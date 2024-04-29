<?php

namespace App\Http\Controllers;

use App\Models\Catalago_ubicaciones;
use App\Models\clientes;
use App\Models\Color;
use App\Models\Descuentos;
use App\Models\direcciones;
use App\Models\direcciones_clientes;
use App\Models\Folio;
use App\Models\Info_tickets;
use App\Models\Marcas;
use App\Models\Modo;
use App\Models\Orden_recoleccion;
use App\Models\personas;
use App\Models\precios_productos;
use App\Models\Preventa;
use App\Models\productos;
use App\Models\TiempoAproximado;
use App\Models\Tipo;
use App\Models\ventas_productos;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                'productos.descripcion',
                'productos.modelo',
                'tipos.nombre as nombre_categoria',
                'colors.id as idColor',
                'colors.nombre as nombre_color',
                'modos.id as modo_id',
                'modos.nombre as nombre_modo',
                'marcas.nombre as nombre_marca',
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

        $HorarioTrabajo = Preventa::where('estatus', 3)
            ->whereNotNull('horario_trabajo_inicio')
            ->select('id_cliente as idCliente', 'horario_trabajo_inicio as horaInicio', 'horario_trabajo_final as horaFinal', 'dia_semana as dias', 'nombre_quien_recibe as recibe')
            ->orderBy('updated_at', 'asc')->get();


        $descuentos = Descuentos::select('*')->orderBy('nombre', 'asc')->get();

        return view('Principal.ordenEntrega.tienda', compact('productos', 'marcas', 'tipos', 'modos', 'colores', 'listaClientes', 'listaDirecciones', 'ListaColonias', 'listaAtencion', 'HorarioTrabajo', 'descuentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


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


        return view('Principal.ordenEntrega.index', compact('listaClientes', 'listaDirecciones', 'ListaColonias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /* $request->validate([
            'txtnombreCliente' => 'required',
            // otras reglas de validación...
        ], [
            'txtnombreCliente.required' => 'El nombre del cliente es obligatorio.',
            // otros mensajes personalizados...
        ]);*/

        $nombreEmpleado = Auth::user()->name;
        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.

        try {

            // si fue seleccionado el cliente y la direccion tendremos estos datos del id
            $idCliente = $request->input('cliente'); //id del cliente
            $idDireccion = $request->input('id_direccion');

            //si modificamos un dato del cliente podrian ser cualquiera de estos 3
            $telefono = $request->input('txttelefono'); //telefono del cliente
            $rfc = $request->input('txtrfc'); //rfc del cliente
            $email = $request->input('txtemail'); //correo electronico del cliente
            $recibe = $request->input('txtrecibe'); // persona que recibira el pedido

            //si registramos un cliente nuevo recibiremos
            $nuevoCliente = $request->input('txtnombreCliente'); //nombre del cliente
            $nuevoApeCliente = $request->input('txtapellidoCliente'); // apellido del cliente

            //datos que iran siempre
            $atencion = $request->input('txtatencion'); //persona que atendera cuando llegue el motociclista

            //si no tenemos datos del id direccion entonces recibiremos
            $idNuevacolonia = $request->input('nuevacolonia'); // el id de la colonia
            $nuevacalle = $request->input('nuevacalle'); //calles de la colonia
            $nuevonumInterior = $request->input('nuevonum_interior'); // numero interior del domicilio
            $nuevonumExterior = $request->input('nuevonum_exterior'); // numero exterior del domicilio
            $nuevareferencia = $request->input('nuevareferencia'); //referencia del docimicilio

            //factura, metodo de pago y horario para entregar paquete
            $factura = $request->input('factura'); //es el checkbox por si queremos factura
            $metodoPago = $request->input('metodoPago'); //metodo de pago
            $pagaCon = $request->input('pagaCon'); //paga con
            $LunesEntrada = $request->input('Lunes_entrada');
            $LunesSalida = $request->input('Lunes_salida');
            $MartesEntrada = $request->input('Martes_entrada');
            $MartesSalida = $request->input('Martes_salida');
            $MiercolesEntrada = $request->input('Miercoles_entrada');
            $MiercolesSalida = $request->input('Miercoles_salida');
            $JuevesEntrada = $request->input('Jueves_entrada');
            $JuevesSalida = $request->input('Jueves_salida');
            $ViernesEntrada = $request->input('Viernes_entrada');
            $ViernesSalida = $request->input('Viernes_salida');
            $SabadoEntrada = $request->input('Sabado_entrada');
            $SabadoSalida = $request->input('Sabado_salida');
            $DomingoEntrada = $request->input('Domingo_entrada');
            $DomingoSalida = $request->input('Domingo_salida');

            $horarioTrabajoInicio = $LunesEntrada . ',' . $MartesEntrada . ',' . $MiercolesEntrada . ',' . $JuevesEntrada . ',' . $ViernesEntrada . ',' . $SabadoEntrada . ',' . $DomingoEntrada;
            $horarioTrabajoFinal = $LunesSalida . ',' . $MartesSalida . ',' . $MiercolesSalida . ',' . $JuevesSalida . ',' . $ViernesSalida . ',' . $SabadoSalida . ',' . $DomingoSalida;


            $diasConDatos = '';

            if (!empty($LunesEntrada)) {
                $diasConDatos .= 'Lunes,';
            }
            if (!empty($MartesEntrada)) {
                $diasConDatos .= 'Martes,';
            }
            if (!empty($MiercolesEntrada)) {
                $diasConDatos .= 'Miercoles,';
            }
            if (!empty($JuevesEntrada)) {
                $diasConDatos .= 'Jueves,';
            }
            if (!empty($ViernesEntrada)) {
                $diasConDatos .= 'Viernes,';
            }
            if (!empty($SabadoEntrada)) {
                $diasConDatos .= 'Sabado,';
            }
            if (!empty($DomingoEntrada)) {
                $diasConDatos .= 'Domingo,';
            }

            // Eliminar la última coma
            $diasConDatos = rtrim($diasConDatos, ',');

            // Decodifica la cadena JSON
            $relacion = json_decode($request->input('inputProductosSeleccionados'), true);



            //crearemos una preventa con estatus 2
            $preventa = Preventa::create([
                'estatus' => 2
            ]);

            // si Seleccionaron un cliente entonces entra

            if (!is_null($idCliente) && is_numeric($idCliente)) {

                //crearemos una preventa con estatus 3
                $preventa->id_cliente = $idCliente;
                $preventa->nombre_empleado = $nombreEmpleado;
                $preventa->nombre_atencion = $atencion;
                $preventa->horario_trabajo_inicio = $horarioTrabajoInicio;
                $preventa->horario_trabajo_final = $horarioTrabajoFinal;
                $preventa->dia_semana = $diasConDatos;
                $preventa->metodo_pago = $metodoPago;
                $preventa->factura = $factura === 'on' ? 1 : 0;
                $preventa->pago_efectivo = $pagaCon;
                $preventa->estatus = 3;
                $preventa->nombre_quien_recibe = $recibe;

                $preventa->save();

                // iteramos en un forech para ir agregando los productos seleccionados en el pedido para agregarlos en ventas_productos
                foreach ($relacion as $articulo) {
                    //primero identificammos el precio del producto solicitado
                    $producto_precio = precios_productos::where('id_producto', $articulo['id'])
                        ->where('estatus', 1)
                        ->first();

                    //si descuento es null entonces valdra 0 y sin descuento para poder ingresarlo a la base de datos
                    if ($articulo['tipoDescuento'] == "null") {
                        $tipoDescuento = 'Sin descuento';
                        $descuento = 0;
                    } else {
                        $tipoDescuento =   $articulo['tipoDescuento'];
                        $descuento = $articulo['descuento'];
                    }


                    //luego buscamos los datos del producto
                    $producto = Productos::where('id', $articulo['id'])->first();
                    //ya una vez identificados le agregamos el id del precio actual y cantidad
                    $producto_venta = ventas_productos::firstOrCreate([
                        'id_precio_producto' => $producto_precio->id, //id del precio producto que esta relacionado con el producto
                        'id_preventa' => $preventa->id, //le asignamos su nummero de preventa
                        'cantidad' => $articulo['cantidad'], //le asignamos su cantidad
                        'descuento' => $descuento,
                        'tipo_descuento' => $tipoDescuento, //le asignamos Sin descuento si llega hacer null
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
                $preventa->nombre_empleado = $nombreEmpleado;
                $preventa->nombre_atencion = $atencion;
                $preventa->horario_trabajo_inicio = $horarioTrabajoInicio;
                $preventa->horario_trabajo_final = $horarioTrabajoFinal;
                $preventa->dia_semana = $diasConDatos;
                $preventa->metodo_pago = $metodoPago;
                $preventa->factura = $factura === 'on' ? 1 : 0;
                $preventa->pago_efectivo = $pagaCon;
                $preventa->estatus = 3;
                $preventa->nombre_quien_recibe = $recibe;
                // Guardar el modelo
                $preventa->save();

                // iteramos en un forech para ir agregando los productos seleccionados en el pedido para agregarlos en ventas_productos
                foreach ($relacion as $articulo) {
                    //primero identificammos el precio del producto solicitado
                    $producto_precio = precios_productos::where('id_producto', $articulo['id'])
                        ->where('estatus', 1)
                        ->first();
                    //luego buscamos los datos del producto
                    $producto = Productos::where('id', $articulo['id'])->first();

                    //si descuento es null entonces valdra 0 y sin descuento para poder ingresarlo a la base de datos
                    if ($articulo['tipoDescuento'] == "null") {
                        $tipoDescuento = 'Sin descuento';
                        $descuento = 0;
                    } else {
                        $tipoDescuento =   $articulo['tipoDescuento'];
                        $descuento = $articulo['descuento'];
                    }
                    //ya una vez identificados le agregamos el id del precio actual y cantidad
                    $producto_venta = ventas_productos::firstOrCreate([
                        'id_precio_producto' => $producto_precio->id, //id del precio producto que esta relacionado con el producto
                        'id_preventa' => $preventa->id, //le asignamos su nummero de preventa
                        'cantidad' => $articulo['cantidad'], //le asignamos su cantidad
                        'descuento' => $descuento,
                        'tipo_descuento' => $tipoDescuento, //le asignamos Sin descuento si llega hacer null
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
            //999999
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
            return $th->getMessage();

            //session()->flash("incorrect", "Error al procesar los productos, posiblemente no registro algun dato");
            //return redirect()->route('orden_entrega.index');
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
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->join('personas as personaClientes', 'personaClientes.id', '=', 'clientes.id_persona')
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
                'preventas.nombre_quien_recibe as recibe',
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
                'preventas.nombre_empleado as nombreEmpleado',
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

            )
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
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->join('personas as personaClientes', 'personaClientes.id', '=', 'clientes.id_persona')
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
            ->leftJoin('cancelaciones', 'cancelaciones.id', '=', 'orden_recoleccions.id_cancelacion')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->join('personas as personaClientes', 'personaClientes.id', '=', 'clientes.id_persona')
            ->where('orden_recoleccions.id', $id)
            ->select(
                'orden_recoleccions.id as idRecoleccion',
                'orden_recoleccions.created_at as fechaCreacion',
                'orden_recoleccions.id_cancelacion as idCancelacion',
                'orden_recoleccions.comentario as descripcionCancelacion',
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
                'preventas.nombre_quien_recibe as recibe',
                'preventas.nombre_empleado as nombreEmpleado',
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
                'cancelaciones.nombre as nombreCancelacion'
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
            ->select(
                'productos.nombre_comercial',
                'precios_productos.precio',
                'ventas_productos.cantidad',
                'ventas_productos.descuento',
                'ventas_productos.tipo_descuento as tipoDescuento',
                'colors.nombre as nombreColor',
                'marcas.nombre as nombreMarca',
                'tipos.nombre as nombreTipo',
                'modos.nombre as nombreModo'
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

        $pdf = PDF::loadView('Principal.ordenEntrega.pdf', compact(
            'ordenRecoleccion',
            'listaProductos',
            'Tiempo',
            'DatosdelNegocio'
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
