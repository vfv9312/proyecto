<?php

namespace App\Http\Controllers;

use App\Models\Catalago_ubicaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ColoniasController extends Controller
{
    private $id_estado = 7;
    private $estado = 'Chiapas';
    private $id_municipio = 101;
    private $id_localidad = 123456789;
    private $municipio = "Tuxtla Gutiérrez";
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $busqueda = $request->query('adminlteSearch');

                //Consulta para mostras los datos de las personas y paginar de 5 en 5
                $coloniasTuxtla = Catalago_ubicaciones::where('estatus', 1)
                ->where(function ($query) use ($busqueda) {
                    $query->where('localidad', 'LIKE', "%{$busqueda}%")
                        ->orWhere('cp', 'LIKE', "%{$busqueda}%");
                })
                ->select('*')
                ->orderBy('updated_at', 'desc')
                ->paginate(5); // Mueve paginate() aquí para que funcione correctamente

        return view('colonias.index', compact('coloniasTuxtla', 'busqueda'));
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
        $nombreColonia = $request->input('txtnombre') ;
        $codigoPostal = $request->input('codigopostal') ;

         // Verifica si ya existe una localidad con el mismo nombre (sin importar mayúsculas/minúsculas)
    $existingLocalidad = Catalago_ubicaciones::whereRaw('LOWER(localidad) = ?', [strtolower($nombreColonia)])->first();

        if ($existingLocalidad) {
            // Si ya existe, retorna un mensaje de error
            session()->flash("incorrect", "La localidad ya existe.");
            return redirect()->route('colonias.index');
        }


        DB::beginTransaction();
try {
    Catalago_ubicaciones::create([
        'localidad' => $nombreColonia,
        'municipio' => $this->municipio,
        'cp' => $codigoPostal,
        'id_estado' => $this->id_estado ,
        'estado' => $this->estado,
        'id_municipio' => $this->id_municipio,
        'id_localidad' => $this->id_localidad,
        'estatus' => 1
    ]);
        DB::commit();
    } catch (\Throwable $th) {
        DB::rollback();
       // return $th->getMessage();
        session()->flash("incorrect", "Error al registrar");
        return redirect()->route('colonias.index');
    }
        session()->flash("correcto", "Registrado correctamente");
        return redirect()->route('colonias.index');
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
        $coloniasTuxtla = Catalago_ubicaciones::find($id);

        //enviar los dos datos a la vista
        return view('colonias.edit', compact('coloniasTuxtla'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $editColonia = Catalago_ubicaciones::find($id);
        $nombreColonia = $request->input('nombre');
        $codigoPostal = $request->input('cp');

         // Verifica si ya existe una localidad con el mismo nombre (sin importar mayúsculas/minúsculas)
    $existingLocalidad = Catalago_ubicaciones::whereRaw('LOWER(localidad) = ?', [strtolower($nombreColonia)])->first();

        if ($existingLocalidad) {
            // Si ya existe, retorna un mensaje de error
            session()->flash("incorrect", "La localidad ya existe.");
            return redirect()->route('colonias.index');
        }

    DB::beginTransaction();
        try {
            $editColonia->update([
                'localidad' => $nombreColonia,
                'cp' => $codigoPostal
            ]);
            $editColonia->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            //return $th->getMessage();

            session()->flash("incorrect", "Error al actualizar");
            return redirect()->route('colonias.index');
        }
        session()->flash("correcto", "actualizacion correctamente");
        return redirect()->route('colonias.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $colonia = Catalago_ubicaciones::find($id);

        if ($colonia) {
            $colonia->delete();
            return redirect()->route('colonias.index')->with('success', 'Colonia eliminada con éxito.');
        } else {
            return redirect()->route('colonias.index')->with('error', 'Colonia no encontrada.');
        }

    }
}
