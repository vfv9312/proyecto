<section class="w-full px-3 pb-3 mt-8 border-4 ">
    <div>
        <h1 class="mb-2 text-2xl font-bold text-center text-green-700">Horario de Trabajo</h1>
    </div>
    <div class="flex flex-col justify-center lg:flex-row">

        {{-- @foreach (['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'] as $dia) --}}
        @foreach (['Lunes-Viernes', 'Sabado', 'Domingo'] as $dia)
            <div class="mb-4">
                <label class="block mb-2 mr-3 text-sm font-bold text-gray-700" for="{{ $dia }}_entrada">
                    {{ $dia }} - Hora de entrada
                </label>
                <input
                    class="w-3/4 px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="{{ $dia }}_entrada" type="time" name="{{ $dia }}_entrada">

                <label class="block mt-4 mb-2 mr-3 text-sm font-bold text-gray-700" for="{{ $dia }}_salida">
                    {{ $dia }} - Hora de salida
                </label>
                <input
                    class="w-3/4 px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="{{ $dia }}_salida" type="time" name="{{ $dia }}_salida">
            </div>

            <div id="horarioDiscontinuo" class="mb-4 border-4 border-green-500 border-double">
                <h2 class="mt-4 mb-2 text-2xl font-semibold text-green-600 underline">Horario Partido</h2>
                <label class="block mb-2 mr-3 text-sm font-bold text-gray-700" for="{{ $dia }}Discontinuo_entrada">
                    {{ $dia }} - Hora de entrada
                </label>
                <input
                    class="w-3/4 px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="{{ $dia }}Discontinuo_entrada" type="time" name="{{ $dia }}Discontinuo_entrada">

                <label class="block mt-4 mb-2 mr-3 text-sm font-bold text-gray-700" for="{{ $dia }}Discontinuo_salida">
                    {{ $dia }} - Hora de salida
                </label>
                <input
                    class="w-3/4 px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="{{ $dia }}Discontinuo_salida" type="time" name="{{ $dia }}Discontinuo_salida">
            </div>
        @endforeach
    </div>

    <div class="mt-4 text-center">
        <button type="button" id="resetButton"
            class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">Restablecer
            horarios</button>
    </div>
</section>
