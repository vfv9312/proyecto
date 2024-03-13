@extends('adminlte::page')

@section('title', 'Orden de recoleccion')

@section('content_header')

@stop

@section('content')
    <form action="{{ route('generarpdf.ordenservicio', ['id' => $recoleccion->id]) }}" method="GET">
        @csrf
        @include('Principal.ordenServicio._form_completado')

        <div class="flex
            justify-center mt-8">
            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-700">
                <i class="fas fa-file-pdf"></i>
                Ver pdf
            </button>
        </div>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
