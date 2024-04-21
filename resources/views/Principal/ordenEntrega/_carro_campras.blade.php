<section class=" overflow-x-auto w-full border-4 mt-8 px-3 pb-3">
    <h1 class="text-2xl
    text-center text-gray-600 mb-2">Productos requeridos</h1>
    <table class="overflow-x-auto min-w-full" id="tablaProductos">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Tipo</th>
                <th>Modo</th>
                <th>Color</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Costo</th>
                <!-- Agrega el resto de los encabezados de las columnas aquí -->
            </tr>
        </thead>
        <tbody id="cuerpoTabla">
            <!-- Aquí se insertarán las filas de la tabla con JavaScript -->
        </tbody>
        <tfoot>
            <tr id="filaSuma">
                <td colspan="7">Total</td>
                <td id="sumaTotal"></td>
            </tr>
        </tfoot>
    </table>

    <div class="flex flex-col w-full md:w-1/2">
        <label class="inline-flex items-center">
            <input type="checkbox" id="factura" name="factura" onchange="toggleRFCField()">
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
        <label class="block" id="pagoEfectivo" style="display: none;">
            <span class="text-gray-700">Paga con</span>
            <input type="number" class="form-input mt-1 block w-full" id="pagaCon" name="pagaCon">
        </label>
        <label class="block" id="cambio" style="display: none;">
            <span class="text-gray-700">Cambio</span>
            <input type="number" class="form-input mt-1 block w-full" id="cambioInput" name="cambioInput" disabled
                readonly>
        </label>
    </div>
    <div>

    </div>
</section>
