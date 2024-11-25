@csrf
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>Nombre comercial</span>
    <input name="txtnombre" class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
        value="{{ $categoria->nombre }}" />
</label>


<div class="flex justify-between items-center mt-2">
    <a href="{{ route('categorias.index') }}" class="text-indigo-600 mr-3 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
            class="bi bi-arrow-return-left mr-2" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5" />
        </svg>
        Volver
    </a>
    <button type="submit"
        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center justify-center">
        <span class="mr-2">Guardar cambios</span>
        <i class="fas fa-hand-pointer opacity-0 hover:opacity-100 transition-opacity duration-200"></i>
    </button>
</div>
