<?php

namespace App\Http\Controllers;

use App\Models\Cancelaciones;
use App\Models\Catalago_recepcion;
use App\Models\clientes;
use App\Models\Orden_recoleccion;
use App\Models\precios_productos;
use App\Models\productos;
use App\Models\Preventa;
use App\Models\Servicios_preventas;
use App\Models\TiempoAproximado;
use App\Models\Metodo_pago;
use App\Models\Descuentos;
use App\Models\ventas_productos;
use App\Models\Info_tickets;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenRecoleccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $busqueda = $request->query('adminlteSearch');
        $filtroES = $request->query('entrega_servicio');
        $filtroFecha_inicio = $request->query('fecha_inicio');
        $fecha_fin = $request->query('fecha_fin');
        $filtroEstatus = $request->query('estatus');
        $palabras = explode(' ', $busqueda); // Divide la cadena de búsqueda en palabras
        $datosEntregaCompromisos[] = [
            'fecha' => null,
            'hora' => null,
            'horaEntregaCompromiso' => null,
        ];

        $preventas = Preventa::join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('personas', 'personas.id', '=', 'clientes.id_persona')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->leftJoin('orden_recoleccions', function ($join) {
                $join->on('orden_recoleccions.id_preventa', '=', 'preventas.id')
                    ->orOn('orden_recoleccions.id_preventaServicio', '=', 'preventas.id')
                    ->orOn('orden_recoleccions.id_preventaOrdenServicio', '=', 'preventas.id');
            })
            ->leftjoin('folios', 'folios.id', '=', 'orden_recoleccions.id_folio')
            ->leftjoin('folios as folio_r', 'folio_r.id', '=', 'orden_recoleccions.id_folio_recoleccion')
            ->leftjoin('folios_servicios', 'folios_servicios.id', '=', 'orden_recoleccions.id_folio_servicio')
            ->whereIn('preventas.tipo_de_venta', ['Entrega', 'Servicio','Orden Servicio']) //whereIn para filtrar las preventas
            ->WhereIn('preventas.estado', ['Recolectar', 'Revision', 'Entrega', 'Listo', 'Revisar'])
            ->WhereNull('preventas.deleted_at')
            ->where(function ($query) use ($palabras) {
                foreach ($palabras as $palabra) {
                    $query->where(function ($query) use ($palabra) {
                        $query->where('personas.telefono', 'LIKE', "%{$palabra}%")
                            ->orWhere('personas.nombre', 'LIKE', "%{$palabra}%")
                            ->orWhere('personas.apellido', 'LIKE', "%{$palabra}%")
                            ->orWhere('catalago_ubicaciones.localidad', 'LIKE', "%{$palabra}%")
                            ->orWhere('catalago_ubicaciones.localidad', 'LIKE', "%{$palabra}%");
                    });
                }
            });

        // Búsqueda por número de folio
        if (preg_match('/^[A-Z]\d+$/', $busqueda)) {
            $letra = substr($busqueda, 0, 1);
            $numero = (int) substr($busqueda, 1);

            $preventas->orWhere(function ($query) use ($letra, $numero) {
                $query->where('folios.letra_actual', $letra)
                    ->where('folios.ultimo_valor', $numero);
            });
        }
        if (preg_match('/^[A-Z]\d+$/', $busqueda)) {
            $letra = substr($busqueda, 0, 1);
            $numero = (int) substr($busqueda, 1);

            $preventas->orWhere(function ($query) use ($letra, $numero) {
                $query->where('folio_r.letra_actual', $letra)
                    ->where('folio_r.ultimo_valor', $numero);
            });
        }
        if (ctype_digit($busqueda)) {

            $numero = (int) $busqueda;

            $preventas->orWhere(function ($query) use ($numero) {
                $query->where('folios_servicios.ultimo_valor', $numero);
            });
        }

        if ($filtroES) { //E : Entrega , S: Servicio
            $preventas->where('preventas.tipo_de_venta', $filtroES);
        }

        if ($filtroFecha_inicio && $fecha_fin) {

            $Inicio = Carbon::createFromFormat('Y-m-d', $filtroFecha_inicio)->startOfDay();
            $Fin = Carbon::createFromFormat('Y-m-d', $fecha_fin)->endOfDay();

            $preventas->whereBetween('orden_recoleccions.created_at', [$Inicio, $Fin]);
        }


        if ($filtroEstatus) {

            $preventas->where('preventas.estado', $filtroEstatus);
        }
        $preventas = $preventas->select(
            'orden_recoleccions.id as idRecoleccion',
            'orden_recoleccions.created_at as fechaCreacion',
            'orden_recoleccions.created_at',
            'folios.letra_actual as letraActual',
            'folios.ultimo_valor as ultimoValor',
            'folios_servicios.ultimo_valor as ultimoValorServicio',
            'folio_r.letra_actual as letraActual_r',
            'folio_r.ultimo_valor as ultimoValor_r',
            'preventas.id as idPreventa',
            'preventas.estado as estatusPreventa',
            'preventas.tipo_de_venta as tipoVenta',
            'preventas.id_cancelacion',
            'preventas.nombre_empleado as nombreEmpleado',
            'personas.nombre as nombreCliente',
            'personas.apellido as apellidoCliente',
            'personas.telefono',
            'personas.email as correo',
            'clientes.comentario as rfc',
            'catalago_ubicaciones.localidad as colonia',
            'direcciones.calle',
            'direcciones.num_exterior',
            'direcciones.num_interior',
            'direcciones.referencia',
        )
            ->orderBy('orden_recoleccions.updated_at', 'desc')

            ->paginate(100)->appends(['adminlteSearch' => $busqueda, 'entrega_servicio' => $filtroES, 'fecha_inicio' => $filtroFecha_inicio, 'fecha_fin' => $fecha_fin, 'estatus' => $filtroEstatus]); // Mueve paginate() aquí para que funcione correctamente


        foreach ($preventas as $preventa) {
            $fechaCreacion = \Carbon\Carbon::parse($preventa->fechaCreacion);
            $Tiempo = TiempoAproximado::whereDate('created_at', $fechaCreacion->toDateString())->orderBy('created_at', 'desc')->first();
            $segundoTiempo = TiempoAproximado::whereDate('created_at', $fechaCreacion->toDateString())->orderBy('created_at', 'desc')->skip(1)->first();

            if ($Tiempo) {
                $fechaHoraArray = explode(' ', $preventa->fechaCreacion);
                $fecha = $fechaHoraArray[0];
                $hora = $fechaHoraArray[1];
                // Crear un objeto DateTime con la hora inicial
                $horaInicial = new DateTime($hora);


                // Sumar el intervalo de tiempo a la hora inicial
                list($horas, $minutos, $segundos) = explode(':', $Tiempo->tiempo);
                $intervalo = new DateInterval(sprintf('PT%dH%dM%dS', $horas, $minutos, $segundos));
                $horaEntregaCompromiso = $horaInicial->add($intervalo);
                // Aquí puedes hacer lo que necesites con $horaEntregaCompromiso
                // Aquí puedes hacer lo que necesites con $horaEntregaCompromiso
                $datosEntregaCompromisos[] = [
                    'fecha' => $fecha,
                    'hora' => $hora,
                    'horaEntregaCompromiso' => $horaEntregaCompromiso->format('H:i:s'),
                ];
            } else {
                $datosEntregaCompromisos[] = [
                    'fecha' => null,
                    'hora' => null,
                    'horaEntregaCompromiso' => null,
                ];
            }
        }

        return view('Principal.ordenRecoleccion.recolecciones', compact('preventas', 'datosEntregaCompromisos', 'busqueda', 'filtroES', 'filtroFecha_inicio', 'fecha_fin', 'filtroEstatus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id_preventa = $request->input('id_recoleccion');
        /* $datosEnvio = Orden_recoleccion::all();
        return $datosEnvio[0]->preventas; */

        $ordenRecoleccion = Preventa::leftJoin('orden_recoleccions', function ($join) {
            $join->on('orden_recoleccions.id_preventa', '=', 'preventas.id')
                ->orOn('orden_recoleccions.id_preventaServicio', '=', 'preventas.id')
                ->orOn('orden_recoleccions.id_preventaOrdenServicio', '=', 'preventas.id');
        })
            ->leftjoin('folios', 'folios.id', '=', 'orden_recoleccions.id_folio')
            ->leftjoin('folios as folio_r', 'folio_r.id', '=', 'orden_recoleccions.id_folio_recoleccion')
            ->leftjoin('folios_servicios', 'folios_servicios.id', '=', 'orden_recoleccions.id_folio_servicio')
            ->join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('personas as clientePersona', 'clientePersona.id', '=', 'clientes.id_persona')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->leftJoin('ventas', 'ventas.id_recoleccion', '=', 'orden_recoleccions.id')
            ->whereIn('preventas.tipo_de_venta', ['Servicio', 'Entrega','Orden Servicio'])
            ->where('preventas.id', $id_preventa)
            ->select(
                'orden_recoleccions.id as idRecoleccion',
                'preventas.id as idPreventa',
                'preventas.nombre_empleado as nombreEmpleado',
                'preventas.nombre_atencion as nombreAtencion',
                'preventas.nombre_quien_recibe as nombreRecibe',
                'preventas.metodo_pago',
                'preventas.pago_efectivo',
                'preventas.tipo_de_venta as tipoVenta',
                'preventas.estado',
                'orden_recoleccions.id as idOrden_recoleccions',
                'orden_recoleccions.Fecha_recoleccion as fechaRecoleccion',
                'orden_recoleccions.id_cancelacion',
                'ventas.created_at as fechaEntrega',
                'orden_recoleccions.created_at',
                'orden_recoleccions.id as id_recoleccion',
                'orden_recoleccions.estatus as estatusRecoleccion', //5 pendiente 4 por recolectar, 3 revision 2 entrega 1 listo
                'clientePersona.nombre as nombreCliente',
                'clientePersona.apellido as apellidoCliente',
                'clientePersona.telefono as telefonoCliente',
                'clientePersona.email as emailCliente',
                'clientes.comentario as rfc',
                'catalago_ubicaciones.localidad as colonia',
                'direcciones.calle',
                'direcciones.num_exterior',
                'direcciones.num_interior',
                'direcciones.referencia',
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
                        ->whereIn('ventas_productos.estatus', [3])
                        ->where('preventas.id', $ordenRecoleccion->idPreventa)
                        ->select(
                            'productos.nombre_comercial',
                            'precios_productos.precio',
                            'ventas_productos.cantidad',
                            'ventas_productos.descuento',
                            'ventas_productos.tipo_descuento as tipoDescuento',
                            'colors.nombre as nombreColor',
                            'marcas.nombre as nombreMarca',
                            'tipos.nombre as nombreTipo',
                            'modos.nombre as nombreModo',
                            'precios_productos.id',

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
                            'ventas_productos.descuento',
                            'ventas_productos.descipcion',
                            'servicios_preventas.tipo_descuento as tipoDescuento',
                            'servicios_preventas.descuento',
                            'precios_productos.precio',
                            'colors.nombre as nombreColor',
                            'marcas.nombre as nombreMarca',
                            'tipos.nombre as nombreTipo',
                            'modos.nombre as nombreModo',
                            'servicios_preventas.descripcion',
                            'precios_productos.id',

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
                            'modos.nombre as nombreModo',
                            'precios_productos.id'
                        )
                        ->get();
                    break;
            }

        $metodosDePagos = Metodo_pago::where('estatus','Activo')->get();
        $descuentos = Descuentos::select('*')->orderBy('nombre', 'asc')->get();

        return view('Principal.ordenRecoleccion.edit', compact('listaProductos', 'ordenRecoleccion','metodosDePagos','descuentos'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Orden_recoleccion $orden_recoleccion)
    {
        // $preventa = Preventa::find($orden_recoleccion->id_preventa);
        $datosEnvio = Orden_recoleccion::join('preventas', 'preventas.id', '=', 'orden_recoleccions.id_preventa')
            ->join('empleados', 'empleados.id', '=', 'preventas.id_empleado')
            ->join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('personas as empleadoPersona', 'empleadoPersona.id', '=', 'empleados.id_persona')
            ->join('personas as clientePersona', 'clientePersona.id', '=', 'clientes.id_persona')
            ->join('roles', 'roles.id', '=', 'empleados.id_rol')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->whereIn('preventas.estatus', [3, 4]) //3 entrega, 4 servicios, 2 inconcluso, 0 eliminado
            ->where('orden_recoleccions.id', $orden_recoleccion->id)
            ->select(
                'orden_recoleccions.id as idRecoleccion',
                'preventas.id as idPreventa',
                'preventas.estatus as estatusPreventa',
                'preventas.costo_servicio',
                'preventas.metodo_pago',
                'preventas.pago_efectivo',
                'orden_recoleccions.id as idOrden_recoleccions',
                'orden_recoleccions.Fecha_recoleccion as fechaRecoleccion',
                'orden_recoleccions.Fecha_entrega as fechaEntrega',
                'orden_recoleccions.created_at',
                'orden_recoleccions.id as id_recoleccion',
                'orden_recoleccions.estatus as estatusRecoleccion', //5 pendiente 4 por recolectar, 3 revision 2 entrega 1 listo 0 eliminado
                'orden_recoleccions.created_at',
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

        $listaProductos = precios_productos::join('ventas_productos', 'ventas_productos.id_precio_producto', '=', 'precios_productos.id')
            ->join('preventas', 'preventas.id', '=', 'ventas_productos.id_preventa')
            ->join('productos', 'productos.id', '=', 'precios_productos.id_producto')
            ->where('preventas.id', $datosEnvio->idPreventa)
            ->select('productos.nombre_comercial', 'precios_productos.precio', 'ventas_productos.cantidad')
            ->get();


        if ($datosEnvio->estatusRecoleccion == 4 || $datosEnvio->estatusRecoleccion == 3) { //4 por recolectar, 3 revision
            return redirect()->route('generarpdf.ordenservicio', ['id' => $orden_recoleccion->id]);
        } else if ($datosEnvio->estatusRecoleccion == 2  && $datosEnvio->estatusPreventa == 4) { // si ya es estatus 2 = entrega  y fue una orden de 4 servicios

            return redirect()->route('generarpdf2.ordenentrega', ['id' => $orden_recoleccion->id, 'listaProductos' => $listaProductos]);
        } else if ($datosEnvio->estatusRecoleccion == 2) { //si ya es estatus 2 = entrega y no fue una orden de 4 servicio quiere decir que es una orden de 3 entrega
            return redirect()->route('generarpdf.ordenentrega', ['id' => $orden_recoleccion->id, 'listaProductos' => $listaProductos]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Preventa $orden_recoleccion, Request $request)
    {

        $costo_unitario = $request->input('costo_unitario');
        $cantidad = $request->input('cantidad');
        $pagaCon = $request->input('txtpagoEfectivo');
        $codigo = $request->input('codigo');
        $observacionesInicial =$request->input('observacionesInicial');
        $nRecarga = $request->input('numero_recarga');
        $observaciones = $request->input('observacionesDetalle');
        $EntregaRecolecta = $request->input('entrego');
        $recibe = $request->input('recibe');
        $horaEntrega = $request->input('HoraFechaEntregado');
        $HoraFechaRecoleccion = $request->input('HoraFechaRecoleccion');
        $inputProductosSeleccionados= $request->input('inputProductosSeleccionados');
        $comentario = $request->input('observaciones');
        // Recuperar el ID de la orden de recolección
        $preventa = $orden_recoleccion;
        $estatus = $request->miSelect;
        $ordenRecoleccion = Orden_recoleccion::leftJoin('preventas', function ($join) {
            $join->on('orden_recoleccions.id_preventa', '=', 'preventas.id')
                ->orOn('orden_recoleccions.id_preventaServicio', '=', 'preventas.id');
        })->where('preventas.id', $preventa->id)
        ->select('orden_recoleccions.Fecha_recoleccion','orden_recoleccions.id_preventaServicio','orden_recoleccions.estatus')
            ->first();

        $serviciosPreventas = Servicios_preventas::join('precios_productos', 'precios_productos.id', '=', 'servicios_preventas.id_precio_producto')
            ->where('servicios_preventas.id_preventa', $preventa->id)->select('precios_productos.id as idPrecio',
            'servicios_preventas.id as id_preventaServicio',
            'servicios_preventas.tipo_descuento',
            'servicios_preventas.precio_unitario',
            'servicios_preventas.cantidad_total')->get();

            $listaProductos = precios_productos::join('ventas_productos', 'ventas_productos.id_precio_producto', '=', 'precios_productos.id')
            ->join('preventas', 'preventas.id', '=', 'ventas_productos.id_preventa')
            ->join('productos', 'productos.id', '=', 'precios_productos.id_producto')
            ->join('marcas', 'marcas.id', '=', 'productos.id_marca')
            ->join('colors', 'colors.id', '=', 'productos.id_color')
            ->join('tipos', 'tipos.id', '=', 'productos.id_tipo')
            ->join('modos', 'modos.id', '=', 'productos.id_modo')
            ->where('preventas.id', $preventa->id)
            ->select(
                'productos.nombre_comercial',
                'precios_productos.precio',
                'ventas_productos.cantidad',
                'ventas_productos.descuento',
                'ventas_productos.id_preventa',
                'ventas_productos.id as id_ventaproducto',
                'ventas_productos.tipo_descuento as tipoDescuento',
                'colors.nombre as nombreColor',
                'marcas.nombre as nombreMarca',
                'tipos.nombre as nombreTipo',
                'modos.nombre as nombreModo',
                'precios_productos.id',


            )
            ->get();

            $cliente = Clientes::find($preventa->id_cliente);

        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.

        try {
            //5 pendiente 4 por recolectar, 3 revision 2 entrega 1 listo 0 eliminado
            switch ($estatus) {
                case 'Listo':
                    $ordenRecoleccion->update([
                        'estatus' => 1,
                    ]);
                    //actualizamos estatus
                    $preventa->update([
                        'Fecha_entrega' => $horaEntrega,
                        'estado' => $estatus,
                        'comentario' => $comentario,
                        'nombre_quien_recibe' => strtoupper($recibe),
                        // Agrega aquí cualquier otro campo que desees actualizar
                    ]);
                    break;
                case 'Entrega':
                    $ordenRecoleccion->update([
                        'estatus' => 2,
                    ]);
                    $preventa->update([
                        'Fecha_entrega' => now(),
                        'estado' => $estatus,
                        // Agrega aquí cualquier otro campo que desees actualizar
                    ]);

                    if ($preventa->tipo_de_venta === 'Servicio') {

                        $preventa->update([
                            'metodo_pago' => $request->input('txtmetodoPago'),
                            'factura' => $request->input('txtfactura') == 'on' ? 1 : 0,
                            'costo_servicio' => $request->input('costo_total'),
                            'pago_efectivo' => $pagaCon
                        ]);


                        if ($request->input('txtfactura') == 'on') {
                            $cliente->update([
                                'comentario' => $request->input('txtrfc'),
                            ]);
                        }

                        foreach ($serviciosPreventas as $index => $servicioPreventa) {
                             // Obtén el costo unitario correspondiente a este servicio preventa
                            $Precio = $this->buscarPrecioRecoleccion($servicioPreventa->idPrecio);
                            $ActualizarserviciosPreventas = Servicios_preventas::where('id', $servicioPreventa->id_preventaServicio)->where('estatus',1)->first();

                            if(isset($costo_unitario[$servicioPreventa->idPrecio])){


                            $Precio->update([
                                'id_producto' => $Precio->id_producto,
                                'precio' => $costo_unitario[$servicioPreventa->idPrecio],
                                'estatus' => 2,
                            ]);


                            // Actualiza el servicio preventa con el nuevo costo unitario
                            $ActualizarserviciosPreventas->update(['precio_unitario' => $costo_unitario[$servicioPreventa->idPrecio],
                            'tipo_descuento' => 'Sin descuento',
                            'cantidad_total' => $cantidad[$servicioPreventa->idPrecio],
                            ]);
                            }
                            else{
                                $ActualizarserviciosPreventas->update(['estatus' => 0,
                                ]);
                            }
                        }

                    }
                    else {

                        $preventa->update([
                            'metodo_pago' => $request->input('txtmetodoPago'),
                            'factura' => $request->input('txtfactura') == 'on' ? 1 : 0,
                            'costo_servicio' => $request->input('costo_total'),
                            'pago_efectivo' => $pagaCon
                        ]);

                        if ($request->input('txtfactura') == 'on') {
                            $cliente->update([
                                'comentario' => $request->input('txtrfc'),
                            ]);
                        }

                        foreach($listaProductos as $productos){

                            $Precio = $this->buscarPrecioRecoleccion($productos->id);

                            $ActualizarentregaPreventas = ventas_productos::where('id', $productos->id_ventaproducto)->where('estatus',3)->first();

                            if(isset($costo_unitario[$productos->id])){
                                if($Precio->precio != $costo_unitario[$productos->id]){

                             // Actualiza el precio con el nuevo costo unitario
                             $Precio->update(['estatus'=> 0]);

                             $NuevoPrecio = precios_productos::create([
                                'id_producto' => $Precio->id_producto,
                                'precio' => $costo_unitario[$productos->id],
                                'alternativo_uno' =>$Precio->alternativo_uno,
                                'alternativo_dos' =>$Precio->alternativo_dos,
                                'alternativo_tres'=>$Precio->alternativo_tres,
                            ]);

                            $ActualizarentregaPreventas->update(['id_precio_producto'=> $NuevoPrecio->id]);

                                }
                                else{
                            $Precio->update(['precio' => $costo_unitario[$productos->id],
                               'cantidad' => $cantidad[$productos->id],
                            ]);
                            }

                             }
                             else{
                                 $ActualizarentregaPreventas->update(['estatus' => 0,
                                 ]);
                             }

                        }

                    }
                    break;
                case 'Revision':

                    // Decodifica el JSON
                $productos = json_decode($inputProductosSeleccionados, true);

                $precioenCero = null;
                foreach ($productos as $producto) {

                    //$Precio = precios_productos::where('id', $producto['idPrecio'])->where('estatus',2)->first();
                    $Precio = $this->buscarPrecioRecoleccion($producto['idPrecio']);

                    switch($Precio->precio){
                        case '0.00':
                            $precioenCero = $producto['idPrecio'];
                        #no haga nada por que ya es 0
                        break;
                        default:

                        $Precio->update([
                            'estatus' => 0,
                        ]);

                        $nuevoPrecio = precios_productos::create([
                            'id_producto' => $producto['id'],
                            'precio' => 0,
                            'estatus' => 2,
                        ]);

                        $precioenCero = $nuevoPrecio->id;
                        break;
                    }

                     //ya una vez identificados le agregamos el id del precio actual y cantidad
                        $servicio_venta = Servicios_preventas::firstOrCreate([
                            'id_precio_producto' => $precioenCero, //id del precio producto que esta relacionado con el producto
                            'id_preventa' => $preventa['id'], //le asignamos su nummero de preventa
                            'descuento' => 0,
                            'precio_unitario' => 0,
                            'tipo_descuento' => 'Sin descuento',
                            'cantidad' => $producto['cantidad'],  //borrar cuando cargue el migration
                            'cantidad_total' => $producto['cantidad'], //le asignamos su cantidad
                            'estatus' => 1 //le asignamos estatus 1
                        ]);

                }

                    //cambiamos el estatus de la recoleccion
                    $ordenRecoleccion->update([
                        'Fecha_recoleccion' => $HoraFechaRecoleccion,
                    ]);
                    $preventa->update([
                        'nombre_quien_entrega' => $EntregaRecolecta,
                        'codigo' => $codigo,
                        'numero_recarga' => $nRecarga,
                        'estado' => $estatus,
                    ]);
                    break;
                case 'Recolectar':
                    $preventa->update([
                        'observacion' => $observaciones,
                    ]);

                    break;

                default:
                    # code...
                    break;
            }

            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.

        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            return $th->getMessage();
            $ordenRecoleccion = false;
        }
        if ($ordenRecoleccion) {
            session()->flash("correcto", "Estatus de recoleccion correctamente actualizado");
            return redirect()->route('orden_recoleccion.index');
        } else {
            session()->flash("incorrect", "Error al actualizar");
            return redirect()->route('orden_recoleccion.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Orden_recoleccion $orden_recoleccion)
    {
        //
    }
    public function vistacancelar($id)
    {

        $id_preventa = $id;

        $datosEnvio = Preventa::leftJoin('orden_recoleccions', function ($join) {
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


            switch ($datosEnvio->tipoVenta) {
                case 'Entrega':
                    $productos = precios_productos::join('ventas_productos', 'ventas_productos.id_precio_producto', '=', 'precios_productos.id')
                        ->join('preventas', 'preventas.id', '=', 'ventas_productos.id_preventa')
                        ->join('productos', 'productos.id', '=', 'precios_productos.id_producto')
                        ->join('marcas', 'marcas.id', '=', 'productos.id_marca')
                        ->join('colors', 'colors.id', '=', 'productos.id_color')
                        ->join('tipos', 'tipos.id', '=', 'productos.id_tipo')
                        ->join('modos', 'modos.id', '=', 'productos.id_modo')
                        ->where('preventas.id', $datosEnvio->idPreventa)
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
                        $productos = precios_productos::leftjoin('servicios_preventas', 'servicios_preventas.id_precio_producto', '=', 'precios_productos.id')
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
                        ->where('preventasServicio.id', $datosEnvio->idPreventa)
                        ->orWhere('preventasProducto.id', $datosEnvio->idPreventa)
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
                    $productos = precios_productos::join('servicios_preventas', 'servicios_preventas.id_precio_producto', '=', 'precios_productos.id')
                        ->join('preventas', 'preventas.id', '=', 'servicios_preventas.id_preventa')
                        ->join('productos', 'productos.id', '=', 'precios_productos.id_producto')
                        ->join('marcas', 'marcas.id', '=', 'productos.id_marca')
                        ->join('colors', 'colors.id', '=', 'productos.id_color')
                        ->join('tipos', 'tipos.id', '=', 'productos.id_tipo')
                        ->join('modos', 'modos.id', '=', 'productos.id_modo')
                        ->where('preventas.id', $datosEnvio->idPreventa)
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


        $cancelar = Cancelaciones::where('estatus', 1)
            ->orderBy('cancelaciones.nombre', 'desc')->get();

        return view('Principal.ordenRecoleccion.cancelar', compact('productos', 'datosEnvio', 'cancelar'));
    }
    public function cancelar(Preventa $id, Request $request)
    {

    // Definir las reglas de validación
    $rules = [
        'txtcancelado' => 'required', // Asegúrate de usar la regla adecuada
        'txtcategoriaCancelacion' => 'required|string', // Ajusta las reglas según tus necesidades
    ];

        // Validar los datos del request
        $validatedData = $request->validate($rules);

    // Acceder a los datos validados
    $cancelado = $validatedData['txtcancelado'];
    $categoriaCancelacion = $validatedData['txtcategoriaCancelacion'];

        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.
        try {


            $id->comentario = $cancelado;
            $id->id_cancelacion = $categoriaCancelacion;
            $id->save();


            //$preventa->deleted_at = now();
            //$preventaCancelada = $preventa->save();


            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            //si retorna un error de sql lo veremos en pantalla
            //return $th->getMessage();
            session()->flash("incorrect", "Error al cancelar el registro");
            return redirect()->route('orden_recoleccion.index');
        }

        session()->flash("correcto", "Cacelacion ejecutada correctamente");
        return redirect()->route('orden_recoleccion.index');
    }

    public function generarPdf2(string $id)
    {


        $ordenRecoleccion = Preventa::join('orden_recoleccions', 'orden_recoleccions.id_preventaOrdenServicio', '=',  'preventas.id')
        ->leftjoin('folios_servicios', 'folios_servicios.id', '=', 'orden_recoleccions.id_folio_servicio')
        ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
        ->join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
        ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
        ->join('personas as personaClientes', 'personaClientes.id', '=', 'clientes.id_persona')
        ->where('orden_recoleccions.id', $id)
        ->select(
            'orden_recoleccions.id as idRecoleccion',
            'orden_recoleccions.created_at as fechaCreacion',
            'orden_recoleccions.Fecha_entrega as fechaEntrega',
            'folios_servicios.ultimo_valor as ultimoValor',
            'preventas.metodo_pago as metodoPago',
            'preventas.id as idPreventa',
            'preventas.factura',
            'preventas.pago_efectivo as pagoEfectivo',
            'preventas.nombre_atencion as nombreAtencion',
            'preventas.nombre_quien_recibe as recibe',
            'preventas.nombre_empleado as nombreEmpleado',
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

        $fechaCreacion = \Carbon\Carbon::parse($ordenRecoleccion->fechaCreacion);

        $Tiempo = TiempoAproximado::whereDate('created_at', $fechaCreacion->toDateString())->orderBy('created_at', 'desc')->first();

        $DatosdelNegocio = Info_tickets::first();

        $largoDelTicket = 700; // Inicializa la variable


        if ($listaProductos->count() > 1) {
            $extra = max(0, $listaProductos->count() - 1);
            $largoDelTicket += $extra * 50;
        }

        $diasSemana = explode(',', $ordenRecoleccion->diaSemana);

        if (count($diasSemana) > 1) {
            $largoDelTicket += 50;
        }


        $pdf = PDF::loadView('Principal.ordenRecoleccion.vista_pdf', compact(
            'ordenRecoleccion',
            'listaProductos',
            'Tiempo',
            'DatosdelNegocio'
        ));

        // Establece el tamaño del papel a 80mm de ancho y 200mm de largo
        $pdf->setPaper([0, 0, 226.77, 750.00], 'portrait'); // 80mm x 200mm en puntos

        // Renderiza el documento PDF y lo envía al navegador
        return $pdf->stream();
    }

    public function generarExcel(Request $request)
    {


        $busqueda = $request->query('adminlteSearch');
        $filtroES = $request->query('entrega_servicio');
        $filtroFecha_inicio = $request->query('fecha_inicio');
        $fecha_fin = $request->query('fecha_fin');
        $filtroEstatus = $request->query('estatus');
        $palabras = explode(' ', $busqueda); // Divide la cadena de búsqueda en palabras
        $datosEntregaCompromisos[] = [
            'fecha' => null,
            'hora' => null,
            'horaEntregaCompromiso' => null,
        ];



        $preventas = Preventa::join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('personas', 'personas.id', '=', 'clientes.id_persona')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->leftJoin('orden_recoleccions', function ($join) {
                $join->on('orden_recoleccions.id_preventa', '=', 'preventas.id')
                    ->orOn('orden_recoleccions.id_preventaServicio', '=', 'preventas.id');
            })
            ->leftjoin('folios', 'folios.id', '=', 'orden_recoleccions.id_folio')
            ->leftjoin('folios_servicios', 'folios_servicios.id', '=', 'orden_recoleccions.id_folio_servicio')
            ->leftjoin('folios as folio_r', 'folio_r.id', '=', 'orden_recoleccions.id_folio_recoleccion')
            ->whereIn('preventas.tipo_de_venta', ['Entrega', 'Servicio']) //whereIn para filtrar las preventas
            ->WhereIn('preventas.estado', ['Recolectar', 'Revision', 'Entrega', 'Listo', 'Cancelado'])
            ->WhereNull('preventas.deleted_at')
            ->where(function ($query) use ($palabras) {
                foreach ($palabras as $palabra) {
                    $query->where(function ($query) use ($palabra) {
                        $query->where('personas.telefono', 'LIKE', "%{$palabra}%")
                            ->orWhere('personas.nombre', 'LIKE', "%{$palabra}%")
                            ->orWhere('personas.apellido', 'LIKE', "%{$palabra}%")
                            ->orWhere('catalago_ubicaciones.localidad', 'LIKE', "%{$palabra}%")
                            ->orWhere('catalago_ubicaciones.localidad', 'LIKE', "%{$palabra}%");
                    });
                }
            });

        // Búsqueda por número de folio
        if (preg_match('/^[A-Z]\d+$/', $busqueda)) {
            $letra = substr($busqueda, 0, 1);
            $numero = (int) substr($busqueda, 1);

            $preventas->orWhere(function ($query) use ($letra, $numero) {
                $query->where('folios.letra_actual', $letra)
                    ->where('folios.ultimo_valor', $numero);
            });
        }
        if (ctype_digit($busqueda)) {

            $numero = (int) $busqueda;

            $preventas->orWhere(function ($query) use ($numero) {
                $query->where('folios_servicios.ultimo_valor', $numero);
            });
        }

        if ($filtroES) { //E : Entrega , S: Servicio
            $preventas->where('preventas.tipo_de_venta', $filtroES);
        }

        if ($filtroFecha_inicio && $fecha_fin) {

            $Inicio = Carbon::createFromFormat('Y-m-d', $filtroFecha_inicio)->startOfDay();
            $Fin = Carbon::createFromFormat('Y-m-d', $fecha_fin)->endOfDay();

            $preventas->whereBetween('orden_recoleccions.created_at', [$Inicio, $Fin]);
        }


        if ($filtroEstatus) {

            $preventas->where('preventas.estado', $filtroEstatus);
        }
        $preventas = $preventas->select(
            'orden_recoleccions.id as idRecoleccion',
            'orden_recoleccions.created_at as fechaCreacion',
            'orden_recoleccions.id_cancelacion',
            'orden_recoleccions.created_at',
            'folios.letra_actual as letraActual',
            'folios.ultimo_valor as ultimoValor',
            'folios_servicios.ultimo_valor as ultimoValorServicio',
            'folio_r.letra_actual as letraActual_r',
            'folio_r.ultimo_valor as ultimoValor_r',
            'preventas.id as idPreventa',
            'preventas.estado as estatusPreventa',
            'preventas.tipo_de_venta as tipoVenta',
            'preventas.nombre_empleado as nombreEmpleado',
            'personas.nombre as nombreCliente',
            'personas.apellido as apellidoCliente',
            'personas.telefono',
            'personas.email as correo',
            'clientes.comentario as rfc',
            'catalago_ubicaciones.localidad as colonia',
            'direcciones.calle',
            'direcciones.num_exterior',
            'direcciones.num_interior',
            'direcciones.referencia',
        )
            ->orderBy('orden_recoleccions.updated_at', 'desc')
            ->get();


        $headers = [
            'Content-type' => 'text/csv;charset=UTF-8',
            'Content-Disposition' => 'attachment; filename=Ecotoner.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
        $row = ['Folio', 'Nombre cliente', 'RFC', 'Telefono cliente', 'Correo electronio', 'Dirección', 'Numero Exterior', 'Numero Interior', 'Referencia', 'Empleado', 'Fecha y hora del pedido', 'Hora compromiso', 'Fecha y hora de conclusión', 'Tipo de servicio', 'Estatus', 'Total de productos', 'Costo total'];
        $callback = function () use ($preventas, $row) {
            $output = fopen('php://output', 'w');
            fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($output, $row);

            foreach ($preventas as $index => $row) {
                if ($row->estatusPreventa == 'Listo' && !is_numeric($row->id_cancelacion)) {
                    $EstadoServicio = 'Orden Procesada';
                } else if ($row->estatusPreventa === 'Entrega' && !is_numeric($row->id_cancelacion)) {
                    $EstadoServicio = 'En entrega';
                } else if ($row->estatusPreventa === 'Revision' && !is_numeric($row->id_cancelacion)) {
                    $EstadoServicio = 'En revision';
                } else if ($row->estatusPreventa === 'Recolectar' && !is_numeric($row->id_cancelacion)) {
                    $EstadoServicio = 'En revisión';
                } else {
                    $EstadoServicio = 'Cancelado';
                }

                if ($row->tipoVenta === 'Entrega') {
                    $TipoServicio = 'Orden Entrega';
                    // Suponiendo que $row->ultimoValor contiene el valor numérico Ahora $valorConCeros contiene el valor de $row->ultimoValor con ceros a la izquierda.
                    $folio = $row->letraActual . str_pad($row->ultimoValor, 6, '0', STR_PAD_LEFT);
                } else if ($row->tipoVenta === 'Servicio') {

                    $TipoServicio = 'Orden Servicio';
                    $folio = $row->letraActual_r . str_pad($row->ultimoValor_r, 6, '0', STR_PAD_LEFT);
                    info('entro : ' . $folio);
                }

                $fechaCreacion = \Carbon\Carbon::parse($row->fechaCreacion);
                $Tiempo = TiempoAproximado::whereDate('created_at', $fechaCreacion->toDateString())->orderBy('created_at', 'desc')->first();
                if ($Tiempo) {
                    $fechaHoraArray = explode(' ', $row->fechaCreacion);
                    $fecha = $fechaHoraArray[0];
                    $hora = $fechaHoraArray[1];
                    // Crear un objeto DateTime con la hora inicial
                    $horaInicial = new DateTime($hora);
                    // Sumar el intervalo de tiempo a la hora inicial
                    list($horas, $minutos, $segundos) = explode(':', $Tiempo->tiempo);
                    $intervalo = new DateInterval(sprintf('PT%dH%dM%dS', $horas, $minutos, $segundos));
                    $horaEntregaCompromiso = $horaInicial->add($intervalo);
                    // Aquí puedes hacer lo que necesites con $horaEntregaCompromiso
                    // Aquí puedes hacer lo que necesites con $horaEntregaCompromiso
                    $datosEntregaCompromisos[] = [
                        'fecha' => $fecha,
                        'hora' => $hora,
                        'horaEntregaCompromiso' => $horaEntregaCompromiso->format('H:i:s'),
                    ];
                } else {
                    $datosEntregaCompromisos[] = [
                        'fecha' => null,
                        'hora' => null,
                        'horaEntregaCompromiso' => null,
                    ];
                }

                if ($row->tipoVenta === 'Entrega') {
                    $productos = ventas_productos::join('precios_productos', 'precios_productos.id', '=', 'ventas_productos.id_precio_producto')
                        ->join('preventas', 'preventas.id', '=', 'ventas_productos.id_preventa')
                        ->join('productos', 'productos.id', '=', 'precios_productos.id_producto')
                        ->join('marcas', 'marcas.id', '=', 'productos.id_marca')
                        ->join('tipos', 'tipos.id', '=', 'productos.id_tipo')
                        ->leftJoin('colors', 'colors.id', '=', 'productos.id_color')
                        ->join('modos', 'modos.id', '=', 'productos.id_modo')
                        ->where('precios_productos.estatus', 1)
                        ->where('preventas.id', $row->idPreventa)
                        ->select(
                            'productos.*',
                            'precios_productos.precio',
                            'marcas.nombre as marca',
                            'tipos.nombre as tipo',
                            'colors.nombre as color',
                            'modos.nombre as nombreModo',
                            'ventas_productos.cantidad',
                            'ventas_productos.descuento',
                            'ventas_productos.tipo_descuento as tipoDescuento',
                        )
                        ->get();
                    $total = 0;
                    $cantidadTotal = 0;


                    foreach ($productos as $indice => $producto) {

                        switch ($producto->tipoDescuento) {
                            case 'Porcentaje':
                                $descuento = $producto->precio * intval($producto->descuento) / 100;
                                $total += ($producto->precio * $producto->cantidad - $descuento);
                                $cantidadTotal += ($producto->cantidad);
                                break;
                            case 'cantidad':
                                $total += (($producto->precio * $producto->cantidad) - ($producto->descuento * $producto->cantidad));
                                $cantidadTotal += ($producto->cantidad);
                                break;
                            case 'alternativo':
                                $total += ($producto->descuento * $producto->cantidad);
                                $cantidadTotal += ($producto->cantidad);
                                break;
                            case 'Sin descuento':
                                $total += ($producto->precio * $producto->cantidad);
                                $cantidadTotal += ($producto->cantidad);
                                break;
                        }
                    }
                } else if ($row->tipoVenta === 'Servicio') {

                    $productos = precios_productos::join('servicios_preventas', 'servicios_preventas.id_precio_producto', '=', 'precios_productos.id')
                        ->join('preventas', 'preventas.id', '=', 'servicios_preventas.id_preventa')
                        ->join('productos', 'productos.id', '=', 'precios_productos.id_producto')
                        ->join('marcas', 'marcas.id', '=', 'productos.id_marca')
                        ->join('colors', 'colors.id', '=', 'productos.id_color')
                        ->join('tipos', 'tipos.id', '=', 'productos.id_tipo')
                        ->join('modos', 'modos.id', '=', 'productos.id_modo')
                        ->where('preventas.id', $row->idPreventa)
                        ->select(
                            'productos.*',
                            'precios_productos.precio',
                            'servicios_preventas.precio_unitario',
                            'servicios_preventas.cantidad_total as cantidad',
                            'servicios_preventas.tipo_descuento as tipoDescuento',
                            'servicios_preventas.descuento',
                            'precios_productos.precio',
                            'marcas.nombre as marca',
                            'tipos.nombre as tipo',
                            'colors.nombre as color',
                            'modos.nombre as nombreModo'
                        )
                        ->get();
                    $total = 0;
                    $cantidadTotal = 0;
                    foreach ($productos as $indice => $producto) {

                        switch ($producto->tipoDescuento) {
                            case 'Porcentaje':
                                $descuento = $producto->precio * intval($producto->descuento) / 100;
                                $total += ($producto->precio * $producto->cantidad - $descuento);
                                $cantidadTotal += ($producto->cantidad);
                                break;
                            case 'cantidad':
                                $total += (($producto->precio * $producto->cantidad) - ($producto->descuento * $producto->cantidad));
                                $cantidadTotal += ($producto->cantidad);
                                break;
                            case 'alternativo':
                                $total += ($producto->descuento * $producto->cantidad);
                                $cantidadTotal += ($producto->cantidad);
                                break;
                            case 'Sin descuento':
                                $total += ($producto->precio * $producto->cantidad);
                                $cantidadTotal += ($producto->cantidad);
                                break;
                        }
                    }
                }

                $count = !is_null($row->cantidad) ? $row->cantidad : 0;
                $rowContent = [$folio, $row->nombreCliente . ' ' . $row->apellidoCliente, $row->rfc, $row->telefono, $row->correo, 'Col.' . $row->colonia . '; ' . $row->calle, $row->num_exterior, $row->num_interior, $row->referencia, $row->nombreEmpleado, $row->fechaCreacion, $datosEntregaCompromisos[$index]['horaEntregaCompromiso'], $row->fechaVenta, $TipoServicio, $EstadoServicio, $cantidadTotal, '$' . $total, $count];

                fputcsv($output, $rowContent);
            }
            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function buscarPrecioRecoleccion($identificadorPrecio)
    {

      return  precios_productos::where('id', $identificadorPrecio)->whereIn('estatus',[2,1])->first();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orden_recoleccion $orden_recoleccion)
    {
        //
    }
}
