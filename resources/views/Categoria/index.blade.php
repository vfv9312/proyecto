@extends('layouts.admin')

@section('title', 'Categoria')

@section('content')
    <h1 class=" font-bold text-center mb-8">Categorias</h1>

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

        @include('Categoria._filtro')
        <!-- boton anadir producto-->
        <button id="abrirnModalRegisrarProducto"
            class=" flex items-center mb-4 bg-gradient-to-r from-gray-800 via-gray-600 to-green-500 text-white font-bold py-2 px-4 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-book-half mr-2" viewBox="0 0 16 16">
                <path
                    d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783" />
            </svg>
            Añadir categoria
        </button>

        @include('Categoria._modal')

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
                @foreach ($categorias as $categoria)
                    <tr class= " border-b border-gray-200 text-sm">
                        <td class=" px-6 py-4">
                            {{ $categoria->nombre }}</td>
                        <td class="px-6 py-4">
                            {{ $categoria->created_at }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $categoria->updated_at }}
                        </td>
                        <td>

                            <button onclick="location.href='{{ route('categorias.edit', $categoria->id) }}';"
                                class="abrirModalEditar border rounded px-6 py-4 bg-green-500 text-white cursor-pointer hover:bg-green-700 transition duration-200 ease-in-out">
                                <i class="fas fa-sync"></i>
                            </button>

                        </td>
                        <td>
                            <form action="{{ route('categorias.desactivar', $categoria->id) }}" method="POST"
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
                <p>Total de resultados: {{ $categorias->total() }}</p> <!--mostrar total de resultados-->
                {{ $categorias->links() }} <!-- Esto mostrará los enlaces de paginación -->
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
