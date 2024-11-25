@extends('layouts.admin')

@section('title', 'Orden servicio')

@section('content')
    <style>
        input[type="text"] {
            text-transform: uppercase;
        }
    </style>

    <h1 class="text-xl font-bold text-center ">Registro de Orden de Servicio</h1>
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

    <form id="formulario" class="flex flex-col justify-center mt-8 lg:ml-4" action="{{ route('orden_servicio.store') }}"
        method="POST">
        @csrf

        @include('Principal.ordenServicio._form_cliente')
        @include('Principal.ordenServicio._modal')
        @include('Principal.ordenServicio._modal_Descuentos')
        @include('Principal.ordenServicio._Lista_Productos')
        @include('Principal.ordenServicio._carro_campras')
        @include('Principal.ordenServicio._form_datos_adicionales')

        <div class="flex justify-center mt-4">
            <button id="botonGuardar" type="submit"
                class="px-4 py-2 text-white bg-green-500 rounded hover:bg-green-700">
                <i class="mr-2 fas fa-save"></i>
                Guardar
            </button>
        </div>
    </form>
    @include('Principal.ordenEntrega._modal_nuevo_producto')
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
            let productRecargaUrl = "{{ route('product.Recarga') }}";
            var datosClientes = @json($listaClientes);
            var datosDirecciones = @json($listaDirecciones);
            let datosAtencion = @json($listaAtencion);

            let detallesProductoNuevoUrl = "{{ route('orden_recoleccion.detallesproducto') }}";
             let detallesProductoUrl = "{{ route('orden_recoleccion.detallesproducto') }}";
            let rutaGuardarProductoAjax = "{{ route('ordenEntrega.guardarProducto') }}"
    </script>
    <script src="{{ asset('js/Servicio.js') }}"></script>
@endpush
