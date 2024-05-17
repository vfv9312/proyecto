@csrf
<div class="bg-gray-100 p-10 rounded-lg shadow-md">
    <label class="text-sm text-green-500 flex flex-col items-start mb-4">
        <span>Nombre</span>
        <input name="txtnombre"
            class="border-2 border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none py-2"
            value="{{ $persona->name }}" />
    </label>
    <x-input-error :messages="$errors->get('txtnombre')" class="mt-2" />

    <label class="text-sm text-green-500 flex flex-col items-start mb-4">
        <span>Rol empleado</span>

        <select name="txtrol"
            class="border-2 border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none py-2">
            <option value="{{ $rol->id_rol }}">{{ $rol->nombre }}</option>
            @foreach ($roles as $rol)
                <option value="{{ $rol->id }}" {{ $rol->nombre }}>{{ $rol->nombre }}</option>
            @endforeach
        </select>
    </label>
    <x-input-error :messages="$errors->get('txtrol')" class="mt-2" />

    {{-- <label class="text-sm text-green-500 flex flex-col items-start mb-4">
        <span>Correo Electronico</span>
        <input name="email"
            class="border-2 border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none py-2"
            value="{{ $persona->email }}" />
    </label> --}}
    <label class="text-sm text-green-500 flex flex-col items-start mb-4">
        <span>Contraseña Nueva</span>
        <input name="password" type="password"
            class="border-2 border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none py-2" />
    </label>
    <x-input-error :messages="$errors->get('password')" class="mt-2" />

    <div class="flex justify-between items-center mt-6">
        <a href="{{ route('empleados.index') }}" class="text-green-600 hover:text-green-800 cursor-pointer">Volver</a>
        <input type="submit" value="Actualizar"
            class="bg-green-500 hover:bg-green-600 text-white rounded px-4 py-2 cursor-pointer">
    </div>
</div>
