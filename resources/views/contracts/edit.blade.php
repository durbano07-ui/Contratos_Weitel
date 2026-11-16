@extends('layouts.app')

@php $codigoContrato = '#ISP-' . \Carbon\Carbon::parse($contract->fecha)->format('Y') . '-' . str_pad($contract->id_contrato, 3, '0', STR_PAD_LEFT); @endphp

@section('header_title', 'Editar contrato')
@section('header_subtitle', 'Modificar datos del contrato ' . $codigoContrato)

@section('content')
<form action="{{ route('contracts.update', $contract->id_contrato) }}" method="POST" class="cds-form max-w-3xl">
    @csrf
    @method('PUT')

    <!-- Datos del cliente -->
    <div class="cds-form-section space-y-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="cds-form-section-title">Datos del cliente</h2>
                <p class="cds-form-section-desc">Contrato <span class="font-mono text-primary">{{ $codigoContrato }}</span></p>
            </div>
        </div>

        <div class="cds-form-item">
            <label class="cds-label" for="cliente_nombre">Nombres completos / razón social</label>
            <input id="cliente_nombre" name="cliente_nombre" type="text" required class="cds-text-input"
                   value="{{ old('cliente_nombre', trim(($contract->client->nombre ?? '') . ' ' . ($contract->client->apellido ?? ''))) }}"
                   @error('cliente_nombre') aria-invalid="true" @enderror>
            <x-cds-field-error name="cliente_nombre" />
        </div>

        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
            <div>
                <dt class="cds-label !mb-1">Cédula / RUC</dt>
                <dd class="font-mono text-primary">{{ $contract->client->cedula ?? '—' }}</dd>
            </div>
            <div>
                <dt class="cds-label !mb-1">Dirección</dt>
                <dd class="text-primary">{{ $contract->client->direccion ?? '—' }}</dd>
            </div>
            <div>
                <dt class="cds-label !mb-1">Operador que creó</dt>
                <dd class="text-primary">{{ $contract->user->name ?? '—' }}</dd>
            </div>
            <div>
                <dt class="cds-label !mb-1">Técnico asignado actualmente</dt>
                <dd class="{{ $contract->tecnico ? 'text-primary' : 'italic text-[#a8a8a8]' }}">{{ $contract->tecnico ? $contract->tecnico->name : 'Ninguno (sin asignar)' }}</dd>
            </div>
        </dl>
    </div>

    <!-- Servicio -->
    <div class="cds-form-section space-y-6">
        <h2 class="cds-form-section-title">Servicio</h2>

        <div class="cds-form-item">
            <label class="cds-label" for="id_tecnico">Técnico asignado (jefe de grupo) <span class="cds-optional">(opcional)</span></label>
            <select id="id_tecnico" name="id_tecnico" class="cds-select--field" @error('id_tecnico') aria-invalid="true" @enderror>
                <option value="">Sin técnico asignado</option>
                @foreach($tecnicos as $tecnico)
                    <option value="{{ $tecnico->id }}" {{ old('id_tecnico', $contract->id_tecnico) == $tecnico->id ? 'selected' : '' }}>
                        {{ $tecnico->name }} (C.I. {{ $tecnico->cedula }})
                    </option>
                @endforeach
            </select>
            <p class="cds-helper">El técnico asignado verá este contrato en su panel para completar el Anexo 2 (instalación y equipos).</p>
            <x-cds-field-error name="id_tecnico" />
        </div>

        <div class="cds-form-item">
            <label class="cds-label" for="id_plan">Plan de internet</label>
            <select id="id_plan" name="id_plan" required class="cds-select--field" @error('id_plan') aria-invalid="true" @enderror>
                @foreach($tiposConexion as $tipo)
                    @if($tipo->plans->isNotEmpty())
                    <optgroup label="{{ $tipo->nombre_tipo }}">
                    @foreach($tipo->plans as $plan)
                        <option value="{{ $plan->id_plan }}" {{ old('id_plan', $contract->id_plan) == $plan->id_plan ? 'selected' : '' }}>
                            {{ $plan->nombre_plan }} ({{ $plan->velocidad }}) · ${{ number_format($plan->precio, 2) }}/mes{{ ($plan->es_promocional || $plan->precio_regular || Str::contains(strtoupper($plan->nombre_plan), 'TERCERA EDAD')) ? ' [Precio promocional - regular $' . number_format($plan->precio_regular ?? 30, 2) . ']' : '' }}
                        </option>
                    @endforeach
                    </optgroup>
                    @endif
                @endforeach
            </select>
            <p class="cds-helper">El tipo de conexión (fibra / radio) se asigna automáticamente según el plan.</p>
            <x-cds-field-error name="id_plan" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="cds-form-item">
                <label class="cds-label" for="fecha">Fecha del contrato</label>
                <input id="fecha" name="fecha" type="date" required class="cds-text-input font-mono"
                       value="{{ old('fecha', \Carbon\Carbon::parse($contract->fecha)->format('Y-m-d')) }}"
                       @error('fecha') aria-invalid="true" @enderror>
                <x-cds-field-error name="fecha" />
            </div>
            <div class="cds-form-item">
                <label class="cds-label" for="duracion">Duración del contrato</label>
                <select id="duracion" name="duracion" required class="cds-select--field" @error('duracion') aria-invalid="true" @enderror>
                    @foreach($duraciones as $meses)
                        <option value="{{ $meses }}" {{ (int) old('duracion', $contract->duracion ?: 24) === (int) $meses ? 'selected' : '' }}>{{ $meses }} meses</option>
                    @endforeach
                </select>
                <x-cds-field-error name="duracion" />
            </div>
        </div>
    </div>

    <div class="cds-form-actions">
        <a href="{{ route('contracts.index') }}" class="cds-btn cds-btn--secondary">Cancelar</a>
        <button type="submit" class="cds-btn cds-btn--primary">
            <span>Guardar cambios</span>
            <span class="material-symbols-outlined">check</span>
        </button>
    </div>
</form>
@endsection
