<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Suara;
use App\Models\SuaraVote;
use App\Models\SuaraComment;

class KarhutlaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create or update User: Rahmat Hidayat
        $user = User::updateOrCreate(
            ['email' => 'rahmat.hidayat@ruangsuara.id'],
            [
                'name' => 'Rahmat Hidayat',
                'password' => Hash::make('RuangSuara2026!'),
                'xp' => 850,
                'level' => 'Penggerak',
                'trust_score' => 88,
                'role' => 'Penggerak',
                'tagline' => 'Relawan Siaga Bencana & Pemantau Gambut Kalteng',
                'city' => 'Palangka Raya',
                'country' => 'Indonesia',
                'is_verified' => 1,
                'avatar' => 'avatars/rahmat_hidayat.jpg',
            ]
        );

        // 2. Create Suara
        $description = <<<'HTML'
<p>Memasuki puncak musim kemarau, titik panas (hotspot) di kawasan lahan gambut Kabupaten Pulang Pisau dan sekitarnya mengalami lonjakan signifikan dalam dua pekan terakhir. Pantauan langsung tim relawan dan Masyarakat Peduli Api (MPA) di Kecamatan Kahayan Hilir dan Jabiren Raya menunjukkan kebakaran bawah tanah (<em>smoldering peat fire</em>) terus merambat perlahan namun meluas di kedalaman 1,5 hingga 3 meter di bawah permukaan.</p>
<p><br></p>
<p>Kondisi ini memicu kepulan asap putih pekat yang mulai menyelimuti ruas jalan poros Trans-Kalimantan (Palangka Raya – Banjarmasin). Jarak pandang pada pagi dan sore hari turun drastis hingga di bawah 250 meter, mengancam keselamatan pengguna jalan serta memicu lonjakan kasus ISPA, terutama pada kelompok rentan balita dan lansia di desa-desa sekitar.</p>
<p><br></p>
<p><strong>Kendala Kritis di Lapangan:</strong></p>
<ul>
<li><strong>Krisis Sumber Air:</strong> Kanal-kanal primer dan sekunder di sekitar eks lahan gambut sejuta hektar (PLG) mengalami penyusutan drastis. Sumur bor darurat yang dibuat warga sebagian besar mengeluarkan lumpur pekat atau kering.</li>
<li><strong>Aksesibilitas dan Logistik:</strong> Titik api berada 2 hingga 4 kilometer dari jalan akses terdekat. Tim gabungan Manggala Agni, BPBD, dan relawan warga harus memanggul pompa jinjing dan menyambung hingga puluhan rol selang menembus semak belukar gambut yang rentan amblas.</li>
<li><strong>Keterbatasan Perlengkapan Perlindungan:</strong> Relawan lokal masih kekurangan masker respirator standar partikulat (N95/FFP2), kacamata pelindung asap (goggles), serta lampu sorot lapangan untuk pemadaman malam hari.</li>
</ul>
<p><br></p>
<p>Sebagian titik api terindikasi berada di area terbuka perbatasan konsesi perkebunan dan lahan telantar yang sekat kanalnya tidak terawat. Tanpa rehidrasi gambut dan pemadaman udara intensif (water bombing) yang terkoordinasi tepat sasaran di titik-titik inti, api bawah tanah dikhawatirkan bertahan hingga berminggu-minggu ke depan.</p>
<p><br></p>
<p><strong>Pernyataan dan Fokus Pantauan Ruang Suara:</strong></p>
<p>Isu ini diinisiasi untuk mengawal transparansi penanganan karhutla dari tingkat tapak hingga pembuat kebijakan:</p>
<ol>
<li>Mendorong percepatan distribusi peralatan pompa apung dan selang tekanan tinggi ke posko-posko desa MPA terdepan.</li>
<li>Mendesak pembukaan posko kesehatan darurat 24 jam dengan fasilitas tabung oksigen gratis bagi warga terdampak kabut asap.</li>
<li>Meminta kejelasan audit dan evaluasi fungsi sekat kanal (canal blocking) di wilayah konsesi serta penegakan hukum tegas terhadap pemilik lahan yang terbukti lalai menjaga lahannya dari kebakaran.</li>
</ol>
<p><br></p>
<p><em>Laporan ini akan terus diperbarui secara berkala berdasarkan verifikasi data titik koordinat, laporan satelit SiPongi KLHK, dan situasi riil tim relawan lapangan.</em></p>
HTML;

        $expectedImpact = <<<'HTML'
<p>• Percepatan mobilisasi bantuan logistik mesin pompa apung dan selang untuk MPA di garda terdepan.</p><p>• Pembukaan posko kesehatan darurat dan pembagian masker medis N95 bagi warga desa terdampak asap.</p><p>• Transparansi penanganan dan audit kepemilikan lahan terbakar oleh satgas terpadu dan penegak hukum.</p>
HTML;

        $suara = Suara::updateOrCreate(
            [
                'title' => 'Karhutla Lahan Gambut Pulang Pisau Meluas: Asap Pekat Kepung Jalur Trans-Kalimantan dan Krisis Air Pemadaman'
            ],
            [
                'user_id' => $user->id,
                'category' => 'Lingkungan',
                'location' => 'Kab. Pulang Pisau, Kalimantan Tengah',
                'reference_link' => 'https://sipongi.menlhk.go.id',
                'description' => $description,
                'image' => 'suaras/karhutla_gambut_kalteng.jpg',
                'contribution_type' => 'voice',
                'target_voice' => 500,
                'supporter_count' => 8,
                'opponent_count' => 0,
                'expected_impact' => $expectedImpact,
                'status' => 'published',
                'current_stage' => 1,
                'is_fundraising' => false,
                'fund_target' => null,
            ]
        );

        // 3. User votes
        SuaraVote::updateOrCreate(
            ['user_id' => $user->id, 'suara_id' => $suara->id],
            ['type' => 'pro']
        );

        $admin = User::where('id', 1)->first();
        if ($admin) {
            SuaraVote::updateOrCreate(
                ['user_id' => $admin->id, 'suara_id' => $suara->id],
                ['type' => 'pro']
            );

            SuaraComment::updateOrCreate(
                ['user_id' => $admin->id, 'suara_id' => $suara->id],
                [
                    'comment' => 'Data dan titik hotspot sudah kami pantau bersama tim koordinator regional Kalimantan. Sangat krusial untuk suplai masker N95 dan pompa apung ke MPA desa secepatnya. Terus kawal bersama warga!',
                    'likes_count' => 5,
                ]
            );
        }

        $guest = User::where('id', 2)->first();
        if ($guest) {
            SuaraVote::updateOrCreate(
                ['user_id' => $guest->id, 'suara_id' => $suara->id],
                ['type' => 'pro']
            );

            SuaraComment::updateOrCreate(
                ['user_id' => $guest->id, 'suara_id' => $suara->id],
                [
                    'comment' => 'Kabut asap di perbatasan Jabiren tadi pagi memang tebal sekali sampai pedih di mata dan jarak pandang sangat pendek. Tolong pengendara yang melintas Trans-Kalimantan selalu nyalakan lampu utama.',
                    'likes_count' => 3,
                ]
            );
        }

        echo "Seeder successfully ran. Suara ID: " . $suara->id . " by User: " . $user->name . PHP_EOL;
    }
}
