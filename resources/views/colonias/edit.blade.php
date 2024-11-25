@extends('layouts.admin')

@section('title', 'Colonias')

@section('content')
    <h1 class="text-center ">Editar colonias</h1>


    <form class="flex flex-col items-center justify-center mt-8" action="{{ route('colonias.update', $coloniasTuxtla->id) }}"
        method="POST">
        @csrf
        @method('PUT')
        @include('colonias._formedit')
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
