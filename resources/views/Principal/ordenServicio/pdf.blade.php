<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Folio</title>
    <style>
        .ticket {
            width: 60mm;
            font-family: Arial, sans-serif;
            font-size: 10px;
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

        .datoscliente {
            border-bottom: 1px dashed;
        }

        .datoscliente h5 {
            font-weight: bold;
            text-align: center;
            font-size: 11px;
            margin: 0;
        }

        .ubicacion {
            border-top: 1px dashed;
            padding-bottom: 5mm;
        }

        .ubicacion p {
            font-size: 9px;
        }

        .body {
            margin-top: 5mm;
        }

        .body h5 {
            font-weight: bold;
            text-align: center;
            font-size: 11px;
            margin: 0;
        }

        .footer {
            border-top: 1px dashed;
            padding-top: 5mm;
            text-align: center;
            font-size: 12px
        }

        .item {
            margin-bottom: 5mm;
        }

        .item p {
            margin: 0;
        }

        .item h3 {
            text-align: center;
        }

        #paginaweb {
            text-align: center;
        }
    </style>
</head>

@if ($ordenRecoleccion->idCancelacion)

    <body
        style="background: url('cancelado.png') no-repeat center center;
-webkit-background-size: 50% 50%;
-moz-background-size: 50% 50%;
-o-background-size: 50% 50%;
background-size: 50% 50%;
opacity: 0.5;">
    @else

        <body>
@endif

@php
    use Carbon\Carbon;

    $fechaHoraArray = explode(' ', $ordenRecoleccion->fechaCreacion);
    $fecha = $fechaHoraArray[0];
    $hora = $fechaHoraArray[1];

    if ($Tiempo !== null && $Tiempo->tiempo !== null) {
        $horaRegistro = Carbon::parse($hora);
        $tiempo = Carbon::parse($Tiempo->tiempo);

        $horaFinal = $horaRegistro
            ->addHours($tiempo->hour)
            ->addMinutes($tiempo->minute)
            ->addSeconds($tiempo->second);
        $fechaHoraDeTiempoAproximadoEntrega = explode(' ', $horaFinal);
        $tiempoPromesa = $fechaHoraDeTiempoAproximadoEntrega[1];
    }
@endphp

<body>
    <div class="ticket">
        <div class="header">
            <img class="logo" src="{{ public_path('logo_ecotoner.png') }}" alt="Logo">
            <h1>{{ $ordenRecoleccion->comentario ? 'Orden Procesada' : 'Orden de servicio' }}</h1>
            <span>Folio:{{ sprintf('%06d', $ordenRecoleccion->ultimoValor) }}</span>
            <p>Fecha recepcion: {{ $fecha }}</p>
            <p>{{ $ordenRecoleccion->idCancelacion ? 'Motivo de cancelación : ' . $ordenRecoleccion->nombreCancelacion : '' }}
            </p>
            <p>{{ $ordenRecoleccion->idCancelacion ? 'Descripcion de cancelacion : ' . $ordenRecoleccion->descripcionCancelacion : '' }}
            </p>
        </div>
        <div class="body">
            <div class="datoscliente item">
                <h5> Datos del cliente </h5>
                <p>Cliente : {{ $ordenRecoleccion->nombreCliente }} {{ $ordenRecoleccion->apellidoCliente }}</p>
                <p>{{ $ordenRecoleccion->rfc ? 'RFC : ' . $ordenRecoleccion->rfc : '' }}</p>
                <p>Atencion : {{ $ordenRecoleccion->nombreAtencion }}</p>
                <p>Tel : {{ $ordenRecoleccion->telefonoCliente }}</p>
                <p>{{ $ordenRecoleccion->correo ? 'Correo : ' . $ordenRecoleccion->correo : '' }}</p>
                <p>Direccion : Col.{{ $ordenRecoleccion->localidad }}; {{ $ordenRecoleccion->calle }}
                    #{{ $ordenRecoleccion->num_exterior }},
                    {{ $ordenRecoleccion->num_interior ? ' num interior ' . $ordenRecoleccion->num_interior : '' }}</p>
                <p>CP :{{ $ordenRecoleccion->cp }}</p>
                <p> Referencia : {{ strtoupper($ordenRecoleccion->referencia) }}</p>
            </div>
            <div class="item">
                @if ($ordenRecoleccion->estatus !== 2)
                    <h3>En revisión</h3>
                @endif
                @php
                    $total = 0;
                @endphp
                @foreach ($listaProductos as $producto)
                    <p>Producto: {{ $producto->nombre_comercial }}</p>
                    <p>Color : {{ $producto->nombreColor }}, Marca : {{ $producto->nombreMarca }}, Tipo :
                        {{ $producto->nombreModo }}, Categoria : {{ $producto->nombreTipo }}, Cantidad:
                        {{ $producto->cantidad }},
                        {{ $producto->descripcion ? 'Descripcion : ' . $producto->descripcion : '' }}
                    </p>
                    @if ($producto->porcentaje !== null)
                        <p>Aplica descuento : {{ $producto->porcentaje }}%</p>
                    @endif
                    @if ($ordenRecoleccion->estatus === 2 || $ordenRecoleccion->estatus === 1)
                        <p style="margin-bottom: 10px;">
                            {{ $producto->precio ? 'Precio : $' . $producto->precio : '' }}</p>
                        @php
                            $total += $producto->precio;
                        @endphp
                    @endif
                    <p style="margin-bottom: 10px;"></p>
                @endforeach

                @if ($ordenRecoleccion->codigo)
                    <p>Codigo : {{ strtoupper($ordenRecoleccion->codigo) }}</p>
                    <p>Recarga :{{ strtoupper($ordenRecoleccion->nRecarga) }}</p>
                @endif

                <p style="margin-bottom: 4px;"></p>
                <h5> Datos del pago </h5>
                @if ($ordenRecoleccion->metodoPago)
                    <p>Requiere : {{ $ordenRecoleccion->factura ? 'FACTURA' : 'NOTA' }}</p>
                    <p>Metodo de pago : {{ strtoupper($ordenRecoleccion->metodoPago) }}</p>
                    @if ($ordenRecoleccion->estatus === 2 || $ordenRecoleccion->estatus === 1)
                        Costo total : ${{ $total }}<br>
                        {{ $ordenRecoleccion->metodoPago == 'Efectivo' ? 'Paga con : $' . $ordenRecoleccion->pagoEfectivo : '' }}
                        <p>{{ $ordenRecoleccion->metodoPago == 'Efectivo' ? 'Cambio : $' . number_format($ordenRecoleccion->pagoEfectivo - $total, 2) : '' }}
                        </p>
                    @endif
                @else
                    <p class=" text-center">Se espera revision para determinar costo del servicio</p>
                @endif
            </div>
            <!-- Agrega más items aquí -->
        </div>

    </div>
    <div class="footer item">
        <p>Recepciono:</p>
        <p>{{ $ordenRecoleccion->nombreEmpleado }} {{ $ordenRecoleccion->apellidoEmpleado }}</p>
        Hora de recepcion : {{ $hora }}
        <p>Recibe : {{ $ordenRecoleccion->nombreRecibe }}</p>
        <p>Entrega : {{ $ordenRecoleccion->nombreEntrega }}</p>
        <p>{{ $Tiempo ? 'Hora aproximada de entrega : ' . $tiempoPromesa : 'No hay tiempo aproximado de entrega' }}
        </p>
    </div>
    <div class="ubicacion">
        <p>{{ $DatosdelNegocio->ubicaciones }}; Conmutador: {{ $DatosdelNegocio->telefono }},
            WhatsApp : {{ $DatosdelNegocio->whatsapp }}</p>
        <p id="paginaweb">{{ $DatosdelNegocio->pagina_web }}</p>
    </div>
</body>

</html>
