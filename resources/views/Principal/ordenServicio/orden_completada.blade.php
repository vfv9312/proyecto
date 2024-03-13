@extends('adminlte::page')

@section('title', 'Orden de recoleccion')

@section('content_header')

@stop

@section('content')
    <form action="{{ route('generarpdf.ordenservicio', ['id' => $recoleccion->id]) }}" method="GET">
        @csrf
        @include('Principal.ordenServicio._form_completado')

        <div class="flex justify-center mt-8">
            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-700">
                <i class="fas fa-file-pdf"></i>
                Ver pdf
            </button>

    </form>

    <button type="button"
        onclick="window.location.href='{{ route('vistaPrevia.ordenservicio', ['id' => $recoleccion->id]) }}'"
        class="mr-8 ml-8 inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
        <i class="fas fa-eye"></i>
        Vista previa
    </button>

    <button type="button"
        onclick="window.location.href='{{ route('vistaPrevia.ordenservicio', ['id' => $recoleccion->id]) }}'"
        class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
        <i class="fas fa-paper-plane"></i>
        Enviar
    </button>
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
