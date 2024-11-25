@extends('layouts.admin')

@section('title', 'Cancelación')

@section('content')
    <h1 class="mb-8 text-center ">Cancelación</h1>
    <form action="{{ route('orden_recoleccion.cancelar', $datosEnvio->idPreventa) }}" method="POST">
        @csrf
        @method('PUT')
        @include('Principal.ordenRecoleccion._form_cancelado');
    </form>
@endsection

@push('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome para los iconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@push('js')
    <script></script>
@endpush
