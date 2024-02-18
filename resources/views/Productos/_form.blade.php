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
    <input name="txtcolor" class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
        value="{{ $producto->color }}" />
</label>
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>Marca</span>
    <input name="txtmarca" class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
        value="{{ $producto->marca }}" />
</label>
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>precio</span>
    <input name="txtprecio" type="number"
        class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
        value="{{ $precioProducto->precio }}" />
</label>
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>Descripcion</span>
    <input name="txtdescripcion" type="text"
        class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
        value="{{ $producto->descripcion }}" />
</label>
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>Fotografia</span>
    <input type="file" class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
        value="{{ $producto->fotografia }}" />
</label>

<div class="flex justify-between items-center">
    <a href="{{ route('productos.index') }}" class="text-indigo-600">Volver</a>
    <input type="submit" value="Enviar" class="bg-gray-800 text-white rounded px-4 py-2">
</div>
