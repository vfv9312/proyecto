@extends('layouts.admin')

@section('title', 'Categoria')

@section('content')
    <h1 class=" font-bold text-center mb-8">Categorias</h1>

    <form class="mt-8 flex flex-col justify-center items-center" action="{{ route('categorias.update', $categoria) }}"
        method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('Categoria._form')
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
