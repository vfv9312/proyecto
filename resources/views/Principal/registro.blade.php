@extends('adminlte::page')

@section('title', 'Venta')

@section('content_header')

@stop

@section('content')
    <p>Registro.</p>

    <form method="POST" action="" class="max-w-xl mx-auto p-6 space-y-6">
        @csrf
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
                <label for="fecha_recibido">Fecha de producto recibido</label>
                <input type="datetime-local" id="fecha_recibido" name="fecha_recibido" class="p-2 border rounded-md">
            </div>
            <div class="flex flex-col">
                <label for="fecha_entrega">Fecha de entrega</label>
                <input type="datetime-local" id="fecha_entrega" name="fecha_entrega" class="p-2 border rounded-md">
            </div>

            <div class="flex justify-center">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Enviar</button>
            </div>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome para los iconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@stop

@section('js')
    <script>
        var clientes = @json($clientes);
        var empleados = @json($empleados);

        function rellenarFormulario() {
            var clienteNombre = document.getElementById('clienteInput').value;
            var cliente = clientes.find(c => c.nombre == clienteNombre);

            if (cliente) {
                document.getElementById('nombreInput').value = cliente.nombre;
                document.getElementById('apellidoInput').value = cliente.apellido;
                document.getElementById('telefonoInput').value = cliente.telefono;
                document.getElementById('clienteId').value = cliente.id; // Establecer el valor del campo oculto
                // Rellenar otros campos del formulario...
            }
        }

        function rellenarFormularioEmpleado() {
            var empleadoNombre = document.getElementById('empleadoInput').value;
            var empleado = empleados.find(e => e.nombre == empleadoNombre);

            if (empleado) {
                document.getElementById('empleadoId').value = empleado.id; // Establecer el valor del campo oculto
            }
        }

        $(document).ready(function() {
            $('#clientes').select2();
            $('#clientes').select2();
        });
    </script>
@stop
