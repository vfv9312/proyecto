<?php

namespace Database\Seeders;

use App\Models\Cancelaciones;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CancelacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $cancelaciones = [
            "Producto no disponible",
            "Tiempo de entrega largo",
            "Cambio de preferencia",
            "Costos adicionales inesperados",
            "Error en la orden",
            "Error en la dirección de entrega",
            "Mejor oferta en otro lugar",
            "Emergencia o imprevisto personal",
            "Insatisfacción con la calidad del servicio"
        ];

        foreach ($cancelaciones as $cancelacion) {
            Cancelaciones::create([
                'nombre' => $cancelacion,
                'estatus' => 1
            ]);
        }
    }
}
