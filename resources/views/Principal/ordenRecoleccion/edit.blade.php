@extends('adminlte::page')

@section('title', 'estatus')

@section('content_header')
    <h1>Estatus</h1>
@stop

@section('content')
    <form class=""
        action="{{ route('orden_recoleccion.edit', ['orden_recoleccion' => $datosEnvio->idOrden_recoleccions]) }}"
        method="GET">
        @csrf
        @include('Principal.ordenRecoleccion._form_edit');
    </form>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@stop

@section('js')
    <script>
        var servicio = {!! json_encode($datosEnvio->estatusPreventa) !!};


        function mostrarInputCosto(value) {
            var inputCosto = document.getElementById('inputCosto');
            let inputFactura = document.querySelector('#inputFactura');
            let inputmetodopago = document.querySelector('#inputmetodopago');
            if (value == '2' && servicio ==
                4) { // Si el valor seleccionado es "En entrega" y el estatus de preventa es servicio
                inputCosto.style.display = 'block';
                inputFactura.style.display = 'flex';
                inputmetodopago.style.display = 'block'

            } else {
                inputCosto.style.display = 'none';
                inputFactura.style.display = 'none';
                inputmetodopago.display = 'none';
            }
        }
    </script>
@stop
