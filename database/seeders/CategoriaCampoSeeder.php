<?php

namespace Database\Seeders;

use App\Models\CategoriaCampo;
use Illuminate\Database\Seeder;

class CategoriaCampoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoriaCampo::create([
            'nombre' => 'usuarios_crear',
            'tabla' => 'users',
        ]);
        CategoriaCampo::create([
            'nombre' => 'usuarios_editar',
            'tabla' => 'users',
        ]);
        CategoriaCampo::create([
            'nombre' => 'perfiles_crear',
            'tabla' => 'perfiles',
        ]);
        CategoriaCampo::create([
            'nombre' => 'perfiles_editar',
            'tabla' => 'perfiles',
        ]);
    }
}
