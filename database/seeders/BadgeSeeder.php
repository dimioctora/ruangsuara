<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Badge::updateOrCreate(['name' => 'First Suara'], ['icon' => 'megaphone', 'requirement' => 'Buat Suara pertama Anda']);
        \App\Models\Badge::updateOrCreate(['name' => 'Active Citizen'], ['icon' => 'zap', 'requirement' => 'Capai 100 XP']);
        \App\Models\Badge::updateOrCreate(['name' => 'Verified'], ['icon' => 'shield-check', 'requirement' => 'Trust Score > 60']);
        \App\Models\Badge::updateOrCreate(['name' => 'Veteran'], ['icon' => 'award', 'requirement' => 'Bergabung selama 1 bulan']);
    }
}
