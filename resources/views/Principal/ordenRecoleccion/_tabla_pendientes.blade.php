<h1 class=" text-center mb-5">Ultimos ordenes de servicio</h1>
<!--tabla-->
<section class="overflow-x-auto">
    <!--La clase overflow-x-auto hace que el div tenga un desplazamiento horizontal si su contenido es demasiado ancho para caber en la pantalla-->
    <table class="min-w-full">
        <!--La clase min-w-full hace que la tabla tenga al menos el ancho completo de su contenedor, lo que significa que se desplazará horizontalmente si es necesario.-->
        <tr class="text-black uppercase text-xs  font-bold leading-normal">
            <td class="py-3 px-6 text-left border-r">Nombre del cliente</td>
            <td class="py-3 px-6 text-left border-r">Direccion de servicio</td>
            <td class="py-3 px-6 text-left border-r">Fecha de envio</td>
            <td class="py-3 px-6 text-left border-r">Fecha de recoleccion</td>
            <td class="py-3 px-6 text-left border-r">Costo total</td>
            <td class="py-3 px-6 text-left border-r">Estatus</td>
        </tr>
        @foreach ($preventas as $pendiente)
            <tr class= " border-b border-gray-200 text-sm">
                <td class="px-6 py-4">
                    {{ $pendiente->nombreCliente }} {{ $pendiente->apellidoCliente }}
                </td>
                <td class=" px-6 py-4">
                    {{ $pendiente->nombreCliente }}
                </td>
                <td class="px-6 py-4">

                </td>
                <td class="px-6 py-4">

                </td>
                <td class="px-6 py-4">

                </td>
                <td class="px-6 py-4">
                    @if ($pendiente->estatus == 2)
                        Se va a recolectar para revision
                    @elseif ($pendiente->estatus == 3)
                        Se va a entregar para finalizar compra
                    @endif
                </td>
                <td>
                    <button
                        class=" border rounded px-6 py-4 bg-green-500 text-white cursor-pointer hover:bg-green-700 transition duration-200 ease-in-out">
                        <i class="fas fa-edit"></i>
                    </button>
                </td>
                <td>
                    <button
                        class="border rounded px-6 py-4 bg-blue-500 text-white cursor-pointer hover:bg-blue-700 transition duration-200 ease-in-out">
                        <i class="fas fa-eye"></i></button>
                </td>
                <td>
                    <button
                        class="border rounded px-6 py-4 bg-red-500 text-white cursor-pointer hover:bg-red-700 transition duration-200 ease-in-out">
                        <i class="fas fa-times-circle"></i></button>
                </td>

            </tr>
        @endforeach
        <!-- Aquí deberías mostrar otros datos del producto -->

    </table>
</section>
