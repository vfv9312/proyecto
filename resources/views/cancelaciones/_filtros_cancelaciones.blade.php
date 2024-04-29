<form class="flex flex-col lg:flex-col justify-center mt-8 mb-12" method="GET" action="{{ route('cancelar.index') }}">
    <div class="flex justify-center items-center">
        <div class="relative">
            <input type="search" class="pl-10 pr-4 py-1 rounded-lg border-2 border-gray-300" name="adminlteSearch"
                placeholder="Buscar...">
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
    </div>
</form>
