@extends('adminlte::page')

@section('title', 'opcion')

@section('content_header')
    <h1 class=" text-center">Productos</h1>
@stop

@section('content')
    <form action="" method="POST">
        <div class="container mx-auto py-6 px-4">
            <h1 class="text-2xl font-semibold mb-4">Carrito de compras</h1>
            @php
                $sumaTotal = 0;
                $combined = array_combine(array_keys($producto), array_values($producto_venta));
            @endphp

            @foreach ($combined as $prod => $venta_producto)
                <div class="flex items-center justify-between border-b py-4">
                    <div class="flex items-center">
                        <img class="h-16 w-16 object-cover" src="{{ $producto[$prod]->fotografia }}"
                            alt="{{ $producto[$prod]->nombre_comercial }}">
                        <div class="ml-4">
                            <h2 class="text-lg font-semibold">{{ $producto[$prod]->nombre_comercial }}</h2>
                            <p class="text-sm text-gray-600">{{ $producto[$prod]->marca }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">

                        <input id="cantidad" type="number" class="cantidad form-input w-20 mr-4"
                            value="{{ $venta_producto['producto']->cantidad }}">
                        <button class="text-red-600 hover:underline">Eliminar</button>
                    </div>

                    <p id="valorProducto" class="valorProducto text-lg font-semibold">
                    </p>
                </div>
            @endforeach

            <div class="flex items-center justify-between mt-6">
                <h2 id="total" class="text-xl font-semibold">Total:</h2>
                <p class="text-xl font-semibold">{{ $sumaTotal }}</p>
            </div>
            <div style="display: flex; justify-content: center;">

                <select name="metodo_pago" id="metodo_pago">
                    <option value="">Seleccione un método de pago</option>
                    <option value="tarjeta_credito">Tarjeta de crédito</option>
                    <option value="paypal">PayPal</option>
                    <option value="transferencia_bancaria">Transferencia bancaria</option>
                    <option value="efectivo">Efectivo</option>
                    <!-- Agrega más opciones según sea necesario -->
                </select>
            </div>

            <div class="mt-6">
                <button class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-500">Proceder al
                    pago</button>

            </div>
        </div>

    </form>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@stop

@section('js')
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            var cantidades = document.querySelectorAll('.cantidad');
            var resultados = document.querySelectorAll('.valorProducto');
            var precios = @json(array_map(function ($item) {
                    return $item['precio'];
                }, $combined));

            cantidades.forEach((cantidad, index) => {
                var resultado = resultados[index];
                var precio = precios[index];

                // Calcula el resultado inicial
                resultado.textContent = cantidad.value * precio;

                cantidad.addEventListener('input', function() {
                    resultado.textContent = this.value * precio;
                });
            });
        });
    </script>
@stop
