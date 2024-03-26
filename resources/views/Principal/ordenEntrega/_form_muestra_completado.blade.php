<div class="flex flex-wrap -mx-3 mt-16 px-6 py-4 whitespace-no-wrap border-b border-gray-200">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Nombre del Cliente
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="nombre_cliente" type="text" name="txtnombre_cliente"
            value=" {{ $ordenRecoleccion->nombreCliente }} {{ $ordenRecoleccion->apellidoCliente }}" readonly>
    </div>

    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Atencion
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="atencion" type="text" name="txtatencion" value="{{ $ordenRecoleccion->nombreEmpleado }}" readonly>
    </div>

    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Empleado
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="atencion" type="text" name="txtatencion"
            value="{{ $ordenRecoleccion->nombreEmpleado }} {{ $ordenRecoleccion->apellidoEmpleado }} -
            {{ $ordenRecoleccion->nombreRol }}"
            readonly>
    </div>
</div>
<div class="flex flex-wrap -mx-3 mt-5 px-6 py-4 whitespace-no-wrap border-b border-gray-200">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Telefono
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="nombre_cliente" type="text" name="txtnombre_cliente"
            value=" {{ $ordenRecoleccion->telefonoCliente }}" readonly>
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            RFC
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="atencion" type="text" name="txtatencion" value=" {{ $ordenRecoleccion->rfc }}" readonly>
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Correo electronico
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="atencion" type="text" name="txtatencion" value="{{ $ordenRecoleccion->correo }}" readonly>
    </div>
</div>
<div class="flex flex-wrap -mx-3 mt-5 px-6 py-4 whitespace-no-wrap border-b border-gray-200">
    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Direccion
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="nombre_cliente" type="text" name="txtnombre_cliente"
            value="{{ $ordenRecoleccion->municipio }}, {{ $ordenRecoleccion->estado }};
            Col.{{ $ordenRecoleccion->localidad }}; {{ $ordenRecoleccion->calle }}
            #{{ $ordenRecoleccion->num_exterior }} / numero interior
            {{ $ordenRecoleccion->num_interior == null ? 'S/N' : $ordenRecoleccion->num_interior }}"
            readonly>
    </div>
    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Fecha del pedido
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="atencion" type="text" name="txtatencion" value="{{ $ordenRecoleccion->fechaCreacion }}" readonly>
    </div>
</div>

<div class="flex flex-wrap -mx-3 mt-5 px-6 py-4 whitespace-no-wrap border-b border-gray-200">
    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Requiere :
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="nombre_cliente" type="text" name="txtnombre_cliente"
            value="{{ $ordenRecoleccion->factura == 1 ? 'Factura' : 'Nota' }}" readonly>
    </div>
    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Costo total
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="atencion" type="text" name="txtatencion"
            value="@php $total = 0;
            foreach ($listaProductos as $producto) {
                $total += $producto->precio * $producto->cantidad;} @endphp ${{ $total }}"
            readonly>
        <input type="hidden" name="total" value="{{ $total }}">
    </div>
    @if ($ordenRecoleccion->metodoPago == 'Efectivo')
        <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                Paga con
            </label>
            <input
                class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="atencion" type="text" name="txtatencion" value=" ${{ $ordenRecoleccion->pagoEfectivo }}"
                readonly>
        </div>
        <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                Cambio
            </label>
            <input
                class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="atencion" type="text" name="txtatencion"
                value="@php $cambio = number_format($ordenRecoleccion->pagoEfectivo - $total, 2); @endphp ${{ $cambio }}"
                readonly>
            <input type="hidden" name="total" value="{{ $cambio }}">
        </div>
    @else
        <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                Metodo de pago
            </label>
            <input
                class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="atencion" type="text" name="txtatencion" value=" {{ $ordenRecoleccion->metodoPago }}"
                readonly>
        </div>
    @endif

</div>
