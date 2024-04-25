        <!-- Modal -->
        <div id="modalRegistrarProducto" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Fondo del modal -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <!-- Contenido del modal -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class=" text-center text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Detalles del producto
                        </h3>
                        <div id="detallesProducto" class=" flex mx-auto flex-col mt-4">
                            <span class=" text-center font-extrabold text-xl " id="tituloDetalle"></span>
                            <span class=" font-bold" id="MarcaDetalle"></span>
                            <span class=" font-bold" id="CategoriaDetalle"></span>
                            <span class=" font-bold" id="TipoDetalle"></span>
                            <span class=" font-bold" id="ModeloDetalle"></span>
                            <span class=" font-bold" id="ColorDetalle"></span>
                            <span class=" font-bold" id="PrecioDetalle"></span>
                            <span class=" font-bold" id="descripcionDetalle"></span>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">

                        <button type="button"
                            class="cerrarmodal text-red-700 mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium  hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                            <i class="fas fa-sign-out-alt text-red-700"></i> Salir
                        </button>
                    </div>
                </div>
            </div>
        </div>
