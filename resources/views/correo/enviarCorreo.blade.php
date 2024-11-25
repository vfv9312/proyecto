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

    @php
    // Definir la parte variable de la URL según el tipo de venta
    $pdfType = ($ordenRecoleccion->tipoVenta == 'Orden Servicio') ? 'generarpdf2' : 'generarpdf';
@endphp

<a href="https://administrativo.ecotonerdelsureste.com/orden_entrega_pdf/{{ $ordenRecoleccion->idRecoleccion }}/{{ $pdfType }}">
    Descargue su folio del pedido
</a>

</body>

</html>
