@extends('adminlte::page')

@section('title', 'productos')

@section('content_header')
    <h1 class=" text-center">Productos</h1>
@stop

@section('content')

    <main class=" w-full h-3/4">
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

        <!-- boton anadir producto-->
        <button id="abrirnModalRegisrarProducto"
            class=" mb-4 bg-gradient-to-r from-green-500 via-green-500 to-yellow-500 text-white font-bold py-2 px-4 rounded">
            Añadir producto
        </button>
        <!-- Modal -->
        <div id="modalRegistrarProducto" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Fondo del modal -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <!-- Contenido del modal -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class=" text-center text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Registrar Producto
                        </h3>

                        <form method="POST" action="{{ route('productos.create') }}"
                            class=" mt-8 flex flex-col items-center">
                            @csrf
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Nombre comercial</span>
                                <input name="txtnombre"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Modelo</span>
                                <input name="txtmodelo"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Color</span>
                                <input name="txtcolor"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Marca</span>
                                <input name="txtmarca"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>precio</span>
                                <input name="txtprecio" type="number"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Descripcion</span>
                                <input name="txtdescripcion" type="text"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Fotografia</span>
                                <input type="file"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <button type="submit" id="enviarmodal"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Aceptar
                            </button>

                        </form>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">

                        <button type="button"
                            class="cerrarmodal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!--tabla-->
        <table class="table-auto w-full text-center shadow-md">
            <thead class="bg-green-500 text-white">
                <tr>
                    <th class="  px-4 py-2">Nombre Comercial</th>
                    <th class="  px-4 py-2">Modelo</th>
                    <th class=" px-4 py-2">Color</th>
                    <th class="px-4 py-2">Marca</th>
                    <th class="px-4 py-2">Fotografia</th>
                    <th class="px-4 py-2">Precio</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datos as $item)
                    <tr class="{{ $loop->iteration % 2 ? 'bg-green-100' : 'bg-green-200' }}">
                        <td class="border px-4 py-2">{{ $item->nombre_comercial }}</td>
                        <td class="border px-4 py-2">{{ $item->modelo }}</td>
                        <td class="border px-4 py-2">{{ $item->color }}</td>
                        <td class="border px-4 py-2">{{ $item->marca }}</td>
                        <td class="border px-4 py-2 flex justify-center items-center"><img class=" w-32"
                                src={{ $item->fotografia }}></td>
                        <td class="border px-4 py-2">$ {{ $item->precio }}</td>
                        <!-- Botón para abrir el modal -->
                        <td
                            class="abrirModalEditar border px-4 py-2 bg-green-500 text-white cursor-pointer hover:bg-green-700 transition duration-200 ease-in-out">
                            ✍🏽
                        </td>
                        <td
                            class="border px-4 py-2 bg-red-500 text-white cursor-pointer hover:bg-red-700 transition duration-200 ease-in-out">
                            🗑</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Modal -->
        <div id="modalEditarRegistro" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Fondo del modal -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <!-- Contenido del modal -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class=" text-center text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Editar
                        </h3>

                        <form action="" method="POST" class=" mt-8 flex flex-col items-center">
                            @csrf
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Nombre comercial</span>
                                <input name="txtnombre"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Modelo</span>
                                <input name="txtmodelo"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Color</span>
                                <input name="txtcolor"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Marca</span>
                                <input name="txtmarca"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>precio</span>
                                <input name="txtprecio" type="number"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Fotografia</span>
                                <input type="file"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>

                        </form>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" id="enviarmodal"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Aceptar
                        </button>
                        <button type="button" id="cerrarModalEditar"
                            class=" mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
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
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@stop

@section('js')
    <script>
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


        //Oculta los elementos de alerta despues de 3 segundos
        window.setTimeout(function() {
            var alertCorrecto = document.getElementById('alert-correcto');
            var alertIncorrect = document.getElementById('alert-incorrect');
            if (alertCorrecto) alertCorrecto.style.display = 'none';
            if (alertIncorrect) alertIncorrect.style.display = 'none';
        }, 3000);
    </script>
@stop
