@extends('layouts.admin')

@section('title', 'Clave')

@section('content')
    <!-- mensaje de aviso que se registro el producto-->
    @if (session('correcto'))
        <div class=" flex justify-center">
            <div id="alert-correcto" class="bg-green-500 bg-opacity-50 text-white px-4 py-2 rounded mb-8 w-64 ">
                {{ session('correcto') }}
            </div>
        </div>
    @endif
    @if (session('incorrect'))
        <div id="alert-incorrect" class="bg-red-500 text-white px-4 py-2 rounded">
            {{ session('incorrect') }}
        </div>
    @endif
    <h1 class=" text-center ">Crear clave para autorización de eliminacion</h1>
    @include('ClaveEliminacion._clave')
    <div class=" text-center">
        <span class=" text-2xl font-bold text-green-800 mb-5">Clave activa :
            <input id="claveActual" type="password"
                value="{{ $ultimoRegistro ? $ultimoRegistro->clave : 'No hay claves registradas' }}">
            <i id="toggleClaveActual" class="fa fa-eye"></i></span>
    </div>
    @include('ClaveEliminacion._tabla')
    <div>


    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Incluye jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Incluye Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Incluye Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
@endpush

@push('js')
    <script>
        //Oculta los elementos de alerta despues de 3 segundos
        window.setTimeout(function() {
            var alertCorrecto = document.getElementById('alert-correcto');
            var alertIncorrect = document.getElementById('alert-incorrect');
            if (alertCorrecto) alertCorrecto.style.display = 'none';
            if (alertIncorrect) alertIncorrect.style.display = 'none';
        }, 3000);

        document.getElementById('generateButton').addEventListener('click', generarNumerosAleatorios)

        function generarNumerosAleatorios() {

            document.getElementById('code-1').value = Math.floor(Math.random() * 10);
            document.getElementById('code-2').value = Math.floor(Math.random() * 10);
            document.getElementById('code-3').value = Math.floor(Math.random() * 10);
            document.getElementById('code-4').value = Math.floor(Math.random() * 10);
            document.getElementById('code-5').value = Math.floor(Math.random() * 10);
            document.getElementById('code-6').value = Math.floor(Math.random() * 10);
        };

        document.getElementById('toggleClaveActual').addEventListener('click', function() {
            var claveInput = document.getElementById('claveActual');
            if (claveInput.type === 'password') {
                claveInput.type = 'text';
            } else {
                claveInput.type = 'password';
            }
        });

        let idClaves = @json($claves->toArray());
        idClaves.data.forEach(element => {
            document.getElementById('toggleClave' + element.id).addEventListener('click', function() {
                var claveInput = document.getElementById('clave' + element.id);
                if (claveInput.type === 'password') {
                    claveInput.type = 'text';
                } else {
                    claveInput.type = 'password';
                }
            });
        });
    </script>
@endpush
