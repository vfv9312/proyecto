@extends('adminlte::page')

@section('title', 'Articulos')

@section('content_header')

@stop

@section('content')
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

    @include('Principal.ordenEntrega._modal')

    <form action="{{ route('orden_entrega.store') }}" method="POST">
        @csrf
        <header class=" flex justify-between p-3">
            <button id="toggle-filters" type="button"
                class="mt-4 mb-4 bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-filter"></i> Añadir Filtros
            </button>
            <button type="submit" id="compras" class="fa fa-shopping-bag fa-2x text-red-500 cursor-pointer"><span
                    id="totalSpan" class="incrementar ml-2 text-sm text-green-500">0</span></button>
        </header>
        @include('Principal.ordenEntrega._filtro_articulo')
        @include('Principal.ordenEntrega._articulos')

    </form>
@stop

@section('css')
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome para los iconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@stop

@section('js')
    <script>
        //BUSCA POR LOS DATOS DE SELECT
        $(document).ready(function() {
            $('#color ,#modo ,#marca, #tipo').on('change', function() { // Cambiar a #marca y #tipo
                console.log('Cambio detectado');

                var marcaFiltro = $('#marca').val(); // Cambiar a #marca
                var tipoFiltro = $('#tipo').val(); // Cambiar a #tipo
                var modoFiltro = $('#modo').val(); // Cambiar a #tipo
                var colorFiltro = $('#color').val(); // Cambiar a #tipo



                $('.producto').each(function() {
                    var marca = $(this).data('marca');
                    var tipo = $(this).data('tipo');
                    var modo = $(this).data('modo');
                    var color = $(this).data('color');

                    if ((marcaFiltro === "" || marcaFiltro == marca) &&
                        (tipoFiltro === "" || tipoFiltro == tipo) &&
                        (colorFiltro === "" || colorFiltro == color) &&
                        (modoFiltro === "" || modoFiltro == modo)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
            //BUSCA POR NOMBRE
            $('#miBuscador').on('input', function() {
                var searchText = $(this).val().toLowerCase();

                $('.producto').each(function() {
                    var productoNombre = $(this).data('nombre').toLowerCase();

                    if (productoNombre.includes(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });

        //mostrar y ocultar los filtros
        document.getElementById('toggle-filters').addEventListener('click', function() {
            var filtersSection = document.getElementById('filters-section');
            if (filtersSection.style.display === "none") {
                filtersSection.style.display = "block";
            } else {
                filtersSection.style.display = "none";
            }
        });
        /*
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener el span para la suma total de compras y todos los inputs con la clase "suma"
            var spanTotalCompras = document.getElementById('totalCompras');
            var inputsSuma = document.querySelectorAll('.suma');

            // Función para calcular la suma total de todos los inputs
            function calcularTotalCompras() {
                var sumaTotal = 0;
                inputsSuma.forEach(function(input) {
                    sumaTotal += parseInt(input.value) ||
                        0; // Asegurarse de que el valor sea un número válido
                });
                return sumaTotal;
            }

            // Agregar evento de escucha a todos los inputs para actualizar la suma total
            inputsSuma.forEach(function(input) {
                input.addEventListener('input', function() {
                    // Actualizar el contenido del span con la suma total
                    spanTotalCompras.textContent = calcularTotalCompras();
                });
            });

        });*/

        function actualizarTotal() {

            var inputs = document.querySelectorAll('.suma');
            let totalSpan = document.querySelector('#totalSpan');
            var total = 0;
            console.log(inputs);
            inputs.forEach(function(input) {
                total += parseInt(input.value);
            });
            totalSpan.textContent = total;
        }


        function incrementar(button) {
            var input = button.parentNode.querySelector('.suma');
            var currentValue = parseInt(input.value);
            input.value = currentValue + 1;
            actualizarTotal();
        }

        function decrementar(button) {
            var input = button.parentNode.querySelector('.suma');
            var currentValue = parseInt(input.value);
            if (currentValue > 0) {
                input.value = currentValue - 1;
                actualizarTotal();
            }
        }

        document.getElementById('compras').addEventListener('click', function(event) {
            var total = document.getElementById('totalSpan').innerText;
            if (total === '0') {
                event.preventDefault();
                alert('No has seleccionado nada.');
            }
        });
    </script>
@stop
