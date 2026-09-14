<!-- VIEW: ADMIN -->
<div x-show="activeTab === 'admin'" x-transition:enter="transition ease-out duration-500" class="space-y-10">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-2 h-8 bg-heat rounded-full"></div>
            <h2 class="text-4xl font-outfit font-black text-slate-900  uppercase tracking-tighter">Security Center</h2>
        </div>
    </div>
    <div class="bg-white p-10 rounded-[48px] border border-slate-100 card-shadow">
        <div class="p-8 bg-heat/5 rounded-[32px] border border-heat/10">
            <h4 class="text-lg font-black text-heat mb-2 uppercase  tracking-tighter">DANGER ZONE</h4>
            <p class="text-xs text-slate-500 mb-6 ">Aksi berikut bersifat permanen dan tidak dapat dibatalkan.</p>
            <div class="flex gap-4">
                <button class="px-8 py-4 bg-heat text-white rounded-2xl text-[10px] font-black uppercase tracking-widest">Delete Mission</button>
                <button class="px-8 py-4 bg-slate-100 text-slate-400 rounded-2xl text-[10px] font-black uppercase tracking-widest">Archive Command</button>
            </div>
        </div>
    </div>
</div>
