@php
    $formattedSupport = number_format($stats['total_support'] ?? 0, 0, ',', '.');

    $rawDonation = (float) ($stats['total_donation'] ?? 0);
    if ($rawDonation >= 1000000000) {
        $val = $rawDonation / 1000000000;
        $formattedDonation = 'Rp ' . (fmod($val, 1) !== 0.0 ? number_format($val, 1, ',', '.') : number_format($val, 0, ',', '.')) . 'M';
    } elseif ($rawDonation >= 1000000) {
        $val = $rawDonation / 1000000;
        $formattedDonation = 'Rp ' . (fmod($val, 1) !== 0.0 ? number_format($val, 1, ',', '.') : number_format($val, 0, ',', '.')) . 'M';
    } elseif ($rawDonation >= 1000) {
        $val = $rawDonation / 1000;
        $formattedDonation = 'Rp ' . (fmod($val, 1) !== 0.0 ? number_format($val, 1, ',', '.') : number_format($val, 0, ',', '.')) . 'K';
    } else {
        $formattedDonation = 'Rp ' . number_format($rawDonation, 0, ',', '.');
    }

    $formattedAksi = number_format($stats['total_aksi'] ?? 0, 0, ',', '.');
@endphp

<div class="bg-white p-8 rounded-[32px] card-prominent hover:-translate-y-2 transition-all">
    <div class="w-14 h-14 bg-accent/10 text-accent rounded-2xl flex items-center justify-center mb-6">
        <i data-lucide="megaphone" class="w-8 h-8"></i>
    </div>
    <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Total Support</h4>
    <div class="text-3xl font-outfit font-black text-slate-900">{{ $formattedSupport }} <span class="text-sm text-slate-400 font-bold tracking-normal ml-1">Voices</span></div>
</div>

<div class="bg-white p-8 rounded-[32px] card-prominent hover:-translate-y-2 transition-all">
    <div class="w-14 h-14 bg-success/10 text-success rounded-2xl flex items-center justify-center mb-6">
        <i data-lucide="wallet" class="w-8 h-8"></i>
    </div>
    <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Donasi</h4>
    <div class="text-3xl font-outfit font-black text-slate-900">{{ $formattedDonation }}</div>
</div>

<div class="bg-white p-8 rounded-[32px] card-prominent hover:-translate-y-2 transition-all">
    <div class="w-14 h-14 bg-warning/10 text-warning rounded-2xl flex items-center justify-center mb-6">
        <i data-lucide="users" class="w-8 h-8"></i>
    </div>
    <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Aksi Nyata</h4>
    <div class="text-3xl font-outfit font-black text-slate-900">{{ $formattedAksi }} <span class="text-sm text-slate-400 font-bold tracking-normal ml-1">Kegiatan</span></div>
</div>
