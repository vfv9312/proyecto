@extends('layouts.admin')

@section('title', 'Cancelaciones')

@section('content')
    <h1 class="mb-8 font-bold text-center ">Lista de cancelaciones</h1>

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
                @foreach ($datosEnvio as $dato)
        @php
                switch ($dato->tipoVenta) {
                case 'Entrega':
                    $idPreventa = $dato->idPreventa;
                    $folio = $dato->letraActual . sprintf('%06d', $dato->ultimoValor);
                    break;

                case 'Orden Servicio':
                    $idPreventa = $dato->idPreventaOrdenServicio;
                    $folio = sprintf('%06d', $dato->ultimoValorServicio);
                    break;

                case 'Servicio':
                    $idPreventa = $dato->idPreventaServicio;
                    $folio = $dato->letraActual_r . sprintf('%06d', $dato->ultimoValor_r);
                    break;

                default:
                    // Puedes agregar un valor predeterminado si lo deseas
                    $idPreventa = null;
                    break;
                 }
        @endphp
                    <tr class= "text-sm border-b border-gray-200 ">
                        <td class="px-6 py-4 ">
                           {{$folio}}
                        </td>
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

                            <form method="POST"
                                action="{{ route('Restablecer.actualizarcancelacion', ['id' => $idPreventa]) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    class="px-6 py-4 text-white transition duration-200 ease-in-out bg-green-500 border rounded cursor-pointer abrirModalEditar hover:bg-green-700">
                                    <i class="fas fa-redo"></i>
                                </button>
                            </form>

                        </td>


                    </tr>
                    <!-- Aquí deberías mostrar otros datos del producto -->
                    <!--endforeach-->
                @endforeach
            </table>
            <div class="mt-3 ">
                <p>Total de resultados: {{ $datosEnvio->total() }}</p> <!--mostrar total de resultados-->
                {{ $datosEnvio->links() }} <!-- Esto mostrará los enlaces de paginación -->
            </div>
        </section>
    </main>

@endsection

@push('css')
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
@endpush

@push('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@endpush
