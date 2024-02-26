     <!-- Modal -->
     <div id="modalRegistrarProducto" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title"
         role="dialog" aria-modal="true">
         <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
             <!-- Fondo del modal -->
             <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

             <!-- Contenido del modal -->
             <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
             <div
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                 <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                     <h3 class=" text-center text-lg leading-6 font-medium text-gray-900" id="modal-title">
                         Registrar Servicio
                     </h3>

                     <form method="POST" action="{{ route('servicios.store') }}"
                         class=" mt-8 flex flex-col items-center">
                         @csrf
                         <label class="text-sm text-gray-500 flex flex-col items-start">
                             <span>Tipo de producto</span>
                             <select name="txttio_producto"
                                 class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none">
                                 <option value="">Selecciona un tipo de producto</option>
                                 <!-- Aquí puedes agregar las opciones que necesites -->
                                 <option value="Rellenado_tinta_pequeño">Rellenado de tinta</option>
                                 <option value="otros_servicio">Otros servicios</option>
                                 <!-- etc. -->
                             </select>
                         </label>
                         <label class="text-sm text-gray-500 flex flex-col items-start">
                             <span>Descripcion del producto</span>
                             <input name="txtdescripcion" type="text"
                                 class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                         </label>
                         <label class="text-sm text-gray-500 flex flex-col items-start">
                             <span>Modelo</span>
                             <input name="txtmodelo" type="text"
                                 class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                         </label>
                         <label class="text-sm text-gray-500 flex flex-col items-start">
                             <span>Color</span>
                             <select id="colorSelect" name="txtcolor" onchange="changeColor()"
                                 class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none">
                                 <option value="">Selecciona un color</option>
                                 <option value="#FF0000">Rojo</option>
                                 <option value="#00FF00">Verde</option>
                                 <option value="#0000FF">Azul</option>
                                 <!-- Agrega más colores según sea necesario -->
                             </select>
                         </label>
                         <label class="text-sm text-gray-500 flex flex-col items-start">
                             <span>Cantidad</span>
                             <input name="txtcantidad" type="number" min="1" step="1"
                                 class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                         </label>
                         <label class="text-sm text-gray-500 flex flex-col items-start">
                             <span>Precio unitario</span>
                             <input name="txtprecio_unitario" type="number" min="1" step="0.01"
                                 class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                         </label>
                         <label class="text-sm text-gray-500 flex flex-col items-center">
                             <span>Factura</span>
                             <input name="txtfactura" type="checkbox"
                                 class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                         </label>


                         <button type="submit" id="enviarmodal"
                             class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                             Agregar servicio
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
