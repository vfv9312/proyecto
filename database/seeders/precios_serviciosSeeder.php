<?php

namespace Database\Seeders;

use App\Models\precios_servicios;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class precios_serviciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        precios_servicios::create([
            'id_servicio' => 1,
            'precio' => 35.00,
            'descripcion' => 'subio el precio de la tinta'
        ]);
        precios_servicios::create([
            'id_servicio' => 2,
            'precio' => 40.00,
            'descripcion' => 'rellenado de tinta mediana'
        ]);
        precios_servicios::create([
            'id_servicio' => 3,
            'precio' => 50.00,
            'descripcion' => 'rellenado de tinta alta'
        ]);
    }
}
