<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $busqueda = $request->query('adminlteSearch');
        $busquedaMarca = $request->query('marca');
        $busquedaTipo = $request->query('tipo');
        $busquedaColor = $request->query('color');
        $busquedaCategoria = $request->query('categoria');

        $categorias = Tipo::where('estatus', 1)->orderBy('nombre')->paginate(10);

        // $productos = productos::join('precios_productos', 'productos.id', '=', 'precios_productos.id_producto')
        //     ->join('marcas', 'marcas.id', '=', 'productos.id_marca')
        //     ->join('tipos', 'tipos.id', '=', 'productos.id_tipo')
        //     ->join('modos', 'modos.id', '=', 'productos.id_modo')
        //     ->join('colors', 'colors.id', '=', 'productos.id_color')
        //     ->where('productos.estatus', 1)
        //     ->where('precios_productos.estatus', 1)
        //     ->where(function ($query) use ($busqueda) {
        //         $query->where('productos.nombre_comercial', 'LIKE', "%{$busqueda}%")
        //             ->orWhere('marcas.nombre', 'LIKE', "%{$busqueda}%")
        //             ->orWhere('modos.nombre', 'LIKE', "%{$busqueda}%");
        //     })
        //     ->when($busquedaMarca, function ($query, $busquedaMarca) {
        //         return $query->where('marcas.id', 'LIKE', "%{$busquedaMarca}%");
        //     })
        //     ->when($busquedaTipo, function ($query, $busquedaTipo) {
        //         return $query->where('modos.id', 'LIKE', "%{$busquedaTipo}%");
        //     })
        //     ->when($busquedaColor, function ($query, $busquedaColor) {
        //         return $query->where('colors.id', 'LIKE', "%{$busquedaColor}%");
        //     })
        //     ->when($busquedaCategoria, function ($query, $busquedaCategoria) {
        //         return $query->where('tipos.id', 'LIKE', "%{$busquedaCategoria}%");
        //     })
        //     ->select('productos.id', 'productos.nombre_comercial', 'productos.modelo', 'marcas.nombre as nombreMarca', 'modos.nombre as nombreModo', 'colors.nombre as nombreColor', 'modos.id as idModo', 'colors.id as idColor', 'marcas.id as idMarca', 'tipos.nombre as nombreTipo', 'tipos.id as idTipos', 'precios_productos.precio')
        //     ->orderBy('productos.updated_at', 'desc')
        //     ->paginate(5)->appends(['adminlteSearch' => $busqueda, 'marca' => $busquedaMarca, 'tipo' => $busquedaTipo, 'color' => $busquedaColor, 'categoria' => $busquedaCategoria]); // Mueve paginate() aquí para que funcione correctamente



        return view('Categoria.index', compact('categorias'));
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
            $nombre = ucfirst(strtolower($request->txtnombre));

            // Insertar en la tabla 'productos'
            Tipo::create([
                'nombre' => $nombre,
                'estatus' => 1,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            session()->flash("incorrect", "Error en el registro");
            return redirect()->route('categorias.index');
        }
        session()->flash("correcto", "Registrado correctamente");
        return redirect()->route('categorias.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tipo $tipo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tipo $categoria)
    {

        //enviar los dos datos a la vista
        return view('Categoria.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tipo $categoria)
    {
        DB::beginTransaction();
        try {
            $nombre = $request->txtnombre;

            $categoria->nombre = ucfirst(strtolower($nombre));

            $categoria->save();


            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            session()->flash("incorrect", "Error al actualizar");
            return redirect()->route('categorias.index');
        }
        session()->flash("correcto", "Categoria actualizada correctamente");
        return redirect()->route('categorias.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function desactivar(Tipo $id)
    {
        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.
        try {

            //estatus la categoria que se llamo tipo antes por tanta modificacion del cliente
            $id->estatus = 0;
            $id->deleted_at = now();
            $id->save();

            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            //si retorna un error de sql lo veremos en pantalla
            //return $th->getMessage();
            session()->flash("incorrect", "Error al eliminar el registro");
            return redirect()->route('categorias.index');
        }

        session()->flash("correcto", "Categoria eliminado correctamente");
        return redirect()->route('categorias.index');
    }
    public function destroy(Tipo $tipo)
    {
        //
    }
}
