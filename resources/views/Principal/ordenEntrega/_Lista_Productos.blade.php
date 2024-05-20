<section class="flex flex-col border-4 mt-8 px-3 pb-3">
    <h1 class="text-2xl text-center text-gray-600 mb-3">Seleccione los productos</h1>
    <div class=" flex flex-col  lg:flex-row space-y-4 lg:space-y-0 lg:space-x-4">
        <select name="producto" id="producto"
            class="lg:w-1/2 w-full px-3 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @foreach ($productos as $producto)
                <option value="{{ $producto->id }}" data-precio="${{ $producto->precio }}">
                    {{ $producto->nombre_comercial }}_{{ $producto->nombre_modo }}_{{ $producto->nombre_marca }}_{{ $producto->nombre_categoria }}_{{ $producto->nombre_color }}
                </option>
            @endforeach
        </select>
        <input type="number" step="1" min="1" id="cantidad"
            class="w-full lg:w-32  px-3 lg:ml-3 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            placeholder="Cantidad">
        <button type="button" id="agregarProducto"
            class=" lg:ml-3 px-4 sm:mt-4
            bg-gray-800 text-white text-sm font-medium rounded hover:bg-gray-700 focus:outline-none focus:bg-gray-700
            focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
            <i class="fas fa-plus"></i>Agregar producto
        </button>
        <button type="button" id="Detalle"
            class="lg:ml-3 px-4 sm:mt-4  bg-gray-800 text-white text-sm font-medium rounded hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">

            <i class="fas fa-info-circle"></i> Detalles
        </button>
    </div>
    <div id="detallesProducto" class="mt-4"></div>

    <input type="hidden" id="inputProductosSeleccionados" name="inputProductosSeleccionados">
</section>
