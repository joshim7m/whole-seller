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
            'role_id' => 2,
            'user_type' => 'manager',
            'name' => 'Manager User',
            'email' => 'manager@exe.com',
            'password' => bcrypt('histacin'),
            'status' => 1,
        ]);

        $sellers = [
            ['name' => 'Jahidul Islam',   'email' => 'jahidul@exe.com', 'user_type' => 'wholeseller', 'company' => 'Jahidul Store',     'mobile' => '01811223344', 'address' => '23 Uttara Sector-7, Dhaka 1230'],
            ['name' => 'Nasrin Akhter',   'email' => 'nasrin@exe.com',  'user_type' => 'wholeseller', 'company' => 'Nasrin Corporation', 'mobile' => '01555667788', 'address' => '55 Motijheel C/A, Dhaka 1000'],
            ['name' => 'Rafiqul Islam',   'email' => 'rafiq@exe.com',  'user_type' => 'wholeseller',  'company' => 'Rafiqul Supplies',  'mobile' => '01555667765', 'address' => 'Circle 10, Mirpur 1002'],
        ];

        $customers = [
            ['name' => 'Sakib Hasan',     'email' => 'sakib@exe.com',    'mobile' => '01718654236', 'company' => null,         'address' => '12 Dhanmondi, Dhaka 1209'],
            ['name' => 'Nusran Khatun',   'email' => 'nusran@exe.com',   'mobile' => '01922222222', 'company' => null,         'address' => '45 Mohammadpur, Dhaka 1207'],
        ];

        foreach ($sellers as $data) {
            $user = User::create([
                'role_id' => 3,
                'user_type' => $data['user_type'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt('histacin'),
                'status' => 1,
            ]);

            $user->userDetail()->create([
                'mobile' => $data['mobile'],
                'company' => $data['company'],
                'address' => $data['address'],
            ]);
        }

        foreach ($customers as $data) {
            $user = User::create([
                'role_id' => 3,
                'user_type' => 'customer',
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt('histacin'),
                'status' => 1,
            ]);

            $user->userDetail()->create([
                'mobile' => $data['mobile'],
                'company' => $data['company'],
                'address' => $data['address'],
            ]);
        }
    }
}
