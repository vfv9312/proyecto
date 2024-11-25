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
    public function enviarMensaje($id, $telefono)
    {

        $ordenRecoleccion = Preventa::leftJoin('orden_recoleccions', function ($join) {
            $join->on('orden_recoleccions.id_preventa', '=', 'preventas.id')
                ->orOn('orden_recoleccions.id_preventaServicio', '=', 'preventas.id')
                ->orOn('orden_recoleccions.id_preventaOrdenServicio', '=', 'preventas.id');
        })
            ->leftJoin('folios', 'folios.id', '=', 'orden_recoleccions.id_folio')
            ->leftJoin('folios_servicios','folios_servicios.id','=','orden_recoleccions.id_folio_servicio')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->join('personas as personaClientes', 'personaClientes.id', '=', 'clientes.id_persona')
            ->where('preventas.id',  $id)
            ->select(
                'orden_recoleccions.id as idRecoleccion',
                'orden_recoleccions.created_at as fechaCreacion',
                'folios.letra_actual as letraActual',
                'folios.ultimo_valor as ultimoValor',
                'folios_servicios.ultimo_valor',
                'preventas.metodo_pago as metodoPago',
                'preventas.id as idPreventa',
                'preventas.factura',
                'preventas.pago_efectivo as pagoEfectivo',
                'preventas.nombre_atencion as nombreAtencion',
                'preventas.horario_trabajo_inicio as horarioTrabajoInicio',
                'preventas.horario_trabajo_final as horarioTrabajoFinal',
                'preventas.dia_semana as diaSemana',
                'preventas.estado',
                'preventas.tipo_de_venta as tipoVenta',
                'direcciones.calle',
                'direcciones.num_exterior',
                'direcciones.num_interior',
                'direcciones.referencia',
                'catalago_ubicaciones.cp',
                'catalago_ubicaciones.localidad',
                'clientes.comentario as rfc',
                'personaClientes.nombre as nombreCliente',
                'personaClientes.apellido as apellidoCliente',
                'personaClientes.telefono as telefonoCliente',
                'personaClientes.email as correo',
            )
            ->first();

        // Definir la parte variable de la URL según el tipo de venta
        $pdfType = ($ordenRecoleccion->tipoVenta == 'Orden Servicio') ? 'generarpdf2' : 'generarpdf';
        $rutaOrden = ($ordenRecoleccion->tipoVenta == 'Entrega') ? 'orden_entrega_pdf' : 'orden_servicio_pdf';

    $enlace = "https://administrativo.ecotonerdelsureste.com/$rutaOrden/$ordenRecoleccion->idRecoleccion/$pdfType";

        $numero = "+52" . $telefono ? $telefono : $ordenRecoleccion->telefonoCliente; //$ordenRecoleccion->telefonoCliente; // Número de teléfono al que deseas enviar el mensaje
        $mensaje = "*Ecotoner* \n\n Hola {$ordenRecoleccion->nombreCliente} {$ordenRecoleccion->apellidoCliente}, te saludamos de ecotoner aquí está el enlace a tu orden de entrega:  {$enlace}"; // Mensaje que deseas enviar

        // Genera el enlace de WhatsApp
        $url = "https://wa.me/{$numero}?text=" . urlencode($mensaje);

        // Redirige al usuario al enlace de WhatsApp
        return redirect()->away($url);
    }
}
