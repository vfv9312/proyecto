<div class="container mx-auto py-6 px-4">
    <h1 class="text-2xl font-semibold mb-4">Vista de recoleccion</h1>

    @foreach ($productos as $producto)
        <div class="flex items-center justify-between border-b py-4">
            <div class="flex items-center">
                <div class="ml-4">
                    <h2 class="text-lg font-semibold">{{ $producto->nombre_comercial }}</h2>
                    <p class="text-sm text-gray-600">{{ $producto->marca }}</p>
                </div>
            </div>

            <div class="flex items-center">
                <input name="cantidad[]" type="number" class="cantidad form-input w-20 mr-4"
                    value="{{ $producto->cantidad_total }}">
                <button type="button" class="text-red-600 hover:underline"
                    onclick="eliminarProducto(this.parentNode.parentNode, {{ $loop->index }})">Eliminar</button>
            </div>
            </p>
        </div>
    @endforeach

    <div class="flex items-center justify-between mt-6">
        <h2 id="total" class="text-xl font-semibold">Total:</h2>
        <p class=" total text-xl font-semibold"></p>
    </div>
    <p class=" flex justify-end cambio"> </p>

    <div class="mt-6">
        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Siguiente <i class="fas fa-arrow-right"></i>
        </button>

    </div>
</div>
