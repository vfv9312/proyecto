<?php

namespace App\Http\Controllers;

use App\Models\Catalago_recepcion;
use App\Models\TiempoAproximado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TiempoAproximadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $existeTiempoHoy = TiempoAproximado::whereDate('created_at', date('Y-m-d'))->orderBy('created_at', 'desc')->select('tiempo')->first();
        return view('Tiempo_aproximado.index', compact('existeTiempoHoy'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        DB::beginTransaction();

        try {
            //code...
            $validatedData = $request->validate([
                'tiempo' => 'required|date_format:H:i',
            ], [
                'tiempo.required' => 'Por favor, ingresa el tiempo aproximado de atención.',
                'tiempo.date_format' => 'El tiempo debe estar en el formato correcto (HH:MM).',
            ]);

            $tiempo = $request->input('tiempo');


            $existeTiempoHoy = TiempoAproximado::whereDate('created_at', date('Y-m-d'))->exists();

            if ($existeTiempoHoy) {
                $creartiempo = TiempoAproximado::create([
                    'tiempo' => $tiempo,
                ]);
            } else {
                $creartiempo = TiempoAproximado::create([
                    'tiempo' => $tiempo,
                ]);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            //return $th->getMessage();
            session()->flash("incorrect", "Error al registrar");
            return redirect()->route('TiempoAproximado.index');
        }
        session()->flash("correcto", "Producto registrado correctamente");
        return redirect()->route('TiempoAproximado.index');
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
    public function show(Catalago_recepcion $catalago_recepcion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Catalago_recepcion $catalago_recepcion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Catalago_recepcion $catalago_recepcion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Catalago_recepcion $catalago_recepcion)
    {
        //
    }
}
