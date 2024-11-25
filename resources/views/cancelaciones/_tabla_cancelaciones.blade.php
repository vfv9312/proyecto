<main class="w-full h-3/4">
    <!-- mensaje de aviso que se registro el producto-->
    @if (session('correcto'))
        <div class="flex justify-center ">
            <div id="alert-correcto" class="w-64 px-4 py-2 mb-8 text-white bg-green-500 bg-opacity-50 rounded ">
                {{ session('correcto') }}
            </div>
        </div>
    @endif
    @if (session('incorrect'))
        <div id="alert-incorrect" class="px-4 py-2 text-white bg-red-500 rounded">
            {{ session('incorrect') }}
        </div>
    @endif

    <!--tabla-->
    <section class="overflow-x-auto">
        <!--La clase overflow-x-auto hace que el div tenga un desplazamiento horizontal si su contenido es demasiado ancho para caber en la pantalla-->
        <table class="min-w-full">
            <!--La clase min-w-full hace que la tabla tenga al menos el ancho completo de su contenedor, lo que significa que se desplazará horizontalmente si es necesario.-->
            <tr class="text-xs font-bold leading-normal text-black uppercase">
                <td class="px-6 py-3 text-left border-r">Folio</td>
                <td class="px-6 py-3 text-left border-r">Nombre cliente</td>
                <td class="px-6 py-3 text-left border-r">Fecha de la recepcion</td>
                <td class="px-6 py-3 text-left border-r">Fecha de la cancelación</td>
                <td class="px-6 py-3 text-left border-r">Direccion</td>
                <td class="px-6 py-3 text-left border-r">Motivo de cancelacion</td>
            </tr>
            <!--foreach ($productos as $producto)-->
            @foreach ($preventas as $dato)
                <tr class= "text-sm border-b border-gray-200 ">
                    @if ($dato->tipoVenta === 'Entrega')
                        <td class="px-6 py-4">
                            {{ $dato->letraActual }}{{ sprintf('%06d', $dato->ultimoValor) }}
                        </td>
                    @else
                        <td class="px-6 py-4">{{ sprintf('%06d', $dato->ultimoValorServicio) }}
                        </td>
                    @endif
                    <td class="px-6 py-4">
                        {{ $dato->nombreCliente }} {{ $dato->apellidoCliente }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $dato->fechaCreacion }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $dato->fechaEliminacion }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $dato->colonia }}; {{ $dato->calle }} #{{ $dato->num_exterior }}
                        {{ $dato->num_interior }} - referencia : {{ $dato->referencia }}
                    </td>
                    <td class="flex items-center justify-center px-6 py-4">
                        {{ $dato->categoriaCancelacion }}
                    </td>


                    <td>
                        @switch($dato->tipoVenta)
                            @case('Entrega')
                                <button onclick="location.href='{{ route('generarpdf.ordenentrega', $dato->idRecoleccion) }}'"
                                    class="px-6 py-4 text-white transition duration-200 ease-in-out bg-blue-500 border rounded cursor-pointer hover:bg-blue-700">
                                    <i class="fas fa-file-pdf"></i>
                                </button>
                            @break

                            @case('Servicio')
                                <button onclick="location.href='{{ route('generarpdf.ordenservicio', $dato->idRecoleccion) }}'"
                                    class="px-6 py-4 text-white transition duration-200 ease-in-out bg-blue-500 border rounded cursor-pointer hover:bg-blue-700">
                                    <i class="fas fa-file-pdf"></i>
                                </button>
                            @break

                            @default
                        @endswitch


                    </td>


                </tr>
                <!-- Aquí deberías mostrar otros datos del producto -->
                <!--endforeach-->
            @endforeach
        </table>
        <div class="mt-3 ">
            <p>Total de resultados: {{ $preventas->total() }}</p> <!--mostrar total de resultados-->
            {{ $preventas->links() }} <!-- Esto mostrará los enlaces de paginación -->
        </div>
    </section>
</main>
