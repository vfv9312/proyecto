@extends('adminlte::page')

@section('title', 'opcion')

@section('content_header')
    <h1 class=" text-center">Productos</h1>
@stop

@section('content')
    <div class="container mx-auto py-6 px-4">
        <h1 class="text-2xl font-semibold mb-4">Carrito de compras</h1>
        @php
            $carrito = [
                'producto1' => [
                    'nombre' => 'Producto 1',
                    'precio' => 100,
                    'cantidad' => 2,
                    'imagen' => 'https://via.placeholder.com/640x480.png/0088aa?text=quam',
                    'descripcion' => 'Mediano',
                ],
                'producto2' => [
                    'nombre' => 'Producto 2',
                    'precio' => 200,
                    'cantidad' => 1,
                    'imagen' => 'https://via.placeholder.com/640x480.png/0088aa?text=quam',
                    'descripcion' => 'Regular',
                ],
                'producto3' => [
                    'nombre' => 'Producto 3',
                    'precio' => 150,
                    'cantidad' => 1,
                    'imagen' => 'https://via.placeholder.com/640x480.png/0088aa?text=quam',
                    'descripcion' => 'Bueno',
                ],
            ];
            $total = 0;
            foreach ($carrito as $producto) {
                $total += $producto['precio'] * $producto['cantidad'];
            }

        @endphp
        @foreach ($carrito as $producto)
            <div class="flex items-center justify-between border-b py-4">
                <div class="flex items-center">
                    <img class="h-16 w-16 object-cover" src="{{ $producto['imagen'] }}" alt="{{ $producto['nombre'] }}">
                    <div class="ml-4">
                        <h2 class="text-lg font-semibold">{{ $producto['nombre'] }}</h2>
                        <p class="text-sm text-gray-600">{{ $producto['descripcion'] }}</p>
                    </div>
                </div>

                <div class="flex items-center">
                    <input type="number" class="form-input w-20 mr-4" value="{{ $producto['cantidad'] }}">
                    <button class="text-red-600 hover:underline">Eliminar</button>
                </div>

                <p class="text-lg font-semibold">${{ $producto['precio'] * $producto['cantidad'] }}</p>
            </div>
        @endforeach

        <div class="flex items-center justify-between mt-6">
            <h2 class="text-xl font-semibold">Total:</h2>
            <p class="text-xl font-semibold">{{ $total }}$</p>
        </div>

        <div class="mt-6">
            <button onclick="window.location.href='{{ route('inicio.registro') }}'"
                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-500">Proceder al pago</button>
        </div>
    </div>



@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@stop

@section('js')
    <script></script>
@stop
