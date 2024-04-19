@extends('layouts.admin')

@section('title', 'Estatus')



@section('content')
    <h1 class="mb-8">Estatus</h1>
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
                inputmetodopago.style.display = 'block'
            } else {
                inputCosto.style.display = 'none';
                inputFactura.style.display = 'none';
                inputmetodopago.display = 'none';
                inputPersonaRecibe.style.display = 'none';
            }
        }

        function calcularTotal() {
            var inputs = document.querySelectorAll('input[name^="costo_unitario"]');
            var total = 0;
            inputs.forEach(input => {
                var cantidad = Number(input.dataset.cantidad);
                total += Number(input.value) * cantidad;
            });
            document.querySelector('input[name="costo_total"]').value = total.toFixed(2);
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
            } else {
                inputPagoEfectivo.style.display = 'none';
            }
        });
    </script>
@endpush
