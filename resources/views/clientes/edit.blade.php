@extends('layouts.app')

@section('header_title', 'Editar Cliente')
@section('header_subtitle', 'Modificar datos del cliente: ' . $cliente->nombre . ' ' . $cliente->apellido)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Card principal de edición -->
    <div class="bg-surface-container-lowest rounded-xl shadow-[0_24px_48px_-12px_rgba(26,28,28,0.08)] overflow-hidden">
        <div class="p-6 bg-surface-container-low border-b border-outline-variant/30 flex items-center justify-between">
            <div>
                <h2 class="font-headline font-bold text-xl">Datos del Cliente</h2>
                <p class="text-sm text-on-surface-variant mt-1">
                    ID: <strong>CL-{{ str_pad($cliente->id_cliente, 5, '0', STR_PAD_LEFT) }}</strong>
                    · Cédula/RUC: <strong>{{ $cliente->cedula }}</strong>
                </p>
            </div>
            @if($cliente->isBaja())
                <span class="px-3 py-1.5 bg-red-100 text-red-700 text-xs font-bold uppercase tracking-wider rounded-full flex items-center space-x-1">
                    <span class="material-symbols-outlined" style="font-size:14px">block</span>
                    <span>Dado de Baja</span>
                </span>
            @else
                <span class="px-3 py-1.5 bg-green-100 text-green-800 text-xs font-bold uppercase tracking-wider rounded-full">Activo</span>
            @endif
        </div>

        <form action="{{ route('clientes.update', $cliente->id_cliente) }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="nombre">Nombre</label>
                    <input id="nombre" name="nombre" type="text" value="{{ old('nombre', $cliente->nombre) }}"
                        class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all @error('nombre') border-error @enderror"
                        required>
                    @error('nombre')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="apellido">Apellido</label>
                    <input id="apellido" name="apellido" type="text" value="{{ old('apellido', $cliente->apellido) }}"
                        class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="cedula">Cédula / RUC</label>
                    <input id="cedula" name="cedula" type="text" value="{{ old('cedula', $cliente->cedula) }}"
                        inputmode="numeric" pattern="[0-9]{10}|[0-9]{13}" maxlength="13" title="Cédula (10 dígitos) o RUC (13 dígitos)"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all @error('cedula') border-error @enderror"
                        required>
                    @error('cedula')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="n_telefono">Teléfono</label>
                    <input id="n_telefono" name="n_telefono" type="text" value="{{ old('n_telefono', $cliente->n_telefono) }}"
                        class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="email">Correo Electrónico</label>
                <input id="email" name="email" type="email" value="{{ old('email', $cliente->email) }}"
                    class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all @error('email') border-error @enderror">
                @error('email')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="direccion">Dirección</label>
                <input id="direccion" name="direccion" type="text" value="{{ old('direccion', $cliente->direccion) }}"
                    class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all">
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="ciudad">Ciudad</label>
                    <input id="ciudad" name="ciudad" type="text" value="{{ old('ciudad', $cliente->ciudad) }}"
                        class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="canton">Cantón</label>
                    <input id="canton" name="canton" type="text" value="{{ old('canton', $cliente->canton) }}"
                        class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="parroquia">Parroquia</label>
                    <input id="parroquia" name="parroquia" type="text" value="{{ old('parroquia', $cliente->parroquia) }}"
                        class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="provincia">Provincia</label>
                    <input id="provincia" name="provincia" type="text" value="{{ old('provincia', $cliente->provincia) }}"
                        class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all">
                </div>
            </div>

            <div class="flex justify-between items-center pt-4 border-t border-outline-variant/30">
                <a href="{{ route('clientes.index') }}" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-on-surface-variant hover:bg-surface-container transition-colors">
                    ← Volver
                </a>
                <button type="submit" class="bg-primary text-on-primary px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-secondary transition-all duration-300 shadow-lg shadow-primary/10">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>

    <!-- Card de Dar de Baja / Reactivar -->
    <div class="bg-surface-container-lowest rounded-xl shadow-[0_24px_48px_-12px_rgba(26,28,28,0.08)] overflow-hidden border {{ $cliente->isBaja() ? 'border-green-200' : 'border-red-200' }}">
        <div class="p-5 flex items-center space-x-3 {{ $cliente->isBaja() ? 'bg-green-50' : 'bg-red-50' }} border-b {{ $cliente->isBaja() ? 'border-green-200' : 'border-red-200' }}">
            <span class="material-symbols-outlined {{ $cliente->isBaja() ? 'text-green-600' : 'text-red-600' }}" style="font-variation-settings: 'FILL' 1; font-size:22px">
                {{ $cliente->isBaja() ? 'check_circle' : 'block' }}
            </span>
            <div>
                <p class="font-semibold text-sm {{ $cliente->isBaja() ? 'text-green-800' : 'text-red-800' }}">
                    {{ $cliente->isBaja() ? 'Reactivar Cliente' : 'Dar de Baja' }}
                </p>
                <p class="text-xs {{ $cliente->isBaja() ? 'text-green-700' : 'text-red-700' }}">
                    {{ $cliente->isBaja()
                        ? 'Baja registrada el ' . \Carbon\Carbon::parse($cliente->fecha_baja)->format('d/m/Y') . '. Motivo: ' . $cliente->motivo_baja
                        : 'El cliente permanecerá en el sistema pero marcado como inactivo.'
                    }}
                </p>
            </div>
        </div>

        @if($cliente->isBaja())
            {{-- Reactivar --}}
            <form action="{{ route('clientes.reactivar', $cliente->id_cliente) }}" method="POST" class="p-5">
                @csrf
                <button type="submit"
                    onclick="return confirm('¿Reactivar a {{ $cliente->nombre }}? Se restaurará su estado como cliente activo.')"
                    class="w-full bg-green-600 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-green-700 transition-all duration-300 flex items-center justify-center space-x-2">
                    <span class="material-symbols-outlined" style="font-size:18px">restart_alt</span>
                    <span>Reactivar Cliente</span>
                </button>
            </form>
        @else
            {{-- Dar de baja --}}
            <form action="{{ route('clientes.baja', $cliente->id_cliente) }}" method="POST" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-red-800 mb-1.5" for="motivo_baja">
                        Motivo de la baja <span class="text-red-500">*</span>
                    </label>
                    <textarea id="motivo_baja" name="motivo_baja" rows="3" required minlength="10"
                        placeholder="Indique el motivo por el cual se da de baja a este cliente..."
                        class="w-full bg-white border border-red-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-red-400 transition-all resize-none @error('motivo_baja') border-error @enderror">{{ old('motivo_baja') }}</textarea>
                    @error('motivo_baja')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <button type="submit"
                    onclick="return confirm('¿Confirmar baja de {{ $cliente->nombre }}? Esta acción puede revertirse más adelante.')"
                    class="w-full bg-red-600 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-red-700 transition-all duration-300 flex items-center justify-center space-x-2">
                    <span class="material-symbols-outlined" style="font-size:18px">block</span>
                    <span>Confirmar Baja</span>
                </button>
            </form>
        @endif
    </div>

</div>
@endsection
