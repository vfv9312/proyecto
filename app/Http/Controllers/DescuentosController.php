<?php

namespace App\Http\Controllers;

use App\Models\Descuentos;
use Illuminate\Http\Request;

class DescuentosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $descuentos = Descuentos::where('estatus', 1)->paginate(5);

        return view('descuentos.index', compact('descuentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $nombre = $request->input('txtnombre');
            $porcentaje = $request->input('txtporcentaje');

            $descuentos = Descuentos::create([
                'nombre' => $nombre,
                'porcentaje' => $porcentaje
            ]);
        } catch (\Throwable $th) {
            //return $th->getMessage();

            session()->flash("incorrect", "Error al registrar el descuento");
            return redirect()->route('descuentos.index');
        }
        session()->flash("correcto", "Descuento registrado correctamente");
        return redirect()->route('descuentos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Descuentos $descuentos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Descuentos $descuento)
    {
        return view('descuentos.edit', compact('descuento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Descuentos $descuento)
    {
        $nombre = $request->input('nombre');
        $porcentaje = $request->input('porcentaje');
        try {
            $descuento->update([
                'nombre' => $nombre,
                'porcentaje' => $porcentaje
            ]);
            $descuento->save();
        } catch (\Throwable $th) {
            //return $th->getMessage();

            session()->flash("incorrect", "Error al actualizar el descuento");
            return redirect()->route('descuentos.index');
        }
        session()->flash("correcto", "Descuento actualizado correctamente");
        return redirect()->route('descuentos.index');
    }

    public function desactivar(Descuentos $descuento)
    {
        try {
            $descuento->update([
                'estatus' => 0,
            ]);
            $descuento->save();
        } catch (\Throwable $th) {
            //return $th->getMessage();

            session()->flash("incorrect", "Error al eliminar el descuento");
            return redirect()->route('descuentos.index');
        }
        session()->flash("correcto", "Descuento eliminado correctamente");
        return redirect()->route('descuentos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Descuentos $descuentos)
    {
        //
    }
}
