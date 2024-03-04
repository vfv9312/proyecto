<?php

namespace App\Http\Controllers;

use App\Models\Catalago_ubicaciones;
use App\Models\clientes;
use App\Models\empleados;
use App\Models\personas;
use App\Models\precios_productos;
use App\Models\Preventa;
use App\Models\productos;
use App\Models\ventas;
use App\Models\ventas_productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrincipalController extends Controller
{
    //
    public function index()
    {/*
        $productos = productos::join('precios_productos', 'productos.id', '=', 'precios_productos.id_producto')
            ->where('productos.estatus', 1)
            ->where('precios_productos.estatus', 1)
            ->select('productos.id', 'productos.nombre_comercial', 'productos.modelo', 'productos.color', 'productos.marca', 'productos.fotografia', 'precios_productos.precio')
            ->orderBy('productos.updated_at', 'desc')->get();

        return view('Principal.inicio', compact('productos'));*/
        return view('Principal.inicio');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(productos $usuarios)
    {
    }

    public function registro(Request $request)
    {
        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.

        try {
            $cantidades = $request->input('cantidad');
            $ventaJson = $request->input('venta');
            $venta = json_decode($ventaJson);
            $productos = $request->input('productos');
            $metodo_pago = $request->input('metodo_pago');
            $relacion = [];
            $factura = $request->input('factura');


            //En resumen, este código está creando un nuevo array ($relacion) que mapea productos a cantidades, pero solo para aquellos productos cuya cantidad es mayor que 0.
            for ($i = 0; $i < count($productos); $i++) {
                if ($cantidades[$i] > 0) {
                    $relacion[$productos[$i]] = $cantidades[$i];
                }
            }

            $ventaActualizada = Preventa::find($venta->id)->update([
                'metodo_pago' => $metodo_pago,
                'factura' => $factura,
            ]);

            foreach ($relacion as $id_Producto => $cantidad) {
                // Si el valor no es un array, no necesitas decodificarlo

                $BuscarIdPrecios = ventas_productos::where('id_precio_producto', $id_Producto)
                    ->where('id_preventa', $venta->id)
                    ->where('estatus', 2)
                    ->first();

                $actualizarCantidad = $BuscarIdPrecios->update([
                    'cantidad' => $cantidad,
                ]);
            }


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
            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.

        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            return $th->getMessage();
            $actualizarCantidad = false;
        }
        if ($actualizarCantidad  == true) {
            return view('Principal.ordenEntrega.registrar_cliente', compact('listaEmpleados', 'listaClientes', 'listaDirecciones', 'ListaColonias', 'venta'));
        } else {
            session()->flash("incorrect", "Error al procesar el carrito de compras");
            return redirect()->route('orden_entrega.create ');
        }
    }

    public function carrito(Request $request)
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

            $venta = ventas::create([
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
                    'id_venta' => $venta->id,
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
            return view('Principal.carrito', ['producto_venta' => $productos_ventas, 'producto' => $productos, 'venta' => $venta]);
        } else {
            session()->flash("incorrect", "Error al procesar el carrito de compras");
            return redirect()->route('inicio.carrito');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(productos $usuarios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, productos $usuarios)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(productos $usuarios)
    {
        //
    }
}
