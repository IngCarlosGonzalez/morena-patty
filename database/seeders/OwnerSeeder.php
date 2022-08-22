<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Owner;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Owner::create(
            [
                'user_id' => 1,
                'esta_vigente' => 1,
                'area_o_depto' => 'SISTEMAS',
                'nombre_titular' => 'CARLOS GONZALEZ',
                'puesto_titular' => 'DESARROLLADOR',
            ]
        );
        Owner::create(
            [
                'user_id' => 2,
                'esta_vigente' => 1,
                'area_o_depto' => 'COMITE EJECUTIVO',
                'nombre_titular' => 'PATRICIA GONZALEZ',
                'puesto_titular' => 'ATENCION CIUDADANA',
            ]
        );
        Owner::create(
            [
                'user_id' => 3,
                'esta_vigente' => 1,
                'area_o_depto' => 'ASESORIA EXTERNA',
                'nombre_titular' => 'LIC. FULANO DE TAL',
                'puesto_titular' => 'TERAPEUTA HUMANITARIO',
            ]
        );
    }
}
