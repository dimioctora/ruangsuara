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

<div class="bg-white p-5 sm:p-8 rounded-2xl sm:rounded-3xl card-prominent hover:-translate-y-1 sm:hover:-translate-y-2 transition-all">
    <div class="w-11 h-11 sm:w-14 sm:h-14 bg-accent/10 text-accent rounded-xl sm:rounded-2xl flex items-center justify-center mb-4 sm:mb-6">
        <i data-lucide="megaphone" class="w-6 h-6 sm:w-8 sm:h-8"></i>
    </div>
    <h4 class="text-[10px] sm:text-xs font-black text-slate-400 uppercase tracking-widest mb-1 sm:mb-2">Total Support</h4>
    <div class="text-2xl sm:text-3xl font-outfit font-black text-slate-900 break-words">{{ $formattedSupport }} <span class="text-xs sm:text-sm text-slate-400 font-bold tracking-normal ml-1">Voices</span></div>
</div>

<div class="bg-white p-5 sm:p-8 rounded-2xl sm:rounded-3xl card-prominent hover:-translate-y-1 sm:hover:-translate-y-2 transition-all">
    <div class="w-11 h-11 sm:w-14 sm:h-14 bg-success/10 text-success rounded-xl sm:rounded-2xl flex items-center justify-center mb-4 sm:mb-6">
        <i data-lucide="wallet" class="w-6 h-6 sm:w-8 sm:h-8"></i>
    </div>
    <h4 class="text-[10px] sm:text-xs font-black text-slate-400 uppercase tracking-widest mb-1 sm:mb-2">Donasi</h4>
    <div class="text-2xl sm:text-3xl font-outfit font-black text-slate-900 break-words">{{ $formattedDonation }}</div>
</div>

<div class="bg-white p-5 sm:p-8 rounded-2xl sm:rounded-3xl card-prominent hover:-translate-y-1 sm:hover:-translate-y-2 transition-all">
    <div class="w-11 h-11 sm:w-14 sm:h-14 bg-warning/10 text-warning rounded-xl sm:rounded-2xl flex items-center justify-center mb-4 sm:mb-6">
        <i data-lucide="users" class="w-6 h-6 sm:w-8 sm:h-8"></i>
    </div>
    <h4 class="text-[10px] sm:text-xs font-black text-slate-400 uppercase tracking-widest mb-1 sm:mb-2">Aksi Nyata</h4>
    <div class="text-2xl sm:text-3xl font-outfit font-black text-slate-900 break-words">{{ $formattedAksi }} <span class="text-xs sm:text-sm text-slate-400 font-bold tracking-normal ml-1">Kegiatan</span></div>
</div>
