@extends('adminlte::page')

@section('title', 'opcion')

@section('content_header')
    <h1 class=" text-center">Productos</h1>
@stop

@section('content')

    <main class=" w-full h-3/4">
        <h5 class=" text-center">Ultimos 15</h5>
        <table class=" table-auto w-full">
            <thead class=" bg-cyan-500">
                <tr>
                    <th class=" border-8 border-slate-600 ...">Nombre Comercial</th>
                    <th class=" border-8 border-slate-600 ...">Modelo</th>
                    <th class=" border-8 border-slate-600 ...">Color</th>
                    <th class="border-8 border-slate-600 ...">Marca</th>
                    <th class="border-8 border-slate-600 ...">Fotografia</th>
                    <th class="border-8 border-slate-600 ">Ultima fecha de actualizacion</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datos as $item)
                    <tr>
                        <td class="border border-slate-700 ...">{{ $item->nombre_comercial }}</td>
                        <td class="border border-slate-700 ...">{{ $item->modelo }}</td>
                        <td class="border border-slate-700 ...">{{ $item->color }}</td>
                        <td class="border border-slate-700 ...">{{ $item->marca }}</td>
                        <td class="border border-slate-700 flex justify-center items-center"><img class=" w-32"
                                src={{ $item->fotografia }}></td>
                        <td class="border border-slate-700 ...">{{ $item->updated_at }}</td>
                        <!-- Botón para abrir el modal -->
                        <td
                            class="openModalButton border border-slate-600 bg-blue-500 text-white cursor-pointer hover:bg-blue-700 transition duration-200 ease-in-out">
                            ✍🏽
                        </td>
                        <td
                            class="border border-slate-600 bg-blue-500 text-white cursor-pointer hover:bg-blue-700 transition duration-200 ease-in-out">
                            🗑</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Modal -->
        <div id="myModal" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Fondo del modal -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <!-- Contenido del modal -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Título del Modal
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Contenido del modal.
                            </p>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" id="enviarmodal"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Aceptar
                        </button>
                        <button type="button" id="cerrarmodal"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </main>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@stop

@section('js')
    <script>
        // Obtén los elementos del DOM
        const modal = document.getElementById('myModal');
        const openModalButton = document.querySelectorAll('.openModalButton');

        const cancelarModal = document.getElementById('cerrarmodal');

        // Selecciona todos los botones con la clase '.openModalButton'
        openModalButton.forEach(button => {
            button.addEventListener('click', function() {
                // Muestra el modal
                modal.classList.remove('hidden');
            });
        });
        // Escucha el evento de click en el botón
        cancelarModal.addEventListener('click', function() {
            // Muestra el modal
            modal.classList.add('hidden');
        });
    </script>
@stop
