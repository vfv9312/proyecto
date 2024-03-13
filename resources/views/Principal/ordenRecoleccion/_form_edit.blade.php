<div class="flex flex-wrap -mx-3 mt-16 whitespace-no-wrap border-b border-gray-200">
    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Nombre del Cliente
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="nombre_cliente" type="text" name="txtnombre_cliente"
            value="{{ $datosEnvio->nombreCliente }} {{ $datosEnvio->apellidoCliente }}" readonly>
    </div>
    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Atendido por
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="atencion" type="text" name="txtatencion"
            value="{{ $datosEnvio->nombreEmpleado }} {{ $datosEnvio->apellidoEmpleado }} - {{ $datosEnvio->nombre_rol }}"
            readonly>
    </div>
</div>


<div class="w-full md:w-full px-3 mb-6 md:mb-0 md:mt-10 whitespace-no-wrap border-b border-gray-200">
    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
        Dirección a entregar
    </label>
    <input
        class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        id="direccion" type="text" name="txtdireccion"
        value="Col.{{ $datosEnvio->colonia }}; {{ $datosEnvio->calle }} #{{ $datosEnvio->num_exterior }} - numero interio {{ $datosEnvio->num_interior }} - Referencia {{ $datosEnvio->referencia }}"
        readonly>
</div>
<div class="flex flex-wrap -mx-3 mt-16 whitespace-no-wrap border-b border-gray-200">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Telefono del cliente
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="telefono" type="text" name="txttelefono" value="{{ $datosEnvio->telefonoCliente }}" readonly>
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            RFC
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="rfc" type="text" name="txtrfc" value="{{ $datosEnvio->rfc }}">
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0 ">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Correo electronico
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="email" type="text" name="txtemail" value="{{ $datosEnvio->emailCliente }}" readonly>
    </div>

</div>
<div class="flex flex-wrap -mx-3 mt-16 whitespace-no-wrap border-b border-gray-200">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Fecha del pedido
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="fecha" type="text" name="txtfecha" value="{{ $datosEnvio->created_at }}" readonly>
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0 ">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Fecha de recoleccion
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="precio" type="text" name="txtprecio"
            @if ($datosEnvio->estatusPreventa == 4) @if ($datosEnvio->fechaRecoleccion == null)
value="hasta el momento no ha sido recolectado"
@else
value="{{ $datosEnvio->fechaRecoleccion }}" @endif
        @elseif($datosEnvio->estatusPreventa == 3) value="Solo es un pedido para envio" @endif >
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Fecha para entrega
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="fecha" type="text" name="txtfecha"
            @if ($datosEnvio->estatusRecoleccion == 4) value="Sin registro"
            @elseif($datosEnvio->estatusRecoleccion == 3) value="En revision"
            @elseif($datosEnvio->estatusRecoleccion == 2) value="{{ $datosEnvio->fechaEntrega }}" @endif
            readonly>
    </div>
</div>
<label class=" mt-7 block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
    Productos
</label>

@foreach ($productos as $producto)
    {{ $producto->nombre_comercial }} - {{ $producto->descripcion }} <br>
    <input type="hidden" name="productos[]" value="{{ $producto->nombre_comercial }}">
@endforeach

<div class="flex flex-col items-center mt-3">
    <div class="flex flex-col items-center">
        <label for="miSelect">Cambia el estatus:</label>
        <select id="miSelect" name="miSelect" onchange="mostrarInputCosto(this.value)">
            @if ($datosEnvio->estatusRecoleccion == 4)
                <option value="4">En recoleccion</option>
                <option value="3">En revision</option>
                <option value="2">En entrega </option>
                <option value="1">Venta completa</option>
            @elseif($datosEnvio->estatusRecoleccion == 3)
                <option value="3">En revision</option>
                <option value="2">En entrega </option>
                <option value="1">Venta completa</option>
            @elseif($datosEnvio->estatusRecoleccion == 2)
                <option value="2">En entrega </option>
                <option value="1">Venta completa</option>
            @endif
        </select>
    </div>

    <div class="flex justify-between mt-5">
        <div id="inputCosto" style="display: none;" class=" mr-4">
            <label for="costo">Costo total:</label>
            <input type="number" id="costo" name="txtcosto"
                class="w-full border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div id="inputmetodopago" style="display: none;" class="mr-4">
            <label for="metodoPago">Método de pago:</label>
            <select id="metodoPago" name="txtmetodoPago"
                class="w-full border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">Seleccione un método de pago</option>
                <option value="Efectivo">Efectivo</option>
                <option value="Cheque">Cheque</option>
                <option value="Transferencia_Bancaria">Transferencia bancaria</option>
                <option value="Tarjeta_Credito">Tarjeta credito</option>
                <!-- Agrega más opciones según sea necesario -->
            </select>
        </div>

        <div id="inputFactura" style="display: none;" class="flex flex-col items-center">
            <label for="factura" class="text-gray-700">¿Requiere factura?</label>
            <input type="checkbox" class="form-checkbox h-5 w-5 text-green-500 mt-2" name="txtfactura"
                id="factura">
        </div>


    </div>

    <button type="submit"
        class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-700 flex items-center mt-8">
        <i class="fas fa-sync-alt mr-2"></i>
        Actualizar
    </button>
</div>
