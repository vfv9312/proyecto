@extends('layouts.admin')

@section('title', 'Tiempo aproximado')

@section('content')
    <h1 class=" text-center"> Puede ingresar el tiempo aproximado de espera del servicio del dia de hoy
        {{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd') }}, fecha {{ date('d/m/Y') }}
    </h1>
    <section>
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
                        (Horas:Minutos) ejemplo 01:20 es una hora con veinte minutos de tiempo aproximado del
                        servicio</label>
                    <input type="text"
                        class="shadow appearance-none border rounded w-1/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="tiempo" name="tiempo" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]"
                        @if ($existeTiempoHoy) value="{{ substr($existeTiempoHoy->tiempo, 0, 5) }}" @endif>
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
        @if ($existeTiempoHoy)
            <div class=" text-center">
                <p class=" text-4xl font-bold "> Hoy {{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd') }} del
                    {{ \Carbon\Carbon::parse($existeTiempoHoy->created_at)->format('Y-m-d') }} a las
                    {{ \Carbon\Carbon::parse($existeTiempoHoy->created_at)->format('H:i:s') }} .</p>

                El tiempo de espera asignado es de <p class=" text-6xl font-extrabold">
                    {{ substr($existeTiempoHoy->tiempo, 0, 5) }}</p>
                {{ \Carbon\Carbon::parse($existeTiempoHoy->tiempo)->locale('es')->isoFormat('H [horas] m [minutos]') }}
            </div>
        @endif
    </section>

    @include('Tiempo_aproximado._tabla')
@endsection

@push('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome para los iconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
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

        document.getElementById('tiempo').addEventListener('input', function(e) {
            var input = e.target.value;
            var match = input.match(/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/);
            if (!match) {
                e.target.setCustomValidity(
                    'Por favor, introduce un tiempo válido en formato HH:MM, ejemplo 02:00 que equivale 2 horas.'
                );
            } else {
                e.target.setCustomValidity('');
            }
        });

        setTimeout(function() {
            const errorAlert = document.getElementById('error-alert');
            if (errorAlert) {
                errorAlert.style.display = 'none';
            }
        }, 2000); // 5000 milisegundos = 5 segundos
    </script>
@endpush
