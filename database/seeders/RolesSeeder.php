<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Roles::create([
            'nombre' => 'administrador',
            'estatus' => 1
        ]);

        Roles::create([
            'nombre' => 'Ventas',
            'estatus' => 1
        ]);

        Roles::create([
            'nombre' => 'Producción',
            'estatus' => 1
        ]);

        Roles::create([
            'nombre' => 'Almacén',
            'estatus' => 1
        ]);

        Roles::create([
            'nombre' => 'Tráfico',
            'estatus' => 1
        ]);

        Roles::create([
            'nombre' => 'Caja',
            'estatus' => 1
        ]);
    }
}
