@extends('layouts.app')

@section('header_title', Auth::user()->isAdministrador() ? 'Todos los contratos' : 'Mis contratos')
@section('header_subtitle', Auth::user()->isAdministrador() ? 'Vista completa del sistema' : 'Contratos asignados a tu usuario')

@section('content')
@php
    $esAdmin = Auth::user()->isAdministrador();
    $codigo = fn($c) => '#ISP-' . \Carbon\Carbon::parse($c->fecha)->format('Y') . '-' . str_pad($c->id_contrato, 3, '0', STR_PAD_LEFT);
@endphp

<!-- Indicadores (tiles Carbon) -->
<section class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="cds-tile">
        <p class="cds-label-01">Total de contratos</p>
        <p class="mt-2 text-[2rem] leading-10 font-light text-primary">{{ number_format($total_contratos) }}</p>
    </div>
    <div class="cds-tile">
        <p class="cds-label-01">Activos</p>
        <p class="mt-2 text-[2rem] leading-10 font-light text-primary">{{ number_format($activos) }}</p>
    </div>
    <div class="cds-tile">
        <p class="cds-label-01">Nuevos del mes</p>
        <p class="mt-2 text-[2rem] leading-10 font-light text-primary">{{ number_format($nuevos_mes) }}</p>
    </div>
</section>

<div>
    <div class="cds-card">
        <!-- Barra de herramientas: título, búsqueda y acción principal -->
        <div class="cds-table-toolbar flex-wrap">
            <div>
                    <h2 class="cds-section-title">{{ $esAdmin ? 'Contratos vigentes' : 'Contratos generados' }}</h2>
                    <p class="cds-label-01 mt-1">{{ $esAdmin ? 'Lista maestra' : 'Mis registros' }}</p>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <form action="{{ route('contracts.index') }}" method="GET" class="flex items-center" role="search">
                    <div class="cds-search">
                        <span class="material-symbols-outlined">search</span>
                        <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Buscar por cédula o nombre" aria-label="Buscar por cédula o nombre">
                    </div>
                    @if($search)
                        <a href="{{ route('contracts.index') }}" class="cds-btn cds-btn--ghost cds-btn--icon" title="Limpiar búsqueda" aria-label="Limpiar búsqueda">
                            <span class="material-symbols-outlined">close</span>
                        </a>
                    @endif
                </form>
                <a href="{{ route('contracts.create') }}" class="cds-btn cds-btn--primary">
                    <span>Nuevo contrato</span>
                    <span class="material-symbols-outlined">add</span>
                </a>
            </div>
        </div>

        <!-- Tabla de contratos -->
        <div class="overflow-x-auto">
        <table class="cds-table">
            <thead>
                <tr>
                    <th>ID contrato</th>
                    <th>Cliente</th>
                    <th>Plan contratado</th>
                    @if($esAdmin)<th>Operador</th>@endif
                    <th>Técnico asignado</th>
                    <th>Estado</th>
                    <th>Fecha inicio</th>
                    <th class="text-right"><span class="sr-only">Acciones</span></th>
                </tr>
            </thead>
            <tbody>
            @forelse($contracts as $contract)
                <tr>
                    <td class="cds-cell-strong font-mono whitespace-nowrap">{{ $codigo($contract) }}</td>
                    <td>
                        <p class="cds-cell-strong">{{ $contract->client->nombre ?? 'Desconocido' }} {{ $contract->client->apellido ?? '' }}</p>
                        <p class="text-xs font-mono">{{ $contract->client->cedula ?? '—' }}</p>
                    </td>
                    <td>{{ $contract->plan->nombre_plan ?? 'Plan no encontrado' }} ({{ $contract->plan->velocidad ?? '' }})</td>
                    @if($esAdmin)
                    <td>{{ $contract->user->name ?? '—' }}</td>
                    @endif
                    <td>
                        @if($contract->tecnico)
                            {{ $contract->tecnico->name }}
                        @else
                            <span class="italic text-[#a8a8a8]">Sin técnico</span>
                        @endif
                    </td>
                    <td><span class="cds-tag cds-tag--green">Activo</span></td>
                    <td class="whitespace-nowrap">{{ \Carbon\Carbon::parse($contract->fecha)->format('d/m/Y') }}</td>
                    <td class="text-right">
                        <div class="flex justify-end">
                            <a href="{{ route('contracts.edit', $contract->id_contrato) }}" class="cds-btn cds-btn--ghost cds-btn--icon" title="Editar contrato" aria-label="Editar contrato {{ $codigo($contract) }}">
                                <span class="material-symbols-outlined">edit</span>
                            </a>
                            <a href="{{ route('contracts.anexos.pdf', $contract->id_contrato) }}" target="_blank" class="cds-btn cds-btn--ghost cds-btn--icon" title="Descargar anexos de instalación (2 páginas)" aria-label="Descargar anexos">
                                <span class="material-symbols-outlined">description</span>
                            </a>
                            <a href="{{ route('contracts.pdf', $contract->id_contrato) }}" target="_blank" class="cds-btn cds-btn--ghost cds-btn--icon" title="Descargar contrato completo (PDF)" aria-label="Descargar contrato PDF">
                                <span class="material-symbols-outlined">download</span>
                            </a>
                            @if($esAdmin)
                                <form method="POST" action="{{ route('contracts.destroy', $contract->id_contrato) }}" onsubmit="return confirm('¿Eliminar el contrato {{ $codigo($contract) }}? Esta acción no se puede deshacer.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cds-btn cds-btn--danger-ghost cds-btn--icon" title="Eliminar contrato" aria-label="Eliminar contrato {{ $codigo($contract) }}">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $esAdmin ? 8 : 7 }}" class="!py-10 text-center">
                        @if($search)
                            No se encontraron contratos para "{{ $search }}".
                            <a href="{{ route('contracts.index') }}" class="text-secondary hover:underline ml-1">Ver todos</a>
                        @else
                            No hay contratos registrados en el sistema.
                        @endif
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        </div>
        <div class="cds-pagination">{{ $contracts->links() }}</div>
    </div>
</div>
@endsection
