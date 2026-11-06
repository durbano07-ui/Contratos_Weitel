@extends('layouts.app')

@section('header_title', 'Gestión de Personal')
@section('header_subtitle', 'Administración de usuarios y roles del sistema')

@section('content')

<!-- Header + Acción -->
<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between mb-6">
    <div class="pl-4 border-l-4 border-secondary">
        <h3 class="text-sm font-label uppercase tracking-widest text-on-surface-variant">Personal</h3>
        <h2 class="text-3xl font-headline font-extrabold tracking-tight -mt-1">Usuarios del Sistema</h2>
    </div>
    <div class="flex items-center gap-3 flex-wrap">
        <a href="{{ route('personal.create') }}" class="bg-primary text-on-primary px-6 py-2.5 rounded-lg flex items-center space-x-2 hover:bg-secondary transition-all duration-300 text-sm font-semibold shadow-lg shadow-primary/10">
            <span class="material-symbols-outlined" style="font-size:18px">person_add</span>
            <span>Agregar Personal</span>
        </a>
    </div>
</div>

<!-- Tabla de personal -->
<div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0_24px_48px_-12px_rgba(26,28,28,0.08)]">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low">
    <th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant">ID</th>
    <th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant">Nombre</th>
    <th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant">Cédula</th>
    <th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant text-center">Rol</th>
    <th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant text-center">Base</th>
    <th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant text-right">Acciones</th>
</tr>
</thead>
<tbody class="text-sm font-body">
@forelse($personal as $persona)
<tr class="hover:bg-surface transition-colors {{ $loop->even ? 'bg-surface-container-low/30' : '' }}">
    <td class="p-5 font-semibold text-outline">
        #{{ $persona->id }}
    </td>
    <td class="p-5">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center font-bold text-[10px] text-primary shrink-0">
                {{ strtoupper(substr($persona->name, 0, 2)) }}
            </div>
            <p class="font-bold text-primary">{{ $persona->name }}</p>
        </div>
    </td>
    <td class="p-5 text-on-surface-variant">
        {{ $persona->cedula }}
    </td>
    <td class="p-5 text-center">
        @if($persona->isAdministrador())
            <span class="inline-block px-3 py-1 bg-secondary/10 text-secondary text-[11px] font-bold uppercase tracking-wider rounded-full">Administrador</span>
        @elseif($persona->isTecnico())
            <span class="inline-block px-3 py-1 bg-amber-100 text-amber-800 text-[11px] font-bold uppercase tracking-wider rounded-full">Técnico</span>
        @else
            <span class="inline-block px-3 py-1 bg-surface-container-high text-on-surface-variant text-[11px] font-bold uppercase tracking-wider rounded-full">Administrativo</span>
        @endif
    </td>
    <td class="p-5 text-center text-on-surface-variant">
        {{ $persona->base ?? ($persona->isAdministrador() ? 'Todas' : '—') }}
    </td>
    <td class="p-5 text-right">
        <div class="flex justify-end space-x-1">
            <a href="{{ route('personal.edit', $persona->id) }}" class="p-2 hover:text-primary hover:bg-surface-container rounded-lg transition-colors" title="Editar">
                <span class="material-symbols-outlined" style="font-size:18px">edit</span>
            </a>
            @if($persona->id !== auth()->id())
            <form method="POST" action="{{ route('personal.destroy', $persona->id) }}" onsubmit="return confirm('¿Estás seguro de eliminar a {{ $persona->name }}? Esta acción no se puede deshacer.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-2 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Eliminar">
                    <span class="material-symbols-outlined" style="font-size:18px">delete</span>
                </button>
            </form>
            @else
            <span class="p-2 text-outline-variant cursor-not-allowed" title="No puedes eliminar tu propia cuenta">
                <span class="material-symbols-outlined" style="font-size:18px">delete</span>
            </span>
            @endif
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="p-10 text-center text-on-surface-variant">
        No hay personal registrado en el sistema.
    </td>
</tr>
@endforelse
</tbody>
</table>
</div>

@endsection
