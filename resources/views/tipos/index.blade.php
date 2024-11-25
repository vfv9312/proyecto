@extends('layouts.admin')

@section('title', 'Tipos de productos')

@section('content')
    <h1 class="text-center ">Tipos de productos</h1>

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
        @include('tipos._filtros')
        <!-- boton anadir producto-->
        <button id="abrirnModalRegisrarTipoProducto"
            class="flex items-center px-4 py-2 mb-4 font-bold text-white rounded-full bg-gradient-to-r from-gray-800 via-gray-600 to-green-500">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive-fill" viewBox="0 0 16 16">
                <path d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1M.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8z"/>
              </svg>
            Añadir Tipo de producto
        </button>

@include('tipos._agregar')
        <section class="overflow-x-auto">
            <table class="min-w-full">
                <!--La clase min-w-full hace que la tabla tenga al menos el ancho completo de su contenedor, lo que significa que se desplazará horizontalmente si es necesario.-->
                <tr class="text-xs font-bold leading-normal text-black uppercase">
                    <td class="px-6 py-3 text-left border-r">Tipo de producto</td>
                    <td class="px-6 py-3 text-left border-r">Fecha de registro</td>
                </tr>

                <!--La clase min-w-full hace que la tabla tenga al menos el ancho completo de su contenedor, lo que significa que se desplazará horizontalmente si es necesario.-->

                @foreach ($tiposProductos as $tipo)
                    <tr class= "text-sm border-b border-gray-200 ">
                        <td class="px-6 py-4 ">
                            {{ $tipo->nombre }}</td>
                        <td class="px-6 py-4">
                            {{ $tipo->created_at }}
                        </td>

                        <!--Formulario para enviar a editar el select de la direccion-->
                        <td>
                            <form method="GET" action="{{ route('tipos.edit', $tipo->id) }}">

                                <!-- Botón para editar colonia -->
                                <button
                                    class="py-2 text-white transition duration-200 ease-in-out bg-green-500 border rounded cursor-pointer lg:px-4 lg:py-4 md:px-6 md:py-2 px-7 hover:bg-green-700"
                                    title="Editar tipos">
                                    <i class="fas fa-redo"></i>
                                </button>
                            </form>

                        </td>
                        <td>
                            <!--Eliminar colonia-->
                            <form method="POST" action="{{ route('tipos.destroy', $tipo->id) }}"
                                onsubmit="return confirm('¿Estás seguro de que lo quieres eliminar?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-6 py-4 text-white transition duration-200 ease-in-out bg-red-500 border rounded cursor-pointer hover:bg-red-700"
                                    title="Eliminar tipo">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                    <!-- Aquí deberías mostrar otros datos del producto -->
                @endforeach
            </table>
            <div class="mt-3 ">
                <p>Total de resultados: {{ $tiposProductos->total() }}</p>
                {{ $tiposProductos->links() }} <!-- Esto mostrará los enlaces de paginación -->
            </div>
    </main>
@endsection

@push('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Incluye jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Incluye Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Incluye Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endpush

@push('js')
    <script>
        //Oculta los elementos de alerta despues de 3 segundos
        window.setTimeout(function() {
            var alertCorrecto = document.getElementById('alert-correcto');
            var alertIncorrect = document.getElementById('alert-incorrect');
            if (alertCorrecto) alertCorrecto.style.display = 'none';
            if (alertIncorrect) alertIncorrect.style.display = 'none';
        }, 3000);

        // Obtén los elementos del DOM
        const modalRegistrarTipoProducto = document.querySelector('#modalRegistrarTipoProducto')
        const abrirnModalRegisrarTipoProducto = document.querySelector('#abrirnModalRegisrarTipoProducto');

        const cancelarModal = document.querySelector('.cerrarmodal');

        //Abre el modal para registrar un producto
        abrirnModalRegisrarTipoProducto.addEventListener('click', function() {
            modalRegistrarTipoProducto.classList.remove('hidden');
        });

        // Escucha el evento de click en el botón cancelar Modal de registro
        cancelarModal.addEventListener('click', function() {
            // Oculta el modal
            modalRegistrarTipoProducto.classList.add('hidden');
        });
        //con esto buscamos rapido con lo que escribimos en el select lo que necesitamos
        $(document).ready(function() {
            $('#coloniaSelect').select2();
        });


    </script>
@endpush
