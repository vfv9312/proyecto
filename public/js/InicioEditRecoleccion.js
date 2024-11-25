CheckproductoRecoleccion = document.querySelector('#contenedorCheckproductoRecoleccion');
CheckproductoEntrega = document.querySelector('#contenedorCheckproductoEntrega');
let datosDeProductos; //valor de los datos de producto
let contenedorMetodoPago = document.querySelector('#contenedorMetodoPago');
botonAgregarNuevoProducto = document.getElementById('agregarProductoNuevo');
const modalRegistrarProducto = document.querySelector('#modalRegistrarProducto');
const abrirnModalRegisrarProducto = document.querySelector('#Detalle');
const cancelarModal = document.querySelector('.cerrarmodal');
let contenedorCarrito = document.getElementById('contenedorCarrito');
let botonAlmacendeProductos = document.getElementById('agregarProducto');
let contenedorCheckFactura = document.getElementById('contenedorCheckFactura');
let filaRecargas = document.getElementById('filaRecargas');
var tabla = document.getElementById('cuerpoTabla');
let inputPagoEfectivo = document.getElementById('inputPagoEfectivo');
let costo = document.querySelector('input[name="costo_total"]')
let cambiodelEfectivo = document.querySelector('#cambiodelEfectivo');
let pagaCon = document.querySelector('#pagoEfectivoApagar');
let tablaProductos = document.querySelector('#tablaProductos'); //tabla de los productos
let botonesEliminarProducto = document.querySelectorAll('.eliminarProductoenTabla');
let selectorDeEstatus = document.getElementById("miSelect");
let ListadeProductos = listaCompletaProductos;
var totalCosto = 0;
let productoSuma = 0;
let recargaSuma = 0;
let totalDelCosto = 0; costo.value;
let totalApagar = 0; pagaCon.value;
let tipoProducto = '';
let ocultarPrecios = false;
 // Inicializa el array
 var productosSeleccionados = [];
 selectorDeEstatus.addEventListener('change', function() {
    mostrarInputCosto(this.value);  // `this.value` obtiene el valor actual del elemento
});
pagaCon.addEventListener('input', calcularTotal);

// Llama a la función calcularTotal cada vez que cambia un input
document.querySelectorAll('input[name^="costo_unitario"]').forEach(input => {
    input.addEventListener('change', calcularTotal);
});

// Añade un evento al select para ejecutar la función al cambiar de valor
document.getElementById('selectmetodoPago').addEventListener("change", function() {
    Mostrarcambio(this.value);
    calcularTotal();
});

function mostrarInputCosto(value) {

    let inputCosto = document.getElementById('inputCosto');
    let inputFactura = document.querySelector('#inputFactura');
    let inputmetodopago = document.querySelector('#inputmetodopago');
    var inputPersonaRecibe = document.getElementById('personaRecibe');
    let inputcostotabla = document.querySelectorAll('.inputcostotabla');
    let inputcantidad = document.querySelectorAll('.inputcantidad');
    let codigo = document.querySelector('#form_codigo');
    let observaciones = document.querySelector('#form_observaciones');
    let botoneliminar = document.querySelectorAll('.eliminarProductoenTabla');



     inputcostotabla.forEach(input => {
         if (value == 'Entrega') {
             input.required = true;
             input.readOnly = false;


         } else {
             input.required = false;
             input.readOnly = true;


         }
     });
     inputcantidad.forEach(input => {
         if (value == 'Entrega') {
             input.required = true;
             input.readOnly = false;
         } else {
             input.required = false;
             input.readOnly = true;
         }
    });

    switch (value) { // Si se selecciona "Venta completa"

        case 'Listo':
            //inputCosto.style.display = 'none';
            // inputFactura.style.display = 'none';
           // inputmetodopago.display = 'none';
            codigo.classList.add('hidden');
            codigo.classList.remove('flex', 'flex-col');
            observaciones.style.display = 'none';
            botoneliminar.forEach(boton => {
                boton.classList.add('hidden');
                boton.disabled = true;
            });
            inputCosto.classList.remove('flex');
            inputCosto.classList.add('hidden');
            inputFactura.classList.remove('flex', 'flex-col');
            inputFactura.classList.add('hidden');
            inputmetodopago.classList.remove('flex');
            inputmetodopago.classList.add('hidden');

            inputPersonaRecibe.style.display = 'block';

            break;
        case 'Entrega':

            inputPersonaRecibe.style.display = 'none';
            codigo.classList.add('hidden');
            codigo.classList.remove('flex', 'flex-col');
            observaciones.style.display = 'none';
            botoneliminar.forEach(boton => {
                boton.classList.remove('hidden');
                boton.disabled = false;
            });
            inputCosto.classList.remove('hidden');
            inputCosto.classList.add('flex');
            inputFactura.classList.remove('hidden');
            inputFactura.classList.add('flex', 'flex-col');
            inputmetodopago.classList.remove('hidden');
            inputmetodopago.classList.add('flex');


            botonAlmacendeProductos.addEventListener('click', botonAgregar);
            break;
        case 'Revision':
            //inputCosto.style.display = 'none';
            //inputFactura.style.display = 'none';
            //inputmetodopago.display = 'none';
            inputPersonaRecibe.style.display = 'none';
            observaciones.style.display = 'none';

            if (servicio == 'Servicio') {

                codigo.classList.remove('hidden');
                codigo.classList.add('flex', 'flex-col');
                contenedorMetodoPago.classList.remove('block');
                contenedorMetodoPago.classList.add('hidden');
                botonAlmacendeProductos.addEventListener('click', AgregarProductosRecoleccion);
                contenedorCheckFactura.classList.remove('inline-flez');
                contenedorCheckFactura.classList.add('hidden');
                filaRecargas.classList.add('hidden');
                ocultarPrecios = true;


            }

            break;

        case 'Noentregado':
            //inputCosto.style.display = 'none';
            //inputFactura.style.display = 'none';
            //inputmetodopago.display = 'none';
            inputPersonaRecibe.style.display = 'none';
            codigo.classList.add('hidden');
            codigo.classList.remove('flex', 'flex-col');
            observaciones.clasList.add('flex');
            break;

        default:
            inputCosto.classList.remove('flex');
            inputCosto.classList.add('hidden');
            inputFactura.classList.remove('flex','flex-col');
            inputFactura.classList.add('hidden');
            inputmetodopago.classList.remove('flex');
            inputmetodopago.classList.add('hidden');
            inputPersonaRecibe.style.display = 'none';
            codigo.classList.add('hidden');
            codigo.classList.remove('flex', 'flex-col');
            observaciones.style.display = 'none';
            break;
    }

}
//Elimino productos de la tabla
tablaProductos.addEventListener('click', function(event) {

    // Verifica si el target es un botón de eliminar
    if (event.target && event.target.matches('button.eliminarProductoenTabla')) {
        event.preventDefault();
        // Obtén el ID del producto desde el atributo data-id
        let productoId = event.target.dataset.id;

        // Filtrar el array para eliminar el producto con el ID
        ListadeProductos = ListadeProductos.filter(producto => producto.id != productoId);
        tablapendiente();
        mostrarInputCosto(selectorDeEstatus.value);
    }


    if (selectorDeEstatus.value === 'Entrega') {
        calcularTotal();
    }


});
//actualizacion de la tabla
tablaProductos.addEventListener('input', tiempoDeEscribir(function(event){
    if (event.target && event.target.matches('.inputcantidad')) {
        // Obtén el valor del input
    let valorInputCantidad = event.target.value;  // Este es el valor del input donde hiciste click

    let idProducto = event.target.dataset.id;
    const producto = ListadeProductos.find(producto => producto.id == idProducto);
switch (infoDeLaOrdenRecoleccion.tipoVenta) {
    case 'Entrega':
        if (producto) {
            // Si el producto fue encontrado, actualiza su precio
            producto.cantidad = valorInputCantidad;

          } else {
            console.log('Producto no encontrado');
          }
        break;
    case 'Servicio':
        if (producto) {
            // Si el producto fue encontrado, actualiza su precio
            producto.cantidad = valorInputCantidad;

          } else {
            console.log('Producto no encontrado');
          }
       break;

    default:
        break;
}



}
if (event.target && event.target.matches('.inputcostotabla')) {
    let idProducto = event.target.dataset.id;
    const producto = ListadeProductos.find(producto => producto.id == idProducto);
    let valorInputCosto = event.target.value;  // Este es el valor del input donde hiciste click
    switch (infoDeLaOrdenRecoleccion.tipoVenta) {
        case 'Entrega':
            if (producto) {
                // Si el producto fue encontrado, actualiza su precio
                   producto.precio = valorInputCosto;
                } else {
                console.log('Producto no encontrado');
               }
            break;
        case 'Servicio':
            if (producto) {
                // Si el producto fue encontrado, actualiza su precio
                   producto.precio_unitario = valorInputCosto;

                } else {
                console.log('Producto no encontrado');
               }
           break;

        default:
            break;
    }



}

tablapendiente();
mostrarInputCosto(selectorDeEstatus.value);
calcularTotal();
},1000));// 1000 milisegundos de retardo antes de ejecutar la actualización

// Función debounce
function tiempoDeEscribir(func, delay) {
    let timer;
    return function() {
        const context = this;
        const args = arguments;
        clearTimeout(timer);
        timer = setTimeout(() => {
            func.apply(context, args);
        }, delay);
    };
}

function tablapendiente() {

    let thTitulo = '<th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">';
    let tdContenido = '<td class="px-6 py-4 whitespace-nowrap">';

            // Crear dinámicamente una tabla HTML
            let html = '<table class="min-w-full divide-y divide-gray-200">';
            html += '<thead class="bg-gray-50">';
            html += '<tr>';
            html += thTitulo;
            html += ' Nombre Comercial</th>';
            html += thTitulo;
            html += 'Cantidad Total</th>';
            html += thTitulo;
            html += 'Descripción</th>';
            html += thTitulo;
            html += 'Precio Unitario</th>';
            html += thTitulo;
            html += 'Descuento</th>';
            html += thTitulo;
            html += 'Costo</th>';
            html += thTitulo;
            html += 'Eliminar</th>';
            html += '</tr></thead>';
            html += '<tbody class="bg-white divide-y divide-gray-200"></tr>';

    ListadeProductos.forEach(producto => {
    // Columna 1: Nombre Comercial
    html += tdContenido + producto.nombre_comercial + '</td>';

    // Columna 2: Cantidad Total
    switch (infoDeLaOrdenRecoleccion.tipoVenta) {
        case 'Entrega':
            html += tdContenido + '<input type="number" name="cantidad[' + producto.id + ']" data-cantidad="' + producto.cantidad + '"  data-id="' + producto.id + '" step="1" class="inputcantidad block w-full mt-1 form-input" placeholder="Cantidad" value="' + producto.cantidad + '" readonly>' + '</td>';
            break;
        case 'Servicio':
            html += tdContenido + '<input type="number" name="cantidad[' + producto.id + ']" data-cantidad="' + producto.cantidad + '"  data-id="' + producto.id + '" step="1" class="inputcantidad block w-full mt-1 form-input" placeholder="Cantidad" value="' + producto.cantidad + '" readonly>' + '</td>';
            break;
        default:
            html += tdContenido + producto.cantidad + '</td>';
            break;
    }
     // Columna 3: Descripcion
    let desc = producto.descripcion ? ' Descripcion : ' + producto.descripcion : '';
    html += tdContenido + 'Marca : ' + producto.nombreMarca + ' Categoria : ' + producto.nombreTipo + ' Color :'+ producto.nombreColor + ' Tipo : ' + producto.nombreModo +  desc  + '</td>';
     // Columna 4: Precio unitario
     switch (infoDeLaOrdenRecoleccion.tipoVenta) {
        case 'Entrega':
            html += tdContenido + '<input type="number" name="costo_unitario[' + producto.id + ']" data-descuento="'+ producto.descuento +'" data-tipodescuento="'+ producto.tipoDescuento +'" data-cantidad="' + producto.cantidad + '"  data-id="' + producto.id + '" step="0.01" class="inputcostotabla block w-full mt-1 form-input" placeholder="Costo unitario" value="' + producto.precio + '" readonly></input> </td>';
            break;
        case 'Servicio':
            html += tdContenido + '<input type="number" name="costo_unitario[' + producto.id + ']" data-descuento="'+ producto.descuento +'" data-tipodescuento="'+ producto.tipoDescuento +'" data-cantidad="' + producto.cantidad + '"  data-id="' + producto.id + '" step="0.01" class="inputcostotabla block w-full mt-1 form-input" placeholder="Costo unitario" value="' + producto.precio_unitario + '" readonly></input> </td>';
        break;

        default:
            html += tdContenido + producto.precio + '</td>';
            break;
     }

    switch (producto.tipoDescuento ) {
        case 'Porcentaje':
           html += tdContenido + parseInt(producto.descuento) + '%' + '</td>';
        break;
        case 'cantidad':


            html += tdContenido + '$' + (producto.descuento * producto.cantidad) + '</td>';
        break;
        case 'alternativo':
            html += tdContenido +'$' + (producto.precio - producto.descuento) * (producto.cantidad) + '</td>';
        break;
        case 'Sin descuento':
            html += tdContenido + producto.tipoDescuento + '</td>';
        break;

        default:
            html += tdContenido +producto.tipoDescuento + '</td>';
            break;
    }
    switch (infoDeLaOrdenRecoleccion.tipoVenta) {
        case 'Entrega':
            if (producto.tipoDescuento == 'Porcentaje') {
                // Realizar la operación de porcentaje correctamente
                html += tdContenido + '$' + ((producto.precio * producto.cantidad) - ((producto.precio * parseInt(producto.descuento)) / 100)) + '</td>';
            } else if (producto.tipoDescuento == 'cantidad') {
                html += tdContenido + '$' + (producto.precio * producto.cantidad - producto.descuento * producto.cantidad) + '</td>';
            } else if (producto.tipoDescuento == 'alternativo') {
                html += tdContenido + producto.descuento * producto.cantidad + '</td>';
            } else if (producto.tipoDescuento == 'Sin descuento') {
                html += tdContenido + (producto.precio * producto.cantidad) + '</td>';
            }
            break;

        case 'Servicio':
            html += tdContenido + (producto.precio_unitario * producto.cantidad) + '</td>';
            break;

        default:
            break;
    }
        html += tdContenido + '<button class="eliminarProductoenTabla text-red-500 hover:text-red-700" data-id="' + producto.id + '">Eliminar</button>' + '</td>';
        html += '</tr>';
    });

    html += '</tbody></table>';
    tablaProductos.innerHTML = html;
}


document.addEventListener('DOMContentLoaded', function() {
    CheckproductoRecoleccion.classList.add('hidden');
    CheckproductoEntrega.classList.add('hidden');
    tablapendiente();

    actualizarListaRecolecciones()

});


function actualizarListaRecolecciones() {


    axios.post(productRecargaUrl, {
        productoRecarga: '1'
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


$(document).ready(function() {
    // Función para buscar en las opciones
    function matchCustom(params, data) {
        // Si no hay término de búsqueda, muestra todas las opciones
        if ($.trim(params.term) === '') {
            return data;
        }

        // Verifica si hay texto en el dato de la opción
        if (typeof data.text === 'undefined') {
            return null;
        }

        // Compara el término de búsqueda con el texto de la opción, ignorando espacios y mayúsculas/minúsculas
        if (data.text.replace(/\s/g, '').toLowerCase().includes(params.term.replace(/\s/g, '').toLowerCase())) {
            return data;
        }

        // Si no coincide, no muestra la opción
        return null;
    }

    // Inicializa Select2 en el select y asigna la función de búsqueda
    $('#producto').select2({
        matcher: matchCustom,
        placeholder: "Seleccione un producto",
        allowClear: true // Para permitir limpiar la selección
    });
});


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



        //llamado para abrir un modal de un formulario para agregar un producto nuevo
botonAgregarNuevoProducto.addEventListener('click', function(evento) {
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
});


function calcularTotal() {
    let inputcostotabla = document.querySelectorAll('.inputcostotabla');
    let inputcantidad = document.querySelectorAll('.inputcantidad');
    var total = 0;
    let descuento = 0;
    inputcostotabla.forEach((input, indice) =>  {
        var costoUnitario = Number(input.value);  // El valor del input costo
        const dataDescuento = input.dataset.descuento;
        const dataTipoDescuento = input.dataset.tipodescuento
        var cantidad = Number(inputcantidad[indice].value);  // El valor de la cantidad correspondiente
         // Si el costo y la cantidad son números válidos, multiplicarlos y sumarlos al total
         if (!isNaN(costoUnitario) && !isNaN(cantidad)) {
            console.log(dataTipoDescuento);

                switch (dataTipoDescuento) {
                    case 'Sin descuento':
                        total += costoUnitario * cantidad;
                        break;
                    case 'cantidad':
                        descuento = cantidad * dataDescuento;
                        total += costoUnitario * cantidad - descuento;
                       break;

                    case 'Porcentaje':
                        total += costoUnitario * cantidad;
                        break;

                    default:
                        break;
                }


        }
    });

    costo.value = total.toFixed(2);
    cambiodelEfectivo.value = pagaCon.value - costo.value;
}


// Calcula el total inicial
calcularTotal();



function Mostrarcambio(valor) {

    if (valor == 'Efectivo') {
        inputPagoEfectivo.classList.remove('hidden');
        inputPagoEfectivo.classList.add('block');
// Calcula el total inicial
calcularTotal();
    } else {
        inputPagoEfectivo.classList.remove('block');
        inputPagoEfectivo.classList.add('hidden');
    }
}


function validarcantidad(cantidad,cantidadInput) {

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
                return false;  // Indicar que la cantidad no es válida
            } else {
                // Si el campo es válido, limpiar cualquier mensaje de error anterior
                cantidadInput.setCustomValidity('');
                return true;  // Indicar que la cantidad es válida
            }
}


function AgregarProductosRecoleccion() {
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

     if(!validarcantidad(cantidad,cantidadInput)){
        alert("La cantidad debe ser al menos 1.");
        return;
     }

             // Luego los pasas a la función
             agregarProducto(selectProducto, idProducto, cantidadInput, cantidad, valorDescuentoCantidad,
                valorDescuentoPorcentaje, precio, estatus, idPrecio, valorAlternativo);

}



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


            validarcantidad(cantidad, cantidadInput);


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

    //funcion para mostrar en una tabla todos los productos del array recibimos el array de objetos de productosSeleccionados y lo renombramos como productos
function agregarProductosATabla(productos) {

        // Elimina todas las filas existentes
        while (tabla.firstChild) {
            tabla.removeChild(tabla.firstChild);
        }
        //creamos las celdas y le ponemos el valor segun la cantidad de array
        for (var i = 0; i < productos.length; i++) {
            let producto = productos[i];
            if (producto.estatus == 1) {
                tipoProducto = 'Producto';

            } else {
                tipoProducto = 'Recoleccion';

            }
            let fila = tabla.insertRow(-1);
            let celdaTipoProducto = fila.insertCell(0);
            let celdaNombre = fila.insertCell(1);
            let celdaMarca = fila.insertCell(2);
            let celdaTipo = fila.insertCell(3);
            let celdaModo = fila.insertCell(4);
            let celdaColor = fila.insertCell(5);
            let celdaCantidad = fila.insertCell(6);
            let celdaPrecio = fila.insertCell(7);
            let celdaDescuento = fila.insertCell(8);
            let celdaCosto = fila.insertCell(9);
            let celdaEliminar = fila.insertCell(10); // Nueva celda para el botón "Eliminar"
            let costo = 0;


            fila.id = 'filaProducto_' + i; // Asigna un identificador único a la fila

            celdaTipoProducto.classList.add("text-center");

            celdaNombre.classList.add("text-center");

            celdaMarca.classList.add("text-center");

            celdaTipo.classList.add("text-center");

            celdaModo.classList.add("text-center");

            celdaColor.classList.add("text-center");

            celdaCantidad.classList.add("text-center");

            celdaPrecio.classList.add("text-center");

            celdaDescuento.classList.add("text-center");

            celdaCosto.classList.add("text-center");

            celdaTipoProducto.textContent = tipoProducto;
            celdaNombre.textContent = producto.nombre;
            celdaMarca.textContent = producto.marca;
            celdaTipo.textContent = producto.tipo;
            celdaModo.textContent = producto.modo;
            celdaColor.textContent = producto.color;
            celdaCantidad.textContent = producto.cantidad;
            if(ocultarPrecios){
                celdaPrecio.textContent = 0;
                costo = 0

            }else{
                celdaPrecio.textContent = producto.precio;
                costo = producto.precio * producto.cantidad;
            }

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
            var tipoProducto = parseFloat(tabla.rows[i].cells[0].textContent);

            if (tipoProducto == 1) {
                productoSuma += costo;
            } else {
                recargaSuma += costo;
            }
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

        cambiodelEfectivo.value = cambio.toFixed(2);
} //finaliza el calculo de los costos



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
     formData.append('txtprecio', document.querySelector('#txtprecioProductoNuevo').value);
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
         console.log(data);  // Manejar la respuesta
         alert('Producto guardado exitosamente');
         // Aquí puedes ocultar el modal o actualizar la página
     document.getElementById('modalAgregarProducto').classList.add('hidden');
     actualizarListaRecolecciones()
     })
     .catch(error => {
         console.error('Error al guardar el producto:', error);
         alert('Hubo un error al guardar el producto.');
     });
 };


    // Validar antes de enviar el formulario
document.getElementById("formularioEdit").addEventListener("submit", function(event) {
        event.preventDefault(); // Evita el envío automático del formulario

        // Selecciona los campos que deben tener un valor
        const obersaciondeEntrega = document.getElementById("obersaciondeEntrega").value;
        const FechadeEntrega = document.getElementById("FechadeEntrega").value;
        const recibeEnLaEntrega = document.getElementById('recibeenlaEntrega').value;
        const valorSelect = document.getElementById("miSelect").value;
        const valorEntrego = document.getElementById('entrego').value;
        const valorobservacionesInicial = document.getElementById('observacionesInicial').value;
        const valorfechaRecolecciones = document.getElementById('fechaRecolecciones').value;
        const valorListaProductos = document.getElementById('inputProductosSeleccionados').value;
        const valorselectmetodoPago = document.getElementById('selectmetodoPago').value;

        let totalDelCosto = parseFloat(costo.value);
        let totalApagar = parseFloat(pagaCon.value);


        // Validación dependiendo del valor seleccionado
        if (valorSelect === "Listo") {
            if(ListadeProductos.length == 0){
                alert('Lista de Productos vacia');
                return;
            }
            else if (!obersaciondeEntrega || !FechadeEntrega || !recibeEnLaEntrega) {
                alert("Por favor, complete el campo faltantes");
                return;
            }

        } else if (valorSelect === "Entrega") {
            if(ListadeProductos.length == 0){
                alert('Lista de Productos vacia');
                return;
            }

            if (valorselectmetodoPago === 'Efectivo') {

                if (isNaN(totalDelCosto) || isNaN(totalApagar)) {
                    alert("ingrese el total a pagar");
                    return; // Detiene la ejecución y no envía el formulario
                }
                else if (totalDelCosto > totalApagar) { // Verifica que cambio y costo sean >= 0
                    alert("El cambio no puede ser menor a 0.");
                    return; // Detiene la ejecución y no envía el formulario
                }
            } else if (valorselectmetodoPago == ''){
                alert("Seleccione un metodo de pago.");
                return; // Detiene la ejecución y no envía el formulario
            }
        } else if (valorSelect === 'Revision'){

            if (!valorEntrego || !valorobservacionesInicial || !valorfechaRecolecciones || valorListaProductos.length === 0 || valorListaProductos.length === 2) {
                alert("Por favor, complete el campo faltantes");
                return; // Detiene la ejecución y no envía el formulario
            }
        }
        else if (valorSelect === 'EnRevision') {
            alert("Actualizacion invalida");
            return; // Detiene la ejecución y no envía el formulario
        }

        document.getElementById("formularioEdit").submit();
});
