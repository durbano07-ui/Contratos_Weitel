<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Sistema de Contratos')</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "secondary": "#b6171e",
                        "tertiary-container": "#2d1f00",
                        "on-surface": "#1a1c1c",
                        "outline": "#747878",
                        "on-primary": "#ffffff",
                        "primary-fixed": "#e5e2e1",
                        "surface-dim": "#dadada",
                        "inverse-surface": "#2f3131",
                        "error": "#ba1a1a",
                        "outline-variant": "#c4c7c7",
                        "on-primary-fixed": "#1b1c1c",
                        "on-secondary-fixed-variant": "#930010",
                        "surface-container-highest": "#e2e2e2",
                        "on-background": "#1a1c1c",
                        "tertiary": "#100900",
                        "on-primary-fixed-variant": "#474746",
                        "on-tertiary-container": "#ae8100",
                        "primary": "#0a0a0a",
                        "surface-container-low": "#f3f3f4",
                        "surface-tint": "#5f5e5e",
                        "on-tertiary-fixed": "#261a00",
                        "inverse-on-surface": "#f0f1f1",
                        "inverse-primary": "#c8c6c5",
                        "on-secondary-container": "#fffbff",
                        "surface": "#f9f9f9",
                        "on-surface-variant": "#444748",
                        "on-secondary-fixed": "#410003",
                        "primary-container": "#212121",
                        "surface-bright": "#f9f9f9",
                        "background": "#f9f9f9",
                        "primary-fixed-dim": "#c8c6c5",
                        "on-tertiary": "#ffffff",
                        "secondary-container": "#da3433",
                        "tertiary-fixed": "#ffdfa0",
                        "on-primary-container": "#898888",
                        "on-error": "#ffffff",
                        "on-secondary": "#ffffff",
                        "error-container": "#ffdad6",
                        "on-tertiary-fixed-variant": "#5c4300",
                        "surface-variant": "#e2e2e2",
                        "surface-container-high": "#e8e8e8",
                        "secondary-fixed": "#ffdad6",
                        "tertiary-fixed-dim": "#f8bd2a",
                        "surface-container-lowest": "#ffffff",
                        "surface-container": "#eeeeee",
                        "on-error-container": "#93000a",
                        "secondary-fixed-dim": "#ffb3ac"
                    },
                    fontFamily: {
                        "headline": ["Manrope"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    },
                    borderRadius: { "DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem" },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        /* Normalizacion Uniforme de Iconos */
        aside .material-symbols-outlined { font-size: 24px !important; }
        header .material-symbols-outlined { font-size: 22px !important; }
        button .material-symbols-outlined { font-size: 18px !important; }
        table .material-symbols-outlined { font-size: 20px !important; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9f9f9;
        }
        h1, h2, h3 {
            font-family: 'Manrope', sans-serif;
        }
        .sidebar-active {
            background-color: #b6171e;
            color: white;
            border-radius: 0.25rem;
        }

        /* Separador de sección en sidebar */
        .sidebar-section-label {
            font-size: 9px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #747878;
            padding: 0 0.75rem;
            margin-top: 1rem;
            margin-bottom: 0.25rem;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
        }

        /* ============================================
           RESPONSIVE SIDEBAR - MÓVIL
        ============================================ */
        #sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(10,10,10,0.45);
            z-index: 40;
            backdrop-filter: blur(2px);
        }
        #sidebar-overlay.visible { display: block; }

        @media (max-width: 1023px) {
            /* Sidebar: oculto a la izquierda por defecto en móvil */
            aside#main-sidebar {
                transform: translateX(-100%);
                transition: transform 0.28s cubic-bezier(0.4,0,0.2,1);
                z-index: 50;
            }
            aside#main-sidebar.open {
                transform: translateX(0);
            }

            /* Header y main: sin margen izquierdo en móvil */
            header#main-header {
                margin-left: 0 !important;
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            main#main-content {
                margin-left: 0 !important;
                padding: 1.25rem 1rem !important;
            }
        }

        /* Botón hamburguesa */
        #hamburger-btn {
            display: none;
            align-items: center;
            justify-content: center;
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 0.375rem;
            background: #f3f3f4;
            border: 1px solid #c4c7c7;
            cursor: pointer;
            flex-shrink: 0;
        }
        #hamburger-btn .material-symbols-outlined { font-size: 20px !important; }
        @media (max-width: 1023px) {
            #hamburger-btn { display: flex; }
        }

        /* Barra de búsqueda: ocultar en móvil para ahorrar espacio */
        @media (max-width: 767px) {
            .search-bar-wrap { display: none; }
        }
    </style>
    @stack('styles')
</head>
<body class="text-on-surface">

    <!-- Overlay para cerrar sidebar en móvil -->
    <div id="sidebar-overlay" onclick="closeSidebar()"></div>

    <!-- SideNavBar -->
    <aside id="main-sidebar" class="fixed left-0 top-0 h-full w-64 flex flex-col p-6 space-y-2 bg-[#f9f9f9] dark:bg-[#0a0a0a] z-50">
        <div class="flex items-center space-x-3 mb-4">
            <img alt="Weitel Logo" class="h-12 w-auto object-contain" src="{{ asset('img/logo_weitel.png') }}"/>
        </div>

        <nav class="flex-1 flex flex-col space-y-1 overflow-y-auto">
            @if(Auth::user()->isTecnico())
                <p class="sidebar-section-label">Técnico</p>
                <a class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-300 {{ request()->routeIs('tecnico.*') ? 'bg-[#b6171e] text-white' : 'text-[#0a0a0a] dark:text-[#f3f3f4] opacity-80 hover:bg-[#b6171e] hover:text-white' }}" href="{{ route('tecnico.index') }}">
                    <span class="material-symbols-outlined" {!! request()->routeIs('tecnico.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>handyman</span>
                    <span class="font-label text-sm uppercase tracking-wider">Mis Instalaciones</span>
                </a>
            @else
                <p class="sidebar-section-label">Gestión</p>
                <a class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-300 {{ request()->routeIs('contracts.*') ? 'bg-[#b6171e] text-white' : 'text-[#0a0a0a] dark:text-[#f3f3f4] opacity-80 hover:bg-[#b6171e] hover:text-white' }}" href="{{ route('contracts.index') }}">
                    <span class="material-symbols-outlined" {!! request()->routeIs('contracts.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>description</span>
                    <span class="font-label text-sm uppercase tracking-wider">Contratos</span>
                </a>
                <a class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-300 {{ request()->routeIs('clientes.*') ? 'bg-[#b6171e] text-white' : 'text-[#0a0a0a] dark:text-[#f3f3f4] opacity-80 hover:bg-[#b6171e] hover:text-white' }}" href="{{ route('clientes.index') }}">
                    <span class="material-symbols-outlined" {!! request()->routeIs('clientes.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>group</span>
                    <span class="font-label text-sm uppercase tracking-wider">Clientes</span>
                </a>

                @if(Auth::user()->isAdministrador())
                    <p class="sidebar-section-label mt-4">Administración</p>
                    <a class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-300 {{ request()->routeIs('personal.*') ? 'bg-[#b6171e] text-white' : 'text-[#0a0a0a] dark:text-[#f3f3f4] opacity-80 hover:bg-[#b6171e] hover:text-white' }}" href="{{ route('personal.index') }}">
                        <span class="material-symbols-outlined" {!! request()->routeIs('personal.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>badge</span>
                        <span class="font-label text-sm uppercase tracking-wider">Personal</span>
                    </a>
                    <a class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-300 {{ request()->routeIs('planes.*') ? 'bg-[#b6171e] text-white' : 'text-[#0a0a0a] dark:text-[#f3f3f4] opacity-80 hover:bg-[#b6171e] hover:text-white' }}" href="{{ route('planes.index') }}">
                        <span class="material-symbols-outlined" {!! request()->routeIs('planes.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>wifi</span>
                        <span class="font-label text-sm uppercase tracking-wider">Planes</span>
                    </a>
                    <a class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-300 {{ request()->routeIs('duraciones.*') ? 'bg-[#b6171e] text-white' : 'text-[#0a0a0a] dark:text-[#f3f3f4] opacity-80 hover:bg-[#b6171e] hover:text-white' }}" href="{{ route('duraciones.index') }}">
                        <span class="material-symbols-outlined" {!! request()->routeIs('duraciones.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>event_repeat</span>
                        <span class="font-label text-sm uppercase tracking-wider">Duraciones</span>
                    </a>
                    <a class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-300 {{ request()->routeIs('extensiones.*') ? 'bg-[#b6171e] text-white' : 'text-[#0a0a0a] dark:text-[#f3f3f4] opacity-80 hover:bg-[#b6171e] hover:text-white' }}" href="{{ route('extensiones.index') }}">
                        <span class="material-symbols-outlined" {!! request()->routeIs('extensiones.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>alternate_email</span>
                        <span class="font-label text-sm uppercase tracking-wider">Extensiones Email</span>
                    </a>
                    <a class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-300 {{ request()->routeIs('equipos.*') ? 'bg-[#b6171e] text-white' : 'text-[#0a0a0a] dark:text-[#f3f3f4] opacity-80 hover:bg-[#b6171e] hover:text-white' }}" href="{{ route('equipos.index') }}">
                        <span class="material-symbols-outlined" {!! request()->routeIs('equipos.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>inventory_2</span>
                        <span class="font-label text-sm uppercase tracking-wider">Inventario</span>
                    </a>
                    <p class="sidebar-section-label mt-4">Sistema</p>
                    <a class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-300 {{ request()->routeIs('auditoria.*') ? 'bg-[#b6171e] text-white' : 'text-[#0a0a0a] dark:text-[#f3f3f4] opacity-80 hover:bg-[#b6171e] hover:text-white' }}" href="{{ route('auditoria.index') }}">
                        <span class="material-symbols-outlined" {!! request()->routeIs('auditoria.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>analytics</span>
                        <span class="font-label text-sm uppercase tracking-wider">Auditoría</span>
                    </a>
                @endif
            @endif
        </nav>

        <!-- User info + Logout -->
        <div class="mt-auto pt-4 border-t border-outline-variant/30">
            <!-- Badge de rol -->
            <div class="flex items-center space-x-2 px-3 py-2 mb-2">
                <div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center font-bold text-[11px] text-on-primary-container shrink-0">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-primary truncate">{{ Auth::user()->name }}</p>
                    @if(Auth::user()->isAdministrador())
                        <span class="inline-block px-2 py-0.5 bg-secondary text-white text-[9px] font-bold uppercase tracking-wider rounded-full">Administrador</span>
                    @elseif(Auth::user()->isTecnico())
                        <span class="inline-block px-2 py-0.5 bg-amber-500 text-white text-[9px] font-bold uppercase tracking-wider rounded-full">Técnico</span>
                    @else
                        <span class="inline-block px-2 py-0.5 bg-surface-container-high text-on-surface-variant text-[9px] font-bold uppercase tracking-wider rounded-full">Administrativo</span>
                    @endif
                </div>
            </div>
            <a class="flex items-center space-x-3 p-3 text-[#0a0a0a] dark:text-[#f3f3f4] opacity-80 hover:bg-[#b6171e] hover:text-white rounded-lg transition-all duration-300" href="{{ route('logout') }}">
                <span class="material-symbols-outlined" data-icon="logout">logout</span>
                <span class="font-label text-sm uppercase tracking-wider">Cerrar Sesión</span>
            </a>
        </div>
    </aside>

    <!-- TopAppBar -->
    <header id="main-header" class="ml-64 flex justify-between items-center px-10 py-6 bg-[#f9f9f9]/85 backdrop-blur-md sticky top-0 z-40">
        <div class="flex items-center gap-3">
            <!-- Hamburger en móvil -->
            <button id="hamburger-btn" onclick="openSidebar()" aria-label="Abrir menú">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <div>
                <h1 class="text-xl lg:text-2xl font-bold font-headline tracking-tight text-primary leading-tight">@yield('header_title', 'Contratos Administrativos')</h1>
                <p class="text-[11px] font-body text-on-surface-variant hidden sm:block">@yield('header_subtitle', 'Gestión de Suministros')</p>
            </div>
        </div>
        <div class="flex items-center space-x-3 lg:space-x-6">
            @yield('top_actions')

            <div class="relative search-bar-wrap">
                <input class="bg-surface-container-high border-none rounded-lg px-4 py-2 text-sm w-64 focus:ring-0 focus:border-b-2 focus:border-primary transition-all" placeholder="Buscar contrato o cliente..." type="text"/>
                <span class="material-symbols-outlined absolute right-3 top-2 text-outline text-sm" data-icon="search">search</span>
            </div>
            <div class="w-10 h-10 rounded-full bg-surface-container-highest border border-outline-variant flex items-center justify-center font-bold text-sm text-primary cursor-pointer select-none shadow-sm hover:bg-surface-variant transition-colors" title="{{ Auth::user()->name ?? 'Usuario' }}">
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
            </div>
        </div>
    </header>

    <!-- Main Content Canvas -->
    <main id="main-content" class="ml-64 p-10 space-y-8">
        @if(session('success'))
            <div class="flex items-center space-x-3 bg-green-50 border border-green-200 text-green-800 px-5 py-3 rounded-lg text-sm font-medium shadow-sm">
                <span class="material-symbols-outlined text-green-600" style="font-size:18px">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="flex items-center space-x-3 bg-red-50 border border-red-200 text-red-800 px-5 py-3 rounded-lg text-sm font-medium shadow-sm">
                <span class="material-symbols-outlined text-red-600" style="font-size:18px">error</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')

    <script>
        function openSidebar() {
            document.getElementById('main-sidebar').classList.add('open');
            document.getElementById('sidebar-overlay').classList.add('visible');
            document.body.style.overflow = 'hidden';
        }
        function closeSidebar() {
            document.getElementById('main-sidebar').classList.remove('open');
            document.getElementById('sidebar-overlay').classList.remove('visible');
            document.body.style.overflow = '';
        }
        // Cerrar con Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeSidebar();
        });
    </script>
</body>
</html>
