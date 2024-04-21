<section class=" w-full border-4 mt-8 px-3 pb-3">
    <h1 class="text-2xl
    text-center text-gray-600 mb-2">Horario de Trabajo</h1>
    <div class=" flex w-full">
        <div class="flex flex-col w-full md:w-1/2">
            <label class="mr-4">De :</label>
            <input type="time"
                class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="horarioTrabajoInicio" name="horarioTrabajoInicio" required>
        </div>
        <div class="flex flex-col w-full md:w-1/2">
            <label class="mr-4">Hasta :</label>
            <input type="time"
                class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="horarioTrabajoFinal" name="horarioTrabajoFinal" required>
        </div>
    </div>
    <div class="flex flex-wrap justify-center">
        <label class="inline-flex items-center mr-3">
            <input type="checkbox" name="dias[]" value="Lunes">
            <span class="ml-2">Lunes</span>
        </label>
        <label class="inline-flex items-center mr-3">
            <input type="checkbox" name="dias[]" value="Martes">
            <span class="ml-2">Martes</span>
        </label>
        <label class="inline-flex items-center mr-3">
            <input type="checkbox" name="dias[]" value="Miércoles">
            <span class="ml-2">Miércoles</span>
        </label>
        <label class="inline-flex items-center mr-3">
            <input type="checkbox" name="dias[]" value="Jueves">
            <span class="ml-2">Jueves</span>
        </label>
        <label class="inline-flex items-center mr-3">
            <input type="checkbox" name="dias[]" value="Viernes">
            <span class="ml-2">Viernes</span>
        </label>
    </div>

    <div>
        <h1 class="text-2xl
        text-center text-gray-600 my-2">Sabado</h1>
        <div class=" flex w-full">
            <div class="flex flex-col w-full md:w-1/2">
                <label class="mr-4">De :</label>
                <input type="time"
                    class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="horarioTrabajoInicio" name="horarioTrabajoInicio" required>
            </div>
            <div class="flex flex-col w-full md:w-1/2">
                <label class="mr-4">Hasta :</label>
                <input type="time"
                    class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="horarioTrabajoFinal" name="horarioTrabajoFinal" required>
            </div>
        </div>
        <div class="flex flex-wrap justify-center">
            <label class="inline-flex items-center mr-3">
                <input type="checkbox" name="dias[]" value="Sábado">
                <span class="ml-2">Sábado</span>
            </label>
        </div>
    </div>
    <div>
        <h1 class="text-2xl
        text-center text-gray-600 my-2">Domingo</h1>
        <div class=" flex w-full">
            <div class="flex flex-col w-full md:w-1/2">
                <label class="mr-4">De :</label>
                <input type="time"
                    class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="horarioTrabajoInicio" name="horarioTrabajoInicio" required>
            </div>
            <div class="flex flex-col w-full md:w-1/2">
                <label class="mr-4">Hasta :</label>
                <input type="time"
                    class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="horarioTrabajoFinal" name="horarioTrabajoFinal" required>
            </div>
        </div>
        <div class="flex flex-wrap justify-center">
            <label class="inline-flex items-center mr-3">
                <input type="checkbox" name="dias[]" value="Domingo">
                <span class="ml-2">Domingo</span>
            </label>
        </div>
    </div>
</section>
{{--
<section class=" flex lg:flex-row flex-col justify-center w-full border-4 mt-8 px-3 pb-3">
    @php
        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
    @endphp

    @foreach ($dias as $dia)
<div class="mb-4">
            <label class="inline-flex items-center mr-3 ">
                <input type="checkbox" name="dias[]" value="{{ $dia }}" onclick="mostrarHorario(this)">
                <span class="ml-2">{{ $dia }}</span>
            </label>
            <div id="{{ $dia }}-horario" style="display: none;" class="flex flex-col">
                <div>
                    <label class="mr-2">Inicio:</label>
                    <input type="time" name="{{ $dia }}-de">
                </div>
                <div>
                    <label class="mr-2">Final:</label>
                    <input type="time" name="{{ $dia }}-hasta">
                </div>
            </div>
        </div>
@endforeach
</section> --}}
