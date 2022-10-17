<?php

namespace Database\Seeders;

use App\Models\TipoFormulario;
use Illuminate\Database\Seeder;

class TipoFormularioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoFormulario::create([
            'nombre' => 'usuarios_crear',
            'tabla' => 'users',
        ]);
        TipoFormulario::create([
            'nombre' => 'usuarios_editar',
            'tabla' => 'users',
        ]);
        TipoFormulario::create([
            'nombre' => 'perfiles_crear',
            'tabla' => 'perfiles',
        ]);
        TipoFormulario::create([
            'nombre' => 'perfiles_editar',
            'tabla' => 'perfiles',
        ]);
    }
}
