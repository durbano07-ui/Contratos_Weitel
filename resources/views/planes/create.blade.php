@extends('layouts.app')

@section('header_title', 'Nuevo plan de internet')
@section('header_subtitle', 'Registrar un nuevo plan en el catálogo')

@section('content')
<form action="{{ route('planes.store') }}" method="POST" class="cds-form max-w-3xl">
    @csrf
    @include('planes._form')
    <div class="cds-form-actions">
        <a href="{{ route('planes.index') }}" class="cds-btn cds-btn--secondary">Cancelar</a>
        <button type="submit" class="cds-btn cds-btn--primary">
            <span>Guardar plan</span>
            <span class="material-symbols-outlined">check</span>
        </button>
    </div>
</form>
@endsection
