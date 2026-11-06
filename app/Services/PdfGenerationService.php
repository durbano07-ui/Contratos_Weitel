<?php

namespace App\Services;

use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PdfGenerationService
{
    /**
     * Genera y guarda el PDF físicamente en Storage.
     */
    public function generateAndSave(Contract $contract)
    {
        $contract->load(['client', 'plan.type', 'user', 'anexo2']);

        $pdf = Pdf::loadView('contracts.pdf', compact('contract'));

        $fileName = 'contrato_' . $contract->id_contrato . '_' . time() . '.pdf';
        $filePath = 'contracts/' . $fileName; // Guards in storage/app/contracts/

        // Guardar físicamente
        Storage::put($filePath, $pdf->output());

        return $filePath;
    }

    /**
     * Retorna el objeto PDF para visualizar o descargar directamente en el navegador.
     */
    public function streamPdf(Contract $contract)
    {
        $contract->load(['client', 'plan.type', 'user', 'anexo2']);
        return Pdf::loadView('contracts.pdf', compact('contract'))
            ->stream('contrato_' . $contract->id_contrato . '.pdf');
    }

    /**
     * Retorna el PDF exclusivo de 2 páginas con Anexo 2 y Anexo 3.
     */
    public function streamAnexosPdf(Contract $contract)
    {
        $contract->load(['client', 'plan.type', 'user', 'anexo2']);
        return Pdf::loadView('contracts.pdf_anexos', compact('contract'))
            ->stream('anexos_instalacion_ISP-' . $contract->id_contrato . '.pdf');
    }
}
