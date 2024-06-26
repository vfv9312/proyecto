@extends('layouts.admin')

@section('title', 'Recoleccion')

@section('content')
    <h1 class=" text-center mb-5">Ultimos ordenes de Entrega/Servicio</h1>
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
        @include('Principal.ordenRecoleccion._excel')
        @include('Principal.ordenRecoleccion._filtros')
    </form>
    @include('Principal.ordenRecoleccion._tabla_pendientes')
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
        document.getElementById('excel').addEventListener('click', function() {
            document.querySelector('#formularioBusqueda').action = "{{ route('ordenentrega.generarExcel') }}";
        });

        document.getElementById('BotonFiltrar').addEventListener('click', function() {
            document.querySelector('#formularioBusqueda').action = "{{ route('orden_recoleccion.index') }}";
        });

        //Oculta los elementos de alerta despues de 3 segundos
        window.setTimeout(function() {
            var alertCorrecto = document.getElementById('alert-correcto');
            var alertIncorrect = document.getElementById('alert-incorrect');
            if (alertCorrecto) alertCorrecto.style.display = 'none';
            if (alertIncorrect) alertIncorrect.style.display = 'none';
        }, 3000);
    </script>
@endpush
