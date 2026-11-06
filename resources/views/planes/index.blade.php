@extends('layouts.app')

@section('header_title', 'Planes de Internet')
@section('header_subtitle', 'Gestión de planes y tarifas del servicio')

@section('content')

<!-- Stats ribbon -->
<section class="grid grid-cols-2 gap-1 bg-primary-container p-1 rounded-xl overflow-hidden shadow-xl">
    <div class="bg-primary-container p-6 flex flex-col justify-center border-r border-white/5">
        <span class="font-label text-[10px] uppercase tracking-[0.2em] text-on-primary-container">Total Planes</span>
        <span class="text-3xl font-headline font-extrabold tracking-tighter mt-1 text-white">{{ $total_planes }}</span>
    </div>
    <div class="bg-primary-container p-6 flex flex-col justify-center">
        <span class="font-label text-[10px] uppercase tracking-[0.2em] text-on-primary-container">Ingresos Mensuales (contratos)</span>
        <span class="text-3xl font-headline font-extrabold tracking-tighter mt-1 text-tertiary-fixed-dim">
            ${{ number_format($total_ingresos, 2) }}
        </span>
    </div>
</section>

<!-- Header + Acción -->
<div class="flex justify-between items-end">
    <div class="pl-4 border-l-4 border-secondary">
        <h3 class="text-sm font-label uppercase tracking-widest text-on-surface-variant">Catálogo</h3>
        <h2 class="text-3xl font-headline font-extrabold tracking-tight -mt-1">Planes Disponibles</h2>
    </div>
    <a href="{{ route('planes.create') }}" class="bg-primary text-on-primary px-6 py-2.5 rounded-lg flex items-center space-x-2 hover:bg-secondary transition-all duration-300 text-sm font-semibold shadow-lg shadow-primary/10">
        <span class="material-symbols-outlined" style="font-size:18px">add</span>
        <span>Nuevo Plan</span>
    </a>
</div>

<!-- Planes agrupados por tipo -->
@foreach($tipos as $tipo)
@if($tipo->plans->count() > 0)
<div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0_24px_48px_-12px_rgba(26,28,28,0.08)]">
    <div class="p-5 bg-surface-container-low border-b border-outline-variant/30 flex items-center space-x-2">
        <span class="material-symbols-outlined text-secondary" style="font-size:20px">wifi</span>
        <h4 class="font-headline font-bold text-base">{{ $tipo->nombre_tipo }}</h4>
        <span class="ml-auto text-xs text-outline">{{ $tipo->plans->count() }} plan(es)</span>
    </div>
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-surface-container-low/50">
                <th class="p-4 font-label text-[11px] uppercase tracking-wider text-on-surface-variant">Nombre del Plan</th>
                <th class="p-4 font-label text-[11px] uppercase tracking-wider text-on-surface-variant">Velocidad</th>
                <th class="p-4 font-label text-[11px] uppercase tracking-wider text-on-surface-variant">Precio / Mes</th>
                <th class="p-4 font-label text-[11px] uppercase tracking-wider text-on-surface-variant">Contratos</th>
                <th class="p-4 font-label text-[11px] uppercase tracking-wider text-on-surface-variant text-right">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-sm font-body">
            @foreach($tipo->plans as $plan)
            <tr class="hover:bg-surface transition-colors {{ $loop->even ? 'bg-surface-container-low/30' : '' }}">
                <td class="p-4 font-semibold text-primary">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span>{{ $plan->nombre_plan }}</span>
                        @if($plan->es_promocional || Str::contains(strtoupper($plan->nombre_plan), 'TERCERA EDAD'))
                            <span class="px-2 py-0.5 bg-secondary text-white text-[9px] font-extrabold rounded-full uppercase tracking-wider shadow-sm">
                                Promocional
                            </span>
                        @endif
                    </div>
                </td>
                <td class="p-4">
                    <span class="flex items-center space-x-1">
                        <span class="material-symbols-outlined text-secondary" style="font-size:16px">speed</span>
                        <span>{{ $plan->velocidad }}</span>
                    </span>
                </td>
                <td class="p-4">
                    <div class="font-bold text-primary">${{ number_format($plan->precio, 2) }}</div>
                    @if($plan->precio_regular && $plan->precio_regular > $plan->precio)
                        <div class="text-[11px] text-outline line-through opacity-70">Reg: ${{ number_format($plan->precio_regular, 2) }}</div>
                    @endif
                </td>
                <td class="p-4">
                    <span class="px-2 py-1 bg-surface-container text-on-surface-variant text-[10px] font-bold rounded-full">
                        {{ $plan->contracts_count ?? $plan->contracts()->count() }} activos
                    </span>
                </td>
                <td class="p-4 text-right">
                    <div class="flex justify-end space-x-1">
                        <a href="{{ route('planes.edit', $plan->id_plan) }}" class="p-2 hover:text-primary hover:bg-surface-container rounded-lg transition-colors" title="Editar">
                            <span class="material-symbols-outlined" style="font-size:18px">edit</span>
                        </a>
                        <form method="POST" action="{{ route('planes.destroy', $plan->id_plan) }}" onsubmit="return confirm('¿Eliminar el plan \'{{ $plan->nombre_plan }}\'? Esta acción no se puede deshacer.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 hover:text-secondary hover:bg-red-50 rounded-lg transition-colors" title="Eliminar">
                                <span class="material-symbols-outlined" style="font-size:18px">delete</span>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endforeach

@if($tipos->sum(fn($t) => $t->plans->count()) === 0)
<div class="bg-surface-container-lowest rounded-xl p-12 text-center text-on-surface-variant shadow">
    <span class="material-symbols-outlined text-5xl text-outline mb-3 block">wifi_off</span>
    <p class="font-semibold">No hay planes registrados</p>
    <a href="{{ route('planes.create') }}" class="mt-4 inline-block text-secondary hover:underline text-sm">Crear el primer plan →</a>
</div>
@endif

@endsection
