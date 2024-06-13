<section class="flex flex-col border-4 mt-8 px-3 pb-3">
    <h1 class="text-2xl text-center text-gray-600 mb-3">Seleccione los productos</h1>

    <label class="flex items-center cursor-pointer mb-2 mt-2">
        <span class="ms-3 mr-2 text-sm font-medium
        text-gray-900 dark:text-gray-300">Productos</span>
        <input id="productoRecarga" type="checkbox" value="" class="sr-only peer">
        <div
            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
        </div>
        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Recargas</span>
    </label>

    <div class=" flex flex-col  lg:flex-row space-y-4 lg:space-y-0 lg:space-x-4">
        <select name="producto" id="producto"
            class="lg:w-1/2 w-full px-3 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline">

            <option value="" data-precio="">
            </option>

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
