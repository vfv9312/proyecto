@extends('adminlte::page')

@section('title', 'Orden de servicio')

@section('content_header')
@stop

@section('content')
    <!-- boton anadir producto-->
    <button id="myBtn"
        class=" mt-4 bg-gradient-to-r from-gray-800 via-gray-600 to-green-500 text-white font-bold py-2 px-4 rounded-full">
        <i class="fas fa-shopping-basket"></i> Añadir producto
    </button>

    <form class="mt-8 flex flex-col justify-center " action="{{ route('orden_servicio.store') }}" method="POST"
        enctype="multipart/form-data">
        @csrf

        @include('Principal.ordenServicio._form_cliente')

        <div id="myModal" class="modal">
            <div class="modal-content h-screen">
                <span class="close cursor-pointer mb-4"><i class="fas fa-times"></i></span>
                @include('Principal.ordenServicio._form_producto')
            </div>
        </div>

    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Incluir las librerías de jQuery y Select2 -->
    <!-- CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $('#mostrarNuevaDireccion').click(function(event) {
            event.preventDefault();
            $('#nuevaDireccion').toggle();
        });

        function validarRFCOpcional(input) {
            var regex = /^[A-ZÑ&]{3,4}\d{6}(?:[A-Z\d]{3})?$/;
            if (input.value.trim() !== '' && !regex.test(input.value)) {
                input.setCustomValidity(
                    'RFC inválido deben ser 3 o 4 letras mayusculas, seguido de 6 dígitos y 3 alfanumericos');
            } else {
                input.setCustomValidity('');
            }
        }

        //este ayuda a buscar en datos en el select
        $(document).ready(function() {
            $('#txtcolonia').select2();
            $('#inputAtencion').select2();
            $('#inputCliente').select2();
        });
        //pasamos los valores recibidos a variables js
        var datosClientes = @json($listaClientes);
        var datosDirecciones = @json($listaDirecciones);
        let datosAtencion = @json($listaAtencion);

        let selectAtencion = $('#inputAtiende');
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

                // Filtra los nombres de atención para obtener solo los que pertenecen al cliente seleccionado
                var atencionCliente = datosAtencion.filter(function(atencion) {
                    return atencion.id_cliente == clienteSeleccionado.id_cliente;
                });
            }

            // Vacía los campos al incio
            $('#inputAtiende').val('');
            $('#telefono').val('');
            $('#rfc').val('');
            $('#email').val('');
            $('#nombreCliente').val('').prop('disabled', false);
            $('#apellidoCliente').val('').prop('disabled', false);
            $('#inputDirecciones').empty();
            $('#inputNombreAtencion').val('').prop('disabled', false);
            // Vacía el select de atención
            selectAtencion.empty();


            //si hay datos comenzamos a imprimir
            if (clienteSeleccionado) {
                $('#inputAtiende').val(clienteSeleccionado.nombre_cliente + ' ' + clienteSeleccionado.apellido);
                $('#telefono').val(clienteSeleccionado.telefono_cliente);
                // Asegúrate de que los nombres de los campos en el objeto clienteSeleccionado coinciden con los nombres de los campos que estás tratando de rellenar
                // Por ejemplo, si el campo RFC se llama rfc_cliente en el objeto clienteSeleccionado, deberías usar clienteSeleccionado.rfc_cliente
                $('#rfc').val(clienteSeleccionado.comentario);
                $('#email').val(clienteSeleccionado.email);
                $('#nombreCliente').val(clienteSeleccionado.nombre_cliente).prop('disabled', true);
                $('#apellidoCliente').val(clienteSeleccionado.apellido).prop('disabled', true);

                selectAtencion.empty();
                // Si atencionCliente tiene datos, los añade al select de atención
                if (atencionCliente && clienteSeleccionado) {
                    selectAtencion.append(new Option('Nueva persona en atencion', ''));
                    atencionCliente.forEach(function(atencion) {
                        selectAtencion.append(new Option(atencion.nombre_atencion, atencion.id));
                    });


                } else {
                    // Si el cliente no tiene ningún nombre de atención registrado
                    selectAtencion.append(new Option('No hay nombres de atención disponibles', ''));
                }

                // Agrega un evento de cambio al select de atención
                selectAtencion.on('change', function() {
                    // Obtén el valor seleccionado en el select de atención
                    var atencionSeleccionada = $(this).val();
                    // Si se ha seleccionado una atención

                    // Si se encontró la atención, actualiza el valor del campo txtatencion
                    if (atencionSeleccionada) {
                        $('#inputNombreAtencion').val(atencionSeleccionada).prop('disabled', true);

                    } else {
                        // Si no se seleccionó ninguna atención, vacía el campo txtatencion
                        $('#inputNombreAtencion').val('').prop('disabled', false);
                    }
                });

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
                $('#inputNombreAtencion').val('').prop('disabled', false);
                // Vacía el select de atención
                selectAtencion.append(new Option('Nueva persona en atencion', ''));
            }
        }

        // Obtén el modal
        var modal = document.getElementById("myModal");

        // Obtén el botón que abre el modal
        var btn = document.getElementById("myBtn");

        // Obtén el elemento <span> que cierra el modal
        var span = document.getElementsByClassName("close")[0];

        // Cuando el usuario haga clic en el botón, abre el modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // Cuando el usuario haga clic en <span> (x), cierra el modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Cuando el usuario haga clic en cualquier lugar fuera del modal, cierra el modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
@stop
