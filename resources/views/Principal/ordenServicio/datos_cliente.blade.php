@extends('adminlte::page')

@section('title', 'Orden de servicio')

@section('content_header')
    <h1>Datos de cliente</h1>
@stop

@section('content')
    <form class="mt-8 flex flex-col justify-center " action="{{ route('orden_servicio.store') }}" method="POST"
        enctype="multipart/form-data">
        @csrf

        @include('Principal.ordenServicio._form_cliente')

    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Incluir las librerías de jQuery y Select2 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@stop

@section('js')
    <script>
        $('#mostrarNuevaDireccion').click(function(event) {
            event.preventDefault();
            $('#nuevaDireccion').toggle();
        });
        //este ayuda a buscar en datos en el select
        $(document).ready(function() {
            $('.select2').select2();
            $('#txtcolonia').select2();
            $('#inputCliente').select2();
        });
        //pasamos los valores recibidos a variables js
        var datosClientes = @json($listaClientes);
        var datosDirecciones = @json($listaDirecciones);
        //el select de direcciones se lo damos a la variable selectDirecciones
        var selectDirecciones = $('#inputDirecciones');
        //esta funcion entra al momento de interactuar con el select de cliente
        function rellenarFormulario() {
            //el id que esta en value del select va almacenar en la variable clienteId
            var clienteId = $('#inputCliente').val();
            //buscamos el id del cliente en el array de objetos de direcciones
            //y retornaremos el valor del id cuando sea identico y si no hay coincidencias sera null
            var clienteSeleccionado = datosClientes.find(function(cliente) {
                return cliente.id_cliente == clienteId;
            }) || null;

            //si hay valores en la variable clienteSeleccionado entonces entra esto para no marcar error en consola
            if (clienteSeleccionado) {
                // Filtra las direcciones para obtener solo las que pertenecen al cliente seleccionado
                var direccionesCliente = datosDirecciones.filter(function(direccion) {
                    return direccion.id_cliente == clienteSeleccionado.id_cliente;
                });
            }


            // Vacía los campos al incio
            $('#telefono').val('');
            $('#rfc').val('');
            $('#email').val('');
            $('#nombreCliente').val('').prop('disabled', false);
            $('#apellidoCliente').val('').prop('disabled', false);
            $('#inputDirecciones').empty();

            //si hay datos comenzamos a imprimir
            if (clienteSeleccionado) {

                $('#telefono').val(clienteSeleccionado.telefono_cliente);
                // Asegúrate de que los nombres de los campos en el objeto clienteSeleccionado coinciden con los nombres de los campos que estás tratando de rellenar
                // Por ejemplo, si el campo RFC se llama rfc_cliente en el objeto clienteSeleccionado, deberías usar clienteSeleccionado.rfc_cliente
                $('#rfc').val(clienteSeleccionado.comentario);
                $('#email').val(clienteSeleccionado.email);
                $('#nombreCliente').val(clienteSeleccionado.nombre_cliente).prop('disabled', true);
                $('#apellidoCliente').val(clienteSeleccionado.apellido).prop('disabled', true);


                // Vacía el select de direcciones
                selectDirecciones.empty();
                //si direccionesCliente tiene datos entra
                if (direccionesCliente && clienteSeleccionado) {
                    selectDirecciones.append(new Option('Buscar Direccion', ''));
                    direccionesCliente.forEach(function(direccion) {
                        selectDirecciones.append(new Option(direccion.localidad + ', ' + direccion.calle + ' #' +
                            direccion.num_exterior + ' - ' + direccion.num_interior + ' referencia: ' +
                            direccion.referencia, direccion
                            .id));
                    });

                } else {
                    // Si el cliente no tiene ninguna dirección registrada
                    selectDirecciones.append(new Option('No hay direcciones disponibles', ''));
                }
                //si clienteSeleccionado es null vacio todos los campos y habilita los bloqueados
            } else if (!clienteSeleccionado) {
                console.log('no entro');
                $('#telefono').val('');
                $('#rfc').val('');
                $('#email').val('');
                $('#nombreCliente').val('').prop('disabled', false);
                $('#apellidoCliente').val('').prop('disabled', false);
                selectDirecciones.append(new Option('No hay direcciones disponibles', ''));
            }
        }
    </script>
@stop
