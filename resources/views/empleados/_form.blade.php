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
    <span>Rol</span>
    <input name="txtrol" class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none"
        value="{{ $empleado->rol_empleado }}" />
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
<label class="text-sm text-gray-500 flex flex-col items-start">
    <span>Fotografia</span>
    <input type="file" name="file" accept="image/*"
        class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
    @if ($empleado->fotografia)
        <img class=" w-52" src="{{ $empleado->fotografia }}" alt="Fotografia del producto" />
    @endif
    @error('file')
        <small class=" text-danger">{{ $message }} </small>
    @enderror
</label>

<div class="flex justify-between items-center">
    <a href="{{ route('empleados.index') }}" class="text-indigo-600">Volver</a>
    <input type="submit" value="Enviar" class="bg-gray-800 text-white rounded px-4 py-2">
</div>
