<form class=" flex justify-center mb-12" method="GET" action="{{ route('orden_recoleccion.index') }}">
    <!-- Filtro por estatus //5 pendiente 4 por recolectar, 3 revision 2 entrega 1 listo 0 eliminado-->
    <div class=" flex flex-col">
        <label>Estatus</label>
        <select name="entrega_servicio" id="entrega_servicio">
            <option value="">Selecciona una opcion</option>
            <option value="3">Entrega</option>
            <option value="4">Servicio</option>
            <!-- Agrega más opciones según sea necesario -->
        </select>
    </div>

    <!-- Filtro por rango de fechas -->
    <div class=" flex flex-col ml-6">
        <label>Fecha inicio :</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio">
    </div>

    <div class=" flex flex-col ml-6">
        <label>Fecha final</label>
        <input type="date" id="fecha_fin" name="fecha_fin">
    </div>

    <!-- Filtro por entrega o servicio -->
    <div class=" flex flex-col ml-6">
        <label>Servcio/Entrega</label>
        <select name="estatus" id="estatus">
            <option value="">Selecciona una opción</option>
            <option value="4">Recoleccion</option>
            <option value="3">Revision</option>
            <option value="2">Entrega</option>
        </select>
    </div>

    <button type="submit" class="flex items-center px-4 py-2 text-white bg-green-500 rounded hover:bg-green-600">
        <i class="fas fa-filter mr-2"></i>
        Filtrar
    </button>
</form>
