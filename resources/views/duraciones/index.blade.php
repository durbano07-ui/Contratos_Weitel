@extends('layouts.app')

@section('header_title', 'Duración de Contratos')
@section('header_subtitle', 'Opciones de meses disponibles al crear un contrato')

@section('content')

<div class="flex justify-between items-end">
    <div class="pl-4 border-l-4 border-secondary">
        <h3 class="text-sm font-label uppercase tracking-widest text-on-surface-variant">Catálogo</h3>
        <h2 class="text-3xl font-headline font-extrabold tracking-tight -mt-1">Duraciones Disponibles</h2>
    </div>
    <form method="POST" action="{{ route('duraciones.store') }}" class="flex items-center gap-2">
        @csrf
        <input type="number" name="meses" min="1" max="120" required placeholder="Meses" value="{{ old('meses') }}"
            class="w-28 px-3 py-2.5 rounded-lg border border-outline-variant bg-surface-container-lowest text-sm">
        <button type="submit" class="bg-primary text-on-primary px-6 py-2.5 rounded-lg flex items-center space-x-2 hover:bg-secondary transition-all duration-300 text-sm font-semibold shadow-lg shadow-primary/10">
            <span class="material-symbols-outlined" style="font-size:18px">add</span>
            <span>Agregar</span>
        </button>
    </form>
</div>

@error('meses')
<p class="text-sm text-secondary font-semibold">{{ $message }}</p>
@enderror

<div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0_24px_48px_-12px_rgba(26,28,28,0.08)]">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-surface-container-low/50">
                <th class="p-4 font-label text-[11px] uppercase tracking-wider text-on-surface-variant">Duración</th>
                <th class="p-4 font-label text-[11px] uppercase tracking-wider text-on-surface-variant">Contratos</th>
                <th class="p-4 font-label text-[11px] uppercase tracking-wider text-on-surface-variant text-right">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-sm font-body">
            @foreach($duraciones as $duracion)
            <tr class="hover:bg-surface transition-colors {{ $loop->even ? 'bg-surface-container-low/30' : '' }}">
                <td class="p-4 font-semibold text-primary">{{ $duracion->meses }} meses</td>
                <td class="p-4">
                    <span class="px-2 py-1 bg-surface-container text-on-surface-variant text-[10px] font-bold rounded-full">
                        {{ $duracion->contracts_count }} contratos
                    </span>
                </td>
                <td class="p-4 text-right">
                    <form method="POST" action="{{ route('duraciones.destroy', $duracion->id) }}" class="inline" onsubmit="return confirm('¿Eliminar la opción de {{ $duracion->meses }} meses? Los contratos existentes no se modifican.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Eliminar">
                            <span class="material-symbols-outlined" style="font-size:18px">delete</span>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
