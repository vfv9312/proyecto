<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $color = [
            "Negro",
            "Amarillo",
            "Cian",
            "Magenta",
            "Cian Ligth",
            "Magenta Ligth",
            "CMA Ligth",
            "CMAN"
        ];

        foreach ($color as $dato) {
            Color::create([
                'nombre' => $dato,
                'estatus' => 1
            ]);
        }
    }
}
