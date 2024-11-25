<div class="flex flex-wrap mt-4 -mx-3 whitespace-no-wrap border-b border-gray-200">
    <div class="w-full px-3 mb-2 md:w-1/4 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Nombre del Cliente
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="nombre_cliente" type="text" name="txtnombre_cliente"
            value="{{ $ordenRecoleccion->nombreCliente }} {{ $ordenRecoleccion->apellidoCliente }}" readonly>
    </div>
    <div class="w-full px-3 mb-6 md:w-1/4 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Atendido por
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="atencion" type="text" name="txtatencion" value="{{ $ordenRecoleccion->nombreAtencion }}" readonly>
    </div>
    <div class="w-full px-3 mb-6 md:w-1/4 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Recibe
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="recibe" type="text" name="txtrecibe" value="{{ $ordenRecoleccion->nombreRecibe }}" readonly>
    </div>
    <div class="w-full px-3 mb-6 md:w-1/4 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Recepcionó
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="recepciono" type="text" name="txtrecepciono" value="{{ $ordenRecoleccion->nombreEmpleado }}" readonly>
    </div>
</div>


<div class="w-full px-3 mb-6 whitespace-no-wrap border-b border-gray-200 md:w-full md:mb-0 md:mt-10">
    <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
        Dirección a entregar
    </label>
    <input
        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
        id="direccion" type="text" name="txtdireccion"
        value="Col.{{ $ordenRecoleccion->colonia }}; {{ $ordenRecoleccion->calle }} #{{ $ordenRecoleccion->num_exterior }} {{ $ordenRecoleccion->num_interior ? '- numero interior ' . $ordenRecoleccion->num_interior : '' }}"
        readonly>
    <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
        Referencia
    </label>
    <input
        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
        id="direccion" type="text" name="txtdireccion"
        value=" {{ $ordenRecoleccion->referencia ? strtoupper($ordenRecoleccion->referencia) : 'Sin Referencia' }}" readonly>
</div>
<div class="flex flex-wrap mt-16 -mx-3 whitespace-no-wrap border-b border-gray-200">
    <div class="w-full px-3 mb-6 md:w-1/3 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Telefono del cliente
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="telefono" type="text" name="txttelefono" value="{{ $ordenRecoleccion->telefonoCliente }}" readonly>
    </div>
    <div class="w-full px-3 mb-6 md:w-1/3 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            RFC
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="rfc" type="text" name="txtrfc" value="{{ $ordenRecoleccion->rfc }}">
    </div>
    <div class="w-full px-3 mb-6 md:w-1/3 md:mb-0 ">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Correo electronico
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="email" type="text" name="txtemail" value="{{ $ordenRecoleccion->emailCliente }}" readonly>
    </div>

</div>
<div class="flex flex-wrap mt-16 -mx-3 whitespace-no-wrap border-b border-gray-200">
    <div class="w-full px-3 mb-6 md:w-1/4 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Fecha del pedido
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="fecha" type="text" name="txtfecha" value="{{ $ordenRecoleccion->created_at }}" readonly>
    </div>
    <div class="w-full px-3 mb-6 md:w-1/4 md:mb-0 ">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Fecha de recoleccion
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="precio" type="text" name="txtprecio"
            @if ($ordenRecoleccion->tipoVenta === 'Servicio') @if ($ordenRecoleccion->fechaRecoleccion == null)
value="Pendiente a recolectar"
@else
value="{{ $ordenRecoleccion->fechaRecoleccion }}" @endif
        @elseif($ordenRecoleccion->tipoVenta === 'Entrega') value="Pedido para envio" @endif >
    </div>
    <div class="w-full px-3 mb-6 md:w-1/4 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Fecha para entrega
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="fecha" type="text" name="txtfecha"
            @if ($ordenRecoleccion->estado === 'Recolectar') value="Sin registro"
            @elseif($ordenRecoleccion->estado === 'Revision') value="En revision"
            @elseif($ordenRecoleccion->estado === 'Entrega') value="Pendiente de entrega"
            @elseif($ordenRecoleccion->estado === 'Listo') value="{{ $ordenRecoleccion->fechaEntrega }}" @endif
            readonly>
    </div>
    <div class="w-full px-3 mb-6 md:w-1/4 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Paga Con
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="pagaCon" type="text" name="txtpagaConanterior" value="{{ $ordenRecoleccion->pago_efectivo }}" readonly>
    </div>
</div>
@include('Principal.ordenRecoleccion.__tabla_productos')
@if ($ordenRecoleccion->id_cancelacion == null)

    <div class="flex flex-col items-center mt-3">
        <div class="flex flex-col items-center">
            <label for="miSelect">Cambia el estatus:</label>
            <select id="miSelect" name="miSelect">
                @if ($ordenRecoleccion->estado === 'Recolectar')
                    <option value="EnRevision">En recoleccion</option>
                    <option value="Revision">En revision</option>
                @elseif($ordenRecoleccion->estado === 'Revision')
                    <option value="EnRevision">En revision</option>
                    <option value="Entrega">En entrega </option>
                @elseif($ordenRecoleccion->estado === 'Entrega')
                    <option value="EnRevision">Seleccione una opcion</option>
                    <option value="Entrega">Actualizar</option>
                    <option value="Listo">Venta completa</option>
                @endif
            </select>
        </div>

        <div id="form_observaciones" class="flex flex-col justify-between mt-5 sm:flex-row" style="display: none;">
            <div class="mr-4">
                <label for="">Observaciones:</label>
                <textarea id="observaciones" name="observacionesDetalle" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escribe aqui..."></textarea>

            </div>
        </div>
    <div id="form_codigo" class="hidden">
        <div id="contenedorcodigo"  class="justify-between mt-5 sm:flex-row" >
            <div class="mr-4">
                <label for="codigo">Entrego:</label>
                <input type="text" id="entrego" name="entrego"
                    class="w-full leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
            </div>

            <div class="mr-4">
                <label for="Observaciones">Observaciones :</label>
                <textarea id="observacionesInicial" name="observacionesInicial" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escribe aqui..."></textarea>
            </div>
            <div class="mr-4">
                <label for="fecha_recoleccion">Fecha y hora de recoleccion:</label>
                <input id="fechaRecolecciones"
                    class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    type="datetime-local" name="HoraFechaRecoleccion">
            </div>
        </div>

        <div class="mr-4">
            @include('Principal.ordenEntrega._Lista_Productos')
            @include('Principal.ordenEntrega._carro_campras')
        </div>
    </div>



        <div class="flex justify-between mt-5">
            <div id="inputCosto" class="hidden mr-4 ">
                <label for="costo">Costo total:</label>
                <input type="number" id="costo" name="costo_total" step="0.01"
                    class="w-full h-6 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    readonly>
            </div>

            <div id="inputmetodopago" class="hidden mr-4 ">
                <label for="metodoPago">Método de pago:</label>
                <select id="selectmetodoPago" name="txtmetodoPago"
                    class="w-full leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                    <option value="">Seleccione un método de pago</option>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Cheque">Cheque</option>
                    <option value="Transferencia_Bancaria">Transferencia bancaria</option>
                    <option value="Tarjeta_Credito">Tarjeta credito</option>
                    <!-- Agrega más opciones según sea necesario -->
                </select>
            </div>

            <div id="inputFactura" class="items-center hidden">
                <label for="factura" class="text-gray-700">¿Requiere factura?</label>
                <input type="checkbox" class="w-5 h-5 mt-2 text-green-500 form-checkbox" name="txtfactura"
                    id="factura">
            </div>

            <div id="personaRecibe" class="flex-row items-center justify-center hidden ">
                <div class="flex flex-col ">
                    <label for="recibe">Observaciones : </label>
                    <textarea id="obersaciondeEntrega" name="observaciones" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escribe aqui..."></textarea>
                </div>
                <div class="flex flex-col ">
                    <label for="recibe">Fecha y hora de entrega:</label>
                    <input id="FechadeEntrega"
                        class="px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none w-72 focus:outline-none focus:shadow-outline"
                        type="datetime-local" name="HoraFechaEntregado">
                </div>
                <div class="flex flex-col ">
                    <label for="recibe">Quien recibe ? : </label>
                    <input id="recibeenlaEntrega"
                        class="px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none w-72 focus:outline-none focus:shadow-outline"
                        type="text" name="recibe" placeholder="Recibe">
                </div>
            </div>

        </div>
        <div id="inputPagoEfectivo" class="hidden mr-4">
            <label for="pagoEfectivo">Paga con:</label>
            <input id="pagoEfectivoApagar" name="txtpagoEfectivo" type="number" step="0.01"
                class="w-full leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                placeholder="Ingrese la cantidad pagada" value="{{ $ordenRecoleccion->pago_efectivo }}">
            <label for="pagoEfectivo">Cambio:</label>
            <input id="cambiodelEfectivo" name="txtcambio" type="number" step="0.01"
                class="w-full leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                placeholder="cambio" value="">
        </div>


        <button type="submit"
            class="flex items-center px-4 py-2 mt-8 text-white bg-green-500 rounded hover:bg-green-700">
            <i class="mr-2 fas fa-sync-alt"></i>
            Actualizar
        </button>

    </div>
@else
    <div class="flex flex-col items-center mt-3">
        <div class="flex flex-col items-center">
            <label for="miSelect">Estatus:</label>
            @switch($ordenRecoleccion->estado)
                @case('Recolectar')
                    <span>En recoleccion</span>
                @break

                @case('Revision')
                    <span>En revision</span>
                @break

                @case('Entrega')
                    <span>En entrega</span>
                @break

                @case('Listo')
                    <span>Orden Procesada</span>
                @break

                @default
            @endswitch
        </div>
    </div>
@endif
