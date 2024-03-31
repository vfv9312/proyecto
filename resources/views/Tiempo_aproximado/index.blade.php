@extends('adminlte::page')

@section('title', 'Orden de entrega')

@section('content_header')
    <h1 class=" text-center"> Puede ingresar el tiempo aproximado de espera del servicio del dia de hoy {{ date('d/m/Y') }}
    </h1>
@stop

@section('content')
    <section>
        <div>
            @if ($errors->any())
                <div id="error-alert" class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="GET" action="{{ route('TiempoAproximado.create') }}">
                @csrf
                <div class="flex flex-col justify-center items-center mb-4">
                    <label for="tiempo" class="block text-gray-700 text-sm font-bold mb-2">Tiempo aproximado de atención
                        (Horas:Minutos)</label>
                    <input type="time"
                        class="shadow appearance-none border rounded w-1/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="tiempo" name="tiempo" value="00:15">
                    @error('tiempo')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mt-7"><i
                            class=" fas fa-save"></i> Guardar</button>
                </div>

            </form>
        </div>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@stop

@section('js')
    <script>
        setTimeout(function() {
            const errorAlert = document.getElementById('error-alert');
            if (errorAlert) {
                errorAlert.style.display = 'none';
            }
        }, 2000); // 5000 milisegundos = 5 segundos
    </script>
@stop
