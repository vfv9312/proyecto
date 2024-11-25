<section id="contenedorCarrito" class="w-full px-3 pb-3 mt-8 overflow-x-auto border-4 ">
    <h1 class="mb-2 text-2xl font-bold text-center text-green-700">Productos requeridos</h1>
    <table class="min-w-full overflow-x-auto" id="tablaProductos">
        <thead>
            <tr>
                <th>Tipo Producto</th>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Tipo</th>
                <th>Modo</th>
                <th>Color</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Descuento</th>
                <th>Costo</th>
                <!-- Agrega el resto de los encabezados de las columnas aquí -->
            </tr>
        </thead>
        <tbody id="cuerpoTabla">
            <!-- Aquí se insertarán las filas de la tabla con JavaScript -->
        </tbody>
        <tfoot>
            <tr id="filaRecargas">
                <td colspan="4"></td>
                <td class="font-semibold text-center text-green-600 ">Total de Productos</td>
                <td id="SumaProducto" class="text-center text-white bg-green-700 rounded-xl"></td>
                <td class="font-semibold text-center text-green-600 ">Total de Recargas</td>
                <td id="SumaRecarga" class="text-center text-white bg-green-700 rounded-xl"></td>
                <td class="font-semibold text-center text-green-600 ">Total</td>
                <td id="sumaTotal" class="text-center text-white bg-green-700 rounded-xl"></td>
            </tr>
        </tfoot>

    </table>

    <div class="flex flex-col w-full md:w-1/2">
        <label id="contenedorCheckFactura" class="inline-flex items-center">
            <input type="checkbox" id="factura" name="factura" onchange="RequiereRFC()">
            <span class = "ml-2">Requiere factura</span>
        </label>
        <span id="warning" class="hidden text-red-500">Si desea factura deberá ingresar RFC</span>

        <label id="contenedorMetodoPago" class="block">
            <span class="text-gray-700">Método de pago</span>
            <select class="block w-full mt-1 form-select" id="metodoPago" name="metodoPago">
                <option value="">Seleccione un método de pago</option>
                @foreach ($metodosDePagos as $metodoPago)
                <option value="{{ $metodoPago->nombre }}">{{ $metodoPago->nombre }}</option>
                @endforeach


            </select>
        </label>
        <div id="PagosEnEfectivo" class="flex flex-row ">
            <div id="pagoEfectivo" class="hidden w-full px-3 pb-3 mt-8 overflow-x-auto border-4">
                <h1 class="font-bold text-center text-green-600 ">Producto</h1>
                <label class="block">
                    <span class="text-gray-700">Paga Con</span>
                    <input type="number" class="block w-full mt-1 form-input" id="pagaCon" name="pagaCon">
                </label>
                <label class="block" id="cambio">
                    <span class="text-gray-700">Cambio</span>
                    <input type="number" class="block w-full mt-1 form-input" id="cambioInput" name="cambioInput"
                        disabled readonly>
                </label>
            </div>
            <div id="pagoEfectivoRecarga" class="hidden w-full px-3 pb-3 mt-8 overflow-x-auto border-4">
                <h1 class="font-bold text-center text-green-600 ">Recarga</h1>
                <label class="block">
                    <span class="text-gray-700">Paga Con</span>
                    <input type="number" class="block w-full mt-1 form-input" id="pagaConRecarga"
                        name="pagaConRecarga">
                </label>
                <label class="block" id="cambioRecarga">
                    <span class="text-gray-700">Cambio</span>
                    <input type="number" class="block w-full mt-1 form-input" id="cambioInputRecarga"
                        name="cambioInputRecarga" disabled readonly>
                </label>
            </div>
        </div>
    </div>
    <div>

    </div>
</section>
