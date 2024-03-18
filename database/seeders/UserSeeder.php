<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('password');
        $date = date('Y-m-d H:i:s');

        User::insert([
            [
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@vascomm.com',
                'password' => $password,
                'role' => User::ADMIN,
                'created_at' => $date
            ],
            [
                'id' => 2,
                'name' => 'User',
                'email' => 'user@vascomm.com',
                'password' => $password,
                'role' => User::USER,
                'created_at' => $date
            ]
        ]);
    }
}
