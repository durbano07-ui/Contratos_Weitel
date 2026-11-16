{{-- Formulario compartido de planes. Requiere: $tipos; opcional: $plan (edición) --}}
@php $plan = $plan ?? null; @endphp
<div class="cds-form-section space-y-6">
    <div class="cds-form-item">
        <label class="cds-label" for="id_tipo">Tipo de conexión</label>
        <select id="id_tipo" name="id_tipo" required class="cds-select--field" @error('id_tipo') aria-invalid="true" @enderror>
            @unless($plan)<option value="">Seleccione un tipo…</option>@endunless
            @foreach($tipos as $tipo)
                <option value="{{ $tipo->id_tipo }}" {{ old('id_tipo', $plan->id_tipo ?? null) == $tipo->id_tipo ? 'selected' : '' }}>{{ $tipo->nombre_tipo }}</option>
            @endforeach
        </select>
        <x-cds-field-error name="id_tipo" />
    </div>

    <div class="cds-form-item">
        <label class="cds-label" for="nombre_plan">Nombre del plan</label>
        <input id="nombre_plan" name="nombre_plan" type="text" required maxlength="100" class="cds-text-input"
               value="{{ old('nombre_plan', $plan->nombre_plan ?? '') }}" placeholder="Ej: Fiber Home Estudiantil 500 Megas"
               @error('nombre_plan') aria-invalid="true" @enderror>
        <x-cds-field-error name="nombre_plan" />
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="cds-form-item">
            <label class="cds-label" for="velocidad">Velocidad</label>
            <input id="velocidad" name="velocidad" type="text" required maxlength="50" class="cds-text-input"
                   value="{{ old('velocidad', $plan->velocidad ?? '') }}" placeholder="Ej: 500 MEGAS"
                   @error('velocidad') aria-invalid="true" @enderror>
            <x-cds-field-error name="velocidad" />
        </div>
        <div class="cds-form-item">
            <label class="cds-label" for="precio">Precio mensual con IVA (USD)</label>
            <div class="cds-input-prefix">
                <span>$</span>
                <input id="precio" name="precio" type="number" step="0.01" min="0" required class="cds-text-input font-mono"
                       value="{{ old('precio', $plan->precio ?? '') }}" placeholder="0.00"
                       @error('precio') aria-invalid="true" @enderror>
            </div>
            <x-cds-field-error name="precio" />
        </div>
    </div>
</div>

<div class="cds-form-section space-y-6">
    <div>
        <h3 class="cds-form-section-title">Promoción</h3>
        <p class="cds-form-section-desc">Opcional. Sirve para mostrar el descuento frente al precio normal.</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="cds-form-item">
            <label class="cds-label" for="precio_regular">Precio regular / antes (USD) <span class="cds-optional">(opcional)</span></label>
            <div class="cds-input-prefix">
                <span>$</span>
                <input id="precio_regular" name="precio_regular" type="number" step="0.01" min="0" class="cds-text-input font-mono"
                       value="{{ old('precio_regular', $plan->precio_regular ?? '') }}" placeholder="Ej: 30.00"
                       @error('precio_regular') aria-invalid="true" @enderror>
            </div>
            <p class="cds-helper">Precio normal de referencia para calcular el descuento.</p>
            <x-cds-field-error name="precio_regular" />
        </div>
        <div class="cds-form-item sm:pt-6">
            <label class="inline-flex items-center gap-2 cursor-pointer text-sm text-primary">
                <input type="checkbox" name="es_promocional" value="1" class="cds-checkbox"
                       {{ old('es_promocional', $plan->es_promocional ?? false) ? 'checked' : '' }}>
                <span>Marcar como precio promocional</span>
            </label>
            <p class="cds-helper ml-6">Muestra la etiqueta “Promocional” en el catálogo.</p>
        </div>
    </div>
</div>
