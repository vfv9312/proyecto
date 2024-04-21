@extends('layouts.admin')

@section('title', 'Restablecer')

@section('content')

    <h1 class=" text-center">Elija la opcion a recuperar</h1>

    <section class=" w-full flex flex-col">
        @include('Restablecer._opcionCancelacion')
        @include('Restablecer._opcionClientes')
        @include('Restablecer._opcionProducto')
        @include('Restablecer._opcionEmpleado')
    </section>
@endsection

@push('css')
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome para los iconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@push('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@endpush
