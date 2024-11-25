const inputOculto = document.getElementById('inputcheckProductooRecoleccion'); // Asegúrate de tener este input en tu HTML
let metodoPago = document.querySelector('#metodoPago');
let recoleccionCheckbox = document.getElementById('CheckproductoRecoleccion');
let entregaCheckbox = document.getElementById('CheckproductoEntrega');
let contenedorCarrito = document.getElementById('contenedorCarrito');
let contenedorProducto = document.getElementById('contenedorProducto');



// Función para manejar la visibilidad de los contenedores
function actualizarVisibilidad() {

    if(recoleccionCheckbox.checked && entregaCheckbox.checked){
        contenedorCarrito.classList.remove('hidden');
        contenedorProducto.classList.remove('hidden');
        inputOculto.value = 'seleccionadolosdos'; // Llenar el input con
    } else if (recoleccionCheckbox.checked) {
        // Si recolección está seleccionado, ocultar ambos divs
        contenedorCarrito.classList.add('hidden');
        contenedorProducto.classList.add('hidden');
        inputOculto.value = 'recoleccion'; // Llenar el input con el texto 'recoleccion'
    } else if (entregaCheckbox.checked) {
        // Si entrega está seleccionado, mostrar ambos divs
        contenedorCarrito.classList.remove('hidden');
        contenedorProducto.classList.remove('hidden');
        inputOculto.value = 'entrega'; // Llenar el input con el texto 'entrega
    } else {
        // Si ninguno está seleccionado, ocultar ambos divs
        contenedorCarrito.classList.add('hidden');
        contenedorProducto.classList.add('hidden');
        inputOculto.value = 'deseleccionadolosdos'; // Llenar el input con
    }

}

// Escuchar cambios en los checkbox
recoleccionCheckbox.addEventListener('change', actualizarVisibilidad);
entregaCheckbox.addEventListener('change', actualizarVisibilidad);

// Llamar a la función una vez para inicializar el estado correcto
actualizarVisibilidad();




 //MUESTRA EL FORMULARIO DE DIRECCION SI SE VA AGREGAR UNO
        document.getElementById('mostrarNuevaDireccion').addEventListener('click', function(eventoClick) {
            eventoClick.preventDefault();
            document.getElementById('nuevaDireccion').classList.toggle('hidden');  // Alternar la visibilidad
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


           //FUNCION QUE PERMITE ENVIAR EL FORMULARIO, PRIMERO REVISA SI HAY VALIDACIONES LUEGO SE DESACTIVA PARA EVITAR DOBLE CLICK Y LUEGO ENVIA FORMULARIO
    document.getElementById('botonGuardar').addEventListener('click', function(event) {
        // Obtén el formulario
        var form = document.getElementById('formulario');

        var dias = ['Lunes-Viernes', 'Sabado', 'Domingo', 'Lunes-ViernesDiscontinuo', 'SabadoDiscontinuo','DomingoDiscontinuo'];
        for (var i = 0; i < dias.length; i++) {
            var dia = dias[i];
            var entrada = document.getElementById(dia + '_entrada').value;
            var salida = document.getElementById(dia + '_salida').value;

            if (entrada && !salida) {
                alert('Por favor, también rellene el campo de Hora de salida para el ' + dia + '.');
                event.preventDefault();
                return;
            }
        }
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

//Checa que si el checbox si es entrega o recollecion es null entonces es una entrega y si solo dice recoleccion es recoleccion
            if (['entrega','seleccionadolosdos'].includes(inputOculto.value)) {
                metodoPago.setCustomValidity('');
                cambioyproductos(event, ArrayProductos, cambioInput);
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

    function cambioyproductos(event, ArrayProductos, cambioInput) {


        //Verificar que tenga datos el array de productos
        if (!ArrayProductos.value) {
            alert('No has agregado productos a tu lista de pedidos');
            event.preventDefault();
            return;
        }

        if (!metodoPago.value) {
            metodoPago.setCustomValidity(
                'Debes seleccionar un metodo de pago para la Entrega.');
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
    }
