let datosDeProductos; //valor de los datos de producto
let datoTipoProductoServicio = 0;
let Revision = false;
let botonAgregarNuevoProducto = document.getElementById('agregarProductoNuevo');
let datosDeLaVenta = document.getElementById('datosDeLaVenta');
let selectMetodoPago = document.getElementById('metodoPago');
// Obtener el checkbox por su ID
const tipoProductoCheck = document.getElementById('productoRecarga');
selectMetodoPago.addEventListener('change', metodoPagoSelect);


// Agregar un event listener para detectar cuando el checkbox cambie
tipoProductoCheck.addEventListener('change', function() {

    // Verificar si está marcado (activo) o no
    if (tipoProductoCheck.checked) {
        datoTipoProductoServicio = 1;
        paquetesDatosProducto(datoTipoProductoServicio);
    } else {
        datoTipoProductoServicio = 0;
        paquetesDatosProducto(datoTipoProductoServicio);
    }
    });

// Agregar el evento de click al botón
botonAgregarNuevoProducto.addEventListener('click', function(evento) {
    // Verificar el estado del checkbox
    if (tipoProductoCheck.checked) {
        // Si está marcado, ejecutar la función traerDatos
        TraerRecoleccion(evento);
    } else {
        // Si no está marcado, ejecutar la función traerProducto
        traerProducto(evento);
    }
});



function paquetesDatosProducto(datoTipoProductoServicio) {
    axios.post(productRecargaUrl, {
        productoRecarga: datoTipoProductoServicio
    }).then(function(response) {
        // Aquí puedes manejar la respuesta de la solicitud

        datosDeProductos = response.data;

        let select = document.getElementById('producto');
        select.innerHTML = ''; // Vacía el select

        // Llena el select con los nuevos datos
        response.data.productos.forEach(function(producto) {
            let option = document.createElement('option');
            option.value = producto.id;

            switch (datoTipoProductoServicio) {
                case 1:
                    option.setAttribute('data-precio', 0);
                    option.setAttribute('data-estatus', producto.estatus);
                    option.setAttribute('data-idPrecio', producto.idPrecio);
                    option.setAttribute('data-alternativoUno', 0);
                    option.setAttribute('data-alternativoDos', 0);
                    option.setAttribute('data-alternativoTres', 0);
                    option.textContent = producto.nombre_comercial + '_' + producto.nombre_modo +
                        '_' + producto.nombre_marca + '_' + producto.nombre_categoria + '_' +
                        producto.nombre_color;
                    select.appendChild(option);
                break;
                case 0:
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
                break;

                default:

                    break;
            }

        });
        // Por ejemplo, actualizar una parte del DOM con los nuevos datos
    }).catch(function(error) {
        // Aquí puedes manejar los errores de la solicitud
        console.error(error);
    });
}

//Cuando entra y carga la pagina entra lo siguiente
document.addEventListener('DOMContentLoaded', function() {

    paquetesDatosProducto(datoTipoProductoServicio);

    document.querySelector('#seleccionadorCliente').addEventListener('change', selectCliente);

    function selectCliente() {
        let esNuevoCliente = document.querySelector('#seleccionadorCliente').value;
        let contenedorOcultoClienteExistente = document.querySelector('#contenedorSelectCliente');
        let seleccionadorClienteInicio = document.querySelector('#inputCliente');
        let selectAtencion = $('#inputAtiende');
        let contenedorCliente = document.querySelector('#tipoCliente');
        var checkTipoCliente = document.getElementById('tipoDeCliente');



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
                $('#clave').val('').prop('disabled',false);

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

function TraerRecoleccion(evento) {

    evento.preventDefault();  // Prevenir el envío normal del formulario
    fetch(detallesProductoUrl, {
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

    content += '<h3 class="text-lg font-medium leading-6 text-center text-gray-900 mb-4" id="modal-title">para revision o recoleccion</h3>'
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

    content += '<label class="items-start text-sm text-gray-500 hidden">';
    content += '<span>precio</span>';
    content += '<input id="txtprecioProductoNuevo" name="txtprecio" type="number" min="0" step="0.01" value="0" class="h-8 border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />';
    content += '</label>';

    content += '<label class="items-start text-sm text-gray-500 hidden">';
    content += '<span>precio alternativo 1</span>';
    content += '<input name="txtprecioalternativouno" type="number" min="0" step="0.01" value="0" class="border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none h-8 />';
    content += '</label>';

    content += '<label class="items-start text-sm text-gray-500 hidden">';
    content += '<span>precio alternativo 2</span>';
    content += '<input name="txtprecioalternativodos" type="number" min="0" step="0.01" value="0" class="h-8 border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />';
    content += '</label>';

    content += '<label class="items-start text-sm text-gray-500 hidden">';
    content += '<span>precio alternativo 3</span>';
    content += '<input name="txtprecioalternativotres" type="number" min="0" step="0.01" value="0" class="h-8 border-2 border-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none" />';
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

}

function traerProducto(evento) {
        evento.preventDefault();  // Prevenir el envío normal del formulario
        fetch(detallesProductoNuevoUrl, {
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
}


//Checbox de persona moral o persona fisica si es persona moral el chebox sera verdadero por lo que ocultara apellido
let seleccionarTipoCliente = document.getElementById('tipoDeCliente');
let contenedorCliente = document.querySelector('#tipoCliente');
seleccionarTipoCliente.addEventListener('change', contenedorEmpresaOCliente);

function contenedorEmpresaOCliente() {
    if (this.checked) {
        $('#apellidoCliente').val('.').prop('disabled', true);
        $('#tituloApellido').css('display', 'none');
        document.getElementById('titulonombre').textContent = 'Razon Social';
    } else {
        $('#tituloApellido').css('display', 'flex');
        $('#apellidoCliente').val('').prop('disabled', false);
        document.getElementById('titulonombre').textContent = 'Nombre';
    }
};




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
    let valorAlternativo = document.getElementById("Alternativos").value;
    const selectedOption = selectProducto.options[selectProducto.selectedIndex];
    let precio = selectedOption.getAttribute('data-precio');
    let estatus = selectedOption.getAttribute('data-estatus');
    let idPrecio = selectedOption.getAttribute('data-idPrecio');



    // Luego los pasas a la función
    agregarProducto(selectProducto, idProducto, cantidadInput, cantidad, valorDescuentoCantidad,
        valorDescuentoPorcentaje, precio, estatus, idPrecio, valorAlternativo);




    // Oculta ambos divs
    descuentoCantidad.classList.add('hidden');
    descuentoPorcentaje.classList.add('hidden');
    document.querySelector('#preciosAlternativos').classList.add('hidden');


    //restauramos el select del modal a sin descuento
    document.getElementById('elejirdescuento').value = '1';

    //restauramos el valor delos descuentos
    document.querySelector('#Cantidaddescuento').value = '';
    document.querySelector('#porcentaje').value = '';
    document.getElementById("Alternativos").innerHTML = '';


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
    // Obtén el select por su id
    let alternativoSeleccionado = document.querySelector('#producto');
    // Obtén la opción seleccionada
    const selectedOption = alternativoSeleccionado.options[alternativoSeleccionado.selectedIndex];
    let alternativouno = selectedOption.getAttribute('data-alternativoUno');
    let alternativoDos = selectedOption.getAttribute('data-alternativoDos');
    let alternativoTres = selectedOption.getAttribute('data-alternativoTres');


    // Obtén el select por su id
    var selectAlternativo = document.getElementById("Alternativos");
    // Crea un nuevo option
    var option = document.createElement("option");
    option.value = '';
    option.text = 'Seleccione nuevo precio';
    // Añade el option al select
    selectAlternativo.appendChild(option);
    if (alternativouno != null && alternativouno != 0 && alternativouno != "null") {
        // Crea un nuevo option
        var option = document.createElement("option");
        option.value = alternativouno;
        option.text = alternativouno;
        // Añade el option al select
        selectAlternativo.appendChild(option);
    }
    if (alternativoDos != null && alternativoDos != 0 && alternativouno != "null") {
        // Repite los pasos anteriores para añadir más opciones
        option = document.createElement("option");
        option.value = alternativoDos;
        option.text = alternativoDos;
        selectAlternativo.appendChild(option);
    }
    if (alternativoTres != null && alternativoTres != 0 && alternativouno != "null") {
        // Repite los pasos anteriores para añadir más opciones
        option = document.createElement("option");
        option.value = alternativoTres;
        option.text = alternativoTres;
        selectAlternativo.appendChild(option);
    }


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
            selectAlternativo.value = '';
            selectAlternativo.innerHTML = "";

            // Oculta el modal
            modalDescuentos.classList.add('hidden');
        });


        document.getElementById('elejirdescuento').addEventListener('change', function() {
            // Obtén el valor seleccionado
            var seleccion = this.value;

            switch (seleccion) {
                case '1': //sin descuento
                    // Oculta ambos divs
                    descuentoCantidad.classList.add('hidden');
                    descuentoPorcentaje.classList.add('hidden');
                    document.querySelector('#preciosAlternativos').classList.add('hidden');

                    //restauramos el valor delos descuentos por si pone datos y despues decide no poner descuentos
                    document.querySelector('#Cantidaddescuento').value = '';
                    document.querySelector('#porcentaje').value = '';
                    selectAlternativo.value = '';
                    seleccion = 1;
                    break;
                case '2': // Cantidad
                    descuentoCantidad.classList.remove('hidden');
                    descuentoPorcentaje.classList.add('hidden');
                    document.querySelector('#preciosAlternativos').classList.add('hidden');

                    //restauramos el valor de porcentaje por si cambia de vista se borre lo que pusiera en porcentaje
                    document.querySelector('#porcentaje').value = '';
                    selectAlternativo.value = '';
                    seleccion = 1;
                    break;
                case '3': //porcentaje
                    descuentoCantidad.classList.add('hidden');
                    descuentoPorcentaje.classList.remove('hidden');
                    document.querySelector('#preciosAlternativos').classList.add('hidden');
                    //restauramos el valor del descuento por cantidad por si cambia por porcentaje
                    document.querySelector('#Cantidaddescuento').value = '';
                    selectAlternativo.value = '';
                    break;
                case '4': //precios alternativos
                    // Oculta ambos divs
                    document.querySelector('#preciosAlternativos').classList.remove('hidden');
                    descuentoCantidad.classList.add('hidden');
                    descuentoPorcentaje.classList.add('hidden');
                    //restauramos el valor delos descuentos por si pone datos y despues decide no poner descuentos
                    document.querySelector('#Cantidaddescuento').value = '';
                    document.querySelector('#porcentaje').value = '';
                    break;

                default:
                    break;
            }

        });
    }

}


// Inicializa el array
var productosSeleccionados = [];
// Función para manejar el evento click del botón para agregar productos cuando le de click
function agregarProducto(selectProducto, idProducto, cantidadInput, cantidad, valorDescuentoCantidad,
    valorDescuentoPorcentaje, valorProducto, estatus, idPrecio, valorAlternativo) {
    let tipoDescuento;
    let valorDescuento;


    //verificar que descuento fue positivo o ninguno
    if (valorDescuentoCantidad) {
        tipoDescuento = 'cantidad';
        valorDescuento = valorDescuentoCantidad;
    } else if (valorDescuentoPorcentaje) {
        tipoDescuento = 'Porcentaje';
        valorDescuento = valorDescuentoPorcentaje;
    } else if (valorAlternativo) {
        tipoDescuento = 'alternativo';
        valorDescuento = valorAlternativo;
    } else {
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
    var precio = valorProducto.replace('$', '');

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
            tipoDescuento: tipoDescuento,
            estatus: estatus,
            idPrecio: idPrecio,
        };
        productosSeleccionados.push(producto);

    }

    // Limpia el input de cantidad
    document.getElementById('cantidad').value = '';


    // Agrega los productos seleccionados a la tabla
    agregarProductosATabla(productosSeleccionados);

    Actualizararray(productosSeleccionados);

} //hasta aqui agrega los datos de los productos a un array


function ocultarCosto() {
    if (Revision) {
        datosDeLaVenta.classList.remove('flex', 'flex-col');
        datosDeLaVenta.classList.add('hidden');
        metodoPago.disabled = true
        selectMetodoPago.disabled = true;
    }else{
        datosDeLaVenta.classList.remove('hidden');
        datosDeLaVenta.classList.add('flex', 'flex-col');
        selectMetodoPago.disabled = false;
    }
}


//funcion para mostrar en una tabla todos los productos del array recibimos el array de objetos de productosSeleccionados y lo renombramos como productos
function agregarProductosATabla(productos) {
    var tabla = document.getElementById('cuerpoTabla');
    var totalCosto = 0;
    let productoSuma = 0;
    let recargaSuma = 0;
    let tipoProducto = '';
    // Elimina todas las filas existentes
    while (tabla.firstChild) {
        tabla.removeChild(tabla.firstChild);
    }
    //creamos las celdas y le ponemos el valor segun la cantidad de array
    for (var i = 0; i < productos.length; i++) {
        let producto = productos[i];
        if (producto.estatus == 1) {
            tipoProducto = 'Producto';
                ocultarCosto(Revision);
        } else {
            tipoProducto = 'Revision';
            Revision= true;
            ocultarCosto(Revision);
        }


        let fila = tabla.insertRow(-1);
        fila.id = 'filaProducto_' + i; // Asigna un identificador único a la fila
        let celdaTipoProducto = fila.insertCell(0);
        celdaTipoProducto.style.textAlign = "center";
        let celdaNombre = fila.insertCell(1);
        celdaNombre.style.textAlign = "center";
        let celdaMarca = fila.insertCell(2);
        celdaMarca.style.textAlign = "center";
        let celdaTipo = fila.insertCell(3);
        celdaTipo.style.textAlign = "center";
        let celdaModo = fila.insertCell(4);
        celdaModo.style.textAlign = "center";
        let celdaColor = fila.insertCell(5);
        celdaColor.style.textAlign = "center";
        let celdaCantidad = fila.insertCell(6);
        celdaCantidad.style.textAlign = "center";
        let celdaPrecio = fila.insertCell(7);
        celdaPrecio.style.textAlign = "center";
        let celdaDescuento = fila.insertCell(8);
        celdaDescuento.style.textAlign = "center";
        let celdaCosto = fila.insertCell(9);
        celdaCosto.style.textAlign = "center";
        let celdaEliminar = fila.insertCell(10); // Nueva celda para el botón "Eliminar"
        celdaTipoProducto.textContent = tipoProducto;
        celdaNombre.textContent = producto.nombre;
        celdaMarca.textContent = producto.marca;
        celdaTipo.textContent = producto.tipo;
        celdaModo.textContent = producto.modo;
        celdaColor.textContent = producto.color;
        celdaCantidad.textContent = producto.cantidad;
        celdaPrecio.textContent = producto.precio;
        let costo = producto.precio * producto.cantidad;

        switch (producto.tipoDescuento) {
            case 'cantidad':
                let descuentoCantidadProducto = producto.descuento * producto.cantidad;
                celdaDescuento.textContent = '$' + descuentoCantidadProducto;
                costo = costo - descuentoCantidadProducto;
                break;
            case 'Porcentaje':
                celdaDescuento.textContent = producto.descuento + '%';
                let descuentoAplicado = costo * (producto.descuento / 100);
                costo = costo - descuentoAplicado;
                break;
            case 'alternativo':
                let restanteDelDescuento = producto.precio - producto.descuento;
                let sumaDeDescuento = restanteDelDescuento * producto.cantidad;
                let decuentoAlternativo = producto.descuento * producto.cantidad;
                celdaDescuento.textContent = '$' + sumaDeDescuento;

                costo = decuentoAlternativo;
                break;

            default:
                celdaDescuento.textContent = 'Sin descuentos'
                break;
        }
        celdaCosto.textContent = costo.toFixed(2);
        totalCosto += costo;

        if (producto.estatus == 1) {
            productoSuma += costo;
        } else {
            recargaSuma += costo;
        }

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

    let SumaRecargas = document.querySelector('#SumaRecarga');
    let SumaProductos = document.querySelector('#SumaProducto');
    SumaProductos.textContent = productoSuma.toFixed(2);
    SumaRecargas.textContent = recargaSuma.toFixed(2);
    SumaRecargas.style.fontWeight = 'bold'; // Hace el texto en negrita
    SumaProductos.style.fontWeight = 'bold'; // Hace el texto en negrita
    SumaRecargas.style.fontSize = '1em'; // Hace el texto un 50% más grande
    SumaProductos.style.fontSize = '1em'; // Hace el texto un 50% más grande


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
    let productoSuma = 0;
    let recargaSuma = 0;

    let pagaConInput = document.getElementById('pagaCon');
    // Asegúrate de reemplazar 'idDelTotal' e 'idDelCambio' con los ids reales de tus elementos
    let cambioInput = document.getElementById('cambioInput');

    // Recorre todas las filas de la tabla y suma los costos de los productos
    for (var i = 0; i < tabla.rows.length; i++) {

        //recordar que se se mueve las celdas se tendra que modificar para que calcule las celtas que tienen los costos
        var costo = parseFloat(tabla.rows[i].cells[9].textContent);
        totalCosto += costo;

        //calcular producto y recarga
        var tipoProducto = tabla.rows[i].cells[0].textContent;

        console.log(tipoProducto);

        if (tipoProducto == 'Producto') {
            productoSuma += costo;
            Revision = false;
            ocultarCosto(Revision);
        } else {
            recargaSuma += costo;
            Revision = true;
            ocultarCosto(Revision);
        }
        calcularCambio();
    }

    // Obtiene el elemento y luego actualiza su contenido y estilo
    let sumaTotalElement = document.getElementById('sumaTotal');
    sumaTotalElement.textContent = totalCosto.toFixed(2);
    sumaTotalElement.style.fontWeight = 'bold'; // Hace el texto en negrita
    sumaTotalElement.style.fontSize = '1em'; // Hace el texto un 50% más grande

    let SumaRecargas = document.querySelector('#SumaRecarga');
    let SumaProductos = document.querySelector('#SumaProducto');
    SumaProductos.textContent = productoSuma.toFixed(2);
    SumaRecargas.textContent = recargaSuma.toFixed(2);
    SumaRecargas.style.fontWeight = 'bold'; // Hace el texto en negrita
    SumaProductos.style.fontWeight = 'bold'; // Hace el texto en negrita
    SumaRecargas.style.fontSize = '1em'; // Hace el texto un 50% más grande
    SumaProductos.style.fontSize = '1em'; // Hace el texto un 50% más grande

    calcularCambio();
}

// Obtiene los elementos
let pagaConElement = document.getElementById('pagaCon');
let sumaTotalElement = document.getElementById('SumaProducto');
let cambioInput = document.getElementById('cambioInput');
let PagoRecarga = document.getElementById('pagaConRecarga');
let cambioRecarga = document.getElementById('cambioInputRecarga');
let sumaRecarga = document.getElementById('SumaRecarga');



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
 PagoRecarga.addEventListener('input', function() {

     let pagaConRecarga = Number(PagoRecarga.value);
     let sumaTotalRecarga = Number(sumaRecarga.textContent);
     let cambioDeRecarga = pagaConRecarga - sumaTotalRecarga;
     cambioRecarga.value = cambioDeRecarga.toFixed(2);
 });

// Define la función calcularCambio
function calcularCambio() {
    // Obtiene los valores de los elementos y los convierte a números
    let pagaCon = Number(pagaConElement.value);
    let sumaTotal = Number(sumaTotalElement.textContent);

    let pagaConRecarga = Number(PagoRecarga.value);
    let sumaTotalRecarga = Number(sumaRecarga.textContent);

    // Realiza la resta
    let cambio = pagaCon - sumaTotal;

    let cambioDeRecarga = pagaConRecarga - sumaTotalRecarga;

    // Muestra el resultado en el input cambioInput
    cambioInput.value = cambio.toFixed(2);

    cambioRecarga.value = cambio.toFixed(2);
} //finaliza el calculo de los costos


//funcion para mostrar o ocultar las vistas del efectivo
function metodoPagoSelect() {

    let sumaTotalProducto = Number(sumaTotalElement.textContent);
    let sumaTotalRecarga = Number(sumaRecarga.textContent);
    //aqui mostrammos las opciones si pagammos en efectivo
    if (!Revision) {
        if (this.value === 'Efectivo') {
            //solo si se paga productos mostrara este
            if (sumaTotalProducto > 0) {
                document.getElementById('pagoEfectivo').style.display = 'block';
            } else {
                document.getElementById('pagoEfectivo').style.display = 'none';
            }

            if (sumaTotalRecarga > 0) {
                document.getElementById('pagoEfectivoRecarga').style.display = 'block';
            } else {
                document.getElementById('pagoEfectivoRecarga').style.display = 'none';
            }


        } else {
            document.getElementById('pagoEfectivo').style.display = 'none';
            document.getElementById('pagoEfectivoRecarga').style.display = 'none';
        }
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

let selectAtencion = $('#inputAtiende');
let inputrecibe = $('#recibe');
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
    $('#clave').val('').prop('disabled',false);
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
        $('#clave').val(clienteSeleccionado.clave).prop('disabled',true);

        if (clienteSeleccionado.apellido == ".") {
            $('#apellidoCliente').val(clienteSeleccionado.apellido).prop('disabled', true);
            $('#tituloApellido').css('display', 'none');
            document.getElementById('titulonombre').textContent = 'Razon Social';
        } else {
            $('#apellidoCliente').val(clienteSeleccionado.apellido).prop('disabled', true);
            $('#tituloApellido').css('display', 'flex');
            document.getElementById('titulonombre').textContent = 'Nombre';
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
                    direccion.referencia, direccion.id_direccion));

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
        $('#clave').val('').prop('disabled', false);
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





//ENTRA LA FUNCION CUANDO LE DAMOS AL CHECKBOX QUE REQUERIMOS UN RFC POR QUE QUIERE FACTURA
function RequiereRFC() {
    var checkbox = document.getElementById("factura");
    var rfcInput = document.getElementById("rfc");
    var warning = document.getElementById("warning");

    if (checkbox.checked) {
        rfcInput.required = true;
        rfcInput.disabled = false;
        warning.classList.remove("hidden");
        //         validarRFC(rfcInput);
    } else {
        rfcInput.required = false;
        rfcInput.disabled = true;
        warning.classList.add("hidden");
        //                rfcInput.setCustomValidity(''); // Limpia cualquier mensaje de error anterior
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
     fetch(rutaGuardarProductoAjax, {
         method: 'POST',
         headers: {
             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
         },
         body: formData
     }).
     then(data => {

         alert('Producto guardado exitosamente');
         // Aquí puedes ocultar el modal o actualizar la página
     document.getElementById('modalAgregarProducto').classList.add('hidden');
     paquetesDatosProducto(datoTipoProductoServicio);
     })
     .catch(error => {
         console.error('Error al guardar el producto:', error);
         alert('Hubo un error al guardar el producto.');
     });
 };


//FUNCION QUE PERMITE ENVIAR EL FORMULARIO, PRIMERO REVISA SI HAY VALIDACIONES LUEGO SE DESACTIVA PARA EVITAR DOBLE CLICK Y LUEGO ENVIA FORMULARIO
document.getElementById('botonGuardar').addEventListener('click', function(event) {

    // Obtén el formulario
    var form = document.getElementById('formulario');

    console.log('revision : ' + Revision);


    //Finaliza funcion para validar si no relleno el horario de salida o entrada

    let inputDirecciones = document.querySelector('#inputDirecciones');
    let txtcolonia = document.querySelector('#txtcolonia');
    let calle = document.querySelector('#calle');
    let cambioInput = document.querySelector('#cambioInput'); // Obtener el campo de entrada de cambio
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

    if (!Revision) {
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


    //chebox de funciones

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
