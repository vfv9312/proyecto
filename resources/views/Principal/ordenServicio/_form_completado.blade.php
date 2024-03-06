<div class="flex flex-wrap -mx-3 mt-16">
    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Nombre del Cliente
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="nombre_cliente" type="text" name="txtnombre_cliente"
            value="{{ $cliente->nombre_cliente }} {{ $cliente->apellido }}">
    </div>
    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Atendido por
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="atencion" type="text" name="txtatencion"
            value="{{ $empleado->nombre_empleado }} {{ $empleado->apellido }} - {{ $empleado->nombre_rol }}">
    </div>
</div>


<div class="w-full md:w-full px-3 mb-6 md:mb-0 md:mt-10">
    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
        Dirección a entregar
    </label>
    <input
        class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        id="direccion" type="text" name="txtdireccion"
        value="Col.{{ $direccion->localidad }}; {{ $direccion->calle }} #{{ $direccion->num_exterior }} - numero interio {{ $direccion->num_interior }} - Referencia {{ $direccion->referencia }}">
</div>
<div class="flex flex-wrap -mx-3 mt-16">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            Telefono del cliente
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="telefono" type="text" name="txttelefono" value="{{ $cliente->telefono_cliente }}">
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            RFC
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="rfc" type="text" name="txtrfc" value="{{ $cliente->comentario }}">
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0 ">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" ">
                Correo electronico
            </label>
            <input
                class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="email" type="text" name="txtemail" value="{{ $cliente->email }}">
        </div>

    </div>
    <div class="flex flex-wrap -mx-3 mt-16">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                Fecha del pedido
            </label>
            <input
                class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="fecha" type="text" name="txtfecha" value="{{ $preventa->created_at }}">
        </div>
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 ">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" ">
            Costo aproximado
        </label>
        <input
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="precio" type="text" name="txtprecio">
    </div>
</div>

<div class="flex
            justify-center mt-8">
    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-700">
        <i class="fas fa-file-pdf"></i>
        Ver pdf
    </button>
</div>
