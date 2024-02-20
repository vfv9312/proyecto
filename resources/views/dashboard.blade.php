{{ $productoPrecio }}
var cantidad = {{ $venta_producto['producto']->cantidad }};
var precio = {{ $venta_producto['precio'] }};
let resultado = precio * cantidad;
let total = precio * cantidad;

document.addEventListener('DOMContentLoaded', (event) => {
document.getElementById('cantidad').value = cantidad;
document.getElementById('valorProducto').textContent = resultado;
});

function handleInput(value) {
var cantidad = value;
resultado = cantidad * precio;
document.getElementById('valorProducto').textContent = resultado;


console.log($precio);
}

oninput="handleInput(this.value)
