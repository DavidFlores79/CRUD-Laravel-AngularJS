<?php

namespace Database\Seeders;

use App\Models\Perfil;
use Illuminate\Database\Seeder;

class PerfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Perfil::create([
            'nombre' => 'Administrador',
        ]);
        Perfil::create([
            'nombre' => 'SuperUsuario',
        ]);
    }
}
