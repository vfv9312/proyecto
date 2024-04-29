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

        #paginaweb {
            text-align: center;
        }

        .dias {
            padding-right: 10px;
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
    $fechaHoraArray = explode(' ', $ordenRecoleccion->fechaCreacion);
    $fecha = $fechaHoraArray[0];
    $hora = $fechaHoraArray[1];
    // array values reacomoda el indice despues de que haga el filter para eliminar los datos vacios
    $horariosInicio = array_values(array_filter(explode(',', $ordenRecoleccion->horarioTrabajoInicio)));
    $horariosFinal = array_values(array_filter(explode(',', $ordenRecoleccion->horarioTrabajoFinal)));
    $dias = explode(',', $ordenRecoleccion->diaSemana);

@endphp
<div class="ticket">
    <div class="header">
        <img class="logo" src="{{ public_path('logo_ecotoner.png') }}" alt="Logo">
        <h1>{{ $ordenRecoleccion->comentario ? 'Orden Procesada!' : 'Orden de Entrega!' }}</h1>
        <span>Folio:{{ $ordenRecoleccion->letraActual }}{{ sprintf('%06d', $ordenRecoleccion->ultimoValor) }}</span>
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
            <p> Referencia : {{ $ordenRecoleccion->referencia }}</p>
            <p>Horario de trabajo
            <table>
                <tr>
                    @foreach ($dias as $index => $dia)
                        <td class="dias">
                            @if ($dia == 'Lunes' || $dia == 'Martes' || $dia == 'Miercoles' || $dia == 'Jueves' || $dia == 'Viernes')
                                {{ $dia }} {{ $horariosInicio[$index] }} - {{ $horariosFinal[$index] }}
                            @endif
                        </td>
                    @endforeach
                </tr>
            </table>
            <table>
                <tr>
                    @foreach ($dias as $index => $dia)
                        <td class="dias">
                            @if ($dia == 'Sabado' || $dia == 'Domingo')
                                {{ $dia }} {{ $horariosInicio[$index] }} - {{ $horariosFinal[$index] }}
                            @endif
                        </td>
                    @endforeach
                </tr>
            </table>
            </p>
        </div>
        <div class="item">
            @php
                $total = 0;
            @endphp
            @foreach ($listaProductos as $producto)
                <p>Producto: {{ $producto->nombre_comercial }}</p>
                <p>Color : {{ $producto->nombreColor }}, Marca : {{ $producto->nombreMarca }}, Tipo :
                    {{ $producto->nombreModo }}, Categoria : {{ $producto->nombreTipo }}, Cantidad:
                    {{ $producto->cantidad }}</p>
                <p>Precio unitario: ${{ $producto->precio }}</p>
                <p>
                    @if ($producto->tipoDescuento == 'Porcentaje')
                        Descuento : {{ intval($producto->descuento) }}%
                        <p> Costo :
                            ${{ $producto->precio * $producto->cantidad - ($producto->precio * intval($producto->descuento)) / 100 }}
                        </p>
                        @php
                            $total +=
                                $producto->precio * $producto->cantidad -
                                ($producto->precio * intval($producto->descuento)) / 100;
                        @endphp
                    @elseif ($producto->tipoDescuento == 'cantidad')
                        Descuento : ${{ $producto->descuento }}
                        <p> Costo : ${{ $producto->precio * $producto->cantidad - $producto->descuento }}</p>
                        @php
                            $total += $producto->precio * $producto->cantidad - $producto->descuento;
                        @endphp
                    @elseif ($producto->tipoDescuento == 'Sin descuento')
                        Costo : {{ $producto->precio * $producto->cantidad }}
                        @php
                            $total += $producto->precio * $producto->cantidad;
                        @endphp
                    @endif
                </p>
                <p style="margin-bottom: 10px;"></p>
            @endforeach
            <h5> Datos del pago </h5>
            <p>Requiere : {{ $ordenRecoleccion->factura ? 'Factura' : 'Nota' }}</p>
            <p>Metodo de pago : {{ $ordenRecoleccion->metodoPago }}</p>
            Costo total : ${{ number_format($total, 2) }}<br>
            {{ $ordenRecoleccion->metodoPago == 'Efectivo' ? 'Paga con : $' . $ordenRecoleccion->pagoEfectivo : '' }}
            <p>{{ $ordenRecoleccion->metodoPago == 'Efectivo' ? 'Cambio : $' . number_format($ordenRecoleccion->pagoEfectivo - $total, 2) : '' }}
            </p>
        </div>
        <!-- Agrega más items aquí -->
    </div>

</div>
<div class="footer item">
    <p>Recepciono:</p>
    <p>{{ $ordenRecoleccion->nombreEmpleado }} </p>
    Hora de recepcion : {{ $hora }}
    <p>Recibe : {{ $ordenRecoleccion->recibe }}</p>
    <p>{{ $Tiempo ? 'Tiempo aproximada de entrega : ' . $Tiempo->tiempo : 'No hay tiempo aproximado de entrega' }}
    </p>
    <p>{{ $ordenRecoleccion->comentario ? 'Observaciones : ' . $ordenRecoleccion->comentario : '' }}</p>

</div>
<div class="ubicacion">
    <p>{{ $DatosdelNegocio->ubicaciones }}; Conmutador: {{ $DatosdelNegocio->telefono }},
        WhatsApp : {{ $DatosdelNegocio->whatsapp }}</p>
    <p id="paginaweb">{{ $DatosdelNegocio->pagina_web }}</p>
</div>
</body>

</html>
