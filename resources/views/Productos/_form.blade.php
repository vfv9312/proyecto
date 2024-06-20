@csrf
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>Nombre comercial</span>
    <input name="txtnombre" class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
        value="{{ $producto->nombre_comercial }}" />
</label>
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>Modelo</span>
    <input name="txtmodelo" class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
        value="{{ $producto->modelo }}" />
</label>
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>Color</span>
    <select name="txtcolor" class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none">
        <option value="{{ $datosProducto->idColor }}">{{ $datosProducto->nombreColor }}</option>
        @foreach ($colores as $color)
            <option value="{{ $color->id }}">{{ $color->nombre }}</option>
        @endforeach
    </select>

</label>
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>Tipo</span>
    <select name="txtmodo" class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none">
        <option value="{{ $datosProducto->idModo }}">{{ $datosProducto->nombreModo }}</option>
        @foreach ($modos as $modo)
            <option value="{{ $modo->id }}">{{ $modo->nombre }}</option>
        @endforeach
    </select>

</label>
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>Categoria</span>
    <select name="txttipo" class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none">
        <option value="{{ $datosProducto->idTipo }}">{{ $datosProducto->nombreTipo }}</option>
        @foreach ($categorias as $tipo)
            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
        @endforeach
    </select>
</label>
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>Marca</span>
    <select name="txtmarca" class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none">
        <option value="{{ $datosProducto->idMarca }}">{{ $datosProducto->nombreMarca }}</option>
        @foreach ($marcas as $marca)
            <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
        @endforeach
    </select>
</label>
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>precio</span>
    <input name="txtprecio" type="number" step="any"
        class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none h-8"
        value="{{ $precioProducto->precio }}" />
</label>
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>precio alternativo 1</span>
    <input name="txtprecioalternativouno" type="number" min="1" step="0.01"
        class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none h-8"
        value="{{ $precioProducto->alternativo_uno }}" />
</label>
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>precio alternativo 2</span>
    <input name="txtprecioalternativodos" type="number" min="1" step="0.01"
        class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none h-8"
        value="{{ $precioProducto->alternativo_dos }}" />
</label>
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>precio alternativo 3</span>
    <input name="txtprecioalternativotres" type="number" min="1" step="0.01"
        class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none h-8"
        value="{{ $precioProducto->alternativo_tres }}" />
</label>

<div class=" w-3/4">
    <label for="message" class="text-lg text-gray-500 flex flex-col items-start">Descripcion</label>
    <textarea id="message" rows="4" name="txtdescripcion"
        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        placeholder="Escribe aqui la descripcion ....">{{ $producto->descripcion }}</textarea>
</div>


<div class="flex justify-between items-center">
    <a href="{{ route('productos.index') }}" class="text-indigo-600 mr-3">Volver</a>
    <input type="submit" value="Guardar cambios" class="bg-green-500 text-white rounded px-4 py-2 cursor-pointer">
</div>
