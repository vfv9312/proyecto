@extends('layouts.admin')

@section('title', 'Agregar direcciones')

@section('content')
    <h1 class="text-center ">Editar descuento</h1>



    <form class="flex flex-col items-center justify-center mt-8" action="{{ route('descuentos.update', $descuento->id) }}"
        method="POST">
        @csrf
        @method('PUT')
        @include('descuentos._form')
    </form>

@endsection
@push('css')
    <!--Font Awesome para los iconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@endpush

@push('js')
    <script></script>
@endpush
