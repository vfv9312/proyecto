@extends('layouts.admin')

@section('title', 'Productos')

@section('content')
    <h1 class=" text-center font-bold">Editar producto</h1>

    <form class="mt-8 flex flex-col justify-center items-center"
        action="{{ route('productos.update', $producto, $precioProducto, $marcas, $categorias, $datosProducto, $modos, $colores) }}"
        method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('Productos._form')
    </form>
@endsection

@push('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@endpush

@push('js')
    <script>
        /*
         */
    </script>
@endpush
