@extends('adminlte::page')

@section('title', 'Editar empleado')

@section('content_header')
    <h1>Editar cliente</h1>
@stop

@section('content')
    <form class="mt-8 flex flex-col justify-center items-center"
        action="{{ route('clientes.update', $cliente, $persona, $direcciones) }}" method="POST" enctype="multipart/form-data">
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
    <script>
        document.getElementById('add').addEventListener('click', function(event) {
            event.preventDefault();
            var input = document.createElement('input');
            input.type = 'text';
            input.className = 'focus:ring-2 focus:ring-blue-300 focus:outline-none';
            input.style.width = '100%';
            document.getElementById('inputList').appendChild(input);
        });
    </script>
@stop
