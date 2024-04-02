@extends('adminlte::page')

@section('title', 'Restablecer')

@section('content_header')
    <h1 class=" text-center">Elija la opcion a recuperar</h1>
@stop

@section('content')
    <section class=" w-full flex flex-col">
        @include('Restablecer._opcionCancelacion')
        @include('Restablecer._opcionClientes')
        @include('Restablecer._opcionProducto')
        @include('Restablecer._opcionEmpleado')
    </section>
@stop

@section('css')
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome para los iconos-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
