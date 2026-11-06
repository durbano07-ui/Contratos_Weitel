@extends('layouts.app')

@section('header_title', 'Registro de Auditoría')
@section('header_subtitle', 'Traza histórica de acciones y modificaciones del sistema')

@section('content')
<!-- Data Summary Ribbon -->
<div class="bg-primary-container text-on-primary flex items-center p-8 rounded-lg shadow-sm">
<div class="grid grid-cols-5 gap-8 w-full">
<div class="flex flex-col">
<span class="font-label text-[10px] uppercase tracking-[0.15em] text-on-primary-container mb-1">Eventos Totales</span>
<span class="font-headline text-3xl font-bold text-white">{{ number_format($eventos_totales) }}</span>
</div>
<div class="flex flex-col border-l border-white/10 pl-8">
<span class="font-label text-[10px] uppercase tracking-[0.15em] text-on-primary-container mb-1">Usuarios Dados de Baja</span>
<span class="font-headline text-3xl font-bold text-tertiary-fixed-dim">{{ str_pad($bajas_periodo, 2, '0', STR_PAD_LEFT) }}</span>
</div>
<div class="flex flex-col border-l border-white/10 pl-8">
<span class="font-label text-[10px] uppercase tracking-[0.15em] text-on-primary-container mb-1">Usuarios Activos</span>
<span class="font-headline text-3xl font-bold text-white">{{ str_pad($usuarios_activos, 2, '0', STR_PAD_LEFT) }}</span>
</div>
<div class="flex flex-col border-l border-white/10 pl-8">
<span class="font-label text-[10px] uppercase tracking-[0.15em] text-on-primary-container mb-1">Última Actividad</span>
<span class="font-headline text-3xl font-bold text-white">{{ $ultima_actividad_formatted }}</span>
</div>
<div class="flex flex-col border-l border-white/10 pl-8">
<span class="font-label text-[10px] uppercase tracking-[0.15em] text-on-primary-container mb-1 text-green-300">Ingresos Mensuales</span>
<span class="font-headline text-3xl font-bold text-green-400">${{ $ingresos_mensuales_str }}</span>
</div>
</div>
</div>

<!-- Audit Log Table Section (High Density Ledger Style to match Contratos) -->
<div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0_24px_48px_-12px_rgba(26,28,28,0.08)]">
<div class="px-6 py-4 flex justify-between items-center bg-surface-container-low border-b border-outline-variant/10">
<h3 class="font-headline font-bold text-lg text-primary ml-2">Logs del Sistema</h3>
<div class="flex space-x-2">
<form action="{{ route('auditoria.index') }}" method="GET" class="flex space-x-2">
    <select name="month" class="bg-surface-container-low text-primary px-3 py-2 rounded-lg text-sm font-semibold border border-outline-variant/30 focus:outline-none focus:ring-2 focus:ring-primary/20">
        @foreach(range(1, 12) as $m)
            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                {{ Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
            </option>
        @endforeach
    </select>
    <select name="year" class="bg-surface-container-low text-primary px-3 py-2 rounded-lg text-sm font-semibold border border-outline-variant/30 focus:outline-none focus:ring-2 focus:ring-primary/20">
        @if($years->isEmpty())
            <option value="{{ now()->year }}">{{ now()->year }}</option>
        @else
            @foreach($years as $y)
                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endforeach
        @endif
    </select>
    <button type="submit" class="bg-surface-container-low text-primary px-5 py-2.5 rounded-lg flex items-center space-x-2 hover:bg-surface-container-high transition-colors text-sm font-semibold border border-outline-variant/30">
        <span class="material-symbols-outlined text-lg" data-icon="filter_list">filter_list</span>
        <span>Filtrar</span>
    </button>
</form>

<a href="{{ route('auditoria.export', ['month' => $month, 'year' => $year]) }}" class="bg-primary text-on-primary px-5 py-2.5 rounded-lg flex items-center space-x-2 hover:bg-primary-container hover:text-primary transition-colors text-sm font-semibold shadow-lg shadow-primary/10">
    <span class="material-symbols-outlined text-lg" data-icon="download">download</span>
    <span>Exportar CSV</span>
</a>
</div>
</div>

<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low">
<th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant border-none pl-8">Fecha / Hora</th>
<th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant border-none">Usuario</th>
<th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant border-none">Acción Realizada</th>
<th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant border-none">Módulo</th>
<th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant border-none text-right pr-8">Detalles</th>
</tr>
</thead>
<tbody class="text-sm font-body">

@forelse($logs as $log)
<tr class="hover:bg-surface transition-colors cursor-pointer group {{ $loop->even ? 'bg-surface-container-low/30' : '' }}">
<td class="p-5 pl-8 border-l-4 border-transparent hover:border-secondary transition-colors">
<div class="font-bold text-primary">{{ $log->created_at->format('d M y') }}</div>
<div class="text-[11px] opacity-70 font-label tracking-wider">{{ $log->created_at->format('H:i:s') }}</div>
</td>
<td class="p-5">
<div class="flex items-center space-x-3">
<div class="w-8 h-8 rounded-full bg-secondary text-white flex items-center justify-center text-[10px] font-bold">{{ strtoupper(substr($log->user->name ?? 'SYS', 0, 2)) }}</div>
<span class="font-medium text-primary">{{ $log->user->name ?? 'Sistema' }}</span>
</div>
</td>
<td class="p-5">
<span class="px-3 py-1 bg-tertiary-fixed text-on-tertiary-fixed-variant rounded-full text-[10px] font-bold uppercase tracking-wider">{{ $log->action }}</span>
</td>
<td class="p-5 font-medium">{{ $log->module }}</td>
<td class="p-5 text-right pr-8">
<button class="text-primary hover:text-secondary p-2 transition-colors" title="{{ $log->details }}">
<span class="material-symbols-outlined" data-icon="visibility">visibility</span>
</button>
</td>
</tr>
@empty
<tr>
<td colspan="5" class="p-10 text-center font-bold text-outline">Sin registros de auditoría aún.</td>
</tr>
@endforelse

</tbody>
</table>

<!-- Footer / Pagination -->
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
    {{ $logs->links() }}
</div>
</div>
@endsection
