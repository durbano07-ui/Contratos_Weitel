@extends('layouts.app')

@section('header_title', 'Editar Plan')
@section('header_subtitle', 'Modificar datos del plan: ' . $plan->nombre_plan)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-surface-container-lowest rounded-xl shadow-[0_24px_48px_-12px_rgba(26,28,28,0.08)] overflow-hidden">
        <div class="p-6 bg-surface-container-low border-b border-outline-variant/30">
            <h2 class="font-headline font-bold text-xl">Editar Plan</h2>
            <p class="text-sm text-on-surface-variant mt-1">Modifica los datos del plan <strong>{{ $plan->nombre_plan }}</strong>.</p>
        </div>
        <form action="{{ route('planes.update', $plan->id_plan) }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="id_tipo">Tipo de Conexión</label>
                <select id="id_tipo" name="id_tipo" required
                    class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all">
                    @foreach($tipos as $tipo)
                        <option value="{{ $tipo->id_tipo }}" {{ (old('id_tipo', $plan->id_tipo)) == $tipo->id_tipo ? 'selected' : '' }}>
                            {{ $tipo->nombre_tipo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="nombre_plan">Nombre del Plan</label>
                <input id="nombre_plan" name="nombre_plan" type="text" value="{{ old('nombre_plan', $plan->nombre_plan) }}"
                    class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all"
                    required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="velocidad">Velocidad</label>
                    <input id="velocidad" name="velocidad" type="text" value="{{ old('velocidad', $plan->velocidad) }}"
                        class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="precio">Precio mensual (USD)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-sm text-outline font-semibold">$</span>
                        <input id="precio" name="precio" type="number" step="0.01" min="0" value="{{ old('precio', $plan->precio) }}"
                            class="w-full bg-surface-container border border-outline-variant rounded-lg pl-7 pr-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all"
                            required>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 bg-surface-container/50 p-4 rounded-lg border border-outline-variant/30">
                <div>
                    <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="precio_regular">Precio Regular / Antes (USD)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-sm text-outline font-semibold">$</span>
                        <input id="precio_regular" name="precio_regular" type="number" step="0.01" min="0" value="{{ old('precio_regular', $plan->precio_regular) }}"
                            placeholder="Ej: 30.00 (Opcional)"
                            class="w-full bg-surface-container border border-outline-variant rounded-lg pl-7 pr-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all">
                    </div>
                    <p class="text-[11px] text-outline mt-1">Precio normal de referencia para calcular el descuento.</p>
                </div>
                <div class="flex flex-col justify-center">
                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Estado Promocional</label>
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="es_promocional" value="1" {{ old('es_promocional', $plan->es_promocional) ? 'checked' : '' }}
                            class="rounded border-outline-variant text-primary focus:ring-primary w-4 h-4">
                        <span class="text-sm font-medium">Marcar como Precio Promocional</span>
                    </label>
                    <p class="text-[11px] text-outline mt-1">Muestra insignia destacada en el catálogo.</p>
                </div>
            </div>

            <div class="flex justify-between items-center pt-4 border-t border-outline-variant/30">
                <a href="{{ route('planes.index') }}" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-on-surface-variant hover:bg-surface-container transition-colors">
                    ← Volver
                </a>
                <button type="submit" class="bg-primary text-on-primary px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-secondary transition-all duration-300 shadow-lg shadow-primary/10">
                    Actualizar Plan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
