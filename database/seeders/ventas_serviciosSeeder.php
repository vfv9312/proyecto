<?php

namespace Database\Seeders;

use App\Models\ventas_servicios;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ventas_serviciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        ventas_servicios::create([
            'id_precio_servicio' => 1,
            'id_venta' => 1,
            'cantidad' => 1,
            'descipcion' => 'ninguno',
        ]);
        ventas_servicios::create([
            'id_precio_servicio' => 2,
            'id_venta' => 2,
            'cantidad' => 1,
            'descipcion' => 'ninguno',
        ]);
        ventas_servicios::create([
            'id_precio_servicio' => 3,
            'id_venta' => 14,
            'cantidad' => 1,
            'descipcion' => 'ninguno',
        ]);
    }
}
