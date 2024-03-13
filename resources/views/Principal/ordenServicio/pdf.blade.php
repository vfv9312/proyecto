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
                @foreach ($productos as $produc)
                    Producto a recolectar : {{ $produc->nombre_comercial }} - {{ $produc->cantidad }} -
                    {{ $produc->descripcion }}
                @endforeach
            </div>
            <!-- Agrega más items aquí -->
        </div>
        <div class="cliente">
            <h5> Datos del cliente </h5>
            <p> {{ $ordenRecoleccion->nombreCliente }} {{ $ordenRecoleccion->apellidoCliente }}</p>
            <p>Tel: {{ $ordenRecoleccion->telefonoCliente }}</p>
            <p>RFC : {{ $ordenRecoleccion->rfc }}</p>
            <p>{{ $ordenRecoleccion->correo }}</p>
            <p>Col.{{ $ordenRecoleccion->localidad }}; {{ $ordenRecoleccion->calle }}
                #{{ $ordenRecoleccion->num_exterior }}
                {{ $ordenRecoleccion->num_interior ? 'num interio #' . $ordenRecoleccion->num_interior : '' }}</p>
        </div>
        <div class="footer">
            <span>Ticket recoleccion:{{ $ordenRecoleccion->idRecoleccion }}</span>
            <p>Le atendio:</p>
            <p>{{ $ordenRecoleccion->nombreEmpleado }} {{ $ordenRecoleccion->apellidoEmpleado }}</p>
            <p>Fecha : {{ $ordenRecoleccion->fechaCreacion }}</p>
            <p>Orden de recoleccion!</p>
        </div>
    </div>
</body>

</html>
