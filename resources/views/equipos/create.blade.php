@extends('layouts.app')

@section('header_title', 'Nuevo Equipo')
@section('header_subtitle', 'Registrar equipo o material técnico en el inventario')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-surface-container-lowest rounded-xl shadow-[0_24px_48px_-12px_rgba(26,28,28,0.08)] overflow-hidden">
        <div class="p-6 bg-surface-container-low border-b border-outline-variant/30">
            <h2 class="font-headline font-bold text-xl">Datos del Equipo</h2>
            <p class="text-sm text-on-surface-variant mt-1">Complete los campos para agregar un nuevo equipo al inventario.</p>
        </div>
        <form action="{{ route('equipos.store') }}" method="POST" class="p-6 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="nombre">Nombre del Equipo / Material</label>
                <input id="nombre" name="nombre" type="text" value="{{ old('nombre') }}"
                    placeholder="Ej: Router TP-Link TL-WR840N, Cable UTP Cat6, Splitter..."
                    class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all @error('nombre') border-error @enderror"
                    required>
                @error('nombre')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="categoria">Categoría</label>
                    <input id="categoria" name="categoria" type="text" value="{{ old('categoria') }}"
                        placeholder="Ej: Router, Cable, Herramienta"
                        list="categorias-list"
                        class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all @error('categoria') border-error @enderror"
                        required>
                    <datalist id="categorias-list">
                        @foreach($categorias as $cat)
                            <option value="{{ $cat }}">
                        @endforeach
                        <option value="Router">
                        <option value="Cable">
                        <option value="Herramienta">
                        <option value="Splitter">
                        <option value="Conector">
                        <option value="Fibra Óptica">
                    </datalist>
                    @error('categoria')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="unidad">Unidad de Medida</label>
                    <select id="unidad" name="unidad"
                        class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all"
                        required>
                        <option value="unidad" {{ old('unidad') == 'unidad' ? 'selected' : '' }}>Unidad</option>
                        <option value="metro" {{ old('unidad') == 'metro' ? 'selected' : '' }}>Metro</option>
                        <option value="rollo" {{ old('unidad') == 'rollo' ? 'selected' : '' }}>Rollo</option>
                        <option value="caja" {{ old('unidad') == 'caja' ? 'selected' : '' }}>Caja</option>
                        <option value="par" {{ old('unidad') == 'par' ? 'selected' : '' }}>Par</option>
                        <option value="kit" {{ old('unidad') == 'kit' ? 'selected' : '' }}>Kit</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="stock">Stock Actual</label>
                    <input id="stock" name="stock" type="number" min="0" value="{{ old('stock', 0) }}"
                        class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all"
                        required>
                    @error('stock')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="stock_minimo">
                        Stock Mínimo
                        <span class="text-outline font-normal text-[10px] ml-1">(alerta de reposición)</span>
                    </label>
                    <input id="stock_minimo" name="stock_minimo" type="number" min="0" value="{{ old('stock_minimo', 5) }}"
                        class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all"
                        required>
                    @error('stock_minimo')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="descripcion">Descripción (opcional)</label>
                <textarea id="descripcion" name="descripcion" rows="3"
                    placeholder="Especificaciones técnicas, modelo, marca, notas..."
                    class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all resize-none">{{ old('descripcion') }}</textarea>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-outline-variant/30">
                <a href="{{ route('equipos.index') }}" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-on-surface-variant hover:bg-surface-container transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="bg-primary text-on-primary px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-secondary transition-all duration-300 shadow-lg shadow-primary/10">
                    Registrar Equipo
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
