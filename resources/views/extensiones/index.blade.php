@extends('layouts.app')

@section('header_title', 'Extensiones de Email')
@section('header_subtitle', 'Dominios de correo disponibles al registrar un cliente')

@section('content')

<div class="flex justify-between items-end flex-wrap gap-4">
    <div class="pl-4 border-l-4 border-secondary">
        <h3 class="text-sm font-label uppercase tracking-widest text-on-surface-variant">Catálogo</h3>
        <h2 class="text-3xl font-headline font-extrabold tracking-tight -mt-1">Extensiones Disponibles</h2>
    </div>
    <form method="POST" action="{{ route('extensiones.store') }}" class="flex items-center gap-2">
        @csrf
        <div class="flex items-center rounded-lg border border-outline-variant bg-surface-container-lowest overflow-hidden">
            <span class="pl-3 text-sm text-on-surface-variant font-semibold">@</span>
            <input type="text" name="dominio" maxlength="100" required placeholder="ejemplo.com" value="{{ old('_editing') ? '' : old('dominio') }}"
                class="w-48 px-2 py-2.5 bg-transparent border-0 text-sm focus:ring-0">
        </div>
        <button type="submit" class="bg-primary text-on-primary px-6 py-2.5 rounded-lg flex items-center space-x-2 hover:bg-secondary transition-all duration-300 text-sm font-semibold shadow-lg shadow-primary/10">
            <span class="material-symbols-outlined" style="font-size:18px">add</span>
            <span>Agregar</span>
        </button>
    </form>
</div>

@error('dominio')
<p class="text-sm text-secondary font-semibold">{{ $message }}</p>
@enderror

<div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0_24px_48px_-12px_rgba(26,28,28,0.08)]">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-surface-container-low/50">
                <th class="p-4 font-label text-[11px] uppercase tracking-wider text-on-surface-variant">Extensión</th>
                <th class="p-4 font-label text-[11px] uppercase tracking-wider text-on-surface-variant">Clientes</th>
                <th class="p-4 font-label text-[11px] uppercase tracking-wider text-on-surface-variant text-right">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-sm font-body">
            @forelse($extensiones as $ext)
            <tr class="hover:bg-surface transition-colors {{ $loop->even ? 'bg-surface-container-low/30' : '' }}">
                <td class="p-4">
                    <span class="font-semibold text-primary" id="ext-label-{{ $ext->id }}">&#64;{{ $ext->dominio }}</span>
                    <form method="POST" action="{{ route('extensiones.update', $ext->id) }}" id="ext-form-{{ $ext->id }}" class="hidden items-center gap-2">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="_editing" value="{{ $ext->id }}">
                        <span class="text-on-surface-variant font-semibold">@</span>
                        <input type="text" name="dominio" maxlength="100" required value="{{ $ext->dominio }}"
                            class="w-48 px-2 py-1.5 rounded-lg border border-outline-variant bg-surface-container-lowest text-sm">
                        <button type="submit" class="p-1.5 hover:text-primary rounded-lg" title="Guardar">
                            <span class="material-symbols-outlined" style="font-size:18px">check</span>
                        </button>
                        <button type="button" class="p-1.5 hover:text-secondary rounded-lg" title="Cancelar" onclick="toggleEdit({{ $ext->id }}, false)">
                            <span class="material-symbols-outlined" style="font-size:18px">close</span>
                        </button>
                    </form>
                </td>
                <td class="p-4">
                    <span class="px-2 py-1 bg-surface-container text-on-surface-variant text-[10px] font-bold rounded-full">
                        {{ $ext->clientes_count }} clientes
                    </span>
                </td>
                <td class="p-4 text-right whitespace-nowrap">
                    <button type="button" class="p-2 hover:text-primary hover:bg-surface-container rounded-lg transition-colors" title="Editar" onclick="toggleEdit({{ $ext->id }}, true)">
                        <span class="material-symbols-outlined" style="font-size:18px">edit</span>
                    </button>
                    <form method="POST" action="{{ route('extensiones.destroy', $ext->id) }}" class="inline" onsubmit="return confirm('¿Eliminar la extensión &#64;{{ $ext->dominio }}? Los correos de clientes existentes no se modifican.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Eliminar">
                            <span class="material-symbols-outlined" style="font-size:18px">delete</span>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="3" class="p-6 text-center text-on-surface-variant">No hay extensiones registradas.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    function toggleEdit(id, editing) {
        document.getElementById('ext-label-' + id).classList.toggle('hidden', editing);
        const form = document.getElementById('ext-form-' + id);
        form.classList.toggle('hidden', !editing);
        form.classList.toggle('flex', editing);
        if (editing) form.querySelector('input[name=dominio]').focus();
    }
    @if(old('_editing'))
        toggleEdit({{ (int) old('_editing') }}, true);
    @endif
</script>

@endsection
