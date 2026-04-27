<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Consulta;

class ConsultasSeeder extends Seeder
{
    public function run(): void
    {
        Consulta::create(['nombre' => 'Consulta Rosa',       'color' => '#cc0247', 'activa' => true]);
        Consulta::create(['nombre' => 'Consulta Azul Claro', 'color' => '#08beff', 'activa' => true]);
        Consulta::create(['nombre' => 'Consulta Azul Oscuro','color' => '#0a6b8a', 'activa' => true]);
    }
}
