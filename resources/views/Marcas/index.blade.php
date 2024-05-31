@extends('layouts.admin')

@section('title', 'Marcas')

@section('content')
    <h1 class=" font-bold text-center mb-8">Marcas</h1>

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

        @include('Marcas._filtro')
        <!-- boton anadir producto-->
        <button id="abrirnModalRegisrarProducto"
            class=" flex items-center mb-4 bg-gradient-to-r from-gray-800 via-gray-600 to-green-500 text-white font-bold py-2 px-4 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-threads mr-2" viewBox="0 0 16 16">
                <path
                    d="M6.321 6.016c-.27-.18-1.166-.802-1.166-.802.756-1.081 1.753-1.502 3.132-1.502.975 0 1.803.327 2.394.948s.928 1.509 1.005 2.644q.492.207.905.484c1.109.745 1.719 1.86 1.719 3.137 0 2.716-2.226 5.075-6.256 5.075C4.594 16 1 13.987 1 7.994 1 2.034 4.482 0 8.044 0 9.69 0 13.55.243 15 5.036l-1.36.353C12.516 1.974 10.163 1.43 8.006 1.43c-3.565 0-5.582 2.171-5.582 6.79 0 4.143 2.254 6.343 5.63 6.343 2.777 0 4.847-1.443 4.847-3.556 0-1.438-1.208-2.127-1.27-2.127-.236 1.234-.868 3.31-3.644 3.31-1.618 0-3.013-1.118-3.013-2.582 0-2.09 1.984-2.847 3.55-2.847.586 0 1.294.04 1.663.114 0-.637-.54-1.728-1.9-1.728-1.25 0-1.566.405-1.967.868ZM8.716 8.19c-2.04 0-2.304.87-2.304 1.416 0 .878 1.043 1.168 1.6 1.168 1.02 0 2.067-.282 2.232-2.423a6.2 6.2 0 0 0-1.528-.161" />
            </svg>
            Añadir Marca
        </button>

        @include('Marcas._modal')

        <!--tabla-->
        <section class="overflow-x-auto">
            <!--La clase overflow-x-auto hace que el div tenga un desplazamiento horizontal si su contenido es demasiado ancho para caber en la pantalla-->
            <table class="min-w-full">
                <!--La clase min-w-full hace que la tabla tenga al menos el ancho completo de su contenedor, lo que significa que se desplazará horizontalmente si es necesario.-->
                <tr class="text-black uppercase text-xs  font-bold leading-normal">
                    <td class="py-3 px-6 text-left border-r">Nombre</td>
                    <td class="py-3 px-6 text-left border-r">Fecha creacion</td>
                    <td class="py-3 px-6 text-left border-r">Fecha Actualización</td>
                </tr>
                @foreach ($marcas as $marca)
                    <tr class= " border-b border-gray-200 text-sm">
                        <td class=" px-6 py-4">
                            {{ $marca->nombre }}</td>
                        <td class="px-6 py-4">
                            {{ $marca->created_at }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $marca->updated_at }}
                        </td>
                        <td>

                            <button onclick="location.href='{{ route('marcas.edit', $marca->id) }}';"
                                class="abrirModalEditar border rounded px-6 py-4 bg-green-500 text-white cursor-pointer hover:bg-green-700 transition duration-200 ease-in-out">
                                <i class="fas fa-sync"></i>
                            </button>

                        </td>
                        <td>
                            <form action="{{ route('marcas.desactivar', $marca->id) }}" method="POST"
                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                                @csrf
                                @method('PUT')
                                <button
                                    class="border rounded px-6 py-4 bg-red-500 text-white cursor-pointer hover:bg-red-700 transition duration-200 ease-in-out">
                                    <i class="fas fa-trash"></i></button>
                            </form>
                        </td>

                    </tr>
                    <!-- Aquí deberías mostrar otros datos del producto -->
                @endforeach
            </table>
            <div class=" mt-3">
                <p>Total de resultados: {{ $marcas->total() }}</p> <!--mostrar total de resultados-->
                {{ $marcas->links() }} <!-- Esto mostrará los enlaces de paginación -->
            </div>
        </section>
    </main>

@endsection

@push('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
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
        const modalEditarRegistro = document.querySelector('#modalEditarRegistro');
        const modalRegistrarProducto = document.querySelector('#modalRegistrarProducto')
        const abrirModalEditar = document.querySelectorAll('.abrirModalEditar');
        const abrirnModalRegisrarProducto = document.querySelector('#abrirnModalRegisrarProducto');

        const cancelarModal = document.querySelector('.cerrarmodal');
        const cancelarModalEditar = document.querySelector('#cerrarModalEditar');

        // Selecciona todos los botones con la clase '.openModalButton'
        abrirModalEditar.forEach(button => {
            button.addEventListener('click', function() {
                // Muestra el modal
                modalEditarRegistro.classList.remove('hidden');
            });
        });
        //Abre el modal para registrar un producto
        abrirnModalRegisrarProducto.addEventListener('click', function() {
            modalRegistrarProducto.classList.remove('hidden');
        });

        // Escucha el evento de click en el botón cancelar Modal de registro
        cancelarModal.addEventListener('click', function() {
            // Oculta el modal
            modalRegistrarProducto.classList.add('hidden');
        });

        // Escucha el evento de click en el botón cancelar Modal de Editar
        cerrarModalEditar.addEventListener('click', function() {

            // Oculta el modal
            modalEditarRegistro.classList.add('hidden');
        });
    </script>
@endpush
