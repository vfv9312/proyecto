@extends('adminlte::page')

@section('title', 'empleados')

@section('content_header')
    <h1>Empleados</h1>
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

        <!--tabla-->
        <section class="overflow-x-auto">
            <!--La clase overflow-x-auto hace que el div tenga un desplazamiento horizontal si su contenido es demasiado ancho para caber en la pantalla-->
            <table class="min-w-full">
                <!--La clase min-w-full hace que la tabla tenga al menos el ancho completo de su contenedor, lo que significa que se desplazará horizontalmente si es necesario.-->
                <tr class=" text-black uppercase text-xs  font-bold leading-normal">
                    <td class="py-3 px-6 text-left border-r">Nombre</td>
                    <td class="py-3 px-6 text-left border-r">Rol</td>
                    <td class="py-3 px-6 text-left border-r">Telefono</td>

                </tr>
                @foreach ($empleados as $empleado)
                    <tr class= " border-b border-gray-200 text-sm">
                        <td class=" px-6 py-4">
                            {{ $empleado->nombre }} {{ $empleado->apellido }}</td>
                        <td class="px-6 py-4">
                            {{ $empleado->nombreRol }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $empleado->telefono }}
                        </td>
                        <input type="hidden" name="miDato" value="{{ $empleado->id_rol }}">

                        <td class="flex">

                            <form action="{{ route('Restablecer.actualizarEmpleado', $empleado->id) }}" method="POST"
                                onsubmit="return confirm('¿Estás seguro de que quieres restaurar este empleado?');">
                                @csrf
                                @method('PUT')
                                <button title="Restablecer"
                                    class="border rounded px-6 py-4 bg-green-500 text-white cursor-pointer hover:bg-red-700 transition duration-200 ease-in-out">
                                    <i class="fas fa-redo"></i></button>
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
    </main>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
@stop

@section('js')
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
@stop
