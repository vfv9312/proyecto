<?php

namespace App\Http\Controllers;

use App\Models\ClaveEliminacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClaveEliminacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nombreEmpleado = Auth::user()->name;
        $claves = ClaveEliminacion::where('creado_por', $nombreEmpleado)->orderBy('id', 'desc')->paginate(10);
        $ultimoRegistro = ClaveEliminacion::where('estatus', 1)->where('creado_por', $nombreEmpleado)->first();


        return view('ClaveEliminacion.eliminacionIndex', compact('claves', 'ultimoRegistro'));
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
        DB::beginTransaction();
        try {
            $nombreEmpleado = Auth::user()->name;
            $uno = $request->input('code-1');
            $dos = $request->input('code-2');
            $tres = $request->input('code-3');
            $cuatro = $request->input('code-4');
            $cinco = $request->input('code-5');
            $seis = $request->input('code-6');
            $codigoCompleto = $uno . $dos . $tres . $cuatro . $cinco . $seis;


            $ultimoRegistro = ClaveEliminacion::where('creado_por', $nombreEmpleado)->latest()->first();

            if ($ultimoRegistro) {
                $ultimoRegistro->update([
                    'deleted_at' => now(),
                    'estatus' => 0,
                ]);
            }
            $ClaveNueva = ClaveEliminacion::create([
                'creado_por' => $nombreEmpleado,
                'clave' => $codigoCompleto,
                'estatus' => 1,
            ]);



            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            session()->flash("incorrect", "Error agregar clave nueva");
            return redirect()->route('eliminacion.index');
        }
        session()->flash("correcto", "Clave actualizada correctamente");
        return redirect()->route('eliminacion.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
