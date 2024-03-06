@extends('adminlte::page')

@section('title', 'Datos de la recoleccion')

@section('content_header')

@stop

@section('content')
    <h1 class=" text-2xl">Registro de los productos a recolectar</h1>
    <form class=" mt-16 flex flex-col justify-center" action="{{ route('orden_servicio.edit', $Preventa->id) }}"
        method="GET">
        @include('Principal.ordenServicio._form_producto')
    </form>

    <form action="{{ route('orden_servicio.update', $Preventa->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="dato2" value="valor2">
        <!-- Agrega más campos de entrada ocultos según sea necesario -->

        <div class="flex justify-center mt-8">
            <input type="hidden" name="dato" value="valor">
            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-700">
                Siguiente
                <i class="fas fa-arrow-right ml-2"></i>
            </button>
        </div>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Incluir las librerías de jQuery y Select2 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
