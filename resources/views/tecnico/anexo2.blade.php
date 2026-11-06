@extends('layouts.app')

@section('title', 'Llenar Anexo 2 | Weitel')
@section('header_title', 'Anexo 2: Equipos e Instalación')
@section('header_subtitle', 'Contrato #ISP-' . $contract->id_contrato . ' | Cliente: ' . $contract->client->nombre)

@push('styles')
    <style>
        /* ================================================
           ACORDEÓN DE SECCIONES
        ================================================ */
        .section-card {
            background: #fff;
            border: 1px solid #c4c7c7;
            border-radius: 0.5rem;
            overflow: hidden;
            transition: box-shadow 0.2s ease;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 1.5rem;
            cursor: pointer;
            user-select: none;
            gap: 1rem;
            background: #f3f3f4;
            transition: background 0.15s ease;
            -webkit-tap-highlight-color: transparent;
        }

        .section-header:hover {
            background: #e8e8e8;
        }

        .section-header.active {
            background: #0a0a0a;
            color: #fff;
        }

        .section-header .section-num {
            font-size: 1.5rem;
            font-weight: 300;
            opacity: 0.35;
            line-height: 1;
            min-width: 2.5rem;
        }

        .section-header.active .section-num {
            opacity: 0.55;
        }

        .section-header .section-title {
            font-family: 'Manrope', sans-serif;
            font-size: 0.85rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            flex: 1;
        }

        .section-chevron {
            transition: transform 0.3s ease;
            font-size: 20px !important;
        }

        .section-header.active .section-chevron {
            transform: rotate(180deg);
            color: #b6171e;
        }

        .section-status {
            font-size: 0.6rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            padding: 0.2rem 0.6rem;
            border-radius: 99px;
            white-space: nowrap;
        }

        .section-status.done {
            background: #dcfce7;
            color: #15803d;
        }

        .section-status.pending {
            background: #fef9c3;
            color: #a16207;
        }

        .section-status.active-badge {
            background: #b6171e;
            color: #fff;
        }

        .section-body {
            display: none;
            border-top: 1px solid #c4c7c7;
        }

        .section-body.open {
            display: block;
            animation: slideDown 0.25s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section-body-inner {
            padding: 1.25rem 1.5rem;
        }

        /* ================================================
           CAMPO GENÉRICO
        ================================================ */
        .field-group {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
        }

        .field-group label {
            font-size: 0.6rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #444748;
        }

        .field-group input,
        .field-group select {
            background: #fff;
            border: 1px solid #c4c7c7;
            border-radius: 0.375rem;
            padding: 0.6rem 0.75rem;
            font-size: 0.82rem;
            font-weight: 700;
            color: #1a1c1c;
            width: 100%;
            transition: border-color 0.15s, box-shadow 0.15s;
            -webkit-appearance: none;
            appearance: none;
        }

        .field-group input:focus,
        .field-group select:focus {
            outline: none;
            border-color: #b6171e;
            box-shadow: 0 0 0 3px rgba(182, 23, 30, 0.12);
        }

        .field-group input[type="number"] {
            text-align: center;
        }

        .input-with-prefix {
            position: relative;
        }

        .input-with-prefix .prefix {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            font-weight: 700;
            opacity: 0.35;
            pointer-events: none;
            font-size: 0.85rem;
        }

        .input-with-prefix input {
            padding-left: 1.5rem;
        }

        /* ================================================
           TARJETA DE EQUIPO (MANUAL)
        ================================================ */
        .equipo-card {
            background: #f9f9f9;
            border: 1.5px solid #c4c7c7;
            border-radius: 0.5rem;
            overflow: hidden;
            animation: cardIn 0.2s ease;
        }

        @keyframes cardIn {
            from {
                opacity: 0;
                transform: scale(0.97);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .equipo-card-head {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.9rem 1.1rem;
            background: #fff;
            border-bottom: 1px solid #e8e8e8;
        }

        .equipo-num-badge {
            width: 1.6rem;
            height: 1.6rem;
            background: #0a0a0a;
            color: #fff;
            border-radius: 0.3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            font-weight: 900;
            flex-shrink: 0;
        }

        .equipo-selected-name {
            flex: 1;
            min-width: 0;
            font-size: 0.78rem;
            font-weight: 800;
            color: #1a1c1c;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .equipo-card-body {
            padding: 1rem 1.1rem;
        }

        .btn-remove-card {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 1.8rem;
            height: 1.8rem;
            border-radius: 0.3rem;
            border: 1px solid #ffdad6;
            background: #fff5f5;
            color: #ba1a1a;
            cursor: pointer;
            transition: background 0.15s;
            flex-shrink: 0;
        }

        .btn-remove-card:hover {
            background: #ffdad6;
        }

        .btn-remove-card .material-symbols-outlined {
            font-size: 15px !important;
        }

        /* ================================================
           CHECKBOX CARDS
        ================================================ */
        .check-card {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 1rem 1.25rem;
            background: #fff;
            border: 2px solid #c4c7c7;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: border-color 0.15s, background 0.15s;
            -webkit-tap-highlight-color: transparent;
        }

        .check-card:has(input:checked) {
            border-color: #b6171e;
            background: #fff1f1;
        }

        .check-card input[type="checkbox"] {
            width: 1.1rem;
            height: 1.1rem;
            accent-color: #b6171e;
            flex-shrink: 0;
        }

        .check-card .check-label {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #1a1c1c;
        }

        /* ================================================
           BARRA DE PROGRESO
        ================================================ */
        .progress-bar-track {
            height: 4px;
            background: #e2e2e2;
            border-radius: 99px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background: #b6171e;
            border-radius: 99px;
            transition: width 0.4s ease;
        }

        /* ================================================
           BOTONES
        ================================================ */
        .btn-add {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            width: 100%;
            background: transparent;
            color: #b6171e;
            border: 1.5px dashed #b6171e;
            border-radius: 0.5rem;
            padding: 0.65rem 1rem;
            font-size: 0.65rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            cursor: pointer;
            margin-top: 0.75rem;
            transition: background 0.15s, color 0.15s;
            -webkit-tap-highlight-color: transparent;
        }

        .btn-add:hover {
            background: #fff1f1;
        }

        .btn-add:active {
            background: #ffdad6;
        }

        .btn-add .material-symbols-outlined {
            font-size: 17px !important;
        }

        .form-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            padding: 0.9rem 1.25rem;
            border-top: 1px solid #eeeeee;
            box-shadow: 0 -4px 24px rgba(10, 10, 10, 0.10);
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        @media (min-width: 1024px) {
            .form-footer {
                left: 16rem;
            }
        }

        .footer-hint {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #444748;
            flex: 1;
        }

        .footer-hint .material-symbols-outlined {
            color: #b6171e;
            font-size: 18px !important;
        }

        .btn-submit {
            background: #0a0a0a;
            color: #fff;
            padding: 0.75rem 1.75rem;
            border-radius: 0.5rem;
            font-size: 0.7rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            border: none;
            cursor: pointer;
            white-space: nowrap;
            transition: background 0.15s, transform 0.1s;
            box-shadow: 0 4px 16px rgba(10, 10, 10, 0.25);
        }

        .btn-submit:hover {
            background: #b6171e;
        }

        .btn-submit:active {
            transform: scale(0.97);
        }

        .inner-section-title {
            font-size: 0.65rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            color: #444748;
            margin-bottom: 0.75rem;
            padding-bottom: 0.4rem;
            border-bottom: 1px dashed #c4c7c7;
        }

        .page-wrapper {
            padding-bottom: 5rem;
        }

        /* ================================================
           FIRMA PAD
        ================================================ */
        .signature-container {
            position: relative;
            width: 100%;
            background: #fff;
            border: 2px solid #c4c7c7;
            border-radius: 0.5rem;
            margin-top: 0.5rem;
        }
        .signature-pad {
            width: 100%;
            height: 200px;
            touch-action: none;
            border-radius: 0.5rem;
        }
        .signature-actions {
            display: flex;
            justify-content: flex-end;
            padding: 0.5rem;
            background: #f8f9fa;
            border-top: 1px solid #eee;
            border-radius: 0 0 0.5rem 0.5rem;
        }
        .btn-clear {
            background: transparent;
            color: #b6171e;
            border: 1px solid #b6171e;
            padding: 0.4rem 0.8rem;
            border-radius: 0.3rem;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-2xl mx-auto page-wrapper">

        {{-- Back --}}
        <a href="{{ route('tecnico.index') }}"
            class="inline-flex items-center gap-2 mb-6 text-xs font-black uppercase tracking-widest opacity-50 hover:opacity-100 transition-opacity">
            <span class="material-symbols-outlined" style="font-size:17px;">arrow_back</span>
            Volver al Panel
        </a>

        {{-- Info card del contrato --}}
        <div class="mb-6 p-4 bg-white border border-outline-variant rounded-xl flex items-start gap-3 shadow-sm">
            <span class="material-symbols-outlined text-secondary mt-0.5"
                style="font-variation-settings:'FILL' 1; font-size:22px;">description</span>
            <div class="flex-1 min-w-0">
                <p class="text-[10px] font-black uppercase tracking-widest text-secondary mb-0.5">Contrato Asignado</p>
                <p class="font-black text-sm tracking-tight text-primary truncate">{{ $contract->client->nombre }}</p>
                <p class="text-[10px] opacity-50 font-bold uppercase">ISP-{{ $contract->id_contrato }} &middot;
                    {{ $contract->plan->nombre_plan }}</p>
            </div>
            <span
                class="px-2 py-0.5 bg-amber-100 text-amber-700 text-[9px] font-black rounded-full uppercase shrink-0">Pendiente</span>
        </div>

        {{-- Barra de progreso --}}
        <div class="mb-6">
            <div class="flex justify-between text-[9px] font-black uppercase tracking-widest opacity-50 mb-1.5">
                <span>Progreso del formulario</span>
                <span id="progress-label">0 / 3 secciones</span>
            </div>
            <div class="progress-bar-track">
                <div class="progress-bar-fill" id="progress-fill" style="width: 0%"></div>
            </div>
        </div>

        <form action="{{ route('tecnico.anexo2.store', $contract->id_contrato) }}" method="POST" id="anexo2-form">
            @csrf

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                    <p class="font-bold mb-1">Por favor corrige los siguientes errores:</p>
                    <ul class="text-xs list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-4">

                {{-- ===========================================
                SECCIÓN 01: EQUIPOS INSTALADOS
                =========================================== --}}
                <div class="section-card" data-section="equipos">
                    <div class="section-header active" onclick="toggleSection(this)">
                        <span class="section-num">01</span>
                        <span class="section-title">Equipos Instalados (Opcional)</span>
                        <span class="section-status active-badge" id="status-equipos">En curso</span>
                        <span class="material-symbols-outlined section-chevron">expand_more</span>
                    </div>
                    <div class="section-body open" id="body-equipos">
                        <div class="section-body-inner">

                            {{-- Lista de tarjetas de equipo --}}
                            <div class="space-y-3" id="equipos-list">
                                {{-- La primera tarjeta se renderiza directamente --}}
                                <div class="equipo-card" id="equipo-card-0">
                                    <div class="equipo-card-head">
                                        <div class="equipo-num-badge">1</div>
                                        <span class="equipo-selected-name" id="eq-name-0">Equipo</span>
                                        <button type="button" class="btn-remove-card remove-equipo" title="Eliminar">
                                            <span class="material-symbols-outlined">close</span>
                                        </button>
                                    </div>
                                    <div class="equipo-card-body">
                                        <div class="grid grid-cols-2 gap-3 mb-3">
                                            <div class="field-group">
                                                <label>Tipo de Equipo</label>
                                                <select name="equipos[0][categoria]">
                                                    <option value="Router">Router</option>
                                                    <option value="ONU">ONU</option>
                                                    <option value="Roseta">Roseta</option>
                                                    <option value="Otro">Otro</option>
                                                </select>
                                            </div>
                                            <div class="field-group">
                                                <label>Estado</label>
                                                <select name="equipos[0][estado_equipo]">
                                                    <option value="Nuevo">Nuevo</option>
                                                    <option value="Usado">Usado</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-3 mb-3">
                                            <div class="field-group">
                                                <label>Marca</label>
                                                <input type="text" name="equipos[0][marca]" placeholder="Ej: TP-Link">
                                            </div>
                                            <div class="field-group">
                                                <label>Modelo</label>
                                                <input type="text" name="equipos[0][modelo]" placeholder="Ej: Archer C6">
                                            </div>
                                        </div>

                                        <div class="field-group">
                                            <label>N° Serial / MAC</label>
                                            <input type="text" name="equipos[0][serial]" placeholder="Opcional">
                                        </div>

                                        {{-- Valores por defecto ocultos --}}
                                        <input type="hidden" name="equipos[0][cantidad]" value="1">
                                        <input type="hidden" name="equipos[0][precio_unitario]" value="0">
                                    </div>
                                </div>
                            </div>

                            {{-- Botón agregar --}}
                            <button type="button" id="add-equipment" class="btn-add">
                                <span class="material-symbols-outlined">add_circle</span>
                                Agregar otro equipo
                            </button>

                        </div>
                    </div>
                </div>

                {{-- ===========================================
                SECCIÓN 02: ACTA DE INSTALACIÓN (ANEXO 3)
                =========================================== --}}
                <div class="section-card" data-section="instalacion">
                    <div class="section-header" onclick="toggleSection(this)">
                        <span class="section-num">02</span>
                        <span class="section-title">Acta de Instalación (Opcional)</span>
                        <span class="section-status pending" id="status-instalacion">Pendiente</span>
                        <span class="material-symbols-outlined section-chevron">expand_more</span>
                    </div>
                    <div class="section-body" id="body-instalacion">
                        <div class="section-body-inner space-y-4">
                            
                            <div class="field-group">
                                <label>IP Asignada al Cliente</label>
                                <input type="text" name="datos_anexo3[ip_asignada]" placeholder="0.0.0.0">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <label class="check-card">
                                    <input type="checkbox" name="datos_anexo3[verifico_ancho_banda]" value="1" checked>
                                    <span class="check-label">Verificó ancho de banda</span>
                                </label>
                                <label class="check-card">
                                    <input type="checkbox" name="datos_anexo3[puesta_a_tierra]" value="1">
                                    <span class="check-label">Tiene puesta a tierra</span>
                                </label>
                            </div>

                            <div class="space-y-3">
                                <p class="inner-section-title">Bloqueos Solicitados</p>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <div class="field-group">
                                        <label>Páginas Web</label>
                                        <input type="text" name="datos_anexo3[bloqueo_web]" placeholder="Detalle o No">
                                    </div>
                                    <div class="field-group">
                                        <label>Servicios</label>
                                        <input type="text" name="datos_anexo3[bloqueo_servicios]" placeholder="Detalle o No">
                                    </div>
                                    <div class="field-group">
                                        <label>Puertos</label>
                                        <input type="text" name="datos_anexo3[bloqueo_puertos]" placeholder="Detalle o No">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ===========================================
                SECCIÓN 03: FIRMA DEL CLIENTE
                =========================================== --}}
                <div class="section-card" data-section="firma">
                    <div class="section-header" onclick="toggleSection(this)">
                        <span class="section-num">03</span>
                        <span class="section-title">Firma del Cliente (Opcional)</span>
                        <span class="section-status pending" id="status-firma">Pendiente</span>
                        <span class="material-symbols-outlined section-chevron">expand_more</span>
                    </div>
                    <div class="section-body" id="body-firma">
                        <div class="section-body-inner">
                            <p class="inner-section-title">Firma táctil o digital del abonado</p>
                            <div class="signature-container">
                                <canvas id="signature-pad" class="signature-pad"></canvas>
                                <div class="signature-actions">
                                    <button type="button" class="btn-clear" id="clear-signature">Limpiar Firma</button>
                                </div>
                            </div>
                            <input type="hidden" name="firma_cliente" id="firma_cliente_input">
                            <p class="text-[10px] opacity-50 mt-3 text-center uppercase font-bold tracking-widest">
                                Use su dedo o un lápiz óptico para firmar dentro del recuadro
                            </p>
                        </div>
                    </div>
                </div>

            </div>{{-- fin .space-y-4 --}}
        </form>
    </div>

    {{-- Footer sticky --}}
    <footer class="form-footer">
        <div class="footer-hint">
            <span class="material-symbols-outlined">info</span>
            <span class="hidden sm:inline">Verifica los datos técnicos antes de guardar</span>
            <span class="sm:hidden">Revisa los datos</span>
        </div>
        <button type="submit" form="anexo2-form" class="btn-submit">
            Finalizar Instalación
        </button>
    </footer>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script>
        // ------------------------------------------------
        // ACORDEÓN
        // ------------------------------------------------
        window.toggleSection = function (headerEl) {
            const body = headerEl.nextElementSibling;
            const isOpen = body.classList.contains('open');
            document.querySelectorAll('.section-body').forEach(b => b.classList.remove('open'));
            document.querySelectorAll('.section-header').forEach(h => h.classList.remove('active'));
            if (!isOpen) { body.classList.add('open'); headerEl.classList.add('active'); }
            setTimeout(updateProgress, 50);
        };

        // ------------------------------------------------
        // AGREGAR / ELIMINAR EQUIPOS DINÁMICOS
        // ------------------------------------------------
        let equipoIdx = 1;
        const equiposList = document.getElementById('equipos-list');
        const addBtn = document.getElementById('add-equipment');

        function buildEquipoCard(idx) {
            const card = document.createElement('div');
            card.className = 'equipo-card';
            card.id = `equipo-card-${idx}`;
            card.innerHTML = `
            <div class="equipo-card-head">
                <div class="equipo-num-badge">${idx + 1}</div>
                <span class="equipo-selected-name" id="eq-name-${idx}">Equipo</span>
                <button type="button" class="btn-remove-card remove-equipo" title="Eliminar">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="equipo-card-body">
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div class="field-group">
                        <label>Tipo de Equipo</label>
                        <select name="equipos[${idx}][categoria]">
                            <option value="Router">Router</option>
                            <option value="ONU">ONU</option>
                            <option value="Roseta">Roseta</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="field-group">
                        <label>Estado</label>
                        <select name="equipos[${idx}][estado_equipo]">
                            <option value="Nuevo">Nuevo</option>
                            <option value="Usado">Usado</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div class="field-group">
                        <label>Marca</label>
                        <input type="text" name="equipos[${idx}][marca]" placeholder="Ej: TP-Link">
                    </div>
                    <div class="field-group">
                        <label>Modelo</label>
                        <input type="text" name="equipos[${idx}][modelo]" placeholder="Ej: Archer C6">
                    </div>
                </div>

                <div class="field-group">
                    <label>N° Serial / MAC</label>
                    <input type="text" name="equipos[${idx}][serial]" placeholder="Opcional">
                </div>

                <input type="hidden" name="equipos[${idx}][cantidad]" value="1">
                <input type="hidden" name="equipos[${idx}][precio_unitario]" value="0">
            </div>
        `;
            return card;
        }

        if (addBtn) {
            addBtn.addEventListener('click', function () {
                const card = buildEquipoCard(equipoIdx);
                equiposList.appendChild(card);
                equipoIdx++;
                updateProgress();
            });
        }

        if (equiposList) {
            equiposList.addEventListener('click', function (e) {
                const btn = e.target.closest('.remove-equipo');
                if (!btn) return;
                btn.closest('.equipo-card').remove();
                // Re-numerar
                equiposList.querySelectorAll('.equipo-card').forEach((c, i) => {
                    const badge = c.querySelector('.equipo-num-badge');
                    if (badge) badge.textContent = i + 1;
                });
                updateProgress();
            });
        }

        // ------------------------------------------------
        // FIRMA PAD
        // ------------------------------------------------
        const canvas = document.getElementById('signature-pad');
        let signaturePad = null;
        if (typeof SignaturePad !== 'undefined' && canvas) {
            signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgba(255, 255, 255, 0)',
                penColor: 'rgb(0, 0, 0)'
            });

            function resizeCanvas() {
                if (!canvas) return;
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                const container = canvas.parentElement;
                canvas.width = container.offsetWidth * ratio;
                canvas.height = 200 * ratio; // Altura fija
                canvas.getContext("2d").scale(ratio, ratio);
                if (signaturePad) signaturePad.clear();
            }

            window.addEventListener("resize", resizeCanvas);
            resizeCanvas();
            setTimeout(resizeCanvas, 500);
            setTimeout(resizeCanvas, 1000);

            document.getElementById('clear-signature')?.addEventListener('click', () => {
                if (signaturePad) signaturePad.clear();
                document.getElementById('firma_cliente_input').value = '';
                updateProgress();
            });

            signaturePad.onEnd = function() {
                if (!signaturePad.isEmpty()) {
                    document.getElementById('firma_cliente_input').value = signaturePad.toDataURL();
                } else {
                    document.getElementById('firma_cliente_input').value = '';
                }
                updateProgress();
            };
        }

        // ------------------------------------------------
        // BARRA DE PROGRESO
        // ------------------------------------------------
        function isSectionDone(sectionId) {
            const body = document.getElementById('body-' + sectionId);
            if (!body) return false;
            
            if (sectionId === 'firma') {
                return signaturePad && !signaturePad.isEmpty();
            }

            let hasValues = false;
            body.querySelectorAll('input[type="text"]').forEach(inp => {
                if (inp.value && inp.value.trim() !== '') hasValues = true;
            });
            return hasValues;
        }

        function updateProgress() {
            let done = 0;
            const sections = ['equipos', 'instalacion', 'firma'];
            sections.forEach(sid => {
                const status = document.getElementById('status-' + sid);
                if (!status) return;
                const isActive = status.closest('.section-header').classList.contains('active');
                if (isActive) {
                    status.textContent = 'En curso';
                    status.className = 'section-status active-badge';
                } else if (isSectionDone(sid)) {
                    status.textContent = '✓ Llenado';
                    status.className = 'section-status done';
                    done++;
                } else {
                    status.textContent = 'Opcional';
                    status.className = 'section-status pending';
                }
            });
            const pct = Math.round((done / sections.length) * 100);
            const fill = document.getElementById('progress-fill');
            const label = document.getElementById('progress-label');
            if (fill) fill.style.width = pct + '%';
            if (label) label.textContent = done + ' / ' + sections.length + ' secciones';
        }

        document.getElementById('anexo2-form')?.addEventListener('input', updateProgress);
        document.getElementById('anexo2-form')?.addEventListener('change', updateProgress);
        document.querySelectorAll('.section-header').forEach(h => {
            h.addEventListener('click', () => setTimeout(updateProgress, 50));
        });

        document.getElementById('anexo2-form')?.addEventListener('submit', function(e) {
            if (signaturePad && !signaturePad.isEmpty()) {
                document.getElementById('firma_cliente_input').value = signaturePad.toDataURL();
            } else {
                document.getElementById('firma_cliente_input').value = '';
            }

            const btn = document.querySelector('.btn-submit');
            btn.innerHTML = '<span class="animate-spin inline-block mr-2">↻</span> Guardando...';
        });

        updateProgress();
    </script>
@endpush