<div class="flex flex-col w-full ">
    <label for="nombre_comercial">Nombre comercial:</label>
    <input
        class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        type="text" id="nombre_comercial" name="txtnombre_comercial">
</div>
<div class="flex md:mt-8">
    <div class="flex flex-col w-full md:w-1/2 md:mr-6">
        <label for="color">Color:</label>
        <select name="txtcolor"
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option value="">Selecciona un color</option>
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
    </div>
    <div class="flex flex-col w-full md:w-1/2 ">
        <label for="tipo">Categoria:</label>
        <select name="txttipo"
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option value="">Selecciona una una categoria</option>
            @foreach ($categorias as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class=" flex md:mt-8">
    <div class="flex flex-col w-full md:w-1/2 mr-8">
        <label for="marca">Marca:</label>
        <select name="txtmarca"
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option value="">Selecciona una marca</option>
            @foreach ($marcas as $marca)
                <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
            @endforeach
        </select>
    </div>

</div>

<div class=" flex flex-col">
    <label for="descripcion">Descripción:</label>
    <textarea
        class="w-full h-32 px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        id="descripcion" name="txtdescripcion" maxlength="255"></textarea>
</div>
<div class=" flex justify-center mt-8 ">
    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-700">
        <i class="fas fa-save mr-2"></i>
        Almacenar producto
    </button>
</div>
