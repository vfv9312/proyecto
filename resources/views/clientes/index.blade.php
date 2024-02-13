@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Clientes</h1>
@stop

@section('content')
    <main class="w-full h-3/4">
        <!-- mensaje de aviso que se registro el producto-->
        @if (session('correcto'))
            <div class=" flex justify-center">
                <div id="alert-correcto" class="bg-green-500 bg-opacity-50 text-white px-4 py-2 rounded mb-8 w-64 ">
                    {{ session('correcto') }}
                </div>
            </div>
        @endif
        @if (session('incorrect'))
            <div id="alert-incorrect" class="bg-red-500 text-white px-4 py-2 rounded">
                {{ session('incorrect') }}
            </div>
        @endif
        <!-- boton anadir producto-->
        <button id="abrirnModalRegisrarProducto"
            class=" mb-4 bg-gradient-to-r from-green-500 via-green-500 to-yellow-500 text-white font-bold py-2 px-4 rounded-full">
            Añadir producto
        </button>
        <!-- Modal -->
        <div id="modalRegistrarProducto" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Fondo del modal -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <!-- Contenido del modal -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class=" text-center text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Registrar Producto
                        </h3>

                        <form method="POST" action="{{ route('productos.create') }}"
                            class=" mt-8 flex flex-col items-center">
                            @csrf
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Nombre comercial</span>
                                <input name="txtnombre"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Modelo</span>
                                <input name="txtmodelo"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Color</span>
                                <input name="txtcolor"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Marca</span>
                                <input name="txtmarca"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>precio</span>
                                <input name="txtprecio" type="number"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Descripcion</span>
                                <input name="txtdescripcion" type="text"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <label class="text-sm text-gray-500 flex flex-col items-start">
                                <span>Fotografia</span>
                                <input type="file"
                                    class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            </label>
                            <button type="submit" id="enviarmodal"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Aceptar
                            </button>

                        </form>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">

                        <button type="button"
                            class="cerrarmodal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!--tabla-->
        <h1>Listado</h1>
        <table>
            @foreach ($clientes as $cliente)
                <tr class= " border-b border-gray-200 text-sm">
                    <td class=" px-6 py-4">
                        {{ $cliente->nombre }}</td>
                    <td class="px-6 py-4">
                        {{ $cliente->apellido }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $cliente->telefono }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $cliente->email }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $cliente->direccion }}
                    </td>

                    <td>
                        <button
                            class="abrirModalEditar border rounded px-6 py-4 bg-green-500 text-white cursor-pointer hover:bg-green-700 transition duration-200 ease-in-out">
                            <i class="fas fa-edit"></i>
                        </button>

                    </td>
                    <td>
                        <button
                            class="border rounded px-6 py-4 bg-red-500 text-white cursor-pointer hover:bg-red-700 transition duration-200 ease-in-out">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>

                </tr>
                <!-- Aquí deberías mostrar otros datos del producto -->
            @endforeach
        </table>
        <div class=" mt-3">
            {{ $clientes->links() }} <!-- Esto mostrará los enlaces de paginación -->
        </div>
    </main>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
