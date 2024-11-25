@csrf
<input type="hidden" name="id_cliente" value="{{ $cliente->id }}">
<input type="hidden" name="id_persona" value="{{ $cliente->id_persona }}">

<div class="mb-4">
    <label  id="tipoCliente" class="flex items-center justify-center cursor-pointer">
        <span class="mr-2 text-sm font-medium text-gray-900 ms-3 dark:text-gray-300">Persona Fisica</span>
        <input id="tipoDeCliente" type="checkbox"
                name="moralofisico"
                value="1"
                class="sr-only peer"
               @if($persona->apellido == ".") checked @endif
               onclick="toggleApellidoInput()">
        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
        </div>
        <span class="text-sm font-medium text-gray-900 ms-3 dark:text-gray-300">Persona Moral</span>
    </label>
</div>

<label class="flex flex-col items-start text-sm text-gray-500">
    <span>Nombre</span>
    <input name="txtnombre" class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
        value="{{ $persona->nombre }}" />
</label>

<div id="apellidoInput" class="hidden">
    <label class="flex flex-col items-start text-sm text-gray-500">
        <span>Apellido</span>
        <input name="txtapellido" class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
               value="{{ $persona->apellido }}" />
    </label>
</div>

<label class="flex flex-col items-start text-sm text-gray-500">
    <span>Telefono</span>
    <input name="txttelefono" class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
        value="{{ $persona->telefono }}" pattern="\d{10}"
        title="Por favor ingrese un número de teléfono de 10 dígitos" />
</label>

<label id="apellidoCliente" class="flex flex-col items-start text-sm text-gray-500">
    <span>clave</span>
    <input name="txtclave" type="number" pattern="\d{0,8}"
     value="{{ $cliente->clave }}"
        class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
</label>

<label class="flex flex-col items-start text-sm text-gray-500">
    <span>Corre electronico</span>
    <input type="email" name="txtemail"
        class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
        value="{{ $persona->email }}" />
</label>
<label class="flex flex-col items-start text-sm text-gray-500">
    <span>RFC</span>
    <input name="txtrfc" type="text"
        class="w-full h-10 border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
        value="{{ $cliente->comentario }}" pattern="^[A-ZÑ&]{3,4}\d{6}(?:[A-Z\d]{2}[A\d])?$"
        title="Por favor ingrese un RFC válido" />
</label>
<label class="flex flex-col items-center text-sm text-gray-500">
    <label class="flex flex-col items-start text-sm text-gray-500">

        <!-- si tienen datos de direccion entonces muestra los input-->
        @if ($direcciones)
            <span>Colonia</span>
            <input type="hidden" name="id_direccion" value="{{ $direcciones->id }}">
            <select id="coloniaSelect" name="txtcolonia"
                class="w-full h-10 border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none">
                <!--si no le cambio el valor entonces sera null esto para saber si lo cambio-->
                <option value="{{ null }}">{{ $direcciones->localidad }}</option>
                @foreach ($catalogo_colonias as $municipio)
                    <option value="{{ $municipio->id }}">{{ $municipio->localidad }}
                    </option>
                @endforeach
            </select>
    </label>
    <label class="flex flex-col items-start text-sm text-gray-500">
        <span>Calles</span>
        <input name="txtcalle" type="text"
            class="w-full h-10 border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
            value="{{ $direcciones->calle }}" />
    </label>
    <label class="flex flex-col items-start text-sm text-gray-500">
        <span>Numero exterior</span>
        <input name="txtnum_exterior" type="text"
            class="w-full h-10 border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
            value="{{ $direcciones->num_exterior }}" />
    </label>
    <label class="flex flex-col items-start text-sm text-gray-500">
        <span>Numero interior</span>
        <input name="txtnum_interior" type="text"
            class="w-full h-10 border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
            value="{{ $direcciones->num_interior }}" />
    </label>
    <label class="flex flex-col items-start text-sm text-gray-500">
        <span>Referencia</span>
        <input name="txtreferencia" type="text"
            class="w-full h-10 border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
            value="{{ $direcciones->referencia }}" />
    </label>
    <!--si no tienen datos entonces no imprime nada de input para la direccion-->
@else
    @endif


    <a href="{{ route('clientes.index') }}" class="text-indigo-600">Volver</a>
    <div class="flex items-center justify-between">

        <button type="submit" id="enviarmodal"
            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-green-700 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
            onclick="this.disabled = true; this.form.submit();">
            Guardar cambios
        </button>
    </div>
