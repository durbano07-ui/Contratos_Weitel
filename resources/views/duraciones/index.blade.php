@extends('layouts.app')

@section('header_title', 'Duración de contratos')
@section('header_subtitle', 'Opciones de meses disponibles al crear un contrato')

@section('content')

<div class="cds-card">
    <div class="cds-table-toolbar flex-wrap">
        <div>
            <h2 class="cds-section-title">Duraciones disponibles</h2>
            <p class="cds-label-01 mt-1">{{ $duraciones->count() }} opción(es)</p>
        </div>
        <form method="POST" action="{{ route('duraciones.store') }}" class="flex items-end gap-2 w-full sm:w-auto">
            @csrf
            <div class="flex-1 min-w-0">
                <label for="meses" class="cds-label-01 block mb-1">Nueva duración (meses)</label>
                <input id="meses" type="number" name="meses" min="1" max="120" required placeholder="Ej: 36" value="{{ old('meses') }}"
                       class="cds-text-input w-full sm:!w-36 !bg-[#f4f4f4] font-mono" @error('meses') aria-invalid="true" @enderror>
            </div>
            <button type="submit" class="cds-btn cds-btn--primary cds-btn--md">
                <span>Agregar</span>
                <span class="material-symbols-outlined">add</span>
            </button>
        </form>
    </div>
    @error('meses')
    <p class="bg-[#fff1f1] border-l-[3px] border-[#da1e28] px-4 py-3 text-sm text-primary" role="alert">{{ $message }}</p>
    @enderror

    <div class="overflow-x-auto">
    <table class="cds-table">
        <thead>
            <tr>
                <th>Duración</th>
                <th>Contratos</th>
                <th class="text-right"><span class="sr-only">Acciones</span></th>
            </tr>
        </thead>
        <tbody>
        @foreach($duraciones as $duracion)
            <tr>
                <td class="cds-cell-strong">{{ $duracion->meses }} meses</td>
                <td><span class="cds-tag cds-tag--gray">{{ $duracion->contracts_count }} contratos</span></td>
                <td class="text-right">
                    <form method="POST" action="{{ route('duraciones.destroy', $duracion->id) }}" class="inline-flex" onsubmit="return confirm('¿Eliminar la opción de {{ $duracion->meses }} meses? Los contratos existentes no se modifican.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="cds-btn cds-btn--danger-ghost cds-btn--icon" title="Eliminar" aria-label="Eliminar {{ $duracion->meses }} meses">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
</div>

@endsection