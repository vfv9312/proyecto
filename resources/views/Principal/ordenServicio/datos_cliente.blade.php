@extends('adminlte::page')

@section('title', 'Orden de servicio')

@section('content_header')
@stop

@section('content')


    <form class="mt-8 flex flex-col justify-center " action="{{ route('orden_servicio.store') }}" method="POST"
        enctype="multipart/form-data">
        @csrf

        @include('Principal.ordenServicio._form_cliente')
        @include('Principal.ordenServicio._form_lista_productos')
        @include('Principal.ordenServicio._carro_campras')
        <div class="mt-4 flex justify-center">
            <button type="submit" class="px-4 py-2  bg-green-500 text-white rounded hover:bg-green-700">
                <i class="fas fa-save"></i> Guardar
            </button>

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
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('#formulario').addEventListener('submit', function(event) {
                let inputDirecciones = document.querySelector('#inputDirecciones');
                let txtcolonia = document.querySelector('#txtcolonia');
                let calle = document.querySelector('#calle');
                let cambioInput = document.querySelector(
                    '#cambioInput'); // Obtener el campo de entrada de cambio


                // Verificar si no se seleccionó una dirección existente y tampoco se ingresó una nueva
                if (inputDirecciones.value === '' && txtcolonia.value === 'null' && calle.value.trim() ===
                    '') {
                    event.preventDefault();

                    // Establecer un mensaje de error personalizado y marcar el campo como inválido
                    inputDirecciones.setCustomValidity(
                        'Debes seleccionar una dirección existente o ingresar una nueva.');
                    inputDirecciones.reportValidity();
                } else {
                    // Si los campos son válidos, limpiar cualquier mensaje de error anterior
                    inputDirecciones.setCustomValidity('');
                }

                // Verificar si el cambio es menor que 0
                if (parseFloat(cambioInput.value) < 0) {
                    event.preventDefault();

                    // Establecer un mensaje de error personalizado y marcar el campo como inválido
                    cambioInput.setCustomValidity('El cambio no puede ser menor que 0.');
                    cambioInput.reportValidity();
                } else {
                    // Si el campo es válido, limpiar cualquier mensaje de error anterior
                    cambioInput.setCustomValidity('');
                }
            });

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
            });
        });

        $('#mostrarNuevaDireccion').click(function(event) {
            event.preventDefault();
            $('#nuevaDireccion').toggle();
        });

        function validarRFCOpcional(input) {
            var regex = /^[A-ZÑ&]{3,4}\d{6}(?:[A-Z\d]{3})?$/;
            if (input.value.trim() !== '' && !regex.test(input.value)) {
                input.setCustomValidity(
                    'RFC inválido deben ser 3 o 4 letras mayusculas, seguido de 6 dígitos y 3 alfanumericos'
                );
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
        let datosRecoleccion = @json($datosRecoleccion);

        let inputRecibe = $('#recibe');
        let inputEntrega = $('#entrega');
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

                var recibeCliente = datosRecoleccion.filter(function(recibe) {
                    return recibe.idCliente == clienteSeleccionado.id_cliente;
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
            inputRecibe.val('').prop('disabled', false);
            inputEntrega.val('').prop('disabled', false);
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
                if (recibeCliente.length > 0) {
                    inputRecibe.val(recibeCliente[0].recibe);
                    inputEntrega.val(recibeCliente[0].entrega);
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
                        selectDirecciones.append(new Option(direccion.localidad + ', ' + direccion
                            .calle + ' #' +
                            direccion.num_exterior + ' - ' + direccion.num_interior +
                            ' referencia: ' +
                            direccion.referencia, direccion
                            .id));
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
                inputRecibe.val('').prop('disabled', false);
                inputEntrega.val('').prop('disabled', false);
                selectDirecciones.append(new Option('No hay direcciones disponibles', ''));
                $('#inputNombreAtencion').val('').prop('disabled', false);
                // Vacía el select de atención
                selectAtencion.append(new Option('Nueva persona en atencion', ''));
            }
        }

        // Inicializa el array
        var productosSeleccionados = [];
        // Función para manejar el evento click del botón
        function agregarProducto() {
            var selectElement = document.getElementById('descuento');
            var selectedOption = selectElement.value;
            let descuento = selectedOption;
            // Obtiene los valores del select y del input
            var selectProducto = document.getElementById('producto');
            var idProducto = selectProducto.value;
            let cantidadInput = document.getElementById('cantidad');
            let cantidad = cantidadInput.value;
            // console.log(cantidad);
            // Verificar si la cantidad es menor que 1
            if (cantidad === '' || parseInt(cantidad) < 1 || isNaN(cantidad)) {
                // Establecer un mensaje de error personalizado y marcar el campo como inválido
                cantidadInput.setCustomValidity('La cantidad debe ser al menos 1.');
                cantidadInput.reportValidity();
                return; // Salir de la función
            } else {
                // Si el campo es válido, limpiar cualquier mensaje de error anterior
                cantidadInput.setCustomValidity('');
            }


            // Obtiene los datos del producto seleccionado
            var productoSeleccionado = selectProducto.options[selectProducto.selectedIndex].text.split('_');
            var nombreComercial = productoSeleccionado[0];
            var nombreModo = productoSeleccionado[1];
            var nombreMarca = productoSeleccionado[2];
            var nombreCategoria = productoSeleccionado[3];
            var nombreColor = productoSeleccionado[4];
            var precio = productoSeleccionado[5].replace('$', '');


            // Verifica si el producto ya está en el array
            var productoExistente = productosSeleccionados.find(function(producto) {
                return producto.id === idProducto;
            });

            if (productoExistente) {
                // Si el producto ya está en el array, actualiza la cantidad
                productoExistente.cantidad = cantidad;
                productoExistente.descuento = descuento;
            } else {
                // Si el producto no está en el array, lo agrega

                var producto = {
                    id: idProducto,
                    cantidad: cantidad,
                    nombre: nombreComercial,
                    modo: nombreModo,
                    marca: nombreMarca,
                    tipo: nombreCategoria,
                    color: nombreColor,
                    precio: precio,
                    descuento: descuento
                };
                productosSeleccionados.push(producto);
            }

            // Limpia el input de cantidad
            document.getElementById('cantidad').value = '';

            // Agrega los productos seleccionados a la tabla
            agregarProductosATabla(productosSeleccionados);
            Actualizararray(productosSeleccionados);

        }


        // Agrega el evento click al botón
        document.getElementById('agregarProducto').addEventListener('click', agregarProducto);

        function agregarProductosATabla(productos) {


            var tabla = document.getElementById('cuerpoTabla');
            var totalCosto = 0;

            // Elimina todas las filas existentes
            while (tabla.firstChild) {
                tabla.removeChild(tabla.firstChild);
            }

            for (var i = 0; i < productos.length; i++) {

                let producto = productos[i];
                let fila = tabla.insertRow(-1);
                fila.id = 'filaProducto_' + i; // Asigna un identificador único a la fila
                let celdaNombre = fila.insertCell(0);
                let celdaMarca = fila.insertCell(1);
                let celdaTipo = fila.insertCell(2);
                let celdaModo = fila.insertCell(3);
                let celdaColor = fila.insertCell(4);
                let celdaCantidad = fila.insertCell(5);
                let celdaPrecio = fila.insertCell(6);
                let celdaCosto = fila.insertCell(7);
                let celdaEliminar = fila.insertCell(8); // Nueva celda para el botón "Eliminar"
                celdaNombre.textContent = producto.nombre;
                celdaMarca.textContent = producto.marca;
                celdaTipo.textContent = producto.tipo;
                celdaModo.textContent = producto.modo;
                celdaColor.textContent = producto.color;
                celdaCantidad.textContent = producto.cantidad;
                celdaPrecio.textContent = producto.precio;


                let porcentaje = producto.descuento / 100;
                let costo = (producto.precio * producto.cantidad) * (1 - porcentaje);

                celdaCosto.textContent = costo.toFixed(2);
                totalCosto += costo;

                // Agrega el botón "Eliminar" a la celda
                let botonEliminar = document.createElement('button');
                botonEliminar.textContent = 'Eliminar';
                botonEliminar.style.color = 'red'; // Cambia el color del texto a rojo
                botonEliminar.addEventListener('click', function() {
                    // Obtiene el id de la fila a eliminar
                    let idFila = this.parentNode.parentNode.id;
                    let indice = parseInt(idFila.split('_')[
                        1]); // Obtiene el índice del producto en el array

                    // Elimina el producto del array
                    productosSeleccionados.splice(indice, 1);

                    // Elimina la fila correspondiente al botón "Eliminar" presionado
                    tabla.removeChild(document.getElementById(idFila));

                    // Recalcula la suma total
                    recalcularSumaTotal();

                    Actualizararray(productosSeleccionados)

                });
                celdaEliminar.appendChild(botonEliminar);
                // Agrega la fila al cuerpo de la tabla
                tabla.appendChild(fila);

            }

            // Obtiene el elemento y luego actualiza su contenido y estilo
            let sumaTotalElement = document.getElementById('sumaTotal');
            sumaTotalElement.textContent = totalCosto.toFixed(2);
            sumaTotalElement.style.fontWeight = 'bold'; // Hace el texto en negrita
            sumaTotalElement.style.fontSize = '1.5em'; // Hace el texto un 50% más grande
        }


        function Actualizararray(productosSeleccionados) {

            // Actualiza el valor del campo de entrada con los productos seleccionados
            document.getElementById('inputProductosSeleccionados').value = JSON.stringify(
                productosSeleccionados);
        }

        function recalcularSumaTotal() {
            var tabla = document.getElementById('cuerpoTabla');
            var totalCosto = 0;

            let pagaConInput = document.getElementById('pagaCon');
            // Asegúrate de reemplazar 'idDelTotal' e 'idDelCambio' con los ids reales de tus elementos
            let cambioInput = document.getElementById('cambioInput');

            // Recorre todas las filas de la tabla y suma los costos de los productos
            for (var i = 0; i < tabla.rows.length; i++) {
                var costo = parseFloat(tabla.rows[i].cells[7].textContent);
                totalCosto += costo;
            }

            // Obtiene el elemento y luego actualiza su contenido y estilo
            let sumaTotalElement = document.getElementById('sumaTotal');
            sumaTotalElement.textContent = totalCosto.toFixed(2);
            sumaTotalElement.style.fontWeight = 'bold'; // Hace el texto en negrita
            sumaTotalElement.style.fontSize = '1.5em'; // Hace el texto un 50% más grande
            calcularCambio();
        }

        // Obtiene los elementos
        let pagaConElement = document.getElementById('pagaCon');
        let sumaTotalElement = document.getElementById('sumaTotal');
        let cambioInput = document.getElementById('cambioInput');

        // Agrega el evento input al elemento pagaConElement
        pagaConElement.addEventListener('input', function() {
            // Obtiene los valores de los elementos y los convierte a números
            let pagaCon = Number(pagaConElement.value);
            let sumaTotal = Number(sumaTotalElement.textContent);

            // Realiza la resta
            let cambio = pagaCon - sumaTotal;

            // Muestra el resultado en el input cambioInput
            cambioInput.value = cambio.toFixed(2);
        });

        // Define la función calcularCambio
        function calcularCambio() {
            // Obtiene los valores de los elementos y los convierte a números
            let pagaCon = Number(pagaConElement.value);
            let sumaTotal = Number(sumaTotalElement.textContent);

            // Realiza la resta
            let cambio = pagaCon - sumaTotal;

            // Muestra el resultado en el input cambioInput
            cambioInput.value = cambio.toFixed(2);
        }


        document.getElementById('metodoPago').addEventListener('change', function() {
            if (this.value === 'Efectivo') {
                document.getElementById('pagoEfectivo').style.display = 'block';
                document.getElementById('cambio').style.display = 'block';
            } else {
                document.getElementById('pagoEfectivo').style.display = 'none';
                document.getElementById('cambio').style.display = 'none';
            }
        });
    </script>
@stop
