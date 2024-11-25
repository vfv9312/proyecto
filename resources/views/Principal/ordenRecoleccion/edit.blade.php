@extends('layouts.admin')

@section('title', 'Estatus')



@section('content')
    <h1 class="mb-0 font-bold text-center ">Estatus {{$ordenRecoleccion->estado}}</h1>
    <form id="formularioEdit" class="" action="{{ route('orden_recoleccion.edit', ['orden_recoleccion' => $ordenRecoleccion->idPreventa]) }}"
        method="GET">
        @csrf
        @include('Principal.ordenRecoleccion._form_edit');
    </form>
    @include('Principal.ordenEntrega._modal_nuevo_producto')
    @include('Principal.ordenEntrega._modal')
    @include('Principal.ordenEntrega._modal_Descuentos')
@endsection

@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome para los iconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('js')
<script>let productRecargaUrl = "{{ route('product.Recarga') }}";
    let detallesProductoUrl = "{{ route('orden_recoleccion.detallesproducto') }}";
    let rutaGuardarProductoAjax = "{{ route('ordenEntrega.guardarProducto') }}"
    let servicio = {!! json_encode($ordenRecoleccion->tipoVenta) !!};
    let listaCompletaProductos = @json($listaProductos);
    let infoDeLaOrdenRecoleccion = @json($ordenRecoleccion);
</script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script src="{{ asset('js/InicioEditRecoleccion.js') }}"></script>

@endpush
