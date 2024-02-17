@extends('adminlte::page')

@section('title', 'Editar producto')

@section('content_header')
    <h1>Editar producto</h1>
@stop

@section('content')
    <form class="mt-8 flex flex-col items-center" action="{{ route('productos.update', $producto) }}" method="POST">
        @method('PUT')
        @include('Productos._form')
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@stop

@section('js')
    <script>
        console.log('Hi!');
        /*
         */
    </script>
@stop
