<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class administradores extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{

    DB::table('users')->insert([
        [
            'name' => 'administrador',
            'email' => 'papitamcfly1234@gmail.com',
            'password' => Hash::make('papitaman'), // Encriptar la contraseña
            'rol' => 3,
            'is_active' => 1
        ]
    ]);
}

}
