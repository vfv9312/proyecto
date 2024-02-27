@csrf
<input type="hidden" name="id_cliente" value="{{ $cliente->id }}">
<input type="hidden" name="id_persona" value="{{ $cliente->id_persona }}">
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>Nombre</span>
    <input name="txtnombre" class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
        value="{{ $persona->nombre }}" />
</label>
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>Apellido</span>
    <input name="txtapellido" class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
        value="{{ $persona->apellido }}" />
</label>

<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>Telefono</span>
    <input name="txttelefono" class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
        value="{{ $persona->telefono }}" />
</label>
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>Corre electronico</span>
    <input name="txtemail" class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
        value="{{ $persona->email }}" />
</label>
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>RFC</span>
    <input name="txtrfc" type="text"
        class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none w-full h-10"
        value="{{ $cliente->comentario }}" />
</label>
<label class="text-sm text-gray-500 flex flex-col items-center">
    <label class="text-sm text-gray-500 flex flex-col items-start">

        <!-- si tienen datos de direccion entonces muestra los input-->
        @if ($direcciones)
            <span>Colonia</span>
            <input type="hidden" name="id_direccion" value="{{ $direcciones->id }}">
            <select id="coloniaSelect" name="txtcolonia"
                class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none w-full h-10">
                <!--si no le cambio el valor entonces sera null esto para saber si lo cambio-->
                <option value="{{ null }}">{{ $direcciones->localidad }}</option>
                @foreach ($catalogo_colonias as $municipio)
                    <option value="{{ $municipio->id }}">{{ $municipio->localidad }}
                    </option>
                @endforeach
            </select>
    </label>
    <label class="text-sm text-gray-500 flex flex-col items-start">
        <span>Calles</span>
        <input name="txtcalle" type="text"
            class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none w-full h-10"
            value="{{ $direcciones->calle }}" />
    </label>
    <label class="text-sm text-gray-500 flex flex-col items-start">
        <span>Numero exterior</span>
        <input name="txtnum_exterior" type="text"
            class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none w-full h-10"
            value="{{ $direcciones->num_exterior }}" />
    </label>
    <label class="text-sm text-gray-500 flex flex-col items-start">
        <span>Numero interior</span>
        <input name="txtnum_interior" type="text"
            class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none w-full h-10"
            value="{{ $direcciones->num_interior }}" />
    </label>
    <label class="text-sm text-gray-500 flex flex-col items-start">
        <span>Referencia</span>
        <input name="txtreferencia" type="text"
            class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none w-full h-10"
            value="{{ $direcciones->referencia }}" />
    </label>
    <!--si no tienen datos entonces no imprime nada de input para la direccion-->
@else
    @endif


    <a href="{{ route('clientes.index') }}" class="text-indigo-600">Volver</a>
    <div class="flex justify-between items-center">

        <button type="submit" id="enviarmodal"
            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-700 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
            Guardar cambios
        </button>
    </div>
