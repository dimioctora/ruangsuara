<!-- VIEW: TUGAS -->
<div x-show="activeTab === 'tugas'" x-transition:enter="transition ease-out duration-500" class="space-y-10">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-2 h-8 bg-accent rounded-full"></div>
            <h2 class="text-4xl font-outfit font-black text-slate-900  uppercase tracking-tighter">Tactical Assignments</h2>
        </div>
        <button class="px-8 py-4 bg-primary text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-primary/20">Delegate Task</button>
    </div>
    <div class="grid gap-6">
        <div class="bg-white p-8 rounded-[40px] border border-slate-100 card-shadow flex items-center justify-between group hover:border-accent/30 transition-all">
            <div class="flex items-center gap-6">
                <div class="w-14 h-14 rounded-2xl bg-success/10 text-success flex items-center justify-center shadow-inner"><i data-lucide="check-circle" class="w-6 h-6"></i></div>
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 leading-none">Verification</p>
                    <h4 class="text-lg font-outfit font-black text-slate-900  uppercase">Validate Photo Evidence: Cileungsi</h4>
                </div>
            </div>
            <div class="flex items-center gap-10">
                <div class="text-right">
                    <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-1">Assigned</p>
                    <p class="text-xs font-bold text-slate-900">Sara Wijaya</p>
                </div>
                <span class="px-5 py-2 rounded-full bg-success/5 border border-success/20 text-success text-[10px] font-black uppercase tracking-widest">Completed</span>
            </div>
        </div>
        <div class="bg-white p-8 rounded-[40px] border border-slate-100 card-shadow flex items-center justify-between group border-l-4 border-l-heat">
            <div class="flex items-center gap-6">
                <div class="w-14 h-14 rounded-2xl bg-heat/10 text-heat flex items-center justify-center shadow-inner"><i data-lucide="alert-octagon" class="w-6 h-6"></i></div>
                <div>
                    <p class="text-[9px] font-black text-heat uppercase tracking-widest mb-1 leading-none">Logistics</p>
                    <h4 class="text-lg font-outfit font-black text-slate-900  uppercase">Urgent: Equipment Procurement</h4>
                </div>
            </div>
            <div class="flex items-center gap-10">
                <div class="text-right">
                    <p class="text-[9px] font-black text-heat uppercase tracking-widest mb-1 ">CRITICAL</p>
                    <p class="text-xs font-bold text-slate-400">NOT ASSIGNED</p>
                </div>
                <button class="px-6 py-2 rounded-full bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest">Assign Self</button>
            </div>
        </div>
    </div>
</div>
