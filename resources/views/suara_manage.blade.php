<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MISSION CONTROL: {{ $suara->title }} — Suara OS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0F172A',
                        accent: '#2563EB',
                        success: '#10B981',
                        warning: '#F59E0B',
                        heat: '#F43F5E',
                        tactical: '#1E293B',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        outfit: ['Outfit', 'sans-serif'],
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    }
                }
            }
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #CBD5E1; }
        
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
        .font-outfit { font-family: 'Outfit', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .card-shadow { box-shadow: 0 10px 40px -10px rgba(15, 23, 42, 0.05); }
        .sidebar-item-active { background: #1E293B !important; color: white !important; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.1); }
        
        .timeline-step-active { background: var(--accent); border-color: var(--accent); color: white; }
        .timeline-step-done { background: var(--success); border-color: var(--success); color: white; }

        .mission-bg {
            background-image: radial-gradient(circle at 2px 2px, #E2E8F0 1px, transparent 0);
            background-size: 32px 32px;
        }

        @keyframes scan {
            0% { transform: translateY(-100%); }
            100% { transform: translateY(100%); }
        }
        .scanline {
            width: 100%;
            height: 2px;
            background: linear-gradient(to bottom, transparent, rgba(37, 99, 235, 0.2), transparent);
            position: absolute;
            animation: scan 4s linear infinite;
        }
    </style>
</head>
<body class="text-slate-900 selection:bg-accent/10 selection:text-accent font-sans mission-bg" x-data="{ activeTab: 'issue', isEditing: false, isPhaseEditing: false, isAddingMission: false }">

    <!-- Header Section: Mission Briefing Style -->
    <header class="sticky top-0 z-[100] bg-primary text-white border-b border-white/5 shadow-2xl overflow-hidden">
        <div class="scanline"></div>
        <div class="container mx-auto px-6 py-4 flex items-center justify-between relative z-10">
            <div class="flex items-center gap-6">
                <a href="/dashboard" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/5 text-white/40 hover:text-white hover:bg-white/10 transition-all border border-white/10 group">
                    <i data-lucide="chevron-left" class="w-5 h-5 group-hover:-translate-x-1 transition-transform"></i>
                </a>
                <div class="h-10 w-px bg-white/10"></div>
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <span class="px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-widest bg-accent text-white">Live Operations</span>
                        <span class="text-[10px] text-white/40 font-bold uppercase tracking-widest">UID: SRA-{{ str_pad($suara->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <h1 class="text-xl font-outfit font-black text-white leading-none tracking-tight">{{ $suara->title }}</h1>
                </div>
            </div>
            
            <div class="flex items-center gap-6">
                <div class="hidden md:flex items-center gap-10 bg-white/5 px-8 py-2 rounded-2xl border border-white/5">
                    <div class="text-center">
                        <p class="text-[9px] font-black text-white/30 uppercase tracking-[0.2em] mb-1">Supporters</p>
                        <p class="text-xl font-outfit font-black text-white ">1,240 <span class="text-[10px] text-success font-bold  ml-1">+12h</span></p>
                    </div>
                    <div class="text-center">
                        <p class="text-[9px] font-black text-white/30 uppercase tracking-[0.2em] mb-1">Tactical Health</p>
                        <p class="text-xl font-outfit font-black text-success ">STABLE</p>
                    </div>
                    <div class="text-center">
                        <p class="text-[9px] font-black text-white/30 uppercase tracking-[0.2em] mb-1">Resources</p>
                        <p class="text-xl font-outfit font-black {{ $suara->is_fundraising ? 'text-accent' : 'text-white/20' }}">
                            {{ $suara->is_fundraising ? 'Rp 4.5M' : 'N/A' }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-white/60 hover:text-white hover:bg-white/10 transition-all group">
                        <i data-lucide="share-2" class="w-4 h-4 group-hover:scale-110"></i>
                    </button>
                    <button class="px-6 py-2.5 bg-white text-primary font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-accent hover:text-white transition-all shadow-xl active:scale-95">Edit Briefing</button>
                    <div class="w-10 h-10 rounded-full border-2 border-accent p-0.5 overflow-hidden">
                        <img src="https://i.pravatar.cc/100?u={{ $user->id }}" class="w-full h-full rounded-full object-cover" />
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-6 py-8">
        <!-- Top Tactical Status Bar -->
        <div class="flex items-center justify-between mb-10 py-3 px-6 bg-slate-100 rounded-2xl border border-slate-200">
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-success animate-pulse"></div>
                    <span class="text-[9px] font-black text-success uppercase tracking-[0.3em]">System Online</span>
                </div>
                <div class="h-4 w-[1px] bg-slate-300"></div>
                <div class="flex items-center gap-3">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Mission ID:</span>
                    <span class="text-[10px] font-mono font-bold text-accent">#{{ str_pad($suara->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em]  leading-none">Encrypted Command Channel</span>
                <div class="flex gap-1">
                    <div class="w-1 h-3 bg-accent animate-[bounce_1.5s_infinite]"></div>
                    <div class="w-1 h-3 bg-accent animate-[bounce_1.5s_infinite_0.2s]"></div>
                    <div class="w-1 h-3 bg-accent animate-[bounce_1.5s_infinite_0.4s]"></div>
                </div>
            </div>
        </div>
        
        <!-- 1. FIRE COMMAND PANEL (URGENT ACTIONS) -->
        <section class="mb-10 animate-fade-in">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-2 h-6 bg-heat rounded-full"></div>
                <h3 class="text-sm font-black uppercase tracking-[0.3em] text-slate-900 ">Priority Command Briefing</h3>
                <div class="flex-1 h-px bg-slate-200"></div>
                <span class="text-[10px] font-bold text-slate-400">3 ACTIVE ALERTS</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Alert Card -->
                <div class="bg-white p-6 rounded-[32px] border border-slate-100 card-shadow relative overflow-hidden group hover:border-heat/30 transition-all">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-heat/5 rounded-full -mr-8 -mt-8 group-hover:scale-150 transition-transform"></div>
                    <div class="relative z-10 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="w-10 h-10 rounded-xl bg-heat/10 text-heat flex items-center justify-center animate-pulse-slow">
                                <i data-lucide="users" class="w-5 h-5"></i>
                            </div>
                            <span class="px-2 py-0.5 rounded bg-heat text-white text-[8px] font-black uppercase tracking-widest">Critical</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 leading-none">Manpower</p>
                            <p class="text-sm font-black text-slate-900 leading-tight ">20 participants needed for upcoming action</p>
                        </div>
                        <button class="w-full py-3 bg-slate-900 text-white text-[9px] font-black uppercase tracking-widest rounded-xl hover:bg-heat transition-all">Deploy Call</button>
                    </div>
                </div>

                <!-- Alert Card -->
                <div class="bg-white p-6 rounded-[32px] border border-slate-100 card-shadow relative overflow-hidden group hover:border-warning/30 transition-all">
                    <div class="relative z-10 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="w-10 h-10 rounded-xl bg-warning/10 text-warning flex items-center justify-center">
                                <i data-lucide="message-square" class="w-5 h-5"></i>
                            </div>
                            <span class="px-2 py-0.5 rounded bg-warning text-white text-[8px] font-black uppercase tracking-widest">Warning</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 leading-none">Moderation</p>
                            <p class="text-sm font-black text-slate-900 leading-tight ">12 unverified public aspirations flagged</p>
                        </div>
                        <button class="w-full py-3 bg-slate-50 text-slate-900 text-[9px] font-black uppercase tracking-widest rounded-xl border border-slate-100 hover:bg-warning hover:text-white transition-all">Verify Now</button>
                    </div>
                </div>

                <!-- Alert Card -->
                <div class="bg-slate-900 p-6 rounded-[32px] border border-white/5 card-shadow relative overflow-hidden group">
                    <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-white/5 rounded-full"></div>
                    <div class="relative z-10 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="w-10 h-10 rounded-xl bg-white/10 text-white flex items-center justify-center">
                                <i data-lucide="calendar" class="w-5 h-5"></i>
                            </div>
                            <span class="px-2 py-0.5 rounded bg-white text-slate-900 text-[8px] font-black uppercase tracking-widest">T-Minus</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-white/30 uppercase tracking-widest mb-1 leading-none">Countdown</p>
                            <p class="text-sm font-black text-white leading-tight ">Next action: Kerja Bakti Massal (2 Days)</p>
                        </div>
                        <button class="w-full py-3 bg-white/10 text-white text-[9px] font-black uppercase tracking-widest rounded-xl hover:bg-white hover:text-slate-900 transition-all">Operational Log</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Workspace Grid (30/70 split) -->
        <div class="space-y-8">
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="bg-success/10 border-2 border-success/30 p-8 rounded-[40px] flex items-center justify-between gap-6 card-shadow animate-pulse-slow">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 bg-success text-white rounded-[24px] flex items-center justify-center shadow-lg shadow-success/20">
                            <i data-lucide="check-circle" class="w-8 h-8"></i>
                        </div>
                        <div>
                            <h5 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em]  mb-1">Command Confirmed</h5>
                            <p class="text-xl font-outfit font-black text-slate-900  tracking-tight">{{ session('success') }}</p>
                        </div>
                    </div>
                    <button @click="show = false" class="w-12 h-12 bg-success/5 border border-success/10 rounded-2xl flex items-center justify-center hover:bg-success/10 transition-all">
                        <i data-lucide="x" class="w-5 h-5 text-success"></i>
                    </button>
                </div>
            @endif

            <div class="grid lg:grid-cols-10 gap-10">
            
            <!-- LEFT STRATEGIC COLUMN (30%) -->
            @include('partials.suara_manage._sidebar')


            <!-- RIGHT OPERATIONAL COLUMN (70%) -->
            <div class="lg:col-span-7 space-y-10 order-1 lg:order-2">

                <!-- ISSUE TIMELINE PHASE (WIDE HORIZONTAL) -->
                @include('partials.suara_manage._mission_progress')


                <!-- OPERATIONAL VIEWS -->
                <div class="space-y-10 pt-10">
                    @include('partials.suara_manage._issue')
                    @include('partials.suara_manage._field_mission')
                    @include('partials.suara_manage._tasks')
                    @include('partials.suara_manage._finance')
                    @include('partials.suara_manage._admin')
                </div>

            </div>

        </div> <!-- Close Main Grid -->
    </main>

    <!-- Role-Based FAB (Operational Zap) -->
    <button class="fixed bottom-10 right-10 w-20 h-20 bg-tactical text-white rounded-[32px] shadow-2xl shadow-primary/40 flex items-center justify-center hover:scale-110 active:scale-95 transition-all z-[200] group overflow-hidden">
        <div class="scanline opacity-20"></div>
        <div class="absolute -top-32 right-0 scale-0 group-hover:scale-100 transition-all origin-bottom flex flex-col items-end gap-3 pointer-events-none group-hover:pointer-events-auto pb-4">
             <div class="flex items-center gap-3">
                 <span class="px-6 py-3 bg-white text-slate-900 border border-slate-100 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-2xl whitespace-nowrap">Broadcast Briefing</span>
                 <div class="w-14 h-14 bg-white border border-slate-100 rounded-2xl flex items-center justify-center text-primary shadow-xl"><i data-lucide="megaphone" class="w-5 h-5"></i></div>
             </div>
             <div class="flex items-center gap-3">
                 <span class="px-6 py-3 bg-white text-slate-900 border border-slate-100 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-2xl whitespace-nowrap">Emergency Alert</span>
                 <div class="w-14 h-14 bg-heat text-white rounded-2xl flex items-center justify-center shadow-xl"><i data-lucide="alert-octagon" class="w-5 h-5"></i></div>
             </div>
        </div>
        <i data-lucide="zap" class="w-10 h-10 relative z-10 shadow-glow"></i>
    </button>

    <script>
        lucide.createIcons();
        
        // Custom animation on scroll trigger or load
        document.addEventListener('DOMContentLoaded', () => {
            const progressBars = document.querySelectorAll('.transition-all');
            progressBars.forEach(bar => {
                // Trigger animation
            });
        });
    </script>
</body>
</html>
