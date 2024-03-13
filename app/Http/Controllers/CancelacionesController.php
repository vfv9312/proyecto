<?php

namespace App\Http\Controllers;

use App\Models\Cancelaciones;
use App\Models\Orden_recoleccion;
use Illuminate\Http\Request;

class CancelacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $datosEnvio = Orden_recoleccion::join('preventas', 'preventas.id', '=', 'orden_recoleccions.id_preventa')
            ->join('cancelaciones', 'cancelaciones.id', '=', 'orden_recoleccions.id_cancelacion')
            ->join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('empleados', 'empleados.id', '=', 'preventas.id_empleado')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->join('personas as personasClientes', 'personasClientes.id', '=', 'clientes.id_persona')
            ->join('personas as personasEmpleado', 'personasEmpleado.id', '=', 'empleados.id_persona')
            ->select(
                'orden_recoleccions.id as idRecoleccion',
                'personasClientes.nombre as nombreCliente',
                'personasClientes.apellido as apellidoCliente',
                'orden_recoleccions.created_at as fechaCreacion',
                'orden_recoleccions.deleted_at as fechaEliminacion',
                'catalago_ubicaciones.localidad as colonia',
                'direcciones.calle',
                'direcciones.num_exterior',
                'direcciones.num_interior',
                'direcciones.referencia',
                'cancelaciones.nombre as categoriaCancelacion',

            )
            ->paginate(5);


        return view('cancelaciones.index', compact('datosEnvio'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cancelaciones $cancelaciones)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cancelaciones $cancelaciones)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cancelaciones $cancelaciones)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cancelaciones $cancelaciones)
    {
        //
    }
}
