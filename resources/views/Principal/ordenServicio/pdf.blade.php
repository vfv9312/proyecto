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
                <p> Orden de recoleccion</p>
                @foreach ($productos as $produc)
                    Producto a recolectar : {{ $produc->nombre_comercial }}
                @endforeach

                <p style="margin-top: 10px;"> Costo total : ${{ $precio }}</p>
            </div>
            <!-- Agrega más items aquí -->
        </div>
        <div class="cliente">
            <h5> Datos del cliente </h5>
            <p> {{ $nombre_cliente }}</p>
            <p>Tel: {{ $telefono }}</p>
            <p>RFC : {{ $rfc }}</p>
            <p>{{ $email }}</p>
            <p>{{ $direccion }}</p>
        </div>
        <div class="footer">
            <p> Le atendio :</p>
            <p> {{ $atencion }} </p>
            <p> {{ $fecha }} </p>
        </div>
    </div>
</body>

</html>
