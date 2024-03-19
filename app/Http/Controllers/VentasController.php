<?php

namespace App\Http\Controllers;

use App\Models\Catalago_recepcion;
use App\Models\Orden_recoleccion;
use App\Models\precios_productos;
use App\Models\Preventa;
use App\Models\ventas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Termwind\Components\Raw;

class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $busqueda = $request->query('adminlteSearch');
        $filtroES = intval($request->query('entrega_servicio'));
        $filtroFecha_inicio = $request->query('fecha_inicio');
        $fecha_fin = $request->query('fecha_fin');

        $datosVentas = ventas::join('orden_recoleccions', 'orden_recoleccions.id', '=', 'ventas.id_recoleccion')
            ->join('preventas', 'preventas.id', '=', 'orden_recoleccions.id_preventa')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('empleados', 'empleados.id', '=', 'preventas.id_empleado')
            ->join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('personas as empleadoPersona', 'empleadoPersona.id', '=', 'empleados.id_persona')
            ->join('personas as clientePersona', 'clientePersona.id', '=', 'clientes.id_persona')
            ->join('roles', 'roles.id', '=', 'empleados.id_rol')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->where(function ($query) use ($busqueda) {
                $query->where('clientePersona.telefono', 'LIKE', "%{$busqueda}%")
                    ->orWhere('clientePersona.nombre', 'LIKE', "%{$busqueda}%")
                    ->orWhere('clientePersona.apellido', 'LIKE', "%{$busqueda}%")
                    ->orWhere('catalago_ubicaciones.localidad', 'LIKE', "%{$busqueda}%")
                    ->orWhere('catalago_ubicaciones.localidad', 'LIKE', "%{$busqueda}%");
            });
        if ($filtroES) {

            $datosVentas->where('preventas.estatus', $filtroES);
        }

        if ($filtroFecha_inicio && $fecha_fin) {
            $datosVentas->whereBetween('ventas.created_at', [$filtroFecha_inicio, $fecha_fin]);
        }
        $datosVentas = $datosVentas->select(
            'ventas.id as idVenta',
            'ventas.created_at as fechaVenta',
            'orden_recoleccions.id as idRecoleccion',
            'preventas.costo_servicio',
            'preventas.id as idPreventa',
            'preventas.estatus as estatusPreventa',
            'preventas.pago_efectivo',
            'orden_recoleccions.id as idOrden_recoleccions',
            'orden_recoleccions.Fecha_recoleccion as fechaRecoleccion',
            'orden_recoleccions.Fecha_entrega as fechaEntrega',
            'orden_recoleccions.created_at',
            'orden_recoleccions.id as id_recoleccion',
            'orden_recoleccions.estatus as estatusRecoleccion', //5 pendiente 4 por recolectar, 3 revision 2 entrega 1 listo 0 eliminado
            'empleadoPersona.nombre as nombreEmpleado',
            'empleadoPersona.apellido as apellidoEmpleado',
            'empleadoPersona.telefono as telefonoEmpleado',
            'clientePersona.nombre as nombreCliente',
            'clientePersona.apellido as apellidoCliente',
            'clientePersona.telefono as telefonoCliente',
            'clientePersona.email as emailCliente',
            'clientes.comentario as rfc',
            'catalago_ubicaciones.localidad as colonia',
            'roles.nombre as nombre_rol',
            'direcciones.calle',
            'direcciones.num_exterior',
            'direcciones.num_interior',
            'direcciones.referencia',
        )
            ->orderBy('ventas.updated_at', 'desc')
            ->paginate(5); // Mueve paginate() aquí para que funcione correctamente

        $datosVentas->getCollection()->transform(function ($venta) {
            $venta->productos = precios_productos::join('ventas_productos', 'ventas_productos.id_precio_producto', '=', 'precios_productos.id')
                ->join('preventas', 'preventas.id', '=', 'ventas_productos.id_preventa')
                ->join('productos', 'productos.id', '=', 'precios_productos.id_producto')
                ->where('preventas.id', $venta->idPreventa)
                ->select('productos.nombre_comercial', 'precios_productos.precio', 'ventas_productos.cantidad')
                ->get();
            return $venta;
        });



        return view('ventas.index', compact('datosVentas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(ventas $venta)
    {

        $datosEnvio = Orden_recoleccion::join('preventas', 'preventas.id', '=', 'orden_recoleccions.id_preventa')
            ->join('empleados', 'empleados.id', '=', 'preventas.id_empleado')
            ->join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('personas as empleadoPersona', 'empleadoPersona.id', '=', 'empleados.id_persona')
            ->join('personas as clientePersona', 'clientePersona.id', '=', 'clientes.id_persona')
            ->join('roles', 'roles.id', '=', 'empleados.id_rol')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->whereIn('preventas.estatus', [3, 4]) //3 entrega, 4 servicios, 2 inconcluso, 0 eliminado
            ->where('orden_recoleccions.id', $venta->id_recoleccion)
            ->select(
                'orden_recoleccions.id as idRecoleccion',
                'preventas.id as idPreventa',
                'preventas.estatus as estatusPreventa',
                'preventas.costo_servicio',
                'preventas.metodo_pago as metodoPago',
                'preventas.factura',
                'preventas.pago_efectivo as pagoEfectivo',
                'orden_recoleccions.id as idOrden_recoleccions',
                'orden_recoleccions.Fecha_recoleccion as fechaRecoleccion',
                'orden_recoleccions.Fecha_entrega as fechaEntrega',
                'orden_recoleccions.created_at',
                'orden_recoleccions.id as id_recoleccion',
                'orden_recoleccions.estatus as estatusRecoleccion', //5 pendiente 4 por recolectar, 3 revision 2 entrega 1 listo 0 eliminado
                'empleadoPersona.nombre as nombreEmpleado',
                'empleadoPersona.apellido as apellidoEmpleado',
                'empleadoPersona.telefono as telefonoEmpleado',
                'clientePersona.nombre as nombreCliente',
                'clientePersona.apellido as apellidoCliente',
                'clientePersona.telefono as telefonoCliente',
                'clientePersona.email as emailCliente',
                'clientes.comentario as rfc',
                'catalago_ubicaciones.localidad as colonia',
                'roles.nombre as nombre_rol',
                'direcciones.calle',
                'direcciones.num_exterior',
                'direcciones.num_interior',
                'direcciones.referencia',
            )
            ->first();

        $productos = Catalago_recepcion::join('productos', 'productos.id', '=', 'catalago_recepcions.id_producto')
            ->join('servicios_preventas', 'servicios_preventas.id_producto_recepcion', '=', 'catalago_recepcions.id')
            ->join('preventas', 'preventas.id', '=', 'servicios_preventas.id_preventa')
            ->leftJoin('marcas', 'marcas.id', '=', 'productos.id_marca')
            ->leftJoin('tipos', 'tipos.id', '=', 'productos.id_tipo')
            ->leftJoin('colors', 'colors.id', '=', 'productos.id_color')
            ->leftJoin('modos', 'modos.id', '=', 'productos.id_modo')
            ->where('preventas.id', $datosEnvio->idPreventa)
            ->where('servicios_preventas.estatus', 2)
            ->select('productos.nombre_comercial', 'productos.descripcion', 'servicios_preventas.cantidad_total', 'marcas.nombre as marca', 'tipos.nombre as tipo', 'colors.nombre as color')
            ->get();

        $listaProductos = precios_productos::join('ventas_productos', 'ventas_productos.id_precio_producto', '=', 'precios_productos.id')
            ->join('preventas', 'preventas.id', '=', 'ventas_productos.id_preventa')
            ->join('productos', 'productos.id', '=', 'precios_productos.id_producto')
            ->where('preventas.id', $datosEnvio->idPreventa)
            ->select(
                'productos.nombre_comercial',
                'precios_productos.precio',
                'ventas_productos.cantidad',
            )
            ->get();

        $pdf = PDF::loadView('ventas.pdf', compact(
            'datosEnvio',
            'productos',
            'listaProductos'
        ));

        // Establece el tamaño del papel a 80mm de ancho y 200mm de largo
        $pdf->setPaper([0, 0, 226.77, 699.93], 'portrait'); // 80mm x 200mm en puntos

        // Renderiza el documento PDF y lo envía al navegador
        return $pdf->stream();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ventas $ventas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ventas $ventas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ventas $ventas)
    {
        //
    }
}
