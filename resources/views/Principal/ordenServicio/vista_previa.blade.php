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
                    @foreach ($productos as $produc)
                        Producto a recolectar : {{ $produc->nombre_comercial }} - {{ $produc->cantidad }} -
                        {{ $produc->descripcion }}
                    @endforeach
                </div>
                <!-- Agrega más items aquí -->
            </div>
            <div class="border-4 border-t border-dashed pb-5">
                <h5 class="text-lg"> Datos del cliente </h5>
                <p> {{ $ordenRecoleccion->nombreCliente }} {{ $ordenRecoleccion->apellidoCliente }}</p>
                <p>Tel: {{ $ordenRecoleccion->telefonoCliente }}</p>
                <p>RFC : {{ $ordenRecoleccion->rfc }}</p>
                <p>{{ $ordenRecoleccion->correo }}</p>
                <p>Col.{{ $ordenRecoleccion->localidad }}; {{ $ordenRecoleccion->calle }}
                    #{{ $ordenRecoleccion->num_exterior }}
                    {{ $ordenRecoleccion->num_interior ? 'num interio #' . $ordenRecoleccion->num_interior : '' }}</p>
            </div>
            <div class="border-4 border-t border-dashed pt-5 text-center">
                <span>Ticket recoleccion:{{ $ordenRecoleccion->idRecoleccion }}</span>
                <p>Le atendio:</p>
                <p>{{ $ordenRecoleccion->nombreEmpleado }} {{ $ordenRecoleccion->apellidoEmpleado }}</p>
                <p>Fecha : {{ $ordenRecoleccion->fechaCreacion }}</p>
                <p>Orden de recoleccion!</p>
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
