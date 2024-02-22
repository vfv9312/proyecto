@extends('adminlte::page')

@section('title', 'Editar producto')

@section('content_header')
    <h1>Registrar venta</h1>
@stop

@section('content')
    <!-- boton anadir servicio-->
    <button id="abrirnModalRegisrarProducto"
        class="mb-4 bg-gradient-to-r from-green-500 via-green-500 to-yellow-500 text-white font-bold py-2 px-4 rounded-full">
        Añadir producto
    </button>
    @include('servicios._modal')
    <form class="mt-8 flex flex-col justify-center items-center" action="{{ route('servicios.store') }}" method="POST">
        @csrf
        @include('servicios._form')
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@stop

@section('js')
    <script>
        var clientes = @json($clientes);
        var empleados = @json($empleados);

        function rellenarFormulario() {
            var clienteNombre = document.getElementById('clienteInput').value;
            var cliente = clientes.find(c => c.nombre == clienteNombre);

            if (cliente) {
                document.getElementById('nombreInput').value = cliente.nombre;
                document.getElementById('apellidoInput').value = cliente.apellido;
                document.getElementById('telefonoInput').value = cliente.telefono;
                document.getElementById('clienteId').value = cliente.id; // Establecer el valor del campo oculto
                // Rellenar otros campos del formulario...
            }
        }

        function rellenarFormularioEmpleado() {
            var empleadoNombre = document.getElementById('empleadoInput').value;
            var empleado = empleados.find(e => e.nombre == empleadoNombre);

            if (empleado) {
                document.getElementById('empleadoId').value = empleado.id; // Establecer el valor del campo oculto
            }
        }

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
@stop
