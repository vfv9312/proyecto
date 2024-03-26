<?php

namespace App\Http\Controllers;

use App\Models\Orden_recoleccion;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function enviarMensaje($id)
    {

        $ordenRecoleccion = Orden_recoleccion::join('preventas', 'preventas.id', '=', 'orden_recoleccions.id_preventa')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('empleados', 'empleados.id', '=', 'preventas.id_empleado')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->join('personas as personaClientes', 'personaClientes.id', '=', 'clientes.id_persona')
            ->join('personas as personaEmpleado', 'personaEmpleado.id', '=', 'empleados.id_persona')
            ->join('roles', 'roles.id', '=', 'empleados.id_rol')
            ->where('orden_recoleccions.id', $id)
            ->select(
                'orden_recoleccions.id as idRecoleccion',
                'orden_recoleccions.created_at as fechaCreacion',
                'preventas.metodo_pago as metodoPago',
                'preventas.id as idPreventa',
                'preventas.factura',
                'preventas.pago_efectivo as pagoEfectivo',
                'direcciones.calle',
                'direcciones.num_exterior',
                'direcciones.num_interior',
                'direcciones.referencia',
                'catalago_ubicaciones.municipio',
                'catalago_ubicaciones.estado',
                'catalago_ubicaciones.cp',
                'catalago_ubicaciones.localidad',
                'clientes.comentario as rfc',
                'personaClientes.nombre as nombreCliente',
                'personaClientes.apellido as apellidoCliente',
                'personaClientes.telefono as telefonoCliente',
                'personaClientes.email as correo',
                'personaEmpleado.nombre as nombreEmpleado',
                'personaEmpleado.apellido as apellidoEmpleado',
                'personaEmpleado.telefono as telefonoEmpleado',
                'roles.nombre as nombreRol',
            )
            ->first();
        //9612602898


        $numero = 52 . $ordenRecoleccion->telefonoCliente; //$ordenRecoleccion->telefonoCliente; // Número de teléfono al que deseas enviar el mensaje
        $mensaje = "*Ecotoner* \n\n Hola {$ordenRecoleccion->nombreCliente} {$ordenRecoleccion->apellidoCliente}, te saludamos de ecotoner aquí está el enlace a tu orden de entrega:  https://administrativo.ecotonerdelsureste.com/orden_entrega_pdf/{$ordenRecoleccion->idRecoleccion}/generarpdf"; // Mensaje que deseas enviar

        // Genera el enlace de WhatsApp
        $url = "https://wa.me/{$numero}?text=" . urlencode($mensaje);

        // Redirige al usuario al enlace de WhatsApp
        return redirect()->away($url);
    }
}
