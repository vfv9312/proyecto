@extends('adminlte::page')

@section('title', 'Editar empleado')

@section('content_header')
    <h1>Editar cliente</h1>
@stop

@section('content')
    <form class="mt-8 flex flex-col justify-center items-center"
        action="{{ route('clientes.update', $cliente, $persona, $direcciones, $catalogo_colonias) }}" method="POST"
        enctype="multipart/form-data">
        @method('PUT')
        @include('clientes._form')
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
