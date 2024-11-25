<div class="flex flex-wrap px-6 py-4 mt-16 -mx-3 whitespace-no-wrap border-b border-gray-200">
    <div class="w-full px-3 mb-6 md:w-1/4 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Nombre del Cliente
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="nombre_cliente" type="text" name="txtnombre_cliente"
            value=" {{ $ordenRecoleccion->nombreCliente }} {{ $ordenRecoleccion->apellidoCliente }}" readonly>
    </div>

    <div class="w-full px-3 mb-6 md:w-1/4 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Atencion
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
            id="atencion" type="text" name="txtatencion" value="{{ $ordenRecoleccion->recibe }}" readonly>
    </div>

    <div class="w-full px-3 mb-6 md:w-1/4 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Empleado
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="atencion" type="text" name="txtatencion" value="{{ $ordenRecoleccion->nombreEmpleado }}" readonly>
    </div>
</div>
<div class="flex flex-wrap px-6 py-4 mt-5 -mx-3 whitespace-no-wrap border-b border-gray-200">
    <div class="w-full px-3 mb-6 md:w-1/3 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Telefono
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="nombre_cliente" type="text" name="txtnombre_cliente"
            value=" {{ $ordenRecoleccion->telefonoCliente }}" readonly>
    </div>
    <div class="w-full px-3 mb-6 md:w-1/3 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            RFC
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="atencion" type="text" name="txtatencion" value=" {{ $ordenRecoleccion->rfc }}" readonly>
    </div>
    <div class="w-full px-3 mb-6 md:w-1/3 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Correo electronico
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="atencion" type="text" name="txtatencion" value="{{ $ordenRecoleccion->correo }}" readonly>
    </div>
</div>
<div class="flex flex-wrap px-6 py-4 mt-5 -mx-3 whitespace-no-wrap border-b border-gray-200">
    <div class="w-full px-3 mb-6 md:w-1/2 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Direccion
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="nombre_cliente" type="text" name="txtnombre_cliente"
            value="{{ $ordenRecoleccion->municipio }}, {{ $ordenRecoleccion->estado }};
            Col.{{ $ordenRecoleccion->localidad }}; {{ $ordenRecoleccion->calle }}#{{ $ordenRecoleccion->num_exterior }}
            {{ $ordenRecoleccion->num_interior == null ? 'S/N' : '/ numero interior' . $ordenRecoleccion->num_interior }}"
            readonly>
    </div>
    <div class="w-full px-3 mb-6 md:w-1/2 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Fecha de recepción
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="atencion" type="text" name="txtatencion" value="{{ $ordenRecoleccion->fechaCreacion }}" readonly>
    </div>
    <div class="w-full px-3 mb-6 md:w-1/2 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Referencia
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="nombre_cliente" type="text" name="txtnombre_cliente"
            value="{{ $ordenRecoleccion->referencia == null ? 'S/D' : $ordenRecoleccion->referencia }}" readonly>
    </div>
    <div class="w-full px-3 mb-6 md:w-1/2 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Fecha de entrega
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="atencion" type="text" name="txtatencion"
            value="{{ $ordenRecoleccion->fechaEntrega ? $ordenRecoleccion->fechaEntrega : 'Por el momento no se ha entregado' }}"
            readonly>
    </div>
</div>

<div class="flex flex-wrap px-6 py-4 mt-5 -mx-3 whitespace-no-wrap border-b border-gray-200">
    <div class="w-full px-3 mb-6 md:w-1/4 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Requiere :
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="nombre_cliente" type="text" name="txtnombre_cliente"
            value="{{ $ordenRecoleccion->factura == 1 ? 'Factura' : 'Nota' }}" readonly>
    </div>
    <div class="w-full px-3 mb-6 md:w-1/4 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Costo total
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="atencion" type="text" name="txtatencion"
            value="@php $total = 0;
            foreach ($listaProductos as $producto) {
                $total += $producto->precio_unitario;} @endphp ${{ $total }}"
            readonly>
        <input type="hidden" name="total" value="{{ $total }}">
    </div>
    @if ($ordenRecoleccion->metodoPago == 'Efectivo')
        <div class="w-full px-3 mb-6 md:w-1/4 md:mb-0">
            <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
                Paga con
            </label>
            <input
                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                id="atencion" type="text" name="txtatencion" value=" ${{ $ordenRecoleccion->pagoEfectivo }}"
                readonly>
        </div>
        <div class="w-full px-3 mb-6 md:w-1/4 md:mb-0">
            <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
                Cambio
            </label>
            <input
                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                id="atencion" type="text" name="txtatencion"
                value="@php $cambio = number_format($ordenRecoleccion->pagoEfectivo - $total, 2); @endphp ${{ $cambio }}"
                readonly>
            <input type="hidden" name="total" value="{{ $cambio }}">
        </div>
    @else
        <div class="w-full px-3 mb-6 md:w-1/4 md:mb-0">
            <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
                Metodo de pago
            </label>
            <input
                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                id="atencion" type="text" name="txtatencion" value=" {{ $ordenRecoleccion->metodoPago }}"
                readonly>
        </div>
    @endif

</div>
<div class="flex flex-col mt-7">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Nombre Comercial
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Cantidad Total
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Descripción
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Precio unitario
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Descuento
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
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
                                    {{ $producto->cantidad ? $producto->cantidad : $producto->cantidadProducto }}
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
                                    @if ($producto->tipoDescuento == 'Porcentaje' || $producto->tipo_descuento == 'Porcentaje')
                                    Porcentaje
                                    @elseif ($producto->tipoDescuento == 'cantidad' || $producto->tipo_descuento == 'cantidad')
                                    Cantidad
                                    @elseif ($producto->tipoDescuento == 'Sin descuento' || $producto->tipo_descuento == 'Sin descuento')
                                    Sin descuento
                                    @endif
                                </td>
                                <td>
                                    {{ $producto->precio_unitario ? $producto->precio_unitario : $producto->precio }}
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
