<!--tabla-->
<section class="overflow-x-auto">
    <!--La clase overflow-x-auto hace que el div tenga un desplazamiento horizontal si su contenido es demasiado ancho para caber en la pantalla-->
    <table class="min-w-full">
        <!--La clase min-w-full hace que la tabla tenga al menos el ancho completo de su contenedor, lo que significa que se desplazará horizontalmente si es necesario.-->
        <tr class="text-black uppercase text-xs  font-bold leading-normal">
            <td class="py-3 px-6 text-left border-r">Ticket</td>
            <td class="py-3 px-6 text-left border-r">Nombre del cliente</td>
            <td class="py-3 px-6 text-left border-r">Direccion de servicio</td>
            <td class="py-3 px-6 text-left border-r">Fecha del pedido</td>
            <td class="py-3 px-6 text-left border-r">Telefono del cliente</td>
            <td class="py-3 px-6 text-left border-r">Servicio/Entrega</td>
            <td class="py-3 px-6 text-left border-r">Estatus</td>
        </tr>
        @foreach ($preventas as $pendiente)
            <tr class= " border-b border-gray-200 text-sm">
                <td class="px-6 py-4">{{ $pendiente->idRecoleccion }}</td>
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
                    @if ($pendiente->estatusPreventa == 3)
                        <span>Entrega</span>
                    @elseif ($pendiente->estatusPreventa == 4)
                        <span class="">Servicio</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @if ($pendiente->estatus == 4)
                        <div style="height:33px;width:33px;background-color:red;border-radius:50%;"></div>
                        <span>Recoleccion</span>
                    @elseif ($pendiente->estatus == 3)
                        <div style="height:33px;width:33px;background-color:orange;border-radius:50%;"></div><span>En
                            revision</span>
                    @elseif ($pendiente->estatus == 2)
                        <div style="height:33px;width:33px;background-color:yellow;border-radius:50%;"></div>
                        <span>Entrega</span>
                    @endif
                </td>

                <td>
                    <form class="" action="{{ route('orden_recoleccion.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_recoleccion" value="{{ $pendiente->id_recoleccion }}">

                        <button type="submit"
                            class="border rounded px-6 py-4 bg-green-500 text-white cursor-pointer hover:bg-green-700 transition duration-200 ease-in-out">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </form>
                </td>
                <td>
                    <button
                        class="border rounded px-6 py-4 bg-blue-500 text-white cursor-pointer hover:bg-blue-700 transition duration-200 ease-in-out">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </td>
                <td>
                    <form action="{{ route('orden_recoleccion.vistacancelar', $pendiente->id_recoleccion) }}"
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
    {{ $preventas->links() }} <!-- Esto mostrará los enlaces de paginación -->
</section>
