<!-- LEFT STRATEGIC COLUMN (30%) -->
<div class="lg:col-span-3 space-y-8 order-2 lg:order-1">
    
    <!-- HEAT INDEX / PROGRESS CARD -->
    @php
        $stage = (int) ($suara->current_stage ?? 1);
        $stagePercent = min(100, $stage * 20);
        $heatColor = $stage <= 2 ? 'accent' : ($stage <= 4 ? 'amber-500' : 'emerald-500');
        $stageNames = [
            1 => 'Tahap 1: Issue Dibuat',
            2 => 'Tahap 2: Penggalangan Aspirasi',
            3 => 'Tahap 3: Pembaruan & Bukti',
            4 => 'Tahap 4: Kajian & Keputusan',
            5 => 'Tahap 5: Aksi Nyata Selesai'
        ];
    @endphp
    <div class="bg-white p-8 rounded-[40px] border border-slate-100 card-shadow relative group overflow-hidden">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Status Progres Isu</h4>
                <div class="flex items-center gap-2 text-accent">
                    <span class="w-2 h-2 rounded-full bg-accent animate-ping"></span>
                    <span class="text-xs font-black uppercase tracking-wider">{{ $stageNames[$stage] ?? 'Aktif' }}</span>
                </div>
            </div>
            <div class="w-10 h-10 rounded-2xl bg-accent/10 text-accent flex items-center justify-center">
                <i data-lucide="activity" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="space-y-3 mb-6">
            <div class="flex items-center justify-between text-xs font-bold">
                <span class="text-slate-400">Penyelesaian Isu</span>
                <span class="text-slate-900 font-extrabold">{{ $stagePercent }}%</span>
            </div>
            <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-accent transition-all duration-700 rounded-full" style="width: {{ $stagePercent }}%"></div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-3 pt-4 border-t border-slate-100 text-center">
            <div class="p-3 bg-slate-50 rounded-2xl">
                <p class="text-[9px] font-black uppercase tracking-wider text-slate-400">Total Dukungan</p>
                <p class="text-lg font-black font-outfit text-slate-900 mt-0.5">{{ number_format($suara->supporter_count ?? 0) }}</p>
            </div>
            <div class="p-3 bg-slate-50 rounded-2xl">
                <p class="text-[9px] font-black uppercase tracking-wider text-slate-400">Komentar Warga</p>
                <p class="text-lg font-black font-outfit text-slate-900 mt-0.5">{{ number_format($suara->comments()->count()) }}</p>
            </div>
        </div>
    </div>

    <!-- NAVIGATION MENU -->
    <nav class="bg-white p-6 md:p-8 rounded-[40px] border border-slate-100 card-shadow space-y-2">
        <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 px-4 mb-4">Menu Manajemen</h4>
        
        <!-- 1. Pembaruan Isu (Primary) -->
        <button @click="activeTab = 'updates'" 
            :class="activeTab === 'updates' ? 'bg-primary text-white shadow-xl translate-x-2' : 'text-slate-600 hover:bg-slate-50'" 
            class="w-full flex items-center justify-between gap-4 px-6 py-4 rounded-2xl font-bold text-xs group transition-all text-left">
            <div class="flex items-center gap-3">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                <span>Pembaruan Isu</span>
            </div>
            <span :class="activeTab === 'updates' ? 'bg-accent text-white' : 'bg-slate-100 text-slate-600'" class="px-2 py-0.5 rounded-full text-[10px] font-black">
                {{ $updates->count() }}
            </span>
        </button>

        <!-- 2. Detail Isu -->
        <button @click="activeTab = 'issue'" 
            :class="activeTab === 'issue' ? 'bg-primary text-white shadow-xl translate-x-2' : 'text-slate-600 hover:bg-slate-50'" 
            class="w-full flex items-center justify-between gap-4 px-6 py-4 rounded-2xl font-bold text-xs group transition-all text-left">
            <div class="flex items-center gap-3">
                <i data-lucide="file-text" class="w-4 h-4"></i>
                <span>Detail & Edit Isu</span>
            </div>
        </button>

        <!-- 3. Tahapan & Heat Index -->
        <button @click="activeTab = 'tahapan'" 
            :class="activeTab === 'tahapan' ? 'bg-primary text-white shadow-xl translate-x-2' : 'text-slate-600 hover:bg-slate-50'" 
            class="w-full flex items-center justify-between gap-4 px-6 py-4 rounded-2xl font-bold text-xs group transition-all text-left">
            <div class="flex items-center gap-3">
                <i data-lucide="git-commit" class="w-4 h-4"></i>
                <span>Tahapan & Status</span>
            </div>
            <span class="text-[10px] font-bold text-slate-400">Tahap {{ $stage }}</span>
        </button>

        <!-- 4. Aksi Lapangan & Relawan -->
        <button @click="activeTab = 'aksi'" 
            :class="activeTab === 'aksi' ? 'bg-primary text-white shadow-xl translate-x-2' : 'text-slate-600 hover:bg-slate-50'" 
            class="w-full flex items-center justify-between gap-4 px-6 py-4 rounded-2xl font-bold text-xs group transition-all text-left">
            <div class="flex items-center gap-3">
                <i data-lucide="users" class="w-4 h-4"></i>
                <span>Aksi & Relawan</span>
            </div>
            <span :class="activeTab === 'aksi' ? 'bg-accent text-white' : 'bg-slate-100 text-slate-600'" class="px-2 py-0.5 rounded-full text-[10px] font-black">
                {{ $missions->count() }}
            </span>
        </button>

        @if($suara->is_fundraising)
            <!-- 5. Dana & Logistik -->
            <button @click="activeTab = 'keuangan'" 
                :class="activeTab === 'keuangan' ? 'bg-primary text-white shadow-xl translate-x-2' : 'text-slate-600 hover:bg-slate-50'" 
                class="w-full flex items-center justify-between gap-4 px-6 py-4 rounded-2xl font-bold text-xs group transition-all text-left">
                <div class="flex items-center gap-3">
                    <i data-lucide="wallet" class="w-4 h-4"></i>
                    <span>Dana & Donasi</span>
                </div>
            </button>
        @endif
    </nav>

    <!-- CREATOR PROFILE CARD -->
    <div class="bg-white p-6 md:p-8 rounded-[40px] border border-slate-100 card-shadow space-y-4">
        <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Inisiator Isu</h4>
        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl">
            @if($suara->user && $suara->user->avatar_url)
                <img src="{{ $suara->user->avatar_url }}" class="w-12 h-12 rounded-xl object-cover border border-slate-200" alt="{{ $suara->user->name }}">
            @else
                <div class="w-12 h-12 rounded-xl bg-accent/10 text-accent font-black flex items-center justify-center text-base">
                    {{ strtoupper(substr($suara->user->name ?? 'User', 0, 2)) }}
                </div>
            @endif
            <div class="overflow-hidden">
                <p class="text-sm font-bold text-slate-900 truncate">{{ $suara->user->name ?? 'Pengguna' }}</p>
                <p class="text-[10px] font-medium text-slate-400 truncate">{{ $suara->user->email ?? '' }}</p>
                <span class="inline-block mt-1 px-2 py-0.5 bg-accent/10 text-accent rounded text-[9px] font-bold">
                    {{ $suara->user->level ?? 'Partisipan' }}
                </span>
            </div>
        </div>
    </div>
</div>
