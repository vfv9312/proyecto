<?php

namespace App\Http\Controllers;

use App\Models\Catalago_ubicaciones;
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
        //Consulta para mostras los datos de las personas y paginar de 5 en 5
        $clientes = clientes::join('personas', 'personas.id', '=', 'clientes.id_persona')
            ->where('clientes.estatus', 1)
            ->select('clientes.id', 'clientes.comentario', 'personas.nombre', 'personas.apellido', 'personas.telefono', 'personas.email', 'personas.fecha_nacimiento')
            ->orderBy('clientes.updated_at', 'desc')
            ->paginate(5); // Mueve paginate() aquí para que funcione correctamente

        //consulta para conseguir datos de la direccion
        $direcciones = direcciones::join('direcciones_clientes', 'direcciones_clientes.id_direccion', '=', 'direcciones.id')
            ->join('clientes', 'clientes.id', '=', 'direcciones_clientes.id_cliente')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->select('clientes.id', 'direcciones.id as id_direccion', 'catalago_ubicaciones.municipio', 'catalago_ubicaciones.localidad', 'direcciones.calle', 'direcciones.num_exterior', 'direcciones.num_interior', 'direcciones.referencia')
            ->where('clientes.estatus', 1)
            ->orderBy('clientes.updated_at', 'desc')
            ->get();
        //enviamos todas las colonias
        $catalogo_colonias = Catalago_ubicaciones::orderBy('localidad')->get();

        //vemos la vista index de clientes y le pasamos dos variables que son nuestas consultas
        return view('clientes.index', compact('clientes', 'direcciones', 'catalogo_colonias'));
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
            //En este código, required indica que el campo es obligatorio, valida que el campo solo contenga números, espacios, guiones, signos más y paréntesis, y min:10 valida que el campo tenga al menos 10 caracteres.
            $request->validate([
                'txttelefono' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            ], [
                'txttelefono.required' => 'El telefono en Mexico debe tener 10 digitos'
            ]);

            // Insertar en la tabla 'personas'
            /**strtolower($request->txtnombre) convierte todo el nombre a minúsculas y
             *  luego ucfirst() convierte la primera letra a mayúscula. Lo mismo se hace para el apellido.
             * Para convertir la primera letra de cada palabra a mayúscula, puedes usar la función ucwords() de PHP
             */
            $persona = personas::create([
                'nombre' => ucwords(strtolower($request->txtnombre)),
                'apellido' => ucwords(strtolower($request->txtapellido)),
                'telefono' => $request->txttelefono,
                'email' => strtolower($request->txtemail),
                'estatus' => 1,
            ]);
            // Insertar en la tabla 'clientes' usando el ID de persona
            //comentarios es el RFC al final si necesitan ese dato y comentarios no asi que uso ese campo para guardar RFC del cliente
            $cliente = clientes::create([
                'id_persona' => $persona->id,
                'comentario' => strtoupper($request->txtrfc),
                'estatus' => 1
            ]);
            //si colonia o calle tienen datos entonces ingrese los datos
            if ($request->txtcolonia || $request->txtcalle) {
                // insertar tabla direcion
                $direccion = direcciones::create([
                    'id_ubicacion' => $request->txtcolonia,
                    'calle' => strtolower($request->txtcalle),
                    'referencia' => strtolower($request->txtreferencia),
                    'num_exterior' => strtolower($request->txtnum_exterior),
                    'num_interior' => strtolower($request->txtnum_interior),
                    'estatus' => 1
                ]);
                //insertar en la tabla direcciones_clientes los id de direcciones de cada cliente
                $catalogo_direcciones = direcciones_clientes::create([
                    'id_cliente' => $cliente->id,
                    'id_direccion' => $direccion->id,
                    'estatus' => 1
                ]);
            } else {
                //si no tiene entonces solo darles valor de true para que en el mensaje de final diga que se agrego bien
                $catalogo_direcciones = true;
                $direccion = true;
            }

            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            /*si retorna un error de sql lo veremos en pantalla*/
            return $th->getMessage();
            //y que la ultima consulta sea false para mandar msj que salio mal la consulta
            $catalogo_direcciones = false;
        }
        if ($catalogo_direcciones && $direccion) {
            session()->flash("correcto", "Cliente registrado correctamente");
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
    public function edit(Request $request, clientes $cliente)
    {
        //id de direcciones
        $idDireccion = $request->input('direccion');

        //conseguir al primer empleado que esta con estatus 1 y tengan el mismo id_empleado
        $persona = personas::where('id', $cliente->id_persona)
            ->where('estatus', 1)
            ->first();

        //consulta para conseguir datos de la direccion
        $direcciones = direcciones::join('catalago_ubicaciones as cu', 'cu.id', '=', 'direcciones.id_ubicacion')
            ->where('direcciones.id', $idDireccion)
            ->where('direcciones.estatus', 1)
            ->select('direcciones.id', 'cu.municipio', 'cu.localidad', 'direcciones.calle', 'direcciones.num_exterior', 'direcciones.num_interior', 'direcciones.referencia')
            ->first();

        //enviamos todas las colonias
        $catalogo_colonias = Catalago_ubicaciones::all();
        //enviar los dos datos a la vista
        return view('clientes.edit', compact('cliente', 'persona', 'direcciones', 'catalogo_colonias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, clientes $clientes)
    {
        //guardamos los datos recibidos en el $request por los input en variables
        $idCliente = $request->input('id_cliente');
        $idPersona = $request->input('id_persona');
        $nombreCliente = $request->input('txtnombre');
        $apellidoCliente = $request->input('txtapellido');
        $telefonoCliente = $request->input('txttelefono');
        $emailCliente = $request->input('txtemail');
        $idDireccion = $request->input('id_direccion');
        $coloniaCliente = $request->input('txtcolonia');
        $calleCliente = $request->input('txtcalle');
        $numExterior = $request->input('txtnum_exterior');
        $numInterior = $request->input('txtnum_interior');
        $numReferencia = $request->input('txtreferencia');
        $rfcCliente = $request->input('txtrfc');


        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.
        try {

            $tablaCliente = clientes::where('id', $idCliente)
                ->where('estatus', 1)
                ->first();

            $tablaPersona = personas::where('id', $idPersona)
                ->where('estatus', 1)
                ->first();

            $tablaDireccion = direcciones::where('id', $idDireccion)
                ->first();

            $datosColonia = Catalago_ubicaciones::where('id', $coloniaCliente)
                ->first();


            if ($rfcCliente) {
                //Actualizar la tabla cliente
                $actualizadocliente = $tablaCliente->update([
                    'comentario' => $rfcCliente,
                ]);
            }


            if ($nombreCliente && $apellidoCliente &&  $telefonoCliente) {
                //Actualizar la tabla persona
                $actualizadoPersona = $tablaPersona->update([
                    'nombre' => $nombreCliente,
                    'apellido' => $apellidoCliente,
                    'telefonoCliente' => $telefonoCliente,
                    'email' => $emailCliente,
                ]);
            }


            if ($datosColonia) {
                $actualizarColonia = $tablaDireccion->update([
                    'id_ubicacion' => $coloniaCliente,
                ]);
            }

            if ($calleCliente | $numExterior | $numInterior | $numReferencia) {
                $actualizarDireccion = $tablaDireccion->update([
                    'calle' => $calleCliente,
                    'num_exterior' => $numExterior,
                    'num_interior' => $numInterior,
                    'referencia' => $numReferencia
                ]);
            }

            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            return $th->getMessage();
            $tablaDireccion  = false;
        }
        if ($tablaDireccion) {
            session()->flash("correcto", "Actualizado correctamente");
            return redirect()->route('clientes.index');
        } else {
            session()->flash("incorrect", "Error al actualizar");
            return redirect()->route('clientes.index');
        }
    }

    public function desactivar(clientes $id)
    {
        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.
        try {
            //en este caso es id por que en la ruta asi dije que se llamaria PUT clientes/{id}/desactivar ............. clientes.desactivar › ClientesController@desactivar
            //conseguir el primer precio del producto que esten con estatus 1 y tengan el mismo id_producto
            $tablaCliente = clientes::where('id', $id->id)
                ->where('estatus', 1)
                ->first();
            //estatus de producto actualizarlo a 0 y la fecha de eliminacion tambien
            $id->estatus = 0;
            $id->deleted_at = now();
            $clienteDesactivado = $id->save();



            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            //si retorna un error de sql lo veremos en pantalla
            return $th->getMessage();
            $clienteDesactivado = false;
        }
        if ($clienteDesactivado) {
            session()->flash("correcto", "Cliente eliminado correctamente");
            return redirect()->route('clientes.index');
        } else {
            session()->flash("incorrect", "Error al eliminar el registro");
            return redirect()->route('clientes.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(clientes $clientes)
    {
        //
    }
}
