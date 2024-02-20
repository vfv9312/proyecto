@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')

    <h5 class=" text-center"> Hola <strong>{{ Auth::user()->name }}</strong> desde aqui podras registrar tus ventas de
        servicios o productos
    </h5>



@stop

@section('content')
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


    <form action="{{ route('inicio.guardarProductoVenta') }}" method="POST">
        @csrf
        <header class=" flex justify-between p-3">
            <h1>Productos</h1> <button type="submit" id="compras"
                class="fa fa-shopping-bag fa-2x text-red-500 cursor-pointer"><span
                    class="incrementar ml-2 text-sm text-green-500">0</span></button>
        </header>
        <section class="flex flex-wrap">
            @foreach ($productos as $producto)
                <div
                    class=" m-3 pb-10 bg-white cursor-pointer w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 h-72 border rounded-lg hover:shadow-lg hover:bg-black hover:bg-opacity-30">
                    <figure class=" relative mb-3 w-full h-4/5">
                        <span
                            class=" absolute bottom-0 left-0  bg-green-500 rounded-lg text-sm m-2">{{ $producto->marca }}</span>
                        <img class=" w-full h-full object-cover rounded-lg" src="{{ $producto->fotografia }}"
                            alt="producto" />
                        <div
                            class=" absolute top-0 right-0 flex justify-center items-center bg-green-600 w-6 h-6 rounded-full m-2">
                            <i class="fas fa-plus"></i>
                        </div>
                    </figure>

                    <p class=" flex flex-col">
                        <span class=" text-sm font-light truncate">{{ $producto->nombre_comercial }}</span>
                        <span class=" text-lg font-bold truncate">$ {{ $producto->precio }}</span>
                    </p>
                    <p class="flex justify-between">
                        <span>Cantidad</span>
                        <input type="hidden" name="producto_id[]" value="{{ $producto->id }}">
                        <input type="number" class="suma form-input w-20 mr-4" name="cantidad[]" value="0">
                    </p>

                </div>
            @endforeach
        </section>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome para los iconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener el span y todos los inputs con la clase "suma"
            var spanIncrementar = document.querySelector('.incrementar');
            var inputsSuma = document.querySelectorAll('.suma');

            // Agregar evento de escucha a todos los inputs
            inputsSuma.forEach(function(input) {
                input.addEventListener('input', function() {
                    // Calcular la suma total de todos los inputs
                    var sumaTotal = 0;
                    inputsSuma.forEach(function(input) {
                        sumaTotal += parseInt(input.value) ||
                            0; // Asegurarse de que el valor sea un número válido
                    });

                    // Actualizar el contenido del span con la suma total
                    spanIncrementar.textContent = sumaTotal;
                });
            });
        });
        /*
        function incrementarProducto(id_Producto) {
            // Verificar si el id_Producto ya existe en sessionStorage
            if (sessionStorage.getItem(id_Producto)) {
                // Si existe, obtener el valor, incrementarlo en 1 y guardarlo de nuevo
                let incrementar = parseInt(sessionStorage.getItem(id_Producto));
                incrementar++;
                sessionStorage.setItem(id_Producto, incrementar);
            } else {
                // Si no existe, inicializarlo con 1
                sessionStorage.setItem(id_Producto, 1);
            }
            // Actualizar el contenido del span
            span.textContent = obtenerTotal();
        }

        // Obtener el elemento span
        let span = document.querySelector('.incrementar');

        function obtenerTotal() {
            let total = 0;
            for (let i = 0; i < sessionStorage.length; i++) {
                let clave = sessionStorage.key(i);
                let valor = parseInt(sessionStorage.getItem(clave));
                total += valor;
            }
            return total;
        }
        let valorIndividual = document.querySelector('.cantidadIndividual');
        // Inicializar el contenido del span
        span.textContent = obtenerTotal();*/
    </script>
@stop
