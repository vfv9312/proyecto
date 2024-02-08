<?php

namespace Database\Seeders;

use App\Models\ventas_productos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ventas_productosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        ventas_productos::create([
            'id_precio_producto' => 1,
            'id_venta' => 1,
            'cantidad' => 3,
            'descipcion' => 'Exitoso'
        ]);
        ventas_productos::create([
            'id_precio_producto' => 2,
            'id_venta' => 1,
            'cantidad' => 1,
            'descipcion' => 'Exitoso'
        ]);
        ventas_productos::create([
            'id_precio_producto' => 3,
            'id_venta' => 2,
            'cantidad' => 2,
            'descipcion' => 'Exitoso'
        ]);
        ventas_productos::create([
            'id_precio_producto' => 4,
            'id_venta' => 3,
            'cantidad' => 1,
            'descipcion' => 'Exitoso'
        ]);
    }
}
