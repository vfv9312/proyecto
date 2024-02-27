<?php

namespace App\Http\Controllers;

use App\Models\Catalago_ubicaciones;
use App\Models\clientes;
use App\Models\direcciones;
use App\Models\direcciones_clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

class DireccionesClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return 'Listo';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return 'listo';
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
    public function show(direcciones_clientes $direcciones_clientes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(clientes $direccione)
    {
        $cliente = $direccione;
        $catalogo_colonias = Catalago_ubicaciones::all();
        //enviar los dos datos a la vista
        return view('direcciones.edit', compact('cliente', 'catalogo_colonias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, direcciones_clientes $direcciones_clientes)
    {
        //guardamos los datos recibidos en el $request por los input en variables
        $cliente = $request->input('cliente');
        $colonia = $request->input('txtcolonia');
        $calle = $request->input('txtcalle');
        $num_exterior = $request->input('txtnum_exterior');
        $num_interior = $request->input('txtnum_interior');
        $referencia = $request->input('txtreferencia');

        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.
        try {
            //insertamos datos en direcciones
            $direccion = direcciones::create([
                'id_ubicacion' => $colonia,
                'calle' => strtolower($calle),
                'referencia' => strtolower($referencia),
                'num_exterior' => strtolower($num_exterior),
                'num_interior' => strtolower($num_interior),
                'estatus' => 1
            ]);
            //insertar en la tabla direcciones_clientes los id de direcciones de cada cliente y su direccion
            $catalogo_direcciones = direcciones_clientes::create([
                'id_cliente' => $cliente,
                'id_direccion' => $direccion->id,
                'estatus' => 1

            ]);

            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            /*si retorna un error de sql lo veremos en pantalla*/
            return $th->getMessage();
            $catalogo_direcciones = false;
        }

        if ($catalogo_direcciones && $direccion) {
            session()->flash("correcto", "Nueva direccion registrada correctamente");
            return redirect()->route('clientes.index');
        } else {
            session()->flash("incorrect", "Error al registrar");
            return redirect()->route('clientes.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(direcciones_clientes $direcciones_clientes)
    {
        //

    }
}
