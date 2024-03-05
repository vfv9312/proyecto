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
                @php
                    $productos = json_decode($listaProductos, true);
                @endphp
                @foreach ($productos as $producto)
                    <p>Producto: {{ $producto['nombre_comercial'] }}</p>
                    <p>Cantidad: {{ $producto['cantidad'] }}</p>
                    <p style="margin-bottom: 10px;">Precio: ${{ $producto['precio'] }}</p>
                @endforeach
                <p style="margin-top: 10px;"> Costo total : ${{ $total }}</p>
            </div>
            <!-- Agrega más items aquí -->
        </div>
        <div class="cliente">
            <h5> Datos del cliente </h5>
            @php
                $Cliente = json_decode($listaCliente);
                $Preventa = json_decode($datosPreventa);
                $Empleado = json_decode($listaEmpleado);
            @endphp
            <p>{{ $Cliente->nombre_cliente }} {{ $Cliente->apellido }}</p>
            <p>{{ $Cliente->telefono_cliente }}</p>
            <p>Col.{{ $Preventa->localidad }}; {{ $Preventa->calle }} #{{ $Preventa->num_exterior }} -
                interior # {{ $Preventa->num_interior }}</p>
            <p>Referencia: {{ $Preventa->referencia }}</p>
            <p>Factura : {{ $Preventa->factura == 1 ? 'Sí' : 'No' }}</p>
        </div>
        <div class="footer">
            <p>Le atendio:</p>
            <p>{{ $Empleado->nombre_empleado }} {{ $Empleado->apellido }}</p>
            <p>Gracias por su compra!</p>
        </div>
    </div>
</body>

</html>
