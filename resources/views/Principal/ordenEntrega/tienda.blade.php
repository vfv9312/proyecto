@extends('adminlte::page')

@section('title', 'Orden de entrega')

@section('content_header')

@stop

@section('content')
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
    <!-- Botón para abrir el modal -->
    <button id="myBtn"
        class=" mt-4 bg-gradient-to-r from-gray-800 via-gray-600 to-green-500 text-white font-bold py-2 px-4 rounded-full">
        <i class="fas fa-shopping-basket"></i> Añadir productos</button>
    <form class="mt-8 flex flex-col justify-center" action="{{ route('orden_entrega.store') }}" method="POST">
        @csrf

        @include('Principal.ordenEntrega._form_orden')
        @include('Principal.ordenEntrega._carro_campras')

        @include('Principal.ordenEntrega._modal')

        <div class="mt-4 flex justify-center">
            <button type="submit" class="px-4 py-2  bg-green-500 text-white rounded hover:bg-green-700">
                Siguiente
                <i class="fas fa-arrow-right ml-2"></i>
            </button>
        </div>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="../../../css/app.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome para los iconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        //cambiar icono por 1 segundo de compra del modal
        document.getElementById('compras').addEventListener('click', function() {
            this.classList.remove('fa-shopping-bag');
            this.classList.add('fa-save', 'text-green-500');

            setTimeout(() => {
                this.classList.remove('fa-save', 'text-green-500');
                this.classList.add('fa-shopping-bag', 'text-gray-500');
            }, 1000);
        });

        //BUSCA POR LOS DATOS DE SELECT
        $(document).ready(function() {
            $('#color ,#modo ,#marca, #tipo').on('change', function() { // Cambiar a #marca y #tipo


                var marcaFiltro = $('#marca').val(); // Cambiar a #marca
                var tipoFiltro = $('#tipo').val(); // Cambiar a #tipo
                var modoFiltro = $('#modo').val(); // Cambiar a #tipo
                var colorFiltro = $('#color').val(); // Cambiar a #tipo



                $('.producto').each(function() {
                    var marca = $(this).data('marca');
                    var tipo = $(this).data('tipo');
                    var modo = $(this).data('modo');
                    var color = $(this).data('color');

                    if ((marcaFiltro === "" || marcaFiltro == marca) &&
                        (tipoFiltro === "" || tipoFiltro == tipo) &&
                        (colorFiltro === "" || colorFiltro == color) &&
                        (modoFiltro === "" || modoFiltro == modo)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
            //BUSCA POR NOMBRE
            $('#search').on('input', function() {
                var searchText = $(this).val().toLowerCase().replace(/\s/g, '');

                $('.producto').each(function() {
                    var productoNombre = $(this).data('nombre').toLowerCase().replace(/\s/g, '');

                    if (productoNombre.startsWith(searchText)) {
                        $(this).show();
                    } else if (productoNombre.includes(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });


        });



        //mostrar y ocultar los filtros
        document.getElementById('toggle-filters').addEventListener('click', function() {
            var filtersSection = document.getElementById('filters-section');
            if (filtersSection.style.display === "none") {
                filtersSection.style.display = "block";
            } else {
                filtersSection.style.display = "none";
            }
        });
        //actualizar el total de productos seleccionado en la bolsita de manera visual
        function actualizarTotal() {

            var inputs = document.querySelectorAll('.suma');
            let totalSpan = document.querySelector('#totalSpan');
            var total = 0;

            inputs.forEach(function(input) {
                total += parseInt(input.value);
            });
            totalSpan.textContent = total;
        }

        //incrementar el valor cuando le de al icono +
        function incrementar(button) {
            var input = button.parentNode.querySelector('.suma');
            var currentValue = parseInt(input.value);
            input.value = currentValue + 1;
            actualizarTotal();
        }
        //decremmentar en 1 cuando le de click al icono -
        function decrementar(button) {
            var input = button.parentNode.querySelector('.suma');
            var currentValue = parseInt(input.value);
            if (currentValue > 0) {
                input.value = currentValue - 1;
                actualizarTotal();
            }
        }
        //si llega a ser 0 marcara no haz seleccionado un producto
        document.getElementById('compras').addEventListener('click', function(event) {
            var total = document.getElementById('totalSpan').innerText;
            if (total === '0') {
                event.preventDefault();
                alert('No has seleccionado nada.');
            }
        });
        //guarda los datos del producto seleccionado para mostrarlo en una tabla
        document.getElementById('compras').addEventListener('click', function() {
            var productosSeleccionados = [];
            var productos = document.getElementsByClassName('producto');

            for (var i = 0; i < productos.length; i++) {
                var producto = productos[i];
                var cantidad = parseInt(producto.querySelector('.suma').value);
                if (cantidad > 0) {
                    let id = producto.dataset.id;
                    var nombre = producto.dataset.nombre;
                    var marca = producto.dataset.nombre_marca;
                    var tipo = producto.dataset.nombre_categoria;
                    var modo = producto.dataset.nombre_modo;
                    var color = producto.dataset.nombre_color;
                    var precio = producto.dataset.precio;
                    productosSeleccionados.push({
                        id: id,
                        nombre: nombre,
                        marca: marca,
                        tipo: tipo,
                        modo: modo,
                        color: color,
                        cantidad: cantidad,
                        precio: precio
                    });
                }
            }

            // Aquí puedes hacer lo que desees con el array de productos seleccionados
            console.log(productosSeleccionados);
            // Por ejemplo, podrías enviar este array a un formulario oculto para luego procesarlo en el backend
            // O podrías agregar los productos directamente a una tabla en la misma página
            agregarProductosATabla(productosSeleccionados);
        });

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
                let costo = producto.precio * producto.cantidad;
                celdaCosto.textContent = costo.toFixed(2);
                totalCosto += costo;

                // Agrega el botón "Eliminar" a la celda
                let botonEliminar = document.createElement('button');
                botonEliminar.textContent = 'Eliminar';
                botonEliminar.style.color = 'red'; // Cambia el color del texto a rojo
                botonEliminar.addEventListener('click', function() {
                    // Obtiene el id de la fila a eliminar
                    let idFila = this.parentNode.parentNode.id;
                    // Elimina la fila correspondiente al botón "Eliminar" presionado
                    tabla.removeChild(document.getElementById(idFila));
                    // Establece la cantidad del producto asociado a 0

                    recalcularSumaTotal();
                    restablecerCantidad(producto.id);
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

        function restablecerCantidad(idProducto) {

            // Encuentra el input de cantidad basado en el id del producto
            var inputCantidad = document.querySelector('#inputNumber_' + idProducto);
            if (inputCantidad) {
                // Restablece el valor del input a 0
                inputCantidad.value = 0;
                actualizarTotal();
            } else {
                console.error("No se encontró el input de cantidad para el producto con id " +
                    idProducto);
            }

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



        $('#mostrarNuevaDireccion').click(function(event) {
            event.preventDefault();
            $('#nuevaDireccion').toggle();
        });

        //este ayuda a buscar en datos en el select
        $(document).ready(function() {
            $('#txtcolonia').select2();
            $('#inputAtencion').select2();
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
            $('#inputAtiende').val('');
            $('#telefono').val('');
            $('#rfc').val('');
            $('#email').val('');
            $('#nombreCliente').val('').prop('disabled', false);
            $('#apellidoCliente').val('').prop('disabled', false);
            $('#inputDirecciones').empty();

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
                selectDirecciones.append(new Option('No hay direcciones disponibles', ''));
            }
        }

        function toggleRFCField() {
            var checkbox = document.getElementById("factura");
            var rfcInput = document.getElementById("rfc");
            var warning = document.getElementById("warning");

            if (checkbox.checked) {
                rfcInput.required = true;
                rfcInput.disabled = false;
                warning.classList.remove("hidden");
                validarRFC(rfcInput);
            } else {
                rfcInput.required = false;
                rfcInput.disabled = true;
                warning.classList.add("hidden");
                rfcInput.setCustomValidity(''); // Limpia cualquier mensaje de error anterior
            }
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
        }
    </script>
@stop
