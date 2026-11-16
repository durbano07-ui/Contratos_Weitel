@extends('layouts.app')

@section('header_title', 'Editar equipo')
@section('header_subtitle', 'Modificar datos del equipo: ' . $equipo->nombre)

@section('content')
<form action="{{ route('equipos.update', $equipo->id) }}" method="POST" class="cds-form max-w-3xl">
    @csrf
    @method('PUT')
    @include('equipos._form', ['equipo' => $equipo])
    <div class="cds-form-actions">
        <a href="{{ route('equipos.index') }}" class="cds-btn cds-btn--secondary">Cancelar</a>
        <button type="submit" class="cds-btn cds-btn--primary">
            <span>Guardar cambios</span>
            <span class="material-symbols-outlined">check</span>
        </button>
    </div>
</form>
@endsection
