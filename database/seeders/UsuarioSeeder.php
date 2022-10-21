<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create(
            [
                'name' => 'CALINMX',
                'email' => 'cegcdeveloper@gmail.com',
                'password' => Hash::make('rufirufi'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]
        )->assignRole('superusuario');

    }
}
