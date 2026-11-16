@extends('layouts.app')

@section('header_title', 'Agregar personal')
@section('header_subtitle', 'Registro de un nuevo usuario en el sistema')

@section('content')
<form action="{{ route('personal.store') }}" method="POST" class="cds-form max-w-3xl">
    @csrf
    @include('personal._form')
    <div class="cds-form-actions">
        <a href="{{ route('personal.index') }}" class="cds-btn cds-btn--secondary">Cancelar</a>
        <button type="submit" class="cds-btn cds-btn--primary">
            <span>Guardar personal</span>
            <span class="material-symbols-outlined">check</span>
        </button>
    </div>
</form>
@endsection
