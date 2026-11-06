<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Anexos 2 y 3 - Instalación ISP-{{ $contract->id_contrato }}</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0.8em 0;
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

        .page-break {
            page-break-before: always;
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

        $signatureImg = null;
        if ($contract->anexo2 && !empty($contract->anexo2->firma_cliente)) {
            $rawSig = trim($contract->anexo2->firma_cliente);
            if (str_starts_with($rawSig, 'data:image') && strlen($rawSig) > 100) {
                $signatureImg = $rawSig;
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

        @include('contracts.partials.anexos_2_3')

    </main>

</body>

</html>