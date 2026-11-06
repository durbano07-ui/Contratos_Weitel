<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Anexo2;
use App\Models\Equipment;
use App\Services\PdfGenerationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TecnicoController extends Controller
{
    protected $pdfService;

    public function __construct(PdfGenerationService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    /**
     * Panel del técnico: lista de contratos asignados.
     */
    public function index()
    {
        $tecnico = Auth::user();

        $pendientes = Contract::with(['client', 'plan'])
            ->where('id_tecnico', $tecnico->id)
            ->where('estado_anexo2', 'pendiente')
            ->orderBy('fecha', 'desc')
            ->get();

        $completados = Contract::with(['client', 'plan', 'anexo2'])
            ->where('id_tecnico', $tecnico->id)
            ->where('estado_anexo2', 'completado')
            ->orderBy('fecha', 'desc')
            ->paginate(10);

        return view('tecnico.index', compact('pendientes', 'completados'));
    }

    /**
     * Formulario del Anexo 2 para un contrato asignado.
     */
    public function editAnexo2($id)
    {
        $tecnico = Auth::user();
        $contract = Contract::with(['client', 'plan', 'anexo2'])
            ->where('id_tecnico', $tecnico->id)
            ->findOrFail($id);

        // Cargar inventario agrupado por categoría para el selector
        $equipmentCatalog = Equipment::where('stock', '>', 0)
            ->orderBy('categoria')
            ->orderBy('nombre')
            ->get()
            ->groupBy('categoria');

        return view('tecnico.anexo2', compact('contract', 'equipmentCatalog'));
    }

    /**
     * Descarga/Visualiza exclusivamente las 2 hojas de los Anexos 2 y 3.
     */
    public function downloadAnexosPdf($id)
    {
        $tecnico = Auth::user();
        $contract = Contract::where('id_tecnico', $tecnico->id)->findOrFail($id);

        return $this->pdfService->streamAnexosPdf($contract);
    }

    /**
     * Guarda los datos del Anexo 2 y marca el contrato como completado.
     */
    public function storeAnexo2(Request $request, $id)
    {
        $tecnico = Auth::user();
        $contract = Contract::with('plan')->where('id_tecnico', $tecnico->id)->findOrFail($id);

        $request->validate([
            'equipos'                      => 'nullable|array',
            'equipos.*.categoria'          => 'nullable|string',
            'equipos.*.marca'              => 'nullable|string|max:100',
            'equipos.*.modelo'             => 'nullable|string|max:100',
            'equipos.*.cantidad'           => 'nullable|integer|min:1',
            'equipos.*.serial'             => 'nullable|string|max:100',
            'equipos.*.estado_equipo'      => 'nullable|string',
            'firma_cliente'                => 'nullable|string',
            'datos_anexo3'                 => 'nullable|array',
        ]);

        // Mapear los datos manuales de los equipos (si se enviaron)
        $equiposData = [];
        if ($request->has('equipos') && is_array($request->equipos)) {
            $equiposData = collect($request->equipos)->filter(function ($item) {
                return !empty($item['marca']) || !empty($item['modelo']) || !empty($item['categoria']) || !empty($item['serial']);
            })->map(function ($item) {
                return [
                    'equipment_id'    => null,
                    'nombre'          => trim(($item['marca'] ?? '') . ' ' . ($item['modelo'] ?? '')),
                    'categoria'       => $item['categoria'] ?? 'Otro',
                    'marca'           => $item['marca'] ?? '',
                    'modelo'          => $item['modelo'] ?? '',
                    'cantidad'        => (int) ($item['cantidad'] ?? 1),
                    'precio_unitario' => (float) ($item['precio_unitario'] ?? 0),
                    'serial'          => $item['serial'] ?? null,
                    'estado_equipo'   => $item['estado_equipo'] ?? 'Nuevo',
                ];
            })->values()->toArray();
        }

        // Si no se llenaron equipos en este formulario, mantener los que ya tenía el contrato
        if (empty($equiposData) && !empty($contract->equipos)) {
            $equiposData = $contract->equipos;
        }

        // Modalidad y Valores automáticos basados en el plan contratado
        $planPrecio = $contract->plan ? (float) $contract->plan->precio : 0.0;
        $duracionMeses = !empty($contract->duracion) ? (int) $contract->duracion : 24;

        $firmaCliente = $request->input('firma_cliente');
        if (empty($firmaCliente) || !str_starts_with($firmaCliente, 'data:image')) {
            $firmaCliente = null;
        }

        // Crear o actualizar el Anexo 2
        Anexo2::updateOrCreate(
            ['id_contrato' => $contract->id_contrato],
            [
                'equipos'                      => $equiposData,
                'compra_credito'               => false,
                'arrendamiento'                => true,
                'compra_contado'               => false,
                'valor_mensual_arrendamiento'  => $planPrecio,
                'valor_mensual_compra_credito' => 0,
                'cantidad_meses'               => $duracionMeses,
                'firma_cliente'                => $firmaCliente,
                'datos_anexo3'                 => $request->datos_anexo3 ?? [],
                'completado_en'                => now(),
            ]
        );

        try {
            // Marcar el contrato como completado
            $contract->update(['estado_anexo2' => 'completado']);

            // REGENERAR EL PDF para incluir los datos del Anexo 2
            $nuevaRuta = $this->pdfService->generateAndSave($contract);
            $contract->update(['pdf_ruta' => $nuevaRuta]);

            \App\Models\AuditLog::create([
                'user_id' => $tecnico->id,
                'action'  => 'Anexo 2 Completado',
                'module'  => 'Técnico / Anexo 2',
                'details' => "Contrato #ISP-{$contract->id_contrato} — Anexo 2 completado por {$tecnico->name}",
            ]);
        } catch (\Exception $e) {
            \Log::error("Error al finalizar instalación: " . $e->getMessage());
            return back()->withErrors(['general' => 'Ocurrió un error al generar el contrato: ' . $e->getMessage()])->withInput();
        }

        return redirect()->route('tecnico.index')
            ->with('success', 'Instalación finalizada y contrato actualizado correctamente.');
    }
}
