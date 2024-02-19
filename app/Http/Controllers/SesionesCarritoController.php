<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SesionesCarritoController extends Controller
{
    public function incrementarContador(Request $request, $id)
    {
        $carrito = $request->session()->get('carrito', []);
        if (isset($carrito[$id])) {
            $carrito[$id]++;
        } else {
            $carrito[$id] = 1;
        }
        $request->session()->put('carrito', $carrito);

        return response()->json(['success' => true]);
    }

    public function verCarrito(Request $request)
    {
        $carrito = $request->session()->get('carrito', []);
        return response()->json($carrito);
    }

    public function mostrarCarrito(Request $request)
    {
        $carrito = $request->session()->get('carrito', []);
        return view('carrito', ['carrito' => $carrito]);
    }

    public function eliminarDelCarrito(Request $request, $id)
    {
        $carrito = $request->session()->get('carrito', []);
        if (isset($carrito[$id])) {
            unset($carrito[$id]);
        }
        $request->session()->put('carrito', $carrito);

        return response()->json(['success' => true]);
    }
}
