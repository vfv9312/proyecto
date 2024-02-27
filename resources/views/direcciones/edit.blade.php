@extends('adminlte::page')

@section('title', 'Agregar direccion')

@section('content_header')
    <h1>Agregar direccion</h1>
@stop

@section('content')
    <form class="mt-8 flex flex-col justify-center items-center"
        action="{{ route('direcciones.update', $cliente, $catalogo_colonias) }}" method="POST">
        @method('PUT')
        @include('direcciones._form')
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@stop

@section('js')
    <script></script>
@stop
