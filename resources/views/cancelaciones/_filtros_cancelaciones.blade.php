<form class="flex flex-col md:flex-row justify-center mt-8 mb-12" method="GET" action="{{ route('cancelar.index') }}">

    <div class="flex flex-col md:mb-4 md:mr-6">
        <label>Por cancelar :</label>
        <select name="motivo" id="categoriaCancelacion"
            class="w-full md:w-auto border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option value="">Selecciona un motivo</option>
            @foreach ($cancelaciones as $cancelar)
                <option value="{{ $cancelar->id }}">{{ $cancelar->nombre }}</option>
            @endforeach
        </select>
    </div>

    <!-- Filtro por rango de fechas -->
    <div class="flex flex-col md:mb-4 md:mr-6">
        <label>Fecha inicio :</label>
        <input
            class="w-full md:w-auto border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="date" id="fecha_inicio" name="fecha_inicio">
    </div>

    <div class="flex flex-col md:mb-4 md:mr-6">
        <label>Fecha final</label>
        <input
            class="w-full md:w-auto border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="date" id="fecha_fin" name="fecha_fin">
    </div>



    <button type="submit"
        class=" mt-3 md:mb-4 md:mr-6 flex items-center px-4 py-2 text-white bg-gray-600 rounded hover:bg-gray-700">
        <i class="fas fa-filter"></i>
        Filtrar
    </button>
</form>
