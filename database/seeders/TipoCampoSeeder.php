<?php

namespace Database\Seeders;

use App\Models\TipoCampo;
use Illuminate\Database\Seeder;

class TipoCampoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        TipoCampo::create([
            'nombre' => 'text',
        ]);
        TipoCampo::create([
            'nombre' => 'email',
        ]);
        TipoCampo::create([
            'nombre' => 'password',
        ]);
        TipoCampo::create([
            'nombre' => 'number',
        ]);
        TipoCampo::create([
            'nombre' => 'hidden',
        ]);
    }
}
