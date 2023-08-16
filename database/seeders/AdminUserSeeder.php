<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('111111'),
            'email_verified_at' => now(),
            'role' => 2,
        ]);

        User::create([
            'name' => 'Van Dat',
            'email' => 'vandat@gmail.com',
            'password' => bcrypt('111111'),
            'email_verified_at' => now(),
            'role' => 1,
        ]);
    }
}
