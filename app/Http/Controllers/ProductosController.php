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
            ->select('productos.nombre_comercial', 'productos.modelo', 'productos.color', 'productos.marca', 'productos.fotografia', 'precios_productos.precio')
            ->paginate(5); // Mueve paginate() aquí para que funcione correctamente

        return view('Productos.productos', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // $producto = new productos();
        // Asegúrate de validar tus datos aquí
        // $producto->nombre_comercial = $request->nombre_comercial;
        // Repite para todos los campos de tu formulario
        //  $producto->save();



        DB::beginTransaction();
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
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(productos $productos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, productos $productos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(productos $productos)
    {
        //
    }
}
