<?php

namespace App\Http\Controllers;

use App\Models\precios_servicios;
use App\Models\servicios;
use App\Models\ventas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        /* $servicios = servicios::join('ventas', 'ventas.id', '=', 'servicios.id_venta')
            ->join('clientes', 'clientes.id', '=', 'ventas.id_cliente')
            ->join('personas', 'personas.id', '=', 'clientes.id_persona')
            ->where('servicios.estatus', 1)
            ->where('ventas.estatus', 1)
            ->select('servicios.id_venta', 'servicios.tipo_de_proyecto', 'servicios.descripcion', 'servicios.modelo', 'servicios.color', 'servicios.cantidad', 'servicios.precio_unitario', 'personas.nombre as nombre_cliente', 'personas.apellido as apellido_cliente', 'ventas.created_at as fecha_creacion')
            ->paginate(5);*/

        return view('servicios.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $servicios = servicios::join('ventas', 'ventas.id', '=', 'servicios.id_venta')
            ->join('clientes', 'clientes.id', '=', 'ventas.id_cliente')
            ->join('personas', 'personas.id', '=', 'clientes.id_persona')
            ->where('servicios.estatus', 1)
            ->where('ventas.estatus', 1)
            ->select('servicios.id_venta', 'servicios.tipo_de_proyecto', 'servicios.descripcion', 'servicios.modelo', 'servicios.color', 'servicios.cantidad', 'servicios.precio_unitario', 'personas.nombre as nombre_cliente', 'personas.apellido as apellido_cliente', 'ventas.created_at as fecha_creacion');

        $empleados = DB::table('empleados')
            ->join('personas', 'empleados.id_persona', '=', 'personas.id')
            ->where('empleados.estatus', 1)
            ->select('personas.nombre', 'personas.apellido', 'personas.telefono', 'empleados.id', 'empleados.rol_empleado')
            ->get();

        $clientes = DB::table('clientes')
            ->join('personas', 'clientes.id_persona', '=', 'personas.id')
            ->where('clientes.estatus', 1)
            ->select('personas.nombre', 'personas.apellido', 'personas.telefono', 'clientes.id')
            ->get();

        $direccionesCliente = DB::table('clientes')
            ->join('direcciones_clientes', 'clientes.id', '=', 'direcciones_clientes.id_cliente')
            ->join('direcciones', 'direcciones_clientes.id_direccion', '=', 'direcciones.id')
            ->where('clientes.estatus', 1)
            ->orderBy('direcciones.created_at', 'desc')
            ->select('clientes.id', 'direcciones.direccion')
            ->get();

        return view('servicios.crear', compact('servicios', 'empleados', 'clientes', 'direccionesCliente'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.
        try {

            $venta = ventas::create([
                'estatus' => 2
            ]);

            // Insertar en la tabla 'servicios'
            $servicio = servicios::create([
                'id_venta' => $venta->id,
                'tipo_de_proyecto' => $request->txttio_producto,
                'descripcion' => $request->txtdescripcion,
                'modelo' => $request->txtmodelo,
                'color' => $request->txtcolor,
                'cantidad' => $request->txtcantidad,
                'precio_unitario' => $request->txtprecio_unitario,
                'estatus' => 2
            ]);

            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            return $th->getMessage();
            $servicio = false;
        }
        if ($servicio) {
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
