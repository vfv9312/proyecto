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
            'nombre' => 'admin',
            'Permisos' => 1,
            'estatus' => 1
        ]);

        Roles::create([
            'nombre' => 'Ventas',
            'Permisos' => 1,
            'estatus' => 1
        ]);

        Roles::create([
            'nombre' => 'Producción',
            'Permisos' => 1,
            'estatus' => 1
        ]);

        Roles::create([
            'nombre' => 'Almacén',
            'Permisos' => 1,
            'estatus' => 1
        ]);

        Roles::create([
            'nombre' => 'Tráfico',
            'Permisos' => 1,
            'estatus' => 1
        ]);

        Roles::create([
            'nombre' => 'Caja',
            'Permisos' => 1,
            'estatus' => 1
        ]);
    }
}
