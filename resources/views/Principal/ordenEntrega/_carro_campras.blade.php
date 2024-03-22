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
            <input type="number" class="form-input mt-1 block w-full" id="cambioInput" name="cambioInput" readonly>
        </label>
    </div>
    <div>

    </div>
</section>
<section class=" w-full border-4 mt-8 px-3 pb-3">
    <h1 class="text-2xl
    text-center text-gray-600 mb-2">Horario de Trabajo</h1>
    <div class=" flex w-full">
        <div class="flex flex-col w-full md:w-1/2">
            <label class="mr-4">De :</label>
            <input type="time"
                class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="horarioTrabajoInicio" name="horarioTrabajoInicio">
        </div>
        <div class="flex flex-col w-full md:w-1/2">
            <label class="mr-4">Hasta :</label>
            <input type="time"
                class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="horarioTrabajoFinal" name="horarioTrabajoFinal">
        </div>
    </div>
    <div class="flex flex-wrap justify-center">
        <label class="inline-flex items-center mr-3">
            <input type="checkbox" name="dias[]" value="Lunes">
            <span class="ml-2">Lunes</span>
        </label>
        <label class="inline-flex items-center mr-3">
            <input type="checkbox" name="dias[]" value="Martes">
            <span class="ml-2">Martes</span>
        </label>
        <label class="inline-flex items-center mr-3">
            <input type="checkbox" name="dias[]" value="Miércoles">
            <span class="ml-2">Miércoles</span>
        </label>
        <label class="inline-flex items-center mr-3">
            <input type="checkbox" name="dias[]" value="Jueves">
            <span class="ml-2">Jueves</span>
        </label>
        <label class="inline-flex items-center mr-3">
            <input type="checkbox" name="dias[]" value="Viernes">
            <span class="ml-2">Viernes</span>
        </label>
        <label class="inline-flex items-center mr-3">
            <input type="checkbox" name="dias[]" value="Sábado">
            <span class="ml-2">Sábado</span>
        </label>
        <label class="inline-flex items-center mr-3">
            <input type="checkbox" name="dias[]" value="Domingo">
            <span class="ml-2">Domingo</span>
        </label>
    </div>

</section>
