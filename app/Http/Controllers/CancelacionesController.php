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
    public function index(Request $request)
    {
        $busqueda = $request->query('adminlteSearch');
        $filtroMotivo = $request->query('motivo');
        $filtroFecha_inicio = $request->query('fecha_inicio');
        $fecha_fin = $request->query('fecha_fin');
        //
        $datosEnvio = Orden_recoleccion::join('preventas', 'preventas.id', '=', 'orden_recoleccions.id_preventa')
            ->join('cancelaciones', 'cancelaciones.id', '=', 'orden_recoleccions.id_cancelacion')
            ->join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('empleados', 'empleados.id', '=', 'preventas.id_empleado')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->join('personas as personasClientes', 'personasClientes.id', '=', 'clientes.id_persona')
            ->join('personas as personasEmpleado', 'personasEmpleado.id', '=', 'empleados.id_persona')
            ->where(function ($query) use ($busqueda) {
                $query->where('personasClientes.telefono', 'LIKE', "%{$busqueda}%")
                    ->orWhere('personasClientes.nombre', 'LIKE', "%{$busqueda}%")
                    ->orWhere('personasClientes.apellido', 'LIKE', "%{$busqueda}%")
                    ->orWhere('catalago_ubicaciones.localidad', 'LIKE', "%{$busqueda}%")
                    ->orWhere('catalago_ubicaciones.localidad', 'LIKE', "%{$busqueda}%");
            });
        if ($filtroMotivo) {
            $datosEnvio->where('orden_recoleccions.id_cancelacion', $filtroMotivo);
        }

        if ($filtroFecha_inicio && $fecha_fin) {
            $datosEnvio->whereBetween('orden_recoleccions.created_at', [$filtroFecha_inicio, $fecha_fin]);
        }
        $datosEnvio = $datosEnvio->select(
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
            ->orderBy('clientes.updated_at', 'desc')
            ->paginate(5);

        $cancelaciones = Cancelaciones::orderBy('cancelaciones.nombre', 'desc')->get();


        return view('cancelaciones.index', compact('datosEnvio', 'cancelaciones'));
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
