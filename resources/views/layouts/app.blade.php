<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    {{-- WCAG 2.4.2: cada página tiene un título propio (el de la vista o, si no define uno, su encabezado) --}}
    <title>{{ trim($__env->yieldContent('title')) ?: trim(strip_tags($__env->yieldContent('header_title', 'Sistema de Contratos'))) . ' | Weitel' }}</title>
    {{-- Favicon Weitel --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}?v=1" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=1">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}?v=1">
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;600;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script id="tailwind-config">
        // Tokens de IBM Carbon Design System (tema Gray 10), con el azul Weitel como color interactivo.
        // Los nombres de color se mantienen para que las vistas existentes sigan funcionando.
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        // Marca / interactivo
                        "secondary": "#123656",            // $interactive (azul Weitel)
                        "secondary-container": "#1c4a75",  // $button-primary-hover
                        "on-secondary": "#ffffff",
                        "on-secondary-container": "#ffffff",
                        "secondary-fixed": "#d6e4f0",
                        "secondary-fixed-dim": "#a9bdd3",
                        "on-secondary-fixed": "#0b2238",
                        "on-secondary-fixed-variant": "#1c4a75",
                        // Texto / iconos
                        "primary": "#161616",              // $text-primary (gray 100)
                        "on-primary": "#ffffff",
                        "primary-container": "#262626",    // gray 90
                        "on-primary-container": "#c6c6c6", // gray 30
                        "primary-fixed": "#e0e0e0",
                        "primary-fixed-dim": "#c6c6c6",
                        "on-primary-fixed": "#161616",
                        "on-primary-fixed-variant": "#393939",
                        "on-surface": "#161616",
                        "on-background": "#161616",
                        "on-surface-variant": "#525252",   // $text-secondary (gray 70)
                        "outline": "#8d8d8d",              // $border-strong (gray 50)
                        "outline-variant": "#e0e0e0",      // $border-subtle (gray 20)
                        // Superficies (g10: fondo gris, capas blancas)
                        "background": "#f4f4f4",           // $background (gray 10)
                        "surface": "#f4f4f4",
                        "surface-bright": "#ffffff",
                        "surface-dim": "#e0e0e0",
                        "surface-tint": "#161616",
                        "surface-container-lowest": "#ffffff", // $layer-01
                        "surface-container-low": "#f4f4f4",
                        "surface-container": "#e8e8e8",        // $layer-hover
                        "surface-container-high": "#e0e0e0",   // $layer-accent
                        "surface-container-highest": "#c6c6c6",
                        "surface-variant": "#e0e0e0",
                        "inverse-surface": "#393939",
                        "inverse-on-surface": "#f4f4f4",
                        "inverse-primary": "#c6c6c6",
                        // Estados
                        "error": "#da1e28",                // $support-error (red 60)
                        "on-error": "#ffffff",
                        "error-container": "#fff1f1",      // red 10
                        "on-error-container": "#a2191f",
                        "tertiary": "#161616",
                        "on-tertiary": "#ffffff",
                        "tertiary-container": "#302400",
                        "on-tertiary-container": "#8e6a00",
                        "tertiary-fixed": "#fcf4d6",       // yellow 10
                        "tertiary-fixed-dim": "#f1c21b",   // yellow 30
                        "on-tertiary-fixed": "#1c1500",
                        "on-tertiary-fixed-variant": "#483700",
                        "accent": "#f15831",               // naranja Weitel (indicadores de selección)
                        "focus": "#0f62fe"                 // $focus (blue 60)
                    },
                    fontFamily: {
                        "headline": ["IBM Plex Sans", "Helvetica Neue", "Arial", "sans-serif"],
                        "body": ["IBM Plex Sans", "Helvetica Neue", "Arial", "sans-serif"],
                        "label": ["IBM Plex Sans", "Helvetica Neue", "Arial", "sans-serif"],
                        "mono": ["IBM Plex Mono", "Menlo", "monospace"]
                    },
                    // Esquinas: "rounded" = 4 px (tarjetas); el resto de utilidades quedan rectas (campos y botones, como Carbon)
                    borderRadius: { "none": "0", "DEFAULT": "4px", "sm": "0", "md": "0", "lg": "0", "xl": "0", "2xl": "0", "3xl": "0", "full": "9999px" },
                },
            },
        }
    </script>
    <style>
        /* =====================================================
           IBM Carbon Design System — tokens y componentes base
           (tema Gray 10, color interactivo = azul Weitel)
           Clases reutilizables con prefijo cds-*
        ===================================================== */
        :root {
            --cds-background: #f4f4f4;
            --cds-layer: #ffffff;
            --cds-layer-hover: #e8e8e8;
            --cds-layer-accent: #e0e0e0;
            --cds-field: #f4f4f4;            /* $field-02: campos sobre capas blancas */
            --cds-border-subtle: #e0e0e0;
            --cds-border-strong: #8d8d8d;
            --cds-text-primary: #161616;
            --cds-text-secondary: #525252;
            --cds-text-placeholder: #6f6f6f;   /* más oscuro que Carbon (#a8a8a8) para cumplir WCAG 1.4.3 */
            --cds-interactive: #123656;
            --cds-interactive-hover: #1c4a75;
            --cds-interactive-active: #0b2238;
            --cds-accent: #f15831;             /* naranja Weitel: indicadores de selección */
            --cds-focus: #0f62fe;
            --cds-shell-bg: #161616;
            --cds-shell-hover: #2c2c2c;
            --cds-shell-text: #f4f4f4;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        /* Normalización de iconos */
        aside .material-symbols-outlined { font-size: 20px !important; }
        header .material-symbols-outlined { font-size: 20px !important; }
        button .material-symbols-outlined { font-size: 18px !important; }
        table .material-symbols-outlined { font-size: 20px !important; }

        body {
            font-family: 'IBM Plex Sans', 'Helvetica Neue', Arial, sans-serif;
            background-color: var(--cds-background);
            color: var(--cds-text-primary);
            -webkit-font-smoothing: antialiased;
        }
        h1, h2, h3, h4 { font-family: 'IBM Plex Sans', 'Helvetica Neue', Arial, sans-serif; }

        /* WCAG 2.4.11: el foco no debe quedar tapado por los pies fijos de los formularios */
        html { scroll-padding-bottom: 6rem; scroll-padding-top: 1rem; }

        /* WCAG 2.4.1: enlace para saltar el menú (visible solo al recibir foco) */
        .cds-skip-link { position: absolute; left: -9999px; top: 0; z-index: 100; background: var(--cds-interactive); color: #fff; padding: .75rem 1rem; font-size: .875rem; }
        .cds-skip-link:focus { left: 1rem; top: 1rem; outline: 2px solid var(--cds-focus); outline-offset: 2px; }

        /* Foco accesible estilo Carbon (solo con teclado) */
        a:focus-visible, button:focus-visible, summary:focus-visible, [role="tab"]:focus-visible {
            outline: 2px solid var(--cds-focus);
            outline-offset: -2px;
        }

        /* ---------- Menú de usuario (encabezado de página) ---------- */
        .cds-user-trigger { display: flex; align-items: center; gap: .75rem; min-height: 3rem; padding: .25rem .75rem; cursor: pointer; user-select: none; }
        .cds-user-trigger:hover { background: var(--cds-layer-hover); }
        .cds-icon-action { flex-shrink: 0; height: 2.5rem; width: 2.5rem; display: inline-flex; align-items: center; justify-content: center; color: var(--cds-text-primary); background: transparent; border: 0; cursor: pointer; }
        .cds-icon-action:hover { background: var(--cds-layer-hover); }

        /* ---------- UI Shell: menú lateral ---------- */
        #main-sidebar {
            position: fixed; top: 0; left: 0; bottom: 0; width: 16rem;
            background: var(--cds-layer); border-right: 1px solid var(--cds-border-subtle);
            display: flex; flex-direction: column; z-index: 50;
        }
        .sidebar-section-label {
            font-size: .75rem; line-height: 1rem; letter-spacing: .32px;
            color: #6f6f6f; padding: 0 1rem; margin: 1rem 0 .25rem; font-weight: 400;
        }
        .cds-nav-link {
            position: relative; display: flex; align-items: center; gap: .75rem;
            min-height: 2.5rem; padding: 0 1rem; font-size: .875rem; line-height: 1.125rem;
            font-weight: 600; color: var(--cds-text-secondary); text-decoration: none;
            transition: background-color 110ms cubic-bezier(.2,0,.38,.9), color 110ms;
        }
        .cds-nav-link:hover { background: var(--cds-layer-hover); color: var(--cds-text-primary); }
        .cds-nav-link.is-active { background: var(--cds-layer-accent); color: var(--cds-text-primary); }
        .cds-nav-link.is-active::before {
            content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 3px; background: var(--cds-accent);
        }
        .cds-nav-link.is-active .material-symbols-outlined { color: var(--cds-accent); }

        /* ---------- Encabezado de página ---------- */
        .cds-page-header { padding: 2rem 2rem 0; }
        .cds-page-title { font-size: 1.75rem; line-height: 2.25rem; font-weight: 400; color: var(--cds-text-primary); }
        .cds-page-subtitle { font-size: .875rem; line-height: 1.25rem; letter-spacing: .16px; color: var(--cds-text-secondary); margin-top: .25rem; }
        .cds-section-title { font-size: 1.25rem; line-height: 1.75rem; font-weight: 400; color: var(--cds-text-primary); }
        .cds-label-01 { font-size: .75rem; line-height: 1rem; letter-spacing: .32px; color: var(--cds-text-secondary); }

        /* ---------- Botones ---------- */
        .cds-btn {
            display: inline-flex; align-items: center; justify-content: space-between; gap: 2rem;
            min-height: 3rem; padding: 0 1rem; font-size: .875rem; line-height: 1.125rem;
            letter-spacing: .16px; font-weight: 400; border: 1px solid transparent; cursor: pointer;
            text-decoration: none; white-space: nowrap;
            transition: background-color 70ms cubic-bezier(0,0,.38,.9), border-color 70ms, color 70ms;
        }
        .cds-btn .material-symbols-outlined { font-size: 20px !important; }
        .cds-btn--sm { min-height: 2rem; }
        .cds-btn--md { min-height: 2.5rem; }
        .cds-btn--primary { background: var(--cds-interactive); color: #fff; }
        .cds-btn--primary:hover { background: var(--cds-interactive-hover); }
        .cds-btn--primary:active { background: var(--cds-interactive-active); }
        .cds-btn--secondary { background: #393939; color: #fff; }
        .cds-btn--secondary:hover { background: #474747; }
        .cds-btn--tertiary { background: transparent; color: var(--cds-interactive); border-color: var(--cds-interactive); }
        .cds-btn--tertiary:hover { background: var(--cds-interactive-hover); color: #fff; }
        .cds-btn--ghost { background: transparent; color: var(--cds-text-primary); }
        .cds-btn--ghost:hover { background: var(--cds-layer-hover); }
        .cds-btn--icon { justify-content: center; gap: 0; padding: 0; width: 2.5rem; min-height: 2.5rem; }
        .cds-btn--danger { background: #da1e28; color: #fff; }
        .cds-btn--danger:hover { background: #b81921; }
        .cds-btn--danger:active { background: #750e13; }
        .cds-btn--danger-ghost { background: transparent; color: var(--cds-text-primary); }
        .cds-btn--danger-ghost:hover { background: #da1e28; color: #fff; }

        /* ---------- Etiquetas (tags) ---------- */
        /* Etiquetas (Carbon tag) — regla única en todo el sistema:
           verde = correcto/activo · rojo = problema/atención · amarillo = pendiente · gris = información neutra */
        .cds-tag {
            display: inline-flex; align-items: center; min-height: 1.5rem; padding: 0 .5rem;
            border-radius: 9999px; font-size: .75rem; line-height: 1rem; letter-spacing: .32px;
            font-weight: 400; white-space: nowrap; background: #e0e0e0; color: #161616;
        }
        .cds-tag--gray   { background: #e0e0e0; color: #161616; }
        .cds-tag--green  { background: #a7f0ba; color: #0e6027; }
        .cds-tag--red    { background: #ffd7d9; color: #a2191f; }
        .cds-tag--yellow { background: #fcf4d6; color: #483700; }

        /* ---------- Pestañas (line tabs) ---------- */
        .cds-tabs { display: flex; overflow-x: auto; overflow-y: hidden; }
        .cds-tab {
            display: inline-flex; align-items: center; gap: .5rem; height: 3rem; padding: 0 1rem;
            min-width: 10rem; border-bottom: 2px solid var(--cds-border-subtle);
            font-size: .875rem; line-height: 1.125rem; letter-spacing: .16px;
            color: var(--cds-text-secondary); text-decoration: none; white-space: nowrap;
            transition: border-color 110ms, color 110ms;
        }
        .cds-tab:hover { color: var(--cds-text-primary); border-bottom-color: var(--cds-border-strong); }
        .cds-tab.is-active { color: var(--cds-text-primary); font-weight: 600; border-bottom: 3px solid var(--cds-accent); }
        .cds-tab.is-active .material-symbols-outlined { color: var(--cds-accent); }
        .cds-tabs + .cds-card { border-top-left-radius: 0; }

        /* ---------- Tablas de datos ---------- */
        .cds-table { width: 100%; border-collapse: collapse; background: var(--cds-layer); font-size: .875rem; line-height: 1.25rem; letter-spacing: .16px; }
        .cds-table thead th { background: var(--cds-layer-accent); color: var(--cds-text-primary); font-weight: 600; text-align: left; height: 3rem; padding: 0 1rem; }
        .cds-table tbody td { height: 3rem; padding: .5rem 1rem; border-top: 1px solid var(--cds-border-subtle); color: var(--cds-text-secondary); vertical-align: middle; }
        .cds-table tbody tr:hover td { background: var(--cds-layer-hover); color: var(--cds-text-primary); }
        .cds-table .cds-cell-strong { color: var(--cds-text-primary); }
        /* Los recuadros con desplazamiento deben "atrapar" a los elementos absolutos (p. ej. .sr-only de los encabezados);
           sin position: relative, esos elementos estiran toda la página en celular. */
        .overflow-x-auto { position: relative; }
        .cds-table-toolbar { display: flex; align-items: center; justify-content: space-between; gap: 1rem; background: var(--cds-layer); padding: 1rem; }

        /* ---------- Paginación (enlaces de Laravel) ---------- */
        .cds-pagination { background: var(--cds-layer); border-top: 1px solid var(--cds-border-subtle); padding: 0 1rem; min-height: 3rem; display: flex; align-items: center; }
        .cds-pagination nav[role="navigation"] { display: flex; align-items: center; justify-content: space-between; width: 100%; }
        .cds-pagination nav[role="navigation"] > div:first-child { display: none; }
        .cds-pagination nav[role="navigation"] > div:last-child { display: flex; align-items: center; justify-content: space-between; width: 100%; gap: 1rem; flex-wrap: wrap; }
        .cds-pagination nav[role="navigation"] p { font-size: .875rem; color: var(--cds-text-secondary); }
        .cds-pagination nav[role="navigation"] p span { font-weight: 400 !important; }
        .cds-pagination nav[role="navigation"] span.relative.z-0 { box-shadow: none !important; display: inline-flex; }
        .cds-pagination nav[role="navigation"] a,
        .cds-pagination nav[role="navigation"] span.relative.inline-flex {
            min-width: 2.5rem; height: 2.5rem; display: inline-flex; align-items: center; justify-content: center;
            padding: 0 .75rem; margin: 0; border: 0 !important; border-radius: 0 !important; background: transparent;
            font-size: .875rem; color: var(--cds-text-primary); font-weight: 400;
        }
        .cds-pagination nav[role="navigation"] a:hover { background: var(--cds-layer-hover); }
        .cds-pagination nav[role="navigation"] span[aria-current="page"] > span {
            background: transparent !important; color: var(--cds-text-primary) !important; font-weight: 600 !important;
            box-shadow: inset 0 -3px 0 var(--cds-accent);
        }
        .cds-pagination nav[role="navigation"] span[aria-disabled="true"] > span { color: #c6c6c6 !important; }
        .cds-pagination nav[role="navigation"] svg { height: 1rem; width: 1rem; }

        /* ---------- Búsqueda ---------- */
        .cds-search { position: relative; }
        .cds-search .material-symbols-outlined { position: absolute; left: .75rem; top: 50%; transform: translateY(-50%); font-size: 18px !important; color: var(--cds-text-secondary); pointer-events: none; }
        .cds-search input[type] {
            height: 2.5rem; width: 18rem; max-width: 100%; padding: 0 1rem 0 2.5rem; background: var(--cds-background);
            border: 0; border-bottom: 1px solid var(--cds-border-strong); font-size: .875rem; letter-spacing: .16px;
            color: var(--cds-text-primary); outline: 2px solid transparent; outline-offset: -2px;
        }
        .cds-search input::placeholder { color: var(--cds-text-placeholder); }
        .cds-search input[type]:focus { outline-color: var(--cds-focus); box-shadow: none; }

        /* ---------- Listas desplegables ---------- */
        .cds-select {
            height: 2.5rem; padding: 0 2.5rem 0 1rem; background-color: var(--cds-background);
            border: 0; border-bottom: 1px solid var(--cds-border-strong); border-radius: 0;
            font-size: .875rem; letter-spacing: .16px; color: var(--cds-text-primary);
            outline: 2px solid transparent; outline-offset: -2px; cursor: pointer;
        }
        .cds-select:focus { outline-color: var(--cds-focus); box-shadow: none; border-bottom-color: var(--cds-border-strong); }

        /* ---------- Tarjetas (estilo "expresivo" de IBM: borde fino, esquinas de 4 px, separadas 16 px) ---------- */
        :root { --cds-radius: 4px; }
        .cds-tile { background: var(--cds-layer); padding: 1rem; border: 1px solid var(--cds-border-subtle); border-radius: var(--cds-radius); }
        .cds-card { background: var(--cds-layer); border: 1px solid var(--cds-border-subtle); border-radius: var(--cds-radius); overflow: hidden; }
        .cds-card .cds-table-toolbar, .cds-card .cds-pagination { background: transparent; }

        /* ---------- Formularios ---------- */
        .cds-form { background: var(--cds-layer); padding: 2rem; border: 1px solid var(--cds-border-subtle); border-radius: var(--cds-radius); }
        .cds-form-section + .cds-form-section { margin-top: 2.5rem; padding-top: 2rem; border-top: 1px solid var(--cds-border-subtle); }
        .cds-form-section-title { font-size: 1.25rem; line-height: 1.75rem; font-weight: 400; color: var(--cds-text-primary); }
        .cds-form-section-desc { font-size: .875rem; line-height: 1.25rem; letter-spacing: .16px; color: var(--cds-text-secondary); margin-top: .25rem; }
        .cds-label { display: block; font-size: .75rem; line-height: 1rem; letter-spacing: .32px; color: var(--cds-text-secondary); margin-bottom: .5rem; }
        .cds-label .cds-optional { color: #6f6f6f; }
        .cds-helper { font-size: .75rem; line-height: 1rem; letter-spacing: .32px; color: #6f6f6f; margin-top: .25rem; }
        .cds-error-msg { display: flex; align-items: flex-start; gap: .25rem; font-size: .75rem; line-height: 1rem; letter-spacing: .32px; color: #da1e28; margin-top: .25rem; }

        /* Selectores con "input."/"select." para ganarle al plugin de formularios de Tailwind */
        input.cds-text-input, textarea.cds-textarea, select.cds-select--field {
            width: 100%; background: var(--cds-field); border: 0; border-bottom: 1px solid var(--cds-border-strong);
            border-radius: 0; color: var(--cds-text-primary); font-size: .875rem; letter-spacing: .16px;
            outline: 2px solid transparent; outline-offset: -2px; box-shadow: none;
            transition: outline-color 70ms cubic-bezier(.2,0,.38,.9);
        }
        input.cds-text-input { height: 2.5rem; padding: 0 1rem; }
        .cds-text-input--lg { height: 3rem; }
        textarea.cds-textarea { padding: .6875rem 1rem; min-height: 5rem; resize: vertical; }
        select.cds-select--field { height: 2.5rem; padding: 0 2.5rem 0 1rem; cursor: pointer; }
        .cds-text-input::placeholder, .cds-textarea::placeholder { color: var(--cds-text-placeholder); }
        input.cds-text-input:focus, textarea.cds-textarea:focus, select.cds-select--field:focus { outline-color: var(--cds-focus); box-shadow: none; border-bottom-color: var(--cds-border-strong); }
        input.cds-text-input[aria-invalid="true"], textarea.cds-textarea[aria-invalid="true"], select.cds-select--field[aria-invalid="true"],
        input.cds-text-input.border-error, input.cds-text-input.is-invalid { outline-color: #da1e28; }
        input.cds-text-input[readonly] { background: transparent; border-bottom-color: var(--cds-border-subtle); color: var(--cds-text-secondary); cursor: not-allowed; }
        input.cds-text-input:disabled, select.cds-select--field:disabled { color: #c6c6c6; border-bottom-color: transparent; cursor: not-allowed; }
        /* Campos sobre fondo gris (segunda capa): van en blanco */
        .cds-layer-2 input.cds-text-input, .cds-layer-2 select.cds-select--field, .cds-layer-2 textarea.cds-textarea { background: #ffffff; }
        .cds-layer-2 input.cds-text-input[readonly] { background: transparent; }
        .cds-input-prefix { position: relative; }
        .cds-input-prefix > span { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); font-size: .875rem; color: var(--cds-text-secondary); pointer-events: none; }
        .cds-input-prefix > input { padding-left: 2rem; }

        /* Casillas y radios */
        input[type="checkbox"].cds-checkbox, input[type="radio"].cds-radio {
            width: 1rem; height: 1rem; border: 1px solid var(--cds-text-primary); color: var(--cds-text-primary);
            background-color: transparent; cursor: pointer; box-shadow: none !important;
        }
        input[type="checkbox"].cds-checkbox { border-radius: 2px; }
        input[type="checkbox"].cds-checkbox:focus-visible, input[type="radio"].cds-radio:focus-visible { outline: 2px solid var(--cds-focus); outline-offset: 1px; }

        /* Recuadros seleccionables (radio/checkbox ocultos con .sr-only.peer delante) */
        .cds-choice {
            position: relative; display: flex; flex-direction: column; justify-content: center; height: 100%;
            background: var(--cds-layer); border: 1px solid var(--cds-border-subtle); border-radius: var(--cds-radius); padding: 1rem;
            cursor: pointer; color: var(--cds-text-primary); transition: background-color 70ms, box-shadow 70ms;
        }
        .cds-choice:hover { background: var(--cds-layer-hover); }
        .peer:checked + .cds-choice { box-shadow: inset 0 0 0 2px var(--cds-interactive); background: var(--cds-layer); }
        .peer:focus-visible + .cds-choice { outline: 2px solid var(--cds-focus); outline-offset: 2px; }
        .cds-choice .cds-choice-check { position: absolute; top: .75rem; right: .75rem; display: none; color: var(--cds-interactive); font-size: 20px !important; }
        .peer:checked + .cds-choice .cds-choice-check { display: block; }

        /* Botonera al pie de los formularios */
        .cds-form-actions { display: flex; justify-content: flex-end; gap: .5rem; margin-top: 2rem; }
        .cds-form-actions .cds-btn { min-width: 10rem; }

        /* ============================================
           RESPONSIVE - MÓVIL
        ============================================ */
        #sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(22,22,22,0.5); z-index: 40;
        }
        #sidebar-overlay.visible { display: block; }

        #hamburger-btn { display: none; }

        /* Pantallas pequeñas (celular): formularios más compactos y botones que reparten el ancho */
        @media (max-width: 639px) {
            .cds-form { padding: 1.5rem 1rem; }
            .cds-form-actions .cds-btn { flex: 1 1 0; min-width: 0; gap: .5rem; white-space: normal; }
            .cds-page-title { font-size: 1.5rem; line-height: 2rem; }
            .cds-table-toolbar > form, .cds-table-toolbar > div:last-child { width: 100%; }
            .cds-table-toolbar form[role="search"] { flex: 1 1 12rem; }
            .cds-search { flex: 1 1 auto; }
            .cds-search input[type] { width: 100%; }
        }
        @media (max-width: 1023px) {
            aside#main-sidebar { transform: translateX(-100%); transition: transform 0.24s cubic-bezier(0.2,0,0.38,0.9); }
            aside#main-sidebar.open { transform: translateX(0); }
            main#main-content { margin-left: 0 !important; }
            #hamburger-btn { display: inline-flex; }
            .cds-page-header { padding: 1.5rem 1rem 0; }
            .cds-content { padding: 1.5rem 1rem 2rem !important; }
        }

        /* Menú de usuario (arriba a la derecha) */
        #user-menu summary::-webkit-details-marker { display: none; }
    </style>
    @stack('styles')
</head>
<body class="text-on-surface bg-background">
    <a href="#contenido" class="cds-skip-link">Saltar al contenido principal</a>

    <!-- Overlay para cerrar sidebar en móvil -->
    <div id="sidebar-overlay" onclick="closeSidebar()"></div>

    <!-- SideNavBar -->
    <aside id="main-sidebar" aria-label="Menú principal">
        <div class="px-4 pt-5 pb-3">
            <img alt="Weitel" class="h-14 w-auto object-contain" src="{{ asset('img/logo_weitel.png') }}"/>
        </div>

        <nav class="flex-1 flex flex-col overflow-y-auto pb-4">
            @if(Auth::user()->isTecnico())
                <p class="sidebar-section-label">Técnico</p>
                <a class="cds-nav-link {{ request()->routeIs('tecnico.*') ? 'is-active' : '' }}" @if(request()->routeIs('tecnico.*')) aria-current="page" @endif href="{{ route('tecnico.index') }}">
                    <span class="material-symbols-outlined" {!! request()->routeIs('tecnico.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>handyman</span>
                    <span>Mis Instalaciones</span>
                </a>
            @else
                <p class="sidebar-section-label">Gestión</p>
                <a class="cds-nav-link {{ request()->routeIs('contracts.*') ? 'is-active' : '' }}" @if(request()->routeIs('contracts.*')) aria-current="page" @endif href="{{ route('contracts.index') }}">
                    <span class="material-symbols-outlined" {!! request()->routeIs('contracts.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>description</span>
                    <span>Contratos</span>
                </a>
                <a class="cds-nav-link {{ request()->routeIs('clientes.*') ? 'is-active' : '' }}" @if(request()->routeIs('clientes.*')) aria-current="page" @endif href="{{ route('clientes.index') }}">
                    <span class="material-symbols-outlined" {!! request()->routeIs('clientes.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>group</span>
                    <span>Clientes</span>
                </a>

                @if(Auth::user()->isAdministrador())
                    <p class="sidebar-section-label">Administración</p>
                    <a class="cds-nav-link {{ request()->routeIs('personal.*') ? 'is-active' : '' }}" @if(request()->routeIs('personal.*')) aria-current="page" @endif href="{{ route('personal.index') }}">
                        <span class="material-symbols-outlined" {!! request()->routeIs('personal.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>badge</span>
                        <span>Personal</span>
                    </a>
                    <a class="cds-nav-link {{ request()->routeIs('planes.*') ? 'is-active' : '' }}" @if(request()->routeIs('planes.*')) aria-current="page" @endif href="{{ route('planes.index') }}">
                        <span class="material-symbols-outlined" {!! request()->routeIs('planes.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>wifi</span>
                        <span>Planes</span>
                    </a>
                    <a class="cds-nav-link {{ request()->routeIs('duraciones.*') ? 'is-active' : '' }}" @if(request()->routeIs('duraciones.*')) aria-current="page" @endif href="{{ route('duraciones.index') }}">
                        <span class="material-symbols-outlined" {!! request()->routeIs('duraciones.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>event_repeat</span>
                        <span>Duraciones</span>
                    </a>
                    <a class="cds-nav-link {{ request()->routeIs('extensiones.*') ? 'is-active' : '' }}" @if(request()->routeIs('extensiones.*')) aria-current="page" @endif href="{{ route('extensiones.index') }}">
                        <span class="material-symbols-outlined" {!! request()->routeIs('extensiones.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>alternate_email</span>
                        <span>Extensiones Email</span>
                    </a>
                    <a class="cds-nav-link {{ request()->routeIs('equipos.*') ? 'is-active' : '' }}" @if(request()->routeIs('equipos.*')) aria-current="page" @endif href="{{ route('equipos.index') }}">
                        <span class="material-symbols-outlined" {!! request()->routeIs('equipos.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>inventory_2</span>
                        <span>Inventario</span>
                    </a>
                    <p class="sidebar-section-label">Sistema</p>
                    <a class="cds-nav-link {{ request()->routeIs('auditoria.*') ? 'is-active' : '' }}" @if(request()->routeIs('auditoria.*')) aria-current="page" @endif href="{{ route('auditoria.index') }}">
                        <span class="material-symbols-outlined" {!! request()->routeIs('auditoria.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>analytics</span>
                        <span>Auditoría</span>
                    </a>
                @endif
            @endif
        </nav>
        <!-- Logout -->
        <div class="mt-auto border-t border-outline-variant py-2">
            <a class="cds-nav-link" href="{{ route('logout') }}">
                <span class="material-symbols-outlined" data-icon="logout">logout</span>
                <span>Cerrar Sesión</span>
            </a>
        </div>
    </aside>


    <!-- Contenido -->
    <main id="main-content" class="ml-64 min-h-screen" tabindex="-1">
        @php
            $u = Auth::user();
            $rolTxt = $u->isAdministrador() ? 'Administrador' : ($u->isTecnico() ? 'Técnico' : 'Administrativo');
        @endphp
        <div class="cds-page-header flex items-start justify-between gap-4">
            <div class="flex items-start gap-2 min-w-0">
                <button id="hamburger-btn" class="cds-icon-action -ml-2 mt-0.5" onclick="openSidebar()" aria-label="Abrir menú" aria-expanded="false" aria-controls="main-sidebar">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div class="min-w-0">
                    <h1 class="cds-page-title">@yield('header_title', 'Contratos Administrativos')</h1>
                    <p class="cds-page-subtitle">@yield('header_subtitle', 'Gestión de Suministros')</p>
                </div>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                @yield('top_actions')
                <!-- Usuario (solo lectura) -->
                <details id="user-menu" class="relative">
                    <summary class="list-none cds-user-trigger" aria-label="Información del usuario">
                        <div class="w-8 h-8 rounded-full bg-[#393939] flex items-center justify-center font-semibold text-xs text-white shrink-0">
                            {{ strtoupper(substr($u->name ?? 'U', 0, 2)) }}
                        </div>
                        <div class="hidden md:block min-w-0 max-w-[16rem] text-left">
                            <p class="text-sm text-primary truncate leading-5">{{ $u->name }}</p>
                            <p class="text-xs text-on-surface-variant leading-4">{{ $rolTxt }}</p>
                        </div>
                        <span class="material-symbols-outlined text-on-surface-variant hidden md:inline" style="font-size:20px">expand_more</span>
                    </summary>
                    <div class="absolute right-0 mt-1 w-72 bg-surface-container-lowest border border-outline-variant shadow-[0_2px_6px_rgba(0,0,0,0.2)] px-4 py-4 z-50 cursor-default">
                        <p class="text-sm font-semibold text-primary break-words">{{ $u->name }}</p>
                        <p class="text-xs text-on-surface-variant mt-1 font-mono">C.I. {{ $u->cedula }}{{ $u->base ? ' · ' . $u->base : '' }}</p>
                        <p class="text-xs text-on-surface-variant mt-2">Rol: <span class="text-primary">{{ $rolTxt }}</span></p>
                    </div>
                </details>
            </div>
        </div>
        <div id="contenido" class="cds-content p-8 space-y-6" tabindex="-1" style="outline: none">
        @if(session('success'))
            <div class="flex items-center gap-3 bg-[#defbe6] border-l-[3px] border-[#24a148] text-[#161616] px-4 py-3 text-sm" role="status">
                <span class="material-symbols-outlined text-[#24a148]" style="font-size:18px">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="flex items-center gap-3 bg-[#fff1f1] border-l-[3px] border-[#da1e28] text-[#161616] px-4 py-3 text-sm" role="alert">
                <span class="material-symbols-outlined text-[#da1e28]" style="font-size:18px">error</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

            @yield('content')
        </div>
    </main>

    @stack('scripts')

    <script>
        function openSidebar() {
            document.getElementById('main-sidebar').classList.add('open');
            document.getElementById('sidebar-overlay').classList.add('visible');
            document.body.style.overflow = 'hidden';
            document.getElementById('hamburger-btn')?.setAttribute('aria-expanded', 'true');
            document.querySelector('#main-sidebar a')?.focus();
        }
        function closeSidebar() {
            const abierto = document.getElementById('main-sidebar').classList.contains('open');
            document.getElementById('main-sidebar').classList.remove('open');
            document.getElementById('sidebar-overlay').classList.remove('visible');
            document.body.style.overflow = '';
            const btn = document.getElementById('hamburger-btn');
            btn?.setAttribute('aria-expanded', 'false');
            if (abierto && btn && getComputedStyle(btn).display !== 'none') btn.focus();
        }

        // WCAG 1.1.1: los iconos (fuente de ligaduras) son decorativos; sin esto el lector de pantalla
        // lee "edit", "delete", "search"… Los botones de solo icono ya llevan aria-label.
        (function ocultarIconos() {
            const marcar = raiz => raiz.querySelectorAll?.('.material-symbols-outlined:not([aria-hidden])').forEach(i => i.setAttribute('aria-hidden', 'true'));
            marcar(document);
            new MutationObserver(cambios => cambios.forEach(c => c.addedNodes.forEach(n => {
                if (n.nodeType !== 1) return;
                if (n.matches?.('.material-symbols-outlined')) n.setAttribute('aria-hidden', 'true');
                marcar(n);
            }))).observe(document.body, { childList: true, subtree: true });
        })();
        // Cerrar con Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSidebar();
                document.getElementById('user-menu')?.removeAttribute('open');
            }
        });
        // Cerrar el menú de usuario al hacer clic fuera
        document.addEventListener('click', function(e) {
            const m = document.getElementById('user-menu');
            if (m && m.open && !m.contains(e.target)) m.removeAttribute('open');
        });
    </script>
</body>
</html>
