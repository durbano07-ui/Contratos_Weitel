@extends('layouts.app')

@section('header_title', 'Editar plan')
@section('header_subtitle', 'Modificar datos del plan: ' . $plan->nombre_plan)

@section('content')
<form action="{{ route('planes.update', $plan->id_plan) }}" method="POST" class="cds-form max-w-3xl">
    @csrf
    @method('PUT')
    @include('planes._form', ['plan' => $plan])
    <div class="cds-form-actions">
        <a href="{{ route('planes.index', ['tipo' => $plan->id_tipo]) }}" class="cds-btn cds-btn--secondary">Cancelar</a>
        <button type="submit" class="cds-btn cds-btn--primary">
            <span>Guardar cambios</span>
            <span class="material-symbols-outlined">check</span>
        </button>
    </div>
</form>
@endsection
