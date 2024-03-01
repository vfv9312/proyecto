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
        <option value="{{ $producto->color }}">{{ $producto->color }}</option>
        <option value="Negro">Negro</option>
        <option value="Cian">Cian</option>
        <option value="Cian">Cyan Light</option>
        <option value="Magenta">Magenta</option>
        <option value="Magenta">Magenta</option>
        <option value="Amarillo">Magenta Light</option>
        <option value="CMY">CMA</option>
        <!--C: Cyan (cian) , M: Magenta, Y: Yellow (amarillo), -->
        <option value="CMY_Light">CMA Light</option>
        <option value="CMYK">CMAN</option><!--K: Key (negro)-->
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
    <input type="file" name="file" accept="image/*"
        class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
    @if ($producto->fotografia)
        <img class=" w-52" src="{{ $producto->fotografia }}" alt="Fotografia del producto" />
    @endif
    @error('file')
        <small class=" text-danger">{{ $message }} </small>
    @enderror
</label>

<div class="flex justify-between items-center">
    <a href="{{ route('productos.index') }}" class="text-indigo-600">Volver</a>
    <input type="submit" value="Guardar cambios" class="bg-green-500 text-white rounded px-4 py-2">
</div>
