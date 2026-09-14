<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'dimioctora@gmail.com'],
            [
                'name' => 'Super Admin (Dimi)',
                'password' => Hash::make('2020Beg!n'),
                'role' => 'Super Admin',
                'is_verified' => true,
                'xp' => 1000000,
                'level' => 'Administrator',
                'trust_score' => 100
            ]
        );
    }
}
