@extends('layouts.admin')

@section('title', 'Envio Correo')

@section('content')
    <div class="p-4 text-green-700 bg-green-100 border-l-4 border-green-500" role="alert">
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
            @php
            // Definir la parte variable de la URL según el tipo de venta
            $pdfType = ($ordenRecoleccion->tipoVenta == 'Orden Servicio') ? 'generarpdf2' : 'generarpdf';
             $rutaOrden = ($ordenRecoleccion->tipoVenta == 'Entrega') ? 'orden_entrega_pdf' : 'orden_servicio_pdf';

        @endphp

        <a href="https://administrativo.ecotonerdelsureste.com/{{$rutaOrden}}/{{ $ordenRecoleccion->idRecoleccion }}/{{ $pdfType }}">
            Descargue su folio del pedido
        </a>
        @endif

    </div>
@endsection

@push('css')
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome para los iconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@push('js')
    <script></script>
@endpush
