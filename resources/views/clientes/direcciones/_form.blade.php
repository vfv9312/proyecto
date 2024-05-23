<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="colonia">
        Colonia
    </label>
    <select id="txtcolonia" name="txtcolonia"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        @foreach ($catalogo_colonias as $colonia)
            <option value="{{ $colonia->id }}">{{ $colonia->localidad }}</option>
        @endforeach
        <!-- Aquí puedes agregar las opciones para la colonia -->
    </select>
</div>

<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="calle">
        Calle
    </label>
    <input id="txtcalle" name="txtcalle" type="text"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
</div>

<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="numero_exterior">
        Número Exterior
    </label>
    <input id="txtnum_exterior" name="txtnum_exterior" type="text"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
</div>

<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="numero_interior">
        Número Interior
    </label>
    <input id="txtnum_interior" name="txtnum_interior" type="text"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
</div>

<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="referencia">
        Referencia
    </label>
    <textarea id="txtreferencia" name="txtreferencia"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
</div>
<div class="flex items-center justify-between">
    <button
        class="inline-flex justify-center bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
        type="submit" onclick="this.disabled = true; this.form.submit();">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
            class="bi bi-floppy-fill mr-2" viewBox="0 0 16 16">
            <path
                d="M0 1.5A1.5 1.5 0 0 1 1.5 0H3v5.5A1.5 1.5 0 0 0 4.5 7h7A1.5 1.5 0 0 0 13 5.5V0h.086a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5H14v-5.5A1.5 1.5 0 0 0 12.5 9h-9A1.5 1.5 0 0 0 2 10.5V16h-.5A1.5 1.5 0 0 1 0 14.5z" />
            <path
                d="M3 16h10v-5.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5zm9-16H4v5.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5zM9 1h2v4H9z" />
        </svg>
        Guardar
    </button>
</div>
