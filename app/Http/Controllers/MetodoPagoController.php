<?php

namespace App\Http\Controllers;

use App\Models\Metodo_pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MetodoPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $metodosDePagos = Metodo_pago::where('estatus', 'Activo')->orderBy('nombre')->paginate(10);

        return view('MetodoPago.index',compact('metodosDePagos'));
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
        DB::beginTransaction();
        try {
            $nombre = ucfirst(strtolower($request->txtnombre));

            // Insertar en la tabla 'productos'
            Metodo_pago::create([
                'nombre' => $nombre,
                'estatus' => 'Activo',
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            session()->flash("incorrect", "Error en el registro");
            return redirect()->route('metodopago.index');
        }
        session()->flash("correcto", "Registrado correctamente");
        return redirect()->route('metodopago.index');

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
        $metodoDePago = Metodo_pago::where('estatus', 'Activo')->where('id',$id)->first();
        return view('MetodoPago.edit',compact('metodoDePago'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        DB::beginTransaction();
        try {
            $metodoDePago = Metodo_pago::where('estatus', 'Activo')->where('id',$id)->first();
            $nombre = $request->txtnombre;

            $metodoDePago->nombre = ucfirst(strtolower($nombre));

            $metodoDePago->save();


            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            session()->flash("incorrect", "Error al actualizar");
            return redirect()->route('metodopago.index');
        }
        session()->flash("correcto", "Metodo actualizada correctamente");
        return redirect()->route('metodopago.index');
    }



    public function desactivar(string $id)
    {

        $metodoDePago = Metodo_pago::where('estatus', 'Activo')->where('id',$id)->first();
        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.
        try {

            //estatus la categoria que se llamo tipo antes por tanta modificacion del cliente
            $metodoDePago->estatus = 'Desactivado';
            $metodoDePago->deleted_at = now();
            $metodoDePago->save();

            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            //si retorna un error de sql lo veremos en pantalla
            //return $th->getMessage();
            session()->flash("incorrect", "Error al eliminar el registro");
            return redirect()->route('metodopago.index');
        }

        session()->flash("correcto", "Eliminado correctamente");
        return redirect()->route('metodopago.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
