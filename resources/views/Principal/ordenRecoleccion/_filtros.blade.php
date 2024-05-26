<form class="flex flex-col lg:flex-col justify-center mb-12" method="GET"
    action="{{ route('orden_recoleccion.index') }}">
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
            <label>Tipo de orden</label>
            <select
                class="w-full md:w-auto  border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                name="entrega_servicio" id="entrega_servicio">
                <option value="">Selecciona una opcion</option>
                <option value="3" {{ old('entrega_servicio', $filtroES) == 3 ? 'selected' : '' }}>Entrega</option>
                <option value="4" {{ old('entrega_servicio', $filtroES) == 4 ? 'selected' : '' }}>Servicio</option>
                <!-- Agrega más opciones según sea necesario -->
            </select>
        </div>

        <!-- Filtro por rango de fechas -->
        <div class="flex flex-col md:ml-6 mb-4 md:mb-0">
            <label>Fecha inicio :</label>
            <input
                class="w-auto border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                type="date" id="fecha_inicio" name="fecha_inicio" value="{{ $filtroFecha_inicio }}">
        </div>

        <div class="flex flex-col md:ml-6 mb-4 md:mb-0">
            <label>Fecha final</label>
            <input
                class="w-auto border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                type="date" id="fecha_fin" name="fecha_fin" value="{{ $fecha_fin }}">
        </div>

        <!-- Filtro por entrega o servicio -->
        <div class="flex flex-col md:ml-6 mb-4 md:mb-0">
            <label>Servcio/Entrega</label>
            <select
                class="w-full md:w-auto border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                name="estatus" id="estatus">
                <option value="">Selecciona una opción</option>
                <option value="5" {{ old('estatus', $filtroEstatus) == 5 ? 'selected' : '' }}>Cancelación</option>
                <option value="4" {{ old('estatus', $filtroEstatus) == 4 ? 'selected' : '' }}>Recoleccion</option>
                <option value="3" {{ old('estatus', $filtroEstatus) == 3 ? 'selected' : '' }}>Revision</option>
                <option value="2" {{ old('estatus', $filtroEstatus) == 2 ? 'selected' : '' }}>Entrega</option>
                <option value="1" {{ old('estatus', $filtroEstatus) == 1 ? 'selected' : '' }}>Orden Procesada
                </option>
            </select>
        </div>
        <button type="submit"
            class="inline-flex  text-center md:ml-6 items-center px-4 py-2 text-white bg-gray-600 rounded hover:bg-gray-700">
            <i class="fas fa-filter mr-2"></i>
            Filtrar
        </button>
    </div>


</form>
