<?php

namespace Database\Seeders;

use App\Models\Tipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $tipos = [
            "Tinta",
            "Toner",
            "Computo",
            "Impresora",
            "Accesorio",
            "Copiadora",
        ];

        foreach ($tipos as $dato) {
            Tipo::create([
                'nombre' => $dato,
                'estatus' => 1
            ]);
        }
    }
}
