@extends('layouts.app')

@section('header_title', 'Planes de Internet')
@section('header_subtitle', 'Gestión de planes y tarifas del servicio')

@section('content')

<!-- Indicadores (tiles Carbon) -->
<section class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div class="cds-tile">
        <p class="cds-label-01">Total de planes</p>
        <p class="mt-2 text-[2rem] leading-10 font-light text-primary">{{ $total_planes }}</p>
    </div>
    <div class="cds-tile">
        <p class="cds-label-01">Ingresos mensuales (contratos)</p>
        <p class="mt-2 text-[2rem] leading-10 font-light text-primary">${{ number_format($total_ingresos, 2) }}</p>
    </div>
</section>

<!-- Planes en pestañas por tipo de conexión -->
@php
    $tiposConPlanes = $tipos->filter(fn($t) => $t->plans->count() > 0)->values();
    $tipoActivo = $tiposConPlanes->first(fn($t) => $t->id_tipo == request()->query('tipo')) ?? $tiposConPlanes->first();
@endphp

<div>
    @if($tiposConPlanes->count() > 0)
    <div class="cds-tabs" role="tablist" aria-label="Tipo de conexión">
        @foreach($tiposConPlanes as $tipo)
            @php
                $activa = $tipo->id_tipo == $tipoActivo->id_tipo;
                $nombreTipo = mb_strtoupper($tipo->nombre_tipo);
                $icono = (str_contains($nombreTipo, 'RADIO') || str_contains($nombreTipo, 'INAL')) ? 'settings_input_antenna' : 'cable';
            @endphp
            <a href="{{ route('planes.index', ['tipo' => $tipo->id_tipo]) }}" role="tab" aria-selected="{{ $activa ? 'true' : 'false' }}"
               class="cds-tab {{ $activa ? 'is-active' : '' }}">
                <span class="material-symbols-outlined" style="font-size:20px">{{ $icono }}</span>
                <span>{{ $tipo->nombre_tipo }}</span>
                <span class="cds-tag cds-tag--gray">{{ $tipo->plans->count() }}</span>
            </a>
        @endforeach
    </div>
    @endif


@foreach($tiposConPlanes as $tipo)
@if($tipo->id_tipo == $tipoActivo->id_tipo)
<div role="tabpanel" class="cds-card">
    <div class="cds-table-toolbar">
        <div>
            <h2 class="cds-section-title">Planes de {{ $tipo->nombre_tipo }}</h2>
            <p class="cds-label-01 mt-1">{{ $tipo->plans->count() }} plan(es) · ordenados por precio</p>
        </div>
        <a href="{{ route('planes.create') }}" class="cds-btn cds-btn--primary">
            <span>Nuevo plan</span>
            <span class="material-symbols-outlined">add</span>
        </a>
    </div>
    <div class="overflow-x-auto">
    <table class="cds-table">
        <thead>
            <tr>
                <th>Nombre del plan</th>
                <th>Velocidad</th>
                <th>Precio / mes</th>
                <th>Contratos</th>
                <th class="text-right"><span class="sr-only">Acciones</span></th>
            </tr>
        </thead>
        <tbody>
            @foreach($tipo->plans->sortBy('precio') as $plan)
            <tr>
                <td class="cds-cell-strong">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span>{{ $plan->nombre_plan }}</span>
                        @if($plan->es_promocional || Str::contains(strtoupper($plan->nombre_plan), 'TERCERA EDAD'))
                            <span class="cds-tag cds-tag--red">Promocional</span>
                        @endif
                    </div>
                </td>
                <td>{{ $plan->velocidad }}</td>
                <td>
                    <span class="font-mono text-primary">${{ number_format($plan->precio, 2) }}</span>
                    @if($plan->precio_regular && $plan->precio_regular > $plan->precio)
                        <span class="ml-2 text-xs text-on-surface-variant line-through font-mono">${{ number_format($plan->precio_regular, 2) }}</span>
                    @endif
                </td>
                <td>
                    @php $nContratos = $plan->contracts_count ?? $plan->contracts()->count(); @endphp
                    <span class="cds-tag cds-tag--gray">{{ $nContratos }} {{ $nContratos == 1 ? 'activo' : 'activos' }}</span>
                </td>
                <td class="text-right">
                    <div class="flex justify-end">
                        <a href="{{ route('planes.edit', $plan->id_plan) }}" class="cds-btn cds-btn--ghost cds-btn--icon" title="Editar" aria-label="Editar {{ $plan->nombre_plan }}">
                            <span class="material-symbols-outlined">edit</span>
                        </a>
                        <form method="POST" action="{{ route('planes.destroy', $plan->id_plan) }}" onsubmit="return confirm('¿Eliminar el plan \'{{ $plan->nombre_plan }}\'? Esta acción no se puede deshacer.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="cds-btn cds-btn--danger-ghost cds-btn--icon" title="Eliminar" aria-label="Eliminar {{ $plan->nombre_plan }}">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endif
@endforeach
</div>

@if($tipos->sum(fn($t) => $t->plans->count()) === 0)
<div class="cds-tile py-12 text-center">
    <span class="material-symbols-outlined text-5xl text-outline mb-3 block">wifi_off</span>
    <p class="cds-section-title">No hay planes registrados</p>
    <a href="{{ route('planes.create') }}" class="cds-btn cds-btn--primary mt-6">
        <span>Crear el primer plan</span>
        <span class="material-symbols-outlined">add</span>
    </a>
</div>
@endif

@endsection
