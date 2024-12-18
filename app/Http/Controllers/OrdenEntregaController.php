<?php

namespace App\Http\Controllers;

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
use App\Models\Metodo_pago;
use App\Models\ventas_servicios;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;
use function PHPUnit\Framework\isNull;

class OrdenEntregaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $marca = $request->marca;
        $tipo = $request->tipo;

        $metodosDePagos = Metodo_pago::where('estatus','Activo')->get();
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
                'clientes.clave'
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

        $HorarioTrabajo = Preventa::where('tipo_de_venta', 'Entrega')
            ->whereNotNull('horario_trabajo_inicio')
            ->select('id_cliente as idCliente', 'horario_trabajo_inicio as horaInicio', 'horario_trabajo_final as horaFinal', 'dia_semana as dias', 'nombre_quien_recibe as recibe')
            ->orderBy('updated_at', 'asc')->get();


        $descuentos = Descuentos::select('*')->orderBy('nombre', 'asc')->get();

        return view('Principal.ordenEntrega.tienda', compact('marcas', 'tipos', 'modos', 'colores', 'listaClientes', 'listaDirecciones', 'ListaColonias', 'listaAtencion', 'HorarioTrabajo', 'descuentos','metodosDePagos'));
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

        $nombreEmpleado = strtoupper(Auth::user()->name);
        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.

        try {

            // si fue seleccionado el cliente y la direccion tendremos estos datos del id
            $idCliente = $request->input('cliente'); //id del cliente
            $nuevaDireccion = $request->input('id_direccion');
            $clave = $request->input('txtclave');
            $ProductooRecoleccion = $request->input('inputcheckProductooRecoleccion');

            //si modificamos un dato del cliente podrian ser cualquiera de estos 3
            $telefono = $request->input('txttelefono'); //telefono del cliente
            $rfc = $request->input('txtrfc'); //rfc del cliente
            $email = $request->input('txtemail'); //correo electronico del cliente
            $recibe = strtoupper($request->input('txtrecibe')); // persona que recibira el pedido

            //si registramos un cliente nuevo recibiremos
            $nuevoCliente = $request->input('txtnombreCliente'); //nombre del cliente
            $nuevoApeCliente = $request->input('txtapellidoCliente'); // apellido del cliente

            //datos que iran siempre
            $atencion = strtoupper($request->input('txtatencion')); //persona que atendera cuando llegue el motociclista

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
            $pagaRecarga = $request->input('pagaConRecarga'); //el pago de una recarga
            $LunesEntrada = $request->input('Lunes-Viernes_entrada');
            $LunesSalida = $request->input('Lunes-Viernes_salida');
            $SabadoEntrada = $request->input('Sabado_entrada');
            $SabadoSalida = $request->input('Sabado_salida');
            $DomingoEntrada = $request->input('Domingo_entrada');
            $DomingoSalida = $request->input('Domingo_salida');
            $LunesDiscontinuoEntrada = $request->input('Lunes-ViernesDiscontinuo_entrada');
            $LunesDiscontinuoSalida = $request->input('Lunes-ViernesDiscontinuo_salida');
            $SabadoDiscontinuoEntrada = $request->input('SabadoDiscontinuo_entrada');
            $SabadoDiscontinuoSalida = $request->input('SabadoDiscontinuo_salida');
            $DomingoDiscontinuoEntrada = $request->input('DomingoDiscontinuo_entrada');
            $DomingoDiscontinuoSalida = $request->input('DomingoDiscontinuo_salida');

            $horarioTrabajoInicio = $LunesEntrada . ',' . $SabadoEntrada . ',' . $DomingoEntrada . ',' . $LunesDiscontinuoEntrada . ',' . $SabadoDiscontinuoEntrada . ',' . $DomingoDiscontinuoEntrada;
            $horarioTrabajoFinal = $LunesSalida . ',' . $SabadoSalida . ',' . $DomingoSalida . ',' . $LunesDiscontinuoSalida . ',' . $SabadoDiscontinuoSalida . ',' . $DomingoDiscontinuoSalida;


            $diasConDatos = '';

            if (!empty($LunesEntrada)) {
                $diasConDatos .= 'Lunes-Viernes,';
            }

            if (!empty($SabadoEntrada)) {
                $diasConDatos .= 'Sabado,';
            }
            if (!empty($DomingoEntrada)) {
                $diasConDatos .= 'Domingo,';
            }
            if (!empty($LunesDiscontinuoEntrada)){
                $diasConDatos .= 'Lunes-ViernesDiscontinuo,';
            }
            if (!empty($SabadoDiscontinuoEntrada)){
                $diasConDatos .= 'SabadoDiscontinuo,';
            }
            if (!empty($DomingoDiscontinuoEntrada)){
                $diasConDatos .= 'DomingoDiscontinuo,';
            }

            // Eliminar la última coma
            $diasConDatos = rtrim($diasConDatos, ',');

            // Decodifica la cadena JSON
            $relacion = json_decode($request->input('inputProductosSeleccionados'), true);



            // si Seleccionaron un cliente entonces entra

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
                    //si tiene apellido no es necesario guardar de nuevo por que es minuscula y mayuscula
                } else {
                    $clientePersona->update([
                        'nombre' => strtoupper($nuevoCliente),
                        'apellido' => '.',
                    ]);
                }


                $clienteNuevo = clientes::create([
                    'id_persona' => $clientePersona->id,
                    'comentario' => strtoupper($rfc),
                    'clave' => $clave,
                    'estatus' => 1,
                ]);


                $idCliente = $clienteNuevo->id;
            }

            if (is_null($nuevaDireccion)) {

                $direccion = direcciones::create([
                    'id_ubicacion' => $idNuevacolonia,
                    'calle' => $nuevacalle,
                    'num_exterior' => $nuevonumExterior,
                    'num_interior' => $nuevonumInterior,
                    'referencia' => strtolower($nuevareferencia),
                ]);


                $direccionNuevaCliente = direcciones_clientes::create([
                    'id_direccion' => $direccion->id,
                    'id_cliente' => $idCliente,
                    'estatus' => 1

                ]);

                $nuevaDireccion = $direccion->id;
            }


            $data = [
                'idCliente' =>  $idCliente,
                'nombreEmpleado' => $nombreEmpleado,
                'atencion' => $atencion,
                'horarioTrabajoInicio' => $horarioTrabajoInicio,
                'horarioTrabajoFinal' => $horarioTrabajoFinal,
                'diasConDatos' => $diasConDatos,
                'metodoPago' => $metodoPago,
                'factura' => $factura,
                'pagaCon' => $pagaCon,
                'recibe' => $recibe,
                'nuevaDireccion' => $nuevaDireccion,
                'pagaRecarga' => $pagaRecarga,
            ];


            $preventaProducto = null;
            $preventaServicio = null;
            // iteramos en un forech para ir agregando los productos seleccionados en el pedido para agregarlos en ventas_productos

        switch($relacion){
                case null:
                    $preventaServicio = is_null($preventaServicio) ? $this->savePresale('Servicio', 'Recolectar', $data) : $preventaServicio;

                break;

                default:
                    if(in_array($ProductooRecoleccion, ['seleccionadolosdos', 'recoleccion'])){
                        $preventaServicio = is_null($preventaServicio) ? $this->savePresale('Servicio', 'Recolectar', $data) : $preventaServicio;
                    }

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
                        $preventaProducto = is_null($preventaProducto) ? $this->savePresale('Entrega', 'Entrega', $data) : $preventaProducto;

                        //ya una vez identificados le agregamos el id del precio actual y cantidad
                        $producto_venta = ventas_productos::firstOrCreate([
                            'id_precio_producto' => $articulo['idPrecio'], //id del precio producto que esta relacionado con el producto
                            'id_preventa' => $preventaProducto->id, //le asignamos su nummero de preventa
                            'cantidad' => $articulo['cantidad'], //le asignamos su cantidad
                            'descuento' => $descuento,
                            'tipo_descuento' => $tipoDescuento, //le asignamos Sin descuento si llega hacer null
                            'estatus' => 3 //le asignamos estatus 3
                        ]);


                        break;

                    case '2':
                        $preventaServicio = is_null($preventaServicio) ? $this->savePresale('Servicio', 'Recolectar', $data) : $preventaServicio;

                        //ya una vez identificados le agregamos el id del precio actual y cantidad
                        /*$servicio_venta = Servicios_preventas::firstOrCreate([
                            'id_precio_producto' => $articulo['idPrecio'], //id del precio producto que esta relacionado con el producto
                            'id_preventa' => $preventaServicio->id, //le asignamos su nummero de preventa
                            'descuento' => $descuento,
                            'precio_unitario' => $valorDescuento,
                            'tipo_descuento' => $tipoDescuento,
                            'cantidad' => $articulo['cantidad'],  //borrar cuando cargue el migration
                            'cantidad_total' => $articulo['cantidad'], //le asignamos su cantidad
                            'estatus' => 1 //le asignamos estatus 1
                        ]);*/
                        break;

                    default:
                        $producto_venta = 'error';
                        break;
                }

            }
            break;
        }


            $cliente = Clientes::find($idCliente);
            $ubicarpersona = personas::find($cliente->id_persona);

            $cliente->update([
                'comentario' => strtoupper($rfc),
                'clave' => $clave
            ]);

            $ubicarpersona->update([
                'telefono' => $telefono,
                'email' => strtolower($email),
            ]);

            if (!is_null($preventaServicio) && !is_null($preventaProducto)) {

                $folioRecoleccion =  $this->folio();
                $folio = $this->folio();

                $Ordenderecoleccion = Orden_recoleccion::create([
                    'id_preventa' => $preventaProducto->id,
                    'id_preventaServicio' => $preventaServicio->id,
                    'id_folio' => $folio->id,
                    'id_folio_recoleccion' => $folioRecoleccion->id,

                ]);
            } else if (!is_null($preventaProducto)) {
                $folio = $this->folio();

                $Ordenderecoleccion = Orden_recoleccion::create([
                    'id_preventa' => $preventaProducto->id,
                    'id_folio' => $folio->id,
                ]);
            } else if (!is_null($preventaServicio)) {

                $folioRecoleccion =  $this->folio();
                $folio = $this->folio();

                $Ordenderecoleccion = Orden_recoleccion::create([
                    'id_preventaServicio' => $preventaServicio->id,
                    'id_folio_recoleccion' => $folioRecoleccion->id

                ]);
            }


            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            return $th->getMessage();

            //session()->flash("incorrect", "Error al procesar los productos, posiblemente no registro algun dato");
            //return redirect()->route('orden_entrega.index');
        }

        // Redirecciona al usuario a una página de vista de resumen o éxito
        return redirect()->route('orden_recoleccion.vistaPreviaTickets', [
            'idproducto' => isset($preventaProducto->id) ? $preventaProducto->id : 0,
            'idservicio' => isset($preventaServicio->id) ? $preventaServicio->id : 0
        ]);
        //return redirect()->route('orden_recoleccion.vistaPreviaOrdenEntrega', $preventa->id); // Reemplaza 'ruta.nombre' con el nombre real de la ruta a la que deseas redirigir
    }

    public function savePresale($tipodeVenta, $estatus, $data)
    {

        //crearemos una preventa con estatus
        $preventa = new Preventa();
        $preventa->id_cliente = $data['idCliente'];
        $preventa->nombre_empleado = $data['nombreEmpleado'];
        $preventa->nombre_atencion = $data['atencion'];
        $preventa->horario_trabajo_inicio = $data['horarioTrabajoInicio'];
        $preventa->horario_trabajo_final = $data['horarioTrabajoFinal'];
        $preventa->dia_semana = $data['diasConDatos'];
        $preventa->metodo_pago = $data['metodoPago'];
        $preventa->factura = $data['factura'] === 'on' ? 1 : 0;
        $preventa->pago_efectivo = $tipodeVenta === 'Entrega' ? $data['pagaCon'] : $data['pagaRecarga'];
        $preventa->tipo_de_venta = $tipodeVenta;
        $preventa->estado = $estatus;
        $preventa->nombre_quien_recibe = $data['recibe'];
        $preventa->id_direccion = $data['nuevaDireccion'];
        $preventa->save();

        return $preventa;
    }
    public function folio()
    {
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

        return $folio;
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
    public function vistaPreviaTickets($idproducto, $idservicio)
    {
        $busqueda = Preventa::find($idproducto) ??  Preventa::find($idservicio);

        $cliente = clientes::join('personas', 'personas.id', '=', 'clientes.id_persona')
            ->where('clientes.id', $busqueda->id_cliente)
            ->select('personas.*')
            ->first();

        $producto = Preventa::find($idproducto) ?  Preventa::find($idproducto) : 0;
        $servicio = Preventa::find($idservicio) ?  Preventa::find($idservicio) : 0;
        $tipoServicio = $busqueda->tipo_de_venta;


        return view('Principal.ordenEntrega.cantidad_ordenes', compact('tipoServicio','producto', 'servicio', 'cliente'));
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
                'orden_recoleccions.Fecha_entrega as fechaEntrega',
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
            ->leftJoin('cancelaciones', 'cancelaciones.id', '=', 'preventas.id_cancelacion')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->join('personas as personaClientes', 'personaClientes.id', '=', 'clientes.id_persona')
            ->where('orden_recoleccions.id', $id)
            ->select(
                'orden_recoleccions.id as idRecoleccion',
                'orden_recoleccions.created_at as fechaCreacion',
                'orden_recoleccions.comentario as descripcionCancelacion',
                'orden_recoleccions.Fecha_entrega as fechaEntrega',
                'folios.letra_actual as letraActual',
                'folios.ultimo_valor as ultimoValor',
                'folios.created_at as fechaDelTiempoAproximado',
                'preventas.id_cancelacion as idCancelacion',
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
                'preventas.observacion',
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

        $diasSemana = explode(',', $ordenRecoleccion->diaSemana);

        if (count($diasSemana) > 1) {
            $largoDelTicket += 50;
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

    public function cambiarProductoRecarga(Request $request)
    {

        $productoRecarga = $request->input('productoRecarga');


        switch ($productoRecarga) {
            case '1':
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
                        'productos.descripcion',
                        'productos.modelo',
                        'tipos.nombre as nombre_categoria',
                        'colors.id as idColor',
                        'colors.nombre as nombre_color',
                        'modos.id as modo_id',
                        'modos.nombre as nombre_modo',
                        'marcas.nombre as nombre_marca',
                        'precios_productos.precio',
                        'precios_productos.id as idPrecio',
                        'precios_productos.alternativo_uno',
                        'precios_productos.alternativo_dos',
                        'precios_productos.alternativo_tres',
                        'precios_productos.estatus',
                        'marcas.id as marca_id',
                        'tipos.id as tipo_id',

                    )
                    ->orderBy('productos.updated_at', 'desc')->get();

                // Retornar una respuesta JSON
                return response()->json(['productos' => $productos]);
                break;

            default:
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
                        'precios_productos.alternativo_uno',
                        'precios_productos.alternativo_dos',
                        'precios_productos.alternativo_tres',
                        'precios_productos.id as idPrecio',
                        'precios_productos.estatus',
                        'marcas.id as marca_id',
                        'tipos.id as tipo_id',
                    )
                    ->orderBy('productos.updated_at', 'desc')->get();

                // Retornar una respuesta JSON
                return response()->json(['productos' => $productos]);
                break;
        }
    }

    public function detallesproducto(Request $request)
    {


        $marcas = Marcas::orderBy('nombre')->get();
        $categorias = Tipo::orderBy('nombre')->get();
        $modos = Modo::orderBy('nombre')->get();
        $colores = Color::all();

        return response()->json(['marcas' => $marcas, 'categorias' => $categorias, 'modos' => $modos, 'colores' => $colores]);
    }

    public function guardarProducto(Request $request)
    {

    $validatedData = $request->validate([
        'txtnombre' => 'required|string|max:255',
        'txtmodelo' => 'required|string|max:255',
        'txtmarca' => 'required|integer',
        'txttipo' => 'required|integer',
        'txtmodo' => 'required|integer',
        'txtcolor' => 'required|integer',
        'txtprecio' => 'required|numeric',
        'txtprecioalternativouno' => 'nullable|numeric',
        'txtprecioalternativodos' => 'nullable|numeric',
        'txtprecioalternativotres' => 'nullable|numeric',
        'txtdescripcion' => 'required|string',
    ]);
    DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.

    //el estatus 2 en precioProducto indica que es un servicio y el 1 es un producto
    try {
    if($validatedData['txtprecio'] == '0'){
        $estatusPrecioProducto = 2;

    }else{
        $estatusPrecioProducto = 1;
    }


    // Guardar el producto en la base de datos
       // Insertar en la tabla 'productos'
       $producto = productos::create([
        'nombre_comercial' => $validatedData['txtnombre'],
        'modelo' => $validatedData['txtmodelo'],
        'id_color' => $validatedData['txtcolor'],
        'id_tipo' => $validatedData['txttipo'],
        'id_modo' => $validatedData['txtmodo'],
        'id_marca' => $validatedData['txtmarca'],
        'descripcion' => $validatedData['txtdescripcion'],
        'fotografia' => null,
        'estatus' => $estatusPrecioProducto,
    ]);

    // Insertar en la tabla 'precios_productos' usando el ID del producto
    $precioProducto = precios_productos::create([
        'id_producto' => $producto->id,
        'precio' => $validatedData['txtprecio'],
        'alternativo_uno' => $validatedData['txtprecioalternativouno'],
        'alternativo_dos' => $validatedData['txtprecioalternativodos'],
        'alternativo_tres' => $validatedData['txtprecioalternativotres'],
        'estatus' => $estatusPrecioProducto,
    ]);

        DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        return response()->json(['success' => true, 'message' => 'Producto guardado correctamente'], 200);
        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            //return $th->getMessage();
            return response()->json(['success' => false, 'message' => 'Error al procesar el registro'], 500);
            //session()->flash("incorrect", "Error al procesar los productos, posiblemente no registro algun dato");
            //return redirect()->route('orden_entrega.index');
        }
}





    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
