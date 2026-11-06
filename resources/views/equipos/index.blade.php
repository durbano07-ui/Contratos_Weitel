@extends('layouts.app')

@section('header_title', 'Inventario de Equipos')
@section('header_subtitle', 'Control de materiales y equipos técnicos para instalaciones')

@section('content')

<!-- Stats ribbon -->
<section class="grid grid-cols-2 gap-1 bg-primary-container p-1 rounded-xl overflow-hidden shadow-xl">
    <div class="bg-primary-container p-6 flex flex-col justify-center border-r border-white/5">
        <span class="font-label text-[10px] uppercase tracking-[0.2em] text-on-primary-container">Total Equipos</span>
        <span class="text-3xl font-headline font-extrabold tracking-tighter mt-1 text-white">{{ $total_equipos }}</span>
    </div>
    <div class="bg-primary-container p-6 flex flex-col justify-center">
        <span class="font-label text-[10px] uppercase tracking-[0.2em] text-on-primary-container">Stock Crítico</span>
        <span class="text-3xl font-headline font-extrabold tracking-tighter mt-1 {{ $stock_bajo > 0 ? 'text-red-300' : 'text-tertiary-fixed-dim' }}">
            {{ $stock_bajo }}
        </span>
        @if($stock_bajo > 0)
            <span class="text-[10px] text-red-300 mt-0.5">⚠ Requiere atención</span>
        @endif
    </div>
</section>

<!-- Header + Filtros + Acción -->
<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div class="pl-4 border-l-4 border-secondary">
        <h3 class="text-sm font-label uppercase tracking-widest text-on-surface-variant">Inventario</h3>
        <h2 class="text-3xl font-headline font-extrabold tracking-tight -mt-1">Equipos Técnicos</h2>
    </div>
    <div class="flex items-center gap-3 flex-wrap">
        <form action="{{ route('equipos.index') }}" method="GET" class="flex items-center gap-2">
            <div class="relative">
                <input type="text" name="search" value="{{ $search ?? '' }}"
                    placeholder="Buscar equipo..."
                    class="bg-surface-container-high border border-outline-variant rounded-lg pl-9 pr-4 py-2 text-sm w-52 focus:outline-none focus:ring-1 focus:ring-primary transition-all">
                <span class="material-symbols-outlined absolute left-2.5 top-2 text-outline" style="font-size:17px">search</span>
            </div>
            <select name="categoria" class="bg-surface-container-high border border-outline-variant rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat }}" {{ ($categoria ?? '') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-surface-container-low text-primary px-4 py-2 rounded-lg text-sm font-semibold hover:bg-surface-container-high transition-colors flex items-center space-x-1">
                <span class="material-symbols-outlined" style="font-size:16px">filter_list</span>
                <span>Filtrar</span>
            </button>
            @if($search || $categoria)
                <a href="{{ route('equipos.index') }}" class="text-sm text-outline hover:text-secondary transition-colors">× Limpiar</a>
            @endif
        </form>
        <a href="{{ route('equipos.create') }}" class="bg-primary text-on-primary px-6 py-2.5 rounded-lg flex items-center space-x-2 hover:bg-secondary transition-all duration-300 text-sm font-semibold shadow-lg shadow-primary/10">
            <span class="material-symbols-outlined" style="font-size:18px">add</span>
            <span>Agregar Equipo</span>
        </a>
    </div>
</div>

<!-- Tabla de equipos -->
<div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0_24px_48px_-12px_rgba(26,28,28,0.08)]">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low">
    <th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant">Equipo</th>
    <th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant">Categoría</th>
    <th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant text-center">Stock</th>
    <th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant text-center">Stock Mínimo</th>
    <th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant">Estado</th>
    <th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant text-right">Acciones</th>
</tr>
</thead>
<tbody class="text-sm font-body">
@forelse($equipos as $equipo)
<tr class="hover:bg-surface transition-colors {{ $loop->even ? 'bg-surface-container-low/30' : '' }} {{ $equipo->stockBajo() ? 'border-l-4 border-red-400' : '' }}">
    <td class="p-5">
        <div>
            <p class="font-semibold text-primary">{{ $equipo->nombre }}</p>
            @if($equipo->descripcion)
                <p class="text-[11px] text-outline truncate max-w-[220px]" title="{{ $equipo->descripcion }}">{{ $equipo->descripcion }}</p>
            @endif
        </div>
    </td>
    <td class="p-5">
        <span class="px-2.5 py-1 bg-surface-container text-on-surface-variant text-[11px] font-semibold rounded-full">{{ $equipo->categoria }}</span>
    </td>
    <td class="p-5 text-center font-bold {{ $equipo->stockBajo() ? 'text-red-600' : 'text-primary' }}">
        {{ $equipo->stock }} <span class="font-normal text-outline text-xs">{{ $equipo->unidad }}</span>
    </td>
    <td class="p-5 text-center text-on-surface-variant">{{ $equipo->stock_minimo }}</td>
    <td class="p-5">
        @if($equipo->stockBajo())
            <span class="px-3 py-1 bg-red-100 text-red-700 text-[10px] font-bold uppercase tracking-wider rounded-full flex items-center w-fit space-x-1">
                <span class="material-symbols-outlined" style="font-size:13px">warning</span>
                <span>Stock Bajo</span>
            </span>
        @else
            <span class="px-3 py-1 bg-green-100 text-green-800 text-[10px] font-bold uppercase tracking-wider rounded-full">OK</span>
        @endif
    </td>
    <td class="p-5 text-right">
        <div class="flex justify-end space-x-1">
            <a href="{{ route('equipos.edit', $equipo->id) }}" class="p-2 hover:text-primary hover:bg-surface-container rounded-lg transition-colors" title="Editar">
                <span class="material-symbols-outlined" style="font-size:18px">edit</span>
            </a>
            <form method="POST" action="{{ route('equipos.destroy', $equipo->id) }}" onsubmit="return confirm('¿Eliminar {{ $equipo->nombre }} del inventario?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-2 hover:text-secondary hover:bg-red-50 rounded-lg transition-colors" title="Eliminar">
                    <span class="material-symbols-outlined" style="font-size:18px">delete</span>
                </button>
            </form>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="p-10 text-center text-on-surface-variant">
        @if($search || $categoria)
            No se encontraron equipos con esos criterios.
            <a href="{{ route('equipos.index') }}" class="text-secondary hover:underline ml-1">Ver todos</a>
        @else
            No hay equipos registrados en el inventario.
        @endif
    </td>
</tr>
@endforelse
</tbody>
</table>
<!-- Paginación -->
<div class="p-5 bg-surface-container-low border-t border-outline-variant/30 w-full overflow-hidden">
    <style>
        nav[role="navigation"] { display: flex; align-items: center; justify-content: space-between; width: 100%; font-family: 'Inter', sans-serif;}
        nav[role="navigation"] > div:first-child { display: none; }
        nav[role="navigation"] > div:last-child { display: flex; align-items: center; justify-content: space-between; width: 100%;}
        nav[role="navigation"] p { font-size: 0.75rem; color: #444748; }
        nav[role="navigation"] span[aria-current="page"] > span { background-color: #0a0a0a !important; color: white !important; font-weight: bold; border: none; }
        nav[role="navigation"] a, nav[role="navigation"] span.relative.inline-flex { padding: 0.5rem 0.75rem; border: 1px solid #c4c7c7; margin: 0 0.2rem; border-radius: 0.25rem; font-size: 0.75rem; color: #1a1c1c; font-weight: bold;}
        nav[role="navigation"] a:hover { background-color: #0a0a0a; color: white; border-color: #0a0a0a;}
        nav[role="navigation"] svg { height: 1rem; width: 1rem; }
    </style>
    {{ $equipos->links() }}
</div>
</div>

@endsection
