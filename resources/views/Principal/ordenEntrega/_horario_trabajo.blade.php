<section class=" w-full border-4 mt-8 px-3 pb-3">
    <div>
        <h1 class="text-2xl
    text-center font-bold text-green-700 mb-2">Horario de Trabajo</h1>
    </div>
    <div class=" flex lg:flex-row flex-col justify-center">

        {{-- @foreach (['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'] as $dia) --}}
        @foreach (['Lunes-Viernes', 'Sabado', 'Domingo'] as $dia)
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2 mr-3" for="{{ $dia }}_entrada">
                    {{ $dia }} - Hora de entrada
                </label>
                <input
                    class="shadow appearance-none border rounded w-3/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="{{ $dia }}_entrada" type="time" name="{{ $dia }}_entrada">

                <label class="block text-gray-700 text-sm font-bold mb-2 mt-4 mr-3" for="{{ $dia }}_salida">
                    {{ $dia }} - Hora de salida
                </label>
                <input
                    class="shadow appearance-none border rounded w-3/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="{{ $dia }}_salida" type="time" name="{{ $dia }}_salida">
            </div>
        @endforeach
    </div>
    {{-- <div class="text-center mt-4">
        <button type="button" id="lunesAViernes"
            class="px-4 py-2 bg-green-500 hover:bg-green-700 text-white rounded">Lunes a
            Viernes</button>
    </div> --}}
    <div class="text-center mt-4">
        <button type="button" id="resetButton"
            class="px-4 py-2 bg-green-600 text-white hover:bg-green-700 rounded">Restablecer
            horarios</button>
    </div>
</section>
