@extends('layouts.app')

@section('header_title', 'Registro de auditoría')
@section('header_subtitle', 'Traza histórica de acciones y modificaciones del sistema')

@section('content')

<!-- Indicadores (tiles Carbon) -->
<section class="grid grid-cols-2 lg:grid-cols-5 gap-4">
    <div class="cds-tile">
        <p class="cds-label-01">Eventos totales</p>
        <p class="mt-2 text-[2rem] leading-10 font-light text-primary">{{ number_format($eventos_totales) }}</p>
    </div>
    <div class="cds-tile">
        <p class="cds-label-01">Bajas del mes</p>
        <p class="mt-2 text-[2rem] leading-10 font-light text-primary">{{ str_pad($bajas_periodo, 2, '0', STR_PAD_LEFT) }}</p>
    </div>
    <div class="cds-tile">
        <p class="cds-label-01">Usuarios activos</p>
        <p class="mt-2 text-[2rem] leading-10 font-light text-primary">{{ str_pad($usuarios_activos, 2, '0', STR_PAD_LEFT) }}</p>
    </div>
    <div class="cds-tile">
        <p class="cds-label-01">Última actividad</p>
        <p class="mt-2 text-[2rem] leading-10 font-light text-primary">{{ $ultima_actividad_formatted }}</p>
    </div>
    <div class="cds-tile col-span-2 lg:col-span-1">
        <p class="cds-label-01">Ingresos mensuales</p>
        <p class="mt-2 text-[2rem] leading-10 font-light text-[#198038]">${{ $ingresos_mensuales_str }}</p>
    </div>
</section>

<div class="cds-card">
    <div class="cds-table-toolbar flex-wrap">
        <div>
            <h2 class="cds-section-title">Logs del sistema</h2>
            <p class="cds-label-01 mt-1">{{ ucfirst(\Carbon\Carbon::create()->month((int) $month)->translatedFormat('F')) }} {{ $year }}</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <form action="{{ route('auditoria.index') }}" method="GET" class="flex items-center gap-2">
                <select name="month" class="cds-select" aria-label="Mes" onchange="this.form.submit()">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ ucfirst(\Carbon\Carbon::create()->month($m)->translatedFormat('F')) }}</option>
                    @endforeach
                </select>
                <select name="year" class="cds-select" aria-label="Año" onchange="this.form.submit()">
                    @if($years->isEmpty())
                        <option value="{{ now()->year }}">{{ now()->year }}</option>
                    @else
                        @foreach($years as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    @endif
                </select>
                <noscript><button type="submit" class="cds-btn cds-btn--ghost cds-btn--md">Filtrar</button></noscript>
            </form>
            <a href="{{ route('auditoria.export', ['month' => $month, 'year' => $year]) }}" class="cds-btn cds-btn--tertiary">
                <span>Exportar CSV</span>
                <span class="material-symbols-outlined">download</span>
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
    <table class="cds-table">
        <thead>
            <tr>
                <th>Fecha / hora</th>
                <th>Usuario</th>
                <th>Acción</th>
                <th>Módulo</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
        @forelse($logs as $log)
            <tr>
                <td class="whitespace-nowrap">
                    <p class="cds-cell-strong">{{ $log->created_at->format('d/m/Y') }}</p>
                    <p class="text-xs font-mono">{{ $log->created_at->format('H:i:s') }}</p>
                </td>
                <td class="cds-cell-strong">{{ $log->user->name ?? 'Sistema' }}</td>
                <td><span class="cds-tag cds-tag--gray">{{ $log->action }}</span></td>
                <td>{{ $log->module }}</td>
                <td class="max-w-[28rem]"><p class="line-clamp-2" title="{{ $log->details }}">{{ $log->details }}</p></td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="!py-10 text-center">Sin registros de auditoría en este periodo.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    </div>
    <div class="cds-pagination">{{ $logs->links() }}</div>
</div>
@endsection
