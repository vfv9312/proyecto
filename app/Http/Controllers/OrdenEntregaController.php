<?php

namespace App\Http\Controllers;

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
use App\Models\TiempoAproximado;
use App\Models\Tipo;
use App\Models\ventas;
use App\Models\ventas_productos;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenEntregaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $marca = $request->marca;
        $tipo = $request->tipo;

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

        // clientes

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

        return view('Principal.ordenEntrega.tienda', compact('productos', 'marcas', 'tipos', 'modos', 'colores', 'listaEmpleados', 'listaClientes', 'listaDirecciones', 'ListaColonias', 'listaAtencion'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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


        return view('Principal.ordenEntrega.index', compact('listaEmpleados', 'listaClientes', 'listaDirecciones', 'ListaColonias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.

        try {
            // si fue seleccionado el cliente y la direccion tendremos estos datos del id
            $idCliente = $request->input('cliente');
            $idDireccion = $request->input('id_direccion');

            //si modificamos un dato del cliente podrian ser cualquiera de estos 3
            $telefono = $request->input('txttelefono');
            $rfc = $request->input('txtrfc');
            $email = $request->input('txtemail');

            //si registramos un cliente nuevo recibiremos
            $nuevoCliente = $request->input('txtnombreCliente');
            $nuevoApeCliente = $request->input('txtapellidoCliente');

            //datos que iran siempre
            $atencion = $request->input('txtatencion');
            $idEmpleado = $request->input('txtempleado');

            //si no tenemos datos del id direccion entonces recibiremos
            $idNuevacolonia = $request->input('nuevacolonia');
            $nuevacalle = $request->input('nuevacalle');
            $nuevonumInterior = $request->input('nuevonum_interior');
            $nuevonumExterior = $request->input('nuevonum_exterior');
            $nuevareferencia = $request->input('nuevareferencia');

            //factura, metodo de pago y horario para entregar paquete
            $factura = $request->input('factura');
            $metodoPago = $request->input('metodoPago');
            $pagaCon = $request->input('pagaCon');
            $horarioTrabajoInicio = $request->input('horarioTrabajoInicio');
            $horarioTrabajoFinal = $request->input('horarioTrabajoFinal');
            $diasHorarioTrabajo = $request->input('dias');


            // Datos del id de productos y su cantidad podria mejorarse para no enviar dos array para enviar todo
            $producto_ids = $request->input('producto_id');
            $cantidades = $request->input('cantidad');
            //creamos un array vacio para juntar los productos con su cantidad
            $relacion = [];
            //un for que al ir iterando va confirmando con un if si cantidad tienen algun numero mayor a 0 entonces lo une
            for ($i = 0; $i < count($producto_ids); $i++) {
                if ($cantidades[$i] > 0) {
                    $relacion[$producto_ids[$i]] = $cantidades[$i];
                }
            }

            //crearemos una preventa con estatus 3
            $preventa = Preventa::create([
                'estatus' => 2
            ]);

            // si Seleccionaron un cliente entonces entra

            if (!is_null($idCliente) && is_numeric($idCliente)) {

                //crearemos una preventa con estatus 3
                $preventa->id_cliente = $idCliente;
                $preventa->id_empleado = $idEmpleado;
                $preventa->nombre_atencion = $atencion;
                $preventa->horario_trabajo_inicio = $horarioTrabajoInicio;
                $preventa->horario_trabajo_final = $horarioTrabajoFinal;
                $preventa->dia_semana = implode(',', $diasHorarioTrabajo);
                $preventa->metodo_pago = $metodoPago;
                $preventa->factura = $factura === 'on' ? 1 : 0;
                $preventa->pago_efectivo = $pagaCon;
                $preventa->estatus = 3;

                $preventa->save();

                // iteramos en un forech para ir agregando los productos seleccionados en el pedido para agregarlos en ventas_productos
                foreach ($relacion as $id_Producto => $cantidad) {
                    //primero identificammos el precio del producto solicitado
                    $producto_precio = precios_productos::where('id_producto', $id_Producto)
                        ->where('estatus', 1)
                        ->first();
                    //luego buscamos los datos del producto
                    $producto = Productos::where('id', $id_Producto)->first();
                    //ya una vez identificados le agregamos el id del precio actual y cantidad
                    $producto_venta = ventas_productos::firstOrCreate([
                        'id_precio_producto' => $producto_precio->id, //id del precio producto que esta relacionado con el producto
                        'id_preventa' => $preventa->id, //le asignamos su nummero de preventa
                        'cantidad' => $cantidad, //le asignamos su cantidad
                        'estatus' => 3 //le asignamos estatus 3
                    ]);
                }


                $cliente = Clientes::find($idCliente);
                $ubicarpersona = personas::find($cliente->id_persona);

                $cliente->update([
                    'comentario' => strtoupper($rfc),
                ]);

                $ubicarpersona->update([
                    'telefono' => $telefono,
                    'email' => strtolower($email),
                ]);


                //si el id_direccion  eligieron una direccion del usuario encontes entra
                if (!is_null($idDireccion) && is_numeric($idDireccion)) {
                    $preventa->id_direccion = $idDireccion;
                    // Guardar el modelo
                    $preventa->save();
                } else {

                    $nuevaDireccion = direcciones::create([
                        'id_ubicacion' => $idNuevacolonia,
                        'calle' => $nuevacalle,
                        'num_exterior' => $nuevonumExterior,
                        'num_interior' => $nuevonumInterior,
                        'referencia' => strtolower($nuevareferencia),
                    ]);
                    $ligarDireccionCliente = direcciones_clientes::create([
                        'id_direccion' => $nuevaDireccion->id,
                        'id_cliente' => $idCliente,
                        'estatus' => 1
                    ]);

                    $preventa->id_direccion = $nuevaDireccion->id;
                    // Guardar el modelo
                    $preventa->save();
                }
            } else {

                $clientePersona = personas::create([
                    'nombre' => ucwords(strtolower($nuevoCliente)),
                    'apellido' => ucwords(strtolower($nuevoApeCliente)),
                    'telefono' => $telefono,
                    'email' => strtolower($email),
                    'estatus' => 1,
                    // ...otros campos aquí...
                ]);


                $clienteNuevo = clientes::create([
                    'id_persona' => $clientePersona->id,
                    'comentario' => strtoupper($rfc),
                    'estatus' => 1,
                ]);

                $preventa->id_cliente = $clienteNuevo->id;
                $preventa->id_empleado = $idEmpleado;
                $preventa->nombre_atencion = $atencion;
                $preventa->horario_trabajo_inicio = $horarioTrabajoInicio;
                $preventa->horario_trabajo_final = $horarioTrabajoFinal;
                $preventa->dia_semana = implode(',', $diasHorarioTrabajo);
                $preventa->metodo_pago = $metodoPago;
                $preventa->factura = $factura === 'on' ? 1 : 0;
                $preventa->pago_efectivo = $pagaCon;
                $preventa->estatus = 3;
                // Guardar el modelo
                $preventa->save();

                // iteramos en un forech para ir agregando los productos seleccionados en el pedido para agregarlos en ventas_productos
                foreach ($relacion as $id_Producto => $cantidad) {
                    //primero identificammos el precio del producto solicitado
                    $producto_precio = precios_productos::where('id_producto', $id_Producto)
                        ->where('estatus', 1)
                        ->first();
                    //luego buscamos los datos del producto
                    $producto = Productos::where('id', $id_Producto)->first();
                    //ya una vez identificados le agregamos el id del precio actual y cantidad
                    $producto_venta = ventas_productos::firstOrCreate([
                        'id_precio_producto' => $producto_precio->id, //id del precio producto que esta relacionado con el producto
                        'id_preventa' => $preventa->id, //le asignamos su nummero de preventa
                        'cantidad' => $cantidad, //le asignamos su cantidad
                        'estatus' => 3 //le asignamos estatus 3
                    ]);
                }

                if ($request->input('nuevacolonia') && $request->input('nuevacalle')) {

                    $nuevaDireccion = direcciones::create([
                        'id_ubicacion' => $idNuevacolonia,
                        'calle' => $nuevacalle,
                        'num_exterior' => $nuevonumExterior,
                        'num_interior' => $nuevonumInterior,
                        'referencia' => strtolower($nuevareferencia),
                    ]);


                    $direccionNuevaCliente = direcciones_clientes::create([
                        'id_direccion' => $nuevaDireccion->id,
                        'id_cliente' => $clienteNuevo->id,
                        'estatus' => 1

                    ]);

                    $preventa->id_direccion = $nuevaDireccion->id;
                    // Guardar el modelo
                    $preventa->save();
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

            $Ordenderecoleccion = Orden_recoleccion::create([
                'id_preventa' => $preventa->id,
                'id_folio' => $folio->id,
                'estatus' => 2 //5 pendiente 4 por recolectar, 3 revision 2 entrega 1 listo 0 eliminado
            ]);



            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.

        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            //return $th->getMessage();
            session()->flash("incorrect", "Error al procesar los productos, posiblemente no registro productos");
            return redirect()->route('inicio.index');
        }
        // Redirecciona al usuario a una página de vista de resumen o éxito
        return redirect()->route('orden_recoleccion.vistaPreviaOrdenEntrega', $preventa->id); // Reemplaza 'ruta.nombre' con el nombre real de la ruta a la que deseas redirigir
    }
    public function VistaPrevioOrdenEntrega($id)
    {

        //busco si ya existe una orden de recoleccion
        $Ordenderecoleccion = Orden_recoleccion::where('id_preventa', $id)
            ->first();

        $ordenRecoleccion = Orden_recoleccion::join('preventas', 'preventas.id', '=', 'orden_recoleccions.id_preventa')
            ->join('folios', 'folios.id', '=', 'orden_recoleccions.id_folio')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('empleados', 'empleados.id', '=', 'preventas.id_empleado')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->join('personas as personaClientes', 'personaClientes.id', '=', 'clientes.id_persona')
            ->join('personas as personaEmpleado', 'personaEmpleado.id', '=', 'empleados.id_persona')
            ->join('roles', 'roles.id', '=', 'empleados.id_rol')
            ->where('orden_recoleccions.id', $Ordenderecoleccion->id)
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
                'personaEmpleado.nombre as nombreEmpleado',
                'personaEmpleado.apellido as apellidoEmpleado',
                'personaEmpleado.telefono as telefonoEmpleado',
                'roles.nombre as nombreRol',
            )
            ->first();


        $listaProductos = precios_productos::join('ventas_productos', 'ventas_productos.id_precio_producto', '=', 'precios_productos.id')
            ->join('preventas', 'preventas.id', '=', 'ventas_productos.id_preventa')
            ->join('productos', 'productos.id', '=', 'precios_productos.id_producto')
            ->where('preventas.id', $id)
            ->select('productos.nombre_comercial', 'precios_productos.precio', 'ventas_productos.cantidad')
            ->get();


        return view('Principal.ordenEntrega.orden_completa', compact('ordenRecoleccion', 'listaProductos'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $orden_recoleccion)
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
            ->where('orden_recoleccions.id', $orden_recoleccion)
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

        return view('Principal.ordenEntrega.vista_previa', compact('ordenRecoleccion', 'listaProductos', 'Tiempo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    public function generarPdf($id)
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
            ->where('orden_recoleccions.id', $id)
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

        $largoDelTicket = 700; // Inicializa la variable


        if ($listaProductos->count() > 1) {
            $extra = max(0, $listaProductos->count() - 1);
            $largoDelTicket += $extra * 50;
        }

        $pdf = PDF::loadView('Principal.ordenEntrega.pdf', compact(
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
