@extends('adminlte::page')

@section('title', 'Orden de recoleccion')

@section('content_header')
    <h1>Orden de recoleccion</h1>
@stop

@section('content')
    <p>Listo puede descargar el ticket de entrega o puede descargarlo despues en el apartade se ordenes de recoleccion</p>
    <form method="POST" action="{{ route('generarpdf.ordenentrega') }}">
        @csrf
        @include('Principal.ordenEntrega._form_muestra_completado')
        <input type="hidden" name="listaCliente" value="{{ $listaCliente }}">
        <input type="hidden" name="datosPreventa" value="{{ $datosPreventa }}">
        <input type="hidden" name="listaEmpleado" value="{{ $listaEmpleado }}">
        <input type="hidden" name="listaProductos" value="{{ $listaProductos }}">
        <button type="submit"
            class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
            <i class="fas fa-file-pdf"></i>
            Ver PDF
        </button>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome para los iconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
