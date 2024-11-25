


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





