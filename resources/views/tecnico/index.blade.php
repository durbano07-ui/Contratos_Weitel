@extends('layouts.app')

@section('title', 'Mis Instalaciones | Weitel')
@section('header_title', 'Mis Instalaciones')
@section('header_subtitle', 'Gestión de equipos y activación de servicios')

@push('styles')
<style>
    /* ================================================
       RESPONSIVE CARDS - INSTALACIONES
    ================================================ */
    .install-card {
        background: #fff;
        border: 1px solid #c4c7c7;
        border-radius: 0.5rem;
        overflow: hidden;
        position: relative;
        transition: box-shadow 0.2s;
    }
    .install-card:hover {
        box-shadow: 0 4px 20px rgba(10,10,10,0.1);
    }
    .install-card .accent-bar {
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        background: #f59e0b;
    }
    .install-card .card-inner {
        padding: 1.25rem 1.25rem 1.25rem 1.5rem;
    }

    /* ================================================
       TABLA HISTORIAL - RESPONSIVE
    ================================================ */
    .hist-table-wrap {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .hist-table {
        min-width: 500px;
        width: 100%;
        border-collapse: collapse;
    }

    /* ================================================
       BADGE SPINNER ESTADO
    ================================================ */
    .badge-pendiente {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #fef3c7;
        color: #92400e;
        font-size: 0.6rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 0.2rem 0.6rem;
        border-radius: 99px;
    }
    .badge-done {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #dcfce7;
        color: #14532d;
        font-size: 0.6rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 0.2rem 0.6rem;
        border-radius: 99px;
    }

    /* ================================================
       CTA BUTTON
    ================================================ */
    .btn-cta {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        background: #123656;
        color: #fff;
        padding: 0.7rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.65rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        text-decoration: none;
        transition: background 0.15s, transform 0.1s;
        -webkit-tap-highlight-color: transparent;
    }
    .btn-cta:hover { background: #f15831; }
    .btn-cta:active { transform: scale(0.97); }
    .btn-cta .material-symbols-outlined { font-size: 18px !important; }

    /* ================================================
       EMPTY STATE
    ================================================ */
    .empty-state {
        background: #f3f3f4;
        border: 2px dashed #c4c7c7;
        border-radius: 0.5rem;
        padding: 3rem 1.5rem;
        text-align: center;
    }
    .empty-state .material-symbols-outlined {
        font-size: 3rem !important;
        opacity: 0.2;
        display: block;
        margin-bottom: 0.75rem;
    }
    .empty-state p {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        opacity: 0.4;
    }
</style>
@endpush

@section('content')
<div class="max-w-3xl mx-auto space-y-10 pb-16">

    {{-- =============================================
         SECCIÓN: PENDIENTES
    ============================================= --}}
    <section>
        <div class="flex items-center justify-between mb-5 gap-3">
            <h2 class="text-base font-black tracking-tight uppercase flex items-center gap-2 font-headline">
                <span class="material-symbols-outlined" style="font-size:20px; color:#f59e0b;">pending_actions</span>
                Instalaciones Pendientes
            </h2>
            <span class="badge-pendiente shrink-0">{{ $pendientes->count() }} por completar</span>
        </div>

        @if($pendientes->isEmpty())
            <div class="empty-state">
                <span class="material-symbols-outlined">task_alt</span>
                <p>No tienes instalaciones pendientes de Anexo 2</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($pendientes as $contract)
                <div class="install-card">
                    <div class="accent-bar"></div>
                    <div class="card-inner">

                        {{-- Header de la card --}}
                        <div class="flex items-start justify-between gap-3 mb-4">
                            <div class="min-w-0">
                                <span class="badge-pendiente mb-1.5 inline-flex">Pendiente Anexo 2</span>
                                <h3 class="text-lg font-black tracking-tight text-primary leading-tight truncate font-headline">
                                    {{ $contract->client->nombre }}
                                </h3>
                                <p class="text-[10px] font-bold opacity-50 uppercase tracking-tight">
                                    {{ $contract->client->tipo_identificacion }} {{ $contract->client->cedula }}
                                </p>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="text-[9px] font-bold block opacity-40 uppercase">Asignado</span>
                                <span class="text-xs font-black">{{ \Carbon\Carbon::parse($contract->fecha)->format('d/m/Y') }}</span>
                            </div>
                        </div>

                        {{-- Detalles --}}
                        <div class="space-y-2 mb-5">
                            <div class="flex items-start gap-2 text-sm">
                                <span class="material-symbols-outlined opacity-40 mt-0.5" style="font-size:17px; color:#f15831;">location_on</span>
                                <span class="font-medium text-xs leading-snug">{{ $contract->client->direccion }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined opacity-40" style="font-size:17px; color:#f15831;">speed</span>
                                <span class="font-black text-xs text-secondary">{{ $contract->plan->nombre_plan }}</span>
                            </div>
                        </div>

                        {{-- Acción --}}
                        <div class="flex items-center gap-2">
                            <a href="{{ route('tecnico.anexo2', $contract->id_contrato) }}" class="btn-cta flex-1">
                                <span class="material-symbols-outlined">edit_document</span>
                                Llenar Anexo 2
                            </a>
                            <a href="{{ route('tecnico.pdf', $contract->id_contrato) }}" target="_blank" 
                               class="px-3 py-2.5 bg-white border border-[#c4c7c7] rounded-lg text-secondary hover:bg-surface-container transition-colors flex items-center gap-1 text-xs font-black uppercase tracking-wider" 
                               title="Imprimir Anexos en Blanco (2 Páginas)">
                                <span class="material-symbols-outlined" style="font-size:18px;">print</span>
                                <span>Anexos</span>
                            </a>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </section>

    {{-- =============================================
         SECCIÓN: HISTORIAL
    ============================================= --}}
    <section>
        <div class="flex items-center gap-2 mb-5">
            <span class="material-symbols-outlined" style="font-size:20px; color:#16a34a;">history</span>
            <h2 class="text-base font-black tracking-tight uppercase font-headline">Instalaciones Completadas</h2>
        </div>

        <div class="bg-white border border-outline-variant rounded-xl overflow-hidden shadow-sm">
            <div class="hist-table-wrap">
                <table class="hist-table text-left">
                    <thead class="bg-surface-container-low border-b border-outline-variant">
                        <tr>
                            <th class="px-4 py-3 text-[9px] font-black uppercase tracking-widest opacity-60">Cliente</th>
                            <th class="px-4 py-3 text-[9px] font-black uppercase tracking-widest opacity-60">Plan</th>
                            <th class="px-4 py-3 text-[9px] font-black uppercase tracking-widest opacity-60 text-center">Fecha</th>
                            <th class="px-4 py-3 text-[9px] font-black uppercase tracking-widest opacity-60 text-right">PDF Anexos</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        @forelse($completados as $contract)
                        <tr class="hover:bg-surface-container-lowest transition-colors">
                            <td class="px-4 py-3">
                                <p class="font-bold text-sm tracking-tight leading-tight">{{ $contract->client->nombre }}</p>
                                <p class="text-[10px] opacity-40">{{ $contract->client->cedula }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge-done">{{ $contract->plan->velocidad }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <p class="text-xs font-bold">
                                    {{ $contract->anexo2->completado_en ? $contract->anexo2->completado_en->format('d/m/Y') : '-' }}
                                </p>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('tecnico.pdf', $contract->id_contrato) }}" target="_blank"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-secondary/10 text-secondary hover:bg-secondary/20 transition-colors group font-bold text-xs" 
                                   title="Imprimir Anexos (2 Páginas)">
                                    <span class="material-symbols-outlined text-secondary group-hover:scale-110 transition-transform" style="font-size:18px !important;">picture_as_pdf</span>
                                    <span>Imprimir Anexos (2 Págs)</span>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-10 text-center text-xs font-bold opacity-30 italic">
                                Aún no has completado ninguna instalación.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($completados->hasPages())
            <div class="px-4 py-3 border-t border-outline-variant">
                {{ $completados->links() }}
            </div>
            @endif
        </div>
    </section>

</div>
@endsection
