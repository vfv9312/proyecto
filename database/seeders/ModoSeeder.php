<?php

namespace Database\Seeders;

use App\Models\Modo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            "Original",
            "Generico",
            "Reciclado"
        ];

        foreach ($tipos as $dato) {
            Modo::create([
                'nombre' => $dato,
                'estatus' => 1
            ]);
        }
    }
}
