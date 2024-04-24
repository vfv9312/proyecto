@extends('layouts.admin')

@section('title', 'Cancelaciones')

@section('content')
    <h1 class=" font-bold text-center mb-8">Lista de cancelaciones</h1>

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
                    <td class="py-3 px-6 text-left border-r">Nombre cliente</td>
                    <td class="py-3 px-6 text-left border-r">Fecha de la recepcion</td>
                    <td class="py-3 px-6 text-left border-r">Fecha de la cancelación</td>
                    <td class="py-3 px-6 text-left border-r">Direccion</td>
                    <td class="py-3 px-6 text-left border-r">Motivo de cancelacion</td>
                </tr>
                <!--foreach ($productos as $producto)-->
                @foreach ($datosEnvio as $dato)
                    <tr class= " border-b border-gray-200 text-sm">
                        <td class=" px-6 py-4">
                            {{ $dato->letraAcutal }}{{ sprintf('%06d', $dato->ultimoValor) }}</td>
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
                        <td class="px-6 py-4 flex justify-center items-center">
                            {{ $dato->categoriaCancelacion }}
                        </td>


                        <td>

                            <form method="POST"
                                action="{{ route('Restablecer.actualizarcancelacion', ['id' => $dato->idRecoleccion]) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    class="abrirModalEditar border rounded px-6 py-4 bg-green-500 text-white cursor-pointer hover:bg-green-700 transition duration-200 ease-in-out">
                                    <i class="fas fa-redo"></i>
                                </button>
                            </form>

                        </td>


                    </tr>
                    <!-- Aquí deberías mostrar otros datos del producto -->
                    <!--endforeach-->
                @endforeach
            </table>
            <div class=" mt-3">
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
