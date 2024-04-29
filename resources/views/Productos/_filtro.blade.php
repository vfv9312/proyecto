<form class="flex flex-col lg:flex-col justify-center mt-8 mb-12" method="GET" action="{{ route('productos.index') }}">
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

</form>
