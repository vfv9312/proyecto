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
    @include('Principal.ordenEntrega._filtro_articulo')

    <form action="{{ route('orden_entrega.store') }}" method="POST">
        @csrf
        <header class=" flex justify-between p-3">
            <h1>Productos</h1> <button type="submit" id="compras"
                class="fa fa-shopping-bag fa-2x text-red-500 cursor-pointer"><span
                    class="incrementar ml-2 text-sm text-green-500">0</span></button>
        </header>
        @include('Principal.ordenEntrega._articulos')

    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
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
            $('#marca, #tipo').on('change', function() { // Cambiar a #marca y #tipo
                console.log('Cambio detectado');

                var marcaFiltro = $('#marca').val(); // Cambiar a #marca
                var tipoFiltro = $('#tipo').val(); // Cambiar a #tipo

                console.log(marcaFiltro);

                $('.producto').each(function() {
                    var marca = $(this).data('marca');
                    var tipo = $(this).data('tipo');

                    if ((marcaFiltro === "" || marcaFiltro == marca) && (tipoFiltro === "" ||
                            tipoFiltro == tipo)) {
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

        document.addEventListener('DOMContentLoaded', function() {
            // Obtener el span y todos los inputs con la clase "suma"
            var spanIncrementar = document.querySelector('.incrementar');
            var inputsSuma = document.querySelectorAll('.suma');

            // Agregar evento de escucha a todos los inputs
            inputsSuma.forEach(function(input) {
                input.addEventListener('input', function() {
                    // Calcular la suma total de todos los inputs
                    var sumaTotal = 0;
                    inputsSuma.forEach(function(input) {
                        sumaTotal += parseInt(input.value) ||
                            0; // Asegurarse de que el valor sea un número válido
                    });

                    // Actualizar el contenido del span con la suma total
                    spanIncrementar.textContent = sumaTotal;
                });
            });
        });
    </script>
@stop
