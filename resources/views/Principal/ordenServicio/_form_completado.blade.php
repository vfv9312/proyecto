<div class="flex flex-wrap -mx-3 mt-16 px-6 py-4 whitespace-no-wrap border-b border-gray-200">
    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Nombre del Cliente
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="nombre_cliente" type="text" name="txtnombre_cliente"
            value=" {{ $ordenRecoleccion->nombreCliente }} {{ $ordenRecoleccion->apellidoCliente }}" readonly>
    </div>

    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Atencion
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="atencion" type="text" name="txtatencion" value="{{ $ordenRecoleccion->nombreAtencion }}" readonly>
    </div>

    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Recibe
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="atencion" type="text" name="txtatencion" value="{{ $ordenRecoleccion->recibe }}" readonly>
    </div>

    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Empleado
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="atencion" type="text" name="txtatencion" value="{{ $ordenRecoleccion->nombreEmpleado }}" readonly>
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
            Col.{{ $ordenRecoleccion->localidad }}; {{ $ordenRecoleccion->calle }}#{{ $ordenRecoleccion->num_exterior }}
            {{ $ordenRecoleccion->num_interior == null ? 'S/N' : '/ numero interior' . $ordenRecoleccion->num_interior }}"
            readonly>
    </div>
    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Fecha de recepción
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="atencion" type="text" name="txtatencion" value="{{ $ordenRecoleccion->fechaCreacion }}" readonly>
    </div>
    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Referencia
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="nombre_cliente" type="text" name="txtnombre_cliente"
            value="{{ $ordenRecoleccion->referencia == null ? 'S/D' : $ordenRecoleccion->referencia }}" readonly>
    </div>
    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Fecha de entrega
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="atencion" type="text" name="txtatencion"
            value="{{ $ordenRecoleccion->fechaEntrega ? $ordenRecoleccion->fechaEntrega : 'Por el momento no se ha entregado' }}"
            readonly>
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
                $total += $producto->precio_unitario;} @endphp ${{ $total }}"
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
<div class="mt-7 flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nombre Comercial
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Cantidad Total
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Descripción
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Precio unitario
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Descuento
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Costo
                            </th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($listaProductos as $producto)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $producto->nombre_comercial }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $producto->cantidad }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    Color : {{ $producto->nombreColor }}, Marca : {{ $producto->nombreMarca }},
                                    Categoria :
                                    {{ $producto->nombreTipo }}, Tipo : {{ $producto->nombreModo }}
                                </td>
                                <td>
                                    ${{ $producto->precio }}
                                </td>
                                <td>
                                    @if ($producto->tipoDescuento == 'Porcentaje')
                                        {{ intval($producto->descuento) }}%
                                    @elseif ($producto->tipoDescuento == 'cantidad')
                                        ${{ $producto->descuento * $producto->cantidad }}
                                    @elseif ($producto->tipoDescuento == 'Sin descuento')
                                        {{ $producto->tipoDescuento }}
                                    @endif
                                </td>
                                <td>
                                    {{ $producto->precio_unitario }}
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
