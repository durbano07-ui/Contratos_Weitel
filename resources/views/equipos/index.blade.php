@extends('layouts.app')

@section('header_title', 'Inventario de equipos')
@section('header_subtitle', 'Control de materiales y equipos técnicos para instalaciones')

@section('content')

<!-- Indicadores (tiles Carbon) -->
<section class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div class="cds-tile">
        <p class="cds-label-01">Total de equipos</p>
        <p class="mt-2 text-[2rem] leading-10 font-light text-primary">{{ $total_equipos }}</p>
    </div>
    <div class="cds-tile">
        <p class="cds-label-01">Stock crítico</p>
        <p class="mt-2 text-[2rem] leading-10 font-light {{ $stock_bajo > 0 ? 'text-error' : 'text-primary' }}">{{ $stock_bajo }}</p>
        @if($stock_bajo > 0)
            <p class="mt-1 text-xs text-error flex items-center gap-1"><span class="material-symbols-outlined" style="font-size:16px">warning</span> Requiere atención</p>
        @endif
    </div>
</section>

<div class="cds-card">
    <div class="cds-table-toolbar flex-wrap">
        <div>
            <h2 class="cds-section-title">Equipos técnicos</h2>
            <p class="cds-label-01 mt-1">{{ $equipos->total() }} equipo(s){{ ($search || $categoria) ? ' con los filtros aplicados' : '' }}</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <form action="{{ route('equipos.index') }}" method="GET" class="flex items-center gap-2 flex-wrap" role="search">
                <div class="cds-search">
                    <span class="material-symbols-outlined">search</span>
                    <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Buscar equipo" aria-label="Buscar equipo" class="!w-52">
                </div>
                <select name="categoria" class="cds-select" aria-label="Categoría" onchange="this.form.submit()">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat }}" {{ ($categoria ?? '') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                @if($search || $categoria)
                    <a href="{{ route('equipos.index') }}" class="cds-btn cds-btn--ghost cds-btn--icon" title="Limpiar filtros" aria-label="Limpiar filtros">
                        <span class="material-symbols-outlined">close</span>
                    </a>
                @endif
            </form>
            <a href="{{ route('equipos.create') }}" class="cds-btn cds-btn--primary">
                <span>Agregar equipo</span>
                <span class="material-symbols-outlined">add</span>
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
    <table class="cds-table">
        <thead>
            <tr>
                <th>Equipo</th>
                <th>Categoría</th>
                <th class="!text-right">Stock</th>
                <th class="!text-right">Stock mínimo</th>
                <th>Estado</th>
                <th class="text-right"><span class="sr-only">Acciones</span></th>
            </tr>
        </thead>
        <tbody>
        @forelse($equipos as $equipo)
            <tr>
                <td>
                    <p class="cds-cell-strong">{{ $equipo->nombre }}</p>
                    @if($equipo->descripcion)
                        <p class="text-xs truncate max-w-[260px]" title="{{ $equipo->descripcion }}">{{ $equipo->descripcion }}</p>
                    @endif
                </td>
                <td><span class="cds-tag cds-tag--gray">{{ $equipo->categoria }}</span></td>
                <td class="text-right font-mono {{ $equipo->stockBajo() ? '!text-error font-semibold' : 'cds-cell-strong' }}">
                    {{ $equipo->stock }} <span class="font-sans text-xs text-on-surface-variant">{{ $equipo->unidad }}</span>
                </td>
                <td class="text-right font-mono">{{ $equipo->stock_minimo }}</td>
                <td>
                    @if($equipo->stockBajo())
                        <span class="cds-tag cds-tag--red">Stock bajo</span>
                    @else
                        <span class="cds-tag cds-tag--green">OK</span>
                    @endif
                </td>
                <td class="text-right">
                    <div class="flex justify-end">
                        <a href="{{ route('equipos.edit', $equipo->id) }}" class="cds-btn cds-btn--ghost cds-btn--icon" title="Editar" aria-label="Editar {{ $equipo->nombre }}">
                            <span class="material-symbols-outlined">edit</span>
                        </a>
                        <form method="POST" action="{{ route('equipos.destroy', $equipo->id) }}" onsubmit="return confirm('¿Eliminar {{ $equipo->nombre }} del inventario?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="cds-btn cds-btn--danger-ghost cds-btn--icon" title="Eliminar" aria-label="Eliminar {{ $equipo->nombre }}">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="!py-10 text-center">
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
    </div>
    <div class="cds-pagination">{{ $equipos->links() }}</div>
</div>

@endsection
