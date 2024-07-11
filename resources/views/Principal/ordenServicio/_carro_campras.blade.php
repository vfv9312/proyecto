<section class=" overflow-x-auto w-full border-4 mt-8 px-3 pb-3">
    <h1 class="text-2xl
    text-center font-bold text-green-700 mb-2">Productos requeridos</h1>
    <table class="overflow-x-auto min-w-full" id="tablaProductos">
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
                <td class=" text-center text-green-600 font-semibold">Total de Productos</td>
                <td id="SumaProducto" class=" text-center bg-green-700 text-white rounded-xl"></td>
                <td class=" text-center text-green-600 font-semibold">Total de Recargas</td>
                <td id="SumaRecarga" class=" text-center bg-green-700 text-white rounded-xl"></td>
                <td class=" text-center text-green-600 font-semibold">Total</td>
                <td id="sumaTotal" class=" text-center bg-green-700 text-white rounded-xl"></td>
            </tr>
        </tfoot>

    </table>

    <div class="flex flex-col w-full md:w-1/2">
        <label class="inline-flex items-center">
            <input type="checkbox" id="factura" name="factura" onchange="RequiereRFC()">
            <span class = "ml-2">Requiere factura</span>
        </label>
        <span id="warning" class="text-red-500 hidden">Si desea factura deberá ingresar RFC</span>

        <label class="block">
            <span class="text-gray-700">Método de pago</span>
            <select class="form-select block w-full mt-1" id="metodoPago" name="metodoPago" required>
                <option value="">Seleccione un método de pago</option>
                <option value="Efectivo">Efectivo</option>
                <option value="Cheque">Cheque</option>
                <option value="Transferencia Bancaria">Transferencia bancaria</option>
                <option value="Tarjeta Credito">Tarjeta credito</option>
                <!-- Agrega más opciones según sea necesario -->
            </select>
        </label>
        <div id="PagosEnEfectivo" class=" flex flex-row">
            <div id="pagoEfectivo" class="overflow-x-auto w-full border-4 mt-8 px-3 pb-3 hidden">
                <h1 class=" text-center text-green-600 font-bold">Producto</h1>
                <label class="block">
                    <span class="text-gray-700">Paga Con</span>
                    <input type="number" class="form-input mt-1 block w-full" id="pagaCon" name="pagaCon">
                </label>
                <label class="block" id="cambio">
                    <span class="text-gray-700">Cambio</span>
                    <input type="number" class="form-input mt-1 block w-full" id="cambioInput" name="cambioInput"
                        disabled readonly>
                </label>
            </div>
            <div id="pagoEfectivoRecarga" class="overflow-x-auto w-full border-4 mt-8 px-3 pb-3 hidden">
                <h1 class=" text-center text-green-600 font-bold">Recarga</h1>
                <label class="block">
                    <span class="text-gray-700">Paga Con</span>
                    <input type="number" class="form-input mt-1 block w-full" id="pagaConRecarga"
                        name="pagaConRecarga">
                </label>
                <label class="block" id="cambioRecarga">
                    <span class="text-gray-700">Cambio</span>
                    <input type="number" class="form-input mt-1 block w-full" id="cambioInputRecarga"
                        name="cambioInputRecarga" disabled readonly>
                </label>
            </div>
        </div>
    </div>
    <div>

    </div>
</section>
