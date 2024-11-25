@extends('layouts.admin')

@section('title', 'Inicio')

@section('content')

<h1 class="font-bold text-center text-green-700 ">Metodo de pago</h1>

        <!-- mensaje de aviso que se registro el producto-->
        @if (session('correcto'))
        <div class="flex justify-center ">
            <div id="alert-correcto" class="w-64 px-4 py-2 mb-8 text-white bg-green-500 bg-opacity-50 rounded ">
                {{ session('correcto') }}
            </div>
        </div>
    @endif
    @if (session('incorrect'))
        <div id="alert-incorrect" class="px-4 py-2 text-white bg-red-500 rounded">
            {{ session('incorrect') }}
        </div>
    @endif

    @include('MetodoPago._filtro')
    <!-- boton anadir producto-->
    <button id="abrirnModalRegisrar"
        class="flex items-center px-4 py-2 mb-4 font-bold text-white rounded-full bg-gradient-to-r from-gray-800 via-gray-600 to-green-500">
        <i class="mr-2 fas fa-cash-register"></i>

        Añadir Metodo De Pago
    </button>

    @include('MetodoPago._modal')

    <!--tabla-->
    <section class="overflow-x-auto">
        <!--La clase overflow-x-auto hace que el div tenga un desplazamiento horizontal si su contenido es demasiado ancho para caber en la pantalla-->
        <table class="min-w-full">
            <!--La clase min-w-full hace que la tabla tenga al menos el ancho completo de su contenedor, lo que significa que se desplazará horizontalmente si es necesario.-->
            <tr class="text-xs font-bold leading-normal text-black uppercase">
                <td class="px-6 py-3 text-left border-r">Nombre</td>
                <td class="px-6 py-3 text-left border-r">Fecha creacion</td>
                <td class="px-6 py-3 text-left border-r">Fecha Actualización</td>
            </tr>
            @foreach ($metodosDePagos as $metodoPago)
                <tr class= "text-sm border-b border-gray-200 ">
                    <td class="px-6 py-4 ">
                        {{ $metodoPago->nombre }}</td>
                    <td class="px-6 py-4">
                        {{ $metodoPago->created_at }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $metodoPago->updated_at }}
                    </td>
                    <td>

                        <button onclick="location.href='{{ route('metodopago.edit', $metodoPago->id) }}';"
                            class="px-6 py-4 text-white transition duration-200 ease-in-out bg-green-500 border rounded cursor-pointer abrirModalEditar hover:bg-green-700">
                            <i class="fas fa-sync"></i>
                        </button>

                    </td>
                    <td>
                        <form action="{{ route('metodopago.desactivar', $metodoPago->id) }}" method="POST"
                            onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                            @csrf
                            @method('PUT')
                            <button
                                class="px-6 py-4 text-white transition duration-200 ease-in-out bg-red-500 border rounded cursor-pointer hover:bg-red-700">
                                <i class="fas fa-trash"></i></button>
                        </form>
                    </td>

                </tr>
                <!-- Aquí deberías mostrar otros datos del producto -->
            @endforeach
        </table>
        <div class="mt-3 ">
            <p>Total de resultados: {{ $metodosDePagos->total() }}</p> <!--mostrar total de resultados-->
            {{ $metodosDePagos->links() }} <!-- Esto mostrará los enlaces de paginación -->
        </div>
    </section>


@endsection



@push('css')

    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome para los iconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endpush

@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
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
        const modalRegistrar = document.querySelector('#modalRegistrarNuevo')
        const abrirModalEditar = document.querySelectorAll('.abrirModalEditar');
        const abrirnModalRegisrar = document.querySelector('#abrirnModalRegisrar');

        const cancelarModal = document.querySelector('.cerrarmodal');
       // const cancelarModalEditar = document.querySelector('#cerrarModalEditar');

        // Selecciona todos los botones con la clase '.openModalButton'
       // abrirModalEditar.forEach(button => {
        //    button.addEventListener('click', function() {
                // Muestra el modal
             //   modalEditarRegistro.classList.remove('hidden');
          //  });
       // });
        //Abre el modal para registrar un producto
        abrirnModalRegisrar.addEventListener('click', function() {
            modalRegistrar.classList.remove('hidden');
        });

        // Escucha el evento de click en el botón cancelar Modal de registro
       cancelarModal.addEventListener('click', function() {
            // Oculta el modal
            modalRegistrar.classList.add('hidden');
        });

        // Escucha el evento de click en el botón cancelar Modal de Editar
       // cerrarModalEditar.addEventListener('click', function() {

            // Oculta el modal
         //   modalEditarRegistro.classList.add('hidden');
       // });
    </script>
</script>


@endpush
