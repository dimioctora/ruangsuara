<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Suara;
use App\Models\SuaraVote;
use App\Models\FieldMission;
use App\Models\FinanceTransaction;
use Carbon\Carbon;

class DashboardStatsSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'dimioctora@gmail.com')->first();
        if (!$user) {
            $user = User::first();
        }

        if (!$user) {
            return;
        }

        // Get some suaras to vote and interact with
        $suaras = Suara::all();
        if ($suaras->isEmpty()) {
            return;
        }

        // 1. Assign 2 suaras to this user if none
        $userSuaras = Suara::where('user_id', $user->id)->get();
        if ($userSuaras->isEmpty()) {
            $suaraToAssign = $suaras->first();
            $suaraToAssign->update([
                'user_id' => $user->id,
                'is_fundraising' => true,
                'fund_target' => 50000000,
                'supporter_count' => 124,
            ]);
            $userSuaras = collect([$suaraToAssign]);
        }

        $primarySuara = $userSuaras->first();

        // 2. Seed Votes for user (Total Support)
        foreach ($suaras->take(5) as $s) {
            SuaraVote::firstOrCreate(
                ['user_id' => $user->id, 'suara_id' => $s->id],
                ['type' => 'pro']
            );
        }

        // 3. Seed Inbound Donations (Finance Transactions)
        FinanceTransaction::firstOrCreate(
            ['user_id' => $user->id, 'suara_id' => $primarySuara->id, 'description' => 'Donasi Awal Program'],
            [
                'type' => 'inbound',
                'sector' => 'Advokasi',
                'amount' => 2400000,
                'status' => 'secured',
            ]
        );

        // 4. Seed Field Missions (Aksi Nyata)
        $missions = [
            [
                'objective' => 'Investigasi & Dokumentasi Lapangan',
                'location' => 'Jakarta Pusat',
                'scheduled_at' => Carbon::now()->addDays(2),
                'target_personnel' => 15,
                'instructions' => 'Kumpulkan bukti foto dan video kondisi riil di lokasi.',
                'status' => 'active',
            ],
            [
                'objective' => 'Audiensi dengan Pemangku Kebijakan',
                'location' => 'Gedung DPRD',
                'scheduled_at' => Carbon::now()->addDays(5),
                'target_personnel' => 8,
                'instructions' => 'Penyampaian draft rekomendasi warga.',
                'status' => 'active',
            ],
            [
                'objective' => 'Aksi Damai & Penyebaran Petisi',
                'location' => 'Area Publik',
                'scheduled_at' => Carbon::now()->addDays(7),
                'target_personnel' => 50,
                'instructions' => 'Distribusi materi edukasi kepada masyarakat.',
                'status' => 'active',
            ]
        ];

        foreach ($missions as $m) {
            FieldMission::firstOrCreate(
                ['user_id' => $user->id, 'suara_id' => $primarySuara->id, 'objective' => $m['objective']],
                $m
            );
        }
    }
}
