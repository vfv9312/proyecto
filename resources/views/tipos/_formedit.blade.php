<div class="mb-4">
    <label class="block mb-2 text-sm font-bold text-gray-700" for="nombre">
        Editar tipo de producto
    </label>
    <input
        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
        id="nombre" type="text" name="nombre" value="{{ $tiposProductos->nombre }}">
</div>

<div class="flex items-center justify-between">
    <button
        class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700 focus:outline-none focus:shadow-outline"
        type="submit">
        Actualizar
    </button>
</div>
