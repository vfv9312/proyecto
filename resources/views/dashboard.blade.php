<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>


        <header class=" flex justify-between p-3">
            <button id="toggle-filters" type="button"
                class="mt-4 mb-4 bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
                <i class="fas fa-filter"></i> Añadir Filtros
            </button>
            <button type="button" id="compras" class="fa fa-shopping-bag fa-2x text-red-500 cursor-pointer"><span
                    id="totalSpan" class="incrementar ml-2 text-sm text-green-500">0</span></button>
        </header>
        @include('Principal.ordenEntrega._filtro_articulo')
        @include('Principal.ordenEntrega._articulos')


    </div>
</div>
