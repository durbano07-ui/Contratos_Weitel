@extends('layouts.app')

@section('header_title', 'Editar Equipo')
@section('header_subtitle', 'Modificar datos del equipo: ' . $equipo->nombre)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-surface-container-lowest rounded-xl shadow-[0_24px_48px_-12px_rgba(26,28,28,0.08)] overflow-hidden">
        <div class="p-6 bg-surface-container-low border-b border-outline-variant/30 flex items-center justify-between">
            <div>
                <h2 class="font-headline font-bold text-xl">Editar Equipo</h2>
                <p class="text-sm text-on-surface-variant mt-1">Actualizando: <strong>{{ $equipo->nombre }}</strong></p>
            </div>
            @if($equipo->stockBajo())
                <span class="px-3 py-1 bg-red-100 text-red-700 text-[10px] font-bold uppercase tracking-wider rounded-full flex items-center space-x-1">
                    <span class="material-symbols-outlined" style="font-size:13px">warning</span>
                    <span>Stock Bajo</span>
                </span>
            @endif
        </div>
        <form action="{{ route('equipos.update', $equipo->id) }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="nombre">Nombre del Equipo / Material</label>
                <input id="nombre" name="nombre" type="text" value="{{ old('nombre', $equipo->nombre) }}"
                    class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all"
                    required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="categoria">Categoría</label>
                    <input id="categoria" name="categoria" type="text" value="{{ old('categoria', $equipo->categoria) }}"
                        list="categorias-list"
                        class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all"
                        required>
                    <datalist id="categorias-list">
                        @foreach($categorias as $cat)
                            <option value="{{ $cat }}">
                        @endforeach
                    </datalist>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="unidad">Unidad de Medida</label>
                    <select id="unidad" name="unidad"
                        class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all"
                        required>
                        @foreach(['unidad','metro','rollo','caja','par','kit'] as $u)
                            <option value="{{ $u }}" {{ old('unidad', $equipo->unidad) === $u ? 'selected' : '' }}>{{ ucfirst($u) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="stock">Stock Actual</label>
                    <input id="stock" name="stock" type="number" min="0" value="{{ old('stock', $equipo->stock) }}"
                        class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all {{ $equipo->stockBajo() ? 'border-red-400 bg-red-50' : '' }}"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="stock_minimo">Stock Mínimo</label>
                    <input id="stock_minimo" name="stock_minimo" type="number" min="0" value="{{ old('stock_minimo', $equipo->stock_minimo) }}"
                        class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all"
                        required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-on-surface-variant mb-1.5" for="descripcion">Descripción (opcional)</label>
                <textarea id="descripcion" name="descripcion" rows="3"
                    class="w-full bg-surface-container border border-outline-variant rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all resize-none">{{ old('descripcion', $equipo->descripcion) }}</textarea>
            </div>

            <div class="flex justify-between items-center pt-4 border-t border-outline-variant/30">
                <a href="{{ route('equipos.index') }}" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-on-surface-variant hover:bg-surface-container transition-colors">
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
