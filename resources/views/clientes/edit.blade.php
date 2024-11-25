@extends('layouts.admin')

@section('title', 'Editar cliente')

@section('content')
    <h1 class="font-bold text-center ">Editar cliente</h1>



    <form class="flex flex-col items-center justify-center mt-8"
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
    <script>
            function toggleApellidoInput() {
        const checkbox = document.getElementById('tipoDeCliente');
        console.log(checkbox.checked);

        const apellidoInput = document.getElementById('apellidoInput');

        if (!checkbox.checked) {
            apellidoInput.classList.remove('hidden');
        } else {
            apellidoInput.classList.add('hidden');
        }
    }

    // Inicializar la visibilidad del input al cargar la página
    document.addEventListener('DOMContentLoaded', (event) => {
        toggleApellidoInput();
    });
    </script>
@endpush
