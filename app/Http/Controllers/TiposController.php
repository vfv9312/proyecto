<?php

namespace App\Http\Controllers;

use App\Models\Modo;
use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TiposController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $busqueda = $request->query('adminlteSearch');

        //Consulta para mostras los datos de las personas y paginar de 5 en 5
        $tiposProductos = Modo::where('estatus', 1)
        ->where(function ($query) use ($busqueda) {
            $query->where('nombre', 'LIKE', "%{$busqueda}%");
        })
        ->select('*')
        ->orderBy('updated_at', 'desc')
        ->paginate(5); // Mueve paginate() aquí para que funcione correctamente

return view('tipos.index', compact('tiposProductos', 'busqueda'));
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

        $nombreTipo = $request->input('txtnombre');

        $existencia = Modo::whereRaw('LOWER(nombre) = ?', [strtolower($nombreTipo)])->first();

        if ($existencia) {
            // Si ya existe, retorna un mensaje de error
            session()->flash("incorrect", "El tipo de producto ya existe.");
            return redirect()->route('tipos.index');
        }

        DB::beginTransaction();
        try {
            Modo::create([
                'nombre' => $nombreTipo,
                'estatus' => 1
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            session()->flash("incorrect", "Error al registrar");
            return redirect()->route('tipos.index');
        }
        session()->flash("correcto", "Registrado correctamente");
        return redirect()->route('tipos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tiposProductos = Modo::find($id);

        //enviar los dos datos a la vista
        return view('tipos.edit', compact('tiposProductos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $editTipo = Modo::find($id);
        $nombreTipo = $request->input('nombre');


         // Verifica si ya existe una localidad con el mismo nombre (sin importar mayúsculas/minúsculas)
    $existenciaTipo = Modo::whereRaw('LOWER(nombre) = ?', [strtolower($nombreTipo)])->first();

        if ($existenciaTipo) {
            // Si ya existe, retorna un mensaje de error
            session()->flash("incorrect", "El tipo de producto ya existe.");
            return redirect()->route('tipos.index');
        }

    DB::beginTransaction();
        try {

            $editTipo->update([
                'nombre' => $nombreTipo,
            ]);
            $editTipo->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            //return $th->getMessage();

            session()->flash("incorrect", "Error al actualizar");
            return redirect()->route('tipos.index');
        }
        session()->flash("correcto", "actualizacion correctamente");
        return redirect()->route('tipos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tipos = Modo::find($id);

        if ($tipos) {
            $tipos->delete();
            return redirect()->route('tipos.index')->with('success', 'Colonia eliminada con éxito.');
        } else {
            return redirect()->route('tipos.index')->with('error', 'Colonia no encontrada.');
        }

    }
}
