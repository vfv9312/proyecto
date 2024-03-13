@extends('adminlte::page')

@section('title', 'recoleciion')

@section('content_header')
@stop

@section('content')
    <form class=" mt-16 flex flex-col justify-center" action="{{ route('orden_servicio.show', $preventa->id) }}"
        method="GET">
        @include('Principal.ordenServicio._form_carrito')
    </form>
@stop

@section('css')
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@stop

@section('js')
    <script>
        //ESTO SIRVE CUANDO ELIMINO UN PRODUCTO LO OCULTA Y LE PONE VALORES 0 A CANTIDAD Y LA MULTIPLICACION Y AL FINAL RECALCULA LA SUMA DEL TOTAL
        function eliminarProducto(elemento, index) {
            var cantidades = document.querySelectorAll('.cantidad');
            var resultados = document.querySelectorAll('.valorProducto');
            var totalElement = document.querySelector('.total');

            // Obtener el input de cantidad correspondiente al producto eliminado
            var inputCantidad = elemento.querySelector('input[name="cantidad[]"]');
            // Establecer su valor a 0
            inputCantidad.value = 0;

            // Obtener el párrafo con id "valorProducto" correspondiente al producto eliminado
            var valorProducto = elemento.querySelector('#valorProducto');
            // Establecer su texto a 0
            valorProducto.textContent = '0';

            // Marcar el input de eliminación como 1 para indicar que se ha eliminado
            var inputEliminacion = elemento.querySelector('input[name="eliminacion[]"]');
            inputEliminacion.value = 1;
            // Ocultar el elemento (opcional)
            elemento.style.display = 'none';

        }
    </script>
@stop
