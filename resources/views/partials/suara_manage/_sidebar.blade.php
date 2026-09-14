<!-- LEFT STRATEGIC COLUMN (30%) -->
<div class="lg:col-span-3 space-y-10 order-2 lg:order-1">
    
    <!-- HEAT INDEX -->
    @php
        $heatScore = min(10, 5.0 + (($suara->current_stage ?? 1) - 1) * 1.25);
        $heatColor = $heatScore < 3 ? 'success' : ($heatScore < 7 ? 'warning' : 'heat');
        $heatPercent = min(100, $heatScore * 10);
    @endphp
    <div class="bg-white p-10 rounded-[48px] border border-slate-100 card-shadow relative group overflow-hidden transition-all duration-700">
        <div class="absolute top-0 left-0 w-1.5 h-full bg-{{ $heatColor }} transition-colors duration-700"></div>
        <div class="flex items-center justify-between mb-8">
            <div>
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]  mb-1">Heat Index</h4>
                <div class="flex items-center gap-2 text-{{ $heatColor }} transition-colors duration-700">
                    <div class="w-2 h-2 rounded-full bg-{{ $heatColor }} animate-ping"></div>
                    <span class="text-[10px] font-black uppercase tracking-widest leading-none ">LIVE SCORE</span>
                </div>
            </div>
            <i data-lucide="flame" class="w-5 h-5 text-{{ $heatColor }}/30 group-hover:scale-110 transition-all duration-700"></i>
        </div>

        <div class="flex flex-col items-center mb-10">
            <div class="relative">
                <svg class="w-32 h-32 -rotate-90">
                    <circle cx="64" cy="64" r="56" fill="none" class="stroke-slate-100" stroke-width="12" />
                    <circle cx="64" cy="64" r="56" fill="none" class="stroke-{{ $heatColor }}" stroke-width="12" stroke-dasharray="351.85" stroke-dashoffset="{{ 351.85 * (1 - ($heatScore/10)) }}" stroke-linecap="round" class="transition-all duration-1000" />
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-4xl font-outfit font-black text-slate-900  tracking-tighter">{{ number_format($heatScore, 1) }}</span>
                    <span class="text-[9px] font-black text-slate-300 uppercase leading-none tracking-widest mt-1 ">Score</span>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="flex items-center justify-between px-2">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest  leading-none">Overall Growth</span>
                <span class="text-xs font-black text-success tracking-tighter">+{{ 5 + ($suara->current_stage * 2) }}%</span>
            </div>
            <div class="w-full h-1.5 bg-slate-50 rounded-full overflow-hidden">
                <div class="h-full bg-{{ $heatColor }} transition-all duration-1000" style="width: {{ $heatPercent }}%"></div>
            </div>
        </div>
    </div>

    <nav class="bg-white p-8 rounded-[48px] border border-slate-100 card-shadow space-y-2">
        <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 px-6 mb-8 ">Operating Hub</h4>
        
        <button @click="activeTab = 'issue'" :class="activeTab === 'issue' ? 'bg-tactical text-white shadow-xl translate-x-3' : 'text-slate-500 hover:bg-slate-50'" class="w-full flex items-center justify-between gap-4 px-8 py-5 rounded-[28px] font-black text-[10px] group transition-all uppercase tracking-widest  text-left">
            <div class="flex items-center gap-4">
                <i data-lucide="file-text" class="w-4 h-4"></i>
                Suara Issue
            </div>
        </button>

        <button @click="activeTab = 'tugas'" :class="activeTab === 'tugas' ? 'bg-tactical text-white shadow-xl translate-x-3' : 'text-slate-500 hover:bg-slate-50'" class="w-full flex items-center justify-between gap-4 px-8 py-5 rounded-[28px] font-black text-[10px] group transition-all uppercase tracking-widest ">
            <div class="flex items-center gap-4">
                <i data-lucide="check-square" class="w-4 h-4"></i>
                Manajemen Tugas
            </div>
        </button>

        <button @click="activeTab = 'aksi'" :class="activeTab === 'aksi' ? 'bg-tactical text-white shadow-xl translate-x-3' : 'text-slate-500 hover:bg-slate-50'" class="w-full flex items-center justify-between gap-4 px-8 py-5 rounded-[28px] font-black text-[10px] group transition-all uppercase tracking-widest ">
            <div class="flex items-center gap-4">
                <i data-lucide="crosshair" class="w-4 h-4"></i>
                Aksi Lapangan
            </div>
            <span :class="activeTab === 'aksi' ? 'bg-accent text-white' : 'bg-slate-100 text-slate-400'" class="px-2 py-0.5 rounded text-[8px] font-black tracking-normal ">LIVE</span>
        </button>

        <button @click="activeTab = 'keuangan'" :class="activeTab === 'keuangan' ? 'bg-tactical text-white shadow-xl translate-x-3' : 'text-slate-500 hover:bg-slate-50'" class="w-full flex items-center justify-between gap-4 px-8 py-5 rounded-[28px] font-black text-[10px] group transition-all uppercase tracking-widest ">
            <div class="flex items-center gap-4">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
                Dana & Logistik
            </div>
        </button>
        
        <div class="my-6 h-px bg-slate-100 mx-8 opacity-50"></div>

        <button @click="activeTab = 'admin'" :class="activeTab === 'admin' ? 'bg-heat/10 text-heat shadow-xl translate-x-3 border border-heat/20' : 'text-rose-400 hover:bg-rose-50'" class="w-full flex items-center gap-4 px-8 py-5 rounded-[28px] font-black text-[10px] group transition-all uppercase tracking-widest ">
            <i data-lucide="shield-alert" class="w-4 h-4"></i>
            Security Root
        </button>
    </nav>

    <!-- PERSONNEL ASSIGNMENT -->
    <div class="bg-white p-10 rounded-[48px] border border-slate-100 card-shadow space-y-8">
        <div class="flex items-center justify-between">
             <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ">Personnel Assignment</h4>
             <i data-lucide="users" class="w-4 h-4 text-slate-200"></i>
        </div>
        <div class="space-y-4">
             <div class="flex items-center justify-between p-5 bg-slate-900 rounded-[32px] text-white overflow-hidden relative shadow-xl">
                 <div class="flex items-center gap-4 relative z-10">
                     <img src="https://i.pravatar.cc/100?u={{ $user->id }}" class="w-10 h-10 border-2 border-accent rounded-xl object-cover shadow-lg" />
                     <div>
                         <p class="text-[10px] font-black uppercase  leading-none mb-1">{{ $user->name }}</p>
                         <p class="text-[8px] font-bold text-accent uppercase tracking-widest ">MISSION COMMANDER</p>
                     </div>
                 </div>
                 <i data-lucide="shield-check" class="w-4 h-4 text-accent relative z-10"></i>
                 <div class="absolute right-0 top-0 h-full w-24 bg-accent/10 -mr-8 -skew-x-12"></div>
             </div>

             <!-- ADD MODERATOR UNIT -->
             <button class="w-full flex items-center justify-between p-5 bg-slate-50 border-2 border-dashed border-slate-200 rounded-[32px] text-slate-400 group hover:border-accent/40 hover:bg-white transition-all">
                 <div class="flex items-center gap-4">
                     <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center group-hover:bg-accent/10 group-hover:text-accent transition-all text-slate-300">
                         <i data-lucide="plus" class="w-5 h-5"></i>
                     </div>
                     <div class="text-left">
                         <p class="text-[10px] font-black uppercase  leading-none mb-1 group-hover:text-slate-900 transition-colors text-slate-400">Assign Moderator</p>
                         <p class="text-[8px] font-bold uppercase tracking-widest  opacity-40">Intelligence & Support</p>
                     </div>
                 </div>
                 <i data-lucide="user-plus" class="w-4 h-4 opacity-20 group-hover:opacity-100 group-hover:text-accent transition-all"></i>
             </button>

             <!-- ADD COORDINATOR UNIT -->
             <button class="w-full flex items-center justify-between p-5 bg-slate-50 border-2 border-dashed border-slate-200 rounded-[32px] text-slate-400 group hover:border-success/40 hover:bg-white transition-all">
                 <div class="flex items-center gap-4">
                     <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center group-hover:bg-success/10 group-hover:text-success transition-all text-slate-300">
                         <i data-lucide="plus" class="w-5 h-5"></i>
                     </div>
                     <div class="text-left">
                         <p class="text-[10px] font-black uppercase  leading-none mb-1 group-hover:text-slate-900 transition-colors text-slate-400">Assign Coordinator</p>
                         <p class="text-[8px] font-bold uppercase tracking-widest  opacity-40">Field Ops Leadership</p>
                     </div>
                 </div>
                 <i data-lucide="user-plus" class="w-4 h-4 opacity-20 group-hover:opacity-100 group-hover:text-success transition-all"></i>
             </button>
        </div>
    </div>

    <!-- INTELLIGENCE FEED -->
    <div class="bg-white p-10 rounded-[48px] border border-slate-100 card-shadow space-y-8 relative overflow-hidden">
        <div class="flex items-center justify-between">
             <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400  leading-none">Intelligence Feed</h4>
             <span class="flex items-center gap-2">
                 <span class="w-1.5 h-1.5 rounded-full bg-success animate-pulse"></span>
                 <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Live</span>
             </span>
        </div>
        <div class="space-y-8 relative z-10">
            <div class="flex gap-4 group">
                 <div class="flex flex-col items-center">
                     <div class="w-1.5 h-1.5 rounded-full bg-accent mt-1 transition-all group-hover:scale-150"></div>
                     <div class="w-px flex-1 bg-slate-100 my-2"></div>
                 </div>
                 <div>
                     <p class="text-[9px] font-bold text-slate-400  leading-none mb-1">2m ago</p>
                     <p class="text-[10px] font-medium text-slate-900 leading-relaxed  uppercase"><strong class="font-black">Commander</strong> updated mission briefing.</p>
                 </div>
            </div>

            <div class="flex gap-4 group">
                 <div class="flex flex-col items-center">
                     <div class="w-1.5 h-1.5 rounded-full bg-success mt-1"></div>
                     <div class="w-px flex-1 bg-slate-100 my-2"></div>
                 </div>
                 <div>
                     <p class="text-[9px] font-bold text-slate-400  leading-none mb-1">15m ago</p>
                     <p class="text-[10px] font-medium text-slate-900 leading-relaxed  uppercase"><span class="text-success font-black">+12 People</span> joined tactical unit.</p>
                 </div>
            </div>

            <div class="flex gap-4 group">
                 <div class="flex flex-col items-center">
                     <div class="w-1.5 h-1.5 rounded-full bg-heat mt-1"></div>
                 </div>
                 <div>
                     <p class="text-[9px] font-bold text-slate-400  leading-none mb-1">45m ago</p>
                     <p class="text-[10px] font-medium text-slate-900 leading-relaxed  uppercase"><strong class="text-heat font-black">Alert:</strong> Sentiment drop detected (-8%).</p>
                 </div>
            </div>
        </div>
    </div>
</div>
