<section class="flex flex-col px-3 pb-3 mt-8 border-4">
    <h1 class="mb-3 text-2xl font-bold text-center text-green-700">Seleccione los productos</h1>

    <label id="contenedorCheckproductoRecoleccion" class="flex items-center mt-2 mb-2 cursor-pointer">

        <input id="CheckproductoRecoleccion" type="checkbox" value="" class="sr-only peer">
        <div
            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
        </div>
        <span class="text-sm font-medium text-gray-900 ms-3 dark:text-gray-300">Recoleccion</span>
    </label>
        <label id="contenedorCheckproductoEntrega" class="flex items-center mt-2 mb-2 cursor-pointer">

        <input id="CheckproductoEntrega" type="checkbox" value="" class="sr-only peer">
        <div
            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
        </div>
        <span class="text-sm font-medium text-gray-900 ms-3 dark:text-gray-300">Entregas</span>
    </label>

    <div id="contenedorProducto" class="flex flex-col space-y-4 lg:flex-row lg:space-y-0 lg:space-x-4">
        <select name="producto" id="producto"
            class="w-full px-3 leading-tight text-gray-700 border rounded shadow appearance-none lg:w-1/2 focus:outline-none focus:shadow-outline">

            <option value="" data-precio="" data-estatus="" data-idPrecio="" data-alternativoUno=""
                data-alternativoDos="" data-alternativoTres="">
            </option>

        </select>
        <input type="number" step="1" min="1" id="cantidad"
            class="w-full px-3 leading-tight text-gray-700 border rounded shadow appearance-none lg:w-32 lg:ml-3 focus:outline-none focus:shadow-outline"
            placeholder="Cantidad">
        <button type="button" id="agregarProducto"
            class="px-4 text-sm font-medium text-white bg-green-600 rounded lg:ml-3 sm:mt-4 hover:bg-green-700 focus:outline-none focus:bg-green-800 focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
            <i class="fas fa-plus"></i>Confirmar producto
        </button>
        <button type="button" id="Detalle"
            class="px-4 text-sm font-medium text-white bg-green-600 rounded lg:ml-3 sm:mt-4 hover:bg-green-700 focus:outline-none focus:bg-green-800 focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">

            <i class="fas fa-info-circle"></i> Detalles
        </button>
        <button type="button" id="agregarProductoNuevo"
        class="px-4 text-sm font-medium text-white bg-green-600 rounded lg:ml-3 sm:mt-4 hover:bg-green-700 focus:outline-none focus:bg-green-800 focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
        <i class="fas fa-plus"></i>Agregar producto
    </button>
    </div>
    <div id="detallesProducto" class="mt-4"></div>

    <input type="hidden" id="inputcheckProductooRecoleccion" name="inputcheckProductooRecoleccion" value="">

    <input type="hidden" id="inputProductosSeleccionados" name="inputProductosSeleccionados">
</section>
