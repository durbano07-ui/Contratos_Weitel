<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Acceso Denegado — Weitel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f9f9f9; }
        h1, h2 { font-family: 'Manrope', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#f9f9f9] to-[#e8e8e8]">
    <div class="text-center max-w-md mx-auto px-6">

        <!-- Ícono grande -->
        <div class="w-24 h-24 rounded-2xl bg-[#212121] flex items-center justify-center mx-auto mb-8 shadow-2xl shadow-black/20">
            <span class="material-symbols-outlined text-white" style="font-size:48px; font-variation-settings: 'FILL' 1, 'wght' 400;">lock</span>
        </div>

        <!-- Código de error -->
        <p class="text-[11px] font-bold uppercase tracking-[0.3em] text-[#b6171e] mb-2">Error 403 — Acceso Denegado</p>

        <!-- Título -->
        <h1 class="text-4xl font-extrabold tracking-tight text-[#0a0a0a] mb-3">
            Sin permiso
        </h1>

        <!-- Descripción -->
        <p class="text-[#444748] text-sm leading-relaxed mb-8">
            Tu rol <strong class="text-[#0a0a0a]">Administrativo</strong> no tiene acceso a esta sección del sistema.<br>
            Si crees que esto es un error, contacta al <strong class="text-[#0a0a0a]">Administrador del sistema</strong>.
        </p>

        <!-- Acciones -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('contracts.index') }}"
               class="inline-flex items-center justify-center space-x-2 px-6 py-3 bg-[#0a0a0a] text-white rounded-lg text-sm font-semibold hover:bg-[#b6171e] transition-all duration-300 shadow-lg">
                <span class="material-symbols-outlined" style="font-size:18px">arrow_back</span>
                <span>Volver atrás</span>
            </a>
            <a href="{{ route('contracts.index') }}"
               class="inline-flex items-center justify-center space-x-2 px-6 py-3 bg-[#eeeeee] text-[#0a0a0a] rounded-lg text-sm font-semibold hover:bg-[#e2e2e2] transition-all duration-300">
                <span class="material-symbols-outlined" style="font-size:18px">home</span>
                <span>Ir a Contratos</span>
            </a>
        </div>

        <!-- Footer info -->
        <p class="mt-10 text-[11px] text-[#747878]">Weitel · Sistema de Contratos</p>
    </div>
</body>
</html>
