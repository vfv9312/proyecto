<?php

namespace App\Http\Controllers;

use App\Models\Orden_recoleccion;
use App\Models\Preventa;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function enviarMensaje($id)
    {

        $ordenRecoleccion = Preventa::leftJoin('orden_recoleccions', function ($join) {
            $join->on('orden_recoleccions.id_preventa', '=', 'preventas.id')
                ->orOn('orden_recoleccions.id_preventaServicio', '=', 'preventas.id');
        })
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->join('personas as personaClientes', 'personaClientes.id', '=', 'clientes.id_persona')
            ->where('preventas.id', $id)
            ->select(
                'orden_recoleccions.id as idRecoleccion',
                'orden_recoleccions.created_at as fechaCreacion',
                'preventas.metodo_pago as metodoPago',
                'preventas.id as idPreventa',
                'preventas.factura',
                'preventas.pago_efectivo as pagoEfectivo',
                'preventas.estado as estatusPreventa',
                'preventas.tipo_de_venta as tipoVenta',
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
            )
            ->first();
        //9612602898

        if ($ordenRecoleccion->tipoVenta === 'Entrega') {
            $enlace = "https://administrativo.ecotonerdelsureste.com/orden_entrega_pdf/$ordenRecoleccion->idRecoleccion/generarpdf";
        } else if ($ordenRecoleccion->tipoVenta === 'Servicio') {
            $enlace = "https://administrativo.ecotonerdelsureste.com/orden_servicio_pdf/$ordenRecoleccion->idRecoleccion/generarpdf";
        }


        $numero = 52 . $ordenRecoleccion->telefonoCliente; //$ordenRecoleccion->telefonoCliente; // Número de teléfono al que deseas enviar el mensaje
        $mensaje = "*Ecotoner* \n\n Hola {$ordenRecoleccion->nombreCliente} {$ordenRecoleccion->apellidoCliente}, te saludamos de ecotoner aquí está el enlace a tu orden de entrega:  {$enlace}"; // Mensaje que deseas enviar

        // Genera el enlace de WhatsApp
        $url = "https://wa.me/{$numero}?text=" . urlencode($mensaje);

        // Redirige al usuario al enlace de WhatsApp
        return redirect()->away($url);
    }
}
