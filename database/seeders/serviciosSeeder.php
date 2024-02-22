<?php

namespace Database\Seeders;

use App\Models\servicios;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class serviciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        servicios::create([
            'tipo_de_proyecto' => 'Rellenado de tinta',
            'id_venta' => 1,
            'descripcion' => 'ninguna',
            'modelo' => 'X9',
            'color' => 'Azul',
            'cantidad' => 1,
            'precio_unitario' => 2.00,
            'estatus' => 1
        ]);

        servicios::create([
            'tipo_de_proyecto' => 'Rellenado de tinta',
            'id_venta' => 2,
            'descripcion' => 'tinta epson',
            'modelo' => 'X8',
            'color' => 'Negro',
            'cantidad' => 3,
            'precio_unitario' => 5.00,
            'estatus' => 1
        ]);
    }
}
