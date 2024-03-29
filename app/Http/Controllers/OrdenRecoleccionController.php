<?php

namespace App\Http\Controllers;

use App\Models\Cancelaciones;
use App\Models\Catalago_recepcion;
use App\Models\clientes;
use App\Models\Orden_recoleccion;
use App\Models\precios_productos;
use App\Models\Preventa;
use App\Models\ventas;
use App\Models\ventas_productos;
use Barryvdh\DomPDF\Facade\Pdf;
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


        $preventas = Preventa::join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('personas', 'personas.id', '=', 'clientes.id_persona')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->join('empleados', 'empleados.id', '=', 'preventas.id_empleado')
            ->join('orden_recoleccions', 'orden_recoleccions.id_preventa', '=', 'preventas.id')
            ->whereIn('preventas.estatus', [3, 4]) //whereIn para filtrar las preventas donde el estatus es 3 o 4.
            ->WhereIn('orden_recoleccions.estatus', [4, 3, 2])
            ->where(function ($query) use ($busqueda) {
                $query->where('personas.telefono', 'LIKE', "%{$busqueda}%")
                    ->orWhere('personas.nombre', 'LIKE', "%{$busqueda}%")
                    ->orWhere('personas.apellido', 'LIKE', "%{$busqueda}%")
                    ->orWhere('catalago_ubicaciones.localidad', 'LIKE', "%{$busqueda}%")
                    ->orWhere('catalago_ubicaciones.localidad', 'LIKE', "%{$busqueda}%");
            });
        if ($filtroES) {
            $preventas->where('preventas.estatus', $filtroES);
        }

        if ($filtroFecha_inicio && $fecha_fin) {
            $preventas->whereBetween('orden_recoleccions.created_at', [$filtroFecha_inicio, $fecha_fin]);
        }

        if ($filtroEstatus) {
            $preventas->where('orden_recoleccions.estatus', $filtroEstatus);
        }
        $preventas = $preventas->select(
            'orden_recoleccions.id as idRecoleccion',
            'preventas.estatus as estatusPreventa',
            'orden_recoleccions.id as id_recoleccion',
            'orden_recoleccions.estatus', //5 pendiente 4 por recolectar, 3 revision 2 entrega 1 listo 0 eliminado
            'orden_recoleccions.created_at',
            'personas.nombre as nombreCliente',
            'personas.apellido as apellidoCliente',
            'personas.telefono',
            'clientes.comentario as rfc',
            'catalago_ubicaciones.localidad as colonia',
            'direcciones.calle',
            'direcciones.num_exterior',
            'direcciones.num_interior',
            'direcciones.referencia',
        )
            ->orderBy('orden_recoleccions.updated_at', 'desc')
            ->paginate(5); // Mueve paginate() aquí para que funcione correctamente
        return view('Principal.ordenRecoleccion.recolecciones', compact('preventas'));
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
            ->join('empleados', 'empleados.id', '=', 'preventas.id_empleado')
            ->join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('personas as empleadoPersona', 'empleadoPersona.id', '=', 'empleados.id_persona')
            ->join('personas as clientePersona', 'clientePersona.id', '=', 'clientes.id_persona')
            ->join('roles', 'roles.id', '=', 'empleados.id_rol')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->whereIn('preventas.estatus', [3, 4]) //3 entrega, 4 servicios, 2 inconcluso, 0 eliminado
            ->where('orden_recoleccions.id', $id_recoleccion)
            ->select(
                'orden_recoleccions.id as idRecoleccion',
                'preventas.id as idPreventa',
                'preventas.estatus as estatusPreventa',
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
                ->select('productos.*', 'marcas.nombre as marca', 'tipos.nombre as tipo', 'colors.nombre as color')

                ->get();
        } else if ($datosEnvio->estatusPreventa == 4) { //leftjoin me devolvera null si no hay relaciones
            $productos = Catalago_recepcion::join('productos', 'productos.id', '=', 'catalago_recepcions.id_producto')
                ->join('servicios_preventas', 'servicios_preventas.id_producto_recepcion', '=', 'catalago_recepcions.id')
                ->join('preventas', 'preventas.id', '=', 'servicios_preventas.id_preventa')
                ->leftJoin('marcas', 'marcas.id', '=', 'productos.id_marca')
                ->leftJoin('tipos', 'tipos.id', '=', 'productos.id_tipo')
                ->leftJoin('colors', 'colors.id', '=', 'productos.id_color')
                ->where('preventas.id', $datosEnvio->idPreventa)
                ->select('productos.*', 'marcas.nombre as marca', 'tipos.nombre as tipo', 'colors.nombre as color')
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
        if ($datosEnvio->estatusRecoleccion == 4 || $datosEnvio->estatusRecoleccion == 3) {
            return redirect()->route('generarpdf.ordenservicio', ['id' => $orden_recoleccion->id]);
        } else if ($datosEnvio->estatusRecoleccion == 2  && $datosEnvio->estatusPreventa == 4) {

            return redirect()->route('generarpdf2.ordenentrega', ['id' => $orden_recoleccion->id, 'listaProductos' => $listaProductos]);
        } else if ($datosEnvio->estatusRecoleccion == 2) {

            return redirect()->route('generarpdf.ordenentrega', ['id' => $orden_recoleccion->id, 'listaProductos' => $listaProductos]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orden_recoleccion $orden_recoleccion, Request $request)
    {
        // Recuperar el ID de la orden de recolección
        $ordenRecoleccion = $orden_recoleccion;
        $estatus = $request->miSelect;
        $preventa = Preventa::where('id', $ordenRecoleccion->id_preventa)
            ->whereIn('estatus', [2, 3, 4])
            ->first();

        $cliente = clientes::where('id', $preventa->id_cliente);

        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.

        try {
            //5 pendiente 4 por recolectar, 3 revision 2 entrega 1 listo 0 eliminado
            if ($estatus == 3) {
                //cambiamos el estatus de la recoleccion
                $ordenRecoleccion->update([
                    'Fecha_recoleccion' => now(),
                    'estatus' => $estatus,
                    // Agrega aquí cualquier otro campo que desees actualizar
                ]);
            } else if ($estatus == 2) {
                $ordenRecoleccion->update([
                    'Fecha_entrega' => now(),
                    'estatus' => $estatus,
                    // Agrega aquí cualquier otro campo que desees actualizar
                ]);

                if ($preventa->estatus == 4) {

                    $preventa->update([
                        'metodo_pago' => $request->input('txtmetodoPago'),
                        'factura' => $request->input('txtfactura') == 'on' ? 1 : 0,
                        'costo_servicio' => $request->input('txtcosto'),
                    ]);

                    if ($request->input('txtfactura') == 'on') {
                        $cliente->update([
                            'comentario' => $request->input('txtrfc'),
                        ]);
                    }
                }
            } else if ($estatus == 1) {
                //actualizamos orden de recoleccion
                $ordenRecoleccion->update([
                    'estatus' => $estatus,
                    // Agrega aquí cualquier otro campo que desees actualizar
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
            ->join('empleados', 'empleados.id', '=', 'preventas.id_empleado')
            ->join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('personas as empleadoPersona', 'empleadoPersona.id', '=', 'empleados.id_persona')
            ->join('personas as clientePersona', 'clientePersona.id', '=', 'clientes.id_persona')
            ->join('roles', 'roles.id', '=', 'empleados.id_rol')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->whereIn('preventas.estatus', [3, 4]) //3 entrega, 4 servicios, 2 inconcluso, 0 eliminado
            ->where('orden_recoleccions.id', $id_recoleccion)
            ->select(
                'orden_recoleccions.id as idRecoleccion',
                'preventas.id as idPreventa',
                'preventas.estatus as estatusPreventa',
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
                ->select('productos.*', 'marcas.nombre as marca', 'tipos.nombre as tipo', 'colors.nombre as color')

                ->get();
        } else if ($datosEnvio->estatusPreventa == 4) { //leftjoin me devolvera null si no hay relaciones
            $productos = Catalago_recepcion::join('productos', 'productos.id', '=', 'catalago_recepcions.id_producto')
                ->join('servicios_preventas', 'servicios_preventas.id_producto_recepcion', '=', 'catalago_recepcions.id')
                ->join('preventas', 'preventas.id', '=', 'servicios_preventas.id_preventa')
                ->leftJoin('marcas', 'marcas.id', '=', 'productos.id_marca')
                ->leftJoin('tipos', 'tipos.id', '=', 'productos.id_tipo')
                ->leftJoin('colors', 'colors.id', '=', 'productos.id_color')
                ->where('preventas.id', $datosEnvio->idPreventa)
                ->select('productos.*', 'marcas.nombre as marca', 'tipos.nombre as tipo', 'colors.nombre as color')
                ->get();
        }

        $cancelar = Cancelaciones::all();
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

            $id->estatus = 0;
            $id->deleted_at = now();
            $id->comentario = $cancelado;
            $id->id_cancelacion = $categoriaCancelacion;
            $ordenCancelada = $id->save();

            $preventa->estatus = 0;
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orden_recoleccion $orden_recoleccion)
    {
        //
    }
}
