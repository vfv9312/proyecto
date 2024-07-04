<?php

namespace App\Http\Controllers;

use App\Models\ClaveEliminacion;
use App\Models\precios_productos;
use App\Models\Preventa;
use App\Models\TiempoAproximado;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EliminacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $busqueda = $request->query('adminlteSearch');
        $filtroES = $request->query('entrega_servicio');
        $filtroFecha_inicio = $request->query('fecha_inicio');
        $fecha_fin = $request->query('fecha_fin');
        $filtroEstatus = $request->query('estatus');
        $palabras = explode(' ', $busqueda); // Divide la cadena de búsqueda en palabras
        $datosEntregaCompromisos[] = [
            'fecha' => null,
            'hora' => null,
            'horaEntregaCompromiso' => null,
        ];

        $preventas = Preventa::join('clientes', 'clientes.id', '=', 'preventas.id_cliente')
            ->join('personas', 'personas.id', '=', 'clientes.id_persona')
            ->join('direcciones', 'direcciones.id', '=', 'preventas.id_direccion')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->join('orden_recoleccions', 'orden_recoleccions.id_preventa', '=', 'preventas.id')
            ->leftjoin('folios', 'folios.id', '=', 'orden_recoleccions.id_folio')
            ->whereNull('preventas.deleted_at')
            ->whereIn('preventas.estatus', [3, 4]) //whereIn para filtrar las preventas donde el estatus es 3 o 4.
            ->WhereIn('orden_recoleccions.estatus', [4, 3, 2, 1])
            //->where('id_cancelacion', null)
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

        if ($filtroES) { //E : Entrega , S: Servicio
            $preventas->where('preventas.estatus', $filtroES);
        }

        if ($filtroFecha_inicio && $fecha_fin) {

            $Inicio = Carbon::createFromFormat('Y-m-d', $filtroFecha_inicio)->startOfDay();
            $Fin = Carbon::createFromFormat('Y-m-d', $fecha_fin)->endOfDay();

            $preventas->whereBetween('orden_recoleccions.created_at', [$Inicio, $Fin]);
        }

        //si es algun valor positivo entra 1: Listo, 2: Entrega, 3: Revision, 4: Recoleccion, 5: Cancelacion
        if ($filtroEstatus) {
            if ($filtroEstatus == "5") { //si es 5 entonces entra al if y verifica si tiene algun id_cancelacion
                $preventas->whereNotNull('orden_recoleccions.id_cancelacion');
            } else {
                $preventas->where('orden_recoleccions.estatus', $filtroEstatus);
            }
        }
        $preventas = $preventas->select(
            'orden_recoleccions.id as idRecoleccion',
            'orden_recoleccions.created_at as fechaCreacion',
            'orden_recoleccions.id_cancelacion',
            'orden_recoleccions.estatus', //5 pendiente 4 por recolectar, 3 revision 2 entrega 1 listo 0 eliminado
            'orden_recoleccions.created_at',
            'folios.letra_actual as letraActual',
            'folios.ultimo_valor as ultimoValor',
            'preventas.id as idPreventa',
            'preventas.estatus as estatusPreventa',
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
            ->paginate(200)->appends(['adminlteSearch' => $busqueda, 'entrega_servicio' => $filtroES, 'fecha_inicio' => $filtroFecha_inicio, 'fecha_fin' => $fecha_fin, 'estatus' => $filtroEstatus]); // Mueve paginate() aquí para que funcione correctamente
        foreach ($preventas as $preventa) {
            $fechaCreacion = \Carbon\Carbon::parse($preventa->fechaCreacion);
            $Tiempo = TiempoAproximado::whereDate('created_at', $fechaCreacion->toDateString())->orderBy('created_at', 'desc')->first();
            if ($Tiempo) {
                $fechaHoraArray = explode(' ', $preventa->fechaCreacion);
                $fecha = $fechaHoraArray[0];
                $hora = $fechaHoraArray[1];
                // Crear un objeto DateTime con la hora inicial
                $horaInicial = new DateTime($hora);
                // Sumar el intervalo de tiempo a la hora inicial
                list($horas, $minutos, $segundos) = explode(':', $Tiempo->tiempo);
                $intervalo = new DateInterval(sprintf('PT%dH%dM%dS', $horas, $minutos, $segundos));
                $horaEntregaCompromiso = $horaInicial->add($intervalo);
                // Aquí puedes hacer lo que necesites con $horaEntregaCompromiso
                // Aquí puedes hacer lo que necesites con $horaEntregaCompromiso
                $datosEntregaCompromisos[] = [
                    'fecha' => $fecha,
                    'hora' => $hora,
                    'horaEntregaCompromiso' => $horaEntregaCompromiso->format('H:i:s'),
                ];
            } else {
                $datosEntregaCompromisos[] = [
                    'fecha' => null,
                    'hora' => null,
                    'horaEntregaCompromiso' => null,
                ];
            }
        }
        return view('EliminacionOrden.index', compact('preventas', 'datosEntregaCompromisos', 'busqueda', 'filtroES', 'filtroFecha_inicio', 'fecha_fin', 'filtroEstatus'));
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
            $nombreEmpleado = Auth::user()->name;
            $uno = $request->input('code-1');
            $dos = $request->input('code-2');
            $tres = $request->input('code-3');
            $cuatro = $request->input('code-4');
            $cinco = $request->input('code-5');
            $seis = $request->input('code-6');
            $codigoCompleto = $uno . $dos . $tres . $cuatro . $cinco . $seis;
            $preventas = $request->input('idPreventas');
            // Separa la cadena de texto por la coma
            $ids = explode(',', $preventas);

            //El método pluck('clave') se usa para obtener solo los valores de la columna 'clave' de la colección.
            $claves = ClaveEliminacion::select('clave')
                ->where('estatus', 1)
                ->orderBy('id', 'desc')
                ->get()
                ->pluck('clave');

            //el método contains($codigoCompleto) se usa para verificar si codigoCompleto está en la colección de claves. contains devuelve true si codigoCompleto está en la colección y false en caso contrario.
            $claveEncontrada = $claves->contains($codigoCompleto);

            if ($claveEncontrada) {
                foreach ($ids as $indice => $valor) {
                    // Obtén la instancia del modelo que quieres actualizar
                    $preventa = Preventa::find($valor);
                    // Actualiza los campos que necesitas
                    $preventa->deleted_at = now();
                    $preventa->save();
                }
            } else {
                session()->flash("incorrect", "clave incorrecta");
                return redirect()->route('ordeneliminacion.index');
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            session()->flash("incorrect", "Error al registrar");
            return redirect()->route('ordeneliminacion.index');
        }
        session()->flash("correcto", "Registro eliminado correctamente");
        return redirect()->route('ordeneliminacion.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(precios_productos $precios_productos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(precios_productos $precios_productos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, precios_productos $precios_productos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(precios_productos $precios_productos)
    {
        //
    }
}
