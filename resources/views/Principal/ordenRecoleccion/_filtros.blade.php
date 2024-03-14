<form class="flex flex-col md:flex-row justify-center mb-12" method="GET"
    action="{{ route('orden_recoleccion.index') }}">
    <!-- Filtro por estatus //5 pendiente 4 por recolectar, 3 revision 2 entrega 1 listo 0 eliminado-->
    <div class="flex flex-col md:ml-6 mb-4 md:mb-0">
        <label>Estatus</label>
        <select
            class="w-full md:w-auto  border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            name="entrega_servicio" id="entrega_servicio">
            <option value="">Selecciona una opcion</option>
            <option value="3">Entrega</option>
            <option value="4">Servicio</option>
            <!-- Agrega más opciones según sea necesario -->
        </select>
    </div>

    <!-- Filtro por rango de fechas -->
    <div class="flex flex-col md:ml-6 mb-4 md:mb-0">
        <label>Fecha inicio :</label>
        <input
            class="w-auto border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="date" id="fecha_inicio" name="fecha_inicio">
    </div>

    <div class="flex flex-col md:ml-6 mb-4 md:mb-0">
        <label>Fecha final</label>
        <input
            class="w-auto border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="date" id="fecha_fin" name="fecha_fin">
    </div>

    <!-- Filtro por entrega o servicio -->
    <div class="flex flex-col md:ml-6 mb-4 md:mb-0">
        <label>Servcio/Entrega</label>
        <select
            class="w-full md:w-auto border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            name="estatus" id="estatus">
            <option value="">Selecciona una opción</option>
            <option value="4">Recoleccion</option>
            <option value="3">Revision</option>
            <option value="2">Entrega</option>
        </select>
    </div>

    <button type="submit"
        class=" md:ml-6 flex items-center px-4 py-2 text-white bg-gray-600 rounded hover:bg-gray-700">
        <i class="fas fa-filter mr-2"></i>
        Filtrar
    </button>
</form>
