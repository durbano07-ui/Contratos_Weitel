<?php

namespace App\Http\Controllers;

use App\Models\ContractDuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DurationController extends Controller
{
    // -------------------------------------------------------
    // Duraciones de contrato disponibles (solo Administrador)
    // -------------------------------------------------------
    public function index()
    {
        $duraciones = ContractDuration::withCount('contracts')->orderBy('meses')->get();
        return view('duraciones.index', compact('duraciones'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'meses' => 'required|integer|min:1|max:120|unique:contract_durations,meses',
        ], [
            'meses.unique' => 'Esa duración ya existe.',
        ]);

        ContractDuration::create($data);

        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action'  => 'Duración Creada',
            'module'  => 'Duraciones de Contrato',
            'details' => "Duración de {$data['meses']} meses agregada",
        ]);

        return redirect()->route('duraciones.index')->with('success', 'Duración agregada.');
    }

    public function destroy($id)
    {
        $duracion = ContractDuration::findOrFail($id);

        if (ContractDuration::count() <= 1) {
            return redirect()->route('duraciones.index')
                ->with('error', 'Debe existir al menos una duración de contrato.');
        }

        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action'  => 'Duración Eliminada',
            'module'  => 'Duraciones de Contrato',
            'details' => "Duración de {$duracion->meses} meses eliminada",
        ]);

        $duracion->delete();

        return redirect()->route('duraciones.index')->with('success', 'Duración eliminada.');
    }
}
