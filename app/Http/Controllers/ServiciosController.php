<?php

namespace App\Http\Controllers;

use App\Models\precios_servicios;
use App\Models\servicios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $servicios = servicios::join('precios_servicios', 'servicios.id', '=', 'precios_servicios.id_servicio')
            ->where('servicios.estatus', 1)
            ->select('servicios.nombre_de_servicio', 'servicios.descripcion', 'precios_servicios.precio')
            ->paginate(5); // Mueve paginate() aquí para que funcione correctamente

        return view('servicios.index', compact('servicios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.
        try {
            // Insertar en la tabla 'productos'
            $servicio = servicios::create([
                'nombre_de_servicio' => $request->txtservicio,
                'descripcion' => $request->txtdescripcion,
                'estatus' => 1
            ]);

            // Insertar en la tabla 'precios_productos' usando el ID del producto
            $precioServicio = precios_servicios::create([
                'id_servicio' => $servicio->id,
                'precio' => $request->txtprecio,
                'estatus' => 1
            ]);
            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            return $th->getMessage();
            $precioServicio = 0;
        }
        if ($precioServicio == true) {
            session()->flash("correcto", "Producto registrado correctamente");
            return redirect()->route('servicios.index');
        } else {
            session()->flash("incorrect", "Error al registrar");
            return redirect()->route('servicios.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(servicios $servicios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(servicios $servicios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, servicios $servicios)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(servicios $servicios)
    {
        //
    }
}
