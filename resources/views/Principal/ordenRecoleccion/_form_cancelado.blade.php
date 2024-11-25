<div class="flex flex-wrap mt-16 -mx-3 whitespace-no-wrap border-b border-gray-200">
    <div class="w-full px-3 mb-6 md:w-1/4 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Nombre del Cliente
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="nombre_cliente" type="text" name="txtnombre_cliente"
            value="{{ $datosEnvio->nombreCliente }} {{ $datosEnvio->apellidoCliente }}" readonly>
    </div>
    <div class="w-full px-3 mb-6 md:w-1/4 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Atención
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="atencion" type="text" name="txtatencion" value="{{ $datosEnvio->nombreAtencion }}" readonly>
    </div>
    <div class="w-full px-3 mb-6 md:w-1/4 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Recibe
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="recibe" type="text" name="txtrecibe" value="{{ $datosEnvio->nombreRecibe }}" readonly>
    </div>
    <div class="w-full px-3 mb-6 md:w-1/4 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Recepcionó
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="recepciono" type="text" name="txtrecepciono" value="{{ $datosEnvio->nombreEmpleado }}" readonly>
    </div>
</div>


<div class="w-full px-3 mb-6 whitespace-no-wrap border-b border-gray-200 md:w-full md:mb-0 md:mt-10">
    <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
        Dirección a entregar
    </label>
    <input
        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
        id="direccion" type="text" name="txtdireccion"
        value="Col.{{ $datosEnvio->colonia }}; {{ $datosEnvio->calle }} #{{ $datosEnvio->num_exterior }} - numero interio {{ $datosEnvio->num_interior }} - Referencia {{ $datosEnvio->referencia }}"
        readonly>
</div>
<div class="flex flex-wrap mt-16 -mx-3 whitespace-no-wrap border-b border-gray-200">
    <div class="w-full px-3 mb-6 md:w-1/3 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Telefono del cliente
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="telefono" type="text" name="txttelefono" value="{{ $datosEnvio->telefonoCliente }}" readonly>
    </div>
    <div class="w-full px-3 mb-6 md:w-1/3 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            RFC
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="rfc" type="text" name="txtrfc" value="{{ $datosEnvio->rfc }}" readonly>
    </div>
    <div class="w-full px-3 mb-6 md:w-1/3 md:mb-0 ">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Correo electronico
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="email" type="text" name="txtemail" value="{{ $datosEnvio->emailCliente }}" readonly>
    </div>

</div>
<div class="flex flex-wrap mt-16 -mx-3 whitespace-no-wrap border-b border-gray-200">
    <div class="w-full px-3 mb-6 md:w-1/3 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Fecha del pedido
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="fecha" type="text" name="txtfecha" value="{{ $datosEnvio->created_at }}" readonly>
    </div>
    <div class="w-full px-3 mb-6 md:w-1/3 md:mb-0 ">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Fecha de recoleccion
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="precio" type="text" name="txtprecio"
            @if ($datosEnvio->estatusPreventa === 'Recolectar') @if ($datosEnvio->fechaRecoleccion == null)
value="hasta el momento no ha sido recolectado"
@else
value="{{ $datosEnvio->fechaRecoleccion }}" @endif
        @elseif($datosEnvio->estatusPreventa === 'Entrega') value="Solo es un pedido para envio" @endif >
    </div>
    <div class="w-full px-3 mb-6 md:w-1/3 md:mb-0">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
            Fecha para entrega
        </label>
        <input
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="fecha" type="text" name="txtfecha"
            @if ($datosEnvio->estatusPreventa === 'Recolectar') value="hasta el momento no ha sido recolectado"
            @elseif($datosEnvio->estatusPreventa == 'Revision') value="En revision"
            @elseif($datosEnvio->estatusPreventa == 'Entrega') value="Por entregar"
            @elseif($datosEnvio->estatusPreventa == 'Listo') value="{{ $datosEnvio->fechaEntrega }}" @endif
            readonly>
    </div>
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
                                Precio Unitario</th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Descuento</th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Costo</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($productos as $producto)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $producto->nombre_comercial }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $producto->cantidad ? $producto->cantidad : $producto->cantidadProducto }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $producto->nombreMarca ? 'Marca : ' . $producto->nombreMarca : '' }}
                                    {{ $producto->nombreTipo ? 'Categoria : ' . $producto->nombreTipo : '' }}
                                    {{ $producto->nombreColor ? 'Color : ' . $producto->nombreColor : '' }}
                                    {{ $producto->nombreModo ? 'Tipo :' . $producto->nombreModo : '' }}
                                    {{ $producto->descripcion ? 'Descripcion :' . $producto->descripcion : $producto->descipcion}}
                                </td>
                                <td>
                                    ${{ $producto->precio }}
                                </td>
                                <td>
                                    @switch($producto->tipoDescuento)
                                        @case('Porcentaje')
                                            {{ intval($producto->descuento) }}%
                                        @break

                                        @case('cantidad')
                                            ${{ $producto->descuento }}
                                        @break

                                        @case('alternativo')
                                            ${{ ($producto->precio - $producto->descuento) * $producto->cantidad }}
                                        @break

                                        @case('Sin descuento')
                                            {{ $producto->tipoDescuento ? $producto->tipoDescuento : ''}}
                                        @break

                                        @default
                                        @if ($producto->tipo_descuento === 'Sin descuento')
                                            {{$producto->tipo_descuento}}
                                        @endif
                                    @endswitch




                                    {{-- <input type="number" name="costo_unitario[{{ $producto->id }}]"
                                        data-cantidad="{{ $producto->cantidad }}" step="0.01"
                                        class="block w-full mt-1 form-input" placeholder="Costo unitario"
                                        value="{{ $producto->precio_unitario * $producto->cantidad }}" readonly> --}}
                                </td>
                                <td>
                                    @switch($producto->tipoDescuento)
                                        @case('Porcentaje')
                                            ${{ $producto->precio * $producto->cantidad - ($producto->precio * $producto->cantidad * intval($producto->descuento)) / 100 }}
                                        @break

                                        @case('cantidad')
                                            ${{ $producto->precio * $producto->cantidad - $producto->descuento * $producto->cantidad }}
                                        @break

                                        @case('alternativo')
                                            ${{ $producto->descuento * $producto->cantidad }}
                                        @break

                                        @case('Sin descuento')
                                            ${{ $producto->precio * $producto->cantidad }}
                                        @break

                                        @default
                                        @if ($producto->tipo_descuento === 'Sin descuento')
                                        ${{ $producto->precio * $producto->cantidad }}
                                        @endif
                                    @endswitch

                                    {{-- @if ($producto->porcentaje === null)
                                    <td>
                                        Sin descuento
                                    </td>
                                @else
                                    <td>
                                        {{ $producto->porcentaje }}%
                                    </td>
                                @endif --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="flex flex-col items-center mt-3">


        <div class="flex flex-col items-center mt-3">
            <div class="flex flex-col items-center">
                <label for="miSelect">Estatus:</label>
                @switch($datosEnvio->estatusPreventa)
                    @case('Recolectar')
                        <span class="font-bold ">En recoleccion</span>
                    @break

                    @case('Revision')
                        <span class="font-bold ">En revision</span>
                    @break

                    @case('Entrega')
                        <span class="font-bold ">En entrega</span>
                    @break

                    @case('Listo')
                        <span class="font-bold ">Orden Procesada</span>
                    @break

                    @default
                @endswitch
            </div>
        </div>
        @if ($datosEnvio->id_cancelacion == null)
            <div class="flex flex-col w-full">
                <label class="" for="motivoCancelacion">Porque se cancela:</label>
                <select name="txtcategoriaCancelacion" id="categoriaCancelacion"
                    class="w-1/3 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                    <option value="">Selecciona un motivo</option>
                    @foreach ($cancelar as $cancelacion)
                        <option value="{{ $cancelacion->id }}">{{ $cancelacion->nombre }}</option>
                    @endforeach
                </select>
            </div>


            <div class="flex flex-col w-full">
                <label class="" for="miSelect">Porque se cancela:</label>
                <textarea
                    class="w-full h-32 px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="cancelado" name="txtcancelado" maxlength="255"></textarea>
            </div>


            <button type="submit"
                class="flex items-center px-4 py-2 mt-8 text-white bg-red-500 rounded hover:bg-red-700">
                <i class="mr-2 fas fa-sync-alt"></i>
                Cancelar
            </button>
        @endif
