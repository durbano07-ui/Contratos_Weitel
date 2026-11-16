@extends('layouts.app')

@section('header_title', 'Gestión de personal')
@section('header_subtitle', 'Administración de usuarios y roles del sistema')

@section('content')

<div class="cds-card">
    <div class="cds-table-toolbar flex-wrap">
        <div>
            <h2 class="cds-section-title">Usuarios del sistema</h2>
            <p class="cds-label-01 mt-1">{{ $personal->count() }} usuario(s) · el ingreso al sistema es con la cédula</p>
        </div>
        <a href="{{ route('personal.create') }}" class="cds-btn cds-btn--primary">
            <span>Agregar personal</span>
            <span class="material-symbols-outlined">person_add</span>
        </a>
    </div>

    <div class="overflow-x-auto">
    <table class="cds-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Cédula</th>
                <th>Rol</th>
                <th>Base</th>
                <th class="text-right"><span class="sr-only">Acciones</span></th>
            </tr>
        </thead>
        <tbody>
        @forelse($personal as $persona)
            <tr>
                <td class="font-mono">#{{ $persona->id }}</td>
                <td class="cds-cell-strong">{{ $persona->name }}</td>
                <td class="font-mono">{{ $persona->cedula }}</td>
                <td>
                    @if($persona->isAdministrador())
                        <span class="cds-tag cds-tag--gray">Administrador</span>
                    @elseif($persona->isTecnico())
                        <span class="cds-tag cds-tag--gray">Técnico</span>
                    @else
                        <span class="cds-tag cds-tag--gray">Administrativo</span>
                    @endif
                </td>
                <td>{{ $persona->base ?? ($persona->isAdministrador() ? 'Todas' : '—') }}</td>
                <td class="text-right">
                    <div class="flex justify-end">
                        <a href="{{ route('personal.edit', $persona->id) }}" class="cds-btn cds-btn--ghost cds-btn--icon" title="Editar" aria-label="Editar {{ $persona->name }}">
                            <span class="material-symbols-outlined">edit</span>
                        </a>
                        @if($persona->id !== auth()->id())
                        <form method="POST" action="{{ route('personal.destroy', $persona->id) }}" onsubmit="return confirm('¿Estás seguro de eliminar a {{ $persona->name }}? Esta acción no se puede deshacer.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="cds-btn cds-btn--danger-ghost cds-btn--icon" title="Eliminar" aria-label="Eliminar {{ $persona->name }}">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </form>
                        @else
                        <span class="cds-btn cds-btn--ghost cds-btn--icon text-[#c6c6c6] cursor-not-allowed hover:!bg-transparent" title="No puedes eliminar tu propia cuenta">
                            <span class="material-symbols-outlined">delete</span>
                        </span>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="!py-10 text-center">No hay personal registrado en el sistema.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    </div>
</div>

@endsection
