@extends('layouts.admin')

@section('title', 'Agregar direccion')

@section('content')
    <h1 class=" font-bold text-center">Agregar direcciones</h1>

    <form class="mt-8 flex flex-col justify-center items-center" action="{{ route('direcciones.update', $cliente) }}"
        method="POST">
        @method('PUT')
        @csrf
        @include('clientes.direcciones._form')
    </form>
@endsection

@push('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <!--select2-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#txtcolonia').select2();
        });
    </script>
@endpush
