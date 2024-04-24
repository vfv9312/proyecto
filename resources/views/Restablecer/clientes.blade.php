@extends('layouts.admin')

@section('title', 'Clientes')

@section('content')
    <h1 class=" font-bold text-center mb-8">Clientes</h1>

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


        <!--tabla-->

        <section class="overflow-x-auto">
            <table class="min-w-full">
                <!--La clase min-w-full hace que la tabla tenga al menos el ancho completo de su contenedor, lo que significa que se desplazará horizontalmente si es necesario.-->
                <tr class="text-black uppercase text-xs  font-bold leading-normal">
                    <td class="py-3 px-6 text-left border-r">Nombre</td>
                    <td class="py-3 px-6 text-left border-r">Telefono</td>
                    <td class="py-3 px-6 text-left border-r">Fecha de eliminación</td>
                    <td class="py-3 px-6 text-left border-r">Correo electronico</td>
                    <td class="py-3 px-6 text-left border-r">RFC</td>
                    <td class="py-3 px-6 text-left border-r">Direccion</td>
                </tr>

                <!--La clase min-w-full hace que la tabla tenga al menos el ancho completo de su contenedor, lo que significa que se desplazará horizontalmente si es necesario.-->

                @foreach ($clientes as $cliente)
                    <tr class= " border-b border-gray-200 text-sm">
                        <td class=" px-6 py-4">
                            {{ $cliente->nombre }} {{ $cliente->apellido }}</td>
                        <td class="px-6 py-4">
                            {{ $cliente->telefono }}
                        </td>
                        <td>{{ $cliente->deleted_at }}</td>

                        <td class="px-6 py-4">
                            {{ $cliente->email }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $cliente->comentario }}
                        </td>
                        <!--Formulario para enviar a editar el select de la direccion-->
                        <form action="{{ route('clientes.edit', $cliente->id) }}" method="get">
                            <td class="px-6 py-4">
                                <select id="direccionSelect" name="direccion"
                                    class="focus:ring-2 focus:ring-blue-300 focus:outline-none">
                                    @php
                                        //una bandera
                                        $direccionEncontrada = false;
                                    @endphp
                                    <!--for de direcciones-->
                                    @foreach ($direcciones as $direccion)
                                        <!--si id cliente es igual al id de direcciones que es el cliente entra-->
                                        @if ($cliente->id == $direccion->id)
                                            <option value="{{ $direccion->id_direccion }}">
                                                Col.{{ $direccion->localidad }}; {{ $direccion->calle }}
                                                #{{ $direccion->num_exterior }}</option>
                                            @php
                                                //si hay datos en direcciones la bandera es true pero si no pasa ningun dato en el for entonces no hay datos
                                                $direccionEncontrada = true;
                                                $valor = $direccion->id_direccion;
                                            @endphp
                                        @endif
                                    @endforeach
                                    @if (!$direccionEncontrada)
                                        <!--si es false entoces imprime No hay registros-->
                                        <option value="">No hay direcciones de registros</option>
                                    @endif
                                </select>
                            </td>
                        </form>

                        <td>
                            <!--Activar al cliente-->
                            <form method="POST" action="{{ route('Restablecer.actualizarcliente', $cliente->id) }}"
                                onsubmit="return confirm('¿Estás seguro de que quieres restablecer este cliente?');">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    class="border rounded px-6 py-4 bg-green-500 text-white cursor-pointer hover:bg-green-700 transition duration-200 ease-in-out"
                                    title="Restablecer cliente">
                                    <i class="fas fa-redo"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                    <!-- Aquí deberías mostrar otros datos del producto -->
                @endforeach
            </table>
            <div class=" mt-3">
                <p>Total de resultados: {{ $clientes->total() }}</p>
                {{ $clientes->links() }} <!-- Esto mostrará los enlaces de paginación -->
            </div>
    </main>
@endsection

@push('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <!-- Incluye jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Incluye Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Incluye Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endpush

@push('js')
    <script>
        //Oculta los elementos de alerta despues de 3 segundos
        window.setTimeout(function() {
            var alertCorrecto = document.getElementById('alert-correcto');
            var alertIncorrect = document.getElementById('alert-incorrect');
            if (alertCorrecto) alertCorrecto.style.display = 'none';
            if (alertIncorrect) alertIncorrect.style.display = 'none';
        }, 3000);


        //con esto buscamos rapido con lo que escribimos en el select lo que necesitamos
        $(document).ready(function() {
            $('#coloniaSelect').select2();
        });
    </script>
@endpush
