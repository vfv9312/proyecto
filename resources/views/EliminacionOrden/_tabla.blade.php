<!--tabla-->
<section class="overflow-x-auto">
    <!--La clase overflow-x-auto hace que el div tenga un desplazamiento horizontal si su contenido es demasiado ancho para caber en la pantalla-->
    <table class="min-w-full">
        <!--La clase min-w-full hace que la tabla tenga al menos el ancho completo de su contenedor, lo que significa que se desplazará horizontalmente si es necesario.-->
        <tr class="text-black uppercase text-xs  font-bold leading-normal">
            <td class="py-3 px-6 text-left border-r">Folio</td>
            <td class="py-3 px-6 text-left border-r">Nombre del cliente</td>
            <td class="py-3 px-6 text-left border-r">Direccion de servicio</td>
            <td class="py-3 px-6 text-left border-r">Fecha y hora del pedido</td>
            <td class="py-3 px-6 text-left border-r">Telefono del cliente</td>
            <td class="py-3 px-6 text-left border-r">Hora de entrega compromiso</td>
            <td class="py-3 px-6 text-left border-r">Servicio/Entrega</td>
            <td class="py-3 px-6 text-left border-r">Estatus</td>
        </tr>
        @foreach ($preventas as $index => $pendiente)
            @php
                $index++;
            @endphp
            <tr class= " border-b border-gray-200 text-sm">
                @if ($pendiente->tipoVenta === 'Entrega')
                    <td class="px-6 py-4">{{ $pendiente->letraActual }}{{ sprintf('%06d', $pendiente->ultimoValor) }}
                    </td>
                @else
                    <td class="px-6 py-4">{{ sprintf('%06d', $pendiente->ultimoValorServicio) }}</td>
                @endif

                <td class="px-6 py-4">
                    {{ $pendiente->nombreCliente }} {{ $pendiente->apellidoCliente }}
                </td>
                <td class=" px-6 py-4">
                    {{ $pendiente->colonia }}; {{ $pendiente->calle }}, #{{ $pendiente->num_exterior }}
                    {{ $pendiente->num_interior }} - {{ $pendiente->referencia }}
                </td>
                <td class="px-6 py-4">
                    {{ $pendiente->created_at }}
                </td>
                <td class="px-6 py-4">
                    {{ $pendiente->telefono }}
                </td>
                <td class="px-6 py-4">
                    {{ $datosEntregaCompromisos[$index]['horaEntregaCompromiso'] ? $datosEntregaCompromisos[$index]['horaEntregaCompromiso'] : 'No hay tiempo aproximado' }}
                </td>
                <td class="px-6 py-4">
                    @switch($pendiente->tipoVenta)
                        @case('Entrega')
                            <span>Entrega</span>
                        @break

                        @case('Servicio')
                            <span class="">Servicio</span>
                        @break

                        @default
                    @endswitch

                </td>
                <td class="px-6 py-4">
                    @if ($pendiente->id_cancelacion)
                        <div style="height:33px;width:33px;background-color:red;border-radius:50%;"></div>
                        <span>Cancelado</span>
                    @else
                        @switch($pendiente->estatusPreventa)
                            @case('Recolectar')
                                <div style="height:33px;width:33px;background-color:orange;border-radius:50%;"></div>
                                <span>Recoleccion</span>
                            @break

                            @case('Revision')
                                <div style="height:33px;width:33px;background-color:rgb(219, 114, 9);border-radius:50%;">
                                </div><span>En
                                    revision</span>
                            @break

                            @case('Entrega')
                                <div style="height:33px;width:33px;background-color:yellow;border-radius:50%;"></div>
                                <span>Entrega</span>
                            @break

                            @case('Listo')
                                <div style="height:33px;width:33px;background-color:green;border-radius:50%;"></div>
                                <span>Orden Procesada</span>
                            @break

                            @default
                        @endswitch
                    @endif
                </td>
                <td>
                    <div class="flex items-center me-4">
                        <input id="{{ $pendiente->idPreventa }}" type="checkbox" value=""
                            class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 seleccionador">
                        <label for="red-checkbox"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Eliminacion</label>
                    </div>
                </td>

            </tr>
        @endforeach

    </table>
    <p>Total de resultados: {{ $preventas->total() }}</p>
    {{ $preventas->links() }} <!-- Esto mostrará los enlaces de paginación -->
</section>
