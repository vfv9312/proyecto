@extends('adminlte::page')

@section('title', 'Agregar direccion')

@section('content_header')
    <h1 class=" text-center">Editar datos del ticket</h1>
@stop

@section('content')
    <form class="mt-8 flex flex-col justify-center items-center" action="{{ route('infoticket.update', $infoticket) }}"
        method="POST">
        @method('PUT')
        @include('TicketUbicacion._form')
    </form>
@stop

@section('css')
    <!--Font Awesome para los iconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@stop

@section('js')
    <script></script>
@stop
