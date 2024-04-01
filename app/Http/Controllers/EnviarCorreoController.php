<?php

namespace App\Http\Controllers;

use App\Mail\correoMailable;
use App\Models\Catalago_ubicaciones;
use App\Models\Orden_recoleccion;
use App\Models\precios_productos;
use App\Models\TiempoAproximado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EnviarCorreoController extends Controller
{
    public function enviarCorreos($id)
    {
        // Enviar correo electrónico
        try {

            $ordenRecoleccion = Orden_recoleccion::join('preventas', 'preventas.id', '=', 'orden_recoleccions.id_preventa')
                ->join('folios', 'folios.id', '=', 'orden_recoleccions.id_folio')
                ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
                ->join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
                ->join('empleados', 'empleados.id', '=', 'preventas.id_empleado')
                ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
                ->join('personas as personaClientes', 'personaClientes.id', '=', 'clientes.id_persona')
                ->join('personas as personaEmpleado', 'personaEmpleado.id', '=', 'empleados.id_persona')
                ->join('roles', 'roles.id', '=', 'empleados.id_rol')
                ->where('orden_recoleccions.id',  $id)
                ->select(
                    'orden_recoleccions.id as idRecoleccion',
                    'orden_recoleccions.created_at as fechaCreacion',
                    'folios.letra_actual as letraActual',
                    'folios.ultimo_valor as ultimoValor',
                    'preventas.metodo_pago as metodoPago',
                    'preventas.id as idPreventa',
                    'preventas.factura',
                    'preventas.pago_efectivo as pagoEfectivo',
                    'preventas.nombre_atencion as nombreAtencion',
                    'preventas.horario_trabajo_inicio as horarioTrabajoInicio',
                    'preventas.horario_trabajo_final as horarioTrabajoFinal',
                    'preventas.dia_semana as diaSemana',
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
                    'personaEmpleado.nombre as nombreEmpleado',
                    'personaEmpleado.apellido as apellidoEmpleado',
                    'personaEmpleado.telefono as telefonoEmpleado',
                    'roles.nombre as nombreRol',
                )
                ->first();


            $listaProductos = precios_productos::join('ventas_productos', 'ventas_productos.id_precio_producto', '=', 'precios_productos.id')
                ->join('preventas', 'preventas.id', '=', 'ventas_productos.id_preventa')
                ->join('productos', 'productos.id', '=', 'precios_productos.id_producto')
                ->join('marcas', 'marcas.id', '=', 'productos.id_marca')
                ->join('colors', 'colors.id', '=', 'productos.id_color')
                ->join('tipos', 'tipos.id', '=', 'productos.id_tipo')
                ->join('modos', 'modos.id', '=', 'productos.id_modo')
                ->where('preventas.id', $ordenRecoleccion->idPreventa)
                ->select('productos.nombre_comercial', 'precios_productos.precio', 'ventas_productos.cantidad', 'colors.nombre as nombreColor', 'marcas.nombre as nombreMarca', 'tipos.nombre as nombreTipo', 'modos.nombre as nombreModo')
                ->get();

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

        $ordenRecoleccion = Orden_recoleccion::join('preventas', 'preventas.id', '=', 'orden_recoleccions.id_preventa')
            ->join('folios', 'folios.id', '=', 'orden_recoleccions.id_folio')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('empleados', 'empleados.id', '=', 'preventas.id_empleado')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->join('personas as personaClientes', 'personaClientes.id', '=', 'clientes.id_persona')
            ->join('personas as personaEmpleado', 'personaEmpleado.id', '=', 'empleados.id_persona')
            ->join('roles', 'roles.id', '=', 'empleados.id_rol')
            ->where('orden_recoleccions.id',  $id)
            ->select(
                'orden_recoleccions.id as idRecoleccion',
                'orden_recoleccions.created_at as fechaCreacion',
                'folios.letra_actual as letraActual',
                'folios.ultimo_valor as ultimoValor',
                'preventas.metodo_pago as metodoPago',
                'preventas.id as idPreventa',
                'preventas.factura',
                'preventas.pago_efectivo as pagoEfectivo',
                'preventas.nombre_atencion as nombreAtencion',
                'preventas.horario_trabajo_inicio as horarioTrabajoInicio',
                'preventas.horario_trabajo_final as horarioTrabajoFinal',
                'preventas.dia_semana as diaSemana',
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
                'personaEmpleado.nombre as nombreEmpleado',
                'personaEmpleado.apellido as apellidoEmpleado',
                'personaEmpleado.telefono as telefonoEmpleado',
                'roles.nombre as nombreRol',
            )
            ->first();


        $listaProductos = precios_productos::join('ventas_productos', 'ventas_productos.id_precio_producto', '=', 'precios_productos.id')
            ->join('preventas', 'preventas.id', '=', 'ventas_productos.id_preventa')
            ->join('productos', 'productos.id', '=', 'precios_productos.id_producto')
            ->join('marcas', 'marcas.id', '=', 'productos.id_marca')
            ->join('colors', 'colors.id', '=', 'productos.id_color')
            ->join('tipos', 'tipos.id', '=', 'productos.id_tipo')
            ->join('modos', 'modos.id', '=', 'productos.id_modo')
            ->where('preventas.id', $ordenRecoleccion->idPreventa)
            ->select('productos.nombre_comercial', 'precios_productos.precio', 'ventas_productos.cantidad', 'colors.nombre as nombreColor', 'marcas.nombre as nombreMarca', 'tipos.nombre as nombreTipo', 'modos.nombre as nombreModo')
            ->get();

        $fechaCreacion = \Carbon\Carbon::parse($ordenRecoleccion->fechaCreacion);
        $Tiempo = TiempoAproximado::whereDate('created_at', $fechaCreacion->toDateString())->orderBy('created_at', 'desc')->first();


        return view('correo.envioExitoso', compact('error', 'ordenRecoleccion', 'listaProductos', 'Tiempo'));
    }
}
