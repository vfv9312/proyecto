<?php

namespace App\Http\Controllers;

use App\Models\clientes;
use App\Models\empleados;
use App\Models\personas;
use App\Models\precios_productos;
use App\Models\productos;
use App\Models\ventas;
use App\Models\ventas_productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrincipalController extends Controller
{
    //
    public function index()
    {
        $productos = productos::join('precios_productos', 'productos.id', '=', 'precios_productos.id_producto')
            ->where('productos.estatus', 1)
            ->where('precios_productos.estatus', 1)
            ->select('productos.id', 'productos.nombre_comercial', 'productos.modelo', 'productos.color', 'productos.marca', 'productos.fotografia', 'precios_productos.precio')
            ->orderBy('productos.updated_at', 'desc')->get();

        return view('Principal.inicio', compact('productos'));
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


            for ($i = 0; $i < count($productos); $i++) {
                if ($cantidades[$i] > 0) {
                    $relacion[$productos[$i]] = $cantidades[$i];
                }
            }

            $ventaActualizada = ventas::find($venta->id)->update([
                'metodo_pago' => $metodo_pago,
            ]);


            foreach ($relacion as $id_Producto => $cantidad) {
                // Si el valor no es un array, no necesitas decodificarlo

                $BuscarIdPrecios = ventas_productos::where('id_precio_producto', $id_Producto)
                    ->where('id_venta', $venta->id)
                    ->where('estatus', 2)
                    ->first();

                $actualizarCantidad = $BuscarIdPrecios->update([
                    'cantidad' => $cantidad,
                ]);
            }



            $empleados = DB::table('empleados')
                ->join('personas', 'empleados.id_persona', '=', 'personas.id')
                ->where('empleados.estatus', 1)
                ->select('personas.nombre', 'personas.apellido', 'personas.telefono', 'empleados.id', 'empleados.rol_empleado')
                ->get();

            $clientes = DB::table('clientes')
                ->join('personas', 'clientes.id_persona', '=', 'personas.id')
                ->where('clientes.estatus', 1)
                ->select('personas.nombre', 'personas.apellido', 'personas.telefono', 'clientes.id')
                ->get();

            $direccionesCliente = DB::table('clientes')
                ->join('direcciones_clientes', 'clientes.id', '=', 'direcciones_clientes.id_cliente')
                ->join('direcciones', 'direcciones_clientes.id_direccion', '=', 'direcciones.id')
                ->where('clientes.estatus', 1)
                ->orderBy('direcciones.created_at', 'desc')
                ->select('clientes.id', 'direcciones.direccion')
                ->get();


            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.

        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            return $th->getMessage();
            $actualizarCantidad = false;
        }
        if ($actualizarCantidad  == true) {
            return view('Principal.registro', ['venta' => $venta, 'empleados' => $empleados, 'clientes' => $clientes, 'direccionesCliente' => $direccionesCliente]);
        } else {
            session()->flash("incorrect", "Error al procesar el carrito de compras");
            return redirect()->route('productos.index');
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
