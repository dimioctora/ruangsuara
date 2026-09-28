<!-- VIEW: AKSI LAPANGAN & RELAWAN (FIELD MISSIONS) -->
<div x-show="activeTab === 'aksi'" x-transition:enter="transition ease-out duration-500" class="space-y-10">
    <!-- DEPLOY MISSION CARD -->
    <div class="bg-white p-8 md:p-12 rounded-[40px] border border-slate-100 card-shadow">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-8 pb-6 border-b border-slate-100">
            <div class="flex items-center gap-4">
                <div class="w-3 h-10 bg-accent rounded-full"></div>
                <div>
                    <h3 class="text-xl md:text-2xl font-black font-outfit text-slate-900 tracking-tight">Buka Aksi Lapangan / Panggilan Relawan</h3>
                    <p class="text-xs text-slate-400 font-medium">Koordinasikan kegiatan nyata seperti investigasi lapangan, kerja bakti, audiensi, atau pengumpulan bukti bersama warga.</p>
                </div>
            </div>
        </div>

        <form action="/suara-manage/{{ $suara->id }}/deploy-mission" method="POST" class="space-y-6">
            @csrf
            <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Nama Aksi / Kegiatan</label>
                    <input type="text" name="objective" required placeholder="Contoh: Kerja Bakti & Pembersihan Saluran Air" 
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/5 outline-none transition-all text-sm">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Lokasi Titik Kumpul / Aksi</label>
                    <input type="text" name="location" required placeholder="Contoh: Balai Warga RW 05 / Depan Kantor Kelurahan" 
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/5 outline-none transition-all text-sm">
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Tanggal Kegiatan</label>
                    <input type="text" name="date" required placeholder="DD/MM/YYYY" id="missionDatePicker" value="{{ date('d/m/Y') }}"
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/5 outline-none transition-all text-sm">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Waktu / Jam</label>
                    <input type="text" name="time" required placeholder="HH:MM" value="09:00"
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/5 outline-none transition-all text-sm">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Target Jumlah Relawan</label>
                    <input type="number" name="target_personnel" min="1" value="10" required
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/5 outline-none transition-all text-sm">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Instruksi & Perlengkapan yang Diperlukan</label>
                <textarea name="instructions" rows="3" placeholder="Contoh: Membawa sarung tangan, kantong sampah, dan smartphone untuk dokumentasi..." 
                    class="w-full p-5 bg-slate-50 border border-slate-200 rounded-3xl font-medium text-slate-900 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/5 outline-none transition-all text-sm leading-relaxed"></textarea>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="submit" class="px-8 py-4 bg-accent text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-xl shadow-accent/20 hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-2">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    Buka Panggilan Aksi
                </button>
            </div>
        </form>
    </div>

    <!-- ACTIVE MISSIONS LIST -->
    <div class="bg-white p-8 md:p-12 rounded-[40px] border border-slate-100 card-shadow space-y-6">
        <div class="flex items-center justify-between pb-6 border-b border-slate-100">
            <h4 class="text-xl font-bold font-outfit text-slate-900 flex items-center gap-2">
                <i data-lucide="crosshair" class="w-5 h-5 text-accent"></i>
                Daftar Aksi Lapangan ({{ $missions->count() }})
            </h4>
        </div>

        @if($missions->isEmpty())
            <div class="text-center py-12 px-6 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                <div class="w-14 h-14 rounded-2xl bg-white border border-slate-100 shadow-sm flex items-center justify-center mx-auto mb-3 text-slate-400">
                    <i data-lucide="users" class="w-7 h-7"></i>
                </div>
                <h5 class="text-sm font-bold text-slate-700 mb-1">Belum Ada Aksi Lapangan Dibuat</h5>
                <p class="text-xs text-slate-400">Buat panggilan relawan atau rencana aksi nyata pertama untuk menggerakkan masyarakat.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($missions as $m)
                    <div class="p-6 bg-slate-50/70 border border-slate-100 rounded-3xl flex flex-wrap items-center justify-between gap-6 hover:border-slate-200 transition-all">
                        <div class="space-y-2 flex-1 min-w-[280px]">
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-xl text-[10px] font-black uppercase">
                                    {{ $m->status == 'active' ? 'Aktif' : 'Selesai' }}
                                </span>
                                <span class="text-xs font-bold text-slate-500 flex items-center gap-1">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                                    {{ $m->scheduled_at ? $m->scheduled_at->format('d M Y, H:i') : '-' }} WIB
                                </span>
                            </div>
                            <h5 class="text-base font-bold text-slate-900 font-outfit">{{ $m->objective }}</h5>
                            <p class="text-xs text-slate-500 flex items-center gap-1.5">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-accent shrink-0"></i>
                                {{ $m->location }}
                            </p>
                            @if($m->instructions)
                                <p class="text-xs text-slate-600 bg-white p-3 rounded-xl border border-slate-100 mt-2">{{ $m->instructions }}</p>
                            @endif
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="text-center px-4 py-2 bg-white rounded-2xl border border-slate-100">
                                <p class="text-[9px] font-bold text-slate-400 uppercase">Target</p>
                                <p class="text-sm font-black text-slate-900">{{ $m->target_personnel }} Relawan</p>
                            </div>

                            <form action="/suara-manage/{{ $suara->id }}/delete-mission/{{ $m->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aksi ini?')" class="inline">
                                @csrf
                                <button type="submit" class="p-2.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all" title="Hapus Aksi">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
