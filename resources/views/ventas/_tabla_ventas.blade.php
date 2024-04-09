<main class="w-full h-3/4">
    <!-- mensaje de aviso que se registro el producto-->
    @if (session('correcto'))
        <div class=" flex justify-center">
            <div id="alert-correcto" class="bg-green-500 bg-opacity-50 text-white px-4 py-2 rounded mb-8 w-64 ">
                {{ session('correcto') }}
            </div>
        </div>
    @endif
    @if (session('incorrect'))
        <div id="alert-incorrect" class="bg-red-500 text-white px-4 py-2 rounded">
            {{ session('incorrect') }}
        </div>
    @endif

    <!--tabla-->
    <section class="overflow-x-auto">
        <!--La clase overflow-x-auto hace que el div tenga un desplazamiento horizontal si su contenido es demasiado ancho para caber en la pantalla-->
        <table class="min-w-full">
            <!--La clase min-w-full hace que la tabla tenga al menos el ancho completo de su contenedor, lo que significa que se desplazará horizontalmente si es necesario.-->
            <tr class="text-black uppercase text-xs  font-bold leading-normal">
                <td class="py-3 px-6 text-left border-r">Folio</td>
                <td class="py-3 px-6 text-left border-r">Cliente</td>
                <td class="py-3 px-6 text-left border-r">Fecha de la venta</td>
                <td class="py-3 px-6 text-left border-r">Direccion</td>
                <td class="py-3 px-6 text-left border-r">Costo total</td>
            </tr>
            <!--foreach ($productos as $producto)-->
            @foreach ($datosVentas as $datosVenta)
                <tr class= " border-b border-gray-200 text-sm">

                    <td class="px-6 py-4">{{ $datosVenta->letraActual }}{{ sprintf('%06d', $datosVenta->ultimoValor) }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $datosVenta->nombreCliente }} {{ $datosVenta->apellidoCliente }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $datosVenta->fechaVenta }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $datosVenta->colonia }}; {{ $datosVenta->calle }} #{{ $datosVenta->num_exterior }}
                        {{ $datosVenta->num_interior }} - referencia : {{ $datosVenta->referencia }}
                    </td>
                    <td class="px-6 py-4 flex justify-center items-center">
                        @php $total = 0; @endphp
                        @foreach ($datosVenta->productos as $producto)
                            @php $total += $producto->cantidad * $producto->precio; @endphp
                        @endforeach
                        ${{ $datosVenta->costo_servicio ? $datosVenta->costo_servicio : $total }}
                    </td>

                    <td>
                        <a href="{{ route('ventas.show', $datosVenta->idVenta) }}" target="_blank"
                            class="border rounded px-6 py-4 bg-blue-500 text-white cursor-pointer hover:bg-blue-700 transition duration-200 ease-in-out">
                            <i class="fas fa-file-pdf"></i>

                        </a>
                    </td>
                    <td>
                        <a href='{{ route('WhatsApp.enviar', ['id' => $datosVenta->idRecoleccion]) }}' target="_blank"
                            class="tems-center px-6 py-4 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </td>
                    <td>
                        <a href='{{ route('Correo.enviar', ['id' => $datosVenta->idRecoleccion]) }}' target="_blank"
                            class=" items-center px-6 py-4 bg-purple-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </td>

                </tr>
                <!-- Aquí deberías mostrar otros datos del producto -->
                <!--endforeach-->
            @endforeach
        </table>
        <div class=" mt-3">
            <p>Total de resultados: {{ $datosVentas->total() }}</p> <!--mostrar total de resultados-->
            {{ $datosVentas->links() }} <!-- Esto mostrará los enlaces de paginación -->
        </div>
    </section>
</main>
