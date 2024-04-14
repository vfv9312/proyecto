<?php

namespace App\Http\Controllers;

use App\Models\Cancelaciones;
use App\Models\Catalago_ubicaciones;
use App\Models\clientes;
use App\Models\Color;
use App\Models\direcciones;
use App\Models\empleados;
use App\Models\Marcas;
use App\Models\Modo;
use App\Models\Orden_recoleccion;
use App\Models\personas;
use App\Models\precios_productos;
use App\Models\productos;
use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RestablecerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Restablecer.index');
    }
    public function cancelaciones(Request $request)
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


        return view('Restablecer.cancelaciones', compact('datosEnvio', 'cancelaciones'));
    }
    public function actualizarCancelacion(Orden_recoleccion $id)
    {
        DB::beginTransaction();
        try {
            $ordenRecoleccion = $id;

            $ordenRecoleccion->update([
                'id_cancelacion' => null
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            // Redirigir al usuario a una página después de la actualización
            session()->flash("incorrect", "Error al restaurar el registro");

            return redirect()->route('Restablecer.cancelaciones');
        }
        session()->flash("correcto", "Restaurado correctamente");
        return redirect()->route('Restablecer.cancelaciones');
    }
    public function clientes(Request $request)
    {
        $busqueda = $request->query('adminlteSearch');

        //Consulta para mostras los datos de las personas y paginar de 5 en 5
        $clientes = clientes::join('personas', 'personas.id', '=', 'clientes.id_persona')
            ->where('clientes.estatus', 0)
            ->where(function ($query) use ($busqueda) {
                $query->where('personas.telefono', 'LIKE', "%{$busqueda}%")
                    ->orWhere('personas.nombre', 'LIKE', "%{$busqueda}%")
                    ->orWhere('personas.apellido', 'LIKE', "%{$busqueda}%")
                    ->orWhere(DB::raw("CONCAT(personas.nombre, ' ', personas.apellido)"), 'LIKE', "%{$busqueda}%");
            })
            ->select('clientes.id', 'clientes.comentario', 'personas.nombre', 'personas.apellido', 'personas.telefono', 'personas.email', 'personas.fecha_nacimiento')
            ->orderBy('clientes.updated_at', 'desc')
            ->paginate(5); // Mueve paginate() aquí para que funcione correctamente

        //consulta para conseguir datos de la direccion
        $direcciones = direcciones::join('direcciones_clientes', 'direcciones_clientes.id_direccion', '=', 'direcciones.id')
            ->join('clientes', 'clientes.id', '=', 'direcciones_clientes.id_cliente')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->where('clientes.estatus', 1)
            ->select('clientes.id', 'direcciones.id as id_direccion', 'catalago_ubicaciones.municipio', 'catalago_ubicaciones.localidad', 'direcciones.calle', 'direcciones.num_exterior', 'direcciones.num_interior', 'direcciones.referencia')
            ->orderBy('clientes.updated_at', 'desc')
            ->get();
        //enviamos todas las colonias
        $catalogo_colonias = Catalago_ubicaciones::orderBy('localidad')->get();


        return view('Restablecer.clientes', compact('clientes', 'direcciones', 'catalogo_colonias'));
    }
    public function actualizarCliente(clientes $id)
    {
        DB::beginTransaction();
        try {
            $cliente = $id;

            $cliente->update([
                'estatus' => 1
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            // Redirigir al usuario a una página después de la actualización
            session()->flash("incorrect", "Error al restaurar el registro");

            return redirect()->route('clientes.index');
        }
        session()->flash("correcto", "Restaurado correctamente");
        return redirect()->route('clientes.index');
    }


    public function empleados(Request $request)
    {
        $busqueda = $request->query('adminlteSearch');
        //
        $empleados = empleados::join('personas', 'personas.id', '=', 'empleados.id_persona')
            ->join('roles', 'roles.id', '=', 'empleados.id_rol')
            ->where('empleados.estatus', 0)
            ->where('personas.estatus', 0)
            ->where(function ($query) use ($busqueda) {
                $query->where('personas.telefono', 'LIKE', "%{$busqueda}%")
                    ->orWhere('personas.nombre', 'LIKE', "%{$busqueda}%")
                    ->orWhere('personas.apellido', 'LIKE', "%{$busqueda}%");
            })
            ->select('empleados.id', 'personas.nombre', 'personas.apellido', 'personas.telefono', 'personas.email', 'personas.fecha_nacimiento', 'empleados.id_rol', 'roles.nombre as nombreRol', 'empleados.fotografia')
            ->orderBy('empleados.updated_at', 'desc')
            ->paginate(5); // Mueve paginate() aquí para que funcione correctamente

        return view('Restablecer.empleados', compact('empleados'));
    }
    public function actualizarEmpleado(empleados $id)
    {
        DB::beginTransaction();
        try {
            $empleados = $id;

            $persona = personas::where('id', $empleados->id_persona)
                ->where('estatus', 0)
                ->first();

            $empleados->update([
                'estatus' => 1
            ]);

            $persona->update([
                'estatus' => 1
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            //return $th->getMessage();

            // Redirigir al usuario a una página después de la actualización
            session()->flash("incorrect", "Error al restaurar el registro");

            return redirect()->route('empleados.index');
        }
        session()->flash("correcto", "Restaurado correctamente");
        return redirect()->route('empleados.index');
    }
    public function productos(Request $request)
    {
        $busqueda = $request->query('adminlteSearch');

        $productos = productos::join('precios_productos', 'productos.id', '=', 'precios_productos.id_producto')
            ->join('marcas', 'marcas.id', '=', 'productos.id_marca')
            ->join('tipos', 'tipos.id', '=', 'productos.id_tipo')
            ->join('modos', 'modos.id', '=', 'productos.id_modo')
            ->join('colors', 'colors.id', '=', 'productos.id_color')
            ->where('productos.estatus', 0)
            ->where('precios_productos.estatus', 0)
            ->where(function ($query) use ($busqueda) {
                $query->where('productos.nombre_comercial', 'LIKE', "%{$busqueda}%")
                    ->orWhere('marcas.nombre', 'LIKE', "%{$busqueda}%")
                    ->orWhere('modos.nombre', 'LIKE', "%{$busqueda}%");
            })
            ->select('productos.id', 'productos.nombre_comercial', 'productos.modelo', 'marcas.nombre as nombreMarca', 'modos.nombre as nombreModo', 'colors.nombre as nombreColor', 'modos.id as idModo', 'colors.id as idColor', 'marcas.id as idMarca', 'tipos.nombre as nombreTipo', 'tipos.id as idTipos', 'productos.fotografia', 'precios_productos.precio')
            ->orderBy('productos.updated_at', 'desc')
            ->paginate(5); // Mueve paginate() aquí para que funcione correctamente

        $marcas = Marcas::orderBy('nombre')->get();
        $categorias = Tipo::orderBy('nombre')->get();
        $modos = Modo::orderBy('nombre')->get();
        $colores = Color::all();


        return view('Restablecer.productos', compact('productos', 'marcas', 'categorias', 'modos', 'colores'));
    }
    public function actualizarProducto(productos $id)
    {
        DB::beginTransaction();
        try {
            $producto = $id;

            $precioProducto = precios_productos::where('id_producto', $producto->id)
                ->where('estatus', 0)
                ->first();

            $producto->update([
                'estatus' => 1
            ]);

            $precioProducto->update([
                'estatus' => 1
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            // Redirigir al usuario a una página después de la actualización
            session()->flash("incorrect", "Error al restaurar el registro");

            return redirect()->route('productos.index');
        }
        session()->flash("correcto", "Restaurado correctamente");
        return redirect()->route('productos.index');
    }
}
