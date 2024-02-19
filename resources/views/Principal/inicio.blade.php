@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <header class=" flex justify-between p-3">

        <h1>Productos</h1> <a href="{{ route('inicio.create') }}"><i
                class="fa fa-shopping-bag fa-2x text-red-500 cursor-pointer"><span
                    class="ml-2 text-sm text-green-500">0</span></i>
        </a>
    </header>
@stop

@section('content')
    <h5 class=" text-center"> Hola <strong>{{ Auth::user()->name }}</strong> desde aqui podras registrar tus ventas de
        servicios o productos
    </h5>

    <section class="flex flex-wrap">
        @foreach ($productos as $producto)
            <div
                class=" m-3 bg-white cursor-pointer w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 h-72 border rounded-lg hover:shadow-lg hover:bg-black hover:bg-opacity-30">
                <figure class=" relative mb-3 w-full h-4/5">
                    <span
                        class=" absolute bottom-0 left-0  bg-green-500 rounded-lg text-sm m-2">{{ $producto->marca }}</span>
                    <img class=" w-full h-full object-cover rounded-lg" src="{{ $producto->fotografia }}" alt="producto" />
                    <div
                        class=" absolute top-0 right-0 flex justify-center items-center bg-green-600 w-6 h-6 rounded-full m-2">
                        <i class="fas fa-plus"></i>
                    </div>
                </figure>

                <p class=" flex flex-col">
                    <span class=" text-sm font-light truncate">{{ $producto->nombre_comercial }}</span>
                    <span class=" text-lg font-bold truncate">$ {{ $producto->precio }}</span>
                </p>
            </div>
        @endforeach
    </section>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome para los iconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@stop

@section('js')
    <script></script>
@stop
