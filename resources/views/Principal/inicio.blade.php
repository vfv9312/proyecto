@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <h5 class=" text-center"> Hola <strong>{{ Auth::user()->name }}</strong> desde aqui podras registrar tus ordenes de
        venta
        y ordenes de
        servicios
    </h5>

@stop

@section('content')
    <div class=" flex flex-col xl:py-40 xl:flex-row xl:space-x-12 xl:justify-center">
        @include('Principal._orden_servicio')
        @include('Principal._orden_entrega')
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome para los iconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!--animate.style-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@stop

@section('js')
    <script></script>
@stop
