<?php

namespace App\Http\Controllers;

use App\Models\Cancelaciones;
use App\Models\Catalago_recepcion;
use App\Models\clientes;
use App\Models\Orden_recoleccion;
use App\Models\precios_productos;
use App\Models\Preventa;
use App\Models\Servicios_preventas;
use App\Models\TiempoAproximado;
use App\Models\ventas;
use App\Models\ventas_productos;
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
            ->join('orden_recoleccions', 'orden_recoleccions.id_preventa', '=', 'preventas.id')
            ->leftjoin('folios', 'folios.id', '=', 'orden_recoleccions.id_folio')
            ->whereIn('preventas.estatus', [3, 4]) //whereIn para filtrar las preventas donde el estatus es 3 o 4.
            ->WhereIn('orden_recoleccions.estatus', [4, 3, 2, 1])
            //->where('id_cancelacion', null)
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

        if ($filtroES) { //E : Entrega , S: Servicio
            $preventas->where('preventas.estatus', $filtroES);
        }

        if ($filtroFecha_inicio && $fecha_fin) {

            $Inicio = Carbon::createFromFormat('Y-m-d', $filtroFecha_inicio)->startOfDay();
            $Fin = Carbon::createFromFormat('Y-m-d', $fecha_fin)->endOfDay();

            $preventas->whereBetween('orden_recoleccions.created_at', [$Inicio, $Fin->addDay()]);
        }

        //si es algun valor positivo entra 1: Listo, 2: Entrega, 3: Revision, 4: Recoleccion, 5: Cancelacion
        if ($filtroEstatus) {
            if ($filtroEstatus == "5") { //si es 5 entonces entra al if y verifica si tiene algun id_cancelacion
                $preventas->whereNotNull('orden_recoleccions.id_cancelacion');
            } else {
                $preventas->where('orden_recoleccions.estatus', $filtroEstatus);
            }
        }
        $preventas = $preventas->select(
            'orden_recoleccions.id as idRecoleccion',
            'orden_recoleccions.created_at as fechaCreacion',
            'orden_recoleccions.id_cancelacion',
            'orden_recoleccions.estatus', //5 pendiente 4 por recolectar, 3 revision 2 entrega 1 listo 0 eliminado
            'orden_recoleccions.created_at',
            'folios.letra_actual as letraActual',
            'folios.ultimo_valor as ultimoValor',
            'preventas.id as idPreventa',
            'preventas.estatus as estatusPreventa',
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
            ->paginate(5)->appends(['adminlteSearch' => $busqueda, 'entrega_servicio' => $filtroES, 'fecha_inicio' => $filtroFecha_inicio, 'fecha_fin' => $fecha_fin, 'estatus' => $filtroEstatus]); // Mueve paginate() aquí para que funcione correctamente
        foreach ($preventas as $preventa) {
            $fechaCreacion = \Carbon\Carbon::parse($preventa->fechaCreacion);
            $Tiempo = TiempoAproximado::whereDate('created_at', $fechaCreacion->toDateString())->orderBy('created_at', 'desc')->first();
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
        $id_recoleccion = $request->input('id_recoleccion');
        /* $datosEnvio = Orden_recoleccion::all();
        return $datosEnvio[0]->preventas; */

        $datosEnvio = Orden_recoleccion::join('preventas', 'preventas.id', '=', 'orden_recoleccions.id_preventa')
            ->join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('personas as clientePersona', 'clientePersona.id', '=', 'clientes.id_persona')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->leftJoin('ventas', 'ventas.id_recoleccion', '=', 'orden_recoleccions.id')
            ->whereIn('preventas.estatus', [3, 4]) //3 entrega, 4 servicios, 2 inconcluso,
            ->where('orden_recoleccions.id', $id_recoleccion)
            ->select(
                'orden_recoleccions.id as idRecoleccion',
                'preventas.id as idPreventa',
                'preventas.estatus as estatusPreventa',
                'preventas.nombre_empleado as nombreEmpleado',
                'preventas.nombre_atencion as nombreAtencion',
                'preventas.nombre_quien_recibe as nombreRecibe',
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


        if ($datosEnvio->estatusPreventa == 3) {
            $productos = ventas_productos::join('precios_productos', 'precios_productos.id', '=', 'ventas_productos.id_precio_producto')
                ->join('preventas', 'preventas.id', '=', 'ventas_productos.id_preventa')
                ->join('productos', 'productos.id', '=', 'precios_productos.id_producto')
                ->join('marcas', 'marcas.id', '=', 'productos.id_marca')
                ->join('tipos', 'tipos.id', '=', 'productos.id_tipo')
                ->leftJoin('colors', 'colors.id', '=', 'productos.id_color')
                ->join('modos', 'modos.id', '=', 'productos.id_modo')
                ->where('precios_productos.estatus', 1)
                ->where('preventas.id', $datosEnvio->idPreventa)
                ->select(
                    'productos.*',
                    'marcas.nombre as marca',
                    'tipos.nombre as tipo',
                    'colors.nombre as color',
                    'ventas_productos.cantidad',
                    'ventas_productos.descuento',
                    'ventas_productos.tipo_descuento as tipoDescuento',
                    'precios_productos.precio'
                )

                ->get();
        } else if ($datosEnvio->estatusPreventa == 4) { //leftjoin me devolvera null si no hay relaciones
            $productos = Servicios_preventas::join('precios_productos', 'precios_productos.id', '=', 'servicios_preventas.id_precio_producto')
                ->join('preventas', 'preventas.id', '=', 'servicios_preventas.id_preventa')
                ->join('productos', 'productos.id', '=', 'precios_productos.id_producto')
                ->leftJoin('marcas', 'marcas.id', '=', 'productos.id_marca')
                ->leftJoin('tipos', 'tipos.id', '=', 'productos.id_tipo')
                ->leftJoin('colors', 'colors.id', '=', 'productos.id_color')
                ->leftJoin('modos', 'modos.id', '=', 'productos.id_modo')
                ->where('preventas.id', $datosEnvio->idPreventa)
                ->select(
                    'productos.nombre_comercial',
                    'productos.descripcion',
                    'modos.nombre as nombreModo',
                    'servicios_preventas.cantidad_total as cantidad',
                    'marcas.nombre as marca',
                    'tipos.nombre as tipo',
                    'colors.nombre as color',
                    'servicios_preventas.precio_unitario',
                    'precios_productos.precio',
                    'servicios_preventas.descuento',
                    'servicios_preventas.tipo_descuento as tipoDescuento',

                )
                ->get();
        }
        return view('Principal.ordenRecoleccion.edit', compact('productos', 'datosEnvio'));
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
    public function edit(Orden_recoleccion $orden_recoleccion, Request $request)
    {
        $costo_unitario = $request->input('costo_unitario');
        $pagaCon = $request->input('txtpagoEfectivo');
        $codigo = $request->input('codigo');
        $nRecarga = $request->input('numero_recarga');
        $observaciones = $request->input('observacionesDetalle');

        $comentario = $request->input('observaciones');
        // Recuperar el ID de la orden de recolección
        $ordenRecoleccion = $orden_recoleccion;
        $estatus = $request->miSelect;
        $preventa = Preventa::where('id', $ordenRecoleccion->id_preventa)
            ->whereIn('estatus', [2, 3, 4])
            ->first();

        $serviciosPreventas = Servicios_preventas::join('precios_productos', 'precios_productos.id', '=', 'servicios_preventas.id_precio_producto')
            ->where('servicios_preventas.id_preventa', $ordenRecoleccion->id_preventa)->get();




        $cliente = clientes::where('id', $preventa->id_cliente);

        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.

        try {
            //5 pendiente 4 por recolectar, 3 revision 2 entrega 1 listo 0 eliminado
            if ($estatus == 3) {
                //cambiamos el estatus de la recoleccion
                $ordenRecoleccion->update([
                    'Fecha_recoleccion' => now(),
                    'estatus' => $estatus,
                ]);
                $preventa->update([
                    'codigo' => $codigo,
                    'numero_recarga' => $nRecarga,
                ]);
            } else if ($estatus == 2) {
                $ordenRecoleccion->update([
                    'Fecha_entrega' => now(),
                    'estatus' => $estatus,
                    // Agrega aquí cualquier otro campo que desees actualizar
                ]);

                if ($preventa->estatus == 4) {

                    foreach ($serviciosPreventas as $index => $servicioPreventa) {
                        // Obtén el costo unitario correspondiente a este servicio preventa


                        // Actualiza el servicio preventa con el nuevo costo unitario
                        $servicioPreventa->update(['precio_unitario' => $costo_unitario[$index]]);
                    }

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
                }
            } else if ($estatus == 5) {
                $preventa->update([
                    'observacion' => $observaciones,
                ]);
            } else if ($estatus == 1) {
                //actualizamos orden de recoleccion
                $ordenRecoleccion->update([
                    'estatus' => $estatus,
                    // Agrega aquí cualquier otro campo que desees actualizar
                ]);

                $preventa->update([
                    'comentario' => $comentario,
                ]);

                //actualizamos ventas
                $ventaConcluida = ventas::create([
                    'id_recoleccion' => $ordenRecoleccion->id,
                ]);
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
        $id_recoleccion = $id;

        $datosEnvio = Orden_recoleccion::join('preventas', 'preventas.id', '=', 'orden_recoleccions.id_preventa')
            ->join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('personas as clientePersona', 'clientePersona.id', '=', 'clientes.id_persona')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->leftJoin('ventas', 'ventas.id_recoleccion', '=', 'orden_recoleccions.id')
            ->whereIn('preventas.estatus', [3, 4]) //3 entrega, 4 servicios, 2 inconcluso, 0 eliminado
            ->where('orden_recoleccions.id', $id_recoleccion)
            ->select(
                'orden_recoleccions.id as idRecoleccion',
                'preventas.id as idPreventa',
                'preventas.estatus as estatusPreventa',
                'preventas.nombre_empleado as nombreEmpleado',
                'preventas.nombre_atencion as nombreAtencion',
                'preventas.nombre_quien_recibe as nombreRecibe',
                'orden_recoleccions.id as idOrden_recoleccions',
                'orden_recoleccions.Fecha_recoleccion as fechaRecoleccion',
                'orden_recoleccions.id_cancelacion',
                'ventas.created_at as fechaEntrega',
                'orden_recoleccions.created_at',
                'orden_recoleccions.id as id_recoleccion',
                'orden_recoleccions.estatus as estatusRecoleccion', //5 pendiente 4 por recolectar, 3 revision 2 entrega 1 listo 0 eliminado
                'orden_recoleccions.created_at',
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


        if ($datosEnvio->estatusPreventa == 3) {
            $productos = ventas_productos::join('precios_productos', 'precios_productos.id', '=', 'ventas_productos.id_precio_producto')
                ->join('preventas', 'preventas.id', '=', 'ventas_productos.id_preventa')
                ->join('productos', 'productos.id', '=', 'precios_productos.id_producto')
                ->join('marcas', 'marcas.id', '=', 'productos.id_marca')
                ->join('tipos', 'tipos.id', '=', 'productos.id_tipo')
                ->leftJoin('colors', 'colors.id', '=', 'productos.id_color')
                ->join('modos', 'modos.id', '=', 'productos.id_modo')
                ->where('precios_productos.estatus', 1)
                ->where('preventas.id', $datosEnvio->idPreventa)
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
        } else if ($datosEnvio->estatusPreventa == 4) { //leftjoin me devolvera null si no hay relaciones
            $productos = Catalago_recepcion::join('productos', 'productos.id', '=', 'catalago_recepcions.id_producto')
                ->join('servicios_preventas', 'servicios_preventas.id_producto_recepcion', '=', 'catalago_recepcions.id')
                ->join('preventas', 'preventas.id', '=', 'servicios_preventas.id_preventa')
                ->leftJoin('marcas', 'marcas.id', '=', 'productos.id_marca')
                ->leftJoin('tipos', 'tipos.id', '=', 'productos.id_tipo')
                ->leftJoin('colors', 'colors.id', '=', 'productos.id_color')
                ->where('preventas.id', $datosEnvio->idPreventa)
                ->select(
                    'productos.*',
                    'marcas.nombre as marca',
                    'tipos.nombre as tipo',
                    'colors.nombre as color'
                )
                ->get();
        }

        $cancelar = Cancelaciones::where('estatus', 1)
            ->orderBy('cancelaciones.nombre', 'desc')->get();

        return view('Principal.ordenRecoleccion.cancelar', compact('productos', 'datosEnvio', 'cancelar'));
    }
    public function cancelar(Orden_recoleccion $id, Request $request)
    {
        $cancelado = $request->input('txtcancelado');
        $categoriaCancelacion = $request->input('txtcategoriaCancelacion');

        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.
        try {

            $preventa = Preventa::where('id', $id->id_preventa)
                ->whereIn('estatus', [2, 3, 4])
                ->first();


            $id->deleted_at = now();
            $id->comentario = $cancelado;
            $id->id_cancelacion = $categoriaCancelacion;
            $ordenCancelada = $id->save();


            $preventa->deleted_at = now();
            $preventaCancelada = $preventa->save();


            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            //si retorna un error de sql lo veremos en pantalla
            return $th->getMessage();
            $preventaCancelada = false;
        }
        if ($preventaCancelada && $ordenCancelada) {
            session()->flash("correcto", "Cacelacion ejecutada correctamente");
            return redirect()->route('orden_recoleccion.index');
        } else {
            session()->flash("incorrect", "Error al cancelar el registro");
            return redirect()->route('orden_recoleccion.index');
        }
    }

    public function generarPdf2(string $id)
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
                'preventas.costo_servicio',
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
            )
            ->first();

        $productos = Catalago_recepcion::join('productos', 'productos.id', '=', 'catalago_recepcions.id_producto')
            ->join('servicios_preventas', 'servicios_preventas.id_producto_recepcion', '=', 'catalago_recepcions.id')
            ->join('preventas', 'preventas.id', '=', 'servicios_preventas.id_preventa')
            ->leftJoin('marcas', 'marcas.id', '=', 'productos.id_marca')
            ->leftJoin('tipos', 'tipos.id', '=', 'productos.id_tipo')
            ->leftJoin('colors', 'colors.id', '=', 'productos.id_color')
            ->leftJoin('modos', 'modos.id', '=', 'productos.id_modo')
            ->where('preventas.id', $ordenRecoleccion->idPreventa)
            ->where('servicios_preventas.estatus', 2)
            ->select('productos.nombre_comercial', 'productos.descripcion', 'servicios_preventas.cantidad_total', 'marcas.nombre as marca', 'tipos.nombre as tipo', 'colors.nombre as color')
            ->get();

        $pdf = PDF::loadView('Principal.ordenRecoleccion.vista_pdf', compact(
            'ordenRecoleccion',
            'productos'
        ));

        // Establece el tamaño del papel a 80mm de ancho y 200mm de largo
        $pdf->setPaper([0, 0, 226.77, 699.93], 'portrait'); // 80mm x 200mm en puntos

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
            ->join('orden_recoleccions', 'orden_recoleccions.id_preventa', '=', 'preventas.id')
            ->leftjoin('folios', 'folios.id', '=', 'orden_recoleccions.id_folio')
            ->leftJoin('ventas', 'ventas.id_recoleccion', '=', 'orden_recoleccions.id')
            ->whereIn('preventas.estatus', [3, 4]) //whereIn para filtrar las preventas donde el estatus es 3 o 4.
            ->WhereIn('orden_recoleccions.estatus', [4, 3, 2, 1])
            //->where('id_cancelacion', null)
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

        if ($filtroES) { //E : Entrega , S: Servicio
            $preventas->where('preventas.estatus', $filtroES);
        }

        if ($filtroFecha_inicio && $fecha_fin) {
            $preventas->whereBetween('orden_recoleccions.created_at', [$filtroFecha_inicio, $fecha_fin]);
        }
        //si es algun valor positivo entra 1: Listo, 2: Entrega, 3: Revision, 4: Recoleccion, 5: Cancelacion
        if ($filtroEstatus) {
            if ($filtroEstatus == "5") { //si es 5 entonces entra al if y verifica si tiene algun id_cancelacion
                $preventas->whereNotNull('orden_recoleccions.id_cancelacion');
            } else {
                $preventas->where('orden_recoleccions.estatus', $filtroEstatus);
            }
        }
        $preventas = $preventas->select(
            'orden_recoleccions.id as idRecoleccion',
            'orden_recoleccions.created_at as fechaCreacion',
            'orden_recoleccions.id_cancelacion',
            'orden_recoleccions.estatus', //5 pendiente 4 por recolectar, 3 revision 2 entrega 1 listo 0 eliminado
            'folios.letra_actual as letraActual',
            'folios.ultimo_valor as ultimoValor',
            'preventas.id as idPreventa',
            'preventas.estatus as estatusPreventa',
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
            'ventas.created_at as fechaVenta',
        )
            ->orderBy('orden_recoleccions.updated_at', 'desc')
            ->get();

        foreach ($preventas as $preventa) {
        }


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
                if ($row->estatus == 1 && !is_numeric($row->id_cancelacion)) {
                    $EstadoServicio = 'Orden Procesada';
                } else if ($row->estatus == 2 && !is_numeric($row->id_cancelacion)) {
                    $EstadoServicio = 'En entrega';
                } else if ($row->estatus == 3 && !is_numeric($row->id_cancelacion)) {
                    $EstadoServicio = 'En revision';
                } else if ($row->estatus == 4 && !is_numeric($row->id_cancelacion)) {
                    $EstadoServicio = 'En revisión';
                } else {
                    $EstadoServicio = 'Cancelado';
                }

                if ($row->estatusPreventa == 3) {
                    $TipoServicio = 'Orden Entrega';
                } else if ($row->estatusPreventa == 4) {
                    $TipoServicio = 'Orden Servicio';
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

                if ($row->estatusPreventa == 3) {
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
                                $total += ($producto->precio * $producto->cantidad - $producto->descuento);
                                $cantidadTotal += ($producto->cantidad);
                                break;
                            case 'Sin descuento':
                                $total += ($producto->precio * $producto->cantidad);
                                $cantidadTotal += ($producto->cantidad);
                                break;
                        }
                    }
                } else if ($row->estatusPreventa == 4) { //leftjoin me devolvera null si no hay relaciones
                    $productos = Catalago_recepcion::join('productos', 'productos.id', '=', 'catalago_recepcions.id_producto')
                        ->join('servicios_preventas', 'servicios_preventas.id_producto_recepcion', '=', 'catalago_recepcions.id')
                        ->join('preventas', 'preventas.id', '=', 'servicios_preventas.id_preventa')
                        ->leftJoin('marcas', 'marcas.id', '=', 'productos.id_marca')
                        ->leftJoin('tipos', 'tipos.id', '=', 'productos.id_tipo')
                        ->leftJoin('colors', 'colors.id', '=', 'productos.id_color')
                        ->where('preventas.id', $row->idPreventa)
                        ->select(
                            'productos.*',
                            'marcas.nombre as marca',
                            'tipos.nombre as tipo',
                            'colors.nombre as color'
                        )
                        ->get();
                }


                $count = !is_null($row->cantidad) ? $row->cantidad : 0;
                $rowContent = [$row->letraActual . ' ' . $row->ultimoValor, $row->nombreCliente . ' ' . $row->apellidoCliente, $row->rfc, $row->telefono, $row->correo, 'Col.' . $row->colonia . '; ' . $row->calle, $row->num_exterior, $row->num_interior, $row->referencia, $row->nombreEmpleado, $row->fechaCreacion, $datosEntregaCompromisos[$index]['horaEntregaCompromiso'], $row->fechaVenta, $TipoServicio, $EstadoServicio, $cantidadTotal, '$' . $total, $count];

                fputcsv($output, $rowContent);
            }
            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orden_recoleccion $orden_recoleccion)
    {
        //
    }
}
