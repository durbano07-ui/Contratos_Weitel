<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contrato de Servicio de Internet</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; line-height: 1.5; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #0056b3; padding-bottom: 10px; }
        .title { font-size: 20px; font-weight: bold; color: #0056b3; }
        .section { margin-bottom: 20px; }
        .section-title { font-size: 16px; font-weight: bold; background-color: #f4f4f4; padding: 5px; border-left: 4px solid #0056b3; }
        .row { margin-bottom: 5px; }
        .label { font-weight: bold; }
        .footer { position: fixed; bottom: 30px; width: 100%; text-align: center; font-size: 12px; border-top: 1px solid #ccc; padding-top: 10px; }
        .signatures { margin-top: 120px; text-align: center; width: 100%; }
        .signature-box { display: inline-block; width: 45%; text-align: center; vertical-align: top; }
        .signature-line { border-top: 1px solid #000; width: 80%; display: inline-block; margin: 0 auto; padding-top: 5px; }
    </style>
</head>
<body>

    <div class="header">
        <div class="title">CONTRATO DE PRESTACIÓN DE SERVICIOS DE INTERNET</div>
        <div>Generado el: {{ \Carbon\Carbon::parse($contract->fecha)->format('d/m/Y') }}</div>
        <div>Contrato N°: {{ str_pad($contract->id_contrato, 6, '0', STR_PAD_LEFT) }}</div>
    </div>

    <div class="section">
        <p>Conste por el presente documento, el Contrato de Prestación de Servicios de Internet que celebran, de una parte la Empresa Proveedora, y de otra parte el CLIENTE cuyos datos se detallan a continuación:</p>
    </div>

    <div class="section">
        <div class="section-title">1. DATOS DEL CLIENTE</div>
        <table style="width: 100%; margin-top: 10px;">
            <tr>
                <td style="width: 50%;"><span class="label">Nombres / Razón Social:</span> {{ $contract->client->nombre }} {{ $contract->client->apellido }}</td>
                <td style="width: 50%;"><span class="label">Cédula / RUC:</span> {{ $contract->client->cedula }}</td>
            </tr>
            <tr>
                <td><span class="label">Email:</span> {{ $contract->client->email ?? 'N/A' }}</td>
                <td><span class="label">Teléfono:</span> {{ $contract->client->n_telefono ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Dirección:</span> {{ $contract->client->direccion ?? 'N/A' }}, {{ $contract->client->ciudad ?? '' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">2. DETALLES DEL SERVICIO CONTRATADO</div>
        <table style="width: 100%; margin-top: 10px;">
            <tr>
                <td style="width: 50%;"><span class="label">Tipo de Conexión:</span> {{ $contract->plan->type->nombre_tipo }}</td>
                <td style="width: 50%;"><span class="label">Plan:</span> {{ $contract->plan->nombre_plan }}</td>
            </tr>
            <tr>
                <td><span class="label">Velocidad:</span> {{ $contract->plan->velocidad }}</td>
                <td><span class="label">Tarifa Mensual:</span> ${{ number_format($contract->plan->precio, 2) }} USD</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">3. TÉRMINOS Y CONDICIONES</div>
        <p style="font-size: 13px; text-align: justify;">
            El CLIENTE se compromete a cancelar la tarifa mensual acordada por la prestación ininterrumpida del servicio de conectividad a la red de internet bajo las características del plan seleccionado. El presente contrato tiene un tiempo de validez indefinido a partir de la firma del mismo.
        </p>
    </div>

    <div class="signatures">
        <div class="signature-box">
            <div class="signature-line">LA EMPRESA</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">EL CLIENTE<br>{{ $contract->client->cedula }}</div>
        </div>
    </div>

    <div class="footer">
        Documento generado automáticamente por el Sistema de Contratos.<br>
        Registrado por: {{ optional($contract->user)->name ?? 'Administrador del Sistema' }}
    </div>

</body>
</html>
