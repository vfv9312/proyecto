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
                /*Aquí se está inicializando la variable $sumaTotal con el valor 0. Esta variable podría ser utilizada posteriormente para almacenar la suma total de algún conjunto de valores, como por ejemplo, el precio total de los productos en un carrito de compras.*/
                $sumaTotal = 0;
                /*Aquí se está utilizando la función array_combine de PHP para combinar dos arrays, $producto y $producto_venta, en un solo array asociativo.*/
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
                        <button type="button" class="text-red-600 hover:underline"
                            onclick="eliminarProducto(this.parentNode.parentNode, {{ $loop->index }})">Eliminar</button>
                        <!-- Input invisible para almacenar el valor 0 cuando el producto se elimina -->
                        <input name="eliminacion[]" type="hidden" id="inputProducto{{ $loop->index }}" value="2">
                    </div>

                    <p id="valorProducto" id="cantidad{{ $loop->index }}" class="valorProducto text-lg font-semibold">
                    </p>
                </div>
            @endforeach
            <input type="hidden" name="venta" value={{ $venta }}>

            <div class="flex items-center justify-between mt-6">
                <h2 id="total" class="text-xl font-semibold">Total:</h2>
                <p class=" total text-xl font-semibold"></p>
            </div>
            <div style="display: flex; justify-content:center;">

                <select name="metodo_pago" id="metodo_pago">
                    <option value="">Seleccione un método de pago</option>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Cheque">Cheque</option>
                    <option value="Transferencia_Bancaria">Transferencia bancaria</option>
                    <option value="Tarjeta_Credito">Tarjeta credito</option>


                    <!-- Agrega más opciones según sea necesario -->
                </select>
            </div>
            <div>
                <label class="mr-4">Factura</label>
                <input type="checkbox" name="factura" value="1">
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Siguiente <i class="fas fa-arrow-right"></i>
                </button>

            </div>
        </div>

    </form>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

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

        function eliminarProducto(elemento, index) {
            // Obtener el input de cantidad correspondiente al producto eliminado
            var inputCantidad = elemento.querySelector('input[name="cantidad[]"]');
            // Establecer su valor a 0
            inputCantidad.value = 0;

            // Obtener el párrafo con id "valorProducto" correspondiente al producto eliminado
            var valorProducto = elemento.querySelector('#valorProducto');
            // Establecer su texto a 0
            valorProducto.textContent = '0';

            // Marcar el input de eliminación como 1 para indicar que se ha eliminado
            var inputEliminacion = elemento.querySelector('input[name="eliminacion[]"]');
            inputEliminacion.value = 1;
            // Ocultar el elemento (opcional)
            elemento.style.display = 'none';

            // Actualizar el total
            updateTotal();
        }

        document.querySelector('form').addEventListener('submit', function(e) {
            // Buscar todos los inputs de eliminación
            var inputsEliminacion = document.querySelectorAll('input[name="eliminacion[]"]');
            inputsEliminacion.forEach(function(input, index) {
                // Si el valor del input de eliminación es 1
                if (input.value == '1') {
                    // Buscar el input de cantidad correspondiente y establecer su valor a 0
                    var inputCantidad = document.querySelector('input[name="cantidad[]"]:nth-child(' + (
                        index + 1) + ')');
                    inputCantidad.value = 0;

                    // Actualizar el resultado
                    var resultado = document.querySelector('#valorProducto');
                    resultado.textContent = '0';
                }
            });
        });
    </script>
@stop
