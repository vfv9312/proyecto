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

        $precios = [];

        for ($i = 1; $i <= 34; $i++) {
            $precio = rand(15000, 30000) / 100; // Genera un número aleatorio entre 15000 y 30000 y luego lo divide por 100 para obtener el precio con decimales
            $precios[] = [$i, $precio];
        }


        foreach ($precios as $precio) {
            precios_productos::create([
                'id_producto' => $precio[0],
                'precio' => $precio[1],
            ]);
        }
    }
}
