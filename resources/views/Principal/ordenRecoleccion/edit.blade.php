@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <form class=""
        action="{{ route('orden_recoleccion.edit', ['orden_recoleccion' => $datosEnvio->idOrden_recoleccions]) }}"
        method="GET">
        @csrf
        @include('Principal.ordenRecoleccion._form_edit');
    </form>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@stop

@section('js')
    <script></script>
@stop
