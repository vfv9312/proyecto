@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <h1 class=" text-center">Ecotoner</h1>
@stop

@section('content')
    <h5 class=" text-center"> Hola <strong>{{ Auth::user()->name }}</strong> desde aqui podras registrar tus ventas de
        servicios o productos
    </h5>
    <div class="row">
        <x-adminlte-input name="iLabel" label="Label" placeholder="placeholder" fgroup-class="col-md-6" disable-feedback />
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
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
