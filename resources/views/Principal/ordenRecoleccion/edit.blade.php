@extends('layouts.admin')

@section('title', 'Estatus')



@section('content')
    <h1 class="mb-8 text-center">Estatus</h1>
    <form class=""
        action="{{ route('orden_recoleccion.edit', ['orden_recoleccion' => $datosEnvio->idOrden_recoleccions]) }}"
        method="GET">
        @csrf
        @include('Principal.ordenRecoleccion._form_edit');
    </form>
@endsection

@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome para los iconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@push('js')
    <script>
        var servicio = {!! json_encode($datosEnvio->estatusPreventa) !!};

        function mostrarInputCosto(value) {
            var inputCosto = document.getElementById('inputCosto');
            let inputFactura = document.querySelector('#inputFactura');
            let inputmetodopago = document.querySelector('#inputmetodopago');
            var inputPersonaRecibe = document.getElementById('personaRecibe');
            var inputs = document.querySelectorAll('input[name^="costo_unitario"]');
            let codigo = document.querySelector('#form_codigo');
            let observaciones = document.querySelector('#form_observaciones')

            inputs.forEach(input => {
                if (value == '2') {
                    input.required = true;
                    input.readOnly = false;
                } else {
                    input.required = false;
                    input.readOnly = true;
                }
            });

            if (value == '1') { // Si se selecciona "Venta completa"
                inputPersonaRecibe.style.display = 'block';
            } else if (value == '2' && servicio ==
                4) { // Si el valor seleccionado es "En entrega" y el estatus de preventa es servicio
                inputCosto.style.display = 'block';
                inputFactura.style.display = 'flex';
                inputmetodopago.style.display = 'block';
            } else if (value == '3') {
                codigo.style.display = 'block';
            } else if (value == '5') {
                observaciones.clasList.add('flex');
            } else {
                inputCosto.style.display = 'none';
                inputFactura.style.display = 'none';
                inputmetodopago.display = 'none';
                inputPersonaRecibe.style.display = 'none';
                codigo.style.display = 'none';
                observaciones.style.display = 'none';
            }
        }



        function calcularTotal() {
            var inputs = document.querySelectorAll('input[name^="costo_unitario"]');
            var total = 0;
            inputs.forEach(input => {
                var cantidad = Number(input.dataset.cantidad);
                total += Number(input.value);

            });
            document.querySelector('input[name="costo_total"]').value = total.toFixed(2);
            let cambio = document.querySelector('#cambio');
            let costo = document.querySelector('#costo');
            let pagaCon = document.querySelector('#pagoEfectivo');

            cambio.value = pagaCon.value - costo.value;
        }

        // Llama a la función calcularTotal cada vez que cambia un input
        document.querySelectorAll('input[name^="costo_unitario"]').forEach(input => {
            input.addEventListener('change', calcularTotal);
        });

        // Calcula el total inicial
        calcularTotal();

        // Calcula el total inicial
        calcularTotal();

        document.getElementById('metodoPago').addEventListener('change', function() {
            var inputPagoEfectivo = document.getElementById('inputPagoEfectivo');
            if (this.value == 'Efectivo') {
                inputPagoEfectivo.style.display = 'block';
                let cambio = document.querySelector('#cambio');
                let costo = document.querySelector('#costo');
                let pagaCon = document.querySelector('#pagoEfectivo');

                cambio.value = pagaCon.value - costo.value;
            } else {
                inputPagoEfectivo.style.display = 'none';
            }
        });

        document.querySelector('#pagoEfectivo').addEventListener('input', function() {
            let cambio = document.querySelector('#cambio');
            let costo = document.querySelector('#costo');
            let pagaCon = document.querySelector('#pagoEfectivo');

            cambio.value = pagaCon.value - costo.value;



        });
    </script>
@endpush
