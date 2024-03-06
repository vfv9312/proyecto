@extends('adminlte::page')

@section('title', 'Orden de recoleccion')

@section('content_header')

@stop

@section('content')
    <form action="{{ route('generarpdf.ordenservicio') }}" method="POST">
        @csrf
        @include('Principal.ordenServicio._form_completado')
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
    </script>
@stop
