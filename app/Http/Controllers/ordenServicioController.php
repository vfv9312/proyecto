<?php

namespace App\Http\Controllers;

use App\Models\Catalago_recepcion;
use App\Models\Catalago_ubicaciones;
use App\Models\clientes;
use App\Models\Color;
use App\Models\direcciones;
use App\Models\direcciones_clientes;
use App\Models\empleados;
use App\Models\Folio;
use App\Models\Marcas;
use App\Models\Modo;
use App\Models\Orden_recoleccion;
use App\Models\personas;
use App\Models\precios_productos;
use App\Models\Preventa;
use App\Models\productos;
use App\Models\Servicios_preventas;
use App\Models\TiempoAproximado;
use App\Models\Tipo;
use App\Models\ventas_productos;
use Barryvdh\DomPDF\Facade\Pdf;
use Dotenv\Util\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ordenServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listaEmpleados = empleados::join('roles', 'roles.id', '=', 'empleados.id_rol')
            ->join('personas', 'personas.id', '=', 'empleados.id_persona')
            ->where('empleados.estatus', 1)
            ->select('empleados.id', 'roles.nombre as nombre_rol', 'personas.nombre as nombre_empleado', 'personas.apellido')
            ->get();

        $listaClientes = clientes::join('personas', 'personas.id', '=', 'clientes.id_persona')
            ->where('clientes.estatus', 1)
            ->select(
                'personas.nombre as nombre_cliente',
                'personas.apellido',
                'personas.telefono as telefono_cliente',
                'personas.email',
                'clientes.comentario',
                'clientes.id as id_cliente',
            )
            ->orderBy('clientes.updated_at', 'desc')
            ->get();

        $listaDirecciones = clientes::join('personas', 'personas.id', '=', 'clientes.id_persona')
            ->join('direcciones_clientes', 'direcciones_clientes.id_cliente', '=', 'clientes.id')
            ->join('direcciones', 'direcciones.id', '=', 'direcciones_clientes.id_direccion')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->where('clientes.estatus', 1)
            ->select(
                'catalago_ubicaciones.localidad',
                'direcciones.calle',
                'direcciones.num_exterior',
                'direcciones.num_interior',
                'direcciones.referencia',
                'clientes.id as id_cliente',
                'catalago_ubicaciones.id as id_ubicaciones',
                'direcciones_clientes.id'
            )
            ->orderBy('clientes.updated_at', 'desc')
            ->get();

        $ListaColonias = Catalago_ubicaciones::orderBy('localidad')->get();

        $listaAtencion = Preventa::select('id_cliente', 'nombre_atencion')
            ->distinct()
            ->whereNotNull('nombre_atencion')
            ->get();

        $productos = productos::join('precios_productos', 'productos.id', '=', 'precios_productos.id_producto')
            ->join('marcas', 'marcas.id', '=', 'productos.id_marca')
            ->join('tipos', 'tipos.id', '=', 'productos.id_tipo')
            ->join('colors', 'colors.id', '=', 'productos.id_color')
            ->join('modos', 'modos.id', '=', 'productos.id_modo')
            ->where('productos.estatus', 1)
            ->where('precios_productos.estatus', 1)
            // ->where('marcas.id', 'LIKE', "%{$marca}%")
            // ->where('tipos.id', 'LIKE', "%{$tipo}%")
            ->select(
                'productos.id',
                'productos.nombre_comercial',
                'tipos.nombre as nombre_categoria',
                'productos.modelo',
                'colors.id as idColor',
                'colors.nombre as nombre_color',
                'modos.id as modo_id',
                'modos.nombre as nombre_modo',
                'marcas.nombre as nombre_marca',
                'productos.fotografia',
                'precios_productos.precio',
                'marcas.id as marca_id',
                'tipos.id as tipo_id'
            )
            ->orderBy('productos.updated_at', 'desc')->get();

        $marcas = Marcas::orderBy('nombre')->get();
        $tipos = Tipo::orderBy('nombre')->get();
        $modos = Modo::orderBy('nombre')->get();
        $colores = Color::all();



        return view('Principal.ordenServicio.datos_cliente', compact('listaEmpleados', 'listaClientes', 'listaDirecciones', 'ListaColonias', 'marcas', 'modos', 'tipos', 'colores', 'listaAtencion', 'productos'));
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
        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.

        try {

            $atiende = ucwords(strtolower($request->input('txtatencion')));


            //clienteSeleccionado es el id del cliente seleccionado si elegi uno ya registrado
            $clienteSeleccionado = $request->input('cliente');
            //id_direcciones es el id de la direccion seleccionada del cliente
            $id_direcciones = $request->input('id_direccion');


            //creamos una preventa con estatus a 3
            $Preventa = Preventa::create([
                'id_empleado' => $request->input('txtempleado'),
                'estatus' => 2,
            ]);
            //



            // si clienteSeleccionado es "1" o algun numero entrara por que seleccionaron uno ya registrado
            if (!is_null($clienteSeleccionado) && is_numeric($clienteSeleccionado)) {

                //si preventa esxite que si entonces entra
                if ($Preventa) {
                    //Actualizar los campos
                    $Preventa->id_cliente = $clienteSeleccionado;
                    $Preventa->nombre_atencion = $atiende;

                    // Guardar el modelo
                    $Preventa->save();

                    //si el id_direccion existe eligieron una direccion del usuario entonces entra
                    if (!is_null($id_direcciones) && is_numeric($clienteSeleccionado)) {
                        $Preventa->id_direccion = $id_direcciones;
                        // Guardar el modelo
                        $Preventa->save();
                    } else {
                        //si no selecciono direccion creamos una nueva direccion con los datos de agregar direccion
                        $nuevaDireccion = direcciones::firstOrCreate([
                            'id_ubicacion' => $request->input('nuevacolonia'),
                            'calle' => strtolower($request->input('nuevacalle')),
                            'num_exterior' => $request->input('nuevonum_exterior'),
                            'num_interior' => $request->input('nuevonum_interior'),
                            'referencia' => strtolower($request->input('nuevareferencia')),

                        ]);
                        $ligarDireccionCliente = direcciones_clientes::firstOrCreate([
                            'id_direccion' => $nuevaDireccion->id,
                            'id_cliente' => $clienteSeleccionado,
                            'estatus' => 1
                        ]);
                        //guardamos el id de la nueva direccion en preventa
                        $Preventa->id_direccion = $nuevaDireccion->id;
                        // Guardar el modelo
                        $Preventa->save();
                    }
                }
            } else {
                //si no hay cliente seleccionado entonces crearemos uno
                //firstOrCreate de Laravel. Este método intentará encontrar un registro en la base de datos que coincida con los valores de los atributos dados. Si no se encuentra un modelo existente, se creará una nueva instancia del modelo.
                $clientePersona = personas::firstOrCreate([
                    'nombre' => ucwords(strtolower($request->input('txtnombreCliente'))),
                    'apellido' => ucwords(strtolower($request->input('txtapellidoCliente'))),
                    'telefono' => $request->input('txttelefono'),
                    'email' => strtolower($request->input('txtemail')),
                    'estatus' => 1,
                ]);


                //crearemos un cliente
                $clienteNuevo = clientes::firstOrCreate([
                    'id_persona' => $clientePersona->id,
                    'comentario' => strtoupper($request->input('txtrfc')),
                    'estatus' => 1,
                ]);
                //Preventa le asignamos el clienta nuevo
                $Preventa->id_cliente = $clienteNuevo->id;
                $Preventa->nombre_atencion = $atiende;
                // Guardar el modelo
                $Preventa->save();

                //si tiene datos cliente con colonia y calles
                if ($request->input('nuevacolonia') && $request->input('nuevacalle')) {
                    //creamos una nueva direccion
                    $nuevaDireccion = direcciones::create([
                        'id_ubicacion' => $request->input('nuevacolonia'),
                        'calle' => strtolower($request->input('nuevacalle')),
                        'num_exterior' => $request->input('nuevonum_exterior'),
                        'num_interior' => $request->input('nuevonum_interior'),
                        'referencia' => $request->input('nuevareferencia'),
                    ]);
                    //le asignamos la nueva direccion al cliente
                    $direccionNuevaCliente = direcciones_clientes::firstOrCreate([
                        'id_direccion' => $nuevaDireccion->id,
                        'id_cliente' => $clienteNuevo->id,
                        'estatus' => 1

                    ]);
                    //y le asignamos la direccion a la preventa
                    $Preventa->id_direccion = $nuevaDireccion->id;
                    // Guardar el modelo
                    $Preventa->save();
                }
            }

            $marcas = Marcas::orderBy('nombre')->get();
            $modos = Tipo::orderBy('nombre')->get();
            $tipos = Modo::all();
            $colores = Color::all();


            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.

        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            //return $th->getMessage();
        }
        return view('Principal.ordenServicio.datos_producto', compact('Preventa', 'marcas', 'modos', 'colores', 'tipos'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.

        $cantidades = $request->query('cantidad');

        try {
            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.

            $preventa = Preventa::find($id);
            $preventa->update([
                'estatus' => 4 //3 entrega y 4 servicios
            ]);

            $servicioPreventa = Servicios_preventas::where('id_preventa', $id)->get();
            foreach ($servicioPreventa as $index => $servicio) {
                if (isset($cantidades[$index])) {
                    if ($cantidades[$index] == 0) {
                        $servicio->cantidad_total = $cantidades[$index];
                        $servicio->estatus = 0;
                        $servicio->save();
                    } else {
                        $servicio->cantidad_total = $cantidades[$index];
                        $servicio->save();
                    }
                }
            }

            $ultimoFolio = Folio::orderBy('id', 'desc')->first();
            $letra = $ultimoFolio ? $ultimoFolio->letra_actual : 'A';
            $valor = $ultimoFolio ? $ultimoFolio->ultimo_valor + 1 : 1;

            if ($valor > 999999) {
                // Incrementa la letra
                $letra = chr(ord($letra) + 1);
                $valor = 1;
            }

            $folio = Folio::create([
                'letra_actual' => $letra,
                'ultimo_valor' => $valor,
            ]);


            $folio->update([
                'letra_actual' => $letra,
                'ultimo_valor' => $valor,
            ]);


            $recoleccion = Orden_recoleccion::firstOrCreate([
                'id_preventa' => $preventa->id,
                'id_folio' => $folio->id,
                'estatus' => 4, //4por recolectar, 3 revision 2 entrega 1 listo 0 eliminado
            ]);
        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            return $th->getMessage();
            //throw $th;
        }
        return redirect()->route('ordenServicio.vistaGeneral', ['id' => $recoleccion->id]);
    }
    public function vistaGeneral(Orden_recoleccion $id)
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
            ->where('orden_recoleccions.id', $id->id)
            ->select(
                'orden_recoleccions.id as idRecoleccion',
                'orden_recoleccions.created_at as fechaCreacion',
                'folios.letra_actual as letraActual',
                'folios.ultimo_valor as ultimoValor',
                'folios.created_at as fechaDelTiempoAproximado',
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

        $productos = Catalago_recepcion::join('productos', 'productos.id', '=', 'catalago_recepcions.id_producto')
            ->join('servicios_preventas', 'servicios_preventas.id_producto_recepcion', '=', 'catalago_recepcions.id')
            ->join('preventas', 'preventas.id', '=', 'servicios_preventas.id_preventa')
            ->leftJoin('marcas', 'marcas.id', '=', 'productos.id_marca')
            ->leftJoin('tipos', 'tipos.id', '=', 'productos.id_tipo')
            ->leftJoin('colors', 'colors.id', '=', 'productos.id_color')
            ->leftJoin('modos', 'modos.id', '=', 'productos.id_modo')
            ->where('preventas.id', $id->id_preventa)
            ->where('servicios_preventas.estatus', 2)
            ->select(
                'productos.id',
                'productos.nombre_comercial',
                'marcas.nombre as marca',
                'tipos.nombre as tipo',
                'colors.nombre as color',
                'modos.nombre as modo',
                'servicios_preventas.cantidad_total',
                'productos.descripcion',
            )
            ->get();

        return view('Principal.ordenServicio.orden_completada', compact('productos', 'ordenRecoleccion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.

        try {

            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.

            $idPreventa = $id;
            $nombre_comercial = $request->input('txtnombre_comercial');
            $color = $request->input('txtcolor');
            $tipo = $request->input('txttipo');
            $marca = $request->input('txtmarca');
            $descripcion = $request->input('txtdescripcion');
            $cantidad = $request->input('txtcantidad');
            $modo = $request->input('txtmodo');

            // Insertar en la tabla 'productos'
            $producto = productos::create([
                'nombre_comercial' => $nombre_comercial,
                'modelo' => $request->txtmodelo,
                'id_color' => $color,
                'id_tipo' => $tipo,
                'id_modo' => $modo,
                'id_marca' => $marca,
                'descripcion' => $descripcion,
                'fotografia' => null,
                'estatus' => 2
            ]);

            $catalago = Catalago_recepcion::firstOrCreate([
                'id_producto' => $producto->id,
                'estatus' => 2
            ]);

            $preventa_servicios = Servicios_preventas::firstOrCreate([
                'id_preventa' => $idPreventa,
                'id_producto_recepcion' => $catalago->id,
                'cantidad_total' => $cantidad,
                'estatus' => 2,
            ]);

            $marcas = Marcas::orderBy('nombre')->get();
            $modos = Tipo::orderBy('nombre')->get();
            $colores = Color::all();
            $tipos = Modo::all();


            $Preventa = Preventa::find($id);
        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            return $th->getMessage();
        }

        return view('Principal.ordenServicio.datos_producto', compact('Preventa', 'marcas', 'modos', 'colores', 'tipos'));

        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.

        try {

            $preventa = Preventa::find($id);

            $productos = Catalago_recepcion::join('productos', 'productos.id', '=', 'catalago_recepcions.id_producto')
                ->join('servicios_preventas', 'servicios_preventas.id_producto_recepcion', '=', 'catalago_recepcions.id')
                ->join('preventas', 'preventas.id', '=', 'servicios_preventas.id_preventa')
                ->leftJoin('marcas', 'marcas.id', '=', 'productos.id_marca')
                ->leftJoin('tipos', 'tipos.id', '=', 'productos.id_tipo')
                ->leftJoin('colors', 'colors.id', '=', 'productos.id_color')
                ->leftJoin('modos', 'modos.id', '=', 'productos.id_modo')
                ->where('preventas.id', $id)
                ->where('servicios_preventas.estatus', 2)
                ->select(
                    'productos.id',
                    'productos.nombre_comercial',
                    'marcas.nombre as marca',
                    'tipos.nombre as tipo',
                    'colors.nombre as color',
                    'modos.nombre as modo',
                    'servicios_preventas.cantidad_total',
                    'servicios_preventas.descripcion',
                )
                ->get();



            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            return $th->getMessage();
        }

        return view('Principal.ordenServicio.carrito', compact('productos', 'preventa'));
    }

    public function generarPdf(Orden_recoleccion $id)
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
            ->where('orden_recoleccions.id', $id->id)
            ->select(
                'orden_recoleccions.id as idRecoleccion',
                'orden_recoleccions.created_at as fechaCreacion',
                'folios.letra_actual as letraActual',
                'folios.ultimo_valor as ultimoValor',
                'folios.created_at as fechaDelTiempoAproximado',
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

        $listaProductos = Catalago_recepcion::join('productos', 'productos.id', '=', 'catalago_recepcions.id_producto')
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

        $fechaCreacion = \Carbon\Carbon::parse($ordenRecoleccion->fechaCreacion);

        $Tiempo = TiempoAproximado::whereDate('created_at', $fechaCreacion->toDateString())->orderBy('created_at', 'desc')->first();

        $largoDelTicket = 700; // Inicializa la variable


        if ($listaProductos->count() > 1) {
            $extra = max(0, $listaProductos->count() - 1);
            $largoDelTicket += $extra * 50;
        }

        $pdf = PDF::loadView('Principal.ordenServicio.pdf', compact('listaProductos', 'ordenRecoleccion', 'Tiempo'));

        // Establece el tamaño del papel a 80mm de ancho y 200mm de largo
        $pdf->setPaper([0, 0, 226.77, $largoDelTicket], 'portrait'); // 80mm x 200mm en puntos

        // Renderiza el documento PDF y lo envía al navegador
        return $pdf->stream();
    }

    public function vistaPrevia(string $id)
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

        return view('Principal.ordenServicio.vista_previa', compact('productos', 'ordenRecoleccion'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
