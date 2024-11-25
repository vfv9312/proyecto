@extends('layouts.admin')

@section('title', 'Categoria')

@section('content')
    <h1 class="mb-8 font-bold text-center ">Metodo de pago</h1>

    <form class="flex flex-col items-center justify-center mt-8" action="{{ route('metodopago.update', $metodoDePago) }}"
        method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('MetodoPago._form')
    </form>
@endsection

@push('css')
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
@endpush

@push('js')
    <script></script>
@endpush
