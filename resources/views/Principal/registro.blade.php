@extends('adminlte::page')

@section('title', 'Venta')

@section('content_header')
    <h1>Venta</h1>
@stop

@section('content')
    <p>Registro.</p>

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
        document.addEventListener('DOMContentLoaded', (event) => {
            enviarDatosALaravel();
        });

        function enviarDatosALaravel() {
            // Crear un objeto para almacenar los datos
            let datos = {};

            // Iterar sobre los elementos almacenados en sessionStorage
            for (let i = 0; i < sessionStorage.length; i++) {
                let clave = sessionStorage.key(i);
                let valor = sessionStorage.getItem(clave);
                datos[clave] = valor;
            }

            // Enviar los datos a Laravel utilizando Ajax
            fetch('/guardarProductoVenta', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(datos)
                })
                .then(response => response.json())
                .then(data => console.log(data))
                .catch(error => console.error('Error:', error));
        }
    </script>
@stop
