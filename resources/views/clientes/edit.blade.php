@extends('layouts.app')

@section('header_title', 'Editar cliente')
@section('header_subtitle', 'Modificar datos del cliente: ' . $cliente->nombre . ' ' . $cliente->apellido)

@section('content')
<div class="max-w-3xl space-y-6">

    <!-- Datos del cliente -->
    <form action="{{ route('clientes.update', $cliente->id_cliente) }}" method="POST" class="cds-form">
        @csrf
        @method('PUT')

        <div class="cds-form-section space-y-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="cds-form-section-title">Datos del cliente</h2>
                    <p class="cds-form-section-desc font-mono">CL-{{ str_pad($cliente->id_cliente, 5, '0', STR_PAD_LEFT) }} · {{ $cliente->cedula }}</p>
                </div>
                @if($cliente->isBaja())
                    <span class="cds-tag cds-tag--red">Dado de baja</span>
                @else
                    <span class="cds-tag cds-tag--green">Activo</span>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="cds-form-item">
                    <label class="cds-label" for="nombre">Nombre</label>
                    <input id="nombre" name="nombre" type="text" required maxlength="100" class="cds-text-input"
                           value="{{ old('nombre', $cliente->nombre) }}" @error('nombre') aria-invalid="true" @enderror>
                    <x-cds-field-error name="nombre" />
                </div>
                <div class="cds-form-item">
                    <label class="cds-label" for="apellido">Apellido <span class="cds-optional">(opcional)</span></label>
                    <input id="apellido" name="apellido" type="text" class="cds-text-input"
                           value="{{ old('apellido', $cliente->apellido) }}" @error('apellido') aria-invalid="true" @enderror>
                    <x-cds-field-error name="apellido" />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="cds-form-item">
                    <label class="cds-label" for="cedula">Cédula / RUC</label>
                    <input id="cedula" name="cedula" type="text" required inputmode="numeric" pattern="[0-9]{10}|[0-9]{13}" maxlength="13"
                           title="Cédula (10 dígitos) o RUC (13 dígitos)" class="cds-text-input font-mono"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           value="{{ old('cedula', $cliente->cedula) }}" @error('cedula') aria-invalid="true" @enderror>
                    <x-cds-field-error name="cedula" />
                </div>
                <div class="cds-form-item">
                    <label class="cds-label" for="n_telefono">Teléfono</label>
                    <input id="n_telefono" name="n_telefono" type="text" maxlength="20" class="cds-text-input font-mono"
                           value="{{ old('n_telefono', $cliente->n_telefono) }}" @error('n_telefono') aria-invalid="true" @enderror>
                    <x-cds-field-error name="n_telefono" />
                </div>
            </div>

            <div class="cds-form-item">
                <label class="cds-label" for="email">Correo electrónico</label>
                <input id="email" name="email" type="email" class="cds-text-input"
                       value="{{ old('email', $cliente->email) }}" @error('email') aria-invalid="true" @enderror>
                <x-cds-field-error name="email" />
            </div>
        </div>

        <div class="cds-form-section space-y-6">
            <h3 class="cds-form-section-title">Ubicación</h3>
            <div class="cds-form-item">
                <label class="cds-label" for="direccion">Dirección</label>
                <input id="direccion" name="direccion" type="text" maxlength="255" class="cds-text-input"
                       value="{{ old('direccion', $cliente->direccion) }}" @error('direccion') aria-invalid="true" @enderror>
                <x-cds-field-error name="direccion" />
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="cds-form-item">
                    <label class="cds-label" for="provincia">Provincia</label>
                    <input id="provincia" name="provincia" type="text" maxlength="100" class="cds-text-input" value="{{ old('provincia', $cliente->provincia) }}">
                    <x-cds-field-error name="provincia" />
                </div>
                <div class="cds-form-item">
                    <label class="cds-label" for="canton">Cantón</label>
                    <input id="canton" name="canton" type="text" maxlength="100" class="cds-text-input" value="{{ old('canton', $cliente->canton) }}">
                    <x-cds-field-error name="canton" />
                </div>
                <div class="cds-form-item">
                    <label class="cds-label" for="ciudad">Ciudad</label>
                    <input id="ciudad" name="ciudad" type="text" maxlength="100" class="cds-text-input" value="{{ old('ciudad', $cliente->ciudad) }}">
                    <x-cds-field-error name="ciudad" />
                </div>
                <div class="cds-form-item">
                    <label class="cds-label" for="parroquia">Parroquia</label>
                    <input id="parroquia" name="parroquia" type="text" maxlength="100" class="cds-text-input" value="{{ old('parroquia', $cliente->parroquia) }}">
                    <x-cds-field-error name="parroquia" />
                </div>
            </div>
        </div>

        <div class="cds-form-actions">
            <a href="{{ route('clientes.index') }}" class="cds-btn cds-btn--secondary">Cancelar</a>
            <button type="submit" class="cds-btn cds-btn--primary">
                <span>Guardar cambios</span>
                <span class="material-symbols-outlined">check</span>
            </button>
        </div>
    </form>

    <!-- Dar de baja / Reactivar -->
    <section id="baja" class="cds-form scroll-mt-6">
        <div class="flex items-start gap-3">
            <span class="material-symbols-outlined {{ $cliente->isBaja() ? 'text-[#24a148]' : 'text-[#da1e28]' }}" style="font-size:24px">{{ $cliente->isBaja() ? 'restart_alt' : 'block' }}</span>
            <div>
                <h2 class="cds-form-section-title">{{ $cliente->isBaja() ? 'Reactivar cliente' : 'Dar de baja' }}</h2>
                <p class="cds-form-section-desc">
                    {{ $cliente->isBaja()
                        ? 'Baja registrada el ' . \Carbon\Carbon::parse($cliente->fecha_baja)->format('d/m/Y') . '. Motivo: ' . $cliente->motivo_baja
                        : 'El cliente permanecerá en el sistema, pero marcado como inactivo. Se puede revertir más adelante.'
                    }}
                </p>
            </div>
        </div>

        @if($cliente->isBaja())
            <form action="{{ route('clientes.reactivar', $cliente->id_cliente) }}" method="POST" class="cds-form-actions">
                @csrf
                <button type="submit" onclick="return confirm('¿Reactivar a {{ $cliente->nombre }}? Se restaurará su estado como cliente activo.')" class="cds-btn cds-btn--primary">
                    <span>Reactivar cliente</span>
                    <span class="material-symbols-outlined">restart_alt</span>
                </button>
            </form>
        @else
            <form action="{{ route('clientes.baja', $cliente->id_cliente) }}" method="POST" class="mt-6">
                @csrf
                <div class="cds-form-item">
                    <label class="cds-label" for="motivo_baja">Motivo de la baja</label>
                    <textarea id="motivo_baja" name="motivo_baja" rows="3" required minlength="10" class="cds-textarea"
                              placeholder="Indique el motivo por el cual se da de baja a este cliente…"
                              @error('motivo_baja') aria-invalid="true" @enderror>{{ old('motivo_baja') }}</textarea>
                    <p class="cds-helper">Mínimo 10 caracteres.</p>
                    <x-cds-field-error name="motivo_baja" />
                </div>
                <div class="cds-form-actions">
                    <button type="submit" onclick="return confirm('¿Confirmar baja de {{ $cliente->nombre }}? Esta acción puede revertirse más adelante.')" class="cds-btn cds-btn--danger">
                        <span>Confirmar baja</span>
                        <span class="material-symbols-outlined">block</span>
                    </button>
                </div>
            </form>
        @endif
    </section>

</div>
@endsection
