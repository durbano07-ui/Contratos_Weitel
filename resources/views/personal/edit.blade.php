@extends('layouts.app')

@section('header_title', 'Editar personal')
@section('header_subtitle', 'Modificación de datos de: ' . $persona->name)

@section('content')
<form action="{{ route('personal.update', $persona->id) }}" method="POST" class="cds-form max-w-3xl">
    @csrf
    @method('PUT')
    @include('personal._form', ['persona' => $persona])
    <div class="cds-form-actions">
        <a href="{{ route('personal.index') }}" class="cds-btn cds-btn--secondary">Cancelar</a>
        <button type="submit" class="cds-btn cds-btn--primary">
            <span>Guardar cambios</span>
            <span class="material-symbols-outlined">check</span>
        </button>
    </div>
</form>
@endsection
