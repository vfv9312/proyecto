<?php

namespace App\Http\Controllers;

use App\Models\Catalago_ubicaciones;
use App\Models\clientes;
use App\Models\direcciones;
use App\Models\empleados;
use App\Models\Marcas;
use App\Models\productos;
use App\Models\Tipo;
use Illuminate\Http\Request;

class OrdenEntregaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $marca = $request->marca;
        $tipo = $request->tipo;

        $productos = productos::join('precios_productos', 'productos.id', '=', 'precios_productos.id_producto')
            ->join('marcas', 'marcas.id', '=', 'productos.id_marca')
            ->join('tipos', 'tipos.id', '=', 'productos.id_tipo')
            ->where('productos.estatus', 1)
            ->where('precios_productos.estatus', 1)
            // ->where('marcas.id', 'LIKE', "%{$marca}%")
            // ->where('tipos.id', 'LIKE', "%{$tipo}%")
            ->select(
                'productos.id',
                'productos.nombre_comercial',
                'tipos.nombre as nombre_tipo',
                'productos.modelo',
                'productos.color',
                'marcas.nombre as nombre_marca',
                'productos.fotografia',
                'precios_productos.precio',
                'marcas.id as marca_id',
                'tipos.id as tipo_id'
            )
            ->orderBy('productos.updated_at', 'desc')->get();

        $marcas = Marcas::orderBy('nombre')->get();
        $tipos = Tipo::orderBy('nombre')->get();

        return view('Principal.ordenEntrega.tienda', compact('productos', 'marcas', 'tipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listaEmpleados = empleados::join('roles', 'roles.id', '=', 'empleados.id_rol')
            ->join('personas', 'personas.id', '=', 'empleados.id_persona')
            ->where('empleados.estatus', 1)
            ->select('empleados.id', 'roles.nombre as nombre_rol', 'personas.nombre as nombre_empleado', 'personas.apellido')
            ->get();

        $listaClientes = clientes::join('personas', 'personas.id', '=', 'clientes.id_persona')
            ->where('clientes.estatus', 1)
            ->select(
                'personas.nombre as nombre_cliente',
                'personas.apellido',
                'personas.telefono as telefono_cliente',
                'personas.email',
                'clientes.comentario',
                'clientes.id as id_cliente',
            )
            ->orderBy('clientes.updated_at', 'desc')
            ->get();

        $listaDirecciones = clientes::join('personas', 'personas.id', '=', 'clientes.id_persona')
            ->join('direcciones_clientes', 'direcciones_clientes.id_cliente', '=', 'clientes.id')
            ->join('direcciones', 'direcciones.id', '=', 'direcciones_clientes.id_direccion')
            ->join('catalago_ubicaciones', 'catalago_ubicaciones.id', '=', 'direcciones.id_ubicacion')
            ->where('clientes.estatus', 1)
            ->select(
                'catalago_ubicaciones.localidad',
                'direcciones.calle',
                'direcciones.num_exterior',
                'direcciones.num_interior',
                'direcciones.referencia',
                'clientes.id as id_cliente',
                'catalago_ubicaciones.id as id_ubicaciones',
                'direcciones_clientes.id'
            )
            ->orderBy('clientes.updated_at', 'desc')
            ->get();

        $ListaColonias = Catalago_ubicaciones::orderBy('localidad')->get();


        return view('Principal.ordenEntrega.index', compact('listaEmpleados', 'listaClientes', 'listaDirecciones', 'ListaColonias'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
