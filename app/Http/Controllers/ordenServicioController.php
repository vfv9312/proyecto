<?php

namespace App\Http\Controllers;

use App\Models\Catalago_recepcion;
use App\Models\Catalago_ubicaciones;
use App\Models\clientes;
use App\Models\Color;
use App\Models\direcciones;
use App\Models\direcciones_clientes;
use App\Models\empleados;
use App\Models\Marcas;
use App\Models\Orden_recoleccion;
use App\Models\personas;
use App\Models\precios_productos;
use App\Models\Preventa;
use App\Models\productos;
use App\Models\Servicios_preventas;
use App\Models\Tipo;
use App\Models\ventas_productos;
use Barryvdh\DomPDF\Facade\Pdf;
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



        return view('Principal.ordenServicio.datos_cliente', compact('listaEmpleados', 'listaClientes', 'listaDirecciones', 'ListaColonias'));
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

                    // Guardar el modelo
                    $Preventa->save();

                    //si el id_direccion existe eligieron una direccion del usuario entonces entra
                    if (!is_null($id_direcciones) && is_numeric($clienteSeleccionado)) {
                        $Preventa->id_direccion = $id_direcciones;
                        // Guardar el modelo
                        $Preventa->save();
                    } else {
                        //si no selecciono direccion creamos una nueva direccion con los datos de agregar direccion
                        $nuevaDireccion = direcciones::create([
                            'id_ubicacion' => $request->input('nuevacolonia'),
                            'calle' => strtolower($request->input('nuevacalle')),
                            'num_exterior' => $request->input('nuevonum_exterior'),
                            'num_interior' => $request->input('nuevonum_interior'),
                            'referencia' => ucfirst(strtolower($request->input('nuevareferencia'))),
                        ]);
                        $ligarDireccionCliente = direcciones_clientes::create([
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
                $clientePersona = personas::create([
                    'nombre' => ucwords(strtolower($request->input('txtnombreCliente'))),
                    'apellido' => ucwords(strtolower($request->input('txtapellidoCliente'))),
                    'telefono' => $request->input('txttelefono'),
                    'email' => strtolower($request->input('txtemail')),
                    'estatus' => 1,
                ]);

                //crearemos un cliente
                $clienteNuevo = clientes::create([
                    'id_persona' => $clientePersona->id,
                    'comentario' => strtoupper($request->input('txtrfc')),
                    'estatus' => 1,
                ]);
                //Preventa le asignamos el clienta nuevo
                $Preventa->id_cliente = $clienteNuevo->id;
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
                    $direccionNuevaCliente = direcciones_clientes::create([
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
            $categorias = Tipo::orderBy('nombre')->get();
            $colores = Color::all();


            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.

        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            //return $th->getMessage();
        }
        return view('Principal.ordenServicio.datos_producto', compact('Preventa', 'marcas', 'categorias', 'colores'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

            // Insertar en la tabla 'productos'
            $producto = productos::create([
                'nombre_comercial' => $nombre_comercial,
                'modelo' => $request->txtmodelo,
                'id_color' => $color,
                'id_tipo' => $tipo,
                'id_marca' => $marca,
                'descripcion' => $descripcion,
                'fotografia' => null,
                'estatus' => 2
            ]);

            $catalago = Catalago_recepcion::create([
                'id_producto' => $producto->id,
                'estatus' => 2
            ]);

            $preventa_servicios = Servicios_preventas::create([
                'id_preventa' => $idPreventa,
                'id_producto_recepcion' => $catalago->id,
                'estatus' => 2,
            ]);

            $marcas = Marcas::orderBy('nombre')->get();
            $categorias = Tipo::orderBy('nombre')->get();
            $colores = Color::all();


            $Preventa = Preventa::find($id);
        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            return $th->getMessage();
        }

        return view('Principal.ordenServicio.datos_producto', compact('Preventa', 'marcas', 'categorias', 'colores'));

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
            $preventa->update([
                'estatus' => 4 //3 entrega y 4 servicios
            ]);
            //buscar si hay una recoleccion con el id de preventa que tenemos
            $buscarrecoleccion = Orden_recoleccion::where('id_preventa', $preventa->id)->first();
            //si lo encuentra no cres nada pero si no lo encuentra crea una recoleccion
            if ($buscarrecoleccion) {
            } else {
                $recoleccion = Orden_recoleccion::create([
                    'id_preventa' => $preventa->id,
                    'estatus' => 4, //4por recolectar, 3 revision 2 entrega 1 listo 0 eliminado
                ]);
            }


            $empleado = empleados::join('roles', 'roles.id', '=', 'empleados.id_rol')
                ->join('personas', 'personas.id', '=', 'empleados.id_persona')
                ->join('preventas', 'preventas.id_empleado', '=', 'empleados.id')
                ->where('empleados.estatus', 1)
                ->select('empleados.id', 'roles.nombre as nombre_rol', 'personas.nombre as nombre_empleado', 'personas.apellido')
                ->first();

            $cliente = clientes::join('personas', 'personas.id', '=', 'clientes.id_persona')
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
                ->first();

            $direccion = direcciones::join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
                ->join('preventas', 'preventas.id_direccion', '=', 'direcciones.id')
                ->where('direcciones.estatus', 1)
                ->where('preventas.estatus', 4)
                ->where('preventas.id', $id)
                ->select('direcciones.calle', 'direcciones.num_exterior', 'direcciones.num_interior', 'direcciones.referencia', 'catalago_ubicaciones.localidad as colonia')
                ->first();

            $productos = Catalago_recepcion::join('productos', 'productos.id', '=', 'catalago_recepcions.id_producto')
                ->join('servicios_preventas', 'servicios_preventas.id_producto_recepcion', '=', 'catalago_recepcions.id')
                ->join('preventas', 'preventas.id', '=', 'servicios_preventas.id_preventa')
                ->leftJoin('marcas', 'marcas.id', '=', 'productos.id_marca')
                ->leftJoin('tipos', 'tipos.id', '=', 'productos.id_tipo')
                ->leftJoin('colors', 'colors.id', '=', 'productos.id_color')
                ->where('preventas.id', $id)
                ->select('productos.*', 'marcas.nombre as marca', 'tipos.nombre as tipo', 'colors.nombre as color')
                ->get();

            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            return $th->getMessage();
        }

        return view('Principal.ordenServicio.orden_completada', compact('id', 'productos', 'direccion', 'preventa', 'empleado', 'cliente'));
    }

    public function generarPdf(Request $request)
    {
        $datos = $request->all();
        $id = $request->input('id');
        $nombre_cliente = $request->input('txtnombre_cliente');
        $atencion = $request->input('txtatencion');
        $direccion = $request->input('txtdireccion');
        $telefono = $request->input('txttelefono');
        $rfc = $request->input('txtrfc');
        $email = $request->input('txtemail');
        $fecha = $request->input('txtfecha');
        $precio = $request->input('txtprecio');

        $productos = Catalago_recepcion::join('productos', 'productos.id', '=', 'catalago_recepcions.id_producto')
            ->join('servicios_preventas', 'servicios_preventas.id_producto_recepcion', '=', 'catalago_recepcions.id')
            ->join('preventas', 'preventas.id', '=', 'servicios_preventas.id_preventa')
            ->leftJoin('marcas', 'marcas.id', '=', 'productos.id_marca')
            ->leftJoin('tipos', 'tipos.id', '=', 'productos.id_tipo')
            ->leftJoin('colors', 'colors.id', '=', 'productos.id_color')
            ->where('preventas.id', $id)
            ->select('productos.*', 'marcas.nombre as marca', 'tipos.nombre as tipo', 'colors.nombre as color')
            ->get();




        $pdf = PDF::loadView('Principal.ordenServicio.pdf', compact('productos', 'telefono', 'nombre_cliente', 'atencion', 'direccion', 'rfc', 'email', 'fecha', 'precio'));

        // Establece el tamaño del papel a 80mm de ancho y 200mm de largo
        $pdf->setPaper([0, 0, 226.77, 699.93], 'portrait'); // 80mm x 200mm en puntos

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
