@extends('layouts.admin')

@section('title', 'Clientes')

@section('content')
    <h1 class=" text-center ">Clientes</h1>

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
        @include('clientes._filtros')
        <!-- boton anadir producto-->
        <button id="abrirnModalRegisrarCliente"
            class=" flex items-center mb-4 bg-gradient-to-r  from-gray-800 via-gray-600 to-green-500 text-white font-bold py-2 px-4 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-person-fill-add mr-2" viewBox="0 0 16 16">
                <path
                    d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                <path
                    d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4" />
            </svg>
            Añadir cliente
        </button>
        <!-- Modal -->
        <div id="modalRegistrarCliente" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title"
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
                            Registrar cliente
                        </h3>

                        <label id="tipoCliente" class="flex items-center cursor-pointer justify-center">
                            <span class="ms-3 mr-2 text-sm font-medium text-gray-900 dark:text-gray-300">Persona
                                Fisica</span>
                            <input id="tipoDeCliente" type="checkbox" value="" class="sr-only peer">
                            <div
                                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                            </div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Persona Moral</span>
                        </label>

                        <form method="POST" action="{{ route('clientes.store') }}"
                            onsubmit="document.getElementById('enviarmodal').disabled = true;"
                            class=" mt-8 flex flex-col items-center">
                            @csrf
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span id="nombreLabel">Nombre del cliente</span>
                                <input name="txtnombre"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <label id="apellidoCliente" class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Apellidos</span>
                                <input name="txtapellido"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Telefono</span>
                                <input name="txttelefono" pattern="\d{10}"
                                    title="Por favor ingresa exactamente 10 dígitos del numero telefonico"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                                @error('txttelefono')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Correo electronico</span>
                                <input type="email" name="txtemail"
                                    title="Por favor ingresa un correo electronico valido ejemplo example@yahoo.com"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>RFC</span>
                                <input name="txtrfc" type="text"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none w-full h-10" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Colonia</span>
                                <select id="coloniaSelect" name="txtcolonia"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none w-full h-10">
                                    <option value="">Selecciona la colonia o Barrio</option>
                                    @foreach ($catalogo_colonias as $municipio)
                                        <option value="{{ $municipio->id }}">{{ $municipio->localidad }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Calles</span>
                                <input name="txtcalle" type="text"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none w-full h-10" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Numero exterior</span>
                                <input name="txtnum_exterior" type="text"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none w-full h-10" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Numero interior</span>
                                <input name="txtnum_interior" type="text"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none w-full h-10" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Referencia</span>
                                <input name="txtreferencia" type="text"
                                    class=" mb-2 border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none w-full h-10" />
                            </label>
                            <button type="submit" id="enviarmodal"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-700 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-floppy-fill mr-2" viewBox="0 0 16 16">
                                    <path
                                        d="M0 1.5A1.5 1.5 0 0 1 1.5 0H3v5.5A1.5 1.5 0 0 0 4.5 7h7A1.5 1.5 0 0 0 13 5.5V0h.086a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5H14v-5.5A1.5 1.5 0 0 0 12.5 9h-9A1.5 1.5 0 0 0 2 10.5V16h-.5A1.5 1.5 0 0 1 0 14.5z" />
                                    <path
                                        d="M3 16h10v-5.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5zm9-16H4v5.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5zM9 1h2v4H9z" />
                                </svg>
                                Guardar cliente
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
            <table class="min-w-full">
                <!--La clase min-w-full hace que la tabla tenga al menos el ancho completo de su contenedor, lo que significa que se desplazará horizontalmente si es necesario.-->
                <tr class="text-black uppercase text-xs  font-bold leading-normal">
                    <td class="py-3 px-6 text-left border-r">Nombre</td>
                    <td class="py-3 px-6 text-left border-r">Telefono</td>
                    <td class="py-3 px-6 text-left border-r">Correo electronico</td>
                    <td class="py-3 px-6 text-left border-r">RFC</td>
                    <td class="py-3 px-6 text-left border-r">Direccion</td>
                </tr>

                <!--La clase min-w-full hace que la tabla tenga al menos el ancho completo de su contenedor, lo que significa que se desplazará horizontalmente si es necesario.-->

                @foreach ($clientes as $cliente)
                    <tr class= " border-b border-gray-200 text-sm">
                        <td class=" px-6 py-4">
                            {{ $cliente->nombre }} {{ $cliente->apellido }}</td>
                        <td class="px-6 py-4">
                            {{ $cliente->telefono }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $cliente->email }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $cliente->comentario }}
                        </td>
                        <!--Formulario para enviar a editar el select de la direccion-->
                        <form action="{{ route('clientes.edit', $cliente->id) }}" method="get">
                            <td class="px-6 py-4">
                                <select id="direccionSelect" name="direccion"
                                    class="focus:ring-2 focus:ring-blue-300 focus:outline-none">
                                    @php
                                        //una bandera
                                        $direccionEncontrada = false;
                                    @endphp
                                    <!--for de direcciones-->
                                    @foreach ($direcciones as $direccion)
                                        <!--si id cliente es igual al id de direcciones que es el cliente entra-->
                                        @if ($cliente->id == $direccion->id)
                                            <option value="{{ $direccion->id_direccion }}">
                                                Col.{{ $direccion->localidad }}; {{ $direccion->calle }}
                                                #{{ $direccion->num_exterior }}</option>
                                            @php
                                                //si hay datos en direcciones la bandera es true pero si no pasa ningun dato en el for entonces no hay datos
                                                $direccionEncontrada = true;
                                                $valor = $direccion->id_direccion;
                                            @endphp
                                        @endif
                                    @endforeach
                                    @if (!$direccionEncontrada)
                                        <!--si es false entoces imprime No hay registros-->
                                        <option value="">No hay direcciones de registros</option>
                                    @endif
                                </select>
                            </td>
                            <td>
                                <!--Edtiamos un cliente-->
                                <button type="submit"
                                    class=" border rounded px-6 py-4 bg-green-500 text-white cursor-pointer hover:bg-green-700 transition duration-200 ease-in-out"
                                    title="Editar cliente">
                                    <i class="fas fa-sync"></i>
                                </button>
                            </td>
                        </form>
                        <td>
                            <!--Agregamos mas direcciones a un usuario-->
                            <button onclick="window.location='{{ route('direcciones.edit', $cliente->id) }}'"
                                class="border rounded lg:px-4 lg:py-4 md:px-6 md:py-2  px-7 py-2 bg-blue-500 text-white cursor-pointer hover:bg-blue-700 transition duration-200 ease-in-out"
                                title="Agregar más direcciones">
                                <i class="fas fa-map-marker-alt"></i>
                                <i class="fas fa-plus"></i>
                            </button>
                        </td>
                        <td>
                            <!--Desactivamos al cliente-->
                            <form method="POST" action="{{ route('clientes.desactivar', $cliente->id) }}"
                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar este cliente?');">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    class="border rounded px-6 py-4 bg-red-500 text-white cursor-pointer hover:bg-red-700 transition duration-200 ease-in-out"
                                    title="Eliminar cliente">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                    <!-- Aquí deberías mostrar otros datos del producto -->
                @endforeach
            </table>
            <div class=" mt-3">
                <p>Total de resultados: {{ $clientes->total() }}</p>
                {{ $clientes->links() }} <!-- Esto mostrará los enlaces de paginación -->
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
        const modalRegistrarEmpleado = document.querySelector('#modalRegistrarCliente')
        const abrirnModalRegisrarEmpleado = document.querySelector('#abrirnModalRegisrarCliente');

        const cancelarModal = document.querySelector('.cerrarmodal');

        //Abre el modal para registrar un producto
        abrirnModalRegisrarEmpleado.addEventListener('click', function() {
            modalRegistrarEmpleado.classList.remove('hidden');
        });

        // Escucha el evento de click en el botón cancelar Modal de registro
        cancelarModal.addEventListener('click', function() {
            // Oculta el modal
            modalRegistrarEmpleado.classList.add('hidden');
        });
        //con esto buscamos rapido con lo que escribimos en el select lo que necesitamos
        $(document).ready(function() {
            $('#coloniaSelect').select2();
        });

        document.getElementById('tipoDeCliente').addEventListener('change', function() {
            var apellidoInput = document.getElementById('apellidoCliente');
            if (this.checked) {
                apellidoInput.style.display = 'none';
                nombreLabel.textContent = 'Razon Social';

            } else {
                apellidoInput.style.display = 'flex';
                nombreLabel.textContent = 'Nombre del cliente';

            }
        });
    </script>
@endpush
