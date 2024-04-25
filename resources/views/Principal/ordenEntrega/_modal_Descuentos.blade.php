        <!-- Modal -->
        <div id="modalDescuentos" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title"
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
                            Aplicar algun descuento
                        </h3>
                        <div class="mt-4">
                            <label for="descuentoPorcentaje" class="block text-sm font-medium text-gray-700">Tipo de
                                descuento:</label>
                            <select id="elejirdescuento" name="descuentoPorcentaje"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                <option value="1">Sin descuento</option>
                                <option value="2">Descuento por cantidad</option>
                                <option value="3">Descuento por porcentaje</option>
                            </select>
                        </div>
                        <div id="descuentoProducto" class=" flex mx-auto flex-col mt-4">
                            <div class="mt-4 hidden" id="descuentoCantidad">
                                <label for="descuento" class="block text-sm font-medium text-gray-700">Descuento por
                                    cantidad :</label>
                                <input type="number" id="Cantidaddescuento" name="descuento" step="any"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md mb-4">
                            </div>
                            <div class="mt-4 hidden" id="descuentoPorcentaje">
                                <label for="descuentoPorcentaje"
                                    class="block text-sm font-medium text-gray-700">Descuento por porcentaje:</label>
                                <select name="descuentoPorcentaje" id="porcentaje"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md mb-4">
                                    <option value="">Selecciona un porcentaje</option>
                                    @foreach ($descuentos as $descuento)
                                        <option value="{{ $descuento->porcentaje }}">{{ $descuento->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" id="botonAgregar"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-500 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:w-auto sm:text-sm">
                                <i class="fas fa-plus-circle"></i> Agregar
                            </button>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">

                        <button type="button"
                            class="cerrarmodalDescuento text-red-700 mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium  hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                            <i class="fas fa-sign-out-alt text-red-700"></i> Salir
                        </button>
                    </div>
                </div>
            </div>
        </div>
