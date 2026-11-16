@extends('layouts.app')

@push('styles')
<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush

@section('title', 'Nuevo Contrato | Weitel')
@section('header_title', 'Nuevo Contrato')
@section('header_subtitle', 'Formulario Técnico de Alta de Servicio')


@section('content')
    <!-- Form Content Container -->
    <div class="max-w-5xl pb-40 sm:pb-32">
        
        <form class="cds-form" method="POST" action="{{ route('contracts.store') }}" enctype="multipart/form-data">
            @csrf
            <p class="text-sm text-on-surface-variant -mt-2 mb-6">Todos los campos son obligatorios, salvo los marcados como <span class="cds-optional">(opcional)</span>.</p>
            
            <!-- Section 01: Datos del Cliente -->
            <section class="cds-form-section">
                <div class="mb-6">
                    <h2 class="cds-form-section-title">Datos del cliente</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                    <div class="space-y-1">
                        <label for="input-nombre" class="cds-label">Nombre completo / Razón social</label>
                        <input id="input-nombre" name="client[nombre]" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\.\,\s]+" title="Solo letras y espacios permitidos" required class="cds-text-input" type="text" oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\.\,\s]/g, '')"/>
                    </div>
                    <div class="space-y-1">
                        <label for="input-cedula" class="cds-label">Cédula / RUC</label>
                        <input id="input-cedula" aria-describedby="error-cedula" name="client[cedula]" maxlength="13" inputmode="numeric" placeholder="10 dígitos (cédula) o 13 (RUC)" required class="cds-text-input" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                        <p class="cds-error-msg hidden" id="error-cedula" role="alert">Cédula (10 dígitos) o RUC (13 dígitos) inválido.</p>
                    </div>
                    <div class="space-y-1">
                        <label for="input-email-prefix" class="cds-label">Correo electrónico</label>
                        <div class="flex">
                            <input id="input-email-prefix" required class="cds-text-input !w-1/2" type="text" placeholder="ejemplo.usuario" oninput="this.value = this.value.replace(/[^A-Za-z0-9\.\_\-]/g, '')"/>
                            <select id="select-email-domain" aria-label="Dominio del correo electrónico" class="cds-select--field !w-1/2 border-l border-l-[#e0e0e0]">
                                @foreach($extensiones as $ext)
                                <option value="&#64;{{ $ext->dominio }}">&#64;{{ $ext->dominio }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="client[email]" id="hidden-email">
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label for="input-telefono" class="cds-label">Teléfono Móvil</label>
                        <input id="input-telefono" name="client[n_telefono]" pattern="09[0-9]{8}" maxlength="10" title="Debe empezar con 09 y tener 10 dígitos exactamente" required class="cds-text-input" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(this.value.length === 1 && this.value !== '0') this.value = '0'; if(this.value.length === 2 && this.value !== '09') this.value = '0';"/>
                    </div>
                </div>
            </section>

            <!-- Section 02: Ubicación -->
            <section class="cds-form-section">
                <div class="mb-6">
                    <h2 class="cds-form-section-title">Ubicación</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-4 space-y-1">
                        <label for="f-client-direccion" class="cds-label">Dirección Tributaria</label>
                        <input id="f-client-direccion" name="client[direccion]" required class="cds-text-input" type="text" placeholder="Ej. Calle Principal y Secundaria, Casa #123"/>
                    </div>
                    <div class="space-y-1">
                        <label for="select-provincia" class="cds-label">Provincia</label>
                        <select name="client[provincia]" id="select-provincia" required class="cds-select--field text-sm">
                            <option value="Bolívar">Bolívar</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label for="select-canton" class="cds-label">Cantón</label>
                        <select name="client[canton]" id="select-canton" required class="cds-select--field text-sm">
                            <option value="">Seleccione Provincia 1º</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label for="select-ciudad" class="cds-label">Ciudad</label>
                        <select name="client[ciudad]" id="select-ciudad" required class="cds-select--field text-sm">
                            <option value="">Seleccione Cantón 1º</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label for="select-parroquia" class="cds-label">Parroquia</label>
                        <select name="client[parroquia]" id="select-parroquia" required class="cds-select--field text-sm">
                            <option value="">Seleccione Cantón 1º</option>
                        </select>
                    </div>
                </div>
            </section>

            <!-- Section 03: Servicio y Plan -->
            <section class="cds-form-section">
                <div class="mb-6">
                    <h2 class="cds-form-section-title">Servicio y plan</h2>
                </div>
                <div class="space-y-12">
                    <div class="space-y-1">
                        <label for="f-contract-direccion-servicio" class="cds-label">Dirección donde será prestado el servicio <span class="cds-optional">(opcional)</span></label>
                        <input id="f-contract-direccion-servicio" name="contract[direccion_servicio]" class="cds-text-input" type="text"/>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <p id="lbl-tipo-servicio" class="cds-label">Tipo de servicio</p>
                            <div class="flex gap-4" role="radiogroup" aria-labelledby="lbl-tipo-servicio">
                                @foreach($tiposConexion as $index => $tipo)
                                <label class="flex-1 cursor-pointer group">
                                    <input class="sr-only peer tipo-servicio-radio" name="id_tipo" value="{{ $tipo->id_tipo }}" type="radio" {{ $index === 0 ? 'checked' : '' }}/>
                                    <div class="cds-choice items-center text-center !py-5">
                                        <span class="material-symbols-outlined cds-choice-check">check_circle</span>
                                        <span class="material-symbols-outlined text-3xl mb-2 text-on-surface-variant" data-icon="{{ Str::contains(strtolower($tipo->nombre_tipo), 'fibra') ? 'settings_ethernet' : 'settings_input_antenna' }}">
                                            {{ Str::contains(strtolower($tipo->nombre_tipo), 'fibra') ? 'settings_ethernet' : 'settings_input_antenna' }}
                                        </span>
                                        <span class="text-sm text-center">{{ $tipo->nombre_tipo }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="space-y-6">
                            <p id="lbl-duracion" class="cds-label">Duración del contrato</p>
                            <div class="flex gap-4" role="radiogroup" aria-labelledby="lbl-duracion">
                                @foreach($duraciones as $duracion)
                                <label class="flex-1 cursor-pointer">
                                    <input {{ old('contract.duration', $duraciones->contains('meses', 24) ? 24 : $duraciones->first()->meses) == $duracion->meses ? 'checked' : '' }} class="sr-only peer" name="contract[duration]" value="{{ $duracion->meses }}" type="radio"/>
                                    <div class="cds-choice items-center text-center !py-3 text-sm">{{ $duracion->meses }} meses</div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Plan Selection Cards -->
                    <div class="space-y-6">
                        <p id="lbl-plan" class="cds-label">Seleccione el plan</p>
                        <div id="plans-container" class="grid grid-cols-1 md:grid-cols-3 gap-4" role="radiogroup" aria-labelledby="lbl-plan" aria-live="polite">
                            <!-- Plans will be loaded dynamically via AJAX here -->
                            <div class="col-span-3 text-center py-8 opacity-50 text-sm font-bold tracking-widest uppercase">
                                Seleccione un Tipo de Servicio para ver los planes
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 04: Método de Pago -->
            <section class="cds-form-section">
                <div class="mb-6">
                    <h2 class="cds-form-section-title">Método de pago</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6" role="radiogroup" aria-label="Método de pago">
                    <label class="cursor-pointer group">
                        <input checked class="sr-only peer payment-method-radio" name="contract[payment]" value="direct" type="radio"/>
                        <div class="cds-choice items-center text-center">
                            <span class="material-symbols-outlined cds-choice-check">check_circle</span>
                            <span class="material-symbols-outlined mb-2 text-2xl text-on-surface-variant" data-icon="storefront">storefront</span>
                            <span class="text-sm">Pago Directo / Ventanilla</span>
                        </div>
                    </label>
                    <label class="cursor-pointer group">
                        <input class="sr-only peer payment-method-radio" name="contract[payment]" value="auto" type="radio"/>
                        <div class="cds-choice items-center text-center">
                            <span class="material-symbols-outlined cds-choice-check">check_circle</span>
                            <span class="material-symbols-outlined mb-2 text-2xl text-on-surface-variant" data-icon="account_balance">account_balance</span>
                            <span class="text-sm">Débito Automático</span>
                        </div>
                    </label>
                    <label class="cursor-pointer group">
                        <input class="sr-only peer payment-method-radio" name="contract[payment]" value="card" type="radio"/>
                        <div class="cds-choice items-center text-center">
                            <span class="material-symbols-outlined cds-choice-check">check_circle</span>
                            <span class="material-symbols-outlined mb-2 text-2xl text-on-surface-variant" data-icon="credit_card">credit_card</span>
                            <span class="text-sm">Débito Tarjeta</span>
                        </div>
                    </label>
                    <label class="cursor-pointer group">
                        <input class="sr-only peer payment-method-radio" name="contract[payment]" value="transfer" type="radio"/>
                        <div class="cds-choice items-center text-center">
                            <span class="material-symbols-outlined cds-choice-check">check_circle</span>
                            <span class="material-symbols-outlined mb-2 text-2xl text-on-surface-variant" data-icon="devices">devices</span>
                            <span class="text-sm">Transferencia / Mi Vecino</span>
                        </div>
                    </label>
                </div>

                <!-- Contenedor dinámico de datos de pago segun la selección -->
                <div id="payment-details-container" class="cds-layer-2 bg-[#f4f4f4] p-6 rounded hidden">
                    
                    <!-- Campos para Débito Automático -->
                    <div id="fields-auto" class="payment-fields hidden space-y-4">
                        <h4 class="text-sm font-semibold text-primary flex items-center gap-2">
                            <span class="material-symbols-outlined text-on-surface-variant" style="font-size:18px">account_balance</span> Datos para Débito Automático Bancario
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="space-y-1">
                                <label for="f-contract-datos-pago-banco" class="cds-label">Banco</label>
                                <select id="f-contract-datos-pago-banco" name="contract[datos_pago][banco]" class="cds-select--field text-sm">
                                    <option value="Banco Pichincha">Banco Pichincha</option>
                                    <option value="Banco Guayaquil">Banco Guayaquil</option>
                                    <option value="Produbanco">Produbanco</option>
                                    <option value="Banco del Pacífico">Banco del Pacífico</option>
                                    <option value="Banco de Loja">Banco de Loja</option>
                                    <option value="Banco Bolivariano">Banco Bolivariano</option>
                                    <option value="Banco Internacional">Banco Internacional</option>
                                    <option value="Cooperativa JEP">Cooperativa JEP</option>
                                    <option value="Otra Institución">Otra Institución</option>
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label for="f-contract-datos-pago-tipo-cuenta" class="cds-label">Tipo de Cuenta</label>
                                <select id="f-contract-datos-pago-tipo-cuenta" name="contract[datos_pago][tipo_cuenta]" class="cds-select--field text-sm">
                                    <option value="Ahorros">Ahorros</option>
                                    <option value="Corriente">Corriente</option>
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label for="f-contract-datos-pago-numero-cuenta" class="cds-label">Número de Cuenta</label>
                                <input id="f-contract-datos-pago-numero-cuenta" name="contract[datos_pago][numero_cuenta]" type="text" class="cds-text-input text-sm" placeholder="Ej: 2200123456" oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                            </div>
                        </div>
                    </div>

                    <!-- Campos para Débito Tarjeta -->
                    <div id="fields-card" class="payment-fields hidden space-y-4">
                        <h4 class="text-sm font-semibold text-primary flex items-center gap-2">
                            <span class="material-symbols-outlined text-on-surface-variant" style="font-size:18px">credit_card</span> Datos de Tarjeta de Crédito
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="space-y-1">
                                <label for="f-contract-datos-pago-banco-emisor" class="cds-label">Banco Emisor</label>
                                <select id="f-contract-datos-pago-banco-emisor" name="contract[datos_pago][banco_emisor]" class="cds-select--field text-sm">
                                    <option value="Banco Pichincha">Banco Pichincha</option>
                                    <option value="Banco Guayaquil">Banco Guayaquil</option>
                                    <option value="Produbanco">Produbanco</option>
                                    <option value="Banco del Pacífico">Banco del Pacífico</option>
                                    <option value="Banco de Loja">Banco de Loja</option>
                                    <option value="Banco Bolivariano">Banco Bolivariano</option>
                                    <option value="Banco Internacional">Banco Internacional</option>
                                    <option value="Diners Club Ecuador">Diners Club Ecuador</option>
                                    <option value="Cooperativa JEP">Cooperativa JEP</option>
                                    <option value="Otra Institución">Otra Institución</option>
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label for="f-contract-datos-pago-nombre-tarjeta" class="cds-label">Tarjeta / Franquicia</label>
                                <select id="f-contract-datos-pago-nombre-tarjeta" name="contract[datos_pago][nombre_tarjeta]" class="cds-select--field text-sm">
                                    <option value="Visa">Visa</option>
                                    <option value="Mastercard">Mastercard</option>
                                    <option value="Diners Club">Diners Club</option>
                                    <option value="American Express">American Express</option>
                                    <option value="Discover">Discover</option>
                                    <option value="Alia">Alia</option>
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label for="f-contract-datos-pago-numero-tarjeta" class="cds-label">Número de Tarjeta</label>
                                <input id="f-contract-datos-pago-numero-tarjeta" name="contract[datos_pago][numero_tarjeta]" type="text" maxlength="16" class="cds-text-input text-sm" placeholder="4532 XXXX XXXX 1234" oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                            </div>
                            <div class="space-y-1">
                                <label for="f-contract-datos-pago-codigo-tarjeta" class="cds-label">Código CVC / Código</label>
                                <input id="f-contract-datos-pago-codigo-tarjeta" name="contract[datos_pago][codigo_tarjeta]" type="text" maxlength="4" class="cds-text-input text-sm" placeholder="123" oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                            </div>
                        </div>
                    </div>

                    <!-- Campos para Transferencia -->
                    <div id="fields-transfer" class="payment-fields hidden space-y-4">
                        <h4 class="text-sm font-semibold text-primary flex items-center gap-2">
                            <span class="material-symbols-outlined text-on-surface-variant" style="font-size:18px">account_balance</span> Datos de Pago - Banco Pichincha
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="space-y-1">
                                <label for="f-contract-datos-pago-banco-2" class="cds-label">Banco de Origen</label>
                                <select id="f-contract-datos-pago-banco-2" name="contract[datos_pago][banco]" class="cds-select--field text-sm font-bold text-primary">
                                    <option value="Banco Pichincha" selected>Banco Pichincha</option>
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label for="f-contract-datos-pago-tipo-cuenta-2" class="cds-label">Tipo de Cuenta / Servicio</label>
                                <select id="f-contract-datos-pago-tipo-cuenta-2" name="contract[datos_pago][tipo_cuenta]" class="cds-select--field text-sm">
                                    <option value="Mi Vecino" selected>Mi Vecino</option>
                                    <option value="Ahorros">Ahorros</option>
                                    <option value="Corriente">Corriente</option>
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label for="f-contract-datos-pago-numero-cuenta-2" class="cds-label flex items-center justify-between">
                                    <span>Código Único</span>
                                    <span class="cds-optional">(no editable)</span>
                                </label>
                                <input id="f-contract-datos-pago-numero-cuenta-2" name="contract[datos_pago][numero_cuenta]" type="text" value="95149" readonly class="cds-text-input font-mono" title="Código único para pagos en Mi Vecino - Banco Pichincha"/>
                                <input name="contract[datos_pago][codigo_unico]" type="hidden" value="95149"/>
                            </div>
                        </div>


                    </div>

                </div>
            </section>

            <!-- Section 05: Información Adicional -->
            <section class="cds-form-section">
                <div class="mb-6">
                    <h2 class="cds-form-section-title">Información adicional</h2>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <p class="text-sm text-primary">¿El abonado es de la tercera edad o tiene una discapacidad?</p>
                        <p class="cds-helper">Aplica los beneficios de ley correspondientes.</p>
                    </div>
                    <div class="inline-flex shrink-0" role="radiogroup" aria-label="Beneficio de ley">
                        <label class="cursor-pointer">
                            <input type="radio" name="contract[beneficio_ley]" value="0" class="sr-only peer" checked>
                            <span class="block w-20 text-center py-2 text-sm border border-primary text-primary peer-checked:bg-primary peer-checked:text-white peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-[#0f62fe]">No</span>
                        </label>
                        <label class="cursor-pointer -ml-px">
                            <input type="radio" name="contract[beneficio_ley]" value="1" class="sr-only peer">
                            <span class="block w-20 text-center py-2 text-sm border border-primary text-primary peer-checked:bg-primary peer-checked:text-white peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-[#0f62fe]">Sí</span>
                        </label>
                    </div>
                </div>
            </section>

            <!-- Section 06: Equipos Entregados / Asignados (Anexo 2) -->
            <section class="cds-form-section">
                <div class="mb-6">
                    <div>
                        <h2 class="cds-form-section-title">Equipos asignados al contrato</h2>
                        <p class="cds-form-section-desc">Seleccione los equipos del catálogo que se completarán automáticamente en el Anexo 2 del contrato.</p>
                    </div>
                </div>

                @if(isset($equipos) && count($equipos) > 0)
                    <div class="overflow-x-auto">
                        <table class="cds-table">
                            <thead>
                                <tr>
                                    <th class="py-3 px-4 text-center w-12">Asignar</th>
                                    <th class="py-3 px-4">Equipo</th>
                                    <th class="py-3 px-4">Categoría</th>
                                    <th class="py-3 px-4 text-center w-28">Cantidad</th>
                                    <th class="py-3 px-4">Nº Serie / Marca (Opcional)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($equipos as $index => $equipo)
                                    @php
                                        $nombreClean = trim(str_replace([' (AC1200 / AX1800)', '(AC1200 / AX1800)'], '', $equipo->nombre));
                                        $icon = 'devices_other';
                                        $nombreLower = strtolower($nombreClean);
                                        if (str_contains($nombreLower, 'router')) $icon = 'router';
                                        elseif (str_contains($nombreLower, 'onu') || str_contains($nombreLower, 'ont')) $icon = 'hub';
                                        elseif (str_contains($nombreLower, 'regulador') || str_contains($nombreLower, 'voltaje')) $icon = 'bolt';
                                        elseif (str_contains($nombreLower, 'cable') || str_contains($nombreLower, 'utp')) $icon = 'settings_ethernet';
                                    @endphp
                                    <tr>
                                        <td class="py-3 px-4 text-center">
                                            <input type="checkbox" name="contract[equipos][{{ $index }}][seleccionado]" value="1" class="cds-checkbox" aria-label="Asignar {{ $nombreClean }}" {{ $index < 3 ? 'checked' : '' }}/>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="flex items-center gap-2.5">
                                                <div class="text-on-surface-variant shrink-0">
                                                    <span class="material-symbols-outlined text-lg" data-icon="{{ $icon }}">{{ $icon }}</span>
                                                </div>
                                                <span class="cds-cell-strong">{{ $nombreClean }}</span>
                                            </div>
                                            <input type="hidden" name="contract[equipos][{{ $index }}][nombre]" value="{{ $nombreClean }}">
                                            <input type="hidden" name="contract[equipos][{{ $index }}][categoria]" value="{{ $equipo->categoria }}">
                                        </td>
                                        <td class="py-3 px-4">
                                            <span class="cds-tag cds-tag--gray">
                                                {{ $equipo->categoria }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <input type="number" min="1" max="100" name="contract[equipos][{{ $index }}][cantidad]" aria-label="Cantidad de {{ $nombreClean }}" value="1" class="cds-text-input !h-8 !w-20 !px-2 text-center font-mono"/>
                                        </td>
                                        <td class="py-3 px-4">
                                            <input type="text" name="contract[equipos][{{ $index }}][serial]" aria-label="Número de serie o marca de {{ $nombreClean }}" placeholder="Ej. SN893427492" class="cds-text-input !h-8 font-mono"/>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-6 bg-[#f4f4f4] text-center text-sm text-on-surface-variant">
                        No hay equipos en inventario. El administrador puede agregarlos desde la sección de Equipos.
                    </div>
                @endif
            </section>

            <!-- Section 07: Asignación de Técnico -->
            <section class="cds-form-section">
                <div class="mb-6">
                    <h2 class="cds-form-section-title">Asignación de técnico</h2>
                </div>
                <div class="space-y-4">
                    <label for="f-id-tecnico" class="cds-label">
                        Seleccione el Técnico (Jefe de Grupo) <span class="cds-optional">(opcional)</span>
                    </label>
                    <div>
                        <select id="f-id-tecnico" name="id_tecnico" class="cds-select--field">
                            <option value="">Sin técnico asignado</option>
                            @foreach($tecnicos as $tecnico)
                                <option value="{{ $tecnico->id }}">{{ $tecnico->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <p class="cds-helper">Campo opcional. Si no se asigna ahora, el administrador podrá asignarlo o cambiarlo posteriormente al editar el contrato.</p>
                </div>
            </section>

            <!-- Section 08: Firma / QR del Prestador -->
            <section class="cds-form-section">
                <div class="mb-6">
                    <h2 class="cds-form-section-title">Firma / QR electrónico del prestador</h2>
                </div>
                <div class="space-y-2">
                    <label for="f-firma-prestador" class="cds-label">Actualizar imagen de firma y QR <span class="cds-optional">(opcional)</span></label>
                    <div class="flex items-center gap-4">
                        <input id="f-firma-prestador" type="file" name="firma_prestador" accept="image/png,image/jpeg,image/jpg" class="block w-full text-sm text-on-surface-variant cursor-pointer file:mr-4 file:py-2.5 file:px-4 file:border-0 file:bg-[#393939] file:text-white hover:file:bg-[#474747] file:cursor-pointer"/>
                    </div>
                    <p class="cds-helper">Si sube una nueva firma/QR, esta se aplicará a este y a los próximos contratos generados.</p>
                </div>
            </section>


            <!-- Pie fijo con acciones -->
            <footer class="fixed bottom-0 left-0 lg:left-64 right-0 bg-white border-t border-outline-variant flex flex-col sm:flex-row sm:flex-wrap justify-between sm:items-center sm:gap-3 z-30 sm:pl-6">
                <div class="flex items-center gap-2 text-sm text-on-surface-variant py-2 sm:py-3 px-4 sm:px-0">
                    <span class="material-symbols-outlined" style="font-size:18px">info</span>
                    <span>
                        Completa todos los campos obligatorios
                    </span>
                </div>
                <div class="grid grid-cols-2 sm:flex items-stretch gap-2 p-2">
                    <a href="{{ route('contracts.index') }}" class="cds-btn cds-btn--secondary !min-h-[3rem] sm:min-w-[9rem] !items-start !pt-3 !gap-1 !whitespace-normal">
                        Cancelar
                    </a>
                    <button type="submit" id="submit-btn" class="cds-btn cds-btn--primary !min-h-[3rem] sm:min-w-[11rem] !items-start !pt-3 !gap-1 !whitespace-normal">
                        <span>Crear contrato</span>
                        <span class="material-symbols-outlined hidden sm:inline">check</span>
                    </button>
                </div>
            </footer>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeRadios = document.querySelectorAll('.tipo-servicio-radio');
        const plansContainer = document.getElementById('plans-container');

        function fetchPlans(tipoId, selectedPlanId = null) {
            plansContainer.innerHTML = '<div class="col-span-3 text-center py-8 font-bold text-sm text-primary animate-pulse">Cargando planes del catálogo...</div>';
            
            return fetch(`{{ url('/api/plans/by-type/') }}/${tipoId}`)
                .then(response => response.json())
                .then(plans => {
                    plansContainer.innerHTML = '';
                    if(!plans || plans.length === 0) {
                        plansContainer.innerHTML = '<div class="col-span-3 text-center py-8 text-error font-bold text-sm bg-error-container rounded-lg">No hay planes disponibles para este tipo en la base de datos.</div>';
                        return;
                    }
                    
                    plans.forEach((plan, index) => {
                        const mainName = plan.nombre_plan.toUpperCase();
                        const isTerceraEdad = mainName.includes('TERCERA EDAD');
                        const isDiscapacidad = mainName.includes('DISCAPACIDAD');
                        const isPromocional = plan.es_promocional || (plan.precio_regular && parseFloat(plan.precio_regular) > parseFloat(plan.precio)) || isTerceraEdad;
                        const precioReg = plan.precio_regular ? parseFloat(plan.precio_regular) : (isTerceraEdad ? 30.00 : null);
                        const precio = parseFloat(plan.precio);
                        const seleccionado = selectedPlanId ? String(plan.id_plan) === String(selectedPlanId) : index === 0;

                        const etiqueta = isPromocional
                            ? '<span class="cds-tag cds-tag--red">Precio promocional</span>'
                            : '<span class="cds-label !mb-0">Plan oficial</span>';

                        let precioAntes = '';
                        if (precioReg && precioReg > precio) {
                            const ahorro = Math.round((1 - precio / precioReg) * 100);
                            precioAntes = `<p class="text-xs text-on-surface-variant mt-1"><span class="line-through font-mono">$${precioReg.toFixed(2)}</span> · ahorro ${ahorro}%</p>`;
                        }

                        let beneficio = '';
                        if (isTerceraEdad) beneficio = '<p class="text-xs text-[#198038] mt-2 flex items-center gap-1"><span class="material-symbols-outlined" style="font-size:16px">verified</span>Tarifa preferencial tercera edad</p>';
                        else if (isDiscapacidad) beneficio = '<p class="text-xs text-[#198038] mt-2 flex items-center gap-1"><span class="material-symbols-outlined" style="font-size:16px">verified</span>Tarifa preferencial discapacidad</p>';

                        const html = `
                            <label class="cursor-pointer plan-option-label block h-full" data-tercera-edad="${isTerceraEdad ? '1' : '0'}" data-discapacidad="${isDiscapacidad ? '1' : '0'}">
                                <input class="sr-only peer" name="contract[id_plan]" value="${plan.id_plan}" type="radio" ${seleccionado ? 'checked' : ''}/>
                                <div class="cds-choice !justify-start !p-5 min-h-[11rem]">
                                    <span class="material-symbols-outlined cds-choice-check">check_circle</span>
                                    <div class="pr-6">${etiqueta}</div>
                                    <h3 class="text-base leading-6 text-primary mt-2 pr-6">${mainName}</h3>
                                    <p class="text-sm text-on-surface-variant font-mono mt-1">${plan.velocidad}</p>
                                    ${beneficio}
                                    <div class="mt-auto pt-4">
                                        <p><span class="text-[1.75rem] leading-9 font-light text-primary">$${precio.toFixed(2)}</span><span class="text-xs text-on-surface-variant ml-1">/ mes</span></p>
                                        ${precioAntes}
                                    </div>
                                </div>
                            </label>
                        `;
                        plansContainer.insertAdjacentHTML('beforeend', html);
                    });

                    // Auto-seleccionar beneficio de ley al escoger un plan de tercera edad o discapacidad
                    document.querySelectorAll('.plan-option-label input[name="contract[id_plan]"]').forEach(radio => {
                        radio.addEventListener('change', function() {
                            const parentLabel = this.closest('.plan-option-label');
                            if (parentLabel && (parentLabel.dataset.terceraEdad === '1' || parentLabel.dataset.discapacidad === '1')) {
                                const yesRadio = document.querySelector('input[name="contract[beneficio_ley]"][value="1"]');
                                if (yesRadio) yesRadio.checked = true;
                            }
                        });
                    });
                })
                .catch(error => {
                    plansContainer.innerHTML = '<div class="col-span-3 text-center py-8 text-error font-bold text-sm">Error de conexión con el servidor.</div>';
                });
        }

        typeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if(this.checked) fetchPlans(this.value);
            });
        });

        const initialChecked = document.querySelector('.tipo-servicio-radio:checked');
        if(initialChecked) fetchPlans(initialChecked.value);

        // Validation Form Logic
        const form = document.querySelector('form');
        const inputCedula = document.getElementById('input-cedula');
        const errorCedula = document.getElementById('error-cedula');
        // Location Hierarchy Logic for Bolívar
        const locData = {
            "Bolívar": {
                "Guaranda": { ciudad: ["Guaranda"], parroquias: ["Guaranda (Sede Principal)", "Ángel Polibio Cháves", "Gabriel Ignacio Veintimilla", "Guanujo", "Facundo Vela", "Julio E. Moreno", "Salinas", "San Lorenzo", "San Luis de Pambil", "San Simón", "Santa Fe", "Simiatug"] },
                "Chillanes": { ciudad: ["Chillanes"], parroquias: ["Chillanes (Urbana)", "San José del Tambo"] },
                "Chimbo": { ciudad: ["San José de Chimbo"], parroquias: ["San José de Chimbo (Urbana)", "Asunción", "Magdalena", "San Sebastián", "Telimbela"] },
                "Echeandía": { ciudad: ["Echeandía"], parroquias: ["Echeandía (Urbana)"] },
                "San Miguel": { ciudad: ["San Miguel"], parroquias: ["San Miguel (Urbana)", "Balsapamba", "Bilován", "Régulo de Mora", "San Pablo de Atenas", "Santiago", "San Vicente"] },
                "Caluma": { ciudad: ["Caluma"], parroquias: ["Caluma (Urbana)"] },
                "Las Naves": { ciudad: ["Las Naves"], parroquias: ["Las Naves (Urbana)", "Las Mercedes"] }
            }
        };

        const selProvincia = document.getElementById('select-provincia');
        const selCanton = document.getElementById('select-canton');
        const selCiudad = document.getElementById('select-ciudad');
        const selParroquia = document.getElementById('select-parroquia');

        function updateCantones() {
            selCanton.innerHTML = '<option value="">Seleccione Cantón</option>';
            selCiudad.innerHTML = '<option value="">Seleccione Cantón 1º</option>';
            selParroquia.innerHTML = '<option value="">Seleccione Cantón 1º</option>';
            
            const p = selProvincia.value;
            if(locData[p]) {
                for(let c in locData[p]) {
                    selCanton.add(new Option(c, c));
                }
            } else {
                selCanton.innerHTML = '<option value="Otro">Otro (Escribir Manual)</option>'; 
            }
        }

        function updateCiudadParroquias() {
            selCiudad.innerHTML = '<option value="">Seleccione Ciudad</option>';
            selParroquia.innerHTML = '<option value="">Seleccione Parroquia</option>';
            
            const p = selProvincia.value;
            const c = selCanton.value;
            if(locData[p] && locData[p][c]) {
                locData[p][c].ciudad.forEach(ci => selCiudad.add(new Option(ci, ci)));
                locData[p][c].parroquias.forEach(pa => selParroquia.add(new Option(pa, pa)));
                
                // Si la ciudad es obvia, la marcamos de una
                if(locData[p][c].ciudad.length === 1) {
                    selCiudad.selectedIndex = 1;
                }
            }
        }

        selProvincia.addEventListener('change', updateCantones);
        selCanton.addEventListener('change', updateCiudadParroquias);
        
        // Arrancar con la provincia principal preseleccionada
        selProvincia.value = 'Bolívar';
        updateCantones();

        const inputPrefix = document.getElementById('input-email-prefix');
        const selectDomain = document.getElementById('select-email-domain');
        const hiddenEmail = document.getElementById('hidden-email');

        // Payment Method Dynamic Sub-forms Logic
        const paymentRadios = document.querySelectorAll('.payment-method-radio');
        const paymentContainer = document.getElementById('payment-details-container');
        const allPaymentFields = document.querySelectorAll('.payment-fields');

        function updatePaymentFields() {
            const selectedRadio = document.querySelector('.payment-method-radio:checked');
            const selectedVal = selectedRadio ? selectedRadio.value : 'direct';

            allPaymentFields.forEach(el => {
                el.classList.add('hidden');
                el.querySelectorAll('input, select, textarea').forEach(input => {
                    input.disabled = true;
                });
            });

            if (selectedVal && selectedVal !== 'direct') {
                paymentContainer.classList.remove('hidden');
                const targetFields = document.getElementById(`fields-${selectedVal}`);
                if (targetFields) {
                    targetFields.classList.remove('hidden');
                    targetFields.querySelectorAll('input, select, textarea').forEach(input => {
                        input.disabled = false;
                    });
                }
            } else {
                paymentContainer.classList.add('hidden');
            }
        }

        paymentRadios.forEach(r => r.addEventListener('change', updatePaymentFields));
        updatePaymentFields();

        function updateEmail() {
            if(inputPrefix.value.trim() !== '') {
                hiddenEmail.value = inputPrefix.value + selectDomain.value;
            }
        }
        inputPrefix.addEventListener('input', updateEmail);
        selectDomain.addEventListener('change', updateEmail);

        // Cédula: 10 dígitos | RUC: 13 dígitos (debe coincidir con App\Rules\CedulaRuc)
        function validarCedulaRucEcuador(numero) {
            if (!/^(\d{10}|\d{13})$/.test(numero)) return false;
            const provincia = parseInt(numero.substring(0, 2), 10);
            if (!((provincia >= 1 && provincia <= 24) || provincia === 30)) return false;

            if (numero.length === 13) {
                // RUC: sin dígito verificador (el SRI emite RUC que no cumplen módulo 11)
                return numero.substring(10) !== '000';
            }

            // Cédula: persona natural, dígito verificador módulo 10
            if (parseInt(numero.charAt(2), 10) >= 6) return false;
            const coef = [2, 1, 2, 1, 2, 1, 2, 1, 2];
            let suma = 0;
            for (let i = 0; i < 9; i++) {
                let valor = parseInt(numero.charAt(i), 10) * coef[i];
                suma += (valor > 9 ? valor - 9 : valor);
            }
            const verificador = suma % 10 === 0 ? 0 : 10 - (suma % 10);
            return verificador === parseInt(numero.charAt(9), 10);
        }

        inputCedula.addEventListener('input', function() {
            this.classList.remove('border-error');
            this.removeAttribute('aria-invalid');
            errorCedula.classList.add('hidden');
        });


        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Evitar envío síncrono para manejar JSON y estado de carga

            updateEmail(); // Garantizar que el correo esté acoplado antes de mandar

            const cedulaVal = inputCedula.value;
            if (!validarCedulaRucEcuador(cedulaVal)) {
                inputCedula.classList.add('border-error', 'ring-1', 'ring-error');
                inputCedula.setAttribute('aria-invalid', 'true');
                errorCedula.classList.remove('hidden');
                
                // Animate Scroll to specific wrong input
                inputCedula.scrollIntoView({ behavior: 'smooth', block: 'center' });
                inputCedula.focus({ preventScroll: true });
                return;
            }

            // Deshabilitar botón y mostrar carga para prevenir doble submit (que crearía contratos duplicados)
            const submitBtn = document.getElementById('submit-btn');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span>Generando…</span><span class="material-symbols-outlined animate-spin hidden sm:inline">autorenew</span>';
            submitBtn.classList.add('opacity-70', 'cursor-not-allowed');

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    window.location.href = "{{ route('contracts.index') }}"; 
                } else {
                    alert('Error: ' + (data.message || 'Error desconocido al crear contrato.'));
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                    submitBtn.classList.remove('opacity-70', 'cursor-not-allowed');
                }
            })
            .catch(error => {
                console.error(error);
                alert('Ocurrió un error excepcional procesando la solicitud.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                submitBtn.classList.remove('opacity-70', 'cursor-not-allowed');
            });
        });
    });
</script>
@endpush
