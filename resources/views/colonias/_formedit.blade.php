<div class="mb-4">
    <label class="block mb-2 text-sm font-bold text-gray-700" for="nombre">
        Colonia
    </label>
    <input
        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
        id="nombre" type="text" name="nombre" value="{{ $coloniasTuxtla->localidad }}">
</div>

<div class="mb-6">
    <label class="block mb-2 text-sm font-bold text-gray-700" for="cp">
        Codigo Postal
    </label>
    <input
        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
        id="porcentaje" type="number" name="cp"
        value="{{ $coloniasTuxtla->cp  }}">
</div>

<div class="flex items-center justify-between">
    <button
        class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700 focus:outline-none focus:shadow-outline"
        type="submit">
        Actualizar
    </button>
</div>
