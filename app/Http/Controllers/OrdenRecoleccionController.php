<?php

namespace App\Http\Controllers;

use App\Models\Orden_recoleccion;
use App\Models\Preventa;
use Illuminate\Http\Request;

class OrdenRecoleccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $preventas = Preventa::join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('personas', 'personas.id', '=', 'clientes.id_persona')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_cliente')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->join('empleados', 'empleados.id', '=', 'preventas.id_empleado')
            ->where('preventas.estatus', 2)
            ->orWhere('preventas.estatus', 3)
            ->select(
                'preventas.estatus',
                'personas.nombre as nombreCliente',
                'personas.apellido as apellidoCliente',
                'personas.telefono',
                'clientes.comentario as rfc',
                'catalago_ubicaciones.localidad',
                'direcciones.calle',
                'direcciones.num_exterior',
                'direcciones.num_interior',
                'direcciones.referencia'
            )
            ->get();
        return view('Principal.ordenRecoleccion.recolecciones', compact('preventas'));
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
    public function show(Orden_recoleccion $orden_recoleccion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orden_recoleccion $orden_recoleccion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Orden_recoleccion $orden_recoleccion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orden_recoleccion $orden_recoleccion)
    {
        //
    }
}
