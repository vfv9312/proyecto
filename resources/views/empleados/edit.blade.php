@extends('adminlte::page')

@section('title', 'Editar empleado')

@section('content_header')
    <h1>Editar empleado</h1>
@stop

@section('content')
    <form class="mt-8 flex flex-col justify-center items-center"
        action="{{ route('empleados.update', $empleado, $persona, $rol, $roles) }}" method="POST"
        enctype="multipart/form-data">
        @method('PUT')
        @include('empleados._form')
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
