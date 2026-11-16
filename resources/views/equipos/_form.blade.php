{{-- Formulario compartido de equipos. Requiere: $categorias; opcional: $equipo (edición) --}}
@php $equipo = $equipo ?? null; @endphp
<div class="cds-form-section space-y-6">
    <div class="cds-form-item">
        <label class="cds-label" for="nombre">Nombre del equipo / material</label>
        <input id="nombre" name="nombre" type="text" required maxlength="150" class="cds-text-input"
               value="{{ old('nombre', $equipo->nombre ?? '') }}" placeholder="Ej: Router TP-Link TL-WR840N, Cable UTP Cat6, Splitter…"
               @error('nombre') aria-invalid="true" @enderror>
        <x-cds-field-error name="nombre" />
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="cds-form-item">
            <label class="cds-label" for="categoria">Categoría</label>
            <input id="categoria" name="categoria" type="text" required maxlength="80" list="categorias-list" class="cds-text-input"
                   value="{{ old('categoria', $equipo->categoria ?? '') }}" placeholder="Ej: Router, Cable, Herramienta"
                   @error('categoria') aria-invalid="true" @enderror>
            <datalist id="categorias-list">
                @foreach($categorias->merge(['Router', 'Cable', 'Herramienta', 'Splitter', 'Conector', 'Fibra Óptica'])->unique() as $cat)
                    <option value="{{ $cat }}">
                @endforeach
            </datalist>
            <p class="cds-helper">Escriba una nueva o elija una existente.</p>
            <x-cds-field-error name="categoria" />
        </div>
        <div class="cds-form-item">
            <label class="cds-label" for="unidad">Unidad de medida</label>
            <select id="unidad" name="unidad" required class="cds-select--field">
                @foreach(['unidad', 'metro', 'rollo', 'caja', 'par', 'kit'] as $u)
                    <option value="{{ $u }}" {{ old('unidad', $equipo->unidad ?? 'unidad') === $u ? 'selected' : '' }}>{{ ucfirst($u) }}</option>
                @endforeach
            </select>
            <x-cds-field-error name="unidad" />
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="cds-form-item">
            <label class="cds-label" for="stock">Stock actual</label>
            <input id="stock" name="stock" type="number" min="0" required class="cds-text-input font-mono"
                   value="{{ old('stock', $equipo->stock ?? 0) }}"
                   @if(($equipo && $equipo->stockBajo()) || $errors->has('stock')) aria-invalid="true" @endif>
            @if($equipo && $equipo->stockBajo() && !$errors->has('stock'))
                <p class="cds-error-msg"><span class="material-symbols-outlined" style="font-size:16px">warning</span><span>Stock por debajo del mínimo.</span></p>
            @endif
            <x-cds-field-error name="stock" />
        </div>
        <div class="cds-form-item">
            <label class="cds-label" for="stock_minimo">Stock mínimo</label>
            <input id="stock_minimo" name="stock_minimo" type="number" min="0" required class="cds-text-input font-mono"
                   value="{{ old('stock_minimo', $equipo->stock_minimo ?? 5) }}"
                   @error('stock_minimo') aria-invalid="true" @enderror>
            <p class="cds-helper">Alerta de reposición cuando el stock llega a este valor.</p>
            <x-cds-field-error name="stock_minimo" />
        </div>
    </div>

    <div class="cds-form-item">
        <label class="cds-label" for="descripcion">Descripción <span class="cds-optional">(opcional)</span></label>
        <textarea id="descripcion" name="descripcion" rows="3" maxlength="500" class="cds-textarea"
                  placeholder="Especificaciones técnicas, modelo, marca, notas…">{{ old('descripcion', $equipo->descripcion ?? '') }}</textarea>
        <x-cds-field-error name="descripcion" />
    </div>
</div>
