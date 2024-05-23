@extends('layouts.admin')

@section('title', 'Editar cliente')

@section('content')
    <h1 class=" font-bold text-center">Editar cliente</h1>



    <form class="mt-8 flex flex-col justify-center items-center"
        action="{{ route('clientes.update', $cliente, $persona, $direcciones, $catalogo_colonias) }}" method="POST"
        enctype="multipart/form-data">
        @method('PUT')
        @include('clientes._form')
    </form>
@endsection

@push('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endpush

@push('js')
    <script></script>
@endpush
