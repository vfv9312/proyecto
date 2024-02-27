@csrf
<input type="hidden" name="cliente" value="{{ $cliente->id }}" />
<label class="text-sm text-gray-500 flex flex-col items-start">

    <span>Colonia</span>
    <select name="txtcolonia"
        class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none w-full h-10">
        <option value="">Selecciona la colonia o Barrio</option>
        @foreach ($catalogo_colonias as $municipio)
            <option value="{{ $municipio->id }}">{{ $municipio->localidad }}
            </option>
        @endforeach
    </select>
</label>
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>Calles</span>
    <input name="txtcalle" type="text"
        class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none w-full h-10" />
</label>
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>Numero exterior</span>
    <input name="txtnum_exterior" type="text"
        class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none w-full h-10" />
</label>
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>Numero interior</span>
    <input name="txtnum_interior" type="text"
        class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none w-full h-10" />
</label>
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>Referencia</span>
    <input name="txtreferencia" type="text"
        class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none w-full h-10" />
</label>
<button type="submit"
    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-700 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
    Guardar cliente
</button>
