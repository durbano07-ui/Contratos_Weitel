<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Acceso Denegado — Weitel</title>
    {{-- Favicon Weitel --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}?v=1" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=1">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}?v=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        /* IBM Carbon Design System — tema Gray 10, color interactivo = azul Weitel */
        body { font-family: 'IBM Plex Sans', 'Helvetica Neue', Arial, sans-serif; background: #f4f4f4; color: #161616; -webkit-font-smoothing: antialiased; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; font-size: 20px; }
        .cds-btn { display: inline-flex; align-items: center; justify-content: space-between; gap: 2rem; min-height: 3rem; padding: 0 1rem; font-size: .875rem; letter-spacing: .16px; text-decoration: none; transition: background-color 70ms cubic-bezier(0,0,.38,.9); }
        .cds-btn--primary { background: #123656; color: #fff; }
        .cds-btn--primary:hover { background: #1c4a75; }
        .cds-btn--secondary { background: #393939; color: #fff; }
        .cds-btn--secondary:hover { background: #474747; }
        .cds-btn:focus-visible { outline: 2px solid #0f62fe; outline-offset: -2px; box-shadow: inset 0 0 0 3px #fff; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4">
    @php
        $usuario = auth()->user();
        $rolTxt = $usuario ? ($usuario->isAdministrador() ? 'Administrador' : ($usuario->isTecnico() ? 'Técnico' : 'Administrativo')) : null;
        $inicio = $usuario && $usuario->isTecnico() ? route('tecnico.index') : route('contracts.index');
        $anterior = url()->previous() !== url()->current() ? url()->previous() : $inicio;
    @endphp
    <main class="w-full max-w-lg bg-white p-8 border border-[#e0e0e0] rounded">
        <img alt="Weitel" class="h-16 w-auto object-contain mb-8" src="{{ asset('img/logo_weitel.png') }}">

        <p class="text-sm text-[#525252] tracking-[.16px] flex items-center gap-2">
            <span class="material-symbols-outlined text-[#da1e28]" aria-hidden="true">lock</span>
            Error 403 · Acceso denegado
        </p>
        <h1 class="mt-2 text-[2rem] leading-10 font-light">No tienes permiso para ver esta página</h1>

        <p class="mt-4 text-sm leading-5 tracking-[.16px] text-[#525252]">
            @if($rolTxt)
                Tu rol <strong class="font-semibold text-[#161616]">{{ $rolTxt }}</strong> no tiene acceso a esta sección del sistema.
            @else
                No tienes acceso a esta sección del sistema.
            @endif
            Si crees que es un error, contacta al administrador del sistema.
        </p>

        <div class="mt-8 flex flex-col sm:flex-row gap-2">
            <a href="{{ $anterior }}" class="cds-btn cds-btn--secondary sm:flex-1">
                <span>Volver atrás</span>
                <span class="material-symbols-outlined" aria-hidden="true">arrow_back</span>
            </a>
            <a href="{{ $inicio }}" class="cds-btn cds-btn--primary sm:flex-1">
                <span>Ir al inicio</span>
                <span class="material-symbols-outlined" aria-hidden="true">home</span>
            </a>
        </div>
    </main>
</body>
</html>
