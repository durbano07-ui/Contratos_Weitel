<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Contrato de Adhesión - WEITEL BOLIVAR</title>
    <style>
        @page {
            margin: 95px 1.5cm 50px 1.5cm;
        }

        body {
            font-family: 'Calibri', 'Helvetica', 'Arial', sans-serif;
            font-size: 9pt;
            line-height: 1.25;
            color: #000;
        }

        header {
            position: fixed;
            top: -75px;
            left: 0px;
            right: 0px;
            height: 65px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            margin: 0;
        }

        .header-table td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }

        h1,
        h2,
        h3 {
            font-weight: bold;
            margin-top: 1.2em;
            margin-bottom: 0.5em;
        }

        h1 {
            font-size: 16pt;
            text-align: center;
            margin-bottom: 0.8em;
        }

        h2 {
            font-size: 13pt;
        }

        .clause-title {
            font-weight: bold;
            margin-top: 1em;
            margin-bottom: 0.3em;
            font-size: 10.5pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0.8em 0;
            page-break-inside: avoid;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 5px 8px;
            vertical-align: middle;
            font-size: 10pt;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        .table-no-border,
        .table-no-border td {
            border: none;
        }

        .table-fillable td,
        .table-fillable th {
            padding: 2px 5px;
            font-size: 8.5pt;
            height: 18px;
        }

        .input-line {
            line-height: 1.8;
        }

        .signature-table {
            width: 100%;
            border: none;
            margin-top: 60px;
            text-align: center;
        }

        .signature-table td {
            border: none;
            width: 50%;
            padding: 40px 10px 10px;
            vertical-align: bottom;
        }

        .page-break {
            page-break-before: always;
        }

        /* Evitar que títulos de cláusula queden solos al pie de página */
        .clause-title, p > strong:first-child {
            page-break-after: avoid;
        }

        .text-center {
            text-align: center;
        }

        .underline {
            text-decoration: underline;
        }

        .mark {
            background-color: #f9f2b0;
            padding: 0 2px;
        }

        .checkbox-symbol {
            font-family: monospace;
            white-space: pre;
        }

        .anexo-title {
            font-size: 13pt;
            font-weight: bold;
            text-align: center;
            margin: 1.5em 0 1em;
        }
    </style>
</head>

<body>

    @php
        $providerSigImg = null;
        $possibleSigPaths = [
            storage_path('app/public/firma_prestador.png'),
            storage_path('app/public/firma_prestador.jpg'),
            storage_path('app/public/firma_prestador.jpeg'),
            public_path('img/firma_prestador.png'),
            public_path('img/firma_prestador.jpg'),
            public_path('img/firma_prestador.jpeg'),
        ];
        foreach ($possibleSigPaths as $path) {
            if (file_exists($path) && filesize($path) > 0) {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $mime = in_array(strtolower($ext), ['jpg', 'jpeg']) ? 'image/jpeg' : 'image/png';
                $content = @file_get_contents($path);
                if ($content) {
                    $providerSigImg = 'data:' . $mime . ';base64,' . base64_encode($content);
                    break;
                }
            }
        }
    @endphp

    <header>
        <table class="header-table">
            <tr>
                <td style="width: 100%; text-align: right;">
                    <img src="{{ public_path('img/logo_weitel.png') }}" alt="Weitel Logo"
                        style="max-height: 60px; width: auto;">
                </td>
            </tr>
        </table>
    </header>

    <main>

        {{-- CONTRATO PRINCIPAL --}}
        <h1 style="text-align: center; font-size: 14pt; font-weight: bold; margin-bottom: 12px; margin-top: 0;">CONTRATO DE ADHESIÓN</h1>

        @php
            $signatureImg = null;
            if ($contract->anexo2 && !empty($contract->anexo2->firma_cliente)) {
                $rawSig = trim($contract->anexo2->firma_cliente);
                if (str_starts_with($rawSig, 'data:image') && strlen($rawSig) > 100) {
                    $signatureImg = $rawSig;
                }
            }
        @endphp

        {{-- CLAUSULA PRIMERA --}}
        <div style="font-weight: bold; font-size: 10.5pt; margin-bottom: 8px;">
            CLAUSULA PRIMERA. - Lugar y fecha. - Datos de los Comparecientes:
        </div>

        <div style="margin-bottom: 10px; font-size: 10pt;">
            <strong>Fecha:</strong>
            <span style="border: 1px solid #000; padding: 2px 12px; display: inline-block; font-size: 10pt;">
                {{ \Carbon\Carbon::parse($contract->fecha)->format('d') }} de {{ \Carbon\Carbon::parse($contract->fecha)->translatedFormat('F') }} de {{ \Carbon\Carbon::parse($contract->fecha)->format('Y') }}
            </span>
        </div>

        <div style="font-weight: bold; font-size: 10.5pt; margin-bottom: 4px;">Datos del prestador</div>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 12px; font-size: 9.5pt;">
            <tr>
                <td style="border: 1px solid #000; padding: 3px 6px; font-weight: bold; width: 25%;">Nombre/Razón Social:</td>
                <td style="border: 1px solid #000; padding: 3px 6px; font-weight: bold;" colspan="3">JUAN CARLOS PAGUAY QUIMBIURCO</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px 6px; font-weight: bold;">Nombre comercial:</td>
                <td style="border: 1px solid #000; padding: 3px 6px; font-weight: bold;" colspan="3">WEITEL BOLIVAR</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px 6px; font-weight: bold;">Dirección:</td>
                <td style="border: 1px solid #000; padding: 3px 6px;" colspan="3">SAN MIGUEL, CONVENCION Y REGULO DE MORA</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px 6px;" colspan="4">
                    <strong>Provincia: BOLIVAR</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Ciudad: SAN MIGUEL</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Cantón: SAN MIGUEL</strong>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px 6px;" colspan="2">
                    <strong>Parroquia:</strong> CENTRAL
                </td>
                <td style="border: 1px solid #000; padding: 3px 6px;" colspan="2">
                    <strong>No. Teléfono:</strong> 0967189813/0961908527
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px 6px;" colspan="2">
                    <strong>RUC:</strong> 1717486532001
                </td>
                <td style="border: 1px solid #000; padding: 3px 6px;" colspan="2">
                    <strong>Correo Electrónico:</strong> juanpaguay2015@gmail.com
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px 6px;" colspan="4">
                    <strong>Sitio web:</strong> <a href="https://weitel.ec" style="color:blue; text-decoration:underline;">https://weitel.ec</a>
                </td>
            </tr>
        </table>

        <div style="font-weight: bold; font-size: 10.5pt; margin-bottom: 4px;">Datos del abonado/suscriptor</div>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 6px; font-size: 9.5pt;">
            <tr>
                <td style="border: 1px solid #000; padding: 3px 6px;" colspan="4">
                    <strong>Nombres/Razón social:</strong> {{ mb_strtoupper($contract->client->nombre) }} {{ mb_strtoupper($contract->client->apellido ?? '') }}
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px 6px;" colspan="2">
                    <strong>Cédula/RUC:</strong> {{ $contract->client->cedula }}
                </td>
                <td style="border: 1px solid #000; padding: 3px 6px;" colspan="2">
                    <strong>Email:</strong> {{ strtolower($contract->client->email ?? '') }}
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px 6px;" colspan="4">
                    <strong>Dirección:</strong> {{ $contract->client->direccion }}
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px 6px;" colspan="4">
                    <strong>Provincia:</strong> {{ $contract->client->provincia ?? 'Bolívar' }} &nbsp;&nbsp;&nbsp;&nbsp; <strong>Ciudad:</strong> {{ $contract->client->ciudad ?? 'San Miguel' }} &nbsp;&nbsp;&nbsp;&nbsp; <strong>Cantón:</strong> {{ $contract->client->canton ?? 'San Miguel' }} &nbsp;&nbsp;&nbsp;&nbsp; <strong>Parroquia:</strong> {{ mb_strtoupper($contract->client->parroquia ?? $contract->client->canton ?? 'San Miguel') }}
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px 6px;" colspan="4">
                    <strong>Dirección donde será prestado el servicio:</strong> {{ $contract->direccion_servicio ?? $contract->client->direccion }}
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px 6px;" colspan="4">
                    <strong>Número telefónico de referencia fijo/móvil:</strong> {{ $contract->client->n_telefono ?? $contract->client->telefono }}
                </td>
            </tr>
        </table>

        <div style="font-size: 9pt; margin-bottom: 10px; line-height: 1.3;">
            ¿El abonado es de la tercera edad o discapacitado? &nbsp;&nbsp;&nbsp;&nbsp; Si.......{{ $contract->beneficio_ley ? 'x' : '' }} &nbsp;&nbsp;&nbsp;&nbsp; No.......{{ !$contract->beneficio_ley ? 'x' : '' }}.<br>
            (En caso afirmativo, aplica tarifa preferencial de acuerdo con el plan del prestador).
        </div>

        {{-- CLAUSULA SEGUNDA --}}
        <p style="font-size: 9pt; margin-bottom: 3px; line-height: 1.25;">
            <strong>CLAUSULA SEGUNDA. - Objeto:</strong> El prestador del servicio se compromete a proporcionar al abonado/suscriptor el/los siguiente (s) servicio (s), para lo cual el prestador dispone de los correspondientes títulos habilitantes otorgados por la ARCOTEL, de conformidad con el ordenamiento jurídico vigente:
        </p>

        @php
            $services = [
                '- Móvil Avanzado (SMA)' => '',
                '- Móvil Avanzado a través de Operador Móvil Virtual (OMV)' => '',
                '- Telefonía Fija' => '',
                '- Telecomunicaciones por Satélite' => '',
                '- Valor Agregado' => '',
                '- Acceso a internet' => 'X',
                '- Troncalizados' => '',
                '- Comunales' => '',
                '- Audio y video por suscripción' => '',
                '- Portador' => ''
            ];
        @endphp
        <table style="width: 55%; border-collapse: collapse; margin-top: 2px; margin-bottom: 3px; font-size: 7.5pt; line-height: 1.0;">
            @foreach($services as $service => $mark)
                <tr>
                    <td style="border: 1px solid #000; padding: 0px 3px; width: 85%;">{{ $service }}</td>
                    <td style="border: 1px solid #000; padding: 0px 3px; width: 15%; text-align: center; font-weight: bold;">{{ $mark }}</td>
                </tr>
            @endforeach
        </table>

        <p style="font-size: 8.5pt; margin-bottom: 5px; line-height: 1.2;">
            Las Condiciones del/los servicio(s) que el abonado va a contratar se encuentran detalladas en el Anexo No. 1, el cual forma parte integrante del presente contrato.
        </p>

        {{-- CLAUSULA TERCERA --}}
        <p style="font-size: 9pt; margin-bottom: 4px; line-height: 1.25;">
            <strong>CLAUSULA TERCERA. - Vigencia del Contrato:</strong> El presente contrato tendrá una duración de {{ $contract->duracion ?? '24' }} meses y entrará en vigencia, a partir de la fecha de instalación y prestación efectiva del servicio, La fecha inicial considerada para facturación para cada uno de los servicios contratados debe ser la de la activación del servicio.
        </p>
        <p style="font-size: 9pt; margin-bottom: 4px; line-height: 1.25;">
            El prestador del servicio, previo a la firma o aceptación del contrato, deberá verificar la identidad del abonado, cliente, usuario o suscriptor. El prestador debe de indicar los mecanismos de identificación disponibles para que el abonado elija, siguiendo la Ley Orgánica de Protección de Datos Personales y la Ley Orgánica del Sistema Nacional de Registro de Datos Públicos y sus respectivos reglamentos.
        </p>

        <p style="margin-bottom: 8px; line-height: 1.25;">Las partes se comprometen a respetar el plazo de vigencia pactado, sin perjuicio de que el abonado/suscriptor
            pueda darlo por terminado unilateralmente, en cualquier tiempo, previa notificación física o electrónica,
            con por lo menos quince (15) días de anticipación, conforme lo dispuesto en las Leyes Orgánicas de
            Telecomunicaciones y de Defensa del Consumidor y sin que para ello esté obligado a cancelar multas o
            recargos de valores de ninguna naturaleza.</p>
        <p style="margin-bottom: 4px; line-height: 1.25;">El abonado acepta la renovación automática sucesiva del contrato en las mismas condiciones de este contrato,
            independientemente de su derecho a terminar la relación contractual conforme la legislación aplicable, o
            solicitar en cualquier tiempo, con hasta quince (15) días de antelación a la fecha de renovación, su
            decisión de no renovación:</p>
        <div style="margin-bottom: 8px; margin-top: 2px;">
            Si...... <span style="display: inline-block; width: 14px; height: 14px; border: 1px solid #7da64e; background-color: {{ ($contract->renovacion_automatica ?? true) ? '#a8d08d' : '#ffffff' }}; vertical-align: middle; margin-right: 40px;"></span>
            No...... <span style="display: inline-block; width: 14px; height: 14px; border: 1px solid #7da64e; background-color: {{ !($contract->renovacion_automatica ?? true) ? '#a8d08d' : '#ffffff' }}; vertical-align: middle;"></span>
        </div>
        <p style="margin-bottom: 10px; line-height: 1.25;">Todas las promociones, servicios adicionales y suplementarios que ofrezca el prestador con carácter gratuito,
            no requerirán autorización y aceptación; la prestación de dichos servicios no debe generar al abonado,
            suscriptor o cliente, obligaciones de retribución de ninguna clase o de permanencia mínima. El abonado,
            suscriptor o cliente podrá solicitar al prestador el cese de dichos servicios, lo cual deberá ser realizado
            por el prestador en un plazo máximo de cinco (5) días a partir del pedido del abonado, suscriptor o cliente,
            sin que, bajo ninguna condición, se exijan o establezcan requisitos de ninguna índole, ni valores o pagos
            asociados a dicho cese.</p>

        {{-- CLAUSULA CUARTA --}}
        <p style="margin-bottom: 10px; line-height: 1.25;">
            <strong>CLAUSULA CUARTA. - Suspensión del Servicio. -</strong> Los servicios contratados podrán ser suspendidos debido a las siguientes causas: a) Por falta de pago del
            abonado; b) Caso fortuito o fuerza mayor que obliguen a la suspensión del servicio, calificada por la
            ARCOTEL, en este caso sólo se podrá cobrar por los servicios efectivamente prestados; c) Por uso indebido de
            los servicios contratados o uso ilegal de los mismos; d) Por mandato judicial; y e) Por otras causas
            previstas en el ordenamiento vigente.
        </p>

        {{-- CLAUSULA QUINTA --}}
        <p style="margin-bottom: 6px; line-height: 1.25;">
            <strong>CLAUSULA QUINTA. - Terminación del contrato. -</strong> Los contratos podrán darse por terminado por cualquiera de las siguientes causas: <strong>Por el prestador
                del Servicio:</strong> a) Incumplimiento de las condiciones contractuales del abonado, o la consignación
            de datos erróneos o falsos, b) Si el abonado o cliente utiliza los servicios contratados para fines
            distintos a los convenidos o si los utiliza en prácticas contrarias a la ley, c) Por vencimiento del plazo
            de vigencia del contrato, cuando no exista renovación, d) Por falta de pago, e) Por las demás causas
            previstas en el Ordenamiento Jurídico Vigente.
        </p>
        <p style="margin-bottom: 6px; line-height: 1.25;"><strong>Por abonado o cliente</strong>: a) Por decisión unilateral del abonado, suscriptor o cliente de dar
            por terminado el contrato. b) Por vencimiento del plazo de vigencia del contrato, cuando no exista
            renovación pactada. c) Por incumplimiento de las condiciones contractuales pactadas. d) Por las demás causas
            previstas en el Ordenamiento Jurídico Vigente.</p>
        <p style="margin-bottom: 6px; line-height: 1.25;">El no cancelar los saldos que estuvieron pendientes al momento de la presentación de la solicitud de
            terminación no podrá ser considerado como un impedimento para procesar y cancelar el contrato. Esto no
            significa que el prestador haya renunciado al cobro de dichos valores ya que los podrá cobrar en la forma y
            plazos establecidos en el ordenamiento jurídico a través de los medios legales correspondientes</p>
        <p style="margin-bottom: 6px; line-height: 1.25;">Los abonados, clientes o suscriptores podrán ejercer su derecho de devolución o cambio del servicio dentro
            del término de quince (15) días posteriores a la activación del servicio, sin la necesidad de presentar
            requisitos adicionales, conforme al ordenamiento jurídico vigente. La devolución del servicio implicará la
            cesación inmediata del contrato de provisión del mismo. El cambio de servicio se efectuará a través de la
            modificación total o parcial de las condiciones de prestación previamente pactadas.</p>
        <p style="margin-bottom: 10px; line-height: 1.25;">El prestador del servicio no podrá cobrar ningún valor por instalación cuando la solicitud de devolución se
            deba a problemas técnicos o el incumplimiento de una o varias de las condiciones contractuales por parte del
            prestador, comprobados por este en el término de hasta cinco (5) días después de presentada la solicitud. En
            tales casos, los abonados, suscriptores o clientes deberán detallar expresamente los problemas técnicos o
            incumplimientos aducidos, ya sea por medio físico, electrónico o telefónico.</p>

        {{-- CLAUSULA SEXTA --}}
        <p style="margin-bottom: 4px; line-height: 1.25;">
            <strong>CLAUSULA SEXTA. - Permanencia mínima:</strong>
        </p>
        <p style="margin-bottom: 4px; line-height: 1.25;">
            ¿El abonado se acoge al período de permanencia mínima de {{ $contract->duracion ?? '24' }} meses en la prestación del servicio contratado?
        </p>
        <div style="margin-bottom: 8px; margin-top: 2px;">
            Si...... <span style="display: inline-block; width: 14px; height: 14px; border: 1px solid #7da64e; background-color: {{ ($contract->permanencia_minima ?? true) ? '#a8d08d' : '#ffffff' }}; vertical-align: middle; margin-right: 40px;"></span>
            No...... <span style="display: inline-block; width: 14px; height: 14px; border: 1px solid #7da64e; background-color: {{ !($contract->permanencia_minima ?? true) ? '#a8d08d' : '#ffffff' }}; vertical-align: middle;"></span>
        </div>
        <p style="margin-bottom: 0px; line-height: 1.25;">
            Los beneficios de la permanencia mínima son:
        </p>

        <p style="margin-top: 0px; margin-bottom: 8px; line-height: 1.25;">
            <strong>No pago por el costo de instalación del servicio si cumple el tiempo, caso contrario cancelara un
                proporcional del costo de instalación.</strong>
        </p>
        <p style="margin-bottom: 10px; line-height: 1.25;">La permanencia mínima se acuerda, sin perjuicio de que el abonado/suscriptor conforme lo determina la Ley
            Orgánica de Telecomunicaciones, puede dar por terminado el contrato en forma unilateral y anticipada, y en
            cualquier tiempo previa notificación por medios físicos, telefónicos o electrónicos al prestador, con por lo
            menos quince (15) días calendario de anticipación, El contrato terminará quince (15) días calendario
            posteriores a la fecha de presentación de la solicitud.</p>

        {{-- CLAUSULA SEPTIMA --}}
        <p style="margin-bottom: 8px; line-height: 1.25;">
            <strong>CLAUSULA SEPTIMA. - Tarifa y forma de pago;</strong> Las tarifas o valores mensuales a ser cancelados por cada uno de los servicios contratados por el abonado estará determinada en la ficha de cada servicio, que constan en el Anexo 1f.... y el pago se realizará, de la siguiente forma:
        </p>
        <table style="width: 75%; border-collapse: collapse; margin-top: 4px; margin-bottom: 8px; font-size: 8.5pt;">
            <tr>
                <th style="border: 1px solid #000; padding: 3px 6px;"></th>
                <th style="border: 1px solid #000; padding: 3px 6px; width: 14%; text-align: center;">SI</th>
                <th style="border: 1px solid #000; padding: 3px 6px; width: 14%; text-align: center;">NO</th>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px 6px;">- Pago directo en cajas del prestador del servicio</td>
                <td style="border: 1px solid #000; padding: 3px 6px; text-align: center;">
                    {{ ($contract->payment == 'direct' || $contract->metodo_pago == 'direct') ? 'X' : '' }}
                </td>
                <td style="border: 1px solid #000; padding: 3px 6px; text-align: center;"></td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px 6px;">- Débito automático cuenta de ahorro o corriente</td>
                <td style="border: 1px solid #000; padding: 3px 6px; text-align: center;">
                    {{ ($contract->payment == 'auto' || $contract->metodo_pago == 'auto') ? 'X' : '' }}
                </td>
                <td style="border: 1px solid #000; padding: 3px 6px; text-align: center;"></td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px 6px;">- Pago en ventanilla de locales autorizados</td>
                <td style="border: 1px solid #000; padding: 3px 6px; text-align: center;">
                    {{ ($contract->payment == 'window' || $contract->metodo_pago == 'window') ? 'X' : '' }}
                </td>
                <td style="border: 1px solid #000; padding: 3px 6px; text-align: center;"></td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px 6px;">- Débito con tarjeta de crédito</td>
                <td style="border: 1px solid #000; padding: 3px 6px; text-align: center;">
                    {{ ($contract->payment == 'card' || $contract->metodo_pago == 'card') ? 'X' : '' }}
                </td>
                <td style="border: 1px solid #000; padding: 3px 6px; text-align: center;"></td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px 6px;">- Transferencia via medios electrónicos</td>
                <td style="border: 1px solid #000; padding: 3px 6px; text-align: center;">
                    {{ ($contract->payment == 'transfer' || $contract->metodo_pago == 'transfer') ? 'X' : '' }}
                </td>
                <td style="border: 1px solid #000; padding: 3px 6px; text-align: center;"></td>
            </tr>
        </table>
        <p style="margin-bottom: 8px; line-height: 1.25;">La tarifa correspondiente al servicio contratado y efectivamente prestado, estará dentro de los techos tarifarios señalados por la ARCOTEL y en los títulos habilitantes correspondientes, en caso de que se establezcan, de conformidad con el ordenamiento jurídico vigente.</p>
        <p style="margin-bottom: 10px; line-height: 1.25;">En caso de que el abonado o suscriptor desee cambiar su modalidad de pago a otra de las disponibles, deberá comunicar al prestador del servicio con quince (15) dias de anticipación. El prestador del servicio, luego de haber sido comunicado, instrumentará la nueva forma de pago.</p>

        {{-- CLAUSULA OCTAVA --}}
        <p style="margin-bottom: 10px; line-height: 1.25;">
            <strong>CLAUSULA OCTAVA.- Compra, Arrendamiento de Equipos:</strong> (Cuando sea procedente el arrendamiento o adquisición de equipos, por parte del abonado, toda la información pertinente será detallada en un <strong>Anexo adicional</strong>, suscrito por el abonado el cual contendrá los temas relacionados a las condiciones de los equipos adquiridos/arrendados, entre otras características se deberá incluir: cantidad, precio, marca, estado, y las condiciones de tal adquisición o arrendamiento, particularmente el tiempo en el que se pagará el arrendamiento o la compra del equipo, el valor mensual a cancelar o las condiciones de pago).
        </p>

        {{-- CLAUSULA NOVENA --}}
        <p style="margin-bottom: 10px; line-height: 1.25;">
            <strong>CLAUSULA NOVENA.- Uso de información personal:</strong> Los datos personales que los usuarios proporcionen a los prestadores de servicios del régimen general de telecomunicaciones, no podrán ser usados para la promoción comercial de servicios o productos, inclusive de la propia operadora; salvo autorización y consentimiento expreso del abonado/suscriptor, el que constará como instrumento separado y distinto al presente contrato de prestación de servicios (contrato de adhesión) a través de medios físicos o electrónicos. En dicho instrumento se deberá dejar constancia expresa de los datos personales o información que están expresamente autorizadas; el plazo de la autorización y el objetivo que esta utilización persigue, conforme lo dispuesto en el artículo 121 del Reglamento General a la Ley Orgánica de Telecomunicaciones, Ley Orgánica de Protección de Datos Personales, su Reglamento General y las directrices emitidas por la Autoridad de Protección de Datos.
        </p>

        {{-- CLAUSULA DECIMA --}}
        <p style="margin-bottom: 6px; line-height: 1.25;">
            <strong>CLAUSULA DECIMA. - - Reclamos y soporte técnico:</strong> El "ABONADO/SUSCRIPTOR" podrá requerir soporte técnico o presentar reclamos al prestador de servicios a través de los siguientes medios o puntos:
        </p>
        <div style="margin-bottom: 10px; line-height: 1.35; padding-left: 0px;">
            - Email: <strong>juanpaguay2015@gmail.com</strong><br>
            - Página Web: <a href="https://weitel.ec" style="color:blue; text-decoration:underline;">https://weitel.ec</a><br>
            - Dirección: San Miguel, Convención y Regulo De Mora<br>
            - Horarios de atención: <strong>lunes a viernes de 08H00 a 17H00.</strong><br>
            - Teléfono celular: 0961908527/0967189813
        </div>

        <p style="margin-bottom: 0px; line-height: 1.25;">
            Para la atención de reclamos NO resueltos por el prestador, el abonado también podrá presentar sus denuncias y reclamos ante la Agencia de Regulación y Control (ARCOTEL) por cualquiera de los siguientes canales de atención:
        </p>

        <p style="margin-top: 0px; margin-bottom: 6px; line-height: 1.2;">
            a) Atención Presencial (Oficinas de la ARCOTEL).<br>
            b) PBX-Directo Matriz, Coordinaciones Zonales y Oficinas Técnicas.<br>
            c) Call Center (llamadas gratuitas al número 1800-567567 o número que designe la ARCOTEL).<br>
            d) Correo Tradicional (oficios), o;<br>
            e) Cualquier otro medio tecnológico o aplicativo que la ARCOTEL ponga a disposición
        </p>

        {{-- CLAUSULA DECIMA PRIMERA --}}
        <p style="margin-bottom: 6px; line-height: 1.2;">
            <strong>CLAUSULA DECIMA PRIMERA. - Normativa Aplicable:</strong> En la prestación del servicio, se entienden incluidos todos los derechos y obligaciones de los abonados/suscriptores, establecidos en las normas jurídicas aplicables, así como también los derechos y obligaciones de los prestadores de servicios de telecomunicaciones y/o servicios de radiodifusión por suscripción, dispuestos en el marco regulatorio.
        </p>

        {{-- CLAUSULA DECIMA SEGUNDA --}}
        <p style="margin-bottom: 4px; line-height: 1.2;">
            <strong>CLAUSULA DECIMA SEGUNDA. - Controversias:</strong> Las diferencias que surjan de la ejecución del presente Contrato, podrán ser resueltas por mutuo acuerdo entre las partes, sin perjuicio de que el abonado o suscriptor acuda con su reclamo, queja o denuncia, ante las autoridades administrativas que correspondan. De no llegarse a una solución, cualquiera de las partes podrá acudir ante los jueces competentes.
        </p>
        <p style="margin-bottom: 4px; line-height: 1.2;">
            No obstante, lo indicado, las partes pueden pactar adicionalmente, someter sus controversias ante un centro de mediación o arbitraje, si así lo deciden expresamente, en cuyo caso el abonado/suscriptor deberá señalarlo en forma expresa.
        </p>
        <p style="margin-bottom: 4px; line-height: 1.2;">
            El abonado, en caso de conflicto, acepta someterse a la mediación o arbitraje (puede significar costos en los que debe incurrir el abonado/suscriptor - No aplica a Empresas Públicas prestadoras de servicios de telecomunicaciones).
        </p>
        <div style="margin-bottom: 4px; margin-top: 2px;">
            SI...... <span style="display: inline-block; width: 14px; height: 14px; border: 1px solid #7da64e; background-color: #a8d08d; vertical-align: middle; margin-right: 30px;"></span>
            NO..... <span style="display: inline-block; width: 14px; height: 14px; border: 1px solid #7da64e; background-color: #ffffff; vertical-align: middle;"></span>
        </div>
        <p style="margin-bottom: 2px; line-height: 1.2;">Firma de aceptación-sujeción a arbitraje:</p>
        <div style="margin-top: 28px; margin-bottom: 6px;">
            @if($signatureImg)
                <img src="{{ $signatureImg }}" style="max-height: 35px; width: auto; margin-top: -30px; margin-bottom: 2px;"><br>
            @endif
            .........................................
        </div>

        {{-- CLAUSULA DECIMA TERCERA --}}
        <p style="margin-bottom: 6px; line-height: 1.2;">
            <strong>CLAUSULA DECIMA TERCERA.- Anexos:</strong> Es parte integrante del presente contrato el Anexo 1 “SERVICIO DE ACCESO A INTERNET”, Anexo 2 “ARRENDAMIENTO O COMPRA DE EQUIPOS” , Anexo 3 “ACTA DE INSTALACION Y ACTIVACION “, Anexo 4 “FORMA DE PAGO”, así como los demás anexos y documentos que se incorporen de conformidad con el ordenamiento jurídico.
        </p>

        {{-- CLAUSULA DECIMA CUARTA --}}
        <p style="margin-bottom: 6px; line-height: 1.2;">
            <strong>CLAUSULA DECIMA CUARTA.- Notificaciones y Domicilio:</strong> Las notificaciones que corresponda, serán entregadas en el domicilio de cada una de las partes señalado en la cláusula primera del presente contrato. Cualquier cambio de domicilio debe ser comunicado por escrito a la otra parte en un plazo de 10 días, a partir del día siguiente en que el cambio se efectúe.
        </p>

        {{-- CLAUSULA DECIMA QUINTA --}}
        <p style="margin-bottom: 4px; line-height: 1.2;">
            <strong>CLAUSULA DECIMA QUINTA. - Empaquetamiento de servicios:</strong>
        </p>
        <div style="margin-bottom: 4px;">
            La contratación incluye empaquetamiento de servicios: Si.... <span style="display: inline-block; width: 14px; height: 14px; border: 1px solid #7da64e; background-color: #ffffff; vertical-align: middle; margin-right: 30px;"></span> NO..... <span style="display: inline-block; width: 14px; height: 14px; border: 1px solid #7da64e; background-color: #a8d08d; vertical-align: middle;"></span>
        </div>
        <p style="margin-bottom: 3px; line-height: 1.2;">
            Especificar los servicios del paquete y los beneficios para cada uno, incluyendo las tarifas aplicables:
        </p>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 6px; font-size: 8pt;">
            <tr>
                <th style="border: 1px solid #000; padding: 2px 4px; text-align: left; font-weight: bold; background-color: #f2f2f2;">PLAN CONTRATO</th>
                <th style="border: 1px solid #000; padding: 2px 4px; text-align: left; font-weight: bold; background-color: #f2f2f2;">MEGAS</th>
                <th style="border: 1px solid #000; padding: 2px 4px; text-align: left; font-weight: bold; background-color: #f2f2f2;">TARIFA SIN IVA</th>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 2px 4px;">{{ mb_strtoupper($contract->plan->nombre_plan ?? 'WEITEL HOME ESTUDIANTIL') }}</td>
                <td style="border: 1px solid #000; padding: 2px 4px;">{{ $contract->plan->velocidad ?? '12' }}</td>
                <td style="border: 1px solid #000; padding: 2px 4px;">{{ number_format(($contract->plan->precio ?? 20) / 1.15, 2) }}</td>
            </tr>
        </table>

        <p style="margin-bottom: 4px; line-height: 1.2;">
            El abonado acepta el presente contrato con sus términos y condiciones y demás documentos anexos para lo cual deja constancia de lo anterior y firman junto con (WEITEL BOLIVAR) en tres ejemplares del mismo tenor, en el cantón {{ $contract->base ?? 'San Miguel' }} a los {{ \Carbon\Carbon::parse($contract->fecha)->format('d') }} días del mes de {{ \Carbon\Carbon::parse($contract->fecha)->translatedFormat('F') }} del año {{ \Carbon\Carbon::parse($contract->fecha)->format('Y') }}
        </p>
        <p style="margin-bottom: 8px; line-height: 1.2;">
            <strong>La fecha de inscripción del modelo de contrato de adhesión que se utiliza es el 20 de diciembre del 2024</strong>
        </p>

        <p style="margin-bottom: 2px; font-weight: bold;">Firman las partes:</p>
        <table style="width: 100%; border: none; margin-top: 2px;">
            <tr style="border: none;">
                <td style="border: none; width: 50%; text-align: center; vertical-align: bottom; padding: 0;">
                    @if($providerSigImg)
                        <div style="text-align: center; margin-bottom: 4px;">
                            <img src="{{ $providerSigImg }}" style="max-height: 40px; width: auto;">
                        </div>
                    @else
                        <div style="height: 60px;"></div>
                    @endif
                    <div style="font-size: 7.5pt; font-weight: bold; line-height: 1.2; margin-bottom: 4px;">
                        JUAN CARLOS PAGUAY QUIMBIURCO<br>
                        PRESTADOR
                    </div>
                </td>
                <td style="border: none; width: 50%; text-align: center; vertical-align: bottom; padding: 0;">
                    @if($signatureImg)
                        <img src="{{ $signatureImg }}" style="max-height: 38px; width: auto; margin-bottom: -6px;"><br>
                    @else
                        <div style="height: 60px;"></div>
                    @endif
                    ____________________________________<br>
                    <span style="font-size: 8pt; font-weight: bold;">
                        {{ mb_strtoupper($contract->client->nombre) }} {{ mb_strtoupper($contract->client->apellido ?? '') }}<br>
                        {{ $contract->client->tipo_identificacion }} {{ $contract->client->cedula }}<br>
                        ABONADO/SUSCRIPTOR
                    </span>
                </td>
            </tr>
        </table>

        {{-- ANEXO 1 --}}
        <div class="page-break"></div>
        <div style="text-align: center; font-weight: bold; font-size: 11pt; margin-bottom: 4px;">ANEXO 1</div>
        <div style="border: 1px solid #000; text-align: center; font-weight: bold; padding: 2px; font-size: 9.5pt; margin-bottom: 4px; background-color: #f2f2f2;">
            SERVICIO DE ACCESO A INTERNET
        </div>

        <div style="border: 1px solid #000; padding: 2px 6px; font-size: 8.5pt; font-weight: bold; margin-bottom: 4px;">
            FECHA: ________ <strong>{{ \Carbon\Carbon::parse($contract->fecha)->format('d') }}</strong> ________ de ___ <strong>{{ \Carbon\Carbon::parse($contract->fecha)->translatedFormat('F') }}</strong> ________ del <strong>{{ \Carbon\Carbon::parse($contract->fecha)->format('Y') }}</strong>
        </div>

        @php
            $tipoPlanNombre = mb_strtoupper($contract->plan->type->nombre_tipo ?? '');
            $nombrePlanTxt  = mb_strtoupper($contract->plan->nombre_plan ?? '');
            $idTipoPlan     = $contract->plan->id_tipo ?? null;

            // Determinar si es radioenlace / inalámbrico o fibra óptica
            $esRadio = ($idTipoPlan == 2)
                || str_contains($tipoPlanNombre, 'RADIO')
                || str_contains($tipoPlanNombre, 'INALÁMBR')
                || str_contains($tipoPlanNombre, 'INALAMBR')
                || str_contains($nombrePlanTxt, 'RADIO');
            $esFibra = !$esRadio;

            // Procesar velocidad numérica para compartición 4:1 (la cuarta parte de las megas ofrecidas)
            $velocidadRaw = $contract->plan->velocidad ?? '12';
            preg_match('/([\d\.]+)/', $velocidadRaw, $velMatches);
            $velNumerica = isset($velMatches[1]) ? (float)$velMatches[1] : 12;

            $minimaEfectiva = $velNumerica / 4;
            $velComercialStr   = ($velNumerica == (int)$velNumerica) ? (string)(int)$velNumerica : number_format($velNumerica, 1, '.', '');
            $minimaEfectivaStr = ($minimaEfectiva == (int)$minimaEfectiva) ? (string)(int)$minimaEfectiva : number_format($minimaEfectiva, 1, '.', '');
        @endphp

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 4px; font-size: 8pt;">
            <tr>
                <td style="border: 1px solid #000; padding: 2px 4px; background-color: #e6e6e6; font-weight: bold; width: 18%;">Nombre del Plan:</td>
                <td style="border: 1px solid #000; padding: 2px 6px; font-weight: bold;">{{ mb_strtoupper($contract->plan->nombre_plan ?? 'WEITEL HOME ESTUDIANTIL') }}</td>
            </tr>
        </table>

        {{-- Red de Acceso --}}
        <div style="font-size: 8pt; font-weight: bold; margin-bottom: 1px;">Red de Acceso:</div>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 4px; font-size: 8pt;">
            <tr>
                <td style="width: 49%; vertical-align: top; padding: 0;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr><td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Par de cobre</td><td style="border: 1px solid #000; padding: 1px 4px; width: 20%; text-align: center;"></td></tr>
                        <tr><td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Coaxial</td><td style="border: 1px solid #000; padding: 1px 4px; text-align: center;"></td></tr>
                        <tr><td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Otros</td><td style="border: 1px solid #000; padding: 1px 4px; text-align: center;"></td></tr>
                    </table>
                </td>
                <td style="width: 2%;"></td>
                <td style="width: 49%; vertical-align: top; padding: 0;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr><td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Fibra Optica</td><td style="border: 1px solid #000; padding: 1px 4px; width: 20%; text-align: center; font-weight: bold;">{{ $esFibra ? 'x' : '' }}</td></tr>
                        <tr><td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Inalámbrico</td><td style="border: 1px solid #000; padding: 1px 4px; width: 20%; text-align: center; font-weight: bold;">{{ $esRadio ? 'x' : '' }}</td></tr>
                        <tr><td style="border: none; padding: 1px 4px;">&nbsp;</td><td style="border: none;"></td></tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- Tipo de Cuenta --}}
        <div style="font-size: 8pt; font-weight: bold; margin-bottom: 1px;">Tipo de Cuenta:</div>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 4px; font-size: 8pt;">
            <tr>
                <td style="width: 49%; vertical-align: top; padding: 0;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr><td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Residencial</td><td style="border: 1px solid #000; padding: 1px 4px; width: 20%; text-align: center; font-weight: bold;">x</td></tr>
                        <tr><td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Cibercafé</td><td style="border: 1px solid #000; padding: 1px 4px; text-align: center;"></td></tr>
                    </table>
                </td>
                <td style="width: 2%;"></td>
                <td style="width: 49%; vertical-align: top; padding: 0;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr><td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Corporativo</td><td style="border: 1px solid #000; padding: 1px 4px; width: 20%; text-align: center;"></td></tr>
                        <tr><td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Otros tipos</td><td style="border: 1px solid #000; padding: 1px 4px; text-align: center;"></td></tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- Velocidad --}}
        <div style="font-size: 7.5pt; font-weight: bold; margin-bottom: 1px;">Velocidad (kbps): si existe velocidad máxima para acceso a internet en servidores internacionales y a través del NAP local, se debe especificar:</div>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 3px; font-size: 8pt;">
            <tr>
                <td style="width: 49%; vertical-align: top; padding: 0;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr><td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Comercial de bajada</td><td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold; text-align: center;">{{ $velComercialStr }} Megas</td></tr>
                        <tr><td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Mínima efectiva de bajada</td><td style="border: 1px solid #000; padding: 1px 4px; text-align: center;">{{ $minimaEfectivaStr }} Megas</td></tr>
                    </table>
                </td>
                <td style="width: 2%;"></td>
                <td style="width: 49%; vertical-align: top; padding: 0;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr><td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Comercial de subida</td><td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold; text-align: center;">{{ $velComercialStr }} Megas</td></tr>
                        <tr><td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Mínima efectiva subida</td><td style="border: 1px solid #000; padding: 1px 4px; text-align: center;">{{ $minimaEfectivaStr }} Megas</td></tr>
                    </table>
                </td>
            </tr>
        </table>

        <div style="font-size: 7.5pt; margin-bottom: 4px;">
            <span style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Nivel de Compartición (1:1,2:1,4:1,8:4)</span>
            <span style="border: 1px solid #000; padding: 1px 8px; font-weight: bold;">4:1</span>
        </div>

        <div style="font-size: 7.5pt; margin-bottom: 4px;">
            <span style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">El contrato incluye permanencia mínima:</span>
            &nbsp;&nbsp; <strong>SI</strong> &nbsp; <span style="border: 1px solid #000; padding: 0px 5px; font-weight: bold;">x</span>
            &nbsp;&nbsp; <strong>NO</strong> &nbsp; <span style="border: 1px solid #000; padding: 0px 5px;">&nbsp;&nbsp;</span>
            &nbsp;&nbsp; <strong>TIEMPO</strong> &nbsp; <span style="border: 1px solid #000; padding: 0px 8px; font-weight: bold;">{{ $contract->duracion ?? '24' }} meses</span>
        </div>

        <div style="font-size: 7.5pt; margin-bottom: 4px;">
            <span style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Beneficios por permanencia</span>
            &nbsp;&nbsp;&nbsp;
            <span style="border: 1px solid #000; padding: 1px 10px; font-weight: bold;">NO APLICA</span>
        </div>

        <div style="font-size: 8pt; font-weight: bold; border: 1px solid #000; padding: 1px 4px; background-color: #f2f2f2; margin-bottom: 3px;">
            SERVICIOS ADICIONALES QUE SE OFRECE:
        </div>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 4px; font-size: 7.5pt;">
            <tr>
                <th style="border: 1px solid #000; padding: 1px 4px; width: 35%;"></th>
                <th style="border: 1px solid #000; padding: 1px 4px; width: 8%; text-align: center;">SI</th>
                <th style="border: 1px solid #000; padding: 1px 4px; width: 8%; text-align: center;">NO</th>
                <th style="border: 1px solid #000; padding: 1px 4px; width: 49%; text-align: left;">Descripción</th>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Cuentas de correo electrónico</td>
                <td style="border: 1px solid #000; padding: 1px 4px; text-align: center;"></td>
                <td style="border: 1px solid #000; padding: 1px 4px; text-align: center; font-weight: bold;"></td>
                <td style="border: 1px solid #000; padding: 1px 4px;">No. Cuentas, capacidad en el servidor por cuenta (MB)</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Otros Servicios</td>
                <td style="border: 1px solid #000; padding: 1px 4px; text-align: center;"></td>
                <td style="border: 1px solid #000; padding: 1px 4px; text-align: center;"></td>
                <td style="border: 1px solid #000; padding: 1px 4px;"></td>
            </tr>
        </table>

        <div style="font-size: 8pt; font-weight: bold; border: 1px solid #000; padding: 1px 4px; width: 55px; margin-bottom: 2px;">Tarifas;</div>
        <div style="font-size: 7.5pt; font-weight: bold; border: 1px solid #000; padding: 1px 4px; width: 170px; margin-bottom: 3px;">Valores a pagar por una sola vez:</div>

        <table style="width: 65%; border-collapse: collapse; margin-bottom: 4px; font-size: 7.5pt;">
            <tr>
                <td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Plazo para instalar/ activar el servicio (horas /días)</td>
                <td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold; text-align: center;">48 horas</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Valor Instalación</td>
                <td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold; text-align: center;">120.00 $ USD</td>
            </tr>
        </table>

        {{-- Pago Mensual & Detalle otros valores --}}
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 4px; font-size: 7.5pt;">
            <tr>
                <td style="width: 48%; vertical-align: top; padding: 0;">
                    <div style="font-weight: bold; border: 1px solid #000; padding: 1px 4px; margin-bottom: 2px;">Valores pago Mensual:</div>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr><th style="border: 1px solid #000; padding: 1px 4px;"></th><th style="border: 1px solid #000; padding: 1px 4px; text-align: center;">$ USD</th></tr>
                        <tr><td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Valor mensual</td><td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold; text-align: center;">{{ number_format(($contract->plan->precio ?? 20) / 1.15, 2) }}</td></tr>
                        <tr><td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Valores otros servicios</td><td style="border: 1px solid #000; padding: 1px 4px;"></td></tr>
                        <tr><td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Valor total</td><td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold; text-align: center;">{{ number_format(($contract->plan->precio ?? 20) / 1.15, 2) }}</td></tr>
                    </table>
                </td>
                <td style="width: 4%;"></td>
                <td style="width: 48%; vertical-align: top; padding: 0;">
                    <div style="font-weight: bold; border: 1px solid #000; padding: 1px 4px; margin-bottom: 2px;">Detalle otros valores:</div>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr><th style="border: 1px solid #000; padding: 1px 4px;"></th><th style="border: 1px solid #000; padding: 1px 4px; text-align: center;">$ USD</th></tr>
                        <tr><td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold; text-align: center;">Item</td><td style="border: 1px solid #000; padding: 1px 4px; text-align: center;">0.0</td></tr>
                        <tr><td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Otros servicios</td><td style="border: 1px solid #000; padding: 1px 4px;"></td></tr>
                        <tr><td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Total, Otros Valores</td><td style="border: 1px solid #000; padding: 1px 4px; text-align: center;">0.0</td></tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- Sitios web --}}
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 4px; font-size: 7pt;">
            <tr>
                <td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold; width: 38%;">Sitio web consulta calidad del servicio:</td>
                <td style="border: 1px solid #000; padding: 1px 4px; width: 62%;"><a href="https://weitel.ec" style="color:blue; text-decoration:underline;">https://weitel.ec</a></td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 1px 4px; font-weight: bold;">Sitio web para consultas de tarifas:</td>
                <td style="border: 1px solid #000; padding: 1px 4px;"><a href="https://weitel.ec" style="color:blue; text-decoration:underline;">https://weitel.ec</a></td>
            </tr>
        </table>

        <div style="font-size: 7.5pt; margin-bottom: 2px;">
            <strong>Notas:</strong><br>
            * Las tarifas no incluyen impuestos de ley
        </div>

        <div style="font-size: 7.5pt; margin-bottom: 4px;">
            Autorización expresa de las partes:
        </div>

        {{-- Firmas --}}
        <table style="width: 100%; border: none; margin-top: 2px;">
            <tr style="border: none;">
                <td style="border: none; width: 50%; text-align: center; vertical-align: bottom; padding: 0;">
                    @if($providerSigImg)
                        <div style="text-align: center; margin-bottom: 2px;">
                            <img src="{{ $providerSigImg }}" style="max-height: 35px; width: auto;">
                        </div>
                    @else
                        <div style="height: 15px;"></div>
                    @endif
                    <div style="border: 1px solid #000; padding: 1px; text-align: center; font-weight: bold; font-size: 7.5pt; width: 120px; margin: 0 auto;">PRESTADOR</div>
                </td>
                <td style="border: none; width: 50%; text-align: center; vertical-align: bottom; padding: 0;">
                    @if($signatureImg)
                        <div style="text-align: center; margin-bottom: 2px;">
                            <img src="{{ $signatureImg }}" style="max-height: 35px; width: auto;">
                        </div>
                    @else
                        <div style="height: 15px;"></div>
                    @endif
                    <div style="font-size: 8pt;">____________________________________</div>
                    <div style="font-size: 7.5pt; font-weight: bold; line-height: 1.2; margin-bottom: 2px;">
                        {{ mb_strtoupper($contract->client->nombre ?? '') }} {{ mb_strtoupper($contract->client->apellido ?? '') }}<br>
                        {{ $contract->client->tipo_identificacion ?? 'C.I.' }}: {{ $contract->client->cedula ?? '' }}
                    </div>
                    <div style="border: 1px solid #000; padding: 1px; text-align: center; font-weight: bold; font-size: 7.5pt; width: 160px; margin: 0 auto;">ABONADO/SUSCRIPTOR</div>
                </td>
            </tr>
        </table>

        {{-- ANEXO 2 y ANEXO 3 (se llenan si el técnico ya completó la instalación) --}}
        <div class="page-break"></div>
        @include('contracts.partials.anexos_2_3')

        {{-- ANEXO 4 --}}
        <div class="page-break"></div>
        <div style="text-align: center; font-weight: bold; font-size: 11pt; margin-bottom: 4px;">ANEXO 4</div>
        <div style="text-align: center; font-weight: bold; font-size: 10pt; margin-bottom: 12px;">FORMA DE PAGO</div>

        @php
            $dp = is_array($contract->datos_pago) ? $contract->datos_pago : (json_decode($contract->datos_pago ?? '[]', true) ?: []);
            $payment = strtolower($contract->payment ?? $contract->metodo_pago ?? '');
            $isDirect = ($payment == 'direct' || $payment == 'window' || $payment == 'efectivo' || $payment == 'pago directo');
            $isTransfer = ($payment == 'transfer' || $payment == 'deposito' || $payment == 'transferencia');
            $isAuto = ($payment == 'auto' || $payment == 'debito_banco' || $payment == 'cuenta' || $payment == 'debito automatico cuenta');
            $isCard = ($payment == 'card' || $payment == 'tarjeta' || $payment == 'debito_tarjeta' || $payment == 'debito automatico tarjeta');
        @endphp

        {{-- Table 1: Formas de pago --}}
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 8pt;">
            <tr>
                <td style="border: 1px solid #000; padding: 3px 6px; font-weight: bold; width: 60%;">Pago directo en oficina de Prestador</td>
                <td style="border: 1px solid #000; padding: 3px 6px; font-weight: bold; width: 20%; text-align: left;">SI {{ $isDirect ? 'X' : '' }}</td>
                <td style="border: 1px solid #000; padding: 3px 6px; font-weight: bold; width: 20%; text-align: left;">NO {{ !$isDirect ? 'X' : '' }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px 6px; font-weight: bold;">Deposito o transferencia a la cuenta bancaria del Prestador</td>
                <td style="border: 1px solid #000; padding: 3px 6px; font-weight: bold; text-align: left;">SI {{ $isTransfer ? 'X' : '' }}</td>
                <td style="border: 1px solid #000; padding: 3px 6px; font-weight: bold; text-align: left;">NO {{ !$isTransfer ? 'X' : '' }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px 6px; font-weight: bold;">Débito automático a la cuenta bancaria del Abonado</td>
                <td style="border: 1px solid #000; padding: 3px 6px; font-weight: bold; text-align: left;">SI {{ $isAuto ? 'X' : '' }}</td>
                <td style="border: 1px solid #000; padding: 3px 6px; font-weight: bold; text-align: left;">NO {{ !$isAuto ? 'X' : '' }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 3px 6px; font-weight: bold;">Débito automático a la tarjeta de crédito del Abonado</td>
                <td style="border: 1px solid #000; padding: 3px 6px; font-weight: bold; text-align: left;">SI {{ $isCard ? 'X' : '' }}</td>
                <td style="border: 1px solid #000; padding: 3px 6px; font-weight: bold; text-align: left;">NO {{ !$isCard ? 'X' : '' }}</td>
            </tr>
        </table>

        {{-- Section 1 --}}
        <div style="font-size: 8pt; margin-bottom: 6px;">
            Para efecto de <strong>depósito o transferencia</strong> a la cuenta bancaria del Prestador, se detalla la información de la misma:
        </div>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 4px; font-size: 7.5pt;">
            <tr>
                <td style="border: 1px solid #000; padding: 2px 5px; font-weight: bold; width: 35%;">BANCO:</td>
                <td style="border: 1px solid #000; padding: 2px 5px; width: 32.5%;">{{ $isTransfer ? mb_strtoupper($dp['banco'] ?? 'BANCO PICHINCHA') : '' }}</td>
                <td style="border: 1px solid #000; padding: 2px 5px; width: 32.5%;">{{ $isTransfer ? mb_strtoupper($dp['banco_2'] ?? '') : '' }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 2px 5px; font-weight: bold;">TIPO DE CUENTA / SERVICIO:</td>
                <td style="border: 1px solid #000; padding: 2px 5px;">{{ $isTransfer ? mb_strtoupper($dp['tipo_cuenta'] ?? 'CUENTA CORRIENTE') : '' }}</td>
                <td style="border: 1px solid #000; padding: 2px 5px;">{{ $isTransfer ? mb_strtoupper($dp['tipo_cuenta_2'] ?? '') : '' }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 2px 5px; font-weight: bold;">NÚMERO DE CUENTA / CÓDIGO ÚNICO:</td>
                <td style="border: 1px solid #000; padding: 2px 5px; font-weight: bold;">{{ $isTransfer ? ($dp['codigo_unico'] ?? $dp['numero_cuenta'] ?? '2100318816') : '' }}</td>
                <td style="border: 1px solid #000; padding: 2px 5px;">{{ $isTransfer ? ($dp['numero_cuenta_2'] ?? '') : '' }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 2px 5px; font-weight: bold;">NOMBRE DE PRESTADOR / EMPRESA:</td>
                <td style="border: 1px solid #000; padding: 2px 5px;">{{ $isTransfer ? mb_strtoupper($dp['nombre_prestador'] ?? 'JUAN CARLOS PAGUAY QUIMBIURCO') : '' }}</td>
                <td style="border: 1px solid #000; padding: 2px 5px;"></td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 2px 5px; font-weight: bold;">N°. DE RUC:</td>
                <td style="border: 1px solid #000; padding: 2px 5px;">{{ $isTransfer ? ($dp['ruc_prestador'] ?? '1717486532001') : '' }}</td>
                <td style="border: 1px solid #000; padding: 2px 5px;"></td>
            </tr>
        </table>
        <div style="font-size: 7.5pt; margin-bottom: 12px; line-height: 1.2;">
            Se enviará foto del comprobante o captura de transferencia al número celular de contacto del Prestador N° <strong>0967189813</strong>, se enviará factura al correo electrónico del prestador, <span style="color: #0066cc; text-decoration: underline;">juanpaguay2015@gmail.com</span>
        </div>

        {{-- Section 2 --}}
        <div style="font-size: 8pt; margin-bottom: 6px;">
            Para efecto de débito automático a la cuenta bancaria del Abonado, se detalla la información de la misma:
        </div>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 4px; font-size: 7.5pt;">
            <tr>
                <td style="border: 1px solid #000; padding: 2px 5px; font-weight: bold; width: 45%;">BANCO:</td>
                <td style="border: 1px solid #000; padding: 2px 5px; width: 55%;">{{ $isAuto ? mb_strtoupper($dp['banco_auto'] ?? $dp['banco'] ?? '') : '' }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 2px 5px; font-weight: bold;">TIPO DE CUENTA:</td>
                <td style="border: 1px solid #000; padding: 2px 5px;">{{ $isAuto ? mb_strtoupper($dp['tipo_cuenta_auto'] ?? $dp['tipo_cuenta'] ?? '') : '' }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 2px 5px; font-weight: bold;">NUMERO DE CUENTA:</td>
                <td style="border: 1px solid #000; padding: 2px 5px;">{{ $isAuto ? ($dp['numero_cuenta_auto'] ?? $dp['numero_cuenta'] ?? '') : '' }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 2px 5px; font-weight: bold;">NUMERO DEL ABONADO:</td>
                <td style="border: 1px solid #000; padding: 2px 5px;">{{ $isAuto ? ($contract->client->n_telefono ?? $contract->client->telefono ?? '') : '' }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 2px 5px; font-weight: bold;">NUMERO DE IDENTIFICACION:</td>
                <td style="border: 1px solid #000; padding: 2px 5px;">{{ $isAuto ? ($contract->client->cedula ?? '') : '' }}</td>
            </tr>
        </table>
        <div style="font-size: 7.5pt; margin-bottom: 12px; line-height: 1.2;">
            Se enviará factura al correo electrónico del Abonado .........................................
        </div>

        {{-- Section 3 --}}
        <div style="font-size: 8pt; margin-bottom: 6px;">
            Para efecto de débito automático a la tarjeta de crédito del Abonado, se detalla la información de la misma:
        </div>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 4px; font-size: 7.5pt;">
            <tr>
                <td style="border: 1px solid #000; padding: 2px 5px; font-weight: bold; width: 45%;">BANCO:</td>
                <td style="border: 1px solid #000; padding: 2px 5px; width: 55%;">{{ $isCard ? mb_strtoupper($dp['banco_emisor'] ?? $dp['banco_card'] ?? $dp['banco'] ?? '') : '' }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 2px 5px; font-weight: bold;">EMISOR:</td>
                <td style="border: 1px solid #000; padding: 2px 5px;">{{ $isCard ? mb_strtoupper($dp['emisor_card'] ?? $dp['emisor'] ?? '') : '' }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 2px 5px; font-weight: bold;">NOMBRE DE LA TARJETA:</td>
                <td style="border: 1px solid #000; padding: 2px 5px;">{{ $isCard ? mb_strtoupper($dp['nombre_tarjeta'] ?? '') : '' }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 2px 5px; font-weight: bold;">NUMERO DE LA TARJETA:</td>
                <td style="border: 1px solid #000; padding: 2px 5px;">{{ $isCard ? ($dp['numero_tarjeta'] ?? '') : '' }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 2px 5px; font-weight: bold;">NUMERO DE CODIGO:</td>
                <td style="border: 1px solid #000; padding: 2px 5px;">{{ $isCard ? ($dp['codigo_tarjeta'] ?? $dp['codigo_seguridad'] ?? $dp['cvv'] ?? '') : '' }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 2px 5px; font-weight: bold;">NOMBRE DEL ABONADO:</td>
                <td style="border: 1px solid #000; padding: 2px 5px;">{{ $isCard ? (mb_strtoupper($contract->client->nombre ?? '') . ' ' . mb_strtoupper($contract->client->apellido ?? '')) : '' }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 2px 5px; font-weight: bold;">N° DE IDENTIFICACION</td>
                <td style="border: 1px solid #000; padding: 2px 5px;">{{ $isCard ? ($contract->client->cedula ?? '') : '' }}</td>
            </tr>
        </table>
        <div style="font-size: 7.5pt; margin-bottom: 20px; line-height: 1.2;">
            Se enviará factura al correo electrónico del Abonado ....................................................................................
        </div>

        {{-- Signatures --}}
        <div style="font-size: 8pt; margin-bottom: 10px;">
            Autorización expresa de las partes:
        </div>

        <table style="width: 100%; border: none; margin-top: 10px;">
            <tr style="border: none;">
                <td style="border: none; width: 50%; text-align: center; vertical-align: bottom; padding: 0;">
                    @if($providerSigImg)
                        <div style="text-align: center; margin-bottom: 4px;">
                            <img src="{{ $providerSigImg }}" style="max-height: 40px; width: auto;">
                        </div>
                    @else
                        <div style="height: 60px;"></div>
                    @endif
                    <div style="border: 1px solid #000; padding: 2px; text-align: center; font-weight: bold; font-size: 8pt; width: 140px; margin: 0 auto;">PRESTADOR</div>
                </td>
                <td style="border: none; width: 50%; text-align: center; vertical-align: bottom; padding: 0;">
                    @if($signatureImg)
                        <div style="text-align: center; margin-bottom: 4px;">
                            <img src="{{ $signatureImg }}" style="max-height: 40px; width: auto;">
                        </div>
                    @else
                        <div style="height: 60px;"></div>
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

        {{-- ANEXO 5 --}}
        <div class="page-break"></div>
        <div style="text-align: center; font-weight: bold; font-size: 11pt; margin-bottom: 40px;">ANEXO 5</div>

        <div style="font-size: 8.5pt; font-weight: bold; margin-bottom: 35px;">
            Autorización expresa de uso de información personal
        </div>

        <p style="font-size: 9pt; text-align: justify; line-height: 1.4; margin-bottom: 20px;">
            El abonado/suscriptor por medio de este anexo, deja en constancia que autoriza al Prestador, basado en el Artículo 121 del Reglamento General a Ley Orgánica de Telecomunicaciones, y en la Ley Orgánica de Protección de Datos Personales, su Reglamento General y las directrices emitidas por la Autoridad de Protección de Datos, al uso de datos o información personal a la cual tiene acceso El Prestador del abonado/suscriptor.
        </p>

        <p style="font-size: 9pt; text-align: justify; line-height: 1.4; margin-bottom: 20px;">
            Esta autorización rige a partir de la fecha de suscripción de este contrato de adhesión. La información personal sólo será utilizada para promociones de planes o premios que sortee El Prestador y la información sólo será publicada en la página web oficial del Prestador, en cualquier momento, El abonado/suscriptor, podrá revocar su consentimiento y lo comunicará a través de medios físicos o electrónicos al Prestador, sin que el Prestador pueda condicionar o establecer requisitos para tal fin, adicionales a la simple voluntad del abonado/suscriptor.
        </p>

        <div style="font-size: 9pt; line-height: 1.4; margin-bottom: 10px;">
            Fecha de validez {{ $contract->fecha ? \Carbon\Carbon::parse($contract->fecha)->format('d/m/Y') : '' }}
        </div>

        {{-- Signatures --}}
        <table style="width: 100%; border: none; margin-top: 50px;">
            <tr style="border: none;">
                <td style="border: none; width: 50%; text-align: center; vertical-align: bottom; padding: 0;">
                    @if($providerSigImg)
                        <div style="text-align: center; margin-bottom: 4px;">
                            <img src="{{ $providerSigImg }}" style="max-height: 40px; width: auto;">
                        </div>
                    @else
                        <div style="height: 60px;"></div>
                    @endif
                    <div style="border: 1px solid #000; padding: 2px; text-align: center; font-weight: bold; font-size: 8pt; width: 140px; margin: 0 auto;">PRESTADOR</div>
                </td>
                <td style="border: none; width: 50%; text-align: center; vertical-align: bottom; padding: 0;">
                    @if($signatureImg)
                        <div style="text-align: center; margin-bottom: 4px;">
                            <img src="{{ $signatureImg }}" style="max-height: 40px; width: auto;">
                        </div>
                    @else
                        <div style="height: 60px;"></div>
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

        {{-- NOTAS IMPORTANTES DEL SERVICIO --}}
        <div class="page-break"></div>
        <div style="text-align: center; font-weight: bold; font-size: 11pt; margin-top: 10px; margin-bottom: 10px;">
            NOTAS IMPORTANTES DEL SERVICIO
        </div>

        <div style="font-size: 8.5pt; line-height: 1.25; color: #000;">
            <p style="margin-bottom: 5px; text-align: justify;">
                •Para la solicitud de instalación debe realizar un abono mínimo de $20.00 que corresponde a un cupo en la base de datos, si el cliente diera por cancelado dicho cupo perderá el 26.66% ($20.00) del valor de Instalación.
            </p>
            <p style="margin-bottom: 5px; text-align: justify;">
                •Las solicitudes de instalación que no se puedan hacer después de acudir al domicilio del solicitante, ya que el medio exterior no lo permita por algún tipo de obstrucción sea esta cualquiera que sea tienen un costo de $10.00 que se cobrará o descontará del abono entregado el día de la solicitud.
            </p>
            <p style="margin-bottom: 5px; text-align: justify;">
                •@php $mesesNota = (int) ($contract->duracion ?? 24); $aniosTxt = [1=>'un año',2=>'dos años',3=>'tres años',4=>'cuatro años',5=>'cinco años'][intdiv($mesesNota,12)] ?? null; @endphp
                El valor de la renta mensual ha sido calculado para {{ ($mesesNota % 12 === 0 && $aniosTxt) ? $aniosTxt.' (' : '' }}{{ $mesesNota }} meses{{ ($mesesNota % 12 === 0 && $aniosTxt) ? ')' : '' }} y será vigente durante este tiempo.
            </p>
            <p style="margin-bottom: 5px; text-align: justify;">
                •La renta mensual debe ser cancelada en la modalidad post pago una vez concluida la instalación.
            </p>
            <p style="margin-bottom: 5px; text-align: justify;">
                •Los equipos deben ser conectados a energía eléctrica regulada con conexión a tierra.
            </p>
            <p style="margin-bottom: 5px; text-align: justify;">
                •Facturación en tarifa plana, puede utilizar el servicio todo el día o no usar nada, sin embargo, cada mes paga siempre el mismo valor fijo.
            </p>
            <p style="margin-bottom: 5px; text-align: justify;">
                •<strong>Para Soporte Técnico comunicarse telefónicamente a los siguientes números de WhatsApp:</strong><br>
                <strong>WEITEL BOLIVAR: 0996855421</strong>
            </p>
            <p style="margin-bottom: 5px; text-align: justify;">
                •La visita técnica cuando la falla NO sea imputable al proveedor tendrá un costo de $10.00.
            </p>
            <p style="margin-bottom: 5px; text-align: justify;">
                •Si el cliente se cambia de domicilio y desea continuar con el servicio tendrá un costo de $25 por reinstalación.
            </p>
            <p style="margin-bottom: 5px; text-align: justify;">
                •Nivel de compresión: Plan Home 4:1; Plan Pymes/Cyber 2:1 y Planes corporativos 1:1
            </p>
            <p style="margin-bottom: 5px; text-align: justify;">
                •El equipo es Instalado a Modalidad de Préstamo por lo tanto será retirado a la terminación del contrato, sin ningún tipo de reembolso económico.
            </p>
            <p style="margin-bottom: 5px; text-align: justify;">
                •Autorizo para que la información de mi comportamiento financiero sea compartida con el Buró de crédito.
            </p>
            <p style="margin-bottom: 5px; text-align: justify;">
                •El valor cancelado por instalación corresponde a material no renovable: cables y conectores, honorarios del técnico y comisión al vendedor, NO corresponde en ningún caso a venta de equipos.
            </p>
            <p style="margin-bottom: 5px; text-align: justify;">
                •La instalación del servicio de Internet puede adelantarse como atrasarse de la fecha establecida en la solicitud de instalación.
            </p>
            <p style="margin-bottom: 5px; text-align: justify;">
                •El cliente tiene la obligación de firmar el contrato en el tiempo estipulado (8 días) caso contrario se retirará equipos sin rembolso alguno.
            </p>
            <p style="margin-bottom: 5px; text-align: justify;">
                •WEITEL BOLIVAR no realiza suspensiones temporales del servicio, ya que si no está en la capacidad de seguir con el contrato se recomienda la cancelación del mismo. Así podremos evitar más montos adicionales a su factura.
            </p>
            <p style="margin-bottom: 5px; text-align: justify;">
                •En caso de terminación anticipada del contrato, el cliente pagará el valor de los costos incurridos en la instalación.
            </p>
            <p style="margin-bottom: 5px; text-align: justify;">
                •Si el cliente no cumpliera su obligación del pago mensual automáticamente se deshabilitará el servicio por falta de pago RECUERDE, los rubros siguen corriendo a pesar de que el sistema este deshabilitado hasta que el valor sea cancelado.
            </p>
            <p style="margin-bottom: 5px; text-align: justify;">
                •El cliente activo no podrá mover o cambiar de posición los equipos exteriores (antena) sea este en el mismo lugar de domicilio o a otro domicilio, sin previo aviso, el cliente debe llamar para pedir una vista técnica.
            </p>
            <p style="margin-bottom: 5px; text-align: justify;">
                •El personal de WEITEL BOLIVAR está autorizado para Instalar el Servicio de Internet y cobrar SOLO los valores detallados en dicho documento.
            </p>
            <p style="margin-bottom: 5px; text-align: justify;">
                •Los planes HOME NO deben usarse para reventa de servicio en Cybers café o similares, una vez detectado se facturará el valor restante acumulado el Plan Pymes desde el primer día de contrato, sin perjuicios de que la ARCOTEL establezca sanciones según establece la Ley Especial de Telecomunicaciones.
            </p>
            <p style="margin-bottom: 5px; text-align: justify;">
                •<strong>FORMAS DE PAGO: La forma de pago se realiza los primeros días (1 al 6) de cada mes, en oficinas de la ciudad de San Miguel, en caso de transferencia o depósito bancario a la CTA. CTE. Bco. Pichincha # 2100318816 a nombre de JUAN CARLOS PAGUAY QUIMBIURCO, RED FACILITO, después realizada la transferencia o el pago llamar PBX: (03) 3033680 o WhatsApp 0967189813 para confirmar el número de documento o control.</strong>
            </p>
            <p style="margin-bottom: 5px; text-align: justify;">
                •<strong>Horarios de atención SAN MIGUEL: lunes a viernes de 7:30am a 17:00pm en horario continuo, sábados de 9:00 am a 13:00 pm</strong>
            </p>
        </div>

        {{-- AUTORIZACIÓN TITULAR --}}
        <div style="text-align: center; font-weight: bold; font-size: 10.5pt; margin-bottom: 20px; page-break-before: always;">
            AUTORIZACIÓN DEL TITULAR
        </div>

        <p style="font-size: 8.5pt; text-align: justify; line-height: 1.4; margin-bottom: 20px;">
            Autorizo(amos) expresa e irrevocablemente a JUAN CARLOS PAGUAY QUIMBIURCO o a quien sea en el futuro el cesionario, beneficiario o acreedor del crédito solicitado o del documento o titulado cambiario que lo respalde para que obtenga cuantas veces sean necesarias, de cualquier fuente de información, incluidos los buros de crédito, mi información de riesgos crediticios, de igual forma, queda expresamente autorizado para que pueda transferir o entregar dicha información a los burós de crédito públicos y/o privados, o a la Central de Riesgos si fuere pertinente.
        </p>

        <div style="font-size: 8.5pt; line-height: 1.5; margin-top: 120px;">
            <div style="border-top: 1px solid #000; width: 40%; padding-top: 4px; font-weight: bold;">
                NOMBRES/APELLIDOS: {{ mb_strtoupper($contract->client->nombre ?? '') }} {{ mb_strtoupper($contract->client->apellido ?? '') }}<br>
                {{ $contract->client->tipo_identificacion ?? 'CI' }}: {{ $contract->client->cedula ?? '' }}
            </div>
        </div>

    </main>
</body>

</html>