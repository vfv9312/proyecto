@extends('layouts.admin')

@section('title', 'Inicio')

@section('content')
    <style>
        input[type="text"] {
            text-transform: uppercase;
        }
    </style>

    <h1 class="font-bold text-center text-green-700 ">Registro de Orden de Entrega/Recoleccion</h1>
    <!-- mensaje de aviso que se registro el producto-->
    @if (session('correcto'))
        <div class="flex justify-center ">
            <div id="alert-correcto" class="w-64 px-4 py-2 mb-8 text-white bg-green-500 bg-opacity-50 rounded ">
                {{ session('correcto') }}
            </div>
        </div>
    @endif
    @if (session('incorrect'))
        <div id="alert-incorrect" class="px-4 py-2 text-white bg-red-500 rounded">
            {{ session('incorrect') }}
        </div>
    @endif

    <form id="formulario" class="flex flex-col justify-center mt-8 lg:ml-4" action="{{ route('orden_entrega.store') }}"
        method="POST">
        @csrf

        @include('Principal.ordenEntrega._form_orden')
        @include('Principal.ordenEntrega._Lista_Productos')
        @include('Principal.ordenEntrega._carro_campras')
        @include('Principal.ordenEntrega._horario_trabajo')

        <div class="flex justify-center mt-4">
            <button id="botonGuardar" type="submit"
                class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">
                <i class="mr-2 fas fa-save"></i>
                Guardar
            </button>
        </div>
    </form>
    @include('Principal.ordenEntrega._modal')
    @include('Principal.ordenEntrega._modal_nuevo_producto')
    @include('Principal.ordenEntrega._modal_Descuentos')
@endsection

@push('css')

    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome para los iconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endpush

@push('js')
<script src="{{ asset('js/Inicio.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

  <script>

        //pasamos los valores recibidos a variables js
        var datosClientes = @json($listaClientes);
        var datosDirecciones = @json($listaDirecciones);
        var datosAtencion = @json($listaAtencion);
        var datosHorarioTrabajo = @json($HorarioTrabajo);
        let inputLunesEntrada = $('#Lunes-Viernes_entrada');
        let inputLunesSalida = $('#Lunes-Viernes_salida');
        let inputSabadoEntrada = $('#Sabado_entrada');
        let inputSabadoSalida = $('#Sabado_salida');
        let inputDomingoEntrada = $('#Domingo_entrada');
        let inputDomingoSalida = $('#Domingo_salida');
        let inputHorarioInicio = $('#horarioTrabajoInicio');
        let inputHorarioFinal = $('#horarioTrabajoFinal');
        let horarioDiscontinuoLunesEntrada = $('#Lunes-ViernesDiscontinuo_entrada');
        let horarioDiscontinuoLunesSalida = $('#Lunes-ViernesDiscontinuo_salida');
        let horarioDiscontinuoSabadoEntrada = $('#SabadoDiscontinuo_entrada');
        let horarioDiscontinuoSabadoSalida = $('#SabadoDiscontinuo_salida');
        let horarioDiscontinuoDomingoEntrada = $('#DomingoDiscontinuo_entrada');
        let horarioDiscontinuoDomingoSalida = $('#DomingoDiscontinuo_salida');
        let selectAtencion = $('#inputAtiende');
        let inputrecibe = $('#recibe');
        //el select de direcciones se lo damos a la variable selectDirecciones
        var selectDirecciones = $('#inputDirecciones');
        //esta funcion entra al momento de interactuar con el select de cliente
          //botones y funciones para mostrar y ocultar modal
    // Obtén los elementos del DOM
    const modalRegistrarProducto = document.querySelector('#modalRegistrarProducto')
    const abrirnModalRegisrarProducto = document.querySelector('#Detalle');
    const cancelarModal = document.querySelector('.cerrarmodal');

        let datosDeProductos; //valor de los datos de producto

function actualizarListaProductos() {

    let productRecargaUrl = "{{ route('product.Recarga') }}";
    axios.post(productRecargaUrl, {
        productoRecarga: 'null'
    }).then(function(response) {
        // Aquí puedes manejar la respuesta de la solicitud
        datosDeProductos = response.data;

        let select = document.getElementById('producto');
        select.innerHTML = ''; // Vacía el select

        // Llena el select con los nuevos datos
        response.data.productos.forEach(function(producto) {
            let option = document.createElement('option');
            option.value = producto.id;
            option.setAttribute('data-precio', producto.precio);
            option.setAttribute('data-estatus', producto.estatus);
            option.setAttribute('data-idPrecio', producto.idPrecio);
            option.setAttribute('data-alternativoUno', producto.alternativo_uno);
            option.setAttribute('data-alternativoDos', producto.alternativo_dos);
            option.setAttribute('data-alternativoTres', producto.alternativo_tres);
            option.textContent = producto.nombre_comercial + '_' + producto.nombre_modo +
                '_' + producto.nombre_marca + '_' + producto.nombre_categoria + '_' +
                producto.nombre_color;
            select.appendChild(option);
        });
        // Por ejemplo, actualizar una parte del DOM con los nuevos datos
    }).catch(function(error) {
        // Aquí puedes manejar los errores de la solicitud
        console.error(error);
    });

}

  //Cuando entra y carga la pagina entra lo siguiente
document.addEventListener('DOMContentLoaded', function() {

    actualizarListaProductos();

    document.querySelector('#seleccionadorCliente').addEventListener('change', selectCliente);

    function selectCliente() {
        let esNuevoCliente = document.querySelector('#seleccionadorCliente').value;
        let contenedorOcultoClienteExistente = document.querySelector('#contenedorSelectCliente');
        let seleccionadorClienteInicio = document.querySelector('#inputCliente');
        let selectAtencion = $('#inputAtiende');
        let contenedorCliente = document.querySelector('#tipoCliente');
        let checkTipoCliente = document.getElementById('tipoDeCliente');

        switch (esNuevoCliente) {
            case 'NuevoCliente':
                seleccionadorClienteInicio.value = 'null';
                seleccionadorClienteInicio.dispatchEvent(new Event('change'));
                contenedorCliente.style.display = 'flex';
                selectAtencion.empty();
                checkTipoCliente.value = false;
                $('#inputDirecciones').empty();
                contenedorOcultoClienteExistente.classList.add('hidden');
                contenedorOcultoClienteExistente.classList.remove('flex');
                $('#telefono').val('');
                $('#rfc').val('');
                $('#email').val('');
                $('#nombreCliente').val('').prop('disabled', false);
                $('#apellidoCliente').val('').prop('disabled', false);

                contenedorEmpresaOCliente();
                $('#inputNombreAtencion').val('').prop('disabled', false);
                $('#recibe').val('');
                break;
            case 'ClienteExistente':

                contenedorCliente.style.display = 'none';
                contenedorOcultoClienteExistente.classList.remove('hidden');
                contenedorOcultoClienteExistente.classList.add('flex');
                break;
            default:
                break;
        }
    }




    //lo que escriba en nombre Cliente se escribe en el input del nombre de atencion
    document.getElementById('nombreCliente').addEventListener('input', cambioTipoCliente);

    function cambioTipoCliente() {
        var checkbox = document.getElementById('tipoDeCliente');
        if (!checkbox.checked) {
            document.getElementById('inputNombreAtencion').value = this.value + ' ' + document
                .getElementById('apellidoCliente').value;

            document.getElementById('recibe').value = this.value + ' ' + document
                .getElementById('apellidoCliente').value;
        }
    };

    document.getElementById('apellidoCliente').addEventListener('input', empresaOPersona);

    function empresaOPersona() {
        var checkbox = document.getElementById('tipoDeCliente');
        if (!checkbox.checked) {
            document.getElementById('inputNombreAtencion').value = document.getElementById(
                    'nombreCliente')
                .value + ' ' + this.value;

            document.getElementById('recibe').value = document.getElementById('nombreCliente')
                .value + ' ' + this.value;
        }
    };


    // Escuchar cambios en los campos txtcolonia y calle para limpiar los mensajes de error cuando se corrijan
    document.querySelector('#txtcolonia').addEventListener('input', function() {
        let inputDirecciones = document.querySelector('#inputDirecciones');
        inputDirecciones.setCustomValidity('');
    });
    document.querySelector('#calle').addEventListener('input', function() {
        let inputDirecciones = document.querySelector('#inputDirecciones');
        inputDirecciones.setCustomValidity('');
    });
    document.querySelector('#inputDirecciones').addEventListener('input', function() {
        this.setCustomValidity('');
    }); //Finaliza la funcion para las direcciones

});

//Rellenar formulario
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

                // Filtra los horarios para obtener solo los que pertenecen al cliente seleccionado
                var HorarioTrabajo = datosHorarioTrabajo.filter(function(horario) {
                    return horario.idCliente == clienteSeleccionado.id_cliente;
                });
                seleccionarTipoCliente.checked = false;


            }

            // Vacía los campos al incio
            $('#telefono').val('');
            $('#rfc').val('');
            $('#email').val('');
            $('#nombreCliente').val('').prop('disabled', false);
            $('#tituloApellido').css('display', 'inline');
            document.getElementById('titulonombre').textContent = 'Nombre';
            $('#apellidoCliente').val('').prop('disabled', false);
            $('#inputDirecciones').empty();
            $('#inputNombreAtencion').val('').prop('disabled', false);
            $('#clave').val('').prop('disabled', false);
            inputLunesEntrada.val('').prop('disabled', false);
            inputLunesSalida.val('').prop('disabled', false);
            // inputMartesEntrada.val('').prop('disabled', false);
            // inputMartesSalida.val('').prop('disabled', false);
            // inputMiercolesEntrada.val('').prop('disabled', false);
            // inputMiercolesSalida.val('').prop('disabled', false);
            // inputJuevesEntrada.val('').prop('disabled', false);
            // inputJuevesSalida.val('').prop('disabled', false);
            // inputViernesEntrada.val('').prop('disabled', false);
            // inputViernesSalida.val('').prop('disabled', false);
            inputSabadoEntrada.val('').prop('disabled', false);
            inputSabadoSalida.val('').prop('disabled', false);
            inputDomingoEntrada.val('').prop('disabled', false);
            inputDomingoSalida.val('').prop('disabled', false);
            horarioDiscontinuoLunesEntrada.val('').prop('disabled',false);
            horarioDiscontinuoLunesSalida.val('').prop('disabled',false);
            horarioDiscontinuoSabadoEntrada.val('').prop('disabled',false);
            horarioDiscontinuoSabadoSalida.val('').prop('disabled', false);
            horarioDiscontinuoDomingoEntrada.val('').prop('disabled',false);
            horarioDiscontinuoDomingoSalida.val('').prop('disabled',false);
            inputrecibe.val('');



            // Vacía el select de atención
            selectAtencion.empty();

            //si hay datos comenzamos a imprimir
            if (clienteSeleccionado) {
                $('#telefono').val(clienteSeleccionado.telefono_cliente);
                // Asegúrate de que los nombres de los campos en el objeto clienteSeleccionado coinciden con los nombres de los campos que estás tratando de rellenar
                // Por ejemplo, si el campo RFC se llama rfc_cliente en el objeto clienteSeleccionado, deberías usar clienteSeleccionado.rfc_cliente
                $('#rfc').val(clienteSeleccionado.comentario);
                $('#email').val(clienteSeleccionado.email);
                $('#nombreCliente').val(clienteSeleccionado.nombre_cliente).prop('disabled', true);
                $('#clave').val(clienteSeleccionado.clave).prop('disabled',false);

                if (clienteSeleccionado.apellido == ".") {
                    $('#apellidoCliente').val(clienteSeleccionado.apellido).prop('disabled', true);
                    $('#tituloApellido').css('display', 'none');
                    document.getElementById('titulonombre').textContent = 'Razon Social';
                } else {
                    $('#apellidoCliente').val(clienteSeleccionado.apellido).prop('disabled', true);
                    $('#tituloApellido').css('display', 'flex');
                    document.getElementById('titulonombre').textContent = 'Nombre';
                }


                //Esta parte es para filtrar el horario mas actual registrado y se lo damos a la variable
                if (HorarioTrabajo.length > 0) {
                    let ultimoHorario = HorarioTrabajo[HorarioTrabajo.length - 1];
                    //split separa la cadena despues del , y luego con filter solo se guardaran los que tengan datos despues del , en el array si esta vacio no
                    let horariosSalida = ultimoHorario.horaFinal.split(',').filter(Boolean);
                    let horariosEntrada = ultimoHorario.horaInicio.split(',').filter(Boolean);
                    let dias = ultimoHorario.dias.split(',');
                    inputrecibe.val(ultimoHorario.recibe);
                    dias.forEach((dia, index) => {
                        if (dia == 'Lunes-Viernes') {
                            inputLunesEntrada.val(horariosEntrada[index]);
                            inputLunesSalida.val(horariosSalida[index]);
                        }

                        else if (dia == 'Sabado') {
                            inputSabadoEntrada.val(horariosEntrada[index]);
                            inputSabadoSalida.val(horariosSalida[index]);
                        } else if (dia == 'Domingo') {
                            inputDomingoEntrada.val(horariosEntrada[index]);
                            inputDomingoSalida.val(horariosSalida[index]);
                        }   else if (dia == 'Lunes-ViernesDiscontinuo') {
                            horarioDiscontinuoLunesEntrada.val(horariosEntrada[index]);
                            horarioDiscontinuoLunesSalida.val(horariosSalida[index]);
                        }   else if (dia == 'SabadoDiscontinuo') {
                            horarioDiscontinuoSabadoEntrada.val(horariosEntrada[index]);
                            horarioDiscontinuoSabadoSalida.val(horariosSalida[index]);
                        }   else if (dia == 'DomingoDiscontinuo') {
                            horarioDiscontinuoDomingoEntrada.val(horariosEntrada[index]);
                            horarioDiscontinuoDomingoSalida.val(horariosSalida[index]);
                        }

                    });


                }

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
                        selectDirecciones.append(new Option(direccion.localidad + ', ' + direccion.calle +
                            ' #' +
                            direccion.num_exterior + ' - ' + direccion.num_interior + ' referencia: ' +
                            direccion.referencia, direccion
                            .id_direccion));

                    });

                } else {
                    // Si el cliente no tiene ninguna dirección registrada
                    selectDirecciones.append(new Option('No hay direcciones disponibles', ''));
                }
                //si clienteSeleccionado es null vacio todos los campos y habilita los bloqueados
            } else if (!clienteSeleccionado) {


                $('#telefono').val('');
                $('#rfc').val('');
                $('#email').val('');
                $('#nombreCliente').val('').prop('disabled', false);
                $('#apellidoCliente').val('').prop('disabled', false);
                $('#inputNombreAtencion').val('').prop('disabled', false);
                inputHorarioInicio.val('').prop('disabled', false);
                inputHorarioFinal.val('').prop('disabled', false);
                inputLunesEntrada.val('').prop('disabled', false);
                inputLunesSalida.val('').prop('disabled', false);
                // inputMartesEntrada.val('').prop('disabled', false);
                // inputMartesSalida.val('').prop('disabled', false);
                // inputMiercolesEntrada.val('').prop('disabled', false);
                // inputMiercolesSalida.val('').prop('disabled', false);
                // inputJuevesEntrada.val('').prop('disabled', false);
                // inputJuevesSalida.val('').prop('disabled', false);
                // inputViernesEntrada.val('').prop('disabled', false);
                // inputViernesSalida.val('').prop('disabled', false);
                inputSabadoEntrada.val('').prop('disabled', false);
                inputSabadoSalida.val('').prop('disabled', false);
                inputDomingoEntrada.val('').prop('disabled', false);
                inputDomingoSalida.val('').prop('disabled', false);
                horarioDiscontinuoLunesEntrada.val('').prop('disabled',false);
                horarioDiscontinuoLunesSalida.val('').prop('disabled',false);
                horarioDiscontinuoSabadoEntrada.val('').prop('disabled',false);
                horarioDiscontinuoSabadoSalida.val('').prop('disabled', false);
                horarioDiscontinuoDomingoEntrada.val('').prop('disabled',false);
                horarioDiscontinuoDomingoSalida.val('').prop('disabled',false);
                inputrecibe.val('');



                selectDirecciones.append(new Option('No hay direcciones disponibles', ''));
                // Vacía el select de atención
                selectAtencion.append(new Option('Nueva persona en atencion', ''));





                document.getElementById('nombreCliente').addEventListener('input', function() {
                    var tipodeCliente = document.getElementById('tipoDeCliente');

                    if (!tipodeCliente.checked) {

                        document.getElementById('inputNombreAtencion').value = this.value + ' ' + document
                            .getElementById('apellidoCliente').value;

                        document.getElementById('recibe').value = this.value + ' ' + document
                            .getElementById('apellidoCliente').value;
                    }
                });

                document.getElementById('apellidoCliente').addEventListener('input', function() {
                    var tipodeCliente = document.getElementById('tipoDeCliente');
                    if (!tipodeCliente.checked) {
                        document.getElementById('inputNombreAtencion').value = document.getElementById(
                                'nombreCliente')
                            .value + ' ' + this.value;

                        document.getElementById('recibe').value = document.getElementById('nombreCliente')
                            .value + ' ' + this.value;
                    }
                });
            }

        }

        //llamado para abrir un modal de un formulario para agregar un producto nuevo
document.getElementById('agregarProductoNuevo').addEventListener('click', function(evento) {
    evento.preventDefault();  // Prevenir el envío normal del formulario
    fetch("{{ route('orden_recoleccion.detallesproducto') }}", {
    method: 'GET',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
    })
    .then(response => response.json())
    .then(data => {
    //console.log(data);   Mostrar los datos en la consola para verificar
    // Mostrar los datos en el modal
    let content = '';  // Abrimos un formulario

    content += '<form id="formularioProductoNuevo" method="POST">'
    content += '<label class="flex flex-col items-start text-sm text-gray-500">'
    content += '<span>Nombre comercial</span>'
    content += '<input name="txtnombre" required class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />'
    content += '</label>';

    content += '<label class="flex flex-col items-start text-sm text-gray-500">'
    content += '<span>Modelo</span>'
    content += '<input name="txtmodelo" required class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />'
    content += '</label>';

    // Crear el select de marcas
    content += '<label class="flex flex-col items-start text-sm text-gray-500">';
    content += '<span>Marca</span>';
    content += '<select name="txtmarca" required class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none">'
    content += '<option value="">Selecciona una marca</option>'
    data.marcas.forEach(function(marca) {
    content += '<option value="' + marca.id + '">' + marca.nombre + '</option>';
    });
    content += '</select>';
    content += '</label>'

    // Crear el select de categorías
    content += '<label class="flex flex-col items-start text-sm text-gray-500">';
    content += '<span>Categoria</span>';
    content += '<select name="txttipo" required class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none">';
    content += '<option value="">Selecciona una una categoria</option>';
    data.categorias.forEach(function(categoria) {
    content += '<option value="' + categoria.id + '">' + categoria.nombre + '</option>';
    });
    content += '</select></label>';

    // Crear el select de modos
    content += '<label class="flex flex-col items-start text-sm text-gray-500">';
    content += '<span>Tipo</span>';
    content += '<select name="txtmodo" required class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none">';
    content += '<option value="">Selecciona un tipo</option>';
    data.modos.forEach(function(modo) {
    content += '<option value="' + modo.id + '">' + modo.nombre + '</option>';
    });
    content += '</select></label>';

    // Crear el select de colores
    content += '<label class="flex flex-col items-start text-sm text-gray-500">';
    content += '<span>Color</span>';
    content += '<select name="txtcolor" required class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none">';
    content += '<option value="">Selecciona un color</option>';
    data.colores.forEach(function(color) {
    content += '<option value="' + color.id + '">' + color.nombre + '</option>';
    });
    content += '</select></label>';

    content += '<label class="flex flex-col items-start text-sm text-gray-500">';
    content += '<span>precio</span>';
    content += '<input name="txtprecio" type="number" min="1" step="0.01" class="h-8 border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />';
    content += '</label>';

    content += '<label class="flex flex-col items-start text-sm text-gray-500">';
    content += '<span>precio alternativo 1</span>';
    content += '<input name="txtprecioalternativouno" type="number" min="1" step="0.01" class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none h-8 />';
    content += '</label>';

    content += '<label class="flex flex-col items-start text-sm text-gray-500">';
    content += '<span>precio alternativo 2</span>';
    content += '<input name="txtprecioalternativodos" type="number" min="1" step="0.01" class="h-8 border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />';
    content += '</label>';

    content += '<label class="flex flex-col items-start text-sm text-gray-500">';
    content += '<span>precio alternativo 3</span>';
    content += '<input name="txtprecioalternativotres" type="number" min="1" step="0.01" class="h-8 border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />';
    content += '</label>';

    content += '<label class="flex flex-col items-start text-sm text-gray-500">';
    content += '<label for="message" class="flex flex-col items-start text-lg text-gray-500">Descripcion</label>';
    content += '<textarea id="message" rows="4" name="txtdescripcion" class="block mb-3 p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border-2 border-blue-500 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escribe aqui la descripcion ...."></textarea>';
    content += '</label>';

    content += '<button id="AgregarProductoNuevoDB" class="px-4 py-2 text-white bg-blue-500 rounded">Guardar</button>';  // Botón de envío
    content += '</form>';  // Cerramos el formulario

    content += '<div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">';
    content += '<button type="button" id="cerrarmodalNuevoProducto" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-red-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">';
    content += '<i class="text-red-700 fas fa-sign-out-alt"></i> Salir';
    content+= '</button></div>';

    document.getElementById('modalAgregarProducto').classList.remove('hidden');  // Muestra el modal
        document.getElementById('modalContent').innerHTML = content;  // Inserta el contenido en el modal


                // Aquí añadimos el event listener al botón de guardar
        document.getElementById('AgregarProductoNuevoDB').addEventListener('click', function(e) {
            e.preventDefault();
             GuardarProductoNuevo();
        });

        document.getElementById('cerrarmodalNuevoProducto').addEventListener('click', function(e){
            e.preventDefault();
            document.getElementById('modalAgregarProducto').classList.add('hidden');  // Oculta el modal
        });
    })
    .catch(error => {
        console.error('Error al cargar los datos:', error);
        alert('Hubo un error al traer los detalles del producto.');
    });
});

// Guardado de un producto nuevo
//Formulario
function GuardarProductoNuevo() {

   // Crear el objeto FormData con los datos del formulario
            let formData = new FormData();
    formData.append('txtnombre', document.querySelector('[name="txtnombre"]').value);
    formData.append('txtmodelo', document.querySelector('[name="txtmodelo"]').value);
    formData.append('txtmarca', document.querySelector('[name="txtmarca"]').value);
    formData.append('txttipo', document.querySelector('[name="txttipo"]').value);
    formData.append('txtmodo', document.querySelector('[name="txtmodo"]').value);
    formData.append('txtcolor', document.querySelector('[name="txtcolor"]').value);
    formData.append('txtprecio', document.querySelector('[name="txtprecio"]').value);
    formData.append('txtprecioalternativouno', document.querySelector('[name="txtprecioalternativouno"]').value);
    formData.append('txtprecioalternativodos', document.querySelector('[name="txtprecioalternativodos"]').value);
    formData.append('txtprecioalternativotres', document.querySelector('[name="txtprecioalternativotres"]').value);
    formData.append('txtdescripcion', document.querySelector('[name="txtdescripcion"]').value);


    // Enviar los datos con AJAX
    fetch("{{ route('ordenEntrega.guardarProducto') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    }).
    then(data => {
        console.log(data);  // Manejar la respuesta
        alert('Producto guardado exitosamente');
        // Aquí puedes ocultar el modal o actualizar la página
    document.getElementById('modalAgregarProducto').classList.add('hidden');
    actualizarListaProductos();
    })
    .catch(error => {
        console.error('Error al guardar el producto:', error);
        alert('Hubo un error al guardar el producto.');
    });
};


    //Abre el modal para registrar un producto
abrirnModalRegisrarProducto.addEventListener('click', function() {
        modalRegistrarProducto.classList.remove('hidden');
});

    // Escucha el evento de click en el botón cancelar Modal de registro
cancelarModal.addEventListener('click', function() {
        // Oculta el modal
        modalRegistrarProducto.classList.add('hidden');
});

    //mmostrar los datos de detalles del modal
document.getElementById('Detalle').addEventListener('click', function() {
        let productoSeleccionado = document.getElementById('producto').value;


        let datosProductos = datosDeProductos.productos;
        let titulo = document.querySelector('#tituloDetalle');
        let categoria = document.querySelector('#CategoriaDetalle');
        let modelo = document.querySelector('#ModeloDetalle');
        let tipo = document.querySelector('#TipoDetalle');
        let color = document.querySelector('#ColorDetalle');
        let marca = document.querySelector('#MarcaDetalle');
        let precio = document.querySelector('#PrecioDetalle');
        let descripcion = document.querySelector('#descripcionDetalle');

        datosProductos.forEach(element => {

            if (productoSeleccionado == element.id) {

                titulo.innerText = element.nombre_comercial;
                categoria.innerText = 'Categoria : ' + element.nombre_categoria;
                modelo.innerText = 'Modelo : ' + element.modelo;
                tipo.innerText = 'Tipo : ' + element.nombre_modo;
                color.innerText = 'Color : ' + element.nombre_color;
                marca.innerText = 'Marca : ' + element.nombre_marca;
                precio.innerText = 'Precio : $' + element.precio;
                descripcion.innerText = 'Descripcion : ' + element.descripcion;


            } else if (productoSeleccionado == null) {
                titulo.innerText = 'Seleccione un producto';
            }
        });

}); //Finaliza la funcion que muestra datos del modal


</script>

<script src="{{ asset('js/fisicamoral.js')}}"></script>

<script src="{{ asset('js/modales.js')}}"></script>

@endpush
