<?php

namespace App\Http\Controllers;

use App\Models\Marcas;
use Illuminate\Foundation\Mix;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarcasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $busqueda = $request->query('adminlteSearch');
        $busquedaMarca = $request->query('marca');
        $busquedaTipo = $request->query('tipo');
        $busquedaColor = $request->query('color');
        $busquedaCategoria = $request->query('categoria');

        $marcas = Marcas::where('estatus', 1)->orderBy('nombre')->paginate(10);

        return view('Marcas.index', compact('marcas'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Marcas $marcas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marcas $marca)
    {
        //enviar los dos datos a la vista
        return view('Marcas.edit', compact('marca'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Marcas $marca)
    {
        DB::beginTransaction();
        try {
            $nombre = $request->txtnombre;

            $marca->nombre = ucfirst(strtolower($nombre));

            $marca->save();


            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            session()->flash("incorrect", "Error al actualizar");
            return redirect()->route('marcas.index');
        }
        session()->flash("correcto", "Categoria actualizada correctamente");
        return redirect()->route('marcas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Marcas $marcas)
    {
        //
    }
    public function desactivar(Marcas $id)
    {
        DB::beginTransaction();
        try {
            //actualizamos los datos de categoria
            $id->estatus = 0;
            $id->deleted_at = now();
            $id->save();



            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            session()->flash("incorrect", "Error al eliminar el registro");
            return redirect()->route('marcas.index');
        }
        session()->flash("correcto", "Marca eliminado correctamente");
        return redirect()->route('marcas.index');
    }
}
