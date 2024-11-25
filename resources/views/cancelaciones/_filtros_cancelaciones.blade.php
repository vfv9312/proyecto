<form class="flex flex-col justify-center mt-8 mb-12 lg:flex-col" method="GET" action="{{ route('cancelar.index') }}">
    <div class="flex items-center justify-center">
        <div class="relative">
            <input type="search" class="py-1 pl-10 pr-4 border-2 border-gray-300 rounded-lg" name="adminlteSearch"
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
    <div class="flex flex-col items-center justify-center lg:flex-row">
        <div class="flex flex-col md:mb-4 md:mr-6">
            <label>Por cancelar :</label>
            <select name="motivo" id="categoriaCancelacion"
                class="w-full leading-tight text-gray-700 border rounded shadow appearance-none md:w-auto focus:outline-none focus:shadow-outline">
                <option value="">Selecciona un motivo</option>
                @foreach ($cancelaciones as $cancelar)
                    <option value="{{ $cancelar->id }}"   {{ old('motivo', $filtroMotivo) == $cancelar->id ? 'selected' : '' }}>{{$cancelar->nombre}}</option>
                @endforeach
            </select>
        </div>

        <!-- Filtro por rango de fechas -->
        <div class="flex flex-col md:mb-4 md:mr-6">
            <label>Fecha inicio :</label>
            <input
                class="w-full leading-tight text-gray-700 border rounded shadow appearance-none md:w-auto focus:outline-none focus:shadow-outline"
                type="date" id="fecha_inicio" name="fecha_inicio" value="{{ $filtroFecha_inicio }}">
        </div>

        <div class="flex flex-col md:mb-4 md:mr-6">
            <label>Fecha final</label>
            <input
                class="w-full leading-tight text-gray-700 border rounded shadow appearance-none md:w-auto focus:outline-none focus:shadow-outline"
                type="date" id="fecha_fin" name="fecha_fin" value="{{ $fecha_fin }}">
        </div>



        <button type="submit"
            class="flex items-center px-4 py-2 mt-3 text-white bg-gray-600 rounded md:mb-4 md:mr-6 hover:bg-gray-700">
            <i class="fas fa-filter"></i>
            Filtrar
        </button>
    </div>
</form>
