@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h5 class=" text-center"> Hola <strong>{{ Auth::user()->name }}</strong> desde aqui podras registrar tus ventas de
        servicios o productos
    </h5>
@stop

@section('content')
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
        <!-- boton anadir servicio-->
        <button id="abrirnModalRegisrarProducto" onclick="window.location='{{ route('servicios.create') }}';"
            class="mb-4 bg-gradient-to-r from-green-500 via-green-500 to-yellow-500 text-white font-bold py-2 px-4 rounded-full">
            Añadir servicio
        </button>

        <!--tabla-->
        <section class="overflow-x-auto">
            <!--La clase overflow-x-auto hace que el div tenga un desplazamiento horizontal si su contenido es demasiado ancho para caber en la pantalla-->
            <table class="min-w-full">
                <!--La clase min-w-full hace que la tabla tenga al menos el ancho completo de su contenedor, lo que significa que se desplazará horizontalmente si es necesario.-->
                <tr class="text-black uppercase text-xs  font-bold leading-normal">
                    <td class="py-3 px-6 text-left border-r">Nombre del cliente</td>
                    <td class="py-3 px-6 text-left border-r">Tipo de servicio</td>
                    <td class="py-3 px-6 text-left border-r">Descripcion</td>
                    <td class="py-3 px-6 text-left border-r">Modelo</td>
                    <td class="py-3 px-6 text-left border-r">Fecha de venta</td>
                    <td class="py-3 px-6 text-left border-r">Costo total</td>
                </tr>
                @foreach ($servicios as $servicio)
                    <tr class= " border-b border-gray-200 text-sm">
                        <td class="px-6 py-4">
                            {{ $servicio->nombre_cliente }} {{ $servicio->apellido_cliente }}
                        </td>
                        <td class=" px-6 py-4">
                            {{ $servicio->tipo_de_proyecto }}</td>
                        <td class="px-6 py-4">
                            {{ $servicio->descripcion }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $servicio->modelo }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $servicio->fecha_creacion }}
                        </td>
                        <td class="px-6 py-4">
                            $ {{ $servicio->precio_unitario * $servicio->cantidad }}
                        </td>
                        <td>
                            <button
                                class="abrirModalEditar border rounded px-6 py-4 bg-green-500 text-white cursor-pointer hover:bg-green-700 transition duration-200 ease-in-out">
                                <i class="fas fa-edit"></i>
                            </button>

                        </td>
                        <td>
                            <button
                                class="border rounded px-6 py-4 bg-red-500 text-white cursor-pointer hover:bg-red-700 transition duration-200 ease-in-out">
                                <i class="fas fa-trash"></i></button>
                        </td>

                    </tr>
                    <!-- Aquí deberías mostrar otros datos del producto -->
                @endforeach
            </table>
            <div class=" mt-3">
                {{ $servicios->links() }} <!-- Esto mostrará los enlaces de paginación -->
            </div>
    </main>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
@stop

@section('js')
    <script>
        /*
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
                            });*/

        function changeColor() {
            var select = document.getElementById('colorSelect');
            select.style.color = select.value;
        }
    </script>
@stop
