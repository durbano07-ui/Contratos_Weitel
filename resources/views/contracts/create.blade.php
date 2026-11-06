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

@section('top_actions')
    <button class="text-[#123656] dark:text-[#e8e8e8] opacity-70 hover:opacity-100 transition-opacity flex items-center gap-2">
        <span class="material-symbols-outlined">help</span>
        <span class="font-medium text-sm">Help</span>
    </button>
@endsection

@section('content')
    <!-- Form Content Container -->
    <div class="flex-1 max-w-5xl mx-auto w-full pb-32">
        <!-- Form Header / Client Title -->
        <div class="mb-16 border-l-4 border-secondary pl-8">
            <label class="block text-[10px] font-bold tracking-widest text-on-surface-variant uppercase mb-2">Nombre del Cliente</label>
            <input class="w-full bg-transparent border-none p-0 text-4xl font-extrabold tracking-tighter text-primary placeholder:text-surface-container-highest focus:ring-0 focus:outline-none" placeholder="Ingrese nombre o razón social..." type="text"/>
        </div>
        
        <form class="space-y-20" method="POST" action="{{ route('contracts.store') }}" enctype="multipart/form-data">
            @csrf
            
            <!-- Section 01: Datos del Cliente -->
            <section>
                <div class="flex items-baseline gap-4 mb-8">
                    <span class="text-4xl font-light text-secondary opacity-30">01</span>
                    <h2 class="text-xl font-bold tracking-tight uppercase">Datos del Cliente</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase">Nombre completo / Razón social</label>
                        <input id="input-nombre" name="client[nombre]" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\.\,\s]+" title="Solo letras y espacios permitidos" required class="w-full bg-white border border-outline-variant rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition-all py-3 px-4 shadow-sm" type="text" oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\.\,\s]/g, '')"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase">Cédula / RUC</label>
                        <input id="input-cedula" name="client[cedula]" maxlength="13" inputmode="numeric" placeholder="10 dígitos (cédula) o 13 (RUC)" required class="w-full bg-white border border-outline-variant rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition-all py-3 px-4 shadow-sm" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                        <p class="text-[10px] text-error hidden mt-1 font-bold" id="error-cedula">Cédula (10 dígitos) o RUC (13 dígitos) inválido.</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase">Correo Electrónico</label>
                        <div class="flex">
                            <input id="input-email-prefix" required class="w-1/2 bg-white border border-outline-variant rounded-l-md focus:ring-1 focus:ring-primary focus:border-primary transition-all py-3 px-4 shadow-sm" type="text" placeholder="ejemplo.usuario" oninput="this.value = this.value.replace(/[^A-Za-z0-9\.\_\-]/g, '')"/>
                            <select id="select-email-domain" class="w-1/2 bg-white border-y border-r border-outline-variant rounded-r-md focus:ring-1 focus:ring-primary focus:border-primary transition-all py-3 px-4 shadow-sm">
                                @foreach($extensiones as $ext)
                                <option value="&#64;{{ $ext->dominio }}">&#64;{{ $ext->dominio }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="client[email]" id="hidden-email">
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase">Teléfono Móvil</label>
                        <input id="input-telefono" name="client[n_telefono]" pattern="09[0-9]{8}" maxlength="10" title="Debe empezar con 09 y tener 10 dígitos exactamente" required class="w-full bg-white border border-outline-variant rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition-all py-3 px-4 shadow-sm" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(this.value.length === 1 && this.value !== '0') this.value = '0'; if(this.value.length === 2 && this.value !== '09') this.value = '0';"/>
                    </div>
                </div>
            </section>

            <!-- Section 02: Ubicación -->
            <section>
                <div class="flex items-baseline gap-4 mb-8">
                    <span class="text-4xl font-light text-secondary opacity-30">02</span>
                    <h2 class="text-xl font-bold tracking-tight uppercase">Ubicación</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-4 space-y-1">
                        <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase">Dirección Tributaria</label>
                        <input name="client[direccion]" required class="w-full bg-white border border-outline-variant rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition-all py-3 px-4 shadow-sm" type="text" placeholder="Ej. Calle Principal y Secundaria, Casa #123"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase">Provincia</label>
                        <select name="client[provincia]" id="select-provincia" required class="w-full bg-white border border-outline-variant rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition-all py-3 px-4 shadow-sm text-sm">
                            <option value="Bolívar">Bolívar</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase">Cantón</label>
                        <select name="client[canton]" id="select-canton" required class="w-full bg-white border border-outline-variant rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition-all py-3 px-4 shadow-sm text-sm">
                            <option value="">Seleccione Provincia 1º</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase">Ciudad</label>
                        <select name="client[ciudad]" id="select-ciudad" required class="w-full bg-white border border-outline-variant rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition-all py-3 px-4 shadow-sm text-sm">
                            <option value="">Seleccione Cantón 1º</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase">Parroquia</label>
                        <select name="client[parroquia]" id="select-parroquia" required class="w-full bg-white border border-outline-variant rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition-all py-3 px-4 shadow-sm text-sm">
                            <option value="">Seleccione Cantón 1º</option>
                        </select>
                    </div>
                </div>
            </section>

            <!-- Section 03: Servicio y Plan -->
            <section>
                <div class="flex items-baseline gap-4 mb-8">
                    <span class="text-4xl font-light text-secondary opacity-30">03</span>
                    <h2 class="text-xl font-bold tracking-tight uppercase">Servicio y Plan</h2>
                </div>
                <div class="space-y-12">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase">Dirección donde será prestado el servicio</label>
                        <input name="contract[direccion_servicio]" class="w-full bg-white border border-outline-variant rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition-all py-3 px-4 shadow-sm" type="text"/>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
                        <div class="space-y-6">
                            <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase block">Tipo de servicio</label>
                            <div class="flex gap-4">
                                @foreach($tiposConexion as $index => $tipo)
                                <label class="flex-1 cursor-pointer group">
                                    <input class="hidden peer tipo-servicio-radio" name="id_tipo" value="{{ $tipo->id_tipo }}" type="radio" {{ $index === 0 ? 'checked' : '' }}/>
                                    <div class="flex flex-col items-center justify-center p-6 bg-surface-container-low border-2 border-transparent peer-checked:border-secondary peer-checked:bg-white transition-all h-full">
                                        <span class="material-symbols-outlined text-3xl mb-2 text-on-surface-variant peer-checked:text-secondary" data-icon="{{ Str::contains(strtolower($tipo->nombre_tipo), 'fibra') ? 'settings_ethernet' : 'settings_input_antenna' }}">
                                            {{ Str::contains(strtolower($tipo->nombre_tipo), 'fibra') ? 'settings_ethernet' : 'settings_input_antenna' }}
                                        </span>
                                        <span class="text-xs font-bold uppercase tracking-widest text-center">{{ $tipo->nombre_tipo }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="space-y-6">
                            <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase block">Duración del contrato</label>
                            <div class="flex gap-4">
                                @foreach($duraciones as $duracion)
                                <label class="flex-1 cursor-pointer">
                                    <input {{ old('contract.duration', $duraciones->contains('meses', 24) ? 24 : $duraciones->first()->meses) == $duracion->meses ? 'checked' : '' }} class="hidden peer" name="contract[duration]" value="{{ $duracion->meses }}" type="radio"/>
                                    <div class="py-4 text-center bg-surface-container-low peer-checked:bg-primary peer-checked:text-white transition-all font-bold text-sm">{{ $duracion->meses }} MESES</div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Plan Selection Cards -->
                    <div class="space-y-6">
                        <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase block">Seleccione su Plan</label>
                        <div id="plans-container" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Plans will be loaded dynamically via AJAX here -->
                            <div class="col-span-3 text-center py-8 opacity-50 text-sm font-bold tracking-widest uppercase">
                                Seleccione un Tipo de Servicio para ver los planes
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 04: Método de Pago -->
            <section>
                <div class="flex items-baseline gap-4 mb-8">
                    <span class="text-4xl font-light text-secondary opacity-30">04</span>
                    <h2 class="text-xl font-bold tracking-tight uppercase">Método de Pago</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <label class="cursor-pointer group">
                        <input checked class="hidden peer payment-method-radio" name="contract[payment]" value="direct" type="radio"/>
                        <div class="h-full flex flex-col items-center text-center p-5 bg-surface-container-low peer-checked:bg-white peer-checked:ring-2 peer-checked:ring-secondary transition-all shadow-sm rounded-xl">
                            <span class="material-symbols-outlined mb-2 text-2xl group-hover:scale-110 transition-transform" data-icon="storefront">storefront</span>
                            <span class="text-xs font-bold uppercase tracking-tight">Pago Directo / Ventanilla</span>
                        </div>
                    </label>
                    <label class="cursor-pointer group">
                        <input class="hidden peer payment-method-radio" name="contract[payment]" value="auto" type="radio"/>
                        <div class="h-full flex flex-col items-center text-center p-5 bg-surface-container-low peer-checked:bg-white peer-checked:ring-2 peer-checked:ring-secondary transition-all shadow-sm rounded-xl">
                            <span class="material-symbols-outlined mb-2 text-2xl group-hover:scale-110 transition-transform" data-icon="account_balance">account_balance</span>
                            <span class="text-xs font-bold uppercase tracking-tight">Débito Automático</span>
                        </div>
                    </label>
                    <label class="cursor-pointer group">
                        <input class="hidden peer payment-method-radio" name="contract[payment]" value="card" type="radio"/>
                        <div class="h-full flex flex-col items-center text-center p-5 bg-surface-container-low peer-checked:bg-white peer-checked:ring-2 peer-checked:ring-secondary transition-all shadow-sm rounded-xl">
                            <span class="material-symbols-outlined mb-2 text-2xl group-hover:scale-110 transition-transform" data-icon="credit_card">credit_card</span>
                            <span class="text-xs font-bold uppercase tracking-tight">Débito Tarjeta</span>
                        </div>
                    </label>
                    <label class="cursor-pointer group">
                        <input class="hidden peer payment-method-radio" name="contract[payment]" value="transfer" type="radio"/>
                        <div class="h-full flex flex-col items-center text-center p-5 bg-surface-container-low peer-checked:bg-white peer-checked:ring-2 peer-checked:ring-secondary transition-all shadow-sm rounded-xl">
                            <span class="material-symbols-outlined mb-2 text-2xl group-hover:scale-110 transition-transform" data-icon="devices">devices</span>
                            <span class="text-xs font-bold uppercase tracking-tight">Transferencia / Mi Vecino</span>
                        </div>
                    </label>
                </div>

                <!-- Contenedor dinámico de datos de pago segun la selección -->
                <div id="payment-details-container" class="bg-surface-container-low p-6 rounded-xl shadow-sm border border-outline-variant/30 hidden">
                    
                    <!-- Campos para Débito Automático -->
                    <div id="fields-auto" class="payment-fields hidden space-y-4">
                        <h4 class="text-xs font-bold tracking-widest text-secondary uppercase flex items-center gap-2">
                            <span class="material-symbols-outlined text-base">account_balance</span> Datos para Débito Automático Bancario
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase">Banco</label>
                                <select name="contract[datos_pago][banco]" class="w-full bg-white border border-outline-variant rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition-all py-3 px-4 shadow-sm text-sm">
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
                                <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase">Tipo de Cuenta</label>
                                <select name="contract[datos_pago][tipo_cuenta]" class="w-full bg-white border border-outline-variant rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition-all py-3 px-4 shadow-sm text-sm">
                                    <option value="Ahorros">Ahorros</option>
                                    <option value="Corriente">Corriente</option>
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase">Número de Cuenta</label>
                                <input name="contract[datos_pago][numero_cuenta]" type="text" class="w-full bg-white border border-outline-variant rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition-all py-3 px-4 shadow-sm text-sm" placeholder="Ej: 2200123456" oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                            </div>
                        </div>
                    </div>

                    <!-- Campos para Débito Tarjeta -->
                    <div id="fields-card" class="payment-fields hidden space-y-4">
                        <h4 class="text-xs font-bold tracking-widest text-secondary uppercase flex items-center gap-2">
                            <span class="material-symbols-outlined text-base">credit_card</span> Datos de Tarjeta de Crédito
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase">Banco Emisor</label>
                                <select name="contract[datos_pago][banco_emisor]" class="w-full bg-white border border-outline-variant rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition-all py-3 px-4 shadow-sm text-sm">
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
                                <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase">Tarjeta / Franquicia</label>
                                <select name="contract[datos_pago][nombre_tarjeta]" class="w-full bg-white border border-outline-variant rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition-all py-3 px-4 shadow-sm text-sm">
                                    <option value="Visa">Visa</option>
                                    <option value="Mastercard">Mastercard</option>
                                    <option value="Diners Club">Diners Club</option>
                                    <option value="American Express">American Express</option>
                                    <option value="Discover">Discover</option>
                                    <option value="Alia">Alia</option>
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase">Número de Tarjeta</label>
                                <input name="contract[datos_pago][numero_tarjeta]" type="text" maxlength="16" class="w-full bg-white border border-outline-variant rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition-all py-3 px-4 shadow-sm text-sm" placeholder="4532 XXXX XXXX 1234" oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase">Código CVC / Código</label>
                                <input name="contract[datos_pago][codigo_tarjeta]" type="text" maxlength="4" class="w-full bg-white border border-outline-variant rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition-all py-3 px-4 shadow-sm text-sm" placeholder="123" oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                            </div>
                        </div>
                    </div>

                    <!-- Campos para Transferencia -->
                    <div id="fields-transfer" class="payment-fields hidden space-y-4">
                        <h4 class="text-xs font-bold tracking-widest text-secondary uppercase flex items-center gap-2">
                            <span class="material-symbols-outlined text-base">account_balance</span> Datos de Pago - Banco Pichincha
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase">Banco de Origen</label>
                                <select name="contract[datos_pago][banco]" class="w-full bg-white border border-outline-variant rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition-all py-3 px-4 shadow-sm text-sm font-bold text-primary">
                                    <option value="Banco Pichincha" selected>Banco Pichincha</option>
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase">Tipo de Cuenta / Servicio</label>
                                <select name="contract[datos_pago][tipo_cuenta]" class="w-full bg-white border border-outline-variant rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition-all py-3 px-4 shadow-sm text-sm">
                                    <option value="Mi Vecino" selected>Mi Vecino</option>
                                    <option value="Ahorros">Ahorros</option>
                                    <option value="Corriente">Corriente</option>
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase flex items-center justify-between">
                                    <span>Código Único</span>
                                    <span class="text-[9px] text-secondary font-bold">(Inmodificable)</span>
                                </label>
                                <input name="contract[datos_pago][numero_cuenta]" type="text" value="95149" readonly class="w-full bg-surface-container-high border border-outline-variant rounded-md py-3 px-4 shadow-sm text-base font-black tracking-widest text-primary cursor-not-allowed select-none focus:ring-0 focus:border-outline-variant" title="Código único para pagos en Mi Vecino - Banco Pichincha"/>
                                <input name="contract[datos_pago][codigo_unico]" type="hidden" value="95149"/>
                            </div>
                        </div>


                    </div>

                </div>
            </section>

            <!-- Section 05: Información Adicional -->
            <section>
                <div class="flex items-baseline gap-4 mb-8">
                    <span class="text-4xl font-light text-secondary opacity-30">05</span>
                    <h2 class="text-xl font-bold tracking-tight uppercase">Información Adicional</h2>
                </div>
                <div class="bg-surface-container-low p-8 flex items-center justify-between shadow-sm">
                    <div>
                        <p class="font-bold tracking-tight text-lg">¿El abonado es de la tercera edad o tiene una discapacidad?</p>
                        <p class="text-sm text-on-surface-variant">Aplica beneficios de ley correspondientes.</p>
                    </div>
                    <div class="flex bg-surface-container-high p-1 rounded-full w-40 relative">
                        <label class="flex-1 text-center py-2 z-10 cursor-pointer">
                            <input type="radio" name="contract[beneficio_ley]" value="0" class="peer hidden" checked>
                            <span class="text-xs font-bold text-on-surface-variant peer-checked:text-primary">NO</span>
                        </label>
                        <label class="flex-1 text-center py-2 z-10 cursor-pointer">
                            <input type="radio" name="contract[beneficio_ley]" value="1" class="peer hidden">
                            <span class="text-xs font-bold text-on-surface-variant peer-checked:text-primary">SÍ</span>
                        </label>
                    </div>
                </div>
            </section>

            <!-- Section 06: Equipos Entregados / Asignados (Anexo 2) -->
            <section>
                <div class="flex items-baseline gap-4 mb-8">
                    <span class="text-4xl font-light text-secondary opacity-30">06</span>
                    <div>
                        <h2 class="text-xl font-bold tracking-tight uppercase">Equipos Asignados al Contrato</h2>
                        <p class="text-xs text-on-surface-variant font-medium">Seleccione los equipos del catálogo que se completarán automáticamente en el Anexo 2 del contrato.</p>
                    </div>
                </div>

                @if(isset($equipos) && count($equipos) > 0)
                    <div class="overflow-x-auto bg-white border border-outline-variant/40 rounded-xl shadow-sm">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-surface-container-low border-b border-outline-variant/40 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">
                                    <th class="py-3 px-4 text-center w-12">Asignar</th>
                                    <th class="py-3 px-4">Equipo</th>
                                    <th class="py-3 px-4">Categoría</th>
                                    <th class="py-3 px-4 text-center w-28">Cantidad</th>
                                    <th class="py-3 px-4">Nº Serie / Marca (Opcional)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/30 text-xs">
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
                                    <tr class="hover:bg-surface-container-lowest/50 transition-colors">
                                        <td class="py-3 px-4 text-center">
                                            <input type="checkbox" name="contract[equipos][{{ $index }}][seleccionado]" value="1" class="w-4 h-4 accent-secondary rounded border-outline-variant transition-all cursor-pointer" {{ $index < 3 ? 'checked' : '' }}/>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="flex items-center gap-2.5">
                                                <div class="p-1.5 bg-surface-container-low text-secondary rounded-md shrink-0">
                                                    <span class="material-symbols-outlined text-lg" data-icon="{{ $icon }}">{{ $icon }}</span>
                                                </div>
                                                <span class="font-bold text-on-surface">{{ $nombreClean }}</span>
                                            </div>
                                            <input type="hidden" name="contract[equipos][{{ $index }}][nombre]" value="{{ $nombreClean }}">
                                            <input type="hidden" name="contract[equipos][{{ $index }}][categoria]" value="{{ $equipo->categoria }}">
                                        </td>
                                        <td class="py-3 px-4">
                                            <span class="text-[10px] font-bold uppercase tracking-wider bg-surface-container-high px-2 py-0.5 rounded text-on-surface-variant/80">
                                                {{ $equipo->categoria }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <input type="number" min="1" max="100" name="contract[equipos][{{ $index }}][cantidad]" value="1" class="w-20 bg-surface-container-low border border-outline-variant rounded-md py-1 px-2 text-center text-xs font-bold focus:ring-1 focus:ring-primary"/>
                                        </td>
                                        <td class="py-3 px-4">
                                            <input type="text" name="contract[equipos][{{ $index }}][serial]" placeholder="Ej. SN893427492" class="w-full bg-surface-container-low border border-outline-variant rounded-md py-1 px-3 text-xs font-mono focus:ring-1 focus:ring-primary"/>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-6 bg-surface-container-low rounded-xl text-center text-xs font-bold text-on-surface-variant uppercase tracking-widest">
                        No hay equipos en inventario. El administrador puede agregarlos desde la sección de Equipos.
                    </div>
                @endif
            </section>

            <!-- Section 07: Asignación de Técnico -->
            <section>
                <div class="flex items-baseline gap-4 mb-8">
                    <span class="text-4xl font-light text-secondary opacity-30">07</span>
                    <h2 class="text-xl font-bold tracking-tight uppercase">Asignación de Técnico</h2>
                </div>
                <div class="space-y-4">
                    <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase block">
                        Seleccione el Técnico (Jefe de Grupo) <span class="font-normal opacity-60 lowercase">(opcional)</span>
                    </label>
                    <div class="relative group">
                        <select name="id_tecnico" class="w-full bg-white border border-outline-variant rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition-all py-4 px-12 shadow-sm appearance-none text-sm font-bold tracking-tight">
                            <option value="">-- Sin técnico asignado (Opcional) --</option>
                            @foreach($tecnicos as $tecnico)
                                <option value="{{ $tecnico->id }}">{{ $tecnico->name }}</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-secondary group-focus-within:scale-110 transition-transform">engineering</span>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 opacity-50">expand_more</span>
                    </div>
                    <p class="text-[10px] text-on-surface-variant font-medium italic">* Campo opcional. Si no se asigna ahora, el administrador podrá asignarlo o cambiarlo posteriormente al editar el contrato.</p>
                </div>
            </section>

            <!-- Section 08: Firma / QR del Prestador -->
            <section>
                <div class="flex items-baseline gap-4 mb-8">
                    <span class="text-4xl font-light text-secondary opacity-30">08</span>
                    <h2 class="text-xl font-bold tracking-tight uppercase">Firma / QR Electrónico del Prestador</h2>
                </div>
                <div class="space-y-4 bg-surface-container-low p-6 rounded-xl border border-outline-variant/30">
                    <label class="text-[10px] font-bold tracking-widest text-on-surface-variant uppercase block">Actualizar Imagen de Firma y QR (Opcional)</label>
                    <div class="flex items-center gap-4">
                        <input type="file" name="firma_prestador" accept="image/png,image/jpeg,image/jpg" class="w-full bg-white border border-outline-variant rounded-md py-3 px-4 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-primary file:text-white hover:file:bg-primary-dark transition-all cursor-pointer"/>
                    </div>
                    <p class="text-[10px] text-on-surface-variant font-medium italic">* Si sube una nueva firma/QR, esta se aplicará a este y a los próximos contratos generados.</p>
                </div>
            </section>


            <!-- Sticky Footer for Actions -->
            <footer class="fixed bottom-0 left-64 right-0 bg-white/80 backdrop-blur-xl p-6 border-t border-surface-container flex justify-between items-center z-30 shadow-[0_-10px_40px_rgba(0,0,0,0.05)]">
                <div class="flex items-center gap-4 text-xs font-bold tracking-widest text-on-surface-variant">
                    <span class="material-symbols-outlined text-secondary">info</span> COMPLETA TODOS LOS CAMPOS OBLIGATORIOS
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('contracts.index') }}" class="bg-transparent border-2 border-primary text-primary px-8 py-4 font-bold tracking-widest uppercase transition-all hover:bg-surface-container active:scale-95 duration-150 inline-block">
                        Cancelar
                    </a>
                    <button type="submit" id="submit-btn" class="bg-[#f15831] hover:bg-[#d9441c] text-white px-10 py-4 font-bold tracking-widest uppercase transition-all scale-100 hover:scale-105 active:scale-95 duration-150">
                        Crear Contrato
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

        function fetchPlans(tipoId) {
            plansContainer.innerHTML = '<div class="col-span-3 text-center py-8 font-bold text-sm text-primary animate-pulse">Cargando planes del catálogo...</div>';
            
            fetch(`{{ url('/api/plans/by-type/') }}/${tipoId}`)
                .then(response => response.json())
                .then(plans => {
                    plansContainer.innerHTML = '';
                    if(!plans || plans.length === 0) {
                        plansContainer.innerHTML = '<div class="col-span-3 text-center py-8 text-error font-bold text-sm bg-error-container rounded-lg">No hay planes disponibles para este tipo en la base de datos.</div>';
                        return;
                    }
                    
                    plans.forEach((plan, index) => {
                        let bgColor = 'bg-white';
                        let textColor = '';
                        let borderClass = 'border-transparent peer-checked:border-secondary';
                        let iconBg = 'bg-surface-container-low';
                        let iconName = 'speed';
                        let dividerColor = 'border-surface-container-low';
                        let opacityClass = 'opacity-10';

                        // Dynamic styling matches for WOW effect
                        if(plan.velocidad.includes('500') || plan.velocidad.includes('550') || plan.velocidad.includes('600') || plan.velocidad.includes('35')) {
                            bgColor = 'bg-primary';
                            textColor = 'text-white';
                            iconBg = 'bg-secondary';
                            iconName = 'bolt';
                            dividerColor = 'border-white/10';
                            opacityClass = 'opacity-20';
                        } else if (plan.velocidad.includes('100') || plan.velocidad.includes('150') || plan.velocidad.includes('200') || plan.velocidad.includes('300') || plan.velocidad.includes('400') || plan.velocidad.includes('450') || plan.velocidad.includes('20') || plan.velocidad.includes('30')) {
                            iconBg = 'bg-tertiary-fixed-dim';
                            iconName = 'rocket_launch';
                            opacityClass = 'opacity-20';
                        }

                        const mainName = plan.nombre_plan.toUpperCase();
                        const isTerceraEdad = mainName.includes('TERCERA EDAD');
                        const isDiscapacidad = mainName.includes('DISCAPACIDAD');
                        const isPromocional = plan.es_promocional || (plan.precio_regular && parseFloat(plan.precio_regular) > parseFloat(plan.precio)) || isTerceraEdad;
                        const precioReg = plan.precio_regular ? parseFloat(plan.precio_regular) : (isTerceraEdad ? 30.00 : null);

                        let badgeHtml = '';
                        if (isPromocional) {
                            badgeHtml = `<span class="text-[9px] font-extrabold uppercase tracking-widest px-2.5 py-1 rounded bg-secondary text-white inline-block mb-1 shadow-sm">⚡ PRECIO PROMOCIONAL</span>`;
                        } else {
                            badgeHtml = `<span class="text-[10px] font-bold tracking-widest text-secondary uppercase block mb-1">Plan Oficial</span>`;
                        }

                        let priceSection = '';
                        if (precioReg && precioReg > parseFloat(plan.precio)) {
                            const ahorro = Math.round((1 - parseFloat(plan.precio) / precioReg) * 100);
                            priceSection = `
                                <div class="mt-auto pt-4 border-t ${dividerColor}">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-xs line-through opacity-60">Antes: $${precioReg.toFixed(2)}</span>
                                        <span class="text-[10px] font-extrabold text-emerald-500 bg-emerald-950/20 px-2 py-0.5 rounded border border-emerald-500/30">
                                            -${ahorro}% Tercera Edad
                                        </span>
                                    </div>
                                    <div class="flex items-end">
                                        <span class="text-3xl font-extrabold tracking-tight">$${parseFloat(plan.precio).toFixed(2)}</span>
                                        <span class="text-xs opacity-50 ml-1 mb-1">/ mes</span>
                                    </div>
                                </div>
                            `;
                        } else {
                            priceSection = `
                                <div class="mt-auto pt-4 border-t ${dividerColor} flex items-end">
                                    <span class="text-3xl font-extrabold tracking-tight">$${parseFloat(plan.precio).toFixed(2)}</span>
                                    <span class="text-xs opacity-50 ml-1 mb-1">/ mes</span>
                                </div>
                            `;
                        }

                        let extraFeature = '';
                        if (isTerceraEdad) {
                            extraFeature = `<li class="flex items-center gap-2 text-emerald-400 font-semibold"><span class="material-symbols-outlined text-xs" data-icon="verified">verified</span> Tarifa preferencial tercera edad</li>`;
                        } else if (isDiscapacidad) {
                            extraFeature = `<li class="flex items-center gap-2 text-emerald-400 font-semibold"><span class="material-symbols-outlined text-xs" data-icon="verified">verified</span> Tarifa preferencial discapacidad</li>`;
                        }

                        const html = `
                            <label class="cursor-pointer group plan-option-label" data-tercera-edad="${isTerceraEdad ? '1' : '0'}" data-discapacidad="${isDiscapacidad ? '1' : '0'}">
                                <input class="hidden peer" name="contract[id_plan]" value="${plan.id_plan}" type="radio" ${index===0 ? 'checked' : ''}/>
                                <div class="relative ${bgColor} ${textColor} p-8 border-2 ${borderClass} transition-all overflow-hidden h-full flex flex-col shadow-sm rounded-xl">
                                    <div class="absolute -right-4 -top-4 ${iconBg} group-hover:scale-110 transition-transform p-8 rounded-full ${opacityClass}">
                                        <span class="material-symbols-outlined text-8xl" data-icon="${iconName}">${iconName}</span>
                                    </div>
                                    <div class="mb-4">
                                        ${badgeHtml}
                                        <h3 class="text-2xl font-extrabold tracking-tight mb-1">${mainName}</h3>
                                        <span class="text-xs font-bold opacity-80 uppercase tracking-widest bg-surface-container px-2.5 py-1 rounded inline-block text-on-surface">${plan.velocidad}</span>
                                    </div>
                                    <ul class="space-y-3 mb-8 text-sm opacity-70 font-medium">
                                        <li class="flex items-center gap-2"><span class="material-symbols-outlined text-xs" data-icon="check">check</span> Servicio Simétrico</li>
                                        <li class="flex items-center gap-2"><span class="material-symbols-outlined text-xs" data-icon="check">check</span> Asistencia Técnica</li>
                                        ${extraFeature}
                                    </ul>
                                    ${priceSection}
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
            errorCedula.classList.add('hidden');
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Evitar envío síncrono para manejar JSON y estado de carga

            updateEmail(); // Garantizar que el correo esté acoplado antes de mandar

            const cedulaVal = inputCedula.value;
            if (!validarCedulaRucEcuador(cedulaVal)) {
                inputCedula.classList.add('border-error', 'ring-1', 'ring-error');
                errorCedula.classList.remove('hidden');
                
                // Animate Scroll to specific wrong input
                inputCedula.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }

            // Deshabilitar botón y mostrar carga para prevenir doble submit (que crearía contratos duplicados)
            const submitBtn = document.getElementById('submit-btn');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="material-symbols-outlined animate-spin align-middle mr-2">autorenew</span> GENERANDO...';
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

<!-- Help Floating Action -->
<button class="fixed bottom-28 right-8 w-14 h-14 bg-[#1a1c1c] text-white rounded-full flex items-center justify-center shadow-[0_10px_40px_-10px_rgba(26,28,28,0.5)] hover:scale-110 active:scale-95 transition-all z-50">
    <span class="material-symbols-outlined text-2xl">question_mark</span>
</button>
@endpush
