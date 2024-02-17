@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <header class=" flex justify-between p-3">
        <h1>Productos</h1> <i class="fa fa-shopping-bag fa-2x text-red-500 cursor-pointer"><span
                class="ml-2 text-sm text-green-500">0</span></i>
    </header>
@stop

@section('content')


    <h5 class=" text-center"> Hola <strong>{{ Auth::user()->name }}</strong> desde aqui podras registrar tus ventas de
        servicios o productos
    </h5>

    <section class="flex flex-wrap">
        <div
            class=" m-3 bg-white cursor-pointer w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 h-60 border rounded-lg hover:shadow-lg hover:bg-black hover:bg-opacity-30">
            <figure class=" relative mb-3 w-full h-4/5">
                <span class=" absolute bottom-0 left-0  bg-white/60 rounded-lg text-xs m-2">Tinta</span>
                <img class=" w-full h-full object-cover rounded-lg"
                    src="https://media.istockphoto.com/id/1373017594/es/foto/auriculares-sobre-fondo-de-color-naranja.jpg?s=1024x1024&w=is&k=20&c=LGG4dNZpoACIjoYV3rUCQcA4d93R3otVuqMxOFDCwus="
                    alt="producto" />
                <div class=" absolute top-0 right-0 flex justify-center items-center bg-green-600 w-6 h-6 rounded-full m-2">
                    <i class="fas fa-plus"></i>
                </div>
            </figure>

            <p class=" flex justify-between">
                <span class=" text-sm font-light">Nike</span>
                <span class=" text-lg font-bold">$80</span>
            </p>
        </div>
    </section>

    <div class="row">
        <x-adminlte-input name="iLabel" label="Label" placeholder="placeholder" fgroup-class="col-md-6"
            disable-feedback />
    </div>

    <form method="POST" action="" class="max-w-xl mx-auto p-6 space-y-6">
        @csrf
        <div class="flex flex-col">
            <label for="nombre_cliente">Nombre del cliente</label>
            <input type="text" id="nombre_cliente" name="nombre_cliente">
        </div>
        <div class="flex flex-col">
            <label for="apellidos">Apellidos</label>
            <input type="text" id="apellidos" name="apellidos">
        </div>
        <div class="flex flex-col">
            <label for="direccion">Dirección</label>
            <input type="text" id="direccion" name="direccion">
        </div>
        <div class="flex flex-col">
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono">
        </div>
        <div class="flex flex-col">
            <label for="nombre_empleado">Nombre del empleado que atiende</label>
            <input type="text" id="nombre_empleado" name="nombre_empleado">
        </div>
        <div class="flex flex-col">
            <label for="numero_recarga">Número de recarga</label>
            <input type="text" id="numero_recarga" name="numero_recarga">
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
        <div class="flex flex-col">
            <label for="cantidad_producto">Cantidad de producto</label>
            <input type="number" id="cantidad_producto" name="cantidad_producto" class="p-2 border rounded-md">
        </div>
        <div class="flex flex-col">
            <label for="nombre_producto">Nombre del producto</label>
            <input type="text" id="nombre_producto" name="nombre_producto" class="p-2 border rounded-md">
        </div>
        <div class="flex flex-col">
            <label for="precio_unitario">Precio unitario</label>
            <input type="number" step="0.01" id="precio_unitario" name="precio_unitario" class="p-2 border rounded-md">
        </div>
        <div class="flex flex-col">
            <label for="importe">Importe</label>
            <input type="number" step="0.01" id="importe" name="importe" class="p-2 border rounded-md">
        </div>
        <div class="flex flex-col">
            <label for="costo_total">Costo total</label>
            <input type="number" step="0.01" id="costo_total" name="costo_total" class="p-2 border rounded-md">
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
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
