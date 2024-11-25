@extends('layouts.admin')

@section('title', 'Colonias')

@section('content')
    <h1 class="text-center ">Colonias</h1>

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
        @include('colonias._filtros')
        <!-- boton anadir producto-->
        <button id="abrirnModalRegisrarColonias"
            class="flex items-center px-4 py-2 mb-4 font-bold text-white rounded-full bg-gradient-to-r from-gray-800 via-gray-600 to-green-500">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
              </svg>
            Añadir colonia
        </button>

@include('colonias._agregar')
        <section class="overflow-x-auto">
            <table class="min-w-full">
                <!--La clase min-w-full hace que la tabla tenga al menos el ancho completo de su contenedor, lo que significa que se desplazará horizontalmente si es necesario.-->
                <tr class="text-xs font-bold leading-normal text-black uppercase">
                    <td class="px-6 py-3 text-left border-r">Colonia</td>
                    <td class="px-6 py-3 text-left border-r">Municipio</td>
                    <td class="px-6 py-3 text-left border-r">Estado</td>
                    <td class="px-6 py-3 text-left border-r">Codigo postal</td>
                    <td class="px-6 py-3 text-left border-r">Fecha de registro</td>
                </tr>

                <!--La clase min-w-full hace que la tabla tenga al menos el ancho completo de su contenedor, lo que significa que se desplazará horizontalmente si es necesario.-->

                @foreach ($coloniasTuxtla as $colonia)
                    <tr class= "text-sm border-b border-gray-200 ">
                        <td class="px-6 py-4 ">
                            {{ $colonia->localidad }}</td>
                        <td class="px-6 py-4">
                            {{ $colonia->municipio }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $colonia->estado }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $colonia->cp }}
                        </td>
                        <td class="px-6 py-4">
                            {{$colonia->created_at}}
                        </td>
                        <!--Formulario para enviar a editar el select de la direccion-->
                        <td>
                            <form method="GET" action="{{ route('colonias.edit', $colonia->id) }}">

                                <!-- Botón para editar colonia -->
                                <button
                                    class="py-2 text-white transition duration-200 ease-in-out bg-green-500 border rounded cursor-pointer lg:px-4 lg:py-4 md:px-6 md:py-2 px-7 hover:bg-green-700"
                                    title="Editar colonia">
                                    <i class="fas fa-map-marker-alt"></i>
                                </button>
                            </form>

                        </td>
                        <td>
                            <!--Eliminar colonia-->
                            <form method="POST" action="{{ route('colonias.destroy', $colonia->id) }}"
                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta colonia?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-6 py-4 text-white transition duration-200 ease-in-out bg-red-500 border rounded cursor-pointer hover:bg-red-700"
                                    title="Eliminar colonia">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                    <!-- Aquí deberías mostrar otros datos del producto -->
                @endforeach
            </table>
            <div class="mt-3 ">
                <p>Total de resultados: {{ $coloniasTuxtla->total() }}</p>
                {{ $coloniasTuxtla->links() }} <!-- Esto mostrará los enlaces de paginación -->
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
        const modalRegistrarColonia = document.querySelector('#modalRegistrarColonia')
        const abrirnModalRegisrarColonia = document.querySelector('#abrirnModalRegisrarColonias');

        const cancelarModal = document.querySelector('.cerrarmodal');

        //Abre el modal para registrar un producto
        abrirnModalRegisrarColonia.addEventListener('click', function() {
            modalRegistrarColonia.classList.remove('hidden');
        });

        // Escucha el evento de click en el botón cancelar Modal de registro
        cancelarModal.addEventListener('click', function() {
            // Oculta el modal
            modalRegistrarColonia.classList.add('hidden');
        });
        //con esto buscamos rapido con lo que escribimos en el select lo que necesitamos
        $(document).ready(function() {
            $('#coloniaSelect').select2();
        });


    </script>
@endpush
