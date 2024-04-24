<?php

namespace App\Http\Controllers;

use App\Models\Cancelaciones;
use App\Models\Orden_recoleccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            ->join('folios', 'folios.id', '=', 'orden_recoleccions.id_folio')
            ->join('cancelaciones', 'cancelaciones.id', '=', 'orden_recoleccions.id_cancelacion')
            ->join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->join('personas as personasClientes', 'personasClientes.id', '=', 'clientes.id_persona')
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
            'preventas.nombre_empleado as nombreEmpleado',
            'preventas.nombre_atencion as nombreAtencion',
            'preventas.nombre_quien_recibe as nombreRecibe',
            'folios.letra_actual as letraAcutal',
            'folios.ultimo_valor as ultimoValor',
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

        $cancelaciones = Cancelaciones::where('estatus', 1)
            ->orderBy('cancelaciones.nombre', 'desc')->get();


        return view('cancelaciones.index', compact('datosEnvio', 'cancelaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $cancelaciones = Cancelaciones::where('estatus', 1)
            ->orderBy('cancelaciones.nombre', 'desc')->paginate(5); // Mueve paginate() aquí para que funcione correctamente;

        return view('cancelaciones.agregarCancelacion', compact('cancelaciones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $motivoNuevo = $request->input('txtnombre');

            $cancelaciones = Cancelaciones::create([
                'nombre' => ucfirst(strtolower($motivoNuevo)),
                'estatus' => 1,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            session()->flash("incorrect", "Error al agregar el registro");
            return redirect()->route('cancelar.create');
        }
        session()->flash("correcto", "Motivo de cancelacion agregado correctamente");
        return redirect()->route('cancelar.create');
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
    public function edit(Cancelaciones $cancelar)
    {
        return view('cancelaciones.edit', compact('cancelar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cancelaciones $cancelar)
    {
        DB::beginTransaction();
        try {

            $nombre = $request->input('nombre');
            $cancelar->update([
                'nombre' => $nombre,
                // Agrega aquí otros campos que quieras actualizar
            ]);


            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            session()->flash("incorrect", "Error al actualizar el registro");
            return redirect()->route('cancelar.create');
        }
        session()->flash("correcto", "Motivo de cancelacion actualizado correctamente");
        return redirect()->route('cancelar.create');
    }

    public function desactivar(Cancelaciones $id)
    {
        DB::beginTransaction();
        try {


            $id->estatus = 0;
            $id->deleted_at = now();
            $cancelacionDesactivado = $id->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();

            session()->flash("incorrect", "Error al eliminar el registro");
            return redirect()->route('cancelar.create');
        }
        session()->flash("correcto", "Motivo de cancelacion eliminada correctamente");
        return redirect()->route('cancelar.create');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cancelaciones $cancelaciones)
    {
        //
    }
}
