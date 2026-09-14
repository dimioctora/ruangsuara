<!-- VIEW: AKSI LAPANGAN -->
<div x-show="activeTab === 'aksi'" x-transition:enter="transition ease-out duration-500" class="space-y-10">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-2 h-8 bg-accent rounded-full"></div>
            <h3 class="text-xl font-black uppercase tracking-[0.3em] text-slate-900 ">Deployment control center</h3>
        </div>
        <!-- NEW MISSION TRIGGER -->
        <button @click="isAddingMission = true; $nextTick(() => { document.body.style.overflow = 'hidden' })" 
            class="px-8 py-5 bg-primary text-white text-[10px] font-black uppercase tracking-widest rounded-3xl shadow-2xl hover:bg-tactical hover:scale-105 active:scale-95 transition-all flex items-center gap-4  group relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-accent/0 via-accent/20 to-accent/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
            <i data-lucide="plus" class="w-5 h-5 group-hover:rotate-90 transition-transform"></i>
            New Field Mission
        </button>
    </div>

    <!-- MISSION DEPLOYMENT MODAL OVERLAY -->
    <template x-teleport="body">
        <div x-show="isAddingMission" 
            x-transition:enter="transition ease-out duration-300" 
            x-transition:enter-start="opacity-0" 
            x-transition:enter-end="opacity-100" 
            x-transition:leave="transition ease-in duration-200" 
            x-transition:leave-start="opacity-100" 
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[200] flex items-center justify-center bg-primary/60 backdrop-blur-md p-6"
            x-cloak>
            
            <div @click.away="isAddingMission = false; document.body.style.overflow = 'auto'"
                x-show="isAddingMission"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 scale-95 translate-y-10"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                class="w-full max-w-4xl bg-white rounded-[64px] shadow-[0_32px_128px_-16px_rgba(15,23,42,0.5)] border border-white/10 overflow-hidden relative">
                
                <!-- Modal Header -->
                <div class="bg-primary p-12 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-96 h-96 bg-accent opacity-10 rounded-full -mr-32 -mt-32 animate-pulse"></div>
                    <div class="relative z-10 flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.4em] text-accent mb-2 ">Phase Activation</p>
                            <h2 class="text-4xl font-outfit font-black uppercase tracking-tighter ">Mission Deployment Protocol</h2>
                        </div>
                        <button @click="isAddingMission = false; document.body.style.overflow = 'auto'" class="w-14 h-14 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center hover:bg-white/10 transition-all">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>
                </div>

                <!-- Form Body -->
                <div class="p-12">
                    <form action="{{ url('/suara-manage/' . $suara->id . '/deploy-mission') }}" method="POST" @submit="isAddingMission = false; document.body.style.overflow = 'auto'" class="space-y-12">
                        @csrf
                <div class="grid md:grid-cols-2 gap-12">
                    <div class="md:col-span-2 space-y-4">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]  px-4">Strategic Issue Context</label>
                        <div class="w-full px-10 py-6 bg-slate-100/50 border-2 border-slate-100 rounded-[32px] font-black text-[14px]  text-slate-500 uppercase tracking-widest shadow-inner flex items-center justify-between">
                            <span>{{ $suara->title }}</span>
                            <div class="flex items-center gap-2">
                                <span class="text-[8px] opacity-40">LOCKED CONTEXT</span>
                                <i data-lucide="lock" class="w-4 h-4 text-slate-300"></i>
                            </div>
                        </div>
                        <input type="hidden" name="suara_id" value="{{ $suara->id }}">
                    </div>
                    <div class="space-y-4">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]  px-4">Tactical Objective Name</label>
                        <input type="text" name="objective" required placeholder="e.g. MASS MOBILIZATION PHASE 2" class="w-full px-10 py-6 bg-slate-50 border-2 border-slate-100 rounded-[32px] font-black text-[14px]  text-slate-900 focus:border-accent focus:bg-white outline-none transition-all shadow-inner uppercase tracking-widest">
                    </div>
                    <div class="space-y-4">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]  px-4">Operation Base (Location)</label>
                        <input type="text" name="location" required placeholder="e.g. SOUTH SQUARE COMMAND" class="w-full px-10 py-6 bg-slate-50 border-2 border-slate-100 rounded-[32px] font-black text-[14px]  text-slate-900 focus:border-accent focus:bg-white outline-none transition-all shadow-inner uppercase tracking-widest">
                    </div>
                    <div class="space-y-4">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]  px-4">Deployment Schedule (WIB)</label>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-2 relative" x-init="flatpickr($el.querySelector('input'), { dateFormat: 'd/m/Y', altInput: true, altFormat: 'd / m / Y', minDate: 'today', static: true })">
                                <input type="text" name="date" required placeholder="DD / MM / YYYY" class="w-full px-8 py-6 bg-slate-50 border-2 border-slate-100 rounded-[32px] font-black text-[14px]  text-slate-900 focus:border-accent focus:bg-white outline-none transition-all shadow-inner uppercase tracking-widest">
                                <i data-lucide="calendar" class="absolute right-6 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-300 pointer-events-none"></i>
                            </div>
                            <div class="col-span-1 relative" x-init="flatpickr($el.querySelector('input'), { noCalendar: true, enableTime: true, dateFormat: 'H:i', time_24hr: true, static: true })">
                                <input type="text" name="time" required placeholder="HH:MM" class="w-full px-6 py-6 bg-slate-50 border-2 border-slate-100 rounded-[32px] font-black text-[14px]  text-slate-900 focus:border-accent focus:bg-white outline-none transition-all shadow-inner uppercase tracking-widest">
                                <i data-lucide="clock" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300 pointer-events-none"></i>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]  px-4">Personnel Target Count</label>
                        <input type="number" name="target_personnel" required placeholder="100" class="w-full px-10 py-6 bg-slate-50 border-2 border-slate-100 rounded-[32px] font-black text-[14px]  text-slate-900 focus:border-accent focus:bg-white outline-none transition-all shadow-inner uppercase tracking-widest">
                    </div>
                    <div class="md:col-span-2 space-y-4">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]  px-4">Action Intel & Instructions</label>
                        <textarea name="instructions" rows="4" placeholder="Input specific field instructions for personnel..." class="w-full px-10 py-8 bg-slate-50 border-2 border-slate-100 rounded-[40px] font-medium text-lg  text-slate-900 focus:border-accent focus:bg-white outline-none transition-all shadow-inner resize-none leading-relaxed"></textarea>
                    </div>
                </div>
                        <div class="pt-6 flex gap-6">
                            <button type="button" @click="isAddingMission = false; document.body.style.overflow = 'auto'" class="px-12 py-6 border-2 border-slate-100 rounded-[32px] font-black text-[12px] uppercase tracking-widest text-slate-400 hover:bg-slate-50 transition-all ">Abort</button>
                            <button type="submit" class="flex-1 py-6 bg-accent text-white font-black text-[12px] uppercase tracking-[0.3em] rounded-[32px] hover:scale-[1.02] transition-all shadow-2xl active:scale-95 flex items-center justify-center gap-4 group">
                                <i data-lucide="rocket" class="w-6 h-6 group-hover:-translate-y-2 transition-transform"></i>
                                ACTIVATE DEPLOYMENT
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>

    <div x-show="!isAddingMission" class="grid grid-cols-1 gap-12">
        @forelse($missions as $mission)
            <!-- Action Card (Dynamic Deployment) -->
            <div class="bg-white rounded-[56px] overflow-hidden border-2 border-slate-100 card-shadow group hover:border-accent/40 transition-all flex flex-col items-stretch animate-fade-in shadow-xl">
                <div class="h-60 bg-slate-900 relative p-8 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&q=80&w=800" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-105 transition-transform duration-1000" />
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div class="flex justify-between items-start">
                            <div class="flex flex-col gap-2">
                                <span class="px-5 py-2 bg-accent text-white text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg shadow-accent/20 flex items-center gap-3 w-max">
                                    <div class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></div>
                                    Active Mission
                                </span>
                                <p class="text-[10px] font-black text-white/50 uppercase tracking-[0.4em] ">{{ $mission->created_at->diffForHumans() }} deployed</p>
                            </div>
                            <div class="flex -space-x-3">
                                @for($i=1; $i<=3; $i++)
                                    <img src="https://i.pravatar.cc/100?u={{ $mission->id + $i }}" class="w-10 h-10 rounded-full border-2 border-slate-900 shadow-xl" />
                                @endfor
                                <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-[10px] font-black text-white border-2 border-slate-900">+{{ $mission->target_personnel > 3 ? ($mission->target_personnel - 3) : 0 }}</div>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-4xl font-outfit font-black text-white  tracking-tighter uppercase mb-2">{{ $mission->objective }}</h4>
                            <div class="flex items-center gap-6 text-white/70">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="map-pin" class="w-4 h-4 text-accent"></i>
                                    <span class="text-[11px] font-black uppercase tracking-widest">{{ $mission->location }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i data-lucide="calendar" class="w-4 h-4 text-accent"></i>
                                    <span class="text-[11px] font-black uppercase tracking-widest">{{ $mission->scheduled_at->format('d/m/Y ; H:i') }} WIB</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-10 space-y-10">
                    <!-- Stats Pulse -->
                    <div class="grid grid-cols-3 gap-8">
                        <div class="bg-slate-50 p-6 rounded-[32px] border border-slate-100 group-hover:bg-white transition-all shadow-inner">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 ">Active Units</p>
                            <p class="text-3xl font-outfit font-black text-slate-900 tracking-tight ">{{ $mission->target_personnel }} <span class="text-[12px] text-accent">Personnel</span></p>
                        </div>
                        <div class="bg-slate-50 p-6 rounded-[32px] border border-slate-100 group-hover:bg-white transition-all shadow-inner">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 ">Deployment Status</p>
                            <p class="text-3xl font-outfit font-black text-success tracking-tight ">On Guard</p>
                        </div>
                        <div class="bg-slate-50 p-6 rounded-[32px] border border-slate-100 group-hover:bg-white transition-all shadow-inner">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 ">Operational Readiness</p>
                            <p class="text-3xl font-outfit font-black text-warning tracking-tight ">100% <i data-lucide="zap" class="inline w-5 h-5 ml-1"></i></p>
                        </div>
                    </div>

                    <!-- Mission Brief Snapshot -->
                    <div class="grid lg:grid-cols-3 gap-10">
                        <div class="lg:col-span-2 space-y-4">
                            <h5 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]  px-4">Tactical Intelligence Brief</h5>
                            <div class="bg-slate-50 p-8 rounded-[40px] border border-dashed border-slate-200 text-sm font-medium text-slate-600 leading-relaxed  h-full min-h-[120px]">
                                "{{ $mission->instructions ?: 'Waiting for specific field instructions from high-command...' }}"
                            </div>
                        </div>
                        <div class="lg:col-span-1 space-y-4">
                            <h5 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]  px-4">Field Mission Lead</h5>
                            <div class="bg-slate-900 p-8 rounded-[40px] text-white space-y-6 relative overflow-hidden h-full">
                                <div class="absolute top-0 right-0 w-20 h-20 bg-accent/20 rounded-full -mr-10 -mt-10 blur-xl"></div>
                                <div class="flex items-center gap-4 border-b border-white/10 pb-4">
                                    <img src="https://i.pravatar.cc/120?u=hq" class="w-12 h-12 rounded-2xl border border-white/20" />
                                    <div>
                                        <p class="text-[8px] font-black text-accent uppercase tracking-widest  leading-none mb-1">Commander</p>
                                        <p class="text-sm font-black uppercase  tracking-tighter">{{ auth()->user()->name }}</p>
                                    </div>
                                </div>
                                <button class="w-full py-4 bg-white/10 text-[9px] font-black uppercase tracking-widest rounded-2xl border border-white/10 hover:bg-accent hover:border-accent transition-all flex items-center justify-center gap-3 ">
                                    <i data-lucide="radio" class="w-4 h-4"></i>
                                    Send Tactical Comms
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <!-- EMPTY READINESS STATE -->
            <div class="bg-slate-50 border-4 border-dashed border-slate-200 rounded-[64px] p-24 flex flex-col items-center justify-center text-center space-y-8 group hover:border-accent/40 transition-all scale-100 hover:scale-[1.01]">
                <div class="w-32 h-32 bg-slate-200 rounded-[48px] flex items-center justify-center text-slate-400 group-hover:scale-110 group-hover:bg-accent/10 group-hover:text-accent transition-all duration-700">
                    <i data-lucide="shield-off" class="w-16 h-16"></i>
                </div>
                <div>
                    <h4 class="text-3xl font-outfit font-black text-slate-400 uppercase tracking-tighter ">Strategic Readiness Empty</h4>
                    <p class="text-slate-400 font-medium  mt-2">No field units currently deployed. System ready for mission activation protocol.</p>
                </div>
                <button @click="isAddingMission = true" class="px-12 py-6 bg-white border border-slate-200 rounded-[32px] text-slate-500 font-black text-[10px] uppercase tracking-widest hover:border-accent hover:text-accent transition-all  flex items-center gap-4 shadow-sm">
                    <i data-lucide="plus" class="w-5 h-5"></i>
                    Initiate First Deployment
                </button>
            </div>
        @endforelse
    </div>
</div>
