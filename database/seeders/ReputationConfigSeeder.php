<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReputationConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $configs = [
            ['action_slug' => 'create_suara', 'action_name' => 'Create Suara (Isu Baru)', 'xp_reward' => 150, 'trust_bonus' => 5, 'description' => 'Diberikan saat user berhasil submit isu baru'],
            ['action_slug' => 'support_suara', 'action_name' => 'Support / Vote Isu', 'xp_reward' => 15, 'trust_bonus' => 1, 'description' => 'Diberikan saat user klik tombol Suarakan'],
            ['action_slug' => 'receive_support', 'action_name' => 'Mendapatkan Dukungan Voters', 'xp_reward' => 15, 'trust_bonus' => 1, 'description' => 'Diberikan kepada pembuat isu setiap kali ada voter yang mendukung isunya'],
            ['action_slug' => 'receive_feedback', 'action_name' => 'Mendapatkan Masukan Voters', 'xp_reward' => 5, 'trust_bonus' => 0.5, 'description' => 'Diberikan kepada pembuat isu setiap kali ada voter yang memberikan sanggahan'],
            ['action_slug' => 'comment_suara', 'action_name' => 'Comment on Isu', 'xp_reward' => 10, 'trust_bonus' => 0.5, 'description' => 'Diberikan saat user melakukan diskusi'],
            ['action_slug' => 'share_suara', 'action_name' => 'Share Isu to Social Media', 'xp_reward' => 30, 'trust_bonus' => 2, 'description' => 'Reward viralitas'],
            ['action_slug' => 'profile_complete', 'action_name' => 'Melengkapi Profil (80%)', 'xp_reward' => 100, 'trust_bonus' => 10, 'description' => 'Lengkapi data diri'],
            ['action_slug' => 'verify_account', 'action_name' => 'Account Verification (ID)', 'xp_reward' => 200, 'trust_bonus' => 25, 'description' => 'Verifikasi KTP / Identitas'],
        ];

        foreach ($configs as $config) {
            \App\Models\ReputationConfig::updateOrCreate(
                ['action_slug' => $config['action_slug']],
                $config
            );
        }
    }
}
