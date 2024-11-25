<?php

namespace App\Http\Controllers;

use App\Models\Cancelaciones;
use App\Models\Orden_recoleccion;
use App\Models\Preventa;
use Carbon\Carbon;
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
        $palabras = explode(' ', $busqueda); // Divide la cadena de búsqueda en palabras

        //
        $preventas = Preventa::join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
        ->join('personas', 'personas.id', '=', 'clientes.id_persona')
        ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
        ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
        ->leftjoin('cancelaciones','cancelaciones.id','=','preventas.id_cancelacion')
        ->leftJoin('orden_recoleccions', function ($join) {
            $join->on('orden_recoleccions.id_preventa', '=', 'preventas.id')
                ->orOn('orden_recoleccions.id_preventaServicio', '=', 'preventas.id');
        })
        ->leftjoin('folios', 'folios.id', '=', 'orden_recoleccions.id_folio')
        ->leftjoin('folios_servicios', 'folios_servicios.id', '=', 'orden_recoleccions.id_folio_servicio')
        ->whereIn('preventas.tipo_de_venta', ['Entrega', 'Servicio']) //whereIn para filtrar las preventas
        ->WhereIn('preventas.estado', ['Recolectar', 'Revision', 'Entrega', 'Listo', 'Cancelado'])
        ->WhereNull('preventas.deleted_at')
        ->whereNotNull('preventas.id_cancelacion')
        ->where(function ($query) use ($palabras) {
            foreach ($palabras as $palabra) {
                $query->where(function ($query) use ($palabra) {
                    $query->where('personas.telefono', 'LIKE', "%{$palabra}%")
                        ->orWhere('personas.nombre', 'LIKE', "%{$palabra}%")
                        ->orWhere('personas.apellido', 'LIKE', "%{$palabra}%")
                        ->orWhere('catalago_ubicaciones.localidad', 'LIKE', "%{$palabra}%")
                        ->orWhere('catalago_ubicaciones.localidad', 'LIKE', "%{$palabra}%");
                });
            }
        });

    // Búsqueda por número de folio
    if (preg_match('/^[A-Z]\d+$/', $busqueda)) {
        $letra = substr($busqueda, 0, 1);
        $numero = (int) substr($busqueda, 1);

        $preventas->orWhere(function ($query) use ($letra, $numero) {
            $query->where('folios.letra_actual', $letra)
                ->where('folios.ultimo_valor', $numero);
        });
    }
    if (ctype_digit($busqueda)) {

        $numero = (int) $busqueda;

        $preventas->orWhere(function ($query) use ($numero) {
            $query->where('folios_servicios.ultimo_valor', $numero);
        });
    }
    if($filtroMotivo) {
        $preventas->where('cancelaciones.id', $filtroMotivo);
    }

    if ($filtroFecha_inicio && $fecha_fin) {

        $Inicio = Carbon::createFromFormat('Y-m-d', $filtroFecha_inicio)->startOfDay();
        $Fin = Carbon::createFromFormat('Y-m-d', $fecha_fin)->endOfDay();

        $preventas->whereBetween('orden_recoleccions.created_at', [$Inicio, $Fin]);
    }

    $preventas = $preventas->select(
        'orden_recoleccions.id as idRecoleccion',
        'orden_recoleccions.created_at as fechaCreacion',
        'orden_recoleccions.created_at',
        'folios.letra_actual as letraActual',
        'folios.ultimo_valor as ultimoValor',
        'folios_servicios.ultimo_valor as ultimoValorServicio',
        'preventas.id as idPreventa',
        'preventas.estado as estatusPreventa',
        'preventas.tipo_de_venta as tipoVenta',
        'preventas.id_cancelacion',
        'preventas.nombre_empleado as nombreEmpleado',
        'personas.nombre as nombreCliente',
        'personas.apellido as apellidoCliente',
        'personas.telefono',
        'personas.email as correo',
        'clientes.comentario as rfc',
        'catalago_ubicaciones.localidad as colonia',
        'direcciones.calle',
        'direcciones.num_exterior',
        'direcciones.num_interior',
        'direcciones.referencia',
    )
        ->orderBy('orden_recoleccions.updated_at', 'desc')

        ->paginate(100)->appends(['adminlteSearch' => $busqueda, 'fecha_inicio' => $filtroFecha_inicio, 'fecha_fin' => $fecha_fin, 'filtroMotivo' => $filtroMotivo]); // Mueve paginate() aquí para que funcione correctamente


        $cancelaciones = Cancelaciones::where('estatus', 1)
            ->orderBy('cancelaciones.nombre', 'desc')->get();


        return view('cancelaciones.index', compact('preventas', 'cancelaciones', 'filtroMotivo','filtroFecha_inicio','fecha_fin'));
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
