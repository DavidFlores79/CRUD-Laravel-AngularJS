<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'nickname' => 'admin',
            'email' => 'admin@itsoft.mx',
            'password' => bcrypt('admin123'), // admin123
            //'perfil_id' => 1,
        ]);

        User::create([
            'name' => 'Joel Estrella',
            'nickname' => 'jestrella',
            'email' => 'jestrella@itsoft.mx',
            'password' => bcrypt('12345678'), //12345678
            //'perfil_id' => 1,
        ]);
    }
}
