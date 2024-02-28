<?php

namespace Database\Seeders;

use App\Models\Marcas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $marcas = [
            "Brady",
            "Brother",
            "Canon",
            "Citizen",
            "Dascom",
            "Dymo",
            "Epson",
            "Evolis",
            "Fargo",
            "Fujitsu",
            "Gestetner",
            "Godex",
            "HP",
            "Konica Minolta",
            "Kyocera",
            "Lanier",
            "Lexmark",
            "Magicard",
            "OKI",
            "Olivetti",
            "Panasonic",
            "Ricoh",
            "Samsung",
            "SATO",
            "Sharp",
            "Tally",
            "Toshiba",
            "TSC",
            "Xerox",
            "Zebra"
        ];

        foreach ($marcas as $dato) {
            Marcas::create([
                'nombre' => $dato,
                'estatus' => 1
            ]);
        }
    }
}
