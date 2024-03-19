<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket</title>
    <style>
        .ticket {
            width: 60mm;
            font-family: Arial, sans-serif;
            margin: auto;
        }

        .header {
            text-align: center;
            border-bottom: 1px dashed;
            padding-bottom: 5mm;
        }

        .logo {
            width: 50mm;
            height: auto;
        }

        .cliente {
            border-top: 1px dashed;
            padding-bottom: 5mm;
        }

        .body {
            margin-top: 10mm;
        }

        .footer {
            border-top: 1px dashed;
            padding-top: 5mm;
            text-align: center;
        }

        .item {
            margin-bottom: 5mm;
        }

        .item p {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="ticket">
        <div class="header">
            <img class="logo" src="{{ public_path('logo_ecotoner.png') }}" alt="Logo">
            <h1>Ecotoner</h1>
            <p>Col. Centro; 4a Norte Poniente 867, Tuxtla Gutiérrez, Chiapas</p>
            <p>Tel: (961) 61.115.44 o 961.1777.992</p>
        </div>
        <div class="body">
            <div class="item">
                @if ($datosEnvio->estatusPreventa == 4)
                    @foreach ($productos as $produc)
                        <p> Producto : {{ $produc->nombre_comercial }} - {{ $produc->cantidad_total }} -
                            {{ $produc->descripcion }}</p>
                    @endforeach
                    <span> Costo : ${{ $datosEnvio->costo_servicio }} </span>
                    {{ $datosEnvio->metodoPago }}
                    {{ $datosEnvio->metodoPago == 'Efectivo' ? 'Paga con : $' . $datosEnvio->pagoEfectivo : '' }}
                    <p>{{ $datosEnvio->metodoPago == 'Efectivo' ? 'Cambio : $' . ($datosEnvio->pagoEfectivo - $total) : '' }}
                    @else
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($listaProductos as $producto)
                            <p>Producto: {{ $producto->nombre_comercial }}</p>
                            <p>Cantidad: {{ $producto->cantidad }}</p>
                            <p style="margin-bottom: 10px;">Precio: ${{ $producto->precio }}</p>
                            @php
                                $total += $producto->precio * $producto->cantidad;
                            @endphp
                        @endforeach
                    <p style="margin-top: 10px;"> Costo total : ${{ $total }}</p>
                    {{ $datosEnvio->metodoPago }}
                    {{ $datosEnvio->metodoPago == 'Efectivo' ? 'Paga con : $' . $datosEnvio->pagoEfectivo : '' }}
                    <p>{{ $datosEnvio->metodoPago == 'Efectivo' ? 'Cambio : $' . ($datosEnvio->pagoEfectivo - $total) : '' }}
                    </p>
                @endif
            </div>
            <!-- Agrega más items aquí -->
        </div>
        <div class="cliente">
            <h5> Datos del cliente </h5>
            <p> {{ $datosEnvio->nombreCliente }} {{ $datosEnvio->apellidoCliente }}</p>
            <p>Tel: {{ $datosEnvio->telefonoCliente }}</p>
            <p>RFC : {{ $datosEnvio->rfc }}</p>
            <p>{{ $datosEnvio->correo }}</p>
            <p>Col.{{ $datosEnvio->localidad }}; {{ $datosEnvio->calle }}
                #{{ $datosEnvio->num_exterior }}
                {{ $datosEnvio->num_interior ? 'num interio #' . $datosEnvio->num_interior : '' }}
                {{ $datosEnvio->referencia }}</p>
        </div>
        <div class="footer">
            <span>Ticket recoleccion:{{ $datosEnvio->idRecoleccion }}</span>
            <p>Le atendio:</p>
            <p>{{ $datosEnvio->nombreEmpleado }} {{ $datosEnvio->apellidoEmpleado }}</p>
            <p>Fecha : {{ $datosEnvio->created_at }}</p>
            <p>Compra finalizada!</p>
        </div>
    </div>
</body>

</html>
