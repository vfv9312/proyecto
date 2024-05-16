@extends('layouts.admin')

@section('title', 'Inicio')

@section('content')

    <h1 class=" text-center">Registro de Orden de Entrega</h1>
    <!-- mensaje de aviso que se registro el producto-->
    @if (session('correcto'))
        <div class=" flex justify-center">
            <div id="alert-correcto" class="bg-green-500 bg-opacity-50 text-white px-4 py-2 rounded mb-8 w-64 ">
                {{ session('correcto') }}
            </div>
        </div>
    @endif
    @if (session('incorrect'))
        <div id="alert-incorrect" class="bg-red-500 text-white px-4 py-2 rounded">
            {{ session('incorrect') }}
        </div>
    @endif

    <form id="formulario" class="mt-8 lg:ml-4 flex flex-col justify-center" action="{{ route('orden_servicio.store') }}"
        method="POST">
        @csrf

        @include('Principal.ordenServicio._form_cliente')
        @include('Principal.ordenEntrega._modal')
        @include('Principal.ordenEntrega._modal_Descuentos')
        @include('Principal.ordenEntrega._Lista_Productos')
        @include('Principal.ordenEntrega._carro_campras')


        <div class="mt-4 flex justify-center">
            <button id="botonGuardar" type="submit"
                class="px-4 py-2 bg-green-500
                text-white rounded hover:bg-green-700">
                <i class="fas fa-save mr-2"></i>
                Guardar
            </button>
        </div>
    </form>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        //Direccion funcion para validar si hay alguna direccion y si el cambio es menor a 0
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('#formulario').addEventListener('submit', function(event) {

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
        }); //Finaliza la funcion para las direcciones



        const modalDescuentos = document.querySelector('#modalDescuentos')
        const cancelarModalDescuento = document.querySelector('.cerrarmodalDescuento');
        // Agrega el evento click al botón para que al darle aceptar al modal de descuento ya agregue a un array los productos
        document.getElementById('agregarProducto').addEventListener('click', botonAgregar);

        //este boton es del modal para verificar si tiene algun descuento
        document.querySelector('#botonAgregar').addEventListener('click', function() {
            // Aquí puedes obtener los valores que quieres pasar a la función
            var selectProducto = document.getElementById('producto');
            var idProducto = selectProducto.value;
            let cantidadInput = document.getElementById('cantidad');
            let cantidad = cantidadInput.value;
            let valorDescuentoCantidad = document.querySelector('#Cantidaddescuento').value;
            let valorDescuentoPorcentaje = document.querySelector('#porcentaje').value;


            // Luego los pasas a la función
            agregarProducto(selectProducto, idProducto, cantidadInput, cantidad, valorDescuentoCantidad,
                valorDescuentoPorcentaje);

            // Oculta ambos divs
            descuentoCantidad.classList.add('hidden');
            descuentoPorcentaje.classList.add('hidden');

            //restauramos el select del modal a sin descuento
            document.getElementById('elejirdescuento').value = '1';
            //restauramos el valor delos descuentos
            document.querySelector('#Cantidaddescuento').value = '';
            document.querySelector('#porcentaje').value = '';


            // Oculta el modal
            modalDescuentos.classList.add('hidden');

        });
        //aqui verifico que tenga datos cantidad antes de abrir un mmodal y preguntar si requiere un descuento
        function botonAgregar() {
            // Obtiene los valores del select y del input
            var selectProducto = document.getElementById('producto');
            var idProducto = selectProducto.value;
            let cantidadInput = document.getElementById('cantidad');
            let cantidad = cantidadInput.value;


            // Verificar si la cantidad es menor que 1
            if (cantidad === '' || parseInt(cantidad) < 1 || isNaN(cantidad)) {
                // Establecer un mensaje de error personalizado y marcar el campo como inválido

                cantidadInput.setCustomValidity('La cantidad debe ser al menos 1.');
                cantidadInput.reportValidity();

                //tuve que limpiar despues de dos segundos para que me permita enviar el formulario debido que igual marcaba error si jugaban con el input
                setTimeout(() => {
                    // Si el campo es válido, limpiar cualquier mensaje de error anterior
                    cantidadInput.setCustomValidity('');
                }, 2000); // Desbloquea el botón después de 2 segundos
                return; // Salir de la función
            } else {
                // Si el campo es válido, limpiar cualquier mensaje de error anterior
                cantidadInput.setCustomValidity('');

                //Abre el modal de los descuentos
                modalDescuentos.classList.remove('hidden');

                // Escucha el evento de click en el botón cancelar Modal de registro
                cancelarModalDescuento.addEventListener('click', function() {
                    // Oculta el modal
                    modalDescuentos.classList.add('hidden');
                });


                document.getElementById('elejirdescuento').addEventListener('change', function() {
                    // Obtén el valor seleccionado
                    var seleccion = this.value;

                    // Muestra el div correspondiente
                    if (seleccion == '2') {
                        descuentoCantidad.classList.remove('hidden');
                        descuentoPorcentaje.classList.add('hidden');
                        //restauramos el valor de porcentaje por si cambia de vista se borre lo que pusiera en porcentaje
                        document.querySelector('#porcentaje').value = '';

                    } else if (seleccion == '3') {
                        descuentoCantidad.classList.add('hidden');
                        descuentoPorcentaje.classList.remove('hidden');
                        //restauramos el valor del descuento por cantidad por si cambia por porcentaje
                        document.querySelector('#Cantidaddescuento').value = '';

                    } else if (seleccion == '1') {
                        // Oculta ambos divs
                        descuentoCantidad.classList.add('hidden');
                        descuentoPorcentaje.classList.add('hidden');
                        //restauramos el valor delos descuentos por si pone datos y despues decide no poner descuentos
                        document.querySelector('#Cantidaddescuento').value = '';
                        document.querySelector('#porcentaje').value = '';
                    }
                });
            }

        }


        // Inicializa el array
        var productosSeleccionados = [];
        // Función para manejar el evento click del botón para agregar productos cuando le de click
        function agregarProducto(selectProducto, idProducto, cantidadInput, cantidad, valorDescuentoCantidad,
            valorDescuentoPorcentaje) {
            let tipoDescuento;
            let valorDescuento;

            //verificar que descuento fue positivo o ninguno
            switch (true) {
                case Boolean(valorDescuentoCantidad):
                    tipoDescuento = 'cantidad';
                    valorDescuento = valorDescuentoCantidad;
                    break;
                case Boolean(valorDescuentoPorcentaje):
                    tipoDescuento = 'Porcentaje';
                    valorDescuento = valorDescuentoPorcentaje;
                    break;
                default:
                    tipoDescuento = 'null';
                    valorDescuento = 'null';
            }


            // Obtiene los datos del productoSeleccionado separamos las variables
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
                // Si el producto ya está en el array, actualiza la cantidad y el descuento


                productoExistente.cantidad = cantidad;
                productoExistente.descuento = valorDescuento;
                productoExistente.tipoDescuento = tipoDescuento;


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
                    descuento: valorDescuento,
                    tipoDescuento: tipoDescuento
                };
                productosSeleccionados.push(producto);

            }

            // Limpia el input de cantidad
            document.getElementById('cantidad').value = '';


            // Agrega los productos seleccionados a la tabla
            agregarProductosATabla(productosSeleccionados);

            Actualizararray(productosSeleccionados);

        } //hasta aqui agrega los datos de los productos a un array





        //funcion para mostrar en una tabla todos los productos del array recibimos el array de objetos de productosSeleccionados y lo renombramos como productos
        function agregarProductosATabla(productos) {
            var tabla = document.getElementById('cuerpoTabla');
            var totalCosto = 0;

            // Elimina todas las filas existentes
            while (tabla.firstChild) {
                tabla.removeChild(tabla.firstChild);
            }
            //creamos las celdas y le ponemos el valor segun la cantidad de array
            for (var i = 0; i < productos.length; i++) {
                let producto = productos[i];
                let fila = tabla.insertRow(-1);
                fila.id = 'filaProducto_' + i; // Asigna un identificador único a la fila
                let celdaNombre = fila.insertCell(0);
                celdaNombre.style.textAlign = "center";
                let celdaMarca = fila.insertCell(1);
                celdaMarca.style.textAlign = "center";
                let celdaTipo = fila.insertCell(2);
                celdaTipo.style.textAlign = "center";
                let celdaModo = fila.insertCell(3);
                celdaModo.style.textAlign = "center";
                let celdaColor = fila.insertCell(4);
                celdaColor.style.textAlign = "center";
                let celdaCantidad = fila.insertCell(5);
                celdaCantidad.style.textAlign = "center";
                let celdaPrecio = fila.insertCell(6);
                celdaPrecio.style.textAlign = "center";
                let celdaDescuento = fila.insertCell(7);
                celdaDescuento.style.textAlign = "center";
                let celdaCosto = fila.insertCell(8);
                celdaCosto.style.textAlign = "center";
                let celdaEliminar = fila.insertCell(9); // Nueva celda para el botón "Eliminar"
                celdaNombre.textContent = producto.nombre;
                celdaMarca.textContent = producto.marca;
                celdaTipo.textContent = producto.tipo;
                celdaModo.textContent = producto.modo;
                celdaColor.textContent = producto.color;
                celdaCantidad.textContent = producto.cantidad;
                celdaPrecio.textContent = producto.precio;
                let costo = producto.precio * producto.cantidad;
                if (producto.tipoDescuento == 'cantidad') {
                    celdaDescuento.textContent = '$' + producto.descuento;
                    costo = costo - producto.descuento;
                } else if (producto.tipoDescuento == 'Porcentaje') {
                    celdaDescuento.textContent = producto.descuento + '%';
                    let descuentoAplicado = costo * (producto.descuento / 100);
                    costo = costo - descuentoAplicado;
                } else {
                    celdaDescuento.textContent = 'Sin descuentos'
                }

                celdaCosto.textContent = costo.toFixed(2);
                totalCosto += costo;


                // Agrega el botón "Eliminar" a la celda
                let botonEliminar = document.createElement('button');
                botonEliminar.textContent = 'Eliminar';
                botonEliminar.style.color = 'red'; // Cambia el color del texto a rojo
                botonEliminar.style.textAlign = "center";
                botonEliminar.addEventListener('click', function() {
                    // Obtiene el id de la fila a eliminar
                    let idFila = this.parentNode.parentNode.id;
                    let indice = parseInt(idFila.split('_')[1]); // Obtiene el índice del producto en el array

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
        } //Finaliza la impresion en la tabla


        function Actualizararray(productosSeleccionados) { //actualizamoms el array de los productos

            // Actualiza el valor del campo de entrada con los productos seleccionados
            document.getElementById('inputProductosSeleccionados').value = JSON.stringify(
                productosSeleccionados);
        }

        //funcion para carlular los costos etc
        function recalcularSumaTotal() {
            var tabla = document.getElementById('cuerpoTabla');
            var totalCosto = 0;

            let pagaConInput = document.getElementById('pagaCon');
            // Asegúrate de reemplazar 'idDelTotal' e 'idDelCambio' con los ids reales de tus elementos
            let cambioInput = document.getElementById('cambioInput');

            // Recorre todas las filas de la tabla y suma los costos de los productos
            for (var i = 0; i < tabla.rows.length; i++) {
                //recordar que se se mueve las celdas se tendra que modificar para que calcule las celtas que tienen los costos
                var costo = parseFloat(tabla.rows[i].cells[8].textContent);
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
        } //finaliza el calculo de los costos


        //funcion para mostrar o ocultar las vistas del efectivo
        document.getElementById('metodoPago').addEventListener('change', function() {
            if (this.value === 'Efectivo') {
                document.getElementById('pagoEfectivo').style.display = 'block';
                document.getElementById('cambio').style.display = 'block';
            } else {
                document.getElementById('pagoEfectivo').style.display = 'none';
                document.getElementById('cambio').style.display = 'none';
            }
        });

        $('#mostrarNuevaDireccion').click(function(event) {
            event.preventDefault();
            $('#nuevaDireccion').toggle();
        });

        //este ayuda a buscar en datos en el select
        $(document).ready(function() {
            $('#txtcolonia').select2();
            $('#inputAtencion').select2();
            $('#inputCliente').select2();

            function matchCustom(params, data) {
                // Si no hay término de búsqueda, devuelve todos los datos
                if ($.trim(params.term) === '') {
                    return data;
                }

                // No devuelve el elemento si no hay 'text'
                if (typeof data.text === 'undefined') {
                    return null;
                }

                // `params.term` debe ser el término de búsqueda
                // `data.text` es el texto que se muestra para la opción
                if (data.text.replace(/\s/g, '').toLowerCase().indexOf(params.term.replace(/\s/g, '')
                        .toLowerCase()) > -1) {
                    return data;
                }

                // Devuelve `null` si el término no debe ser mostrado
                return null;
            }

            $('#producto').select2({
                matcher: matchCustom
            });
        });
        //pasamos los valores recibidos a variables js
        var datosClientes = @json($listaClientes);
        var datosDirecciones = @json($listaDirecciones);
        let datosAtencion = @json($listaAtencion);
        let datosRecoleccion = @json($datosRecoleccion);


        let selectAtencion = $('#inputAtiende');
        let inputrecibe = $('#recibe');
        let inputentrega = $('#entrega');
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

                var recibeCliente = datosRecoleccion.filter(function(reciben) {
                    return reciben.idCliente == clienteSeleccionado.id_cliente;
                });
            }


            // Vacía los campos al incio
            $('#telefono').val('');
            $('#rfc').val('');
            $('#email').val('');
            $('#nombreCliente').val('').prop('disabled', false);
            $('#apellidoCliente').val('').prop('disabled', false);
            $('#inputDirecciones').empty();
            $('#inputNombreAtencion').val('').prop('disabled', false);
            inputrecibe.val('');
            inputentrega.val('');
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
                $('#apellidoCliente').val(clienteSeleccionado.apellido).prop('disabled', true);
                if (recibeCliente && recibeCliente.length > 0) {
                    inputrecibe.val(recibeCliente[0].recibe);
                    inputentrega.val(recibeCliente[0].entrega);
                } else {
                    // Aquí va tu código si el array está vacío
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
                $('#telefono').val('');
                $('#rfc').val('');
                $('#email').val('');
                $('#nombreCliente').val('').prop('disabled', false);
                $('#apellidoCliente').val('').prop('disabled', false);
                $('#inputNombreAtencion').val('').prop('disabled', false);
                inputrecibe.val('');
                inputentrega.val('');
                selectDirecciones.append(new Option('No hay direcciones disponibles', ''));
                // Vacía el select de atención
                selectAtencion.append(new Option('Nueva persona en atencion', ''));
            }

        }





        //ENTRA LA FUNCION CUANDO LE DAMOS AL CHECKBOX QUE REQUERIMOS UN RFC POR QUE QUIERE FACTURA
        function RequiereRFC() {
            var checkbox = document.getElementById("factura");
            var rfcInput = document.getElementById("rfc");
            var warning = document.getElementById("warning");

            if (checkbox.checked) {
                rfcInput.required = true;
                rfcInput.disabled = false;
                warning.classList.remove("hidden");
            } else {
                rfcInput.required = false;
                rfcInput.disabled = true;
                warning.classList.add("hidden");
            }
        } //FINALIZA LA FUNCION AL DARLE AL CHECKBOX QUE QUIERE RFC



        function mostrarHorario(checkbox) {
            var horario = document.getElementById(checkbox.value + '-horario');
            if (checkbox.checked) {
                horario.style.display = 'block';
            } else {
                horario.style.display = 'none';
            }
        }

        //botones y funciones para mostrar y ocultar modal
        // Obtén los elementos del DOM
        const modalRegistrarProducto = document.querySelector('#modalRegistrarProducto')
        const abrirnModalRegisrarProducto = document.querySelector('#Detalle');
        const cancelarModal = document.querySelector('.cerrarmodal');


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
            let datosProductos = @json($productos);
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




        //FUNCION QUE PERMITE ENVIAR EL FORMULARIO, PRIMERO REVISA SI HAY VALIDACIONES LUEGO SE DESACTIVA PARA EVITAR DOBLE CLICK Y LUEGO ENVIA FORMULARIO
        document.getElementById('botonGuardar').addEventListener('click', function(event) {
            // Obtén el formulario
            var form = document.getElementById('formulario');

            /**
             *
             *
             * */


            let inputDirecciones = document.querySelector('#inputDirecciones');
            let txtcolonia = document.querySelector('#txtcolonia');
            let calle = document.querySelector('#calle');
            let cambioInput = document.querySelector(
                '#cambioInput'); // Obtener el campo de entrada de cambio
            let ArrayProductos = document.querySelector('#inputProductosSeleccionados');

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
            //Verificar que tenga datos el array de productos
            if (!ArrayProductos.value) {
                alert('No has agregado productos a tu lista de pedidos');
                event.preventDefault();
                return;
            }

            // Verificar si el cambio es menor que 0  pues marque un alert
            if (parseFloat(cambioInput.value) < 0) {
                event.preventDefault();
                // Establecer un mensaje de error personalizado y marcar el campo como inválido
                pagaCon.setCustomValidity('El cambio no puede ser menor que 0.');
                pagaCon.reportValidity();
                alert('El cambio no puede ser menor que 0.');
                return;
            } else {
                // Si el campo es válido, limpiar cualquier mensaje de error anterior
                cambioInput.setCustomValidity('');
            }


            //ENTRA LA FUNCION CUANDO LE DAMOS AL CHECKBOX QUE REQUERIMOS UN RFC POR QUE QUIERE FACTURA
            var checkbox = document.getElementById("factura");
            var rfcInput = document.getElementById("rfc");


            if (checkbox.checked) {
                validarRFC(rfcInput);
            } else {

                rfcInput.setCustomValidity(''); // Limpia cualquier mensaje de error anterior
            }
            //validar rfc
            //Dentro de la función, se define una expresión regular (regex) que describe el formato de un RFC válido. Un RFC válido comienza con 3 o 4 letras mayúsculas (incluyendo Ñ y &), seguido de 6 dígitos, y opcionalmente termina con 3 caracteres alfanuméricos.
            function validarRFC(input) {
                var regex = /^[A-ZÑ&]{3,4}\d{6}(?:[A-Z\d]{3})?$/;
                if (input.value.trim() !== '' && !regex.test(input.value)) {
                    input.setCustomValidity(
                        'RFC inválido. Deben ser 3 o 4 letras mayúsculas, seguido de 6 dígitos y 3 caracteres alfanuméricos.'
                    );
                } else {
                    input.setCustomValidity('');
                }
            } //FINALIZA FUNCION DE VALIDACION DE RFC



            // Si el formulario no es válido, detén la ejecución de la función
            if (!form.checkValidity()) {
                return;
            }

            // Desactiva el botón
            this.disabled = true;

            // Envía el formulario
            form.submit();

            setTimeout(() => {
                // Reactiva el botón después de 3 segundos
                this.disabled = false;
            }, 3000);
        });
    </script>
@endpush
