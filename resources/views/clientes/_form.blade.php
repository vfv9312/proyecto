@csrf
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
    <span>Fecha de nacimiento</span>
    <input name="txtfecha_nacimiento" type="date"
        class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
        value="{{ $persona->fecha_nacimiento }}" />
</label>

<label class="text-sm text-gray-500 flex flex-col items-center">
    <span>Direcciones</span>
    <input list="direcciones" class="focus:ring-2 focus:ring-blue-300 focus:outline-none w-96 h-12">
    <datalist id="direcciones">
        @foreach ($direcciones as $direccion)
            @if ($cliente->id == $direccion->id)
                <option value="{{ $direccion->direccion }}">
            @endif
        @endforeach
    </datalist>
</label>

<button id="add">Añadir dirección</button>
<div id="inputList"></div>

<button id="add">Añadir referencia</button>
<div id="inputList"></div>

<div class="flex justify-between items-center">
    <a href="{{ route('clientes.index') }}" class="text-indigo-600">Volver</a>
    <input type="submit" value="Enviar" class="bg-gray-800 text-white rounded px-4 py-2">
</div>
