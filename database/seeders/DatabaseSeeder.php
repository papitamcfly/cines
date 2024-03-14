<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['rol' => 'invitado'],
            ['rol' => 'usuario'],
            ['rol' => 'administrador'],
        ]);

        DB::table('users')->insert([
            'name' => 'emiliano',
            'email' => 'fehane91@gmail.com',
            'email_verified_at' => null,
            'password' => bcrypt('123456'),
            'rol' => 1, // Asignar el ID del rol correspondiente
            'is_active' => true,
            'created_at' => null,
            'updated_at' => null,
        ]);
    }
}
