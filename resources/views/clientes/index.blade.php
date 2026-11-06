@extends('layouts.app')

@section('header_title', Auth::user()->isAdministrador() ? 'Clientes' : 'Mis Clientes')
@section('header_subtitle', Auth::user()->isAdministrador() ? 'Directorio Central de Usuarios y Servicios' : 'Clientes de tus contratos registrados')

@section('content')
<!-- Data Summary Ribbon -->
<section class="bg-primary-container text-white p-8 rounded-xl flex justify-between items-center overflow-hidden relative shadow-xl">
<div class="relative z-10 flex space-x-16">
<div>
<p class="text-[10px] font-label uppercase tracking-[0.2em] text-on-primary-container mb-1">Total Clientes</p>
<p class="text-4xl font-headline font-extrabold tracking-tighter">{{ number_format($total_clientes) }}</p>
</div>
<div>
<p class="text-[10px] font-label uppercase tracking-[0.2em] text-on-primary-container mb-1">Nuevos (Mes)</p>
<p class="text-4xl font-headline font-extrabold tracking-tighter">+{{ number_format($nuevos_mes) }}</p>
</div>
@if(Auth::user()->isAdministrador())
<div>
<p class="text-[10px] font-label uppercase tracking-[0.2em] text-red-300 mb-1">Dados de Baja</p>
<p class="text-4xl font-headline font-extrabold tracking-tighter text-red-300">{{ number_format($clientes_baja) }}</p>
</div>
@endif
</div>
<!-- Abstract architectural background texture -->
<div class="absolute right-0 top-0 w-1/3 h-full opacity-10 pointer-events-none">
<svg class="h-full w-full fill-current" viewbox="0 0 100 100">
<rect height="2" width="80" x="10" y="10"></rect>
<rect height="2" width="80" x="10" y="30"></rect>
<rect height="2" width="80" x="10" y="50"></rect>
<rect height="2" width="80" x="10" y="70"></rect>
<rect height="2" width="80" x="10" y="90"></rect>
</svg>
</div>
</section>

<!-- Table Section (High Density Ledger Style to match Contratos) -->
<div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0_24px_48px_-12px_rgba(26,28,28,0.08)]">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low">
<th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant border-none">Nombre del Cliente</th>
<th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant border-none">Cédula / RUC</th>
<th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant border-none">Plan Contratado</th>
<th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant border-none text-center">Estado</th>
<th class="p-5 font-label text-[11px] uppercase tracking-wider text-on-surface-variant border-none text-right">Contacto</th>
</tr>
</thead>
<tbody class="text-sm font-body">

@forelse($clientes as $client)
<tr class="hover:bg-surface transition-colors cursor-pointer group {{ $loop->even ? 'bg-surface-container-low/30' : '' }}">
<td class="p-5">
<div class="flex items-center space-x-3">
<div class="w-8 h-8 rounded-full {{ ['bg-primary-container text-white', 'bg-outline-variant text-on-surface', 'bg-secondary text-white', 'bg-tertiary-fixed text-on-tertiary-fixed-variant'][$loop->index % 4] }} flex items-center justify-center font-bold text-[10px]">
{{ strtoupper(substr($client->nombre ?? 'N', 0, 2)) }}
</div>
<div>
<p class="font-bold text-sm text-primary tracking-tight">{{ $client->nombre }} {{ $client->apellido ?? '' }}</p>
<p class="text-[11px] text-outline font-body">ID: CL-{{ str_pad($client->id_cliente ?? $client->id ?? 0, 5, '0', STR_PAD_LEFT) }}</p>
</div>
</div>
</td>
<td class="p-5 font-body text-primary">{{ $client->cedula }}</td>
<td class="p-5">{{ optional(optional($client->contracts->first())->plan)->nombre_plan ?? 'Ninguno' }}</td>
<td class="p-5 text-center">
<span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full
    {{ $client->isBaja()
        ? 'bg-red-100 text-red-700'
        : ($client->contracts->count() > 0 ? 'bg-green-100 text-green-800' : 'bg-surface-container-high text-on-surface-variant')
    }}">
    {{ $client->isBaja() ? 'BAJA' : ($client->contracts->count() > 0 ? 'ACTIVO' : 'SIN CONTRATO') }}
</span>
</td>
<td class="p-5 text-right">
<div class="flex items-center justify-end space-x-1">
    <p class="text-sm font-body truncate" title="{{ $client->email }}">{{ \Illuminate\Support\Str::limit($client->email, 22) }}</p>
    @if(Auth::user()->isAdministrador())
    <a href="{{ route('clientes.edit', $client->id_cliente) }}"
       class="ml-3 p-1.5 hover:text-primary hover:bg-surface-container rounded-lg transition-colors" title="Editar cliente">
        <span class="material-symbols-outlined" style="font-size:18px">edit</span>
    </a>
    @if($client->isBaja())
        <form method="POST" action="{{ route('clientes.reactivar', $client->id_cliente) }}" onsubmit="return confirm('¿Reactivar a {{ $client->nombre }}?')">
            @csrf
            <button type="submit" class="p-1.5 hover:text-green-700 hover:bg-green-50 rounded-lg transition-colors" title="Reactivar">
                <span class="material-symbols-outlined" style="font-size:18px">restart_alt</span>
            </button>
        </form>
    @else
        <a href="{{ route('clientes.edit', $client->id_cliente) }}#baja"
           class="p-1.5 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Dar de baja">
            <span class="material-symbols-outlined" style="font-size:18px">block</span>
        </a>
    @endif
    @endif
</div>
</td>
</tr>
@empty
<tr>
<td colspan="5" class="p-10 text-center text-on-surface-variant">No hay clientes registrados en el sistema.</td>
</tr>
@endforelse

</tbody>
</table>

<!-- Pagination/Footer -->
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
    {{ $clientes->links() }}
</div>
</div>
@endsection
