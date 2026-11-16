@extends('layouts.app')

@section('title', 'Mis Instalaciones | Weitel')
@section('header_title', 'Mis instalaciones')
@section('header_subtitle', 'Gestión de equipos y activación de servicios')

@section('content')
<div class="max-w-4xl space-y-8 pb-16">

    {{-- =============================================
         SECCIÓN: PENDIENTES
    ============================================= --}}
    <section>
        <div class="flex items-center justify-between gap-3 mb-3">
            <h2 class="cds-section-title">Instalaciones pendientes</h2>
            <span class="cds-tag {{ $pendientes->count() > 0 ? 'cds-tag--yellow' : 'cds-tag--green' }}">{{ $pendientes->count() }} por completar</span>
        </div>

        @if($pendientes->isEmpty())
            <div class="cds-tile py-12 text-center">
                <span class="material-symbols-outlined text-5xl text-[#24a148] block mb-2">task_alt</span>
                <p class="text-sm text-on-surface-variant">No tienes instalaciones pendientes de Anexo 2.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($pendientes as $contract)
                <div class="cds-tile relative pl-6 overflow-hidden">
                    <span class="absolute left-0 top-0 bottom-0 w-[3px] bg-[#f1c21b]" aria-hidden="true"></span>

                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <span class="cds-tag cds-tag--yellow mb-2">Pendiente Anexo 2</span>
                            <h3 class="text-xl leading-7 text-primary truncate">{{ $contract->client->nombre }}</h3>
                            <p class="text-xs font-mono text-on-surface-variant">{{ $contract->client->tipo_identificacion }} {{ $contract->client->cedula }}</p>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="cds-label-01">Asignado</p>
                            <p class="text-sm font-mono text-primary">{{ \Carbon\Carbon::parse($contract->fecha)->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    <dl class="mt-4 space-y-2 text-sm">
                        <div class="flex items-start gap-2">
                            <dt><span class="material-symbols-outlined text-on-surface-variant" style="font-size:18px" aria-hidden="true">location_on</span><span class="sr-only">Dirección</span></dt>
                            <dd class="text-on-surface-variant leading-snug">{{ $contract->client->direccion }}</dd>
                        </div>
                        <div class="flex items-center gap-2">
                            <dt><span class="material-symbols-outlined text-on-surface-variant" style="font-size:18px" aria-hidden="true">speed</span><span class="sr-only">Plan</span></dt>
                            <dd class="text-primary font-semibold">{{ $contract->plan->nombre_plan }}</dd>
                        </div>
                    </dl>

                    <div class="mt-5 flex flex-wrap gap-2">
                        <a href="{{ route('tecnico.anexo2', $contract->id_contrato) }}" class="cds-btn cds-btn--primary flex-1 min-w-[12rem]">
                            <span>Llenar Anexo 2</span>
                            <span class="material-symbols-outlined">edit_document</span>
                        </a>
                        <a href="{{ route('tecnico.pdf', $contract->id_contrato) }}" target="_blank" class="cds-btn cds-btn--tertiary" title="Imprimir anexos en blanco (2 páginas)">
                            <span>Anexos</span>
                            <span class="material-symbols-outlined">print</span>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </section>

    {{-- =============================================
         SECCIÓN: HISTORIAL
    ============================================= --}}
    <section class="cds-card">
        <div class="cds-table-toolbar">
            <div>
                <h2 class="cds-section-title">Instalaciones completadas</h2>
                <p class="cds-label-01 mt-1">Historial de anexos llenados</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="cds-table min-w-[500px]">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Plan</th>
                        <th>Fecha</th>
                        <th class="text-right"><span class="sr-only">PDF anexos</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($completados as $contract)
                    <tr>
                        <td>
                            <p class="cds-cell-strong">{{ $contract->client->nombre }}</p>
                            <p class="text-xs font-mono">{{ $contract->client->cedula }}</p>
                        </td>
                        <td><span class="cds-tag cds-tag--gray">{{ $contract->plan->velocidad }}</span></td>
                        <td class="font-mono whitespace-nowrap">{{ $contract->anexo2->completado_en ? $contract->anexo2->completado_en->format('d/m/Y') : '—' }}</td>
                        <td class="text-right">
                            <a href="{{ route('tecnico.pdf', $contract->id_contrato) }}" target="_blank" class="cds-btn cds-btn--ghost cds-btn--sm !text-secondary" title="Imprimir anexos (2 páginas)">
                                <span>Imprimir anexos</span>
                                <span class="material-symbols-outlined">picture_as_pdf</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="!py-10 text-center">Aún no has completado ninguna instalación.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($completados->hasPages())
            <div class="cds-pagination">{{ $completados->links() }}</div>
        @endif
    </section>

</div>
@endsection
