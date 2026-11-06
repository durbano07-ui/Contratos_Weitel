{{-- Anexo 2 (Equipos) y Anexo 3 (Instalación). Requiere: $contract, $providerSigImg, $signatureImg --}}

        {{-- ========================================================
             PÁGINA 1: ANEXO 2 - ARRENDAMIENTO O COMPRA DE EQUIPOS
        ======================================================== --}}
        <div style="text-align: center; font-weight: bold; font-size: 11pt; margin-bottom: 4px;">ANEXO 2</div>
        <div style="text-align: center; font-weight: bold; font-size: 10pt; margin-bottom: 15px;">
            ARRENDAMIENTO O COMPRA DE EQUIPOS
        </div>

        <div style="font-weight: bold; font-size: 9pt; margin-bottom: 6px;">
            DETALLE Y CONDICIONES DE EQUIPOS:
        </div>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 8.5pt;">
            <tr>
                <th style="border: 1px solid #000; padding: 4px 6px; text-align: left; font-weight: bold; width: 14%;">CANTIDAD</th>
                <th style="border: 1px solid #000; padding: 4px 6px; text-align: left; font-weight: bold; width: 16%;">PRECIO UNITARIO</th>
                <th style="border: 1px solid #000; padding: 4px 6px; text-align: left; font-weight: bold; width: 20%;">MARCA</th>
                <th style="border: 1px solid #000; padding: 4px 6px; text-align: left; font-weight: bold; width: 20%;">MODELO</th>
                <th style="border: 1px solid #000; padding: 4px 6px; text-align: left; font-weight: bold; width: 16%;">SERIAL</th>
                <th style="border: 1px solid #000; padding: 4px 6px; text-align: left; font-weight: bold; width: 14%;">NUEVO/USADO</th>
            </tr>
            @php
                $equiposList = ($contract->anexo2 && is_array($contract->anexo2->equipos) && count($contract->anexo2->equipos) > 0)
                    ? $contract->anexo2->equipos
                    : (is_array($contract->equipos) ? $contract->equipos : []);
                $minRows = max(4, count($equiposList));
            @endphp
            @for($i = 0; $i < $minRows; $i++)
                @php $eq = $equiposList[$i] ?? null; @endphp
                <tr>
                    <td style="border: 1px solid #000; padding: 4px 6px; height: 18px;">{{ $eq['cantidad'] ?? '' }}</td>
                    <td style="border: 1px solid #000; padding: 4px 6px;">{{ isset($eq['precio_unitario']) && $eq['precio_unitario'] > 0 ? '$' . number_format($eq['precio_unitario'], 2) : '' }}</td>
                    <td style="border: 1px solid #000; padding: 4px 6px;">{{ mb_strtoupper($eq['marca'] ?? '') }}</td>
                    <td style="border: 1px solid #000; padding: 4px 6px;">{{ mb_strtoupper($eq['modelo'] ?? '') }}</td>
                    <td style="border: 1px solid #000; padding: 4px 6px;">{{ mb_strtoupper($eq['serial'] ?? '') }}</td>
                    <td style="border: 1px solid #000; padding: 4px 6px;">{{ mb_strtoupper($eq['estado_equipo'] ?? '') }}</td>
                </tr>
            @endfor
        </table>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 8.5pt;">
            <tr>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold; width: 45%;">CLIENTE NOS COMPRA EQUIPOS A CREDITO</td>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold; width: 27.5%;">
                    SI: 
                </td>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold; width: 27.5%;">
                    NO: X
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold;">CLIENTE NOS ARRIENDA EQUIPOS</td>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold;">
                    SI: X
                </td>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold;">
                    NO: 
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold;">CLIENTE NOS COMPRA EQUIPOS DE CONTADO:</td>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold;">
                    SI: 
                </td>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold;">
                    NO: X
                </td>
            </tr>
        </table>

        @php
            $valArrendamiento = ($contract->plan && $contract->plan->precio > 0)
                ? (float)$contract->plan->precio
                : (($contract->anexo2 && $contract->anexo2->valor_mensual_arrendamiento > 0) ? (float)$contract->anexo2->valor_mensual_arrendamiento : 0);
            $mesesDuracion = $contract->duracion ?? ($contract->anexo2->cantidad_meses ?? '24');
        @endphp
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 25px; font-size: 8.5pt;">
            <tr>
                <th style="border: 1px solid #000; padding: 4px 6px; font-weight: bold; width: 35%; text-align: left;">VALOR MENSUAL POR ARRENDAMIENTO</th>
                <th style="border: 1px solid #000; padding: 4px 6px; font-weight: bold; width: 35%; text-align: left;">VALOR MENSUAL POR COMPRA A CREDITO</th>
                <th style="border: 1px solid #000; padding: 4px 6px; font-weight: bold; width: 30%; text-align: left;">CANTIDAD DE MESES POR COBRAR</th>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 4px 6px; height: 18px;">
                    {{ $valArrendamiento > 0 ? '$' . number_format($valArrendamiento, 2) : '' }}
                </td>
                <td style="border: 1px solid #000; padding: 4px 6px;"></td>
                <td style="border: 1px solid #000; padding: 4px 6px;">
                    {{ $mesesDuracion }}
                </td>
            </tr>
        </table>

        <div style="font-size: 8.5pt; margin-bottom: 30px;">
            Autorización expresa de las partes:
        </div>

        {{-- Firmas Anexo 2 --}}
        <table style="width: 100%; border: none; margin-top: 10px;">
            <tr style="border: none;">
                <td style="border: none; width: 50%; text-align: center; vertical-align: bottom; padding: 0;">
                    @if($providerSigImg)
                        <div style="text-align: center; margin-bottom: 4px;">
                            <img src="{{ $providerSigImg }}" style="max-height: 40px; width: auto;">
                        </div>
                    @else
                        <div style="height: 20px;"></div>
                    @endif
                    <div style="border: 1px solid #000; padding: 2px; text-align: center; font-weight: bold; font-size: 8pt; width: 140px; margin: 0 auto;">PRESTADOR</div>
                </td>
                <td style="border: none; width: 50%; text-align: center; vertical-align: bottom; padding: 0;">
                    @if($signatureImg)
                        <div style="text-align: center; margin-bottom: 4px;">
                            <img src="{{ $signatureImg }}" style="max-height: 40px; width: auto;">
                        </div>
                    @else
                        <div style="height: 20px;"></div>
                    @endif
                    <div style="font-size: 8pt;">____________________________________</div>
                    <div style="font-size: 7.5pt; font-weight: bold; line-height: 1.2; margin-bottom: 4px;">
                        {{ mb_strtoupper($contract->client->nombre ?? '') }} {{ mb_strtoupper($contract->client->apellido ?? '') }}<br>
                        {{ $contract->client->tipo_identificacion ?? 'C.I.' }}: {{ $contract->client->cedula ?? '' }}
                    </div>
                    <div style="border: 1px solid #000; padding: 2px; text-align: center; font-weight: bold; font-size: 8pt; width: 180px; margin: 0 auto;">ABONADO/SUSCRIPTOR</div>
                </td>
            </tr>
        </table>

        {{-- ========================================================
             PÁGINA 2: ANEXO 3 - ACTA DE INSTALACIÓN Y ACTIVACIÓN
        ======================================================== --}}
        <div class="page-break"></div>
        <div style="text-align: center; font-weight: bold; font-size: 11pt; margin-bottom: 4px;">ANEXO 3</div>
        <div style="text-align: center; font-weight: bold; font-size: 10pt; margin-bottom: 15px;">
            ACTA DE INSTALACION Y ACTIVACION
        </div>

        {{-- Dynamic Info Fields --}}
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 12px; font-size: 8.5pt;">
            <tr>
                <td style="font-weight: bold; width: 28%; padding: 4px 0; vertical-align: middle;">Fecha y hora de instalación:</td>
                <td style="padding: 4px 0;">
                    <div style="border: 1px solid #000; padding: 3px 8px; width: 90%;">
                        {{ \Carbon\Carbon::parse($contract->anexo2->completado_en ?? $contract->fecha)->format('d/m/Y') }}
                    </div>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 4px 0; vertical-align: middle;">Lugar de la instalación:</td>
                <td style="padding: 4px 0;">
                    <div style="border: 1px solid #000; padding: 3px 8px; width: 98%;">
                        {{ $contract->direccion_servicio ?? $contract->direccion_instalacion ?? $contract->client->direccion }}
                    </div>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 4px 0; vertical-align: middle;">IP asignada al cliente:</td>
                <td style="padding: 4px 0;">
                    <div style="border: 1px solid #000; padding: 3px 8px; width: 90%; height: 16px;">
                        {{ $contract->anexo2->datos_anexo3['ip_asignada'] ?? '' }}
                    </div>
                </td>
            </tr>
        </table>

        @php
            $a3 = $contract->anexo2->datos_anexo3 ?? [];
            // Si el técnico aún no llenó el Anexo 3, las casillas quedan vacías
            $a3Lleno = !empty($a3);
            $verificoBanda = isset($a3['verifico_ancho_banda']) ? (bool)$a3['verifico_ancho_banda'] : true;
            $puestaTierra = isset($a3['puesta_a_tierra']) ? (bool)$a3['puesta_a_tierra'] : false;
            $bloqueoWeb = $a3['bloqueo_web'] ?? 'No';
            $bloqueoServicios = $a3['bloqueo_servicios'] ?? 'No';
            $bloqueoPuertos = $a3['bloqueo_puertos'] ?? 'No';
        @endphp

        {{-- Table 1 --}}
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 8.5pt;">
            <tr>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold; width: 45%;">Cliente verificó ancho de banda instalado</td>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold; width: 27.5%;">
                    SI {{ ($a3Lleno && ($verificoBanda)) ? 'x' : '' }}
                </td>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold; width: 27.5%;">
                    NO {{ ($a3Lleno && (!$verificoBanda)) ? 'x' : '' }}
                </td>
            </tr>
        </table>

        {{-- Table 2 --}}
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 8.5pt;">
            <tr>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold; width: 45%;">Características de la computadora del cliente</td>
                <td style="border: 1px solid #000; padding: 4px 6px; width: 55%; height: 35px; vertical-align: top;">
                </td>
            </tr>
        </table>

        {{-- Table 3 --}}
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 8.5pt;">
            <tr>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold; width: 45%;">Cliente tiene puesta a tierra</td>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold; width: 27.5%;">
                    SI {{ ($a3Lleno && ($puestaTierra)) ? 'x' : '' }}
                </td>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold; width: 27.5%;">
                    NO {{ ($a3Lleno && (!$puestaTierra)) ? 'x' : '' }}
                </td>
            </tr>
        </table>

        {{-- Table 4: Bloqueos y Material --}}
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 25px; font-size: 8.5pt;">
            <tr>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold; width: 40%;">Cliente pide bloqueo de páginas web</td>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold; width: 8%; text-align: center;">
                    SI {{ ($a3Lleno && (($bloqueoWeb != 'No' && $bloqueoWeb != ''))) ? 'x' : '' }}
                </td>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold; width: 12%;">
                    NO {{ ($a3Lleno && (($bloqueoWeb == 'No' || $bloqueoWeb == ''))) ? 'x' : '' }}
                </td>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold; width: 40%;">
                    DETALLE: {{ ($bloqueoWeb != 'No') ? $bloqueoWeb : '' }}
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold;">Cliente pide bloqueo de servicios</td>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold; text-align: center;">
                    SI {{ ($a3Lleno && (($bloqueoServicios != 'No' && $bloqueoServicios != ''))) ? 'x' : '' }}
                </td>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold;">
                    NO {{ ($a3Lleno && (($bloqueoServicios == 'No' || $bloqueoServicios == ''))) ? 'x' : '' }}
                </td>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold;">
                    DETALLE: {{ ($bloqueoServicios != 'No') ? $bloqueoServicios : '' }}
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold;">Cliente pide bloqueo de puertos</td>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold; text-align: center;">
                    SI {{ ($a3Lleno && (($bloqueoPuertos != 'No' && $bloqueoPuertos != ''))) ? 'x' : '' }}
                </td>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold;">
                    NO {{ ($a3Lleno && (($bloqueoPuertos == 'No' || $bloqueoPuertos == ''))) ? 'x' : '' }}
                </td>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold;">
                    DETALLE: {{ ($bloqueoPuertos != 'No') ? $bloqueoPuertos : '' }}
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 4px 6px; font-weight: bold; vertical-align: top;">
                    DETALLE DE MATERIAL UTILIZADO PARA INSTALACION POR PARTE DE PRESTADOR
                </td>
                <td colspan="3" style="border: 1px solid #000; padding: 4px 6px; height: 40px; vertical-align: top;">
                </td>
            </tr>
        </table>

        <div style="font-size: 8.5pt; margin-bottom: 30px;">
            Autorización expresa de las partes:
        </div>

        {{-- Firmas Anexo 3 --}}
        <table style="width: 100%; border: none; margin-top: 10px;">
            <tr style="border: none;">
                <td style="border: none; width: 50%; text-align: center; vertical-align: bottom; padding: 0;">
                    @if($providerSigImg)
                        <div style="text-align: center; margin-bottom: 4px;">
                            <img src="{{ $providerSigImg }}" style="max-height: 40px; width: auto;">
                        </div>
                    @else
                        <div style="height: 20px;"></div>
                    @endif
                    <div style="border: 1px solid #000; padding: 2px; text-align: center; font-weight: bold; font-size: 8pt; width: 140px; margin: 0 auto;">PRESTADOR</div>
                </td>
                <td style="border: none; width: 50%; text-align: center; vertical-align: bottom; padding: 0;">
                    @if($signatureImg)
                        <div style="text-align: center; margin-bottom: 4px;">
                            <img src="{{ $signatureImg }}" style="max-height: 40px; width: auto;">
                        </div>
                    @else
                        <div style="height: 20px;"></div>
                    @endif
                    <div style="font-size: 8pt;">____________________________________</div>
                    <div style="font-size: 7.5pt; font-weight: bold; line-height: 1.2; margin-bottom: 4px;">
                        {{ mb_strtoupper($contract->client->nombre ?? '') }} {{ mb_strtoupper($contract->client->apellido ?? '') }}<br>
                        {{ $contract->client->tipo_identificacion ?? 'C.I.' }}: {{ $contract->client->cedula ?? '' }}
                    </div>
                    <div style="border: 1px solid #000; padding: 2px; text-align: center; font-weight: bold; font-size: 8pt; width: 180px; margin: 0 auto;">ABONADO/SUSCRIPTOR</div>
                </td>
            </tr>
        </table>
