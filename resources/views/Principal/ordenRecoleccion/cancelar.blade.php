@extends('layouts.admin')

@section('title', 'Cancelación')

@section('content')
    <h1 class=" text-center mb-8">Cancelación</h1>
    <form action="{{ route('orden_recoleccion.cancelar', $datosEnvio->idRecoleccion) }}" method="POST">
        @csrf
        @method('PUT')
        @include('Principal.ordenRecoleccion._form_cancelado');
    </form>
@endsection

@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@endpush

@push('js')
    <script></script>
@endpush
