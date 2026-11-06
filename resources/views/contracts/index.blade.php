@extends('layouts.app')

@section('header_title', Auth::user()->isAdministrador() ? 'Todos los Contratos' : 'Mis Contratos')
@section('header_subtitle', Auth::user()->isAdministrador() ? 'Vista completa del sistema' : 'Contratos asignados a tu usuario')

@section('content')
<!-- Data Summary Ribbon -->
<section class="grid grid-cols-3 gap-1 bg-primary-container p-1 rounded-xl overflow-hidden shadow-xl">
<div class="bg-primary-container p-6 text-white flex flex-col justify-center border-r border-white/5">
<span class="font-label text-[10px] uppercase tracking-[0.2em] text-on-primary-container">Total Contratos</span>
<span class="text-3xl font-headline font-extrabold tracking-tighter mt-1">{{ number_format($total_contratos) }}</span>
</div>
<div class="bg-primary-container p-6 text-white flex flex-col justify-center border-r border-white/5">
<span class="font-label text-[10px] uppercase tracking-[0.2em] text-on-primary-container">Activos</span>
<span class="text-3xl font-headline font-extrabold tracking-tighter mt-1 text-on-primary">{{ number_format($activos) }}</span>
</div>
<div class="bg-primary-container p-6 text-white flex flex-col justify-center">
<span class="font-label text-[10px] uppercase tracking-[0.2em] text-on-primary-container">Nuevos del Mes</span>
<span class="text-3xl font-headline font-extrabold tracking-tighter mt-1 text-tertiary-fixed-dim">{{ number_format($nuevos_mes) }}</span>
</div>
</section>

<!-- Dynamic Content Header -->
<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div class="asymmetric-header pl-4 border-l-4 border-secondary">
        <h3 class="text-sm font-label uppercase tracking-widest text-on-surface-variant">
            {{ Auth::user()->isAdministrador() ? 'Lista Maestra' : 'Mis Registros' }}
        </h3>
        <h2 class="text-3xl font-headline font-extrabold tracking-tight -mt-1">
            {{ Auth::user()->isAdministrador() ? 'Contratos Vigentes' : 'Contratos Generados' }}
        </h2>
    </div>
    <div class="flex items-center gap-3 flex-wrap">
        <!-- Buscador por cédula / nombre -->
        <form action="{{ route('contracts.index') }}" method="GET" class="flex items-center gap-2">
            <div class="relative">
                <input
                    type="text"
                    name="search"
                    value="{{ $search ?? '' }}"
                    placeholder="Buscar por cédula o nombre..."
                    class="bg-surface-container-high border border-outline-variant rounded-lg pl-9 pr-4 py-2 text-sm w-64 focus:outline-none focus:ring-1 focus:ring-primary transition-all"
                />
                <span class="material-symbols-outlined absolute left-2.5 top-2 text-outline" style="font-size:17px">search</span>
            </div>
            <button type="submit" class="bg-surface-container-low text-primary px-4 py-2 rounded-lg text-sm font-semibold hover:bg-surface-container-high transition-colors flex items-center space-x-1">
                <span class="material-symbols-outlined" style="font-size:16px">filter_list</span>
                <span>Filtrar</span>
            </button>
            @if($search)
                <a href="{{ route('contracts.index') }}" class="text-sm text-outline hover:text-secondary transition-colors">
                    × Limpiar
                </a>
            @endif
        </form>
        <a href="{{ route('contracts.create') }}" class="bg-primary text-on-primary px-6 py-2.5 rounded-lg flex items-center space-x-2 hover:bg-secondary transition-all duration-300 text-sm font-semibold shadow-lg shadow-primary/10">
            <span class="material-symbols-outlined text-lg" data-icon="add">add</span>
            <span>Nuevo Contrato</span>
        </a>
    </div>
</div>

<!-- Contracts Table -->
<div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0_24px_48px_-12px_rgba(26,28,28,0.08)]">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low">
<th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant border-none">ID Contrato</th>
<th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant border-none">Cliente</th>
<th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant border-none">Plan Contratado</th>
@if(Auth::user()->isAdministrador())
<th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant border-none">Operador</th>
@endif
<th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant border-none">Estado</th>
<th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant border-none">Fecha Inicio</th>
<th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant border-none text-right">Acciones</th>
</tr>
</thead>
<tbody class="text-sm font-body">
@forelse($contracts as $contract)
<tr class="hover:bg-surface transition-colors {{ $loop->even ? 'bg-surface-container-low/30' : '' }}">
<td class="p-5 font-bold text-primary">#ISP-{{ \Carbon\Carbon::parse($contract->fecha)->format('Y') }}-{{ str_pad($contract->id_contrato, 3, '0', STR_PAD_LEFT) }}</td>
<td class="p-5">
<div class="flex items-center space-x-3">
<div class="w-8 h-8 bg-surface-container-high rounded-full flex items-center justify-center font-bold text-[10px]">{{ strtoupper(substr($contract->client->nombre ?? 'N', 0, 2)) }}</div>
<div>
    <p class="font-semibold text-sm">{{ $contract->client->nombre ?? 'Desconocido' }} {{ $contract->client->apellido ?? '' }}</p>
    <p class="text-[11px] text-outline">{{ $contract->client->cedula ?? '—' }}</p>
</div>
</div>
</td>
<td class="p-5">{{ $contract->plan->nombre_plan ?? 'Plan no encontrado' }} ({{ $contract->plan->velocidad ?? '' }})</td>
@if(Auth::user()->isAdministrador())
<td class="p-5 text-sm">
    <div class="font-medium text-on-surface">{{ $contract->user->name ?? '—' }}</div>
    @if($contract->tecnico)
        <div class="text-[11px] text-on-surface-variant flex items-center gap-1 mt-0.5" title="Técnico asignado">
            <span class="material-symbols-outlined text-[13px] text-secondary">engineering</span>
            <span>{{ $contract->tecnico->name }}</span>
        </div>
    @else
        <div class="text-[11px] text-outline/60 flex items-center gap-1 mt-0.5 italic" title="Sin técnico asignado">
            <span class="material-symbols-outlined text-[13px]">engineering</span>
            <span>Sin técnico</span>
        </div>
    @endif
</td>
@endif
<td class="p-5">
<span class="px-3 py-1 bg-green-100 text-green-800 text-[10px] font-bold uppercase tracking-wider rounded-full">Activo</span>
</td>
<td class="p-5 opacity-70">{{ \Carbon\Carbon::parse($contract->fecha)->format('d M Y') }}</td>
<td class="p-5 text-right">
<div class="flex justify-end space-x-1">
    <a href="{{ route('contracts.edit', $contract->id_contrato) }}" class="p-2 hover:text-primary hover:bg-surface-container rounded-lg transition-colors" title="Editar contrato">
        <span class="material-symbols-outlined" data-icon="edit">edit</span>
    </a>
    @if(Auth::user()->isAdministrador())
        <form method="POST" action="{{ route('contracts.destroy', $contract->id_contrato) }}" onsubmit="return confirm('¿Eliminar el contrato #ISP-{{ \Carbon\Carbon::parse($contract->fecha)->format('Y') }}-{{ str_pad($contract->id_contrato, 3, '0', STR_PAD_LEFT) }}? Esta acción no se puede deshacer.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="p-2 hover:text-secondary hover:bg-red-50 rounded-lg transition-colors" title="Eliminar contrato">
                <span class="material-symbols-outlined" data-icon="delete">delete</span>
            </button>
        </form>
    @endif
    <a href="{{ route('contracts.anexos.pdf', $contract->id_contrato) }}" target="_blank" class="p-2 hover:text-secondary transition-colors" title="Descargar Anexos de Instalación (2 Páginas)">
        <span class="material-symbols-outlined" data-icon="description">description</span>
    </a>
    <a href="{{ route('contracts.pdf', $contract->id_contrato) }}" target="_blank" class="p-2 hover:text-secondary transition-colors" title="Descargar Contrato Completo (PDF)">
        <span class="material-symbols-outlined" data-icon="download">download</span>
    </a>
</div>
</td>
</tr>
@empty
<tr>
<td colspan="{{ Auth::user()->isAdministrador() ? 7 : 6 }}" class="p-10 text-center text-on-surface-variant">
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
<!-- Table Footer / Pagination -->
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
    {{ $contracts->links() }}
</div>
</div>
@endsection
