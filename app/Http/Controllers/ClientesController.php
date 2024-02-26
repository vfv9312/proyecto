<?php

namespace App\Http\Controllers;

use App\Models\clientes;
use App\Models\direcciones;
use App\Models\direcciones_clientes;
use App\Models\personas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $clientes = clientes::join('personas', 'personas.id', '=', 'clientes.id_persona')
            ->where('clientes.estatus', 1)
            ->select('clientes.id', 'personas.nombre', 'personas.apellido', 'personas.telefono', 'personas.email', 'personas.fecha_nacimiento')
            ->orderBy('clientes.updated_at', 'desc')
            ->paginate(5); // Mueve paginate() aquí para que funcione correctamente

        $direcciones = direcciones::join('direcciones_clientes', 'direcciones_clientes.id_direccion', '=', 'direcciones.id')
            ->join('clientes', 'clientes.id', '=', 'direcciones_clientes.id_cliente')
            ->select('clientes.id', 'direcciones.direccion')
            ->where('clientes.estatus', 1)
            ->orderBy('clientes.updated_at', 'desc')
            ->get();



        return view('clientes.index', compact('clientes', 'direcciones'));
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
        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.
        try {

            // Insertar en la tabla 'personas'
            $persona = personas::create([
                'nombre' => $request->txtnombre,
                'apellido' => $request->txtapellido,
                'telefono' => $request->txttelefono,
                'email' => $request->txtemail,
                'fecha_nacimiento' => $request->txtfecha_nacimiento,
                'estatus' => 1,
            ]);
            // Insertar en la tabla 'clientes' usando el ID de persona
            $cliente = clientes::create([
                'id_persona' => $persona->id,
                'comentario' => $request->txtdescripcion,
                'estatus' => 1
            ]);
            // insertar tabla direcion
            $direccion = direcciones::create([
                'direccion' => $request->txtdireccion,
                'referencia' => $request->txtreferencia,
                'estatus' => 1
            ]);
            //insertar en la tabla direcciones_clientes los id de direcciones de cada cliente
            $catalogo_direcciones = direcciones_clientes::create([
                'id_cliente' => $cliente->id,
                'id_direccion' => $direccion->id,
                'estatus' => 1
            ]);


            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            /*si retorna un error de sql lo veremos en pantalla*/
            return $th->getMessage();
            //y que la ultima consulta sea false para mandar msj que salio mal la consulta
            $catalogo_direcciones = false;
        }
        if ($catalogo_direcciones && $direccion) {
            session()->flash("correcto", "Producto registrado correctamente");
            return redirect()->route('clientes.index');
        } else {
            session()->flash("incorrect", "Error al registrar");
            return redirect()->route('clientes.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(clientes $clientes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(clientes $cliente)
    {
        //conseguir al primer empleado que esta con estatus 1 y tengan el mismo id_empleado
        $persona = personas::where('id', $cliente->id_persona)
            ->where('estatus', 1)
            ->first();

        $direcciones = direcciones::join('direcciones_clientes', 'direcciones_clientes.id_direccion', '=', 'direcciones.id')
            ->join('clientes', 'clientes.id', '=', 'direcciones_clientes.id_cliente')
            ->select('clientes.id', 'direcciones.direccion', 'direcciones.referencia', 'direcciones.id as id_direcciones')
            ->where('clientes.estatus', 1)
            ->where('clientes.id', $cliente->id)
            ->orderBy('clientes.updated_at', 'desc')
            ->get();

        //enviar los dos datos a la vista
        return view('clientes.edit', compact('cliente', 'persona', 'direcciones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, clientes $clientes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(clientes $clientes)
    {
        //
    }
}
