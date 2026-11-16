<!DOCTYPE html>
<html class="light" lang="es">
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title>Login - Weitel</title>
    {{-- Favicon Weitel --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}?v=1" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=1">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}?v=1">
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;600&amp;family=IBM+Plex+Mono:wght@400&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
<style>
    /* IBM Carbon Design System — tema Gray 10, color interactivo = azul Weitel */
    :root {
        --cds-background: #f4f4f4; --cds-layer: #ffffff; --cds-field: #f4f4f4;
        --cds-border-subtle: #e0e0e0; --cds-border-strong: #8d8d8d;
        --cds-text-primary: #161616; --cds-text-secondary: #525252; --cds-text-placeholder: #a8a8a8;
        --cds-interactive: #123656; --cds-interactive-hover: #1c4a75; --cds-interactive-active: #0b2238; --cds-accent: #f15831;
        --cds-focus: #0f62fe; --cds-error: #da1e28;
    }
    body { font-family: 'IBM Plex Sans', 'Helvetica Neue', Arial, sans-serif; background: var(--cds-background); color: var(--cds-text-primary); -webkit-font-smoothing: antialiased; }
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; font-size: 20px; }
    .cds-label { display: block; font-size: .75rem; line-height: 1rem; letter-spacing: .32px; color: var(--cds-text-secondary); margin-bottom: .5rem; }
    input.cds-text-input {
        width: 100%; height: 3rem; padding: 0 1rem; background: var(--cds-field); border: 0;
        border-bottom: 1px solid var(--cds-border-strong); font-size: .875rem; letter-spacing: .16px;
        color: var(--cds-text-primary); outline: 2px solid transparent; outline-offset: -2px; font-family: 'IBM Plex Mono', monospace;
    }
    input.cds-text-input::placeholder { color: var(--cds-text-placeholder); font-family: 'IBM Plex Sans', sans-serif; }
    input.cds-text-input:focus { outline-color: var(--cds-focus); box-shadow: none; }
    input.cds-text-input[aria-invalid="true"] { outline-color: var(--cds-error); }
    .cds-btn-primary {
        display: flex; align-items: center; justify-content: space-between; width: 100%; min-height: 3rem;
        padding: 0 1rem; background: var(--cds-interactive); color: #fff; border: 0; font-size: .875rem;
        letter-spacing: .16px; cursor: pointer; transition: background-color 70ms cubic-bezier(0,0,.38,.9);
    }
    .cds-btn-primary:hover { background: var(--cds-interactive-hover); }
    .cds-btn-primary:active { background: var(--cds-interactive-active); }
    .cds-btn-primary:focus-visible { outline: 2px solid var(--cds-focus); outline-offset: -2px; box-shadow: inset 0 0 0 3px #fff; }
</style>
</head>
<body class="min-h-screen flex flex-col">

<main class="flex-1 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-[400px] bg-[#ffffff] px-8 pt-8 pb-10 border border-[#e0e0e0] rounded">
        <img alt="Weitel" class="h-20 w-auto object-contain mb-8" src="{{ asset('img/logo_weitel.png') }}">

        <h1 class="text-[2rem] leading-10 font-light text-[#161616]">Iniciar sesión</h1>
        <p class="mt-1 text-sm text-[#525252] tracking-[.16px]">Sistema de gestión de contratos</p>

        <hr class="my-8 border-[#e0e0e0]">

        <form action="{{ route('login.post') }}" method="POST" novalidate>
            @csrf

            <label class="cds-label" for="cedula">Número de cédula</label>
            <input class="cds-text-input" id="cedula" name="cedula" placeholder="Ej: 0987654321" type="text"
                   inputmode="numeric" maxlength="10" value="{{ old('cedula') }}" required autofocus autocomplete="username"
                   @if($errors->any()) aria-invalid="true" aria-describedby="cedula-error" @endif>

            @if ($errors->any())
                <p id="cedula-error" class="mt-1 flex items-center gap-1 text-xs tracking-[.32px] text-[#da1e28]">
                    <span class="material-symbols-outlined" aria-hidden="true" style="font-size:16px">error</span>
                    {{ $errors->first() }}
                </p>
            @endif

            <button class="cds-btn-primary mt-8" type="submit">
                <span>Continuar</span>
                <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
            </button>
        </form>
    </div>
</main>

<footer class="px-4 py-4 text-xs tracking-[.32px] text-[#525252] flex justify-between">
    <span>© {{ date('Y') }} Weitel · Sistema de contratos</span>
</footer>
</body>
</html>
