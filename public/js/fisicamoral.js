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
