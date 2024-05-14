@extends('layouts.admin')

@section('title', 'Empleados')

@section('content_header')

@section('content')
    <main class=" w-full h-3/4">
        <h1 class=" mb-10 text-center font-bold ">Añadir empleado</h1>
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
        @include('empleados._filtro')
        <!-- boton anadir producto-->
        <button id="abrirnModalRegisrarEmpleado"
            class=" flex items-center ml-10 mb-4 bg-gradient-to-r  from-gray-800 via-gray-600 to-green-500 text-white font-bold py-2 px-4 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-person-circle mr-2" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                <path fill-rule="evenodd"
                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
            </svg>
            Añadir empleado
        </button>
        <!-- Modal -->
        <div id="modalRegistrarEmpleado" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-start justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Fondo del modal -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <!-- Contenido del modal -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class=" text-center text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Registrar empleado
                        </h3>

                        <form method="POST" action="{{ route('user.register') }}" class=" mt-8 flex flex-col items-center"
                            onsubmit="document.getElementById('enviarmodal').disabled = true;">
                            @csrf
                            <!-- Nombre-->
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Nombre Completo</span>
                                <input name="name" :value="old('name')" required autofocus autocomplete="name"
                                    type="text"
                                    class="border-2 border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Nombre de usuario</span>
                                <input name="username" :value="old('username')" required autofocus autocomplete="username"
                                    type="text"
                                    class="border-2 border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none" />
                                <x-input-error :messages="$errors->get('username')" class="mt-2" />
                            </label>
                            <!-- Roles-->
                            <label class="text-sm text-gray-500 flex flex-col items-start mb-4">
                                <span>Rol del empleado</span>
                                <select name="rol"
                                    class="border-2 border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none w-full h-14">
                                    @foreach ($roles as $rol)
                                        <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <!-- Correo Electronico-->
                            {{-- <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Correo Electronico</span>
                                <input name="email" :value="old('email')" required autocomplete="username" type="email"
                                    class="border-2 border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </label> --}}
                            <!-- Password -->
                            <label class="text-sm text-gray-500 flex flex-col items-start mb-4">
                                <span> Contraseña</span>
                                <input type="password" name="password" required autocomplete="new-password"
                                    class="border-2 border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </label>
                            <!--Confirmar Contraseña-->
                            <label class="text-sm text-gray-500 flex flex-col items-start mb-10">
                                <span>Confirmar Contraseña</span>
                                <input id="password_confirmation" type="password" name="password_confirmation" required
                                    autocomplete="new-password"
                                    class="border-2 border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </label>


                            <!---Si el cliente cambia de opinion y quiere agregar datos  quitar comentario-->
                            <!-- tipos de ordenes : Orden de Servicio (Recepción), Orden de Pedido a Domicilio, Orden de Venta, Orden de Recolección <label class="text-sm text-gray-500 flex flex-col items-start">

                                                                                                                                                                                                                                                                                                                                                    </label>-->
                            <button type="submit" id="enviarmodal"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-700 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-floppy-fill mr-2" viewBox="0 0 16 16">
                                    <path
                                        d="M0 1.5A1.5 1.5 0 0 1 1.5 0H3v5.5A1.5 1.5 0 0 0 4.5 7h7A1.5 1.5 0 0 0 13 5.5V0h.086a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5H14v-5.5A1.5 1.5 0 0 0 12.5 9h-9A1.5 1.5 0 0 0 2 10.5V16h-.5A1.5 1.5 0 0 1 0 14.5z" />
                                    <path
                                        d="M3 16h10v-5.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5zm9-16H4v5.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5zM9 1h2v4H9z" />
                                </svg>
                                Guardar empleado
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
    </main>

    <!--tabla-->
    <section class="overflow-x-auto">

        <!--La clase overflow-x-auto hace que el div tenga un desplazamiento horizontal si su contenido es demasiado ancho para caber en la pantalla-->
        <table class="min-w-full ml-10">
            <!--La clase min-w-full hace que la tabla tenga al menos el ancho completo de su contenedor, lo que significa que se desplazará horizontalmente si es necesario.-->
            <tr class=" text-black uppercase text-xs  font-bold leading-normal">
                <td class="py-3 px-6 text-left border-r">Nombre</td>
                <td class="py-3 px-6 text-left border-r">Nombre de usuario</td>
                <td class="py-3 px-6 text-left border-r">Rol</td>
                <!--El dueño no quiere correo o imagen-->
                <!--
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td class="py-3 px-6 text-left border-r">Correo electronico</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td class="py-3 px-6 text-left border-r">Imagen</td>-->
            </tr>
            @foreach ($empleados as $empleado)
                <tr class= " border-b border-gray-200 text-sm">
                    <td class=" px-6 py-4">
                        {{ $empleado->nombre }}</td>
                    <td class="px-6 py-4">
                        {{ $empleado->username }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $empleado->nombreRol }}
                    </td>

                    <input type="hidden" name="miDato" value="{{ $empleado->id_rol }}">
                    <!--el dueño no queria foto y email, pero si cambia de opinion aqui esta-->
                    <!--</td> -->

                    <td class="flex">
                        <button onclick="location.href='{{ route('empleados.edit', $empleado->id) }}';"
                            class="border rounded px-6 py-4 bg-green-500 text-white cursor-pointer hover:bg-green-700 transition duration-200 ease-in-out mr-3"
                            title="Editar empleado">
                            <i class="fas fa-sync"></i>
                        </button>

                        <form action="{{ route('empleados.destroy', $empleado->id) }}" method="POST"
                            onsubmit="return confirm('¿Estás seguro de que quieres eliminar este empleado?');">
                            @csrf
                            @method('DELETE')
                            <button
                                class="border rounded px-6 py-4 bg-red-500 text-white cursor-pointer hover:bg-red-700 transition duration-200 ease-in-out"
                                title="Eliminar empleado">
                                <i class="fas fa-trash"></i></button>
                        </form>
                    </td>

                </tr>
                <!-- Aquí deberías mostrar otros datos del producto -->
            @endforeach
        </table>
        <div class=" mt-3">
            <p>Total de resultados: {{ $empleados->total() }}</p>
            {{ $empleados->links() }} <!-- Esto mostrará los enlaces de paginación -->
        </div>
    </section>

@endsection


@push('css')
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome -->
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
        const modalRegistrarEmpleado = document.querySelector('#modalRegistrarEmpleado')
        const abrirnModalRegisrarEmpleado = document.querySelector('#abrirnModalRegisrarEmpleado');

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
    </script>
@endpush
