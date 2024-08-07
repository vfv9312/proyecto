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
                <td class="px-6 py-4">
                    {{ $pendiente->letraActual ? $pendiente->letraActual : '' }}{{ $pendiente->ultimoValor ? sprintf('%06d', $pendiente->ultimoValor) : sprintf('%06d', $pendiente->ultimoValorServicio) }}
                </td>
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
                    @if ($pendiente->estatusPreventa == 3)
                        <span>Entrega</span>
                    @elseif ($pendiente->estatusPreventa == 4)
                        <span class="">Servicio</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @if (in_array($pendiente->estatus, [1, 2, 3, 4]) && $pendiente->id_cancelacion !== null)
                        <div style="height:33px;width:33px;background-color:red;border-radius:50%;"></div>
                        <span>Cancelado</span>
                    @elseif ($pendiente->estatus == 4)
                        <div style="height:33px;width:33px;background-color:orange;border-radius:50%;"></div>
                        <span>Recoleccion</span>
                    @elseif ($pendiente->estatus == 3)
                        <div style="height:33px;width:33px;background-color:rgb(219, 114, 9);border-radius:50%;">
                        </div><span>En
                            revision</span>
                    @elseif ($pendiente->estatus == 2)
                        <div style="height:33px;width:33px;background-color:yellow;border-radius:50%;"></div>
                        <span>Entrega</span>
                    @elseif ($pendiente->estatus == 1)
                        <div style="height:33px;width:33px;background-color:green;border-radius:50%;"></div>
                        <span>Orden Procesada</span>
                    @endif
                </td>

                <td>
                    <form class="" action="{{ route('orden_recoleccion.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_recoleccion" value="{{ $pendiente->idRecoleccion }}">

                        <button type="submit"
                            class="border rounded px-6 py-4 bg-green-500 text-white cursor-pointer hover:bg-green-700 transition duration-200 ease-in-out">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </form>
                </td>
                <td>
                    <a @if ($pendiente->estatusPreventa == 3) href="{{ route('orden_recoleccion.vistaPreviaOrdenEntrega', $pendiente->idPreventa) }}"
                    @elseif ($pendiente->estatusPreventa == 4)
                    href="{{ route('ordenServicio.vistaGeneral', $pendiente->idRecoleccion) }}" @endif
                        class="border rounded px-6 py-4 bg-blue-500 text-white cursor-pointer hover:bg-blue-700 transition duration-200 ease-in-out block">
                        <i class="fas fa-eye"></i>
                    </a>

                </td>
                <td>
                    <form action="{{ route('orden_recoleccion.vistacancelar', $pendiente->idRecoleccion) }}"
                        method="GET">
                        @csrf
                        <button
                            class="border rounded px-6 py-4 bg-red-500 text-white cursor-pointer hover:bg-red-700 transition duration-200 ease-in-out">
                            <i class="fas fa-ban"></i></button>
                    </form>
                </td>

            </tr>
        @endforeach

    </table>
    <p>Total de resultados: {{ $preventas->total() }}</p>
    {{ $preventas->links() }} <!-- Esto mostrará los enlaces de paginación -->
</section>
