<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganicSuaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Aditya Nugraha', 'email' => 'aditya@example.com'],
            ['name' => 'Bintang Pratama', 'email' => 'bintang@example.com'],
            ['name' => 'Citra Lestari', 'email' => 'citra@example.com'],
            ['name' => 'Dahlan Iskan', 'email' => 'dahlan@example.com'],
            ['name' => 'Eka Kurnia', 'email' => 'eka@example.com'],
            ['name' => 'Fajar Sidik', 'email' => 'fajar@example.com'],
            ['name' => 'Gita Savitri', 'email' => 'gita@example.com'],
        ];

        $createdUsers = [];
        foreach ($users as $u) {
            $createdUsers[] = \App\Models\User::firstOrCreate(
                ['email' => $u['email']],
                ['name' => $u['name'], 'password' => \Illuminate\Support\Facades\Hash::make('password')]
            );
        }

        $issues = [
            [
                'title' => 'Kontroversi Board of Peace',
                'category' => 'Social',
                'location' => 'Jakarta',
                'description' => 'Mendesak audit publik terhadap operasional Board of Peace yang dinilai kurang transparan dalam penyaluran dana kemanusiaan.',
                'supporter_count' => 3450,
                'opponent_count' => 120,
                'target_voice' => 5000,
                'status' => 'published',
                'image' => 'images/media__1774088614299.png', // Using existing dummy images
            ],
            [
                'title' => 'Kawal Dana Gereja di BNI',
                'category' => 'Finance',
                'location' => 'Nasional',
                'description' => 'Mendorong transparansi pembekuan dana jamaah dan alur birokrasi perbankan yang menghambat operasional sosial.',
                'supporter_count' => 840,
                'opponent_count' => 12,
                'target_voice' => 1000,
                'status' => 'published',
                'image' => 'images/community_education_campaign_1774090118432.png',
            ],
            [
                'title' => 'Kenaikan Tarif Listrik',
                'category' => 'Economy',
                'location' => 'Nasional',
                'description' => 'Petisi menolak kenaikan tarif listrik golongan rumah tangga tanpa ada perbaikan layanan interkoneksi di daerah 3T.',
                'supporter_count' => 12800,
                'opponent_count' => 450,
                'target_voice' => 15000,
                'status' => 'published',
                'image' => 'images/road_repair_campaign_1774090099529.png',
            ],
            [
                'title' => 'Audit LPDP',
                'category' => 'Education',
                'location' => 'Jakarta',
                'description' => 'Evaluasi menyeluruh sistem pengabdian alumni LPDP dan transparansi seleksi penerima beasiswa agar lebih tepat sasaran.',
                'supporter_count' => 5600,
                'opponent_count' => 85,
                'target_voice' => 7500,
                'status' => 'published',
                'image' => 'images/community_education_campaign_1774090118432.png',
            ],
            [
                'title' => 'Proses Hukum Timothy Ronald',
                'category' => 'Legal',
                'location' => 'Jakarta',
                'description' => 'Memantau jalannya proses hukum terhadap konten edukasi finansial yang diduga menyesatkan publik.',
                'supporter_count' => 2100,
                'opponent_count' => 600,
                'target_voice' => 3000,
                'status' => 'published',
                'image' => 'images/media__1774088614299.png',
            ],
            [
                'title' => 'Stop Program MBG',
                'category' => 'Policy',
                'location' => 'Nasional',
                'description' => 'Kritik terhadap program makan bergizi gratis yang dinilai belum memiliki infrastruktur sanitasi yang memadai di sekolah dasar.',
                'supporter_count' => 750,
                'opponent_count' => 240,
                'target_voice' => 1000,
                'status' => 'published',
                'image' => 'images/community_cleanup_campaign_1774090192711.png',
            ],
            [
                'title' => 'Jalan Rusak Bekasi',
                'category' => 'Infrastructure',
                'location' => 'Bekasi',
                'description' => 'Laporan titik jalan berlubang di sepanjang Jl. Raya Kalimalang yang membahayakan pengendara motor saat hujan.',
                'supporter_count' => 4200,
                'opponent_count' => 5,
                'target_voice' => 5000,
                'status' => 'published',
                'image' => 'images/road_repair_campaign_1774090099529.png',
            ],
        ];

        foreach ($issues as $index => $issue) {
            \App\Models\Suara::updateOrCreate(
                ['title' => $issue['title']],
                array_merge($issue, ['user_id' => $createdUsers[$index % count($createdUsers)]->id])
            );
        }
    }
}
