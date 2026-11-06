@extends('layouts.app')

@section('title', 'Inicio')
@section('header_title', 'Dashboard Principal')
@section('header_subtitle', 'Resumen general del sistema')

@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card p-5 text-center shadow-sm" style="border-radius: 12px; border: none;">
                <div class="mb-3">
                    <i class="bi bi-check-circle-fill" style="font-size: 3rem; color: #10b981;"></i>
                </div>
                <h3 style="font-weight: 700; color: #111827;">¡Plantilla Maestra Instalada!</h3>
                <p class="text-muted mt-2">
                    El esqueleto de la aplicación está funcionando correctamente.<br>
                    Podemos comenzar a construir las tablas de Contratos y Clientes aquí abajo.
                </p>
            </div>
        </div>
    </div>
@endsection