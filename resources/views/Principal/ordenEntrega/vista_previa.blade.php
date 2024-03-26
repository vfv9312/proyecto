@extends('adminlte::page')

@section('title', 'vista previa')

@section('content_header')

@stop

@section('content')

    <body class="font-sans">
        <div class=" border-2 w-80 mx-auto">
            <div class=" text-center border-4 border-t border-dashed pb-5">
                <img class="w-50 h-auto" src="{{ asset('logo_ecotoner.png') }}" alt="Logo">
                <h1 class="text-xl">Ecotoner</h1>
                <p>orden de Entrega!</p>
                <h1>Ecotoner</h1>
                <p>Orden de Entrega!</p>
                <p>Col. Centro; 4a Norte Poniente 867, Tuxtla Gutiérrez, Chiapas</p>
                <p>Tel: (961) 61.115.44 o 961.1777.992</p>
                <p>Fecha recepcion: {{ $ordenRecoleccion->fechaCreacion }}</p>

            </div>
            <div class="border-4 border-t border-dashed pb-5">
                <h5 class="text-lg text-center"> Datos del cliente </h5>
                <p>Cliente : {{ $ordenRecoleccion->nombreCliente }} {{ $ordenRecoleccion->apellidoCliente }}</p>
                <p>Atencion : {{ $ordenRecoleccion->nombreAtencion }}</p>
                <p>Horario de trabajo :{{ $ordenRecoleccion->horarioTrabajoInicio }} hasta las:
                    {{ $ordenRecoleccion->horarioTrabajoFinal }}. {{ $ordenRecoleccion->diaSemana }}</p>
                <p> Tel :{{ $ordenRecoleccion->telefonoEmpleado }}</p>
                <p>Direccion : {{ $ordenRecoleccion->localidad }}; {{ $ordenRecoleccion->calle }}
                    #{{ $ordenRecoleccion->num_exterior }} @if ($ordenRecoleccion->num_interior)
                        {{ $ordenRecoleccion->num_interior }}
                    @endif
                </p>
                <p>CP : {{ $ordenRecoleccion->cp }}</p>
                <p>Referencia: {{ $ordenRecoleccion->referencia }}</p>
            </div>
            <div class=" border-4 border-t border-dashed pt-6">
                <div class="mb-5">
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($listaProductos as $producto)
                        <p>Producto: {{ $producto->nombre_comercial }}</p>
                        <p>Color : {{ $producto->nombreColor }}, Marca : {{ $producto->nombreMarca }}, Tipo :
                            {{ $producto->nombreModo }}, Categoria : {{ $producto->nombreTipo }}, Cantidad:
                            {{ $producto->cantidad }}</p>
                        <p style="margin-bottom: 10px;">Precio: ${{ $producto->precio * $producto->cantidad }}</p>
                        @php
                            $total += $producto->precio * $producto->cantidad;
                        @endphp
                    @endforeach
                    <p>Requiere : {{ $ordenRecoleccion->factura ? 'Factura' : 'Nota' }}</p>
                    <p>Metodo de pago : {{ $ordenRecoleccion->metodoPago }}</p>
                    Costo total : ${{ $total }}<br>
                    {{ $ordenRecoleccion->metodoPago == 'Efectivo' ? 'Paga con : $' . $ordenRecoleccion->pagoEfectivo : '' }}
                    <p>{{ $ordenRecoleccion->metodoPago == 'Efectivo' ? 'Cambio : $' . number_format($ordenRecoleccion->pagoEfectivo - $total, 2) : '' }}
                    </p>
                </div>
                <!-- Agrega más items aquí -->
            </div>
            <div class="border-4 border-t border-dashed pt-5 text-center">
                <span>Numero de
                    Folio:{{ $ordenRecoleccion->letraActual }}{{ sprintf('%06d', $ordenRecoleccion->ultimoValor) }}</span>
                <p>Le atendio:</p>
                <p>{{ $ordenRecoleccion->nombreEmpleado }} {{ $ordenRecoleccion->apellidoEmpleado }}</p>
                <p>Gracias por su pedido</p>
            </div>
        </div>
    </body>
@stop

@section('css')
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@stop

@section('js')
    <script></script>
@stop
