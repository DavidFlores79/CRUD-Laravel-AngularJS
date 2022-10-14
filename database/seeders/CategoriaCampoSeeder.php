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
            'nombre' => 'usuarios',
        ]);
        CategoriaCampo::create([
            'nombre' => 'perfiles',
        ]);
    }
}
