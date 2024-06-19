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
use App\Models\Servicios_preventas;
use App\Models\TiempoAproximado;
use App\Models\Tipo;
use App\Models\ventas_productos;
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

        $HorarioTrabajo = Preventa::where('estatus', 3)
            ->whereNotNull('horario_trabajo_inicio')
            ->select('id_cliente as idCliente', 'horario_trabajo_inicio as horaInicio', 'horario_trabajo_final as horaFinal', 'dia_semana as dias', 'nombre_quien_recibe as recibe')
            ->orderBy('updated_at', 'asc')->get();


        $descuentos = Descuentos::select('*')->orderBy('nombre', 'asc')->get();

        return view('Principal.ordenEntrega.tienda', compact('marcas', 'tipos', 'modos', 'colores', 'listaClientes', 'listaDirecciones', 'ListaColonias', 'listaAtencion', 'HorarioTrabajo', 'descuentos'));
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
            $nuevaDireccion = $request->input('id_direccion');

            //si modificamos un dato del cliente podrian ser cualquiera de estos 3
            $telefono = $request->input('txttelefono'); //telefono del cliente
            $rfc = $request->input('txtrfc'); //rfc del cliente
            $email = $request->input('txtemail'); //correo electronico del cliente
            $recibe = ucwords(strtolower($request->input('txtrecibe'))); // persona que recibira el pedido

            //si registramos un cliente nuevo recibiremos
            $nuevoCliente = $request->input('txtnombreCliente'); //nombre del cliente
            $nuevoApeCliente = $request->input('txtapellidoCliente'); // apellido del cliente

            //datos que iran siempre
            $atencion = ucwords(strtolower($request->input('txtatencion'))); //persona que atendera cuando llegue el motociclista

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
            $LunesEntrada = $request->input('Lunes-Viernes_entrada');
            $LunesSalida = $request->input('Lunes-Viernes_salida');
            // $MartesEntrada = $request->input('Lunes_entrada');
            // $MartesSalida = $request->input('Lunes_salida');
            // $MiercolesEntrada = $request->input('Lunes_entrada');
            // $MiercolesSalida = $request->input('Lunes_salida');
            // $JuevesEntrada = $request->input('Lunes_entrada');
            // $JuevesSalida = $request->input('Lunes_salida');
            // $ViernesEntrada = $request->input('Lunes_entrada');
            // $ViernesSalida = $request->input('Lunes_salida');
            $SabadoEntrada = $request->input('Sabado_entrada');
            $SabadoSalida = $request->input('Sabado_salida');
            $DomingoEntrada = $request->input('Domingo_entrada');
            $DomingoSalida = $request->input('Domingo_salida');

            // $horarioTrabajoInicio = $LunesEntrada . ',' . $MartesEntrada . ',' . $MiercolesEntrada . ',' . $JuevesEntrada . ',' . $ViernesEntrada . ',' . $SabadoEntrada . ',' . $DomingoEntrada;
            // $horarioTrabajoFinal = $LunesSalida . ',' . $MartesSalida . ',' . $MiercolesSalida . ',' . $JuevesSalida . ',' . $ViernesSalida . ',' . $SabadoSalida . ',' . $DomingoSalida;
            $horarioTrabajoInicio = $LunesEntrada . ',' . $SabadoEntrada . ',' . $DomingoEntrada;
            $horarioTrabajoFinal = $LunesSalida . ',' . $SabadoSalida . ',' . $DomingoSalida;


            $diasConDatos = '';


            if (!empty($LunesEntrada)) {
                $diasConDatos .= 'Lunes-Viernes,';
            }
            // if (!empty($MartesEntrada)) {
            //     $diasConDatos .= 'Martes,';
            // }
            // if (!empty($MiercolesEntrada)) {
            //     $diasConDatos .= 'Miercoles,';
            // }
            // if (!empty($JuevesEntrada)) {
            //     $diasConDatos .= 'Jueves,';
            // }
            // if (!empty($ViernesEntrada)) {
            //     $diasConDatos .= 'Viernes,';
            // }
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



            // si Seleccionaron un cliente entonces entra

            if ($idCliente == "null") {
                $clientePersona = personas::create([
                    'nombre' => ucwords(strtolower($nuevoCliente)),
                    'apellido' => ucwords(strtolower($nuevoApeCliente)),
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
            ];


            $preventaProducto = null;
            $preventaServicio = null;
            // iteramos en un forech para ir agregando los productos seleccionados en el pedido para agregarlos en ventas_productos
            foreach ($relacion as $articulo) {


                //si descuento es null entonces valdra 0 y sin descuento para poder ingresarlo a la base de datos
                switch ($articulo['tipoDescuento']) {
                    case 'cantidad':
                        $valorDescuento = $articulo['cantidad'] * $articulo['precio'] - $articulo['descuento'];
                        $tipoDescuento =   $articulo['tipoDescuento'];
                        $descuento = $articulo['descuento'];
                        break;

                    case 'Porcentaje':
                        $descuentoDividido =  intval($articulo['descuento']) / 100;
                        $valorDescuento = (intval($articulo['cantidad']) * $articulo['precio']) * (1 - $descuentoDividido);
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
                        $preventaProducto = is_null($preventaProducto) ? $this->savePresale(3, $data) : $preventaProducto;

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
                        $preventaServicio = is_null($preventaServicio) ? $this->savePresale(4, $data) : $preventaServicio;

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

            if (!is_null($preventaProducto)) {
                $folio = $this->folio();

                $Ordenderecoleccion = Orden_recoleccion::create([
                    'id_preventa' => $preventaProducto->id,
                    'id_folio' => $folio->id,
                    'estatus' => 2 //5 pendiente 4 por recolectar, 3 revision 2 entrega 1 listo 0 eliminado
                ]);
            }
            if (!is_null($preventaServicio)) {

                $folio =  $this->folio();

                $Ordenderecoleccion = Orden_recoleccion::create([
                    'id_preventa' => $preventaServicio->id,
                    'id_folio' => $folio->id,
                    'estatus' => 4 //5 pendiente 4 por recolectar, 3 revision 2 entrega 1 listo 0 eliminado
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

    public function savePresale($estatus, $data)
    {

        //crearemos una preventa con estatus 3
        $preventa = new Preventa();
        $preventa->id_cliente = $data['idCliente'];
        $preventa->nombre_empleado = $data['nombreEmpleado'];
        $preventa->nombre_atencion = $data['atencion'];
        $preventa->horario_trabajo_inicio = $data['horarioTrabajoInicio'];
        $preventa->horario_trabajo_final = $data['horarioTrabajoFinal'];
        $preventa->dia_semana = $data['diasConDatos'];
        $preventa->metodo_pago = $data['metodoPago'];
        $preventa->factura = $data['factura'] === 'on' ? 1 : 0;
        $preventa->pago_efectivo = $data['pagaCon'];
        $preventa->estatus = $estatus;
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
    public function vistaPreviaTickets($idproducto, $idservicio)
    {
        $busqueda = Preventa::find($idproducto) ??  Preventa::find($idservicio);


        $cliente = clientes::join('personas', 'personas.id', '=', 'clientes.id_persona')
            ->where('clientes.id', $busqueda->id_cliente)
            ->select('personas.*')
            ->first();

        $producto = Preventa::find($idproducto);
        $servicio = Preventa::find($idservicio);
        if ($servicio) {
            $ordenrecoleccionServicio = Orden_recoleccion::where('id_preventa', $servicio->id)->first();
        } else {
            $ordenrecoleccionServicio = null;
        }



        return view('Principal.ordenEntrega.cantidad_ordenes', compact('producto', 'servicio', 'cliente', 'ordenrecoleccionServicio'));
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

        if (count($diasSemana) > 5) {
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



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
