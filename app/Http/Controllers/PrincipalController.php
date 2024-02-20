<?php

namespace App\Http\Controllers;

use App\Models\precios_productos;
use App\Models\productos;
use App\Models\ventas_productos;
use Illuminate\Http\Request;

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
    public function registro()
    {
        //
        return view('Principal.registro');
    }

    public function guardarProductoVenta(Request $request)
    {
        // Recibir los datos enviados desde el navegador
        $datos = $request->all();



        $productos_venta = [];
        // Procesar y buscar los datos en la base de datos
        foreach ($datos as $id_Producto => $cantidad) {
            $producto_precio = precios_productos::where('id_producto', $id_Producto)
                ->where('estatus', 1)
                ->first();
            dd($producto_precio->id);

            $producto_venta = ventas_productos::create([
                'id_precio_producto' => $producto_precio->id,
                'modelo' => $request->txtmodelo,
                'color' => $request->txtcolor,
                'marca' => $request->txtmarca,
                'descripcion' => $request->txtdescripcion,
                'fotografia' => $url,
                'estatus' => 1
            ]);



            if ($producto_precio) {
                // $producto->cantidad = $cantidad; // Agrega la cantidad al objeto del producto
                $productos_venta[] = $producto_precio;
            }
        }



        // Devolver una respuesta al navegador con los productos
        return response()->json(['productos' => $productos_venta]);
    }
    public function carrito()
    {
        return view('Principal.carrito');
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
