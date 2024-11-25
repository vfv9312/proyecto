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
                     Registrar Categoria
                 </h3>

                 <form method="POST" action="{{ route('categorias.store') }}"
                     onsubmit="document.getElementById('enviarmodal').disabled = true;" enctype="multipart/form-data"
                     class=" mt-8 flex flex-col items-center">
                     @csrf
                     <label class="text-sm text-gray-500 flex flex-col items-start">
                         <span>Nombre comercial</span>
                         <input name="txtnombre" required
                             class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                     </label>
                     <button type="submit" id="enviarmodal"
                         class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-greens-500 sm:ml-3 sm:w-auto sm:text-sm mt-2">
                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-floppy-fill mr-2" viewBox="0 0 16 16">
                             <path
                                 d="M0 1.5A1.5 1.5 0 0 1 1.5 0H3v5.5A1.5 1.5 0 0 0 4.5 7h7A1.5 1.5 0 0 0 13 5.5V0h.086a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5H14v-5.5A1.5 1.5 0 0 0 12.5 9h-9A1.5 1.5 0 0 0 2 10.5V16h-.5A1.5 1.5 0 0 1 0 14.5z" />
                             <path
                                 d="M3 16h10v-5.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5zm9-16H4v5.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5zM9 1h2v4H9z" />
                         </svg>
                         Guardar
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
