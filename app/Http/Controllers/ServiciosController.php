<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Marcas;
use App\Models\Modo;
use App\Models\precios_productos;
use App\Models\precios_servicios;
use App\Models\productos;
use App\Models\servicios;
use App\Models\Tipo;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiciosController extends Controller
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

        $productos = productos::join('precios_productos', 'productos.id', '=', 'precios_productos.id_producto')
            ->join('marcas', 'marcas.id', '=', 'productos.id_marca')
            ->join('tipos', 'tipos.id', '=', 'productos.id_tipo')
            ->join('modos', 'modos.id', '=', 'productos.id_modo')
            ->join('colors', 'colors.id', '=', 'productos.id_color')
            ->where('productos.estatus', 2)
            ->where('precios_productos.estatus', 2)
            ->where(function ($query) use ($busqueda) {
                $query->where('productos.nombre_comercial', 'LIKE', "%{$busqueda}%")
                    ->orWhere('marcas.nombre', 'LIKE', "%{$busqueda}%")
                    ->orWhere('modos.nombre', 'LIKE', "%{$busqueda}%");
            })
            ->when($busquedaMarca, function ($query, $busquedaMarca) {
                return $query->where('marcas.id', 'LIKE', "%{$busquedaMarca}%");
            })
            ->when($busquedaTipo, function ($query, $busquedaTipo) {
                return $query->where('modos.id', 'LIKE', "%{$busquedaTipo}%");
            })
            ->when($busquedaColor, function ($query, $busquedaColor) {
                return $query->where('colors.id', 'LIKE', "%{$busquedaColor}%");
            })
            ->when($busquedaCategoria, function ($query, $busquedaCategoria) {
                return $query->where('tipos.id', 'LIKE', "%{$busquedaCategoria}%");
            })
            ->select('productos.id', 'productos.nombre_comercial', 'productos.modelo', 'marcas.nombre as nombreMarca', 'modos.nombre as nombreModo', 'colors.nombre as nombreColor', 'modos.id as idModo', 'colors.id as idColor', 'marcas.id as idMarca', 'tipos.nombre as nombreTipo', 'tipos.id as idTipos', 'precios_productos.precio')
            ->orderBy('productos.updated_at', 'desc')
            ->paginate(10)->appends(['adminlteSearch' => $busqueda, 'marca' => $busquedaMarca, 'tipo' => $busquedaTipo, 'color' => $busquedaColor, 'categoria' => $busquedaCategoria]); // Mueve paginate() aquí para que funcione correctamente

        $marcas = Marcas::orderBy('nombre')->get();
        $categorias = Tipo::orderBy('nombre')->get();
        $modos = Modo::orderBy('nombre')->get();
        $colores = Color::all();


        return view('servicios.index', compact('productos', 'marcas', 'categorias', 'modos', 'colores', 'busqueda', 'busquedaMarca', 'busquedaTipo', 'busquedaColor', 'busquedaCategoria'));
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
            // Insertar en la tabla 'productos'
            $producto = productos::create([
                'nombre_comercial' => $request->txtnombre,
                'modelo' => $request->txtmodelo,
                'id_color' => $request->txtcolor,
                'id_tipo' => $request->txttipo,
                'id_modo' => $request->txtmodo,
                'id_marca' => $request->txtmarca,
                'descripcion' => $request->txtdescripcion,
                'fotografia' => null,
                'estatus' => 2
            ]);

            // Insertar en la tabla 'precios_productos' usando el ID del producto
            $precioProducto = precios_productos::create([
                'id_producto' => $producto->id,
                'precio' => $request->txtprecio,
                //'descripcion' => $request->txtdescripcion,
                'estatus' => 2
            ]);

            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            //return $th->getMessage();
            $precioProducto = 0;
        }
        if ($precioProducto == true) {
            session()->flash("correcto", "Producto registrado correctamente");
            return redirect()->route('servicios.index');
        } else {
            session()->flash("incorrect", "Error al registrar");
            return redirect()->route('servicios.index');
        }
        /* DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.
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
        }*/
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
    public function edit(servicios $servicios, $servicio)
    {
        $producto = productos::where('id', $servicio)->select('*')->first();
        //conseguir el primer precio del producto que esten con estatus 1 y tengan el mismo id_producto
        $precioProducto = precios_productos::where('id_producto', $servicio)
            ->where('estatus', 2)
            ->first();
        $datosProducto = productos::join('marcas', 'marcas.id', '=', 'productos.id_marca')
            ->join('tipos', 'tipos.id', '=', 'productos.id_tipo')
            ->join('modos', 'modos.id', '=', 'productos.id_modo')
            ->join('colors', 'colors.id', '=', 'productos.id_color')
            ->where('productos.estatus', 2)
            ->where('productos.id', $servicio)
            ->select('marcas.id as idMarca', 'marcas.nombre as nombreMarca', 'tipos.id as idTipo', 'tipos.nombre as nombreTipo', 'modos.id as idModo', 'modos.nombre as nombreModo', 'colors.id as idColor', 'colors.nombre as nombreColor')
            ->first();

        $marcas = Marcas::orderBy('nombre')->get();
        $categorias = Tipo::orderBy('nombre')->get();
        $modos = Modo::orderBy('nombre')->get();
        $colores = Color::all();

        //enviar los dos datos a la vista
        return view('servicios.edit', compact('servicio', 'producto', 'precioProducto', 'marcas', 'categorias', 'datosProducto', 'colores', 'modos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $servicio, servicios $servicios)
    {
        DB::beginTransaction();
        try {
            $producto = productos::where('id', $servicio)->select('*')->first();
            //Actualizar la tabla producto
            $productoActualizado = $producto->update([
                'nombre_comercial' => $request->txtnombre,
                'modelo' => $request->txtmodelo,
                'id_color' => $request->txtcolor,
                'id_marca' => $request->txtmarca,
                'id_tipo' => $request->txttipo,
                'id_modo' => $request->txtmodo,
                'descripcion' => $request->txtdescripcion,
                'estatus' => 2
            ]);

            // Obetener el primer id del precio del producto que este relacionado donde el estatus sea 1
            $preciosProductoActualizado = precios_productos::where('id_producto', $producto->id)
                ->where('estatus', 2)
                ->first();

            // Obtén el precio actual
            $precioActual = $preciosProductoActualizado->precio;
            //si el precio actual es txt precio es diferente al que esta en el campo txtprecio actualizalo
            if ($precioActual != $request->txtprecio) {
                //primero cambiamos el estatus del producto estatus
                $preciosProductoActualizado->update([
                    'deleted_at' => now(),
                    'estatus' => 3
                ]);
                //ahora creamos el nuevo precio
                $preciosProductoNuevo =  precios_productos::create([
                    'id_producto' => $producto->id,
                    'precio' => $request->txtprecio,
                    //'descripcion' => $request->txtdescripcion,
                    'estatus' => 2
                ]);
            } else {
                // Si el precio no ha cambiado, no crees un nuevo registro
                $preciosProductoNuevo = true; // Para que la comprobación final siga funcionando
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            session()->flash("incorrect", "Error al actualizar el registro");
            return redirect()->route('servicios.index');
        }
        session()->flash("correcto", "Producto actualizado correctamente");
        return redirect()->route('servicios.index');
    }

    public function desactivar(productos $id)
    {
        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.
        try {
            //en este caso es id por que en la ruta asi dije que se llamaria PUT productos/{id}/desactivar ............. productos.desactivar › ProductosController@desactivar
            //conseguir el primer precio del producto que esten con estatus 2 y tengan el mismo id_producto
            $precioProducto = precios_productos::where('id_producto', $id->id)
                ->where('estatus', 2)
                ->first();
            //estatus de producto actualizarlo a 3 y la fecha de eliminacion tambien
            $id->estatus = 3;
            $id->deleted_at = now();
            $productoDesactivado = $id->save();
            //estatus de precio_producto actualizarlo a 0 y la fecha de eliminacion tambien
            $precioProducto->estatus = 3;
            $precioProducto->deleted_at = now();
            $precioProductoDesactivado = $precioProducto->save();


            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            //si retorna un error de sql lo veremos en pantalla
            return $th->getMessage();
            session()->flash("incorrect", "Error al eliminar el registro");
            return redirect()->route('servicios.index');
        }
        session()->flash("correcto", "Producto eliminado correctamente");
        return redirect()->route('servicios.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(servicios $servicios)
    {
        //
    }
}
