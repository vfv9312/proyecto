@csrf
<div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="ubicacion">
            Ubicación
        </label>
        <input
            class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
            id="ubicacion" name="txtubicacion" type="text" placeholder="Ubicación" value="{{ $infoticket->ubicaciones }}">
    </div>
    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="telefono">
            Teléfono
        </label>
        <input
            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            id="telefono" name="txttelefono" type="text" placeholder="Teléfono" value="{{ $infoticket->telefono }}">
    </div>
    <div class="w-full md:w-1/2 px-3">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="whatsapp">
            WhatsApp
        </label>
        <input
            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            id="whatsapp" name="txtwhatsapp" type="text" placeholder="WhatsApp" value="{{ $infoticket->whatsapp }}">
    </div>
    <div class="w-full px-3">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="pagina-web">
            Página Web
        </label>
        <input
            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            id="pagina-web" name="txtpagina-web" type="text" placeholder="Página Web"
            value="{{ $infoticket->whatsapp }}">
    </div>
</div>

<button type="submit"
    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-700 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
    <i class="fas fa-save mr-2"></i> Guardar
</button>
