


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

            } else {
                tipoProducto = 'Recarga';

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

        cambioRecarga.value = cambio.toFixed(2);
} //finaliza el calculo de los costos


    //funcion para mostrar o ocultar las vistas del efectivo
document.getElementById('metodoPago').addEventListener('change', function() {
        let sumaTotalProducto = Number(sumaTotalElement.textContent);
        let sumaTotalRecarga = Number(sumaRecarga.textContent);
        //aqui mostrammos las opciones si pagammos en efectivo
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
});





