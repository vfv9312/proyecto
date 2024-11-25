<div class="flex flex-col w-full h-12 mb-5 md:w-1/4">
    <label class="">Seleccione el tipo de cliente</label>
    <select id="seleccionadorCliente" class="h-full ">
        <option value="NuevoCliente">Nuevo Cliente</option>
        <option value="ClienteExistente">Cliente existente</option>
    </select>
</div>
<div id="contenedorSelectCliente" class="flex-col hidden md:flex-row">

    <div class="flex flex-col w-full md:w-1/2 md:mr-2">
        <label class="">Cliente</label>
        <select
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="inputCliente" name="cliente" oninput="rellenarFormulario()">
            <option value="null">Selecciona un cliente</option>
            @foreach ($listaClientes as $cliente)
                <option value="{{ $cliente->id_cliente }}">{{ $cliente->nombre_cliente }} {{ $cliente->apellido }} -
                    {{ $cliente->telefono_cliente }}- {{ $cliente->clave }}</option>
            @endforeach
        </select>
    </div>

    <div class="flex flex-col w-full md:w-1/2 md:mr-2">
        <label class="mr-4">Atención</label>
        <select
            class="w-full px-3 py-1 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="inputAtiende" name="txtatencion">
        </select>
    </div>

</div>

<label id="tipoCliente" class="flex items-center cursor-pointer">
    <span class="mr-2 text-sm font-medium text-gray-900 ms-3 dark:text-gray-300">Persona Fisica</span>
    <input id="tipoDeCliente" type="checkbox" value="" class="sr-only peer">
    <div
        class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
    </div>
    <span class="text-sm font-medium text-gray-900 ms-3 dark:text-gray-300">Persona Moral</span>
</label>

<section class="px-3 pb-3 mt-8 border-4 ">

    <h1 class="mb-3 text-2xl font-bold text-center text-green-700">Datos del Cliente</h1>

    <div class="flex flex-col space-y-4 md:flex-row md:space-y-0 md:space-x-4">
        <div class="flex flex-col w-full md:w-1/3">
            <label id="titulonombre">Nombre</label>
            <input type="text"
                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                id="nombreCliente" name="txtnombreCliente" placeholder="Nombre del cliente" required>
            {{--  @error('txtnombreCliente')
                <span class="text-red-500">{{ $message }}</span>
            @enderror --}}
        </div>

        <div id="tituloApellido" class="flex flex-col w-full md:w-1/3">
            <label>Apellido</label>
            <input type="text"
                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                id="apellidoCliente" name="txtapellidoCliente" placeholder="Apellidos del cliente" required>
        </div>
        <div class="flex flex-col w-full md:w-1/3 md:mr-2">
            <label class="mr-4">Atención</label>
            <input type="text"
                class="w-full px-3 py-1 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                id="inputNombreAtencion" name="txtatencion" placeholder="Nombre de la persona que atiende" required>
            </input>
        </div>

    </div>

    <div class="flex flex-col space-y-4 md:flex-row md:space-y-0 md:space-x-4">


        <div class="flex flex-col w-full md:w-1/2">
            <label>Telefono</label>
            <input type="text"
                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                id="telefono" name="txttelefono" placeholder="Numero de telefono" pattern="\d{10}" required
                title="Por favor ingrese exactamente 10 dígitos">
        </div>

        <div class="flex flex-col w-full md:w-1/2">
            <label for="rfc">RFC</label>
            <input type="text"
                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                id="rfc" name="txtrfc" placeholder="RFC">
        </div>
        <div class="flex flex-col w-full md:w-1/2">
            <label>Correo electronico</label>
            <input type="email"
                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                id="email" name="txtemail" placeholder="ecotoner@example.com">
        </div>
    </div>
    <div>
        <div class="flex flex-col w-full md:w-1/3">
            <label>Recibe</label>
            <input type="text"
                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                id="recibe" name="txtrecibe" placeholder="Nombre de la persona que recibe" required>
        </div>
    </div>

    <div>
        <div class="flex flex-col w-full md:w-1/3">
            <label>Clave</label>
            <input type="text"
                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                id="clave" name="txtclave" placeholder="Clave del cliente">
        </div>
    </div>

    <div class="flex flex-col w-full mt-8 md:w-full">
        <label class="mr-4">Direcciones registradas</label>
        <select
            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            id="inputDirecciones" name="id_direccion">
        </select>
    </div>
</section>

<button id="mostrarNuevaDireccion" class="mb-2 "> <i class="fas fa-plus"></i>Agregar nueva direccion</button>


<section id="nuevaDireccion" class="hidden px-3 pb-3 mb-3 border-4" >

    <h1 class="mb-2 text-2xl font-bold text-center text-green-700">Agregar nueva direccion</h1>



    <div class="flex flex-col space-y-4 md:flex-row md:space-y-0 md:space-x-4">

        <div class="flex flex-col w-full md:w-1/2 ">
            <label class="mr-4">Colonia</label>
            <select
                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                id="txtcolonia" name="nuevacolonia">
                <option value="null">Seleccione una colonia</option>
                @foreach ($ListaColonias as $colonia)
                    <option value="{{ $colonia->id }}">{{ $colonia->localidad }} - cp {{ $colonia->cp }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col w-full md:w-1/2">
            <label class="mr-4">Calles</label>
            <input type="text"
                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                id="calle" name="nuevacalle" placeholder="C. 2 Oriente y Av. 3 Sur">
        </div>

    </div>
    <div class="flex flex-col space-y-4 md:flex-row md:space-y-0 md:space-x-4">
        <div class="flex flex-col w-full md:w-1/2">
            <label class="mr-4">Numero Exterior</label>
            <input type="text"
                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                id="num_exterior" name="nuevonum_exterior" placeholder="1000">
        </div>


        <div class="flex flex-col w-full md:w-1/2">
            <label class="mr-4">Numero Interior</label>
            <input type="text"
                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                id="num_interior" name="nuevonum_interior" placeholder="b15">
        </div>
    </div>


    <div class="flex flex-col space-y-4 md:flex-row md:space-y-0 md:space-x-4">
        <div class="flex flex-col w-full md:w-full">
            <label>Referencia</label>
            <input type="text"
                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                id="referencia" name="nuevareferencia" placeholder="Referencia">
        </div>
    </div>
</section>
