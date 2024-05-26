<form class="flex flex-col lg:flex-col justify-center mt-8 mb-12" method="GET" action="{{ route('productos.index') }}">
    <div class="flex justify-center items-center">
        <div class="relative">
            <input type="search" class="pl-10 pr-4 py-1 rounded-lg border-2 border-gray-300" name="adminlteSearch"
                placeholder="Buscar..." value="{{ $busqueda }}">
            <div class="absolute left-2 top-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="w-6 h-6 text-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    <div class=" flex lg:flex-row flex-col justify-center items-center">
        <!-- Filtro por estatus //5 pendiente 4 por recolectar, 3 revision 2 entrega 1 listo 0 eliminado-->
        <div class="flex flex-col md:ml-6 mb-4 md:mb-0">
            <label>Marca</label>
            <select
                class="w-full md:w-auto  border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                name="marca" id="marca">
                <option value="">Selecciona una opcion</option>
                @foreach ($marcas as $marca)
                    <option value="{{ $marca->id }}"
                        {{ old('marca', $busquedaMarca) == $marca->id ? 'selected' : '' }}>
                        {{ $marca->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Filtro por rango de fechas -->
        <div class="flex flex-col md:ml-6 mb-4 md:mb-0">
            <label>Tipo</label>
            <select
                class="w-full md:w-auto  border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                name="tipo" id="tipo">
                <option value="">Selecciona una opcion</option>
                @foreach ($modos as $modo)
                    <option value="{{ $modo->id }}" {{ old('tipo', $busquedaTipo) == $modo->id ? 'selected' : '' }}>
                        {{ $modo->nombre }}</option>
                @endforeach
                <!-- Agrega más opciones según sea necesario -->
            </select>
        </div>

        <div class="flex flex-col md:ml-6 mb-4 md:mb-0">
            <label>Color</label>
            <select
                class="w-full md:w-auto  border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                name="color" id="color">
                <option value="">Selecciona una opcion</option>
                @foreach ($colores as $color)
                    <option value="{{ $color->id }}"
                        {{ old('color', $busquedaColor) == $color->id ? 'selected' : '' }}>{{ $color->nombre }}
                    </option>
                @endforeach

            </select>
        </div>

        <!-- Filtro por entrega o servicio -->
        <div class="flex flex-col md:ml-6 mb-4 md:mb-0">
            <label>Categoria</label>
            <select
                class="w-full md:w-auto border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                name="categoria" id="categoria">
                <option value="">Selecciona una opcion</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}"
                        {{ old('categoria', $busquedaCategoria) == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit"
            class="inline-flex  text-center md:ml-6 items-center px-4 py-2 text-white bg-gray-600 rounded hover:bg-gray-700">
            <i class="fas fa-filter mr-2"></i>
            Filtrar
        </button>
    </div>
</form>
