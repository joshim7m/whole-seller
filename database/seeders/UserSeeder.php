<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::create([
            'role_id' => 1,
            'user_type' => 'admin',
            'name' => 'Sajib Hossain',
            'email' => 'sajibhossain523@gmail.com',
            'password' => bcrypt('Back28space@'),
            'status' => 1,
        ]);

        User::create([
            'role_id' => 1,
            'user_type' => 'admin',
            'name' => 'Joshim Uddin',
            'email' => 'joshimfv@gmail.com',
            'password' => bcrypt('histacin'),
            'status' => 1,
        ]);

    }
}
