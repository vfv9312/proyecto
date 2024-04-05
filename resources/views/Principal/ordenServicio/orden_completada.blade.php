@extends('adminlte::page')

@section('title', 'Orden de recoleccion')

@section('content_header')
    <h1 class=" text-center">Orden de Servicio {{ $ordenRecoleccion->letraActual }}
        {{ sprintf('%06d', $ordenRecoleccion->ultimoValor) }}</h1>
@stop

@section('content')

    @include('Principal.ordenServicio._form_completado')

    <div class="flex justify-center mt-8">
        <a target="_blank"
            class="mb-2 sm:mb-0 sm:mr-2 items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150"
            href="{{ route('generarpdf.ordenservicio', ['id' => $ordenRecoleccion->idRecoleccion]) }}">
            <i class="fas fa-file-pdf"></i>
            Ver pdf
        </a>

        <button type="button"
            onclick="window.location.href='{{ route('vistaPrevia.ordenservicio', ['id' => $ordenRecoleccion->idRecoleccion]) }}'"
            class="mb-2 sm:mb-0 sm:mr-2 items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
            <i class="fas fa-eye"></i>
            Vista previa
        </button>

        <a href='{{ route('Correo.enviar', ['id' => $ordenRecoleccion->idRecoleccion]) }}' target="_blank"
            class="mb-2 sm:mb-0 sm:mr-2 items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
            <i class="fas fa-envelope"></i>
            Correo
        </a>

        <a href='{{ route('WhatsApp.enviar', ['id' => $ordenRecoleccion->idRecoleccion]) }}' target="_blank"
            class="mb-2 sm:mb-0 sm:mr-2 items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
            <i class="fab fa-whatsapp"></i>
            WhatsApp
        </a>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@stop

@section('js')
    <script></script>
@stop
