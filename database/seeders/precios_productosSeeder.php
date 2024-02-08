<?php

namespace Database\Seeders;

use App\Models\precios_productos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class precios_productosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        precios_productos::create([
            'id_producto' => 1,
            'precio' => 50.50,
            'descripcion' => 'toner 604'
        ]);
        precios_productos::create([
            'id_producto' => 2,
            'precio' => 55.50,
            'descripcion' => 'toner 202'
        ]);
        precios_productos::create([
            'id_producto' => 3,
            'precio' => 75.50,
            'descripcion' => 'super toner 204'
        ]);
        precios_productos::create([
            'id_producto' => 4,
            'precio' => 90.01,
            'descripcion' => 'toner chafa'
        ]);
        precios_productos::create([
            'id_producto' => 5,
            'precio' => 800.50,
            'descripcion' => 'impresora 1'
        ]);
        precios_productos::create([
            'id_producto' => 6,
            'precio' => 800.50,
            'descripcion' => 'impresora 3'
        ]);
        precios_productos::create([
            'id_producto' => 7,
            'precio' => 300.50,
            'descripcion' => 'paquete hojas'
        ]);
        precios_productos::create([
            'id_producto' => 8,
            'precio' => 250.5,
            'descripcion' => 'paquete de hoja fea'
        ]);
        precios_productos::create([
            'id_producto' => 9,
            'precio' => 350.5,
            'descripcion' => 'hojas inflacion'
        ]);
        precios_productos::create([
            'id_producto' => 10,
            'precio' => 2.00,
            'descripcion' => 'hojas sueltas'
        ]);
    }
}
