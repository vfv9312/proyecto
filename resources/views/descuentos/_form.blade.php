<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="nombre">
        Nombre
    </label>
    <input
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        id="nombre" type="text" name="nombre" value="{{ $descuento->nombre }}">
</div>

<div class="mb-6">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="porcentaje">
        Porcentaje
    </label>
    <input
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        id="porcentaje" type="number" min="1" max="100" name="porcentaje"
        value="{{ $descuento->porcentaje }}">
</div>

<div class="flex items-center justify-between">
    <button
        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
        type="submit">
        Actualizar
    </button>
</div>
