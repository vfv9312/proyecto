<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
@php
    $total = 0;
@endphp

<body>
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
    <a
        href="https://administrativo.ecotonerdelsureste.com/orden_entrega_pdf/{{ $ordenRecoleccion->idRecoleccion }}/generarpdf">Descargue
        su folio del pedido</a>
</body>

</html>
