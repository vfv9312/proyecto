<?php

namespace App\Http\Controllers;

use App\Models\Catalago_recepcion;
use App\Models\Catalago_ubicaciones;
use App\Models\clientes;
use App\Models\Color;
use App\Models\Descuentos;
use App\Models\direcciones;
use App\Models\direcciones_clientes;
use App\Models\Folio;
use App\Models\Folio_servicios;
use App\Models\Info_tickets;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class ordenServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
                'direcciones_clientes.id',
                'direcciones_clientes.id_direccion',
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
            ->where('productos.estatus', 2)
            ->where('precios_productos.estatus', 2)
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

        $datosRecoleccion = Preventa::where('estatus', 4)
            ->whereNotNull('nombre_quien_recibe')
            ->select('id_cliente as idCliente', 'nombre_quien_recibe as recibe', 'nombre_quien_entrega as entrega')
            ->orderBy('updated_at', 'asc')->get();


        $descuentos = Descuentos::select('*')->orderBy('nombre', 'asc')->get();


        return view('Principal.ordenServicio.tienda', compact('listaClientes', 'listaDirecciones', 'ListaColonias', 'marcas', 'modos', 'tipos', 'colores', 'listaAtencion', 'productos', 'datosRecoleccion', 'descuentos'));
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
            // si fue seleccionado el cliente y la direccion tendremos estos datos del id
            $idCliente = $request->input('cliente');
            $nuevaDireccion = $request->input('id_direccion');

            //si modificamos un dato del cliente podrian ser cualquiera de estos 3
            $telefono = $request->input('txttelefono');
            $rfc = strtoupper($request->input('txtrfc'));
            $email = $request->input('txtemail');
            $recibe = strtoupper($request->input('txtrecibe'));
            $entrega = strtoupper($request->input('txtentrega'));

            //si registramos un cliente nuevo recibiremos
            $nuevoCliente = $request->input('txtnombreCliente');
            $nuevoApeCliente = $request->input('txtapellidoCliente');

            //datos que iran siempre
            $atencion = strtoupper($request->input('txtatencion'));
            $nombreEmpleado = strtoupper(Auth::user()->name);

            //si no tenemos datos del id direccion entonces recibiremos
            $idNuevacolonia = $request->input('nuevacolonia');
            $nuevacalle = $request->input('nuevacalle');
            $nuevonumInterior = $request->input('nuevonum_interior');
            $nuevonumExterior = $request->input('nuevonum_exterior');
            $nuevareferencia = $request->input('nuevareferencia');

            //datos adicionales
            $observaciones = strtoupper($request->input('observaciones'));
            $numeroRecargas = $request->input('numero_regarcas');
            $codigo = strtoupper($request->input('numero_regarcas'));

            //factura, metodo de pago y horario para entregar paquete
            $factura = $request->input('factura');
            $metodoPago = $request->input('metodoPago');
            $pagaCon = $request->input('pagaCon');
            $pagaRecarga = $request->input('pagaConRecarga'); //el pago de una recarga

            // Decodifica la cadena JSON
            $relacion = json_decode($request->input('inputProductosSeleccionados'), true);




            if ($idCliente == "null") {
                $clientePersona = personas::create([
                    'nombre' => strtoupper($nuevoCliente),
                    'apellido' => strtoupper($nuevoApeCliente),
                    'telefono' => $telefono,
                    'email' => strtolower($email),
                    'estatus' => 1,
                    // ...otros campos aquí...
                ]);

                if ($nuevoApeCliente) {
                    //si tiene apellido no es necesario guardar de nuevo
                } else { //si no tiene apellidos entonces es una emprea y debemos colocar un .
                    $clientePersona->update([
                        'nombre' => strtoupper($nuevoCliente),
                        'apellido' => '.',
                    ]);
                }

                //creamos un persona y lo agregamos
                $clienteNuevo = clientes::create([
                    'id_persona' => $clientePersona->id,
                    'comentario' => strtoupper($rfc),
                    'estatus' => 1,
                ]);

                //le pasamos el id del cliente nuevo para guardar posterior en la compra
                $idCliente = $clienteNuevo->id;
            }

            //si no hay id de direccion entonces se crea una
            if (is_null($nuevaDireccion)) {

                $direccion = direcciones::create([
                    'id_ubicacion' => $idNuevacolonia,
                    'calle' => $nuevacalle,
                    'num_exterior' => $nuevonumExterior,
                    'num_interior' => $nuevonumInterior,
                    'referencia' => strtolower($nuevareferencia),
                ]);

                // se relaciona con el cliente para que este cliente ya tenga agregado esta direccion en su cuenta
                $direccionNuevaCliente = direcciones_clientes::create([
                    'id_direccion' => $direccion->id,
                    'id_cliente' => $idCliente,
                    'estatus' => 1

                ]);
                //le pasamos a nueva direccion el valor de la nueva direccion
                $nuevaDireccion = $direccion->id;
            }

            $data = [
                'idCliente' =>  $idCliente,
                'nombreEmpleado' => $nombreEmpleado,
                'atencion' => $atencion,
                'observacion' => $observaciones,
                'codigo' => $codigo,
                'numero_recarga' => $numeroRecargas,
                'metodoPago' => $metodoPago,
                'factura' => $factura,
                'pagaCon' => $pagaCon,
                'recibe' => $recibe,
                'entrega' => $entrega,
                'nuevaDireccion' => $nuevaDireccion,
                'pagaRecarga' => $pagaRecarga,
            ];



            $preventaServicio = null;
            // iteramos en un forech para ir agregando los productos seleccionados en el pedido para agregarlos en ventas_productos
            foreach ($relacion as $articulo) {

                //si descuento es null entonces valdra 0 y sin descuento para poder ingresarlo a la base de datos
                switch ($articulo['tipoDescuento']) {
                    case 'cantidad':
                        $cuantoEsDeDescuento = $articulo['descuento'] * $articulo['cantidad'];
                        $valorDescuento = ($articulo['cantidad'] * $articulo['precio']) - $cuantoEsDeDescuento;
                        $tipoDescuento =   $articulo['tipoDescuento'];
                        $descuento = $articulo['descuento'];
                        break;

                    case 'Porcentaje':
                        $descuentoDividido =  intval($articulo['descuento']) / 100;
                        $valorDescuento = (intval($articulo['cantidad']) * $articulo['precio']) * (1 - $descuentoDividido);
                        $tipoDescuento =   $articulo['tipoDescuento'];
                        $descuento = $articulo['descuento'];
                        break;
                    case 'alternativo':
                        $cuantoEsDeDescuento = $articulo['descuento'] - $articulo['precio'];
                        $valorDescuento = $articulo['descuento'] * $articulo['cantidad'];
                        $tipoDescuento =   $articulo['tipoDescuento'];
                        $descuento = $articulo['descuento'];
                        break;

                    default:
                        $valorDescuento = $articulo['cantidad'] * $articulo['precio'];
                        $tipoDescuento = 'Sin descuento';
                        $descuento = 0;
                        break;
                }

                switch ($articulo['estatus']) {
                    case '1':
                        $producto_venta = 'error';
                        break;

                    case '2':

                        $preventaServicio = is_null($preventaServicio) ? $this->savePresale('Servicio', 'Recolectar', $data) : $preventaServicio;

                        //ya una vez identificados le agregamos el id del precio actual y cantidad
                        $servicio_venta = Servicios_preventas::firstOrCreate([
                            'id_precio_producto' => $articulo['idPrecio'], //id del precio producto que esta relacionado con el producto
                            'id_preventa' => $preventaServicio->id, //le asignamos su nummero de preventa
                            'descuento' => $descuento,
                            'precio_unitario' => $valorDescuento,
                            'tipo_descuento' => $tipoDescuento,
                            'cantidad' => $articulo['cantidad'],  //borrar cuando cargue el migration
                            'cantidad_total' => $articulo['cantidad'], //le asignamos su cantidad
                            'estatus' => 1 //le asignamos estatus 1
                        ]);
                        break;

                    default:
                        $producto_venta = 'error';
                        break;
                }
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


            $folioServicio =  $this->folioServicio();

            $Ordenderecoleccion = Orden_recoleccion::create([
                'id_preventaServicio' => $preventaServicio->id,
                'id_folio_servicio' => $folioServicio->id,

            ]);


            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.

        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            return $th->getMessage();
            session()->flash("incorrect", "Error al procesar los productos, posiblemente no registro algun dato");
            return redirect()->route('orden_servicio.index');
        }
        // Redirecciona al usuario a una página de vista de resumen o éxito
        // Redirecciona al usuario a una página de vista de resumen o éxito
        return redirect()->route('ordenServicio.vistaGeneral', ['id' => $preventaServicio->id]);
    }

    public function savePresale($tipodeVenta, $estatus, $data)
    {

        //crearemos una preventa con estatus 3
        $preventa = new Preventa();
        $preventa->id_cliente = $data['idCliente'];
        $preventa->nombre_empleado = $data['nombreEmpleado'];
        $preventa->nombre_atencion = $data['atencion'];
        $preventa->observacion = $data['observacion'];
        $preventa->codigo = $data['codigo'];
        $preventa->numero_recarga = $data['numero_recarga'];
        $preventa->metodo_pago = $data['metodoPago'];
        $preventa->factura = $data['factura'] === 'on' ? 1 : 0;
        $preventa->pago_efectivo = $estatus === 3 ? $data['pagaCon'] : $data['pagaRecarga'];
        $preventa->tipo_de_venta = $tipodeVenta;
        $preventa->estado = $estatus;
        $preventa->nombre_quien_recibe = $data['recibe'];
        $preventa->nombre_quien_entrega = $data['entrega'];
        $preventa->id_direccion = $data['nuevaDireccion'];
        $preventa->save();

        return $preventa;
    }
    public function folioServicio()
    {
        $ultimoFolio = Folio_servicios::orderBy('id', 'desc')->first();

        $valor = $ultimoFolio ? $ultimoFolio->ultimo_valor + 1 : 1;

        //999999
        if ($valor > 999999) {
            $valor = 1;
        }

        $folio = Folio_servicios::create([
            'ultimo_valor' => $valor,
        ]);


        $folio->update([
            'ultimo_valor' => $valor,
        ]);

        return $folio;
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
    public function vistaGeneral(Preventa $id)
    {


        $ordenRecoleccion = Preventa::join('orden_recoleccions', 'orden_recoleccions.id_preventaServicio', '=',  'preventas.id')
            ->leftjoin('folios_servicios', 'folios_servicios.id', '=', 'orden_recoleccions.id_folio_servicio')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->join('personas as personaClientes', 'personaClientes.id', '=', 'clientes.id_persona')
            ->where('preventas.id', $id->id)
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

        return view('Principal.ordenServicio.orden_completada', compact('listaProductos', 'ordenRecoleccion'));
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

        $ordenRecoleccion = Orden_recoleccion::join('preventas', 'preventas.id', '=', 'orden_recoleccions.id_preventaServicio')
            ->leftjoin('folios_servicios', 'folios_servicios.id', '=', 'orden_recoleccions.id_folio_servicio')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->join('personas as personaClientes', 'personaClientes.id', '=', 'clientes.id_persona')
            ->where('orden_recoleccions.id', $id->id)
            ->select(
                'orden_recoleccions.id as idRecoleccion',
                'orden_recoleccions.created_at as fechaCreacion',
                'orden_recoleccions.estatus',
                'orden_recoleccions.id_cancelacion as idCancelacion',
                'folios_servicios.ultimo_valor as ultimoValor',
                'folios_servicios.created_at as fechaDelTiempoAproximado',
                'preventas.metodo_pago as metodoPago',
                'preventas.id as idPreventa',
                'preventas.factura',
                'preventas.pago_efectivo as pagoEfectivo',
                'preventas.nombre_atencion as nombreAtencion',
                'preventas.nombre_quien_recibe as nombreRecibe',
                'preventas.nombre_quien_entrega as nombreEntrega',
                'preventas.horario_trabajo_inicio as horarioTrabajoInicio',
                'preventas.horario_trabajo_final as horarioTrabajoFinal',
                'preventas.dia_semana as diaSemana',
                'preventas.codigo',
                'preventas.numero_recarga as nRecarga',
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

        $listaProductos = Servicios_preventas::join('precios_productos', 'precios_productos.id', '=', 'servicios_preventas.id_precio_producto')
            ->join('preventas', 'preventas.id', '=', 'servicios_preventas.id_preventa')
            ->join('productos', 'productos.id', '=', 'precios_productos.id_producto')
            ->leftJoin('marcas', 'marcas.id', '=', 'productos.id_marca')
            ->leftJoin('tipos', 'tipos.id', '=', 'productos.id_tipo')
            ->leftJoin('colors', 'colors.id', '=', 'productos.id_color')
            ->leftJoin('modos', 'modos.id', '=', 'productos.id_modo')
            ->where('preventas.id', $ordenRecoleccion->idPreventa)
            ->select(
                'productos.nombre_comercial',
                'productos.descripcion',
                'modos.nombre as nombreModo',
                'servicios_preventas.cantidad_total as cantidad',
                'marcas.nombre as nombreMarca',
                'tipos.nombre as nombreTipo',
                'colors.nombre as nombreColor',
                'servicios_preventas.precio_unitario as precio',
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

        $pdf = PDF::loadView('Principal.ordenServicio.pdf', compact('listaProductos', 'ordenRecoleccion', 'Tiempo', 'DatosdelNegocio'));

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
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->join('personas as personaClientes', 'personaClientes.id', '=', 'clientes.id_persona')
            ->where('orden_recoleccions.id', $id)
            ->select(
                'orden_recoleccions.id as idRecoleccion',
                'orden_recoleccions.created_at as fechaCreacion',
                'orden_recoleccions.estatus',
                'orden_recoleccions.id_cancelacion as idCancelacion',
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
