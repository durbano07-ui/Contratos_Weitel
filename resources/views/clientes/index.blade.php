@extends('layouts.app')

@section('header_title', Auth::user()->isAdministrador() ? 'Clientes' : 'Mis clientes')
@section('header_subtitle', Auth::user()->isAdministrador() ? 'Directorio central de usuarios y servicios' : 'Clientes de tus contratos registrados')

@section('content')
@php $esAdmin = Auth::user()->isAdministrador(); @endphp

<!-- Indicadores (tiles Carbon) -->
<section class="grid grid-cols-1 sm:grid-cols-{{ $esAdmin ? 3 : 2 }} gap-4">
    <div class="cds-tile">
        <p class="cds-label-01">Total de clientes</p>
        <p class="mt-2 text-[2rem] leading-10 font-light text-primary">{{ number_format($total_clientes) }}</p>
    </div>
    <div class="cds-tile">
        <p class="cds-label-01">Nuevos del mes</p>
        <p class="mt-2 text-[2rem] leading-10 font-light text-primary">+{{ number_format($nuevos_mes) }}</p>
    </div>
    @if($esAdmin)
    <div class="cds-tile">
        <p class="cds-label-01">Dados de baja</p>
        <p class="mt-2 text-[2rem] leading-10 font-light {{ $clientes_baja > 0 ? 'text-error' : 'text-primary' }}">{{ number_format($clientes_baja) }}</p>
    </div>
    @endif
</section>

<div>
    <!-- Pestañas por tipo de conexión -->
    <div class="cds-tabs" role="tablist" aria-label="Tipo de conexión">
        @foreach($tipos as $tipo)
            @php
                $activa = $tipoActivo == $tipo->id_tipo;
                $nombreTipo = mb_strtoupper($tipo->nombre_tipo);
                $icono = (str_contains($nombreTipo, 'RADIO') || str_contains($nombreTipo, 'INAL')) ? 'settings_input_antenna' : 'cable';
            @endphp
            <a href="{{ route('clientes.index', array_filter(['tipo' => $tipo->id_tipo, 'q' => $busqueda])) }}" role="tab" aria-selected="{{ $activa ? 'true' : 'false' }}"
               class="cds-tab {{ $activa ? 'is-active' : '' }}">
                <span class="material-symbols-outlined" style="font-size:20px">{{ $icono }}</span>
                <span>{{ $tipo->nombre_tipo }}</span>
                <span class="cds-tag cds-tag--gray">{{ $tipo->clientes_count }}</span>
            </a>
        @endforeach
        @if($sin_contrato_count > 0)
            @php $activa = $tipoActivo === 'sin'; @endphp
            <a href="{{ route('clientes.index', array_filter(['tipo' => 'sin', 'q' => $busqueda])) }}" role="tab" aria-selected="{{ $activa ? 'true' : 'false' }}"
               class="cds-tab {{ $activa ? 'is-active' : '' }}">
                <span class="material-symbols-outlined" style="font-size:20px">person_off</span>
                <span>Sin contrato</span>
                <span class="cds-tag cds-tag--gray">{{ $sin_contrato_count }}</span>
            </a>
        @endif
    </div>

    <div role="tabpanel" class="cds-card">
        <!-- Barra de herramientas: título y búsqueda -->
        <div class="cds-table-toolbar flex-wrap">
            <div>
                <h2 class="cds-section-title">Directorio de clientes</h2>
                <p class="cds-label-01 mt-1">
                    @if($busqueda !== '')
                        {{ $clientes->total() }} resultado(s) para “{{ $busqueda }}”
                    @else
                        {{ $clientes->total() }} cliente(s) en esta pestaña
                    @endif
                </p>
            </div>
            <form method="GET" action="{{ route('clientes.index') }}" class="flex items-center" role="search">
                <input type="hidden" name="tipo" value="{{ $tipoActivo }}">
                <div class="cds-search">
                    <span class="material-symbols-outlined">search</span>
                    <input type="search" name="q" value="{{ $busqueda }}" autocomplete="off" placeholder="Buscar por nombre, cédula o email" aria-label="Buscar clientes">
                </div>
                @if($busqueda !== '')
                    <a href="{{ route('clientes.index', ['tipo' => $tipoActivo]) }}" class="cds-btn cds-btn--ghost cds-btn--icon" title="Limpiar búsqueda" aria-label="Limpiar búsqueda">
                        <span class="material-symbols-outlined">close</span>
                    </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
        <table class="cds-table">
            <thead>
                <tr>
                    <th>Nombre del cliente</th>
                    <th>Cédula / RUC</th>
                    <th>Plan contratado</th>
                    <th>Estado</th>
                    <th>Email</th>
                    @if($esAdmin)<th class="text-right"><span class="sr-only">Acciones</span></th>@endif
                </tr>
            </thead>
            <tbody>
            @forelse($clientes as $client)
                @php
                    $contratoTab = is_numeric($tipoActivo)
                        ? $client->contracts->first(fn($c) => optional($c->plan)->id_tipo == $tipoActivo)
                        : null;
                    $contratoTab = $contratoTab ?? $client->contracts->first();
                @endphp
                <tr>
                    <td>
                        <p class="cds-cell-strong">{{ $client->nombre }} {{ $client->apellido ?? '' }}</p>
                        <p class="text-xs font-mono">CL-{{ str_pad($client->id_cliente ?? $client->id ?? 0, 5, '0', STR_PAD_LEFT) }}</p>
                    </td>
                    <td class="font-mono">{{ $client->cedula }}</td>
                    <td>{{ optional(optional($contratoTab)->plan)->nombre_plan ?? 'Ninguno' }}</td>
                    <td>
                        @if($client->isBaja())
                            <span class="cds-tag cds-tag--red">Baja</span>
                        @elseif($client->contracts->count() > 0)
                            <span class="cds-tag cds-tag--green">Activo</span>
                        @else
                            <span class="cds-tag cds-tag--gray">Sin contrato</span>
                        @endif
                    </td>
                    <td class="max-w-[16rem] truncate" title="{{ $client->email }}">{{ $client->email }}</td>
                    @if($esAdmin)
                    <td class="text-right">
                        <div class="flex justify-end">
                            <a href="{{ route('clientes.edit', $client->id_cliente) }}" class="cds-btn cds-btn--ghost cds-btn--icon" title="Editar cliente" aria-label="Editar {{ $client->nombre }}">
                                <span class="material-symbols-outlined">edit</span>
                            </a>
                            @if($client->isBaja())
                                <form method="POST" action="{{ route('clientes.reactivar', $client->id_cliente) }}" onsubmit="return confirm('¿Reactivar a {{ $client->nombre }}?')">
                                    @csrf
                                    <button type="submit" class="cds-btn cds-btn--ghost cds-btn--icon" title="Reactivar" aria-label="Reactivar {{ $client->nombre }}">
                                        <span class="material-symbols-outlined">restart_alt</span>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('clientes.edit', $client->id_cliente) }}#baja" class="cds-btn cds-btn--danger-ghost cds-btn--icon" title="Dar de baja" aria-label="Dar de baja a {{ $client->nombre }}">
                                    <span class="material-symbols-outlined">block</span>
                                </a>
                            @endif
                        </div>
                    </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $esAdmin ? 6 : 5 }}" class="!py-10 text-center">{{ $busqueda !== '' ? 'No se encontraron clientes con esa búsqueda en esta pestaña.' : 'No hay clientes en esta pestaña.' }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        </div>
        <div class="cds-pagination">{{ $clientes->links() }}</div>
    </div>
</div>
@endsection
