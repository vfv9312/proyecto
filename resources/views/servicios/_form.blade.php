<div style="width: 100%; max-width: 600px; margin: auto;">
    <h2 style="text-align: center; color: #f00;">Atención</h2>
    <input list="empleados" name="empleado" id="empleadoInput" oninput="rellenarFormularioEmpleado()"
        style="width: 100%; padding: 10px; border: none; border-radius: 5px; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
    <datalist id="empleados">
        @foreach ($empleados as $empleado)
            <option value="{{ $empleado->nombre }}">{{ $empleado->apellido }} {{ $empleado->rol_empleado }}
            </option>
        @endforeach
        <input type="hidden" id="empleadoId" name="empleadoId">
    </datalist>

    <div style="width: 100%; max-width: 600px; margin: auto;">
        <h2 style="text-align: center; color: #f00;">Buscar del cliente</h2>
        <input list="clientes" name="clientes" id="clienteInput" oninput="rellenarFormulario()"
            style="width: 100%; padding: 10px; border: none; border-radius: 5px; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
        <datalist id="clientes">
            @foreach ($clientes as $cliente)
                <option value="{{ $cliente->nombre }}">{{ $cliente->apellido }} |{{ $cliente->telefono }}|
                    {{ $cliente->id }}
                </option>
            @endforeach
        </datalist>
        <input type="hidden" id="clienteId" name="clienteId">
    </div>
    <div class="flex flex-col">
        <label for="nombre_cliente">Nombre del cliente</label>
        <input type="text" id="nombreInput" name="nombre_cliente">
    </div>
    <div class="flex flex-col">
        <label for="apellidos">Apellidos</label>
        <input type="text" id="apellidoInput" name="apellidos">
    </div>
    <div class="flex flex-col">
        <label for="costo_total">Direcciones</label>
        <input list="direcciones" name="direccion" id="direccionInput" class="p-2 border rounded-md">
        <datalist id="direcciones">
            @foreach ($direccionesCliente as $direccion)
                <option value="{{ $direccion->direccion }}">{{ $direccion->id }}</option>
            @endforeach
        </datalist>
    </div>
    <div class="flex flex-col">
        <label for="telefono">Teléfono</label>
        <input type="text" id="telefonoInput" name="telefono">
    </div>
    <div class="flex flex-col">
        <label for="observaciones">Observaciones</label>
        <textarea id="observaciones" name="observaciones"></textarea>
    </div>
    <div class="flex flex-col">
        <label for="observaciones">Referencia</label>
        <textarea id="observaciones" name="observaciones"></textarea>
    </div>

    <div class="flex justify-center">
        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md">Carrito</button>
    </div>
