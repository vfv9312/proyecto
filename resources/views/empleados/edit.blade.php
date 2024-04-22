@extends('layouts.admin')

@section('title', 'Empleado')

@section('content')
    <h1 class=" text-center font-bold">Editar empleado</h1>

    <form class="mt-8 flex flex-col justify-center items-center"
        onsubmit="return confirm('¿Estás seguro de que quieres actualizar los datos del empleado?');"
        action="{{ route('empleados.update', $empleado, $persona, $rol, $roles) }}" method="POST">
        @method('PUT')
        @include('empleados._form')
    </form>
@endsection

@push('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@endpush

@push('js')
    <script>
        console.log('Hi!');
        /*
         */
    </script>
@endpush
