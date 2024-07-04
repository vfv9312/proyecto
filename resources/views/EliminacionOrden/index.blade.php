@extends('layouts.admin')

@section('title', 'Eliminacion')

@section('content')
    <h1 class=" text-center mb-5">Ordenes de Entrega/Servicio</h1>
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
    <form id="formularioBusqueda" method="GET">
        @include('Principal.ordenRecoleccion._filtros')
    </form>
    @include('EliminacionOrden._modal')
    @include('EliminacionOrden._checbox')
    @include('EliminacionOrden._tabla')
@endsection

@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome para los iconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@push('js')
    <script>
        document.getElementById('BotonFiltrar').addEventListener('click', function() {
            document.querySelector('#formularioBusqueda').action = "{{ route('ordeneliminacion.index') }}";
        });

        //Oculta los elementos de alerta despues de 3 segundos
        window.setTimeout(function() {
            var alertCorrecto = document.getElementById('alert-correcto');
            var alertIncorrect = document.getElementById('alert-incorrect');
            if (alertCorrecto) alertCorrecto.style.display = 'none';
            if (alertIncorrect) alertIncorrect.style.display = 'none';
        }, 3000);


        //esto funciona para mostrar el boton de eliminar siempre y cuando este seleccionado
        let preventas = @json($preventas->toArray());
        //seleccionamos todo si seleccionamos el checkbox con mmostrar boton
        document.getElementById('orange-checkbox').addEventListener('change', function() {
            preventas.data.forEach(element => {
                let checkboxes = document.getElementById(element.idPreventa);
                checkboxes.checked = this.checked;
                MostrarBotonElimnar()

            });
        });

        let checkTickets = document.querySelectorAll('.seleccionador');
        //apareceremos el boton o no dependiendo
        function MostrarBotonElimnar() {
            let algunoSeleccionado = Array.from(checkTickets).some(c => c.checked);
            if (algunoSeleccionado) {
                document.querySelector('#contenedorBotoneliminar').classList.remove('hidden');
            } else {
                document.querySelector('#contenedorBotoneliminar').classList.add('hidden');
            }
        }
        //llamamos la funcion para ocultar o mostrar los cambios si el checkbox esta seleccionado
        checkTickets.forEach(function(checkbox) {

            checkbox.addEventListener('change', MostrarBotonElimnar);
        });
        //AQUI TERMINA TODO EL APARTADO DE LOS CHECKBOX PARA MOSTRAR EL BOTON DE ELIMINAR


        // Obtén los elementos del DOM para abrir y cerrar el modal
        const modal = document.querySelector('#modal')
        const abrirnModal = document.querySelector('#botonEliminar');

        const cancelarModal = document.querySelector('.cerrarmodal');

        //Abre el modal para registrar un producto
        abrirnModal.addEventListener('click', function() {
            modal.classList.remove('hidden');

            // Obtén todos los checkboxes
            let checkboxes = document.querySelectorAll('.seleccionador');

            // Filtra los checkboxes para obtener solo los seleccionados
            let checkboxesSeleccionados = Array.from(checkboxes).filter(c => c.checked);

            // Obtén los ID de los checkboxes seleccionados
            let idsSeleccionados = checkboxesSeleccionados.map(c => c.id);


            // Crea un input oculto
            let inputOculto = document.createElement('input');
            inputOculto.type = 'hidden';
            inputOculto.name = 'idPreventas';
            inputOculto.value = idsSeleccionados.join(',');

            // Agrega el input oculto al DOM
            document.querySelector('#checkboxSeleccionado').appendChild(inputOculto);


        });

        // Escucha el evento de click en el botón cancelar Modal de registro
        cancelarModal.addEventListener('click', function() {
            // Oculta el modal
            modal.classList.add('hidden');
        });
        //AQUI TERMINA EL MODAL
    </script>
@endpush
