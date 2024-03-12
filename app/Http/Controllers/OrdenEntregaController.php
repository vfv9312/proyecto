<?php

namespace App\Http\Controllers;

use App\Models\Catalago_ubicaciones;
use App\Models\clientes;
use App\Models\Color;
use App\Models\direcciones;
use App\Models\direcciones_clientes;
use App\Models\empleados;
use App\Models\Marcas;
use App\Models\Modo;
use App\Models\Orden_recoleccion;
use App\Models\personas;
use App\Models\precios_productos;
use App\Models\Preventa;
use App\Models\productos;
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

        return view('Principal.ordenEntrega.tienda', compact('productos', 'marcas', 'tipos', 'modos', 'colores'));
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
            // Recibir los datos enviados desde el navegador
            $producto_ids = $request->input('producto_id');
            $cantidades = $request->input('cantidad');

            $relacion = [];

            for ($i = 0; $i < count($producto_ids); $i++) {
                if ($cantidades[$i] > 0) {
                    $relacion[$producto_ids[$i]] = $cantidades[$i];
                }
            }

            $preventa = Preventa::create([
                'estatus' => 2
            ]);

            $productos_ventas = [];
            $productos = [];

            // Procesar y buscar los datos en la base de datos
            foreach ($relacion as $id_Producto => $cantidad) {

                $producto_precio = precios_productos::where('id_producto', $id_Producto)
                    ->where('estatus', 1)
                    ->first();

                $producto = Productos::where('id', $id_Producto)->first();

                $producto_venta = ventas_productos::create([
                    'id_precio_producto' => $producto_precio->id,
                    'id_preventa' => $preventa->id,
                    'cantidad' => $cantidad,
                    'estatus' => 2
                ]);
                $productos_ventas[] = [
                    'producto' => $producto_venta,
                    'precio' => $producto_precio->precio,
                ];

                $productos[] = $producto;
            }
            // Devolver una respuesta al navegador con los productos
            //return response()->json(['productos' => $productos_venta]);


            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.

        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            return $th->getMessage();
            $producto_venta = false;
        }
        if ($producto_venta == true) {
            return view('Principal.ordenEntrega.carrito', ['producto_venta' => $productos_ventas, 'producto' => $productos, 'venta' => $preventa]);
        } else {
            session()->flash("incorrect", "Error al procesar el carrito de compras");
            return redirect()->route('inicio.carrito');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $orden_recoleccion)
    {
        $ordenRecoleccion = Orden_recoleccion::join('preventas', 'preventas.id', '=', 'orden_recoleccions.id_preventa')
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
                'personaEmpleado.telefono as telefonoEmpleado',
            )
            ->first();


        $listaProductos = precios_productos::join('ventas_productos', 'ventas_productos.id_precio_producto', '=', 'precios_productos.id')
            ->join('preventas', 'preventas.id', '=', 'ventas_productos.id_preventa')
            ->join('productos', 'productos.id', '=', 'precios_productos.id_producto')
            ->where('preventas.id', $ordenRecoleccion->idPreventa)
            ->select('productos.nombre_comercial', 'precios_productos.precio', 'ventas_productos.cantidad')
            ->get();

        return view('Principal.ordenEntrega.vista_previa', compact('ordenRecoleccion', 'listaProductos'));
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
        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.

        try {
            $clienteSeleccionado = $request->input('cliente');
            $id_direcciones = $request->input('id_direccion');
            //buco la preventa con el id
            $Preventa = Preventa::find($id);

            //busco si ya existe una orden de recoleccion
            $buscarrecoleccion = Orden_recoleccion::where('id_preventa', $Preventa->id)
                ->first();
            //si ya hay una orden de recoleccion con el id de preventa no haga nada pero si no hay nada entonces crea uno
            if ($buscarrecoleccion) {
            } else {


                $Preventa->estatus = 3;
                // Guardar el modelo
                $Preventa->save();



                $venta_producto = ventas_productos::where('id_preventa', $Preventa->id)->get();
                foreach ($venta_producto as $producto) {
                    $producto->estatus = 3;
                    $producto->save();
                }

                // si id_direccion tiene datos entonces entra
                if (!is_null($clienteSeleccionado) && is_numeric($clienteSeleccionado)) {

                    //si preventa esxite que si entonces entra
                    if ($Preventa) {
                        //Actualizar los campos
                        $Preventa->id_cliente = $clienteSeleccionado;
                        $Preventa->id_empleado = $request->input('txtempleado');

                        // Guardar el modelo
                        $Preventa->save();

                        //si el id_direccion existe eligieron una direccion del usuario encontes entra
                        if ($id_direcciones) {
                            $Preventa->id_direccion = $id_direcciones;
                            // Guardar el modelo
                            $Preventa->save();
                        } else {
                            $nuevaDireccion = direcciones::create([
                                'id_ubicacion' => $request->input('nuevacolonia'),
                                'calle' => $request->input('nuevacalle'),
                                'num_exterior' => $request->input('nuevonum_exterior'),
                                'num_interior' => $request->input('nuevonum_interior'),
                                'referencia' => $request->input('nuevareferencia'),
                            ]);
                            $ligarDireccionCliente = direcciones_clientes::create([
                                'id_direccion' => $nuevaDireccion->id,
                                'id_cliente' => $clienteSeleccionado,
                                'estatus' => 1
                            ]);

                            $Preventa->id_direccion = $nuevaDireccion->id;
                            // Guardar el modelo
                            $Preventa->save();
                        }
                    }
                } else {

                    $clientePersona = personas::create([
                        'nombre' => $request->input('txtnombreCliente'),
                        'apellido' => $request->input('txtapellidoCliente'),
                        'telefono' => $request->input('txttelefono'),
                        'email' => $request->input('txtemail'),
                        'estatus' => 1,
                        // ...otros campos aquí...
                    ]);


                    $clienteNuevo = clientes::create([
                        'id_persona' => $clientePersona->id,
                        'comentario' => $request->input('txtrfc'),
                        'estatus' => 1,
                    ]);

                    $Preventa->id_cliente = $clienteNuevo->id;
                    $Preventa->id_empleado = $request->input('txtempleado');
                    // Guardar el modelo
                    $Preventa->save();

                    if ($request->input('nuevacolonia') && $request->input('nuevacalle')) {

                        $nuevaDireccion = direcciones::create([
                            'id_ubicacion' => $request->input('nuevacolonia'),
                            'calle' => $request->input('nuevacalle'),
                            'num_exterior' => $request->input('nuevonum_exterior'),
                            'num_interior' => $request->input('nuevonum_interior'),
                            'referencia' => $request->input('nuevareferencia'),
                        ]);

                        $direccionNuevaCliente = direcciones_clientes::create([
                            'id_direccion' => $nuevaDireccion->id,
                            'id_cliente' => $clienteNuevo->id,
                            'estatus' => 1

                        ]);

                        $Preventa->id_direccion = $nuevaDireccion->id;
                        // Guardar el modelo
                        $Preventa->save();
                    }
                }

                $Ordenderecoleccion = Orden_recoleccion::create([
                    'id_preventa' => $Preventa->id,
                    'estatus' => 2 //5 pendiente 4 por recolectar, 3 revision 2 entrega 1 listo 0 eliminado

                ]);
            }


            //consultas para motrar los datos
            $listaCliente = clientes::join('personas', 'personas.id', '=', 'clientes.id_persona')
                ->where('clientes.estatus', 1)
                ->where('clientes.id', $Preventa->id_cliente)
                ->orWhere('clientes.id', $clienteSeleccionado)
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

            $listaEmpleado = empleados::join('roles', 'roles.id', '=', 'empleados.id_rol')
                ->join('personas', 'personas.id', '=', 'empleados.id_persona')
                ->where('empleados.estatus', 1)
                ->where('empleados.id', $request->input('txtempleado'))
                ->select('empleados.id', 'roles.nombre as nombre_rol', 'personas.nombre as nombre_empleado', 'personas.apellido')
                ->first();

            $datosPreventa = Preventa::join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
                ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
                ->where('preventas.id', $id)
                ->select('preventas.updated_at as fecha', 'preventas.pago_efectivo', 'preventas.metodo_pago', 'preventas.factura', 'preventas.comentario', 'catalago_ubicaciones.localidad', 'catalago_ubicaciones.estado', 'catalago_ubicaciones.municipio', 'direcciones.calle', 'direcciones.num_exterior', 'direcciones.num_interior', 'direcciones.referencia')
                ->first();

            $listaProductos = precios_productos::join('ventas_productos', 'ventas_productos.id_precio_producto', '=', 'precios_productos.id')
                ->join('preventas', 'preventas.id', '=', 'ventas_productos.id_preventa')
                ->join('productos', 'productos.id', '=', 'precios_productos.id_producto')
                ->where('preventas.id', $id)
                ->select('productos.nombre_comercial', 'precios_productos.precio', 'ventas_productos.cantidad')
                ->get();


            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.

        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            return $th->getMessage();
        }
        if (true) {
            return view('Principal.ordenEntrega.orden_completa', compact('buscarrecoleccion', 'listaCliente', 'listaEmpleado', 'datosPreventa', 'listaProductos'));
        } else {
            session()->flash("incorrect", "Error al procesar el carrito de compras");
            return redirect()->route('orden_entrega.create ');
        }
    }

    public function generarPdf(string $id)
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


        $listaProductos = precios_productos::join('ventas_productos', 'ventas_productos.id_precio_producto', '=', 'precios_productos.id')
            ->join('preventas', 'preventas.id', '=', 'ventas_productos.id_preventa')
            ->join('productos', 'productos.id', '=', 'precios_productos.id_producto')
            ->where('preventas.id', $ordenRecoleccion->idPreventa)
            ->select('productos.nombre_comercial', 'precios_productos.precio', 'ventas_productos.cantidad')
            ->get();

        $pdf = PDF::loadView('Principal.ordenEntrega.pdf', compact(
            'ordenRecoleccion',
            'listaProductos'
        ));

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
