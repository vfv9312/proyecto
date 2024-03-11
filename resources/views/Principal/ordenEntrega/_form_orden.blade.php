<div class="flex flex-col md:flex-row">

    <div class="flex flex-col w-full md:w-1/2 md:mr-10">
        <label class="mr-4">Cliente</label>
        <select
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="inputCliente" name="cliente" oninput="rellenarFormulario()">
            <option value="null">Nuevo Cliente</option>
            @foreach ($listaClientes as $cliente)
                <option value="{{ $cliente->id_cliente }}">{{ $cliente->nombre_cliente }} {{ $cliente->apellido }} -
                    {{ $cliente->telefono_cliente }}- {{ $cliente->email }}</option>
            @endforeach
        </select>
    </div>

    <div class="flex flex-col w-full md:w-1/2 ">
        <label class="mr-4">Atención</label>
        <select
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="inputAtencion" name="txtempleado" required
            oninvalid="this.setCustomValidity('Por favor, selecciona un empleado.')"
            oninput="this.setCustomValidity('')">
            <option value="">Seleccione un empleado</option>
            @foreach ($listaEmpleados as $empleado)
                <option value="{{ $empleado->id }}">{{ $empleado->nombre_empleado }} {{ $empleado->apellido }}-
                    {{ $empleado->nombre_rol }}</option>
            @endforeach
        </select>
    </div>


</div>
<section class=" border-4 mt-8 px-3 pb-3">

    <h1 class="text-2xl text-center text-blue-600 mb-3">Datos del Cliente</h1>

    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
        <div class="flex flex-col w-full md:w-1/2">
            <label>Nombre</label>
            <input type="text"
                class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="nombreCliente" name="txtnombreCliente" placeholder="Nombre del cliente">
        </div>

        <div class="flex flex-col w-full md:w-1/2">
            <label>Apellido</label>
            <input type="text"
                class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="apellidoCliente" name="txtapellidoCliente" placeholder="Apellidos del cliente">
        </div>

    </div>

    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">


        <div class="flex flex-col w-full md:w-1/2">
            <label>Telefono</label>
            <input type="text"
                class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="telefono" name="txttelefono" placeholder="Numero de telefono" pattern="\d{10}" required
                title="Por favor ingrese exactamente 10 dígitos">
        </div>

        <div class="flex flex-col w-full md:w-1/2">
            <label>RFC</label>
            <input type="text"
                class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="rfc" name="txtrfc" placeholder="RFC">
        </div>

        <div class="flex flex-col w-full md:w-1/2">
            <label>Correo electronico</label>
            <input type="email"
                class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="email" name="txtemail" placeholder="ecotoner@example.com">
        </div>

    </div>



    <div class="flex flex-col w-full md:w-full mt-8">
        <label class="mr-4">Direcciones registradas</label>
        <select
            class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="inputDirecciones" name="id_direccion">
        </select>
    </div>
</section>

<button id="mostrarNuevaDireccion" class=" mb-2"> <i class="fas fa-plus"></i>Agregar nueva direccion</button>


<section id="nuevaDireccion" class=" border-4 mb-3 px-3 pb-3" style="display: none;">

    <h1 class="text-2xl
    text-center text-blue-600 mb-2">Agregar nueva direccion</h1>

    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">

        <div class="flex flex-col w-full md:w-1/2 ">
            <label class="mr-4">Colonia</label>
            <select
                class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="txtcolonia" name="nuevacolonia">
                <option value="null">Seleccione una colonia</option>
                @foreach ($ListaColonias as $colonia)
                    <option value="{{ $colonia->id }}">{{ $colonia->localidad }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col w-full md:w-1/2">
            <label class="mr-4">Calles</label>
            <input type="text"
                class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="calle" name="nuevacalle" placeholder="C. 2 Oriente y Av. 3 Sur">
        </div>

    </div>
    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
        <div class="flex flex-col w-full md:w-1/2">
            <label class="mr-4">Numero Interior</label>
            <input type="text"
                class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="num_interior" name="nuevonum_interior" placeholder="b15">
        </div>

        <div class="flex flex-col w-full md:w-1/2">
            <label class="mr-4">Numero Exterior</label>
            <input type="text"
                class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="num_exterior" name="nuevonum_exterior" placeholder="1000">
        </div>
    </div>


    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
        <div class="flex flex-col w-full md:w-full">
            <label>Referencia</label>
            <input type="text"
                class="w-full px-3 py-2 border rounded shadow appearance-none text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="referencia" name="nuevareferencia" placeholder="Referencia">
        </div>
    </div>

</section>
<button type="submit" class="bg-green-500 hover:bg-green-700 transition duration-200">Siguiente</button>
