@extends('layouts.admin')

@section('title', 'Productos')

@section('content')
    <h1 class=" font-bold text-center mb-8">Productos</h1>

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
        @include('Productos._filtro')
        <!-- boton anadir producto-->
        <button id="abrirnModalRegisrarProducto"
            class=" flex items-center mb-4 bg-gradient-to-r from-gray-800 via-gray-600 to-green-500 text-white font-bold py-2 px-4 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-box-seam-fill mr-2" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003zM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461z" />
            </svg>
            Añadir producto
        </button>
        <!--Hacemos responsivo el modal-->
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

                        <form method="POST" action="{{ route('productos.store') }}"
                            onsubmit="document.getElementById('enviarmodal').disabled = true;" enctype="multipart/form-data"
                            class=" mt-8 flex flex-col items-center">
                            @csrf
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Nombre comercial</span>
                                <input name="txtnombre" required
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Modelo</span>
                                <input name="txtmodelo" required
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Color</span>
                                <select name="txtcolor" required
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none">
                                    <option value="">Selecciona un color</option>
                                    @foreach ($colores as $color)
                                        <option value="{{ $color->id }}">{{ $color->nombre }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Categoria</span>
                                <select name="txttipo" required
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none">
                                    <option value="">Selecciona una una categoria</option>
                                    @foreach ($categorias as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Tipo</span>
                                <select name="txtmodo" required
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none">
                                    <option value="">Selecciona un tipo</option>
                                    @foreach ($modos as $modo)
                                        <option value="{{ $modo->id }}">{{ $modo->nombre }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Marca</span>
                                <select name="txtmarca" required
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none">
                                    <option value="">Selecciona una marca</option>
                                    @foreach ($marcas as $marca)
                                        <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>precio</span>
                                <input name="txtprecio" type="number" min="1" step="0.01"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none h-8"
                                    required />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>precio alternativo 1</span>
                                <input name="txtprecioalternativouno" type="number" min="1" step="0.01"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none h-8"
                                    required />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>precio alternativo 2</span>
                                <input name="txtprecioalternativodos" type="number" min="1" step="0.01"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none h-8"
                                    required />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>precio alternativo 3</span>
                                <input name="txtprecioalternativotres" type="number" min="1" step="0.01"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none h-8"
                                    required />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <label for="message"
                                    class="text-lg text-gray-500 flex flex-col items-start">Descripcion</label>
                                <textarea id="message" rows="4" name="txtdescripcion"
                                    class="block mb-3 p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border-2 border-blue-500 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Escribe aqui la descripcion ...."></textarea>

                            </label>

                            <button type="submit" id="enviarmodal"
                                class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-greens-500 sm:ml-3 sm:w-auto sm:text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-floppy-fill mr-2" viewBox="0 0 16 16">
                                    <path
                                        d="M0 1.5A1.5 1.5 0 0 1 1.5 0H3v5.5A1.5 1.5 0 0 0 4.5 7h7A1.5 1.5 0 0 0 13 5.5V0h.086a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5H14v-5.5A1.5 1.5 0 0 0 12.5 9h-9A1.5 1.5 0 0 0 2 10.5V16h-.5A1.5 1.5 0 0 1 0 14.5z" />
                                    <path
                                        d="M3 16h10v-5.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5zm9-16H4v5.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5zM9 1h2v4H9z" />
                                </svg>
                                Guardar
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
        <section class="overflow-x-auto">
            <!--La clase overflow-x-auto hace que el div tenga un desplazamiento horizontal si su contenido es demasiado ancho para caber en la pantalla-->
            <table class="min-w-full">
                <!--La clase min-w-full hace que la tabla tenga al menos el ancho completo de su contenedor, lo que significa que se desplazará horizontalmente si es necesario.-->
                <tr class="text-black uppercase text-xs  font-bold leading-normal">
                    <td class="py-3 px-6 text-left border-r">Nombre comercial</td>
                    <td class="py-3 px-6 text-left border-r">Modelo</td>
                    <td class="py-3 px-6 text-left border-r">Color</td>
                    <td class="py-3 px-6 text-left border-r">Marca</td>
                    <td class="py-3 px-6 text-left border-r">Categoria</td>
                    <td class="py-3 px-6 text-left border-r">Tipo </td>
                    <td class="py-3 px-6 text-left border-r">Precio</td>
                </tr>
                @foreach ($productos as $producto)
                    <tr class= " border-b border-gray-200 text-sm">
                        <td class=" px-6 py-4">
                            {{ $producto->nombre_comercial }}</td>
                        <td class="px-6 py-4">
                            {{ $producto->modelo }}
                        </td>
                        <td class="px-6 py-4">
                            @if ($producto->idColor == 1)
                                <div style="height:25px;width:25px;background-color:black;border-radius:50%;"></div>
                            @elseif ($producto->idColor == 2)
                                <div style="height:25px;width:25px;background-color:yellow;border-radius:50%;">
                                </div>
                            @elseif ($producto->idColor == 3)
                                <div style="height:33px;width:33px;background-color:cyan;border-radius:50%;"></div>
                            @elseif ($producto->idColor == 4)
                                <div style="height:33px;width:33px;background-color:magenta;border-radius:50%;"></div>
                            @elseif ($producto->idColor == 5)
                                <div
                                    style="background: linear-gradient(to right, cyan 33%, magenta 33%, magenta 66%, yellow 66%); border-radius: 50%; width: 33px; height: 33px;">
                                </div>
                            @elseif ($producto->idColor == 6)
                                <div
                                    style="background: linear-gradient(to right, cyan 25%, magenta 25%, magenta 50%, yellow 50%, yellow 75%, black 75%); border-radius: 50%; width: 33px; height: 33px;">
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            {{ $producto->nombreMarca }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $producto->nombreTipo }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $producto->nombreModo }}
                        </td>
                        <td class="px-6 py-4">
                            ${{ $producto->precio }}
                        </td>
                        <td>

                            <button onclick="location.href='{{ route('productos.edit', $producto->id) }}';"
                                class="abrirModalEditar border rounded px-6 py-4 bg-green-500 text-white cursor-pointer hover:bg-green-700 transition duration-200 ease-in-out">
                                <i class="fas fa-sync"></i>
                            </button>

                        </td>
                        <td>
                            <form action="{{ route('productos.desactivar', $producto->id) }}" method="POST"
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
                <p>Total de resultados: {{ $productos->total() }}</p> <!--mostrar total de resultados-->
                {{ $productos->links() }} <!-- Esto mostrará los enlaces de paginación -->
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

        document.querySelector('input[name="txtprecio"]').addEventListener('input', function() {
            if (this.value < 1) {
                this.setCustomValidity('El precio debe ser mayor que 0');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>
@endpush
