{{-- Formulario compartido de personal. Opcional: $persona (edición) --}}
@php $persona = $persona ?? null; @endphp
<div class="cds-form-section space-y-6">
    <div class="cds-form-item">
        <label class="cds-label" for="name">Nombre completo</label>
        <input type="text" name="name" id="name" required maxlength="255" class="cds-text-input"
               value="{{ old('name', $persona->name ?? '') }}" placeholder="Apellidos y nombres"
               @error('name') aria-invalid="true" @enderror>
        <x-cds-field-error name="name" />
    </div>

    <div class="cds-form-item">
        <label class="cds-label" for="cedula">Número de cédula</label>
        <input type="text" name="cedula" id="cedula" required maxlength="10" inputmode="numeric" class="cds-text-input font-mono sm:!w-64"
               value="{{ old('cedula', $persona->cedula ?? '') }}" placeholder="10 dígitos"
               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
               @error('cedula') aria-invalid="true" @enderror>
        <p class="cds-helper">Con esta cédula el usuario ingresa al sistema.</p>
        <x-cds-field-error name="cedula" />
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="cds-form-item">
            <label class="cds-label" for="role">Rol</label>
            <select name="role" id="role" required class="cds-select--field" @error('role') aria-invalid="true" @enderror>
                @unless($persona)<option value="" disabled {{ old('role') ? '' : 'selected' }}>Seleccione un rol…</option>@endunless
                <option value="administrativo" {{ old('role', $persona->role ?? '') == 'administrativo' ? 'selected' : '' }}>Administrativo</option>
                <option value="administrador" {{ old('role', $persona->role ?? '') == 'administrador' ? 'selected' : '' }}>Administrador</option>
                <option value="tecnico" {{ old('role', $persona->role ?? '') == 'tecnico' ? 'selected' : '' }}>Técnico</option>
            </select>
            <x-cds-field-error name="role" />
        </div>
        <div class="cds-form-item">
            <label class="cds-label" for="base">Base</label>
            <select name="base" id="base" class="cds-select--field" @error('base') aria-invalid="true" @enderror>
                <option value="">Sin base (solo administrador general)</option>
                @foreach(\App\Models\User::BASES as $base)
                    <option value="{{ $base }}" {{ old('base', $persona->base ?? '') == $base ? 'selected' : '' }}>{{ $base }}</option>
                @endforeach
            </select>
            <x-cds-field-error name="base" />
        </div>
    </div>

    <div class="bg-[#f4f4f4] border-l-[3px] border-[#0f62fe] px-4 py-3 text-sm text-primary space-y-1">
        <p><strong class="font-semibold">Administrador:</strong> acceso total.</p>
        <p><strong class="font-semibold">Administrativo:</strong> solo clientes y contratos.</p>
        <p><strong class="font-semibold">Técnico:</strong> solo sus instalaciones asignadas.</p>
        <p class="pt-1 text-on-surface-variant">Cada usuario solo ve los contratos de su base. Un administrador sin base ve todas las bases.</p>
    </div>

    @if($persona && $persona->id == auth()->id() && $persona->isAdministrador())
        <div class="bg-[#fcf4d6] border-l-[3px] border-[#f1c21b] px-4 py-3 text-sm text-primary flex items-start gap-2" role="note">
            <span class="material-symbols-outlined text-[#8e6a00]" style="font-size:18px">warning</span>
            <span>Si te quitas el rol de administrador a ti mismo, podrías perder acceso a esta página.</span>
        </div>
    @endif
</div>
