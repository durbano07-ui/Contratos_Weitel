<?php

namespace App\Http\Controllers;

use App\Rules\CedulaRuc;
use App\Models\Contract;
use App\Models\InternetType;
use App\Services\ContractService;
use App\Services\PdfGenerationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    private $contractService;
    private $pdfService;

    public function __construct(ContractService $contractService, PdfGenerationService $pdfService)
    {
        $this->contractService = $contractService;
        $this->pdfService      = $pdfService;
    }

    public function index(Request $request)
    {
        $user   = Auth::user();
        $search = $request->get('search');

        // Base query con relaciones necesarias.
        // Administrativo: solo sus contratos. Administrador: solo los de su base (o todos si es general).
        $query = Contract::with(['client', 'plan', 'user', 'tecnico'])->visibleTo($user);

        // Búsqueda por cédula del cliente (ambos roles)
        if ($search) {
            $query->whereHas('client', function ($q) use ($search) {
                $q->where('cedula', 'like', "%{$search}%")
                  ->orWhere('nombre', 'like', "%{$search}%")
                  ->orWhere('apellido', 'like', "%{$search}%");
            });
        }

        $contracts = $query->orderBy('fecha', 'desc')->paginate(10)->withQueryString();

        // Estadísticas adaptadas al scope del usuario
        $statsQuery = Contract::visibleTo($user);

        $total_contratos = $statsQuery->count();
        $activos         = $total_contratos;
        $nuevos_mes      = (clone $statsQuery)
            ->whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->count();

        return view('contracts.index', compact(
            'total_contratos', 'activos', 'nuevos_mes', 'contracts', 'search'
        ));
    }

    public function create()
    {
        $tiposConexion = InternetType::all();
        $tecnicos      = $this->tecnicosDeBase(Auth::user()->base);
        $equipos       = \App\Models\Equipment::orderBy('categoria')->orderBy('nombre')->get();
        $duraciones    = \App\Models\ContractDuration::orderBy('meses')->get();
        $extensiones   = \App\Models\EmailDomain::orderBy('dominio')->get();
        return view('contracts.create', compact('tiposConexion', 'tecnicos', 'equipos', 'duraciones', 'extensiones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client.nombre'    => 'required',
            'client.cedula'    => ['required', new CedulaRuc()],
            'client.email'     => ['required', 'email', 'max:150', function ($attr, $value, $fail) {
                $dominio = \App\Models\EmailDomain::normalizar(substr(strrchr((string) $value, '@'), 1));
                if (!\App\Models\EmailDomain::where('dominio', $dominio)->exists()) {
                    $fail('La extensión de correo no está habilitada en el sistema.');
                }
            }],
            'contract.id_plan' => 'required|exists:internet_plans,id_plan',
            'contract.duration' => 'nullable|exists:contract_durations,meses',
            'id_tecnico'       => ['nullable', $this->tecnicoValidoRule(Auth::user()->base)],
            'firma_prestador'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('firma_prestador')) {
            $file = $request->file('firma_prestador');
            $ext = strtolower($file->getClientOriginalExtension());
            $filename = 'firma_prestador.' . (in_array($ext, ['jpg', 'jpeg']) ? $ext : 'png');
            $file->storeAs('public', $filename);

            $publicImgDir = public_path('img');
            if (!file_exists($publicImgDir)) {
                @mkdir($publicImgDir, 0777, true);
            }
            @copy($file->getRealPath(), $publicImgDir . '/' . $filename);
        }

        // Usar el usuario autenticado real (no User::first())
        $contract = $this->contractService->createContract(
            $request->all(),
            Auth::id(),
            $request->input('id_tecnico') // opcional / nullable
        );

        // Generar y guardar el PDF
        $pdfPath = $this->pdfService->generateAndSave($contract);
        $this->contractService->savePdfPath($contract, $pdfPath);

        return response()->json([
            'success'     => true,
            'message'     => 'Contrato generado y guardado exitosamente.',
            'contract_id' => $contract->id_contrato,
        ]);
    }

    public function downloadPdf($id)
    {
        $contract = Contract::findOrFail($id);
        $this->authorizeOwnership($contract);

        return $this->pdfService->streamPdf($contract);
    }

    public function downloadAnexosPdf($id)
    {
        $contract = Contract::findOrFail($id);
        $this->authorizeOwnership($contract);

        return $this->pdfService->streamAnexosPdf($contract);
    }

    // -------------------------------------------------------
    // Edición: Administrador (todos) y Administrativo (solo los suyos)
    // -------------------------------------------------------

    public function edit($id)
    {
        $contract      = Contract::with(['client', 'plan', 'user', 'tecnico'])->findOrFail($id);
        $this->authorizeOwnership($contract);

        $tiposConexion = \App\Models\InternetType::with('plans')->get();
        $tecnicos      = $this->tecnicosDeBase($contract->base, $contract->id_tecnico);
        $duraciones    = $this->duracionesPermitidas($contract);

        return view('contracts.edit', compact('contract', 'tiposConexion', 'tecnicos', 'duraciones'));
    }

    /**
     * Duraciones del catálogo más la actual del contrato (por si fue eliminada del catálogo).
     */
    private function duracionesPermitidas(Contract $contract)
    {
        return \App\Models\ContractDuration::pluck('meses')
            ->push((int) ($contract->duracion ?: 24))
            ->unique()
            ->sort()
            ->values();
    }

    public function update(Request $request, $id)
    {
        $contract = Contract::with(['plan', 'tecnico', 'client', 'anexo2'])->findOrFail($id);
        $this->authorizeOwnership($contract);

        $data = $request->validate([
            'id_plan'          => 'required|exists:internet_plans,id_plan',
            'fecha'            => 'required|date',
            'duracion'         => ['required', \Illuminate\Validation\Rule::in($this->duracionesPermitidas($contract)->all())],
            'id_tecnico'       => ['nullable', $this->tecnicoValidoRule($contract->base, $contract->id_tecnico)],
            'cliente_nombre'   => 'required|string|max:255',
        ]);

        $data['id_tecnico'] = !empty($data['id_tecnico']) ? $data['id_tecnico'] : null;

        $planAnterior    = $contract->plan->nombre_plan ?? '—';
        $tecnicoAnterior = $contract->tecnico->name ?? 'Sin asignar';
        $clienteAnterior = trim(($contract->client->nombre ?? '') . ' ' . ($contract->client->apellido ?? ''));
        $duracionAnterior = $contract->duracion ?? '24';

        // Actualizar datos del contrato
        $contract->update([
            'id_plan'    => $data['id_plan'],
            'fecha'      => $data['fecha'],
            'id_tecnico' => $data['id_tecnico'],
            'duracion'   => (string) $data['duracion'],
        ]);

        // Mantener sincronizada la cantidad de meses del Anexo 2
        if ($contract->anexo2) {
            $contract->anexo2->update(['cantidad_meses' => (int) $data['duracion']]);
        }

        // Actualizar nombre del cliente
        if ($contract->client) {
            $contract->client->update([
                'nombre'   => trim($data['cliente_nombre']),
                'apellido' => '',
            ]);
            $contract->load('client');
        }

        $contract->load('tecnico');

        $tecnicoNuevo = $contract->tecnico->name ?? 'Sin asignar';
        $clienteNuevo = trim(($contract->client->nombre ?? '') . ' ' . ($contract->client->apellido ?? ''));

        // Regenerar el PDF físico si ya existía uno guardado
        if ($contract->pdf_ruta && \Illuminate\Support\Facades\Storage::exists($contract->pdf_ruta)) {
            \Illuminate\Support\Facades\Storage::delete($contract->pdf_ruta);
            $nuevaRuta = $this->pdfService->generateAndSave($contract);
            $contract->update(['pdf_ruta' => $nuevaRuta]);
        }

        $detallesAudit = "Contrato #ISP-{$contract->id_contrato}: plan anterior '{$planAnterior}', fecha {$data['fecha']}, técnico: {$tecnicoAnterior} → {$tecnicoNuevo}";
        if ($clienteAnterior !== $clienteNuevo) {
            $detallesAudit .= ", cliente: '{$clienteAnterior}' → '{$clienteNuevo}'";
        }
        if ((string) $duracionAnterior !== (string) $data['duracion']) {
            $detallesAudit .= ", duración: {$duracionAnterior} → {$data['duracion']} meses";
        }

        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action'  => 'Contrato Modificado',
            'module'  => 'Contratos',
            'details' => $detallesAudit,
        ]);

        return redirect()->route('contracts.index')->with('success', 'Contrato actualizado correctamente.');
    }

    /**
     * El Administrativo solo puede gestionar los contratos que él generó,
     * y el Administrador solo los de su base (salvo que sea general).
     */
    private function authorizeOwnership(Contract $contract): void
    {
        if (!Auth::user()->canAccessContract($contract)) {
            abort(403, 'No tienes acceso a este contrato.');
        }
    }

    /**
     * Técnicos de una base (todos si la base es null). Incluye al técnico
     * ya asignado aunque sea de otra base, para no perderlo al editar.
     */
    private function tecnicosDeBase(?string $base, $incluirId = null)
    {
        return \App\Models\User::where('role', 'tecnico')
            ->when($base, function ($q) use ($base, $incluirId) {
                $q->where(function ($q) use ($base, $incluirId) {
                    $q->where('base', $base);
                    if ($incluirId) {
                        $q->orWhere('id', $incluirId);
                    }
                });
            })
            ->orderBy('name')
            ->get();
    }

    private function tecnicoValidoRule(?string $base, $incluirId = null)
    {
        return \Illuminate\Validation\Rule::in($this->tecnicosDeBase($base, $incluirId)->pluck('id')->all());
    }

    // -------------------------------------------------------
    // Métodos exclusivos del Administrador
    // -------------------------------------------------------

    public function destroy($id)
    {
        $contract = Contract::with(['client'])->findOrFail($id);
        $this->authorizeOwnership($contract);

        $clienteNombre = $contract->client->nombre ?? 'Desconocido';

        // Eliminar el PDF físico si existe
        if ($contract->pdf_ruta && \Illuminate\Support\Facades\Storage::exists($contract->pdf_ruta)) {
            \Illuminate\Support\Facades\Storage::delete($contract->pdf_ruta);
        }

        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action'  => 'Contrato Eliminado',
            'module'  => 'Contratos',
            'details' => "Contrato #ISP-{$contract->id_contrato} del cliente '{$clienteNombre}' eliminado por el administrador",
        ]);

        $contract->delete();

        return redirect()->route('contracts.index')->with('success', 'Contrato eliminado del sistema.');
    }
}
