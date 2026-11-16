<?php

namespace App\Http\Controllers;

use App\Rules\CedulaRuc;
use App\Services\ClientService;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    private $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        // Clientes visibles según rol/base
        $base = Client::query();
        if (!$user->isAdminGeneral()) {
            // Administrativo: clientes de sus propios contratos. Administrador de base: clientes de su base.
            $clienteIds = \App\Models\Contract::visibleTo($user)->pluck('id_cliente');
            $base->whereIn('id_cliente', $clienteIds);
        }

        // Estadísticas generales (no dependen de la pestaña ni de la búsqueda)
        $total_clientes = (clone $base)->count();
        $clientes_baja  = (clone $base)->where('estado', 'baja')->count();
        $nuevos_mes     = (clone $base)->whereMonth('created_at', now()->month)
                                       ->whereYear('created_at', now()->year)
                                       ->count();

        // Pestañas por tipo de conexión (Fibra Óptica / Radio Enlace)
        $tipos = \App\Models\InternetType::orderBy('id_tipo')->get();
        foreach ($tipos as $t) {
            $t->clientes_count = (clone $base)
                ->whereHas('contracts.plan', fn ($q) => $q->where('id_tipo', $t->id_tipo))
                ->count();
        }
        $sin_contrato_count = (clone $base)->doesntHave('contracts')->count();

        $tipoParam = $request->query('tipo');
        if ($tipoParam === 'sin') {
            $tipoActivo = 'sin';
        } else {
            $tipoActivo = optional($tipos->firstWhere('id_tipo', (int) $tipoParam))->id_tipo
                ?? optional($tipos->first(fn ($t) => $t->clientes_count > 0))->id_tipo
                ?? optional($tipos->first())->id_tipo;
        }

        // Búsqueda por nombre, apellido, cédula/RUC o email
        $busqueda = trim((string) $request->query('q', ''));

        $query = (clone $base);
        if ($tipoActivo === 'sin') {
            $query->doesntHave('contracts');
        } elseif ($tipoActivo) {
            $query->whereHas('contracts.plan', fn ($q) => $q->where('id_tipo', $tipoActivo));
        }
        if ($busqueda !== '') {
            $like = '%' . str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $busqueda) . '%';
            $query->where(function ($q) use ($like) {
                $q->where('nombre', 'like', $like)
                  ->orWhere('apellido', 'like', $like)
                  ->orWhere('cedula', 'like', $like)
                  ->orWhere('email', 'like', $like)
                  ->orWhereRaw("CONCAT(nombre, ' ', COALESCE(apellido, '')) LIKE ?", [$like]);
            });
        }

        $clientes = $query->with(['contracts.plan'])
                          ->orderBy('estado')
                          ->orderBy('created_at', 'desc')
                          ->paginate(10)
                          ->withQueryString();

        return view('clientes.index', compact(
            'total_clientes',
            'nuevos_mes',
            'clientes_baja',
            'clientes',
            'tipos',
            'tipoActivo',
            'sin_contrato_count',
            'busqueda',
        ));
    }

    // -------------------------------------------------------
    // CRUD (solo Administrador)
    // -------------------------------------------------------

    public function edit($id)
    {
        $cliente = Client::findOrFail($id);
        $this->authorizeBase($cliente);
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $cliente = Client::findOrFail($id);
        $this->authorizeBase($cliente);

        $data = $request->validate([
            'nombre'     => 'required|string|max:100',
            'apellido'   => 'nullable|string|max:100',
            'cedula'     => ['required', 'string', new CedulaRuc(), 'unique:clients,cedula,' . $id . ',id_cliente'],
            'email'      => 'nullable|email|max:150',
            'direccion'  => 'nullable|string|max:255',
            'ciudad'     => 'nullable|string|max:100',
            'canton'     => 'nullable|string|max:100',
            'parroquia'  => 'nullable|string|max:100',
            'provincia'  => 'nullable|string|max:100',
            'n_telefono' => 'nullable|string|max:20',
        ]);

        // La columna "apellido" no admite NULL y la mayoría de clientes guarda el nombre completo en "nombre":
        // un apellido vacío llega como null (ConvertEmptyStringsToNull) y debe guardarse como cadena vacía.
        $data['apellido'] = $data['apellido'] ?? '';

        $cliente->update($data);

        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action'  => 'Cliente Actualizado',
            'module'  => 'Clientes',
            'details' => "Cliente '{$cliente->nombre} {$cliente->apellido}' (cédula: {$cliente->cedula}) modificado",
        ]);

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function darDeBaja(Request $request, $id)
    {
        $cliente = Client::findOrFail($id);
        $this->authorizeBase($cliente);

        if ($cliente->isBaja()) {
            return redirect()->route('clientes.index')
                ->with('error', "El cliente '{$cliente->nombre}' ya está dado de baja.");
        }

        $request->validate([
            'motivo_baja' => 'required|string|min:10|max:500',
        ]);

        $cliente->update([
            'estado'      => 'baja',
            'fecha_baja'  => now(),
            'motivo_baja' => $request->motivo_baja,
        ]);

        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action'  => 'Cliente Dado de Baja',
            'module'  => 'Clientes',
            'details' => "Cliente '{$cliente->nombre} {$cliente->apellido}' (cédula: {$cliente->cedula}) dado de baja. Motivo: {$request->motivo_baja}",
        ]);

        return redirect()->route('clientes.index')->with('success', "Cliente '{$cliente->nombre}' dado de baja correctamente.");
    }

    public function reactivar($id)
    {
        $cliente = Client::findOrFail($id);
        $this->authorizeBase($cliente);

        $cliente->update([
            'estado'      => 'activo',
            'fecha_baja'  => null,
            'motivo_baja' => null,
        ]);

        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action'  => 'Cliente Reactivado',
            'module'  => 'Clientes',
            'details' => "Cliente '{$cliente->nombre} {$cliente->apellido}' reactivado en el sistema",
        ]);

        return redirect()->route('clientes.index')->with('success', "Cliente '{$cliente->nombre}' reactivado correctamente.");
    }

    /**
     * El Administrador de una base solo gestiona clientes con contratos en su base.
     */
    private function authorizeBase(Client $cliente): void
    {
        $user = Auth::user();

        if (!$user->isAdminGeneral()
            && !\App\Models\Contract::visibleTo($user)->where('id_cliente', $cliente->id_cliente)->exists()) {
            abort(403, 'No tienes acceso a este cliente.');
        }
    }

    // -------------------------------------------------------
    // API (búsqueda de clientes para formularios)
    // -------------------------------------------------------

    public function search(Request $request)
    {
        $query = $request->get('q');
        if (!$query) {
            return response()->json([]);
        }
        $clients = $this->clientService->searchClient($query);
        return response()->json($clients);
    }
}

