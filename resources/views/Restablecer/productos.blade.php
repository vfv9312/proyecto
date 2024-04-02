@extends('adminlte::page')

@section('title', 'productos')

@section('content_header')
    <h1 class=" text-center">Productos</h1>
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

        <!--tabla-->
        <section class="overflow-x-auto">
            <!--La clase overflow-x-auto hace que el div tenga un desplazamiento horizontal si su contenido es demasiado ancho para caber en la pantalla-->
            <table class="min-w-full">
                <!--La clase min-w-full hace que la tabla tenga al menos el ancho completo de su contenedor, lo que significa que se desplazará horizontalmente si es necesario.-->
                <tr class="text-black uppercase text-xs  font-bold leading-normal">
                    <td class="py-3 px-6 text-left border-r">Nombre comercial</td>
                    <td class="py-3 px-6 text-left border-r">Modelo</td>
                    <td class="py-3 px-6 text-left border-r">Color</td>
                    <td class="py-3 px-6 text-left border-r">Marca</td>
                    <td class="py-3 px-6 text-left border-r">Categoria</td>
                    <td class="py-3 px-6 text-left border-r">Tipo </td>
                    <td class="py-3 px-6 text-left border-r">Imagen</td>
                    <td class="py-3 px-6 text-left border-r">Precio</td>
                </tr>
                @foreach ($productos as $producto)
                    <tr class= " border-b border-gray-200 text-sm">
                        <td class=" px-6 py-4">
                            {{ $producto->nombre_comercial }}</td>
                        <td class="px-6 py-4">
                            {{ $producto->modelo }}
                        </td>
                        <td class="px-6 py-4">
                            @if ($producto->idColor == 1)
                                <div style="height:25px;width:25px;background-color:black;border-radius:50%;"></div>
                            @elseif ($producto->idColor == 2)
                                <div style="height:25px;width:25px;background-color:yellow;border-radius:50%;">
                                </div>
                            @elseif ($producto->idColor == 3)
                                <div style="height:33px;width:33px;background-color:cyan;border-radius:50%;"></div>
                            @elseif ($producto->idColor == 4)
                                <div style="height:33px;width:33px;background-color:magenta;border-radius:50%;"></div>
                            @elseif ($producto->idColor == 5)
                                <div
                                    style="background: linear-gradient(to right, cyan 33%, magenta 33%, magenta 66%, yellow 66%); border-radius: 50%; width: 33px; height: 33px;">
                                </div>
                            @elseif ($producto->idColor == 6)
                                <div
                                    style="background: linear-gradient(to right, cyan 25%, magenta 25%, magenta 50%, yellow 50%, yellow 75%, black 75%); border-radius: 50%; width: 33px; height: 33px;">
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            {{ $producto->nombreMarca }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $producto->nombreTipo }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $producto->nombreModo }}
                        </td>
                        <td class="px-6 py-4 flex justify-center items-center">
                            <img class=" w-20" src={{ $producto->fotografia }}>
                        </td>
                        <td class="px-6 py-4">
                            ${{ $producto->precio }}
                        </td>

                        <td>
                            <form action="{{ route('Restablecer.actualizarProducto', $producto->id) }}" method="POST"
                                onsubmit="return confirm('¿Estás seguro de que quieres restaurar este producto?');">
                                @csrf
                                @method('PUT')
                                <button title="Restablecer producto"
                                    class="border rounded px-6 py-4 bg-green-500 text-white cursor-pointer hover:bg-red-700 transition duration-200 ease-in-out">
                                    <i class="fas fa-redo"></i></button>
                            </form>
                        </td>

                    </tr>
                    <!-- Aquí deberías mostrar otros datos del producto -->
                @endforeach
            </table>
            <div class=" mt-3">
                <p>Total de resultados: {{ $productos->total() }}</p> <!--mostrar total de resultados-->
                {{ $productos->links() }} <!-- Esto mostrará los enlaces de paginación -->
            </div>
        </section>
    </main>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@stop

@section('js')
    <script>
        //Oculta los elementos de alerta despues de 3 segundos
        window.setTimeout(function() {
            var alertCorrecto = document.getElementById('alert-correcto');
            var alertIncorrect = document.getElementById('alert-incorrect');
            if (alertCorrecto) alertCorrecto.style.display = 'none';
            if (alertIncorrect) alertIncorrect.style.display = 'none';
        }, 3000);

        // Obtén los elementos del DOM
        const modalEditarRegistro = document.querySelector('#modalEditarRegistro');
        const modalRegistrarProducto = document.querySelector('#modalRegistrarProducto')
        const abrirModalEditar = document.querySelectorAll('.abrirModalEditar');
        const abrirnModalRegisrarProducto = document.querySelector('#abrirnModalRegisrarProducto');

        const cancelarModal = document.querySelector('.cerrarmodal');
        const cancelarModalEditar = document.querySelector('#cerrarModalEditar');

        // Selecciona todos los botones con la clase '.openModalButton'
        abrirModalEditar.forEach(button => {
            button.addEventListener('click', function() {
                // Muestra el modal
                modalEditarRegistro.classList.remove('hidden');
            });
        });
        //Abre el modal para registrar un producto
        abrirnModalRegisrarProducto.addEventListener('click', function() {
            modalRegistrarProducto.classList.remove('hidden');
        });

        // Escucha el evento de click en el botón cancelar Modal de registro
        cancelarModal.addEventListener('click', function() {
            // Oculta el modal
            modalRegistrarProducto.classList.add('hidden');
        });

        // Escucha el evento de click en el botón cancelar Modal de Editar
        cerrarModalEditar.addEventListener('click', function() {

            // Oculta el modal
            modalEditarRegistro.classList.add('hidden');
        });

        document.querySelector('input[name="txtprecio"]').addEventListener('input', function() {
            if (this.value < 1) {
                this.setCustomValidity('El precio debe ser mayor que 0');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>
@stop
