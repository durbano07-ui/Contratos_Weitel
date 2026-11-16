@extends('layouts.app')

@section('header_title', 'Nuevo equipo')
@section('header_subtitle', 'Registrar equipo o material técnico en el inventario')

@section('content')
<form action="{{ route('equipos.store') }}" method="POST" class="cds-form max-w-3xl">
    @csrf
    @include('equipos._form')
    <div class="cds-form-actions">
        <a href="{{ route('equipos.index') }}" class="cds-btn cds-btn--secondary">Cancelar</a>
        <button type="submit" class="cds-btn cds-btn--primary">
            <span>Registrar equipo</span>
            <span class="material-symbols-outlined">check</span>
        </button>
    </div>
</form>
@endsection
