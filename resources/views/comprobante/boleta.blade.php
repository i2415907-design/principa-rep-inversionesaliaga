<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta de Venta Electrónica</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .boleta-container {
            width: 700px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            border: 1px solid #000;
            padding: 10px;
        }
        .logo-box {
            width: 50%;
            display: flex;
            align-items: center;
        }
        .logo {
            width: 150px;
            height: 50px;
            border: 1px solid #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #555;
            background-color: #eee;
        }
        .ruc-box {
            width: 45%;
            text-align: center;
            border: 2px solid #000;
            padding: 5px;
            line-height: 1.5;
        }
        .ruc-box p {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
        }
        .ruc-box h2 {
            margin: 5px 0;
            font-size: 18px;
            font-weight: 900;
        }
        .info-empresa, .info-cliente {
            font-size: 12px;
            margin-bottom: 15px;
        }
        .info-empresa p, .info-cliente p {
            margin: 3px 0;
        }
        .info-empresa strong, .info-cliente strong {
            display: inline-block;
            width: 100px;
        }
        .info-cliente table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        .info-cliente td {
            padding: 2px 0;
        }
        .info-cliente .label {
            font-weight: bold;
            width: 150px;
        }
        .info-cliente .value {
            font-weight: normal;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }
        .items-table th, .items-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        .items-table th {
            background-color: #f2f2f2;
            text-transform: uppercase;
        }
        .items-table .text-left {
            text-align: left;
        }
        .items-table .text-right {
            text-align: right;
        }

        .footer-details {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .qr-code {
            width: 150px;
            height: 150px;
            border: 1px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
        }

        .total-box {
            width: 50%;
        }

        .total-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-left: auto;
        }
        .total-table tr:last-child td {
            font-weight: bold;
        }
        .total-table td {
            padding: 5px;
            border: 1px solid #000;
        }
        .total-table .label {
            text-align: right;
            width: 70%;
        }
        .total-table .currency {
            text-align: center;
            width: 5%;
        }
        .total-table .amount {
            text-align: right;
            width: 25%;
        }
        .footer-text {
            margin-top: 20px;
            font-size: 10px;
            text-align: center;
        }

        /* Estilos específicos para la data */
        .data-header { font-size: 10px; }
        .data-label { font-weight: bold; }
        .data-value { font-weight: normal; }
    </style>
</head>
<body>
    <div class="boleta-container">

        <div class="header">
            <div class="logo-box">
                <div class="logo">
                    INVERSIONES ALIAGA
                </div>
            </div>
            
            <div class="ruc-box">
                <p>RUC: 10755123043</p>
                <h2>BOLETA DE VENTA ELECTRÓNICA</h2>
                <p>{{ $numeroBoleta }}</p>
            </div>
        </div>
        
        <div class="info-empresa">
            <p><strong>EMPRESA:</strong> INVERSIONES ALIAGA</p>
            <p><strong>Domicilio Fiscal:</strong> Call Real 833 - HUANCAYO - HUANCAYO - JUNÍN</p>
            <p><strong>Teléfono(s):</strong> +51 998 404 055 | <strong>Página Web:</strong> https://inversionesaliaga.com/</p>
        </div>

        <div class="info-cliente">
            <table>
                <tr>
                    <td class="label">Cliente</td>
                    <td>:</td>
                    <td class="value">{{ $cliente->nombre_cliente }} {{ $cliente->apellido_cliente }}</td>
                    <td class="label">Moneda</td>
                    <td>:</td>
                    <td class="value">SOL</td>
                </tr>
                <tr>
                    <td class="label">Dirección</td>
                    <td>:</td>
                    <td class="value">
                        @if($pedido && $pedido->recojo_tienda)
                            RECOJO EN TIENDA
                        @elseif($distrito)
                            {{ $distrito->nombre_distr ?? 'Dirección no especificada' }}
                        @else
                            {{ $cliente->direccion_cliente ?? 'Dirección no especificada' }}
                        @endif
                    </td>
                    <td class="label">Código de Cliente</td>
                    <td>:</td>
                    <td class="value">{{ $cliente->id_cliente }}</td>
                </tr>
                <tr>
                    <td class="label">DNI</td>
                    <td>:</td>
                    <td class="value">{{ $cliente->doc_ident ?? 'No especificado' }}</td>
                    <td class="label">Nombre</td>
                    <td>:</td>
                    <td class="value">{{ $cliente->nombre_cliente }} {{ $cliente->apellido_cliente }}</td>
                </tr>
                <tr>
                    <td class="label">Fecha de Emisión</td>
                    <td>:</td>
                    <td class="value">{{ $fechaEmision }}</td>
                    <td class="label">Hora de Emisión</td>
                    <td>:</td>
                    <td class="value">{{ $horaEmision }}</td>
                </tr>
                @if($pedido && $pedido->referencia_ped)
                <tr>
                    <td class="label">Referencias</td>
                    <td>:</td>
                    <td class="value" colspan="4">{{ $pedido->referencia_ped }}</td>
                </tr>
                @endif
            </table>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 5%;">Cantidad</th>
                    <th style="width: 5%;">UM</th>
                    <th style="width: 45%;">Descripción</th>
                    <th style="width: 15%;">Valor Unitario</th>
                    <th style="width: 15%;">Precio Unitario</th>
                    <th style="width: 15%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detalles as $detalle)
                <tr>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>UND</td>
                    <td class="text-left">{{ $detalle->nombre_producto }}</td>
                    <td class="text-right">S/ {{ number_format($detalle->precio_unitario / 1.18, 2) }}</td>
                    <td class="text-right">S/ {{ number_format($detalle->precio_unitario, 2) }}</td>
                    <td class="text-right">S/ {{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer-details">
            <div class="qr-code">
                CÓDIGO QR<br>
                (Para verificación SUNAT)
            </div>

            <div class="total-box">
                <table class="total-table">
                    <tr>
                        <td class="label">Total Valor de Venta</td>
                        <td class="currency">S/</td>
                        <td class="amount">{{ $valorVenta }}</td>
                    </tr>
                    <tr>
                        <td class="label">IGV (18%)</td>
                        <td class="currency">S/</td>
                        <td class="amount">{{ $igv }}</td>
                    </tr>
                    <tr>
                        <td class="label">Importe Total</td>
                        <td class="currency">S/</td>
                        <td class="amount">{{ $totalVenta }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <p class="footer-text">
            Representación Impresa de la Boleta de Venta Electrónica<br>
            N° de Venta: {{ $venta->id_venta }} | Fecha: {{ $fechaEmision }} | Hora: {{ $horaEmision }}
        </p>

    </div>
</body>
</html>