@extends('layouts.app')

@section('header_title', 'Extensiones de email')
@section('header_subtitle', 'Dominios de correo disponibles al registrar un cliente')

@section('content')

<div class="cds-card">
    <div class="cds-table-toolbar flex-wrap">
        <div>
            <h2 class="cds-section-title">Extensiones disponibles</h2>
            <p class="cds-label-01 mt-1">{{ $extensiones->count() }} extensión(es)</p>
        </div>
        <form method="POST" action="{{ route('extensiones.store') }}" class="flex items-end gap-2 w-full sm:w-auto">
            @csrf
            <div class="flex-1 min-w-0">
                <label for="nuevo-dominio" class="cds-label-01 block mb-1">Nueva extensión</label>
                <div class="flex items-center bg-[#f4f4f4] border-b border-outline">
                    <span class="pl-3 text-sm text-on-surface-variant">@</span>
                    <input id="nuevo-dominio" type="text" name="dominio" maxlength="100" required placeholder="ejemplo.com" value="{{ old('_editing') ? '' : old('dominio') }}"
                           class="cds-text-input w-full sm:!w-52 !bg-transparent !border-0 !pl-1">
                </div>
            </div>
            <button type="submit" class="cds-btn cds-btn--primary cds-btn--md">
                <span>Agregar</span>
                <span class="material-symbols-outlined">add</span>
            </button>
        </form>
    </div>
    @error('dominio')
    <p class="bg-[#fff1f1] border-l-[3px] border-[#da1e28] px-4 py-3 text-sm text-primary" role="alert">{{ $message }}</p>
    @enderror

    <div class="overflow-x-auto">
    <table class="cds-table">
        <thead>
            <tr>
                <th>Extensión</th>
                <th>Clientes</th>
                <th class="text-right"><span class="sr-only">Acciones</span></th>
            </tr>
        </thead>
        <tbody>
        @forelse($extensiones as $ext)
            <tr>
                <td>
                    <span class="cds-cell-strong font-mono" id="ext-label-{{ $ext->id }}">&#64;{{ $ext->dominio }}</span>
                    <form method="POST" action="{{ route('extensiones.update', $ext->id) }}" id="ext-form-{{ $ext->id }}" class="hidden items-center gap-1">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="_editing" value="{{ $ext->id }}">
                        <span class="text-on-surface-variant">@</span>
                        <input type="text" name="dominio" maxlength="100" required value="{{ $ext->dominio }}" aria-label="Editar extensión"
                               class="cds-text-input !w-52 !h-8 !bg-[#f4f4f4] font-mono">
                        <button type="submit" class="cds-btn cds-btn--ghost cds-btn--icon !min-h-8 !w-8" title="Guardar" aria-label="Guardar">
                            <span class="material-symbols-outlined">check</span>
                        </button>
                        <button type="button" class="cds-btn cds-btn--ghost cds-btn--icon !min-h-8 !w-8" title="Cancelar" aria-label="Cancelar" onclick="toggleEdit({{ $ext->id }}, false)">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </form>
                </td>
                <td><span class="cds-tag cds-tag--gray">{{ $ext->clientes_count }} clientes</span></td>
                <td class="text-right whitespace-nowrap">
                    <div class="flex justify-end">
                        <button type="button" class="cds-btn cds-btn--ghost cds-btn--icon" title="Editar" aria-label="Editar &#64;{{ $ext->dominio }}" onclick="toggleEdit({{ $ext->id }}, true)">
                            <span class="material-symbols-outlined">edit</span>
                        </button>
                        <form method="POST" action="{{ route('extensiones.destroy', $ext->id) }}" class="inline-flex" onsubmit="return confirm('¿Eliminar la extensión &#64;{{ $ext->dominio }}? Los correos de clientes existentes no se modifican.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="cds-btn cds-btn--danger-ghost cds-btn--icon" title="Eliminar" aria-label="Eliminar &#64;{{ $ext->dominio }}">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="3" class="!py-10 text-center">No hay extensiones registradas.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
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
