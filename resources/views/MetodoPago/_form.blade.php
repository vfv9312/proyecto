@csrf
<label class="flex flex-col items-start text-sm text-gray-500">
    <span>Nombre del metodo de Pago</span>
    <input name="txtnombre" class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
        value="{{ $metodoDePago->nombre }}" />
</label>


<div class="flex items-center justify-between mt-2">
    <a href="{{ route('metodopago.index') }}" class="flex items-center mr-3 text-indigo-600">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
            class="mr-2 bi bi-arrow-return-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5" />
        </svg>
        Volver
    </a>
    <button type="submit"
        class="flex items-center justify-center px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
        <span class="mr-2">Guardar cambios</span>
        <i class="transition-opacity duration-200 opacity-0 fas fa-hand-pointer hover:opacity-100"></i>
    </button>
</div>
