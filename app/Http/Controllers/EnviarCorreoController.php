<?php

namespace App\Http\Controllers;

use App\Mail\correoMailable;
use App\Models\Catalago_ubicaciones;
use App\Models\Orden_recoleccion;
use App\Models\precios_productos;
use App\Models\Preventa;
use App\Models\TiempoAproximado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EnviarCorreoController extends Controller
{
    public function enviarCorreos($id)
    {
        // Enviar correo electrónico
        try {

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



            switch ($ordenRecoleccion->tipoVenta) {
                case 'Entrega':
                    $listaProductos = precios_productos::join('ventas_productos', 'ventas_productos.id_precio_producto', '=', 'precios_productos.id')
                        ->join('preventas', 'preventas.id', '=', 'ventas_productos.id_preventa')
                        ->join('productos', 'productos.id', '=', 'precios_productos.id_producto')
                        ->join('marcas', 'marcas.id', '=', 'productos.id_marca')
                        ->join('colors', 'colors.id', '=', 'productos.id_color')
                        ->join('tipos', 'tipos.id', '=', 'productos.id_tipo')
                        ->join('modos', 'modos.id', '=', 'productos.id_modo')
                        ->where('preventas.id', $ordenRecoleccion->idPreventa)
                        ->select(
                            'productos.nombre_comercial',
                            'precios_productos.precio',
                            'ventas_productos.cantidad',
                            'colors.nombre as nombreColor',
                            'marcas.nombre as nombreMarca',
                            'tipos.nombre as nombreTipo',
                            'modos.nombre as nombreModo'
                        )
                        ->get();
                    break;
                    case 'Orden Servicio':
                        $listaProductos = precios_productos::leftjoin('servicios_preventas', 'servicios_preventas.id_precio_producto', '=', 'precios_productos.id')
                        ->leftjoin('ventas_productos', 'ventas_productos.id_precio_producto', '=', 'precios_productos.id')
                        ->leftjoin('preventas as preventasServicio', 'preventasServicio.id', '=', 'servicios_preventas.id_preventa')
                        ->leftjoin('preventas as preventasProducto', 'preventasProducto.id', '=', 'ventas_productos.id_preventa')
                        ->leftjoin('productos', 'productos.id', '=', 'precios_productos.id_producto')
                        ->leftjoin('productos as productoenServicio', 'productoenServicio.id', '=', 'precios_productos.id_producto')
                        ->leftjoin('marcas', 'marcas.id', '=', 'productos.id_marca')
                        ->leftjoin('colors', 'colors.id', '=', 'productos.id_color')
                        ->leftjoin('tipos', 'tipos.id', '=', 'productos.id_tipo')
                        ->leftjoin('modos', 'modos.id', '=', 'productos.id_modo')
                        ->leftjoin('marcas as marcasServicio', 'marcasServicio.id', '=', 'productoenServicio.id_marca')
                        ->leftjoin('colors as colorsServicio', 'colorsServicio.id', '=', 'productoenServicio.id_color')
                        ->leftjoin('tipos as tiposServicio', 'tiposServicio.id', '=', 'productoenServicio.id_tipo')
                        ->leftjoin('modos as modoServicios', 'modoServicios.id', '=', 'productoenServicio.id_modo')
                        ->where('preventasServicio.id', $ordenRecoleccion->idPreventa)
                        ->orWhere('preventasProducto.id', $ordenRecoleccion->idPreventa)
                        ->select(
                            'productos.nombre_comercial',
                            'servicios_preventas.precio_unitario',
                            'servicios_preventas.cantidad_total as cantidad',
                            'ventas_productos.cantidad as cantidadProducto',
                            'ventas_productos.tipo_descuento',
                            'servicios_preventas.tipo_descuento as tipoDescuento',
                            'servicios_preventas.descuento',
                            'precios_productos.precio',
                            'colors.nombre as nombreColor',
                            'marcas.nombre as nombreMarca',
                            'tipos.nombre as nombreTipo',
                            'modos.nombre as nombreModo',
                            'ventas_productos.descipcion',
                            'servicios_preventas.descripcion',

                        )
                        ->get();

                    break;

                default:
                    $listaProductos = precios_productos::join('servicios_preventas', 'servicios_preventas.id_precio_producto', '=', 'precios_productos.id')
                        ->join('preventas', 'preventas.id', '=', 'servicios_preventas.id_preventa')
                        ->join('productos', 'productos.id', '=', 'precios_productos.id_producto')
                        ->join('marcas', 'marcas.id', '=', 'productos.id_marca')
                        ->join('colors', 'colors.id', '=', 'productos.id_color')
                        ->join('tipos', 'tipos.id', '=', 'productos.id_tipo')
                        ->join('modos', 'modos.id', '=', 'productos.id_modo')
                        ->whereIn('servicios_preventas.estatus', [1])
                        ->where('preventas.id', $ordenRecoleccion->idPreventa)
                        ->select(
                            'productos.nombre_comercial',
                            'servicios_preventas.precio_unitario',
                            'servicios_preventas.cantidad_total as cantidad',
                            'servicios_preventas.tipo_descuento as tipoDescuento',
                            'servicios_preventas.descuento',
                            'precios_productos.precio',
                            'colors.nombre as nombreColor',
                            'marcas.nombre as nombreMarca',
                            'tipos.nombre as nombreTipo',
                            'modos.nombre as nombreModo'
                        )
                        ->get();
                    break;
            }

            $fechaCreacion = \Carbon\Carbon::parse($ordenRecoleccion->fechaCreacion);
            $Tiempo = TiempoAproximado::whereDate('created_at', $fechaCreacion->toDateString())->orderBy('created_at', 'desc')->first();


            Mail::to($ordenRecoleccion->correo)->send(new correoMailable($ordenRecoleccion, $listaProductos, $Tiempo));
            $error = 0;
        } catch (\Exception $e) {
            $error = 1;
        }

        return redirect()->route('Correo.vistaPrevia', ['error' => $error, 'id' => $id]);
    }

    public function vistaPrevia($error, $id)
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


            switch ($ordenRecoleccion->tipoVenta) {
                case 'Entrega':
                    $listaProductos = precios_productos::join('ventas_productos', 'ventas_productos.id_precio_producto', '=', 'precios_productos.id')
                        ->join('preventas', 'preventas.id', '=', 'ventas_productos.id_preventa')
                        ->join('productos', 'productos.id', '=', 'precios_productos.id_producto')
                        ->join('marcas', 'marcas.id', '=', 'productos.id_marca')
                        ->join('colors', 'colors.id', '=', 'productos.id_color')
                        ->join('tipos', 'tipos.id', '=', 'productos.id_tipo')
                        ->join('modos', 'modos.id', '=', 'productos.id_modo')
                        ->where('preventas.id', $ordenRecoleccion->idPreventa)
                        ->select(
                            'productos.nombre_comercial',
                            'precios_productos.precio',
                            'ventas_productos.cantidad',
                            'colors.nombre as nombreColor',
                            'marcas.nombre as nombreMarca',
                            'tipos.nombre as nombreTipo',
                            'modos.nombre as nombreModo'
                        )
                        ->get();
                    break;
                    case 'Orden Servicio':
                        $listaProductos = precios_productos::leftjoin('servicios_preventas', 'servicios_preventas.id_precio_producto', '=', 'precios_productos.id')
                        ->leftjoin('ventas_productos', 'ventas_productos.id_precio_producto', '=', 'precios_productos.id')
                        ->leftjoin('preventas as preventasServicio', 'preventasServicio.id', '=', 'servicios_preventas.id_preventa')
                        ->leftjoin('preventas as preventasProducto', 'preventasProducto.id', '=', 'ventas_productos.id_preventa')
                        ->leftjoin('productos', 'productos.id', '=', 'precios_productos.id_producto')
                        ->leftjoin('productos as productoenServicio', 'productoenServicio.id', '=', 'precios_productos.id_producto')
                        ->leftjoin('marcas', 'marcas.id', '=', 'productos.id_marca')
                        ->leftjoin('colors', 'colors.id', '=', 'productos.id_color')
                        ->leftjoin('tipos', 'tipos.id', '=', 'productos.id_tipo')
                        ->leftjoin('modos', 'modos.id', '=', 'productos.id_modo')
                        ->leftjoin('marcas as marcasServicio', 'marcasServicio.id', '=', 'productoenServicio.id_marca')
                        ->leftjoin('colors as colorsServicio', 'colorsServicio.id', '=', 'productoenServicio.id_color')
                        ->leftjoin('tipos as tiposServicio', 'tiposServicio.id', '=', 'productoenServicio.id_tipo')
                        ->leftjoin('modos as modoServicios', 'modoServicios.id', '=', 'productoenServicio.id_modo')
                        ->where('preventasServicio.id', $ordenRecoleccion->idPreventa)
                        ->orWhere('preventasProducto.id', $ordenRecoleccion->idPreventa)
                        ->select(
                            'productos.nombre_comercial',
                            'servicios_preventas.precio_unitario',
                            'servicios_preventas.cantidad_total as cantidad',
                            'ventas_productos.cantidad as cantidadProducto',
                            'ventas_productos.tipo_descuento',
                            'servicios_preventas.tipo_descuento as tipoDescuento',
                            'servicios_preventas.descuento',
                            'precios_productos.precio',
                            'colors.nombre as nombreColor',
                            'marcas.nombre as nombreMarca',
                            'tipos.nombre as nombreTipo',
                            'modos.nombre as nombreModo',
                            'ventas_productos.descipcion',
                            'servicios_preventas.descripcion',

                        )
                        ->get();

                    break;

                default:
                    $listaProductos = precios_productos::join('servicios_preventas', 'servicios_preventas.id_precio_producto', '=', 'precios_productos.id')
                        ->join('preventas', 'preventas.id', '=', 'servicios_preventas.id_preventa')
                        ->join('productos', 'productos.id', '=', 'precios_productos.id_producto')
                        ->join('marcas', 'marcas.id', '=', 'productos.id_marca')
                        ->join('colors', 'colors.id', '=', 'productos.id_color')
                        ->join('tipos', 'tipos.id', '=', 'productos.id_tipo')
                        ->join('modos', 'modos.id', '=', 'productos.id_modo')
                        ->where('preventas.id', $ordenRecoleccion->idPreventa)
                        ->select(
                            'productos.nombre_comercial',
                            'servicios_preventas.precio_unitario',
                            'servicios_preventas.cantidad_total as cantidad',
                            'servicios_preventas.tipo_descuento as tipoDescuento',
                            'servicios_preventas.descuento',
                            'precios_productos.precio',
                            'colors.nombre as nombreColor',
                            'marcas.nombre as nombreMarca',
                            'tipos.nombre as nombreTipo',
                            'modos.nombre as nombreModo'
                        )
                        ->get();
                    break;
            }

        $fechaCreacion = \Carbon\Carbon::parse($ordenRecoleccion->fechaCreacion);
        $Tiempo = TiempoAproximado::whereDate('created_at', $fechaCreacion->toDateString())->orderBy('created_at', 'desc')->first();


        return view('correo.envioExitoso', compact('error', 'ordenRecoleccion', 'listaProductos', 'Tiempo'));
    }
}
