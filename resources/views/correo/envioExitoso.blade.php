@extends('adminlte::page')

@section('title', 'Envio por correo')

@section('content_header')
    <h1>Envío de correo</h1>
@stop

@section('content')
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
        <p class="font-bold">
            {{ $error ? $error : '¡Correo enviado con éxito!' }}
        </p>
        {{ $error ? $error : 'El correo electrónico ha sido enviado con éxito a la dirección proporcionada.' }}
        <hr class="my-2">
        @if ($error == false)
            @php
                $total = 0;
            @endphp
            <h1> Detalles de la entrega </h1>
            <p>Nombre del cliente: {{ $ordenRecoleccion->nombreCliente }} {{ $ordenRecoleccion->apellidoCliente }}</p>
            <p>Nombre de la persona que atendera: {{ $ordenRecoleccion->nombreAtencion }}</p>
            <p>Dirección: {{ $ordenRecoleccion->localidad }}; {{ $ordenRecoleccion->calle }}
                {{ $ordenRecoleccion->num_exterior }}
                {{ $ordenRecoleccion->num_interior ? 'N° interior' . $ordenRecoleccion->num_interior : '' }}</p>
            <p>Referencia :{{ $ordenRecoleccion->referencia }}</p>
            <p>Codigo Postal : {{ $ordenRecoleccion->cp }}</p>
            <p>Número de teléfono: {{ $ordenRecoleccion->telefonoCliente }}</p>
            <p>Correo: {{ $ordenRecoleccion->correo }}</p>
            @foreach ($listaProductos as $producto)
                <p>Producto: {{ $producto->nombre_comercial }}</p>
                <p>Color : {{ $producto->nombreColor }}, Marca : {{ $producto->nombreMarca }}, Tipo :
                    {{ $producto->nombreModo }}, Categoria : {{ $producto->nombreTipo }}, Cantidad:
                    {{ $producto->cantidad }}</p>
                <p style="margin-bottom: 10px;">Precio: ${{ $producto->precio * $producto->cantidad }}</p>
                @php
                    $total += $producto->precio * $producto->cantidad;
                @endphp
            @endforeach
            <h1> Datos del pago </h1>
            <p>Requiere : {{ $ordenRecoleccion->factura ? 'Factura' : 'Nota' }}</p>
            <p>Metodo de pago : {{ $ordenRecoleccion->metodoPago }}</p>
            Costo total : ${{ $total }}<br>
            {{ $ordenRecoleccion->metodoPago == 'Efectivo' ? 'Paga con : $' . $ordenRecoleccion->pagoEfectivo : '' }}
            <p>{{ $ordenRecoleccion->metodoPago == 'Efectivo' ? 'Cambio : $' . number_format($ordenRecoleccion->pagoEfectivo - $total, 2) : '' }}
            </p>
            @if ($ordenRecoleccion->estatusVenta)
                <a href="https://administrativo.ecotonerdelsureste.com/ventas/{{ $ordenRecoleccion->idVenta }}">Descargue
                    su folio del pedido</a>
            @else
                <a
                    href="https://administrativo.ecotonerdelsureste.com/orden_entrega_pdf/{{ $ordenRecoleccion->idRecoleccion }}/generarpdf">Descargue
                    su folio del pedido</a>
            @endif

        @endif

    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script></script>
@stop
