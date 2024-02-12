@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <h1 class=" text-center">Ecotoner</h1>
@stop

@section('content')
    <h5 class=" text-center"> Hola <strong>{{ Auth::user()->name }}</strong> desde aqui podras registrar tus ventas de
        servicios o productos
    </h5>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
