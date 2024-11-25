<!--tabla-->
<section class="overflow-x-auto">
    <!--La clase overflow-x-auto hace que el div tenga un desplazamiento horizontal si su contenido es demasiado ancho para caber en la pantalla-->
    <table class="min-w-full">
        <!--La clase min-w-full hace que la tabla tenga al menos el ancho completo de su contenedor, lo que significa que se desplazará horizontalmente si es necesario.-->
        <tr class="text-xs font-bold leading-normal text-black uppercase">
            <td class="px-6 py-3 text-left border-r">Folio</td>
            <td class="px-6 py-3 text-left border-r">Nombre del cliente</td>
            <td class="px-6 py-3 text-left border-r">Direccion de servicio</td>
            <td class="px-6 py-3 text-left border-r">Fecha y hora del pedido</td>
            <td class="px-6 py-3 text-left border-r">Telefono del cliente</td>
            <td class="px-6 py-3 text-left border-r">Hora de entrega compromiso</td>
            <td class="px-6 py-3 text-left border-r">Servicio/Entrega</td>
            <td class="px-6 py-3 text-left border-r">Estatus</td>
        </tr>
        @foreach ($preventas as $index => $pendiente)
            @php
                $index++;
            @endphp
            <tr class= "text-sm border-b border-gray-200 ">
                <td class="px-6 py-4">
                    @switch($pendiente->tipoVenta)
                        @case('Entrega')
                            {{$pendiente->letraActual . sprintf('%06d', $pendiente->ultimoValor)}}
                        @break
                        @case('Servicio')
                            {{$pendiente->letraActual_r . sprintf('%06d', $pendiente->ultimoValor_r)}}
                        @break
                        @case('Orden Servicio')
                            {{sprintf('%06d', $pendiente->ultimoValorServicio)}}
                        @break

                        @default

                    @endswitch
                </td>
                <td class="px-6 py-4">
                    {{ $pendiente->nombreCliente }} {{ $pendiente->apellidoCliente }}
                </td>
                <td class="px-6 py-4 ">
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
                    @if ($pendiente->tipoVenta === 'Entrega')
                        <span>Entrega</span>
                    @elseif ($pendiente->tipoVenta === 'Servicio')
                        <span class="">Recoleccion</span>
                    @elseif ($pendiente->tipoVenta === 'Orden Servicio')
                    <span class="">Orden Servicio</span>
                    @endif
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

                            @case('Revisar')
                                <div style="height:33px;width:33px;background-color:rgb(201, 198, 65);border-radius:50%;"></div>
                                <span>En revision</span>
                            @break

                            @default
                        @endswitch
                    @endif

                </td>

                @if ($pendiente->estatusPreventa != "Listo")
                @if (empty($pendiente->id_cancelacion))


                <td>
                    <form class="" action="{{ route('orden_recoleccion.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_recoleccion" value="{{ $pendiente->idPreventa }}">

                        <button type="submit"
                            class="px-6 py-4 text-white transition duration-200 ease-in-out bg-green-500 border rounded cursor-pointer hover:bg-green-700">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </form>
                </td>
                @endif
                @endif
                <td>
                    <a @if ($pendiente->tipoVenta === 'Entrega') href="{{ route('ordenEntrega.vistaGeneral', $pendiente->idPreventa) }}"
                    @elseif ($pendiente->tipoVenta === 'Servicio')
                    href="{{ route('ordenServicio.vistaGeneral', $pendiente->idPreventa) }}"
                    @elseif ($pendiente->tipoVenta === 'Orden Servicio')
                    href="{{ route('ordenServicio.vistaGeneralOrdenServicio', $pendiente->idPreventa) }}"
                    @endif
                        class="block px-6 py-4 text-white transition duration-200 ease-in-out bg-blue-500 border rounded cursor-pointer hover:bg-blue-700">
                        <i class="fas fa-eye"></i>
                    </a>

                </td>
                @if ($pendiente->estatusPreventa != "Listo")
                @if (empty($pendiente->id_cancelacion))
                <td>
                    <form action="{{ route('orden_recoleccion.vistacancelar', $pendiente->idPreventa) }}"
                        method="GET">
                        @csrf
                        <button
                            class="px-6 py-4 text-white transition duration-200 ease-in-out bg-red-500 border rounded cursor-pointer hover:bg-red-700">
                            <i class="fas fa-ban"></i></button>
                    </form>
                </td>
                @endif
                @endif


            </tr>
        @endforeach

    </table>
    <p>Total de resultados: {{ $preventas->total() }}</p>
    {{ $preventas->links() }} <!-- Esto mostrará los enlaces de paginación -->
</section>
