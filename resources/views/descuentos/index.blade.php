@extends('layouts.admin')

@section('title', 'Descuentos')

@section('content')
    <h1 class=" text-center">Descuentos</h1>

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
        <!-- boton anadir producto-->
        <button id="abrirnModalRegisrarProducto"
            class=" mb-4 bg-gradient-to-r from-gray-800 via-gray-600 to-green-500 text-white font-bold py-2 px-4 rounded-full">
            Añadir descuento
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

                        <form method="POST" action="{{ route('descuentos.store') }}" enctype="multipart/form-data"
                            class=" mt-8 flex flex-col items-center">
                            @csrf
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Nombre del descuento</span>
                                <input name="txtnombre"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
                                    required />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Porcentaje</span>
                                <input name="txtporcentaje" type="number" min="1" max="100"
                                    class="border-2 px-10 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
                                    required />
                            </label>


                            <button type="submit" id="enviarmodal"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
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
                    <td class="py-3 px-6 text-left border-r">Clave del descuento</td>
                    <td class="py-3 px-6 text-left border-r">Porcentaje</td>
                    <td class="py-3 px-6 text-left border-r">Fecha de creación</td>
                    <td class="py-3 px-6 text-left border-r">Fecha de actualización</td>
                </tr>
                @foreach ($descuentos as $descuento)
                    <tr class= " border-b border-gray-200 text-sm">
                        <td class=" px-6 py-4">
                            {{ $descuento->nombre }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $descuento->porcentaje }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $descuento->created_at }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $descuento->updated_at }}
                        </td>
                        {{-- descomentar si quieren actualizar sin embargo no es practico por que si actualizan podrian cambiar todos los ticket viejos con ese descuento <td>

                            <button onclick="location.href='{{ route('descuentos.edit', $descuento->id) }}';"
                                class=" border rounded px-6 py-4 bg-green-500 text-white cursor-pointer hover:bg-green-700 transition duration-200 ease-in-out">
                                <i class="fas fa-sync"></i>
                            </button>

                        </td> --}}
                        <td>
                            <form action="{{ route('descuentos.desactivar', $descuento->id) }}" method="POST"
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
                <p>Total de resultados: {{ $descuentos->total() }}</p> <!--mostrar total de resultados-->
                {{ $descuentos->links() }} <!-- Esto mostrará los enlaces de paginación -->
            </div>
        </section>
    </main>
@endsection

@push('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome para los iconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
