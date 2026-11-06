<!DOCTYPE html><html class="light" lang="es"><head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title>Login - Weitel</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "on-primary-fixed": "#1b1c1c",
              "outline": "#747878",
              "surface-container-lowest": "#ffffff",
              "on-secondary-container": "#fffbff",
              "on-background": "#1a1c1c",
              "on-secondary": "#ffffff",
              "surface-variant": "#e2e2e2",
              "secondary": "#f15831",
              "surface-container-low": "#f3f3f4",
              "inverse-surface": "#2f3131",
              "surface-dim": "#dadada",
              "primary-container": "#1c4a75",
              "tertiary": "#100900",
              "surface-container-high": "#e8e8e8",
              "surface": "#f9f9f9",
              "on-primary-container": "#a9bdd3",
              "surface-container": "#eeeeee",
              "on-surface": "#1a1c1c",
              "error-container": "#ffdad6",
              "tertiary-fixed-dim": "#f8bd2a",
              "primary": "#123656",
              "on-secondary-fixed": "#3d1206",
              "primary-fixed-dim": "#c8c6c5",
              "on-surface-variant": "#444748",
              "on-error": "#ffffff",
              "tertiary-fixed": "#ffdfa0",
              "inverse-on-surface": "#f0f1f1",
              "error": "#ba1a1a",
              "on-tertiary-container": "#ae8100",
              "on-tertiary": "#ffffff",
              "on-error-container": "#93000a",
              "inverse-primary": "#c8c6c5",
              "on-tertiary-fixed-variant": "#5c4300",
              "on-primary-fixed-variant": "#474746",
              "outline-variant": "#c4c7c7",
              "on-tertiary-fixed": "#261a00",
              "surface-bright": "#f9f9f9",
              "surface-tint": "#123656",
              "on-secondary-fixed-variant": "#a3361a",
              "tertiary-container": "#2d1f00",
              "secondary-fixed": "#ffe0d6",
              "secondary-fixed-dim": "#ffb59e",
              "primary-fixed": "#e5e2e1",
              "surface-container-highest": "#e2e2e2",
              "secondary-container": "#d9441c",
              "on-primary": "#ffffff",
              "background": "#f9f9f9"
            },
            fontFamily: {
              "headline": ["Manrope"],
              "body": ["Inter"],
              "label": ["Inter"]
            },
            borderRadius: {"DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem"},
          },
        },
      }
    </script>
<style>
      .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
      }
      .ledger-line:focus-within {
        border-bottom: 2px solid #123656;
      }
      .gradient-button {
        background: linear-gradient(145deg, #f15831 0%, #d9441c 100%);
      }
    </style>
</head>
<body class="bg-surface font-body text-on-surface antialiased min-h-screen flex flex-col justify-center items-center">
<main class="w-full max-w-[440px] px-6">
<div class="bg-surface-container-lowest p-10 lg:p-14 rounded-xl shadow-[0_24px_48px_-12px_rgba(26,28,28,0.08)] flex flex-col items-center">
<div class="mb-12">
<img alt="Weitel logo" class="h-20 object-contain" src="{{ asset('img/logo_weitel.png') }}">
</div>
<header class="w-full mb-8 text-center">
<h1 class="font-headline font-extrabold text-2xl tracking-tight text-primary uppercase mb-2">Acceso al Sistema</h1>
<p class="text-on-surface-variant text-sm font-label tracking-wide uppercase opacity-70">Weitel Gestión de contratos</p>
</header>
<form class="w-full space-y-8" action="{{ route('login.post') }}" method="POST">
@csrf

@if ($errors->any())
<div class="bg-error-container text-on-error-container text-xs p-3 rounded-md mb-4 text-center font-bold">
    {{ $errors->first() }}
</div>
@endif

<div class="space-y-6">
<div class="relative group">
<label class="block font-label text-[10px] font-bold tracking-[0.1em] text-on-surface-variant uppercase mb-2" for="cedula">Número de Cédula</label>
<div class="bg-surface-container-high rounded-DEFAULT p-1 ledger-line transition-all duration-200">
<input class="w-full bg-transparent border-none focus:ring-0 text-primary py-3 px-4 font-body placeholder:text-outline-variant placeholder:font-normal" id="cedula" name="cedula" placeholder="Ej: 0987654321" type="text" maxlength="10" value="{{ old('cedula') }}" required autofocus>
</div>
</div>
</div>
<div class="pt-4">
<button class="gradient-button w-full text-on-secondary font-headline font-bold py-4 px-6 rounded-lg tracking-widest uppercase text-sm hover:opacity-90 transition-opacity duration-300 shadow-lg shadow-secondary/20" type="submit">
                        INICIAR SESIÓN
                    </button>
</div>
</form>
</div>
</main>
<footer class="fixed bottom-0 w-full flex flex-row justify-between items-center px-10 py-8 bg-[#f9f9f9]">
<div class="flex flex-col md:flex-row gap-6 items-center">
<span class="font-['Manrope'] font-bold text-[#123656] text-sm tracking-tighter">Weitel</span>
<p class="font-['Inter'] text-[10px] tracking-[0.05em] uppercase text-[#1c4a75] opacity-60">© 2026 Weitel Sistema de contratos.</p>
</div>
</footer>
</body></html>
