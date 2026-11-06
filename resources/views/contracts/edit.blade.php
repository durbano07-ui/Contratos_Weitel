@extends('layouts.app')

@section('header_title', 'Editar Contrato')
@section('header_subtitle', 'Modificar datos del contrato #ISP-' . \Carbon\Carbon::parse($contract->fecha)->format('Y') . '-' . str_pad($contract->id_contrato, 3, '0', STR_PAD_LEFT))

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-surface-container-lowest rounded-xl shadow-[0_24px_48px_-12px_rgba(26,28,28,0.08)] overflow-hidden">

        <!-- Header del formulario -->
        <div class="p-6 bg-surface-container-low border-b border-outline-variant/30">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-headline font-bold text-xl">Editar Contrato</h2>
                    <p class="text-sm text-on-surface-variant mt-1">
                        Cliente: <strong>{{ $contract->client->nombre ?? '—' }} {{ $contract->client->apellido ?? '' }}</strong>
                        · Cédula/RUC: <strong>{{ $contract->client->cedula ?? '—' }}</strong>
                    </p>
                </div>
                <span class="font-bold text-lg text-secondary">
                    #ISP-{{ \Carbon\Carbon::parse($contract->fecha)->format('Y') }}-{{ str_pad($contract->id_contrato, 3, '0', STR_PAD_LEFT) }}
                </span>
            </div>
        </div>

        <form action="{{ route('contracts.update', $contract->id_contrato) }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            <!-- Datos del Cliente -->
            <div class="bg-surface-container rounded-lg p-4 space-y-3">
                <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant mb-1">Datos del Cliente</p>

                <div>
                    <label class="block text-xs font-semibold text-on-surface-variant mb-1" for="cliente_nombre">
                        Nombres completos / Razón Social <span class="text-error">*</span>
                    </label>
                    <input id="cliente_nombre" name="cliente_nombre" type="text"
                        value="{{ old('cliente_nombre', trim(($contract->client->nombre ?? '') . ' ' . ($contract->client->apellido ?? ''))) }}"
                        class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all @error('cliente_nombre') border-error @enderror"
                        required>
                    @error('cliente_nombre')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-2 gap-3 text-sm pt-2 border-t border-outline-variant/20">
                    <div>
                        <span class="text-outline text-xs">Cédula / RUC</span>
                        <p class="font-semibold">{{ $contract->client->cedula ?? '—' }}</p>
                    </div>
                    <div>
                        <span class="text-outline text-xs">Dirección</span>
                        <p class="font-semibold">{{ $contract->client->direccion ?? '—' }}</p>
                    </div>
                    <div>
                        <span class="text-outline text-xs">Operador que creó</span>
                        <p class="font-semibold">{{ $contract->user->name ?? '—' }}</p>
                    </div>
                    <div class="col-span-2 pt-1 border-t border-outline-variant/20 flex items-center justify-between">
                        <span class="text-outline text-xs">Técnico Asignado Actualmente:</span>
                        <span class="font-semibold text-xs px-2.5 py-0.5 rounded-full {{ $contract->tecnico ? 'bg-primary/10 text-primary' : 'bg-surface-container-high text-outline' }}">
                            {{ $contract->tecnico ? $contract->tecnico->name : 'Ninguno (Sin asignar)' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Técnico Asignado -->
            <div>
                <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="id_tecnico">
                    Técnico Asignado (Jefe de Grupo)
                </label>
                <select id="id_tecnico" name="id_tecnico"
                    class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all @error('id_tecnico') border-error @enderror">
                    <option value="">-- Sin técnico asignado (Opcional) --</option>
                    @foreach($tecnicos as $tecnico)
                        <option value="{{ $tecnico->id }}" {{ old('id_tecnico', $contract->id_tecnico) == $tecnico->id ? 'selected' : '' }}>
                            {{ $tecnico->name }} (C.I. {{ $tecnico->cedula }})
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-on-surface-variant mt-1">El técnico asignado tendrá acceso a este contrato en su panel para completar el Anexo 2 (Instalación y Equipos).</p>
                @error('id_tecnico')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Plan de internet -->
            <div>
                <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="id_plan">Plan de Internet</label>
                <select id="id_plan" name="id_plan" required
                    class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all @error('id_plan') border-error @enderror">
                    @foreach($tiposConexion as $tipo)
                        @if($tipo->plans->isNotEmpty())
                        <optgroup label="{{ $tipo->nombre_tipo }}">
                        @foreach($tipo->plans as $plan)
                            <option value="{{ $plan->id_plan }}" {{ old('id_plan', $contract->id_plan) == $plan->id_plan ? 'selected' : '' }}>
                                {{ $plan->nombre_plan }} ({{ $plan->velocidad }}) · ${{ number_format($plan->precio, 2) }}/mes{{ ($plan->es_promocional || $plan->precio_regular || Str::contains(strtoupper($plan->nombre_plan), 'TERCERA EDAD')) ? ' [⚡ Precio Promocional - Regular $' . number_format($plan->precio_regular ?? 30, 2) . ']' : '' }}
                            </option>
                        @endforeach
                        </optgroup>
                        @endif
                    @endforeach
                </select>
                <p class="text-xs text-on-surface-variant mt-1">El tipo de conexión (Fibra / Radio) se asigna automáticamente según el plan.</p>
                @error('id_plan')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Fecha del contrato -->
            <div>
                <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="fecha">Fecha del Contrato</label>
                <input id="fecha" name="fecha" type="date"
                    value="{{ old('fecha', \Carbon\Carbon::parse($contract->fecha)->format('Y-m-d')) }}"
                    class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all @error('fecha') border-error @enderror"
                    required>
                @error('fecha')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Duración del contrato -->
            <div>
                <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="duracion">Duración del Contrato</label>
                <select id="duracion" name="duracion" required
                    class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all @error('duracion') border-error @enderror">
                    @foreach($duraciones as $meses)
                        <option value="{{ $meses }}" {{ (int) old('duracion', $contract->duracion ?: 24) === (int) $meses ? 'selected' : '' }}>
                            {{ $meses }} meses
                        </option>
                    @endforeach
                </select>
                @error('duracion')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Botones -->
            <div class="flex justify-between items-center pt-4 border-t border-outline-variant/30">
                <a href="{{ route('contracts.index') }}" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-on-surface-variant hover:bg-surface-container transition-colors">
                    ← Volver
                </a>
                <button type="submit" class="bg-primary text-on-primary px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-secondary transition-all duration-300 shadow-lg shadow-primary/10">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
