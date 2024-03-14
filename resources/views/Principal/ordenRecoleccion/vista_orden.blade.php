@extends('adminlte::page')

@section('title', 'Orden de recoleccion')

@section('content_header')
    <h1>Ordenes</h1>
@stop

@section('content')

    @include('Principal.ordenRecoleccion._tabla_datos_orden')


    <div class="mt-6 flex justify-center">
        <button type="button"
            @if ($buscarrecoleccion) onclick="window.location.href='{{ route('generarpdf.ordenentrega', ['id' => $buscarrecoleccion->id]) }}'"
    @else
    onclick="window.location.href='{{ route('generarpdf.ordenentrega', ['id' => $Ordenderecoleccion->id]) }}'" @endif
            class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
            <i class="fas fa-file-pdf"></i>
            Ver PDF
        </button>
        <button type="button"
            @if ($buscarrecoleccion) onclick="window.location.href='{{ route('orden_entrega.show', ['orden_entrega' => $buscarrecoleccion->id]) }}'"
        @else
        onclick="window.location.href='{{ route('orden_entrega.show', ['orden_entrega' => $Ordenderecoleccion->id]) }}'" @endif
            class="mr-8 ml-8 inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
            <i class="fas fa-eye"></i>
            Vista previa
        </button>


        <button type="button"
            class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
            <i class="fas fa-envelope"></i>
            Enviar por correo
        </button>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome para los iconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
