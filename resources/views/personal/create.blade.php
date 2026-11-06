@extends('layouts.app')

@section('header_title', 'Agregar Personal')
@section('header_subtitle', 'Registro de un nuevo usuario en el sistema')

@section('content')

    <div class="pl-4 border-l-4 border-secondary mb-6">
        <h3 class="text-sm font-label uppercase tracking-widest text-on-surface-variant">Personal</h3>
        <h2 class="text-3xl font-headline font-extrabold tracking-tight -mt-1">Nuevo Usuario</h2>
    </div>

    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/30 p-8 max-w-2xl">
        <form action="{{ route('personal.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-sm font-label text-on-surface-variant mb-1">Nombre Completo <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full bg-surface border border-outline-variant rounded-lg px-4 py-2.5 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                    @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Nombre -->
                <div>
                    <label for="cedula" class="block text-sm font-label text-on-surface-variant mb-1">Número de cédula <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="cedula" id="cedula" value="{{ old('cedula') }}" required
                        class="w-full bg-surface border border-outline-variant rounded-lg px-4 py-2.5 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                    @error('cedula') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Rol -->
                <div>
                    <label for="role" class="block text-sm font-label text-on-surface-variant mb-1">Rol <span
                            class="text-red-500">*</span></label>
                    <select name="role" id="role" required
                        class="w-full bg-surface border border-outline-variant rounded-lg px-4 py-2.5 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                        <option value="" disabled selected>Seleccione un rol...</option>
                        <option value="administrativo" {{ old('role') == 'administrativo' ? 'selected' : '' }}>Administrativo
                        </option>
                        <option value="administrador" {{ old('role') == 'administrador' ? 'selected' : '' }}>Administrador
                        </option>
                        <option value="tecnico" {{ old('role') == 'tecnico' ? 'selected' : '' }}>Técnico</option>
                    </select>
                    @error('role') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror

                    <p class="text-xs text-outline mt-2">
                        <b>Administrador:</b> Acceso total.<br>
                        <b>Administrativo:</b> Solo clientes y contratos.<br>
                        <b>Técnico:</b> Solo sus instalaciones asignadas.
                    </p>
                </div>

                <!-- Base -->
                <div>
                    <label for="base" class="block text-sm font-label text-on-surface-variant mb-1">Base</label>
                    <select name="base" id="base"
                        class="w-full bg-surface border border-outline-variant rounded-lg px-4 py-2.5 text-sm outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                        <option value="">Sin base (solo Administrador general)</option>
                        @foreach(\App\Models\User::BASES as $base)
                            <option value="{{ $base }}" {{ old('base') == $base ? 'selected' : '' }}>{{ $base }}</option>
                        @endforeach
                    </select>
                    @error('base') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror

                    <p class="text-xs text-outline mt-2">
                        Cada usuario solo ve los contratos de su base. Un Administrador sin base ve todas las bases.
                    </p>
                </div>
            </div>

            <!-- Acciones -->
            <div class="mt-8 pt-6 border-t border-outline-variant/30 flex items-center justify-end space-x-3">
                <a href="{{ route('personal.index') }}"
                    class="px-5 py-2.5 rounded-lg text-sm font-semibold text-on-surface-variant hover:bg-surface-container transition-colors">Cancelar</a>
                <button type="submit"
                    class="bg-primary text-on-primary px-6 py-2.5 rounded-lg flex items-center space-x-2 hover:bg-secondary transition-all shadow-md text-sm font-semibold">
                    <span class="material-symbols-outlined" style="font-size:18px">save</span>
                    <span>Guardar Personal</span>
                </button>
            </div>
        </form>
    </div>

@endsection
