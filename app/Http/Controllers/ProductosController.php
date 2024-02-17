<?php

namespace App\Http\Controllers;

use App\Models\precios_productos;
use App\Models\productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /*
        $datos = DB::select('SELECT p.nombre_comercial, p.modelo, p.color, p.marca, p.fotografia, pp.precio
        FROM canacotu_tuxtla.productos AS p
        INNER JOIN canacotu_tuxtla.precios_productos AS pp
        ON p.id = pp.id_producto
        WHERE p.estatus = 1;');*/

        $productos = productos::join('precios_productos', 'productos.id', '=', 'precios_productos.id_producto')
            ->where('productos.estatus', 1)
            ->select('productos.id', 'productos.nombre_comercial', 'productos.modelo', 'productos.color', 'productos.marca', 'productos.fotografia', 'precios_productos.precio')
            ->paginate(5); // Mueve paginate() aquí para que funcione correctamente

        return view('Productos.productos', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $producto = new productos();
        // Asegúrate de validar tus datos aquí
        // $producto->nombre_comercial = $request->nombre_comercial;
        // Repite para todos los campos de tu formulario
        //  $producto->save();



        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.
        try {
            // Insertar en la tabla 'productos'
            $producto = productos::create([
                'nombre_comercial' => $request->txtnombre,
                'modelo' => $request->txtmodelo,
                'color' => $request->txtcolor,
                'marca' => $request->txtmarca,
                'fotografia' => $request->txtfotografia,
                'estatus' => 1
            ]);

            // Insertar en la tabla 'precios_productos' usando el ID del producto
            $precioProducto = precios_productos::create([
                'id_producto' => $producto->id,
                'precio' => $request->txtprecio,
                'descripcion' => $request->txtdescripcion,
                'estatus' => 1
            ]);
            /*
            // Insertar en la tabla 'productos'
            $sql = DB::insert('INSERT INTO canacotu_tuxtla.productos
            (nombre_comercial, modelo, color, marca, fotografia, created_at, updated_at, estatus)
            VALUES (?,?, ?, ?, ?, now(), now(), ?);

            ', [
                $request->txtnombre,
                $request->txtmodelo,
                $request->txtcolor,
                $request->txtmarca,
                $request->txtfotografia,
                1
            ]);
            // Obtener el ID del producto insertado
            $idProducto = DB::getPdo()->lastInsertId();
            // Insertar en la tabla 'precios_productos' usando el ID del producto
            $sql = DB::insert(
                'INSERT INTO canacotu_tuxtla.precios_productos
(id_producto, precio, descripcion, created_at, updated_at, estatus)
VALUES (?, ?, ?, now(), now(),1)',
                [
                    $idProducto,
                    $request->txtprecio,
                    $request->txtdescripcion
                ]
            );*/
            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            return $th->getMessage();
            $precioProducto = 0;
        }
        if ($precioProducto == true) {
            session()->flash("correcto", "Producto registrado correctamente");
            return redirect()->route('productos.index');
        } else {
            session()->flash("incorrect", "Error al registrar");
            return redirect()->route('productos.index');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(productos $productos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(productos $producto)
    {
        //
        $precioProducto = precios_productos::where('id_producto', $producto->id)->first();

        return view('Productos.edit', compact('producto', 'precioProducto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, productos $producto)
    {
        //
        $producto->update([
            'nombre_comercial' => $request->txtnombre,
            'modelo' => $request->txtmodelo,
            'color' => $request->txtcolor,
            'marca' => $request->txtmarca,
            'fotografia' => $request->txtfotografia,
            'estatus' => $request->txtestatus1
        ]);
        // Actualizar la tabla precios_productos
        $sql = precios_productos::where('id_producto', $producto->id)->first();

        $sql->update([
            'precio' => $request->txtprecio,
            'descripcion' => $request->txtdescripcion,
            'estatus' => $request->txtestatus
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(productos $productos)
    {
        //
    }
}
