        <!-- Modal -->
        <div id="modal" class=" hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Fondo del modal -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <!-- Contenido del modal -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class=" text-center text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Ingrese el codigo de autorización
                        </h3>

                        <form method="POST" action="{{ route('ordeneliminacion.store') }}"
                            onsubmit="document.getElementById('enviarmodal').disabled = true;"
                            class=" mt-8 flex flex-col items-center">
                            @csrf
                            <div class="flex mb-2 space-x-2 rtl:space-x-reverse">
                                <div>
                                    <label for="code-1" class="sr-only">First code</label>
                                    <input type="text" maxlength="1" data-focus-input-init
                                        data-focus-input-next="code-2" id="code-1" name="code-1"
                                        class="block w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        required />
                                </div>
                                <div>
                                    <label for="code-2" class="sr-only">Second code</label>
                                    <input type="text" maxlength="1" data-focus-input-init
                                        data-focus-input-prev="code-1" data-focus-input-next="code-3" id="code-2"
                                        name="code-2"
                                        class="block w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        required />
                                </div>
                                <div>
                                    <label for="code-3" class="sr-only">Third code</label>
                                    <input type="text" maxlength="1" data-focus-input-init
                                        data-focus-input-prev="code-2" data-focus-input-next="code-4" id="code-3"
                                        name="code-3"
                                        class="block w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        required />
                                </div>
                                <div>
                                    <label for="code-4" class="sr-only">Fourth code</label>
                                    <input type="text" maxlength="1" data-focus-input-init
                                        data-focus-input-prev="code-3" data-focus-input-next="code-5" id="code-4"
                                        name="code-4"
                                        class="block w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        required />
                                </div>
                                <div>
                                    <label for="code-5" class="sr-only">Fifth code</label>
                                    <input type="text" maxlength="1" data-focus-input-init
                                        data-focus-input-prev="code-4" data-focus-input-next="code-6" id="code-5"
                                        name="code-5"
                                        class="block w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        required />
                                </div>
                                <div>
                                    <label for="code-6" class="sr-only">Sixth code</label>
                                    <input type="text" maxlength="1" data-focus-input-init
                                        data-focus-input-prev="code-5" id="code-6" name="code-6"
                                        class="block w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        required />
                                </div>
                                <div id="checkboxSeleccionado"></div>
                            </div>
                            <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Ingrese los 6 digitos para eliminar la información.</p>



                            <button type="submit" id="enviarmodal"
                                class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-greens-500 sm:ml-3 sm:w-auto sm:text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-trash3-fill mr-2" viewBox="0 0 16 16">
                                    <path
                                        d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                </svg>
                                Borrado permanente
                            </button>

                        </form>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">

                        <button type="button"
                            class="cerrarmodal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
