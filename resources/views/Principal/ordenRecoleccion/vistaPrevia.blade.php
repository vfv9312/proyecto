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
                <p>Col. Centro; 4a Norte Poniente 867, Tuxtla Gutiérrez, Chiapas</p>
                <p>Tel: (961) 61.115.44 o 961.1777.992</p>
            </div>
            <div class=" border-4 border-t border-dashed pt-6">
                <div class="mb-5">
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
                    <p class=" mt-4"> Costo total : ${{ $total }}</p>
                    {{ $ordenRecoleccion->metodoPago }}
                    {{ $ordenRecoleccion->metodoPago == 'Efectivo' ? 'Paga con : $' . $ordenRecoleccion->pagoEfectivo : '' }}
                    <p>{{ $ordenRecoleccion->metodoPago == 'Efectivo' ? 'Cambio : $' . ($ordenRecoleccion->pagoEfectivo - $total) : '' }}
                    </p>
                </div>
                <!-- Agrega más items aquí -->
            </div>
            <div class="border-4 border-t border-dashed pb-5">
                <h5 class="text-lg"> Datos del cliente </h5>

                <p>{{ $ordenRecoleccion->nombreCliente }}</p>
                <p>{{ $ordenRecoleccion->telefonoEmpleado }}</p>
                <p>Col.{{ $ordenRecoleccion->localidad }}; {{ $ordenRecoleccion->calle }}
                    #{{ $ordenRecoleccion->num_exterior }} @if ($ordenRecoleccion->num_interior)
                        {{ $ordenRecoleccion->num_interior }}
                    @endif
                </p>
                <p>CP : {{ $ordenRecoleccion->cp }}</p>
                <p>Referencia: {{ $ordenRecoleccion->referencia }}</p>
                <p>Factura : {{ $ordenRecoleccion->factura ? 'SI' : 'NO' }}</p>
            </div>
            <div class="border-4 border-t border-dashed pt-5 text-center">
                <span>Ticket compra:{{ $ordenRecoleccion->idRecoleccion }}</span>
                <p>Le atendio:</p>
                <p>{{ $ordenRecoleccion->nombreEmpleado }} {{ $ordenRecoleccion->apellidoEmpleado }}</p>
                <p>Fecha : {{ $ordenRecoleccion->fechaCreacion }}</p>
                <p>Gracias por su compra!</p>
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
