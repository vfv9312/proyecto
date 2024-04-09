<?php

namespace App\Http\Controllers;

use App\Models\Catalago_recepcion;
use App\Models\Orden_recoleccion;
use App\Models\precios_productos;
use App\Models\Preventa;
use App\Models\TiempoAproximado;
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
            ->join('folios', 'folios.id', '=', 'orden_recoleccions.id_folio')
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
            'preventas.nombre_quien_recibe as recibe',
            'folios.letra_actual as letraActual',
            'folios.ultimo_valor as ultimoValor',
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
        $ordenRecoleccion = Orden_recoleccion::join('preventas', 'preventas.id', '=', 'orden_recoleccions.id_preventa')
            ->join('ventas', 'ventas.id_recoleccion', '=', 'orden_recoleccions.id')
            ->join('folios', 'folios.id', '=', 'orden_recoleccions.id_folio')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('empleados', 'empleados.id', '=', 'preventas.id_empleado')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->join('personas as personaClientes', 'personaClientes.id', '=', 'clientes.id_persona')
            ->join('personas as personaEmpleado', 'personaEmpleado.id', '=', 'empleados.id_persona')
            ->join('roles', 'roles.id', '=', 'empleados.id_rol')
            ->where('orden_recoleccions.id', $venta->id_recoleccion)
            ->select(
                'ventas.created_at as fechaVenta',
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
                'preventas.nombre_quien_recibe as recibe',
                'preventas.estatus as estatusPreventa',
                'preventas.comentario',
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

        if ($ordenRecoleccion->estatusPreventa == 4) { //3 entrega y 4 servicios
            $listaProductos = Catalago_recepcion::join('productos', 'productos.id', '=', 'catalago_recepcions.id_producto')
                ->join('servicios_preventas', 'servicios_preventas.id_producto_recepcion', '=', 'catalago_recepcions.id')
                ->join('preventas', 'preventas.id', '=', 'servicios_preventas.id_preventa')
                ->leftJoin('marcas', 'marcas.id', '=', 'productos.id_marca')
                ->leftJoin('tipos', 'tipos.id', '=', 'productos.id_tipo')
                ->leftJoin('colors', 'colors.id', '=', 'productos.id_color')
                ->leftJoin('modos', 'modos.id', '=', 'productos.id_modo')
                ->where('preventas.id', $ordenRecoleccion->idPreventa)
                ->where('servicios_preventas.estatus', 2)
                ->select('productos.nombre_comercial', 'servicios_preventas.precio_unitario as precio', 'productos.descripcion', 'servicios_preventas.cantidad_total as cantidad', 'marcas.nombre as nombreMarca', 'tipos.nombre as nombreTipo', 'colors.nombre as nombreColor', 'modos.nombre as nombreModo')
                ->get();
        } else {

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
        }

        $fechaCreacion = \Carbon\Carbon::parse($ordenRecoleccion->fechaCreacion);

        $Tiempo = TiempoAproximado::whereDate('created_at', $fechaCreacion->toDateString())->orderBy('created_at', 'desc')->first();

        $largoDelTicket = 700; // Inicializa la variable


        if ($listaProductos->count() > 1) {
            $extra = max(0, $listaProductos->count() - 1);
            $largoDelTicket += $extra * 50;
        }

        $pdf = PDF::loadView('ventas.pdf', compact(
            'ordenRecoleccion',
            'listaProductos',
            'Tiempo'
        ));

        // Establece el tamaño del papel a 80mm de ancho y 200mm de largo
        $pdf->setPaper([0, 0, 226.77, $largoDelTicket], 'portrait'); // 80mm x 200mm en puntos

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
