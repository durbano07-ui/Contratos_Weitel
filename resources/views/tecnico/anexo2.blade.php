@extends('layouts.app')

@section('title', 'Llenar Anexo 2 | Weitel')
@section('header_title', 'Anexo 2: Equipos e Instalación')
@section('header_subtitle', 'Contrato #ISP-' . $contract->id_contrato . ' | Cliente: ' . $contract->client->nombre)

@push('styles')
    <style>
        /* Anexo 2 — estilos IBM Carbon (mismas clases que usa el JavaScript) */

        /* ---------- Acordeón de secciones ---------- */
        .section-card { background: #fff; border-top: 1px solid #e0e0e0; }
        .section-card:last-child { border-bottom: 1px solid #e0e0e0; }
        .section-header {
            display: flex; align-items: center; justify-content: space-between; gap: 1rem;
            min-height: 3rem; padding: .75rem 1rem; cursor: pointer; user-select: none;
            background: #fff; transition: background-color 110ms cubic-bezier(.2,0,.38,.9);
            -webkit-tap-highlight-color: transparent;
        }
        .section-header:hover { background: #e8e8e8; }
        .section-header:focus-visible { outline: 2px solid #0f62fe; outline-offset: -2px; }
        .section-header .section-num { font-family: 'IBM Plex Mono', monospace; font-size: .875rem; color: #6f6f6f; min-width: 1.75rem; }
        .section-header .section-title { flex: 1; font-size: 1rem; line-height: 1.5rem; font-weight: 400; color: #161616; }
        .section-header.active .section-title { font-weight: 600; }
        .section-chevron { transition: transform 110ms cubic-bezier(.2,0,.38,.9); font-size: 20px !important; color: #161616; }
        .section-header.active .section-chevron { transform: rotate(180deg); }

        /* Estado de la sección: misma etiqueta que el resto del sistema
           (verde = completado, amarillo = pendiente, gris = en curso) */
        .section-status { display: inline-flex; align-items: center; min-height: 1.5rem; padding: 0 .5rem; border-radius: 9999px; font-size: .75rem; line-height: 1rem; letter-spacing: .32px; white-space: nowrap; background: #e0e0e0; color: #161616; }
        .section-status.done { background: #a7f0ba; color: #0e6027; }
        .section-status.pending { background: #fcf4d6; color: #483700; }
        .section-status.active-badge { background: #e0e0e0; color: #161616; }

        .section-body { display: none; }
        .section-body.open { display: block; }
        .section-body-inner { padding: .5rem 1rem 1.5rem 3.75rem; }
        @media (max-width: 640px) { .section-body-inner { padding-left: 1rem; } }

        /* ---------- Campos ---------- */
        .field-group { display: flex; flex-direction: column; }
        .field-group label { font-size: .75rem; line-height: 1rem; letter-spacing: .32px; color: #525252; margin-bottom: .5rem; }
        .field-group input, .field-group select {
            width: 100%; height: 2.5rem; padding: 0 1rem; background: #f4f4f4;
            border: 0; border-bottom: 1px solid #8d8d8d; border-radius: 0;
            font-size: .875rem; letter-spacing: .16px; color: #161616;
            outline: 2px solid transparent; outline-offset: -2px; box-shadow: none;
        }
        .field-group select { padding-right: 2.5rem; cursor: pointer; }
        .field-group input::placeholder { color: #a8a8a8; }
        .field-group input:focus, .field-group select:focus { outline-color: #0f62fe; box-shadow: none; border-bottom-color: #8d8d8d; }
        .field-group input[type="number"] { text-align: left; font-family: 'IBM Plex Mono', monospace; }
        .input-with-prefix { position: relative; }
        .input-with-prefix .prefix { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #525252; pointer-events: none; font-size: .875rem; }
        .input-with-prefix input { padding-left: 2rem; }

        /* ---------- Tarjeta de equipo ---------- */
        .equipo-card { background: #f4f4f4; }
        .equipo-card-head { display: flex; align-items: center; gap: .75rem; padding: .5rem .5rem .5rem 1rem; border-bottom: 1px solid #e0e0e0; }
        .equipo-num-badge { font-family: 'IBM Plex Mono', monospace; font-size: .75rem; color: #525252; flex-shrink: 0; }
        .equipo-num-badge::before { content: '#'; }
        .equipo-selected-name { flex: 1; min-width: 0; font-size: .875rem; font-weight: 600; color: #161616; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .equipo-card-body { padding: 1rem; }
        .equipo-card-body .field-group input, .equipo-card-body .field-group select { background: #fff; }
        .btn-remove-card {
            display: flex; align-items: center; justify-content: center; width: 2rem; height: 2rem;
            border: 0; background: transparent; color: #161616; cursor: pointer; flex-shrink: 0;
            transition: background-color 70ms;
        }
        .btn-remove-card:hover { background: #da1e28; color: #fff; }
        .btn-remove-card .material-symbols-outlined { font-size: 18px !important; }

        /* ---------- Casillas ---------- */
        .check-card {
            display: flex; align-items: center; gap: .75rem; padding: .75rem 1rem; min-height: 3rem;
            background: #f4f4f4; cursor: pointer; transition: background-color 70ms;
            -webkit-tap-highlight-color: transparent;
        }
        .check-card:hover { background: #e8e8e8; }
        .check-card input[type="checkbox"] {
            width: 1rem; height: 1rem; border: 1px solid #161616; border-radius: 2px;
            color: #161616; flex-shrink: 0; box-shadow: none !important; cursor: pointer;
        }
        .check-card input[type="checkbox"]:focus-visible { outline: 2px solid #0f62fe; outline-offset: 1px; }
        .check-card .check-label { font-size: .875rem; letter-spacing: .16px; color: #161616; }

        /* ---------- Progreso ---------- */
        .progress-bar-track { height: .5rem; background: #e0e0e0; overflow: hidden; }
        .progress-bar-fill { height: 100%; background: #f15831; transition: width 240ms cubic-bezier(.2,0,.38,.9); }

        /* ---------- Botones ---------- */
        .btn-add {
            display: inline-flex; align-items: center; justify-content: space-between; gap: 2rem;
            min-height: 2.5rem; padding: 0 1rem; margin-top: 1rem;
            background: transparent; color: #123656; border: 1px solid #123656;
            font-size: .875rem; letter-spacing: .16px; cursor: pointer;
            transition: background-color 70ms, color 70ms;
            -webkit-tap-highlight-color: transparent;
        }
        .btn-add:hover { background: #1c4a75; color: #fff; }
        .btn-add .material-symbols-outlined { font-size: 18px !important; order: 2; }

        .form-footer {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 50;
            background: #fff; border-top: 1px solid #e0e0e0;
            display: flex; align-items: stretch; justify-content: space-between; gap: 1rem;
            padding-left: 1rem;
        }
        @media (min-width: 1024px) { .form-footer { left: 16rem; } }
        .footer-hint { display: flex; align-items: center; gap: .5rem; font-size: .875rem; color: #525252; flex: 1; padding: .75rem 0; }
        .footer-hint .material-symbols-outlined { font-size: 18px !important; }
        .btn-submit {
            display: inline-flex; align-items: flex-start; justify-content: space-between; gap: 2rem;
            min-width: 12rem; min-height: 4rem; padding: .75rem 1rem;
            background: #123656; color: #fff; border: 0; font-size: .875rem; letter-spacing: .16px;
            cursor: pointer; white-space: nowrap; transition: background-color 70ms;
        }
        .btn-submit:hover { background: #1c4a75; }
        .btn-submit:active { background: #0b2238; }
        .btn-submit:focus-visible { outline: 2px solid #0f62fe; outline-offset: -2px; box-shadow: inset 0 0 0 3px #fff; }

        .inner-section-title { font-size: .875rem; font-weight: 600; color: #161616; margin-bottom: .5rem; }
        .page-wrapper { padding-bottom: 6rem; }

        /* ---------- Firma ---------- */
        .signature-container { position: relative; width: 100%; background: #fff; border: 1px solid #8d8d8d; margin-top: .5rem; }
        .signature-pad { width: 100%; height: 200px; touch-action: none; display: block; }
        .signature-actions { display: flex; justify-content: flex-end; border-top: 1px solid #e0e0e0; background: #f4f4f4; }
        .btn-clear {
            min-height: 2rem; padding: 0 1rem; background: transparent; color: #161616; border: 0;
            font-size: .875rem; letter-spacing: .16px; cursor: pointer;
        }
        .btn-clear:hover { background: #e8e8e8; }
    </style>
@endpush

@section('content')
    <div class="max-w-2xl mx-auto page-wrapper">

        {{-- Back --}}
        <a href="{{ route('tecnico.index') }}"
            class="inline-flex items-center gap-2 mb-6 min-h-[2.5rem] text-sm text-secondary hover:underline">
            <span class="material-symbols-outlined" style="font-size:18px;">arrow_back</span>
            Volver a mis instalaciones
        </a>

        {{-- Info card del contrato --}}
        <div class="mb-6 p-4 bg-white relative pl-5 flex items-start gap-3">
            <span class="absolute left-0 top-0 bottom-0 w-[3px] bg-[#f1c21b]" aria-hidden="true"></span>
            <div class="flex-1 min-w-0">
                <p class="text-xs text-on-surface-variant tracking-[.32px]">Contrato asignado</p>
                <p class="text-xl leading-7 text-primary truncate">{{ $contract->client->nombre }}</p>
                <p class="text-sm text-on-surface-variant"><span class="font-mono">ISP-{{ $contract->id_contrato }}</span> &middot; {{ $contract->plan->nombre_plan }}</p>
            </div>
            <span class="cds-tag cds-tag--yellow shrink-0">Pendiente</span>
        </div>

        {{-- Barra de progreso --}}
        <div class="mb-6">
            <div class="flex justify-between text-xs text-on-surface-variant tracking-[.32px] mb-2">
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
                <div class="mb-6 p-4 bg-[#fff1f1] border-l-[3px] border-[#da1e28] text-primary" role="alert">
                    <p class="font-semibold text-sm mb-1">Por favor corrige los siguientes errores:</p>
                    <ul class="text-sm list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>

                {{-- ===========================================
                SECCIÓN 01: EQUIPOS INSTALADOS
                =========================================== --}}
                <div class="section-card" data-section="equipos">
                    <div class="section-header active" onclick="toggleSection(this)" role="button" tabindex="0" aria-expanded="true">
                        <span class="section-num">01</span>
                        <span class="section-title">Equipos instalados <span class="text-on-surface-variant font-normal text-sm">(opcional)</span></span>
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
                                        <button type="button" class="btn-remove-card remove-equipo" title="Eliminar equipo" aria-label="Eliminar este equipo">
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
                    <div class="section-header" onclick="toggleSection(this)" role="button" tabindex="0" aria-expanded="false">
                        <span class="section-num">02</span>
                        <span class="section-title">Acta de instalación <span class="text-on-surface-variant font-normal text-sm">(opcional)</span></span>
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
                                <p class="inner-section-title">Bloqueos solicitados</p>
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
                    <div class="section-header" onclick="toggleSection(this)" role="button" tabindex="0" aria-expanded="false">
                        <span class="section-num">03</span>
                        <span class="section-title">Firma del cliente <span class="text-on-surface-variant font-normal text-sm">(opcional)</span></span>
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
                            <p class="text-xs text-on-surface-variant tracking-[.32px] mt-2">
                                Use su dedo o un lápiz óptico para firmar dentro del recuadro.
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
            <span>Finalizar instalación</span>
            <span class="material-symbols-outlined" style="font-size:20px">check</span>
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
                <button type="button" class="btn-remove-card remove-equipo" title="Eliminar equipo" aria-label="Eliminar este equipo">
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

        // ------------------------------------------------
        // ACCESIBILIDAD (WCAG 1.3.1 / 2.1.1 / 4.1.2)
        // ------------------------------------------------
        // Cada etiqueta .field-group queda asociada a su campo (también en las tarjetas que se agregan después).
        let contadorCampos = 0;
        function asociarEtiquetas(raiz) {
            raiz.querySelectorAll('.field-group').forEach(g => {
                const label = g.querySelector('label');
                const campo = g.querySelector('input:not([type=hidden]), select, textarea');
                if (!label || !campo) return;
                if (!campo.id) campo.id = 'campo-anexo-' + (++contadorCampos);
                label.htmlFor = campo.id;
            });
        }
        asociarEtiquetas(document);
        const listaEquipos = document.getElementById('equipos-list');
        if (listaEquipos) new MutationObserver(() => asociarEtiquetas(listaEquipos)).observe(listaEquipos, { childList: true });

        // Encabezados de sección: Enter o Espacio los abren, y anuncian si están expandidos.
        function actualizarExpandido() {
            document.querySelectorAll('.section-header').forEach(h => h.setAttribute('aria-expanded', h.classList.contains('active') ? 'true' : 'false'));
        }
        document.querySelectorAll('.section-header').forEach(h => {
            h.addEventListener('keydown', e => {
                if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); toggleSection(h); }
            });
            h.addEventListener('click', () => setTimeout(actualizarExpandido, 0));
        });
        const _toggleOriginal = window.toggleSection;
        if (typeof _toggleOriginal === 'function') {
            window.toggleSection = function (el) { _toggleOriginal(el); actualizarExpandido(); };
        }
    </script>
@endpush