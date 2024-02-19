<?php

namespace App\Http\Controllers;

use App\Models\productos;
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
        return view('Principal.carrito');
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
