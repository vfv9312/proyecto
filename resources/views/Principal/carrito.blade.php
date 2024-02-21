@extends('adminlte::page')

@section('title', 'opcion')

@section('content_header')
    <h1 class=" text-center">Productos</h1>
@stop

@section('content')
    <form action="{{ route('inicio.registro') }}" method="POST">
        @csrf
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
                        <input type="hidden" name="productos[]"
                            value={{ $venta_producto['producto']->id_precio_producto }}>
                        <input name="cantidad[]" type="number" class="cantidad form-input w-20 mr-4"
                            value="{{ $venta_producto['producto']->cantidad }}">
                        <button class="text-red-600 hover:underline">Eliminar</button>
                    </div>

                    <p id="valorProducto" class="valorProducto text-lg font-semibold">
                    </p>
                </div>
            @endforeach
            <input type="hidden" name="venta" value={{ $venta }}>

            <div class="flex items-center justify-between mt-6">
                <h2 id="total" class="text-xl font-semibold">Total:</h2>
                <p class=" total text-xl font-semibold"></p>
            </div>
            <div style="display: flex; justify-content: center;">

                <select name="metodo_pago" id="metodo_pago">
                    <option value="">Seleccione un método de pago</option>
                    <option value="Tarjeta_Credito">Tarjeta de crédito</option>
                    <option value="Paypal">PayPal</option>
                    <option value="Transferencia_Bancaria">Transferencia bancaria</option>
                    <option value="Efectivo">Efectivo</option>
                    <!-- Agrega más opciones según sea necesario -->
                </select>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-500">Proceder al
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
            var totalElement = document.querySelector('.total');
            var precios = @json(array_map(function ($item) {
                    return $item['precio'];
                }, $combined));

            function updateTotal() {
                var total = 0;
                resultados.forEach((resultado) => {
                    total += parseFloat(resultado.textContent);
                });
                totalElement.textContent = total;
            }

            cantidades.forEach((cantidad, index) => {
                var resultado = resultados[index];
                var precio = precios[index];

                // Calcula el resultado inicial
                resultado.textContent = cantidad.value * precio;

                cantidad.addEventListener('input', function() {
                    resultado.textContent = this.value * precio;
                    updateTotal();
                });
            });
            updateTotal();
        });
    </script>
@stop
