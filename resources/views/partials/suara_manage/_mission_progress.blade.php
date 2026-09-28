<!-- TAHAPAN & STATUS PROGRES HEAT INDEX -->
<div x-show="activeTab === 'tahapan' || activeTab === 'updates' || activeTab === 'issue'" x-transition:enter="transition ease-out duration-500" class="bg-white p-8 md:p-10 rounded-[40px] border border-slate-100 card-shadow relative overflow-hidden">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <i data-lucide="git-commit" class="w-4 h-4 text-accent"></i>
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Tahapan Perkembangan Isu</h4>
            </div>
            <h3 class="text-xl md:text-2xl font-black font-outfit text-slate-900 tracking-tight">Timeline & Heat Index</h3>
        </div>

        <div class="flex items-center gap-3">
            <button @click="isPhaseEditing = !isPhaseEditing" 
                class="px-5 py-2.5 rounded-2xl border border-slate-200 text-slate-600 text-xs font-bold hover:border-accent hover:text-accent transition-all shadow-sm active:scale-95 flex items-center gap-2 bg-white"
                :class="isPhaseEditing ? 'border-accent text-accent bg-accent/5' : ''">
                <i data-lucide="sliders-horizontal" class="w-4 h-4"></i>
                <span x-text="isPhaseEditing ? 'Tutup Pengubah Status' : 'Ubah Status Tahapan'"></span>
            </button>
            <span class="px-4 py-2 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-xl text-xs font-bold flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Tahap {{ $suara->current_stage ?? 1 }} Aktif
            </span>
        </div>
    </div>

    @php
        $stages = [
            1 => ['name' => 'Issue Dibuat', 'short' => 'Issue', 'icon' => 'alert-circle', 'desc' => 'Laporan pertama kali dipublikasikan'],
            2 => ['name' => 'Penggalangan Aspirasi', 'short' => 'Aspirasi', 'icon' => 'megaphone', 'desc' => 'Pengumpulan suara dan dukungan publik'],
            3 => ['name' => 'Pembaruan & Bukti', 'short' => 'Pembaruan', 'icon' => 'refresh-cw', 'desc' => 'Bukti lanjutan & kronologi berkala'],
            4 => ['name' => 'Kajian & Keputusan', 'short' => 'Keputusan', 'icon' => 'scale', 'desc' => 'Respon & tindak lanjut pihak berwenang'],
            5 => ['name' => 'Aksi Nyata Selesai', 'short' => 'Selesai', 'icon' => 'check-circle-2', 'desc' => 'Solusi tuntas di lapangan'],
        ];
        $cStage = (int) ($suara->current_stage ?? 1);
        if ($cStage < 1) $cStage = 1;
        if ($cStage > 5) $cStage = 5;
    @endphp

    <!-- DESKTOP TIMELINE DISPLAY -->
    <div class="overflow-x-auto pb-4">
        <div class="min-w-[620px] relative px-4 py-6">
            <!-- Progress Line -->
            <div class="absolute top-[52px] left-10 right-10 h-1.5 bg-slate-100 -translate-y-1/2 rounded-full overflow-hidden">
                <div class="h-full bg-accent transition-all duration-700" style="width: {{ (($cStage - 1) / 4) * 100 }}%"></div>
            </div>

            <!-- Nodes -->
            <div class="relative flex justify-between items-start">
                @foreach($stages as $num => $s)
                    @php
                        $isDone = $num < $cStage;
                        $isActive = $num == $cStage;
                    @endphp
                    <div class="flex flex-col items-center text-center flex-1 group"
                         :class="isPhaseEditing ? 'cursor-pointer' : ''"
                         @click="if(isPhaseEditing) { if(confirm('Pindahkan status isu ke Tahap {{ $num }}: {{ $s['name'] }}?')) { $refs.stageForm{{ $num }}.submit(); } }">
                        
                        <!-- Badge indicator when in edit mode -->
                        <div x-show="isPhaseEditing && {{ $num }} != {{ $cStage }}" x-cloak class="mb-2 px-2.5 py-0.5 bg-accent text-white text-[9px] font-black uppercase rounded-full shadow-md animate-bounce">
                            Pilih
                        </div>

                        <!-- Circle Node -->
                        <div :class="isPhaseEditing && {{ $num }} != {{ $cStage }} ? 'ring-2 ring-accent/40 animate-pulse' : ''"
                            class="w-12 h-12 rounded-2xl flex items-center justify-center z-10 transition-all duration-300 shadow-md relative {{ $isDone ? 'bg-accent text-white' : ($isActive ? 'bg-white border-4 border-accent text-accent ring-4 ring-accent/20 scale-110' : 'bg-white border-2 border-slate-200 text-slate-300 group-hover:border-accent group-hover:text-accent') }}">
                            <i data-lucide="{{ $isDone ? 'check' : $s['icon'] }}" class="w-5 h-5"></i>
                        </div>

                        <div class="mt-3 space-y-0.5">
                            <p class="text-xs font-black {{ $isActive ? 'text-slate-900 font-outfit' : ($isDone ? 'text-accent' : 'text-slate-400') }}">
                                {{ $s['short'] }}
                            </p>
                            <p class="text-[10px] text-slate-400 font-medium hidden sm:block max-w-[110px] leading-tight">
                                {{ $s['desc'] }}
                            </p>
                        </div>

                        <form x-ref="stageForm{{ $num }}" action="/suara-manage/{{ $suara->id }}/update-stage" method="POST" class="hidden">
                            @csrf
                            <input type="hidden" name="stage" value="{{ $num }}">
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Quick stage selector panel when isPhaseEditing -->
    <div x-show="isPhaseEditing" x-cloak class="mt-6 p-6 bg-slate-50 rounded-3xl border border-slate-200/80 space-y-4 animate-fade-in">
        <h5 class="text-xs font-black uppercase tracking-wider text-slate-700">Pilih Tahapan Baru untuk Isu Ini:</h5>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-3">
            @foreach($stages as $num => $s)
                <form action="/suara-manage/{{ $suara->id }}/update-stage" method="POST">
                    @csrf
                    <input type="hidden" name="stage" value="{{ $num }}">
                    <button type="submit" class="w-full text-left p-4 rounded-2xl border transition-all flex items-start gap-3 {{ $num == $cStage ? 'bg-accent text-white border-accent shadow-md' : 'bg-white text-slate-800 border-slate-200 hover:border-accent' }}">
                        <span class="w-6 h-6 rounded-lg {{ $num == $cStage ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }} flex items-center justify-center text-xs font-bold shrink-0">
                            {{ $num }}
                        </span>
                        <div>
                            <p class="text-xs font-bold">{{ $s['name'] }}</p>
                            <p class="text-[10px] {{ $num == $cStage ? 'text-white/80' : 'text-slate-400' }} mt-0.5 leading-tight">{{ $s['desc'] }}</p>
                        </div>
                    </button>
                </form>
            @endforeach
        </div>
    </div>
</div>
