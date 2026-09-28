<!-- VIEW: PEMBARUAN & KRONOLOGI ISU (ISSUE UPDATES) -->
<div x-show="activeTab === 'updates'" x-transition:enter="transition ease-out duration-500" class="space-y-10">
    <!-- POST UPDATE FORM CARD -->
    <div class="bg-white p-8 md:p-12 rounded-[40px] border border-slate-100 card-shadow">
        <div class="flex items-center justify-between mb-8 pb-6 border-b border-slate-100">
            <div class="flex items-center gap-4">
                <div class="w-3 h-10 bg-accent rounded-full"></div>
                <div>
                    <h3 class="text-xl md:text-2xl font-black font-outfit text-slate-900 tracking-tight">Publikasikan Pembaruan Isu</h3>
                    <p class="text-xs text-slate-400 font-medium">Informasi ini akan langsung ditampilkan di halaman publik untuk para pendukung dan masyarakat.</p>
                </div>
            </div>
            <span class="hidden sm:inline-flex px-4 py-2 bg-accent/10 text-accent rounded-xl text-[10px] font-black uppercase tracking-widest">
                Official Creator Update
            </span>
        </div>

        <form id="postUpdateForm" action="/suara-manage/{{ $suara->id }}/post-update" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="grid md:grid-cols-3 gap-6">
                <div class="md:col-span-2 space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Judul Pembaruan / Milestone</label>
                    <div class="relative group">
                        <i data-lucide="bookmark" class="absolute left-5 top-4 w-5 h-5 text-slate-300 group-focus-within:text-accent transition-colors"></i>
                        <input type="text" name="title" required placeholder="Contoh: Audiensi dengan Pihak Terkait / Bukti Tambahan Ditemukan" 
                            class="w-full pl-14 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-800 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/5 outline-none transition-all text-sm">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Kategori Tahapan</label>
                    <select name="stage" class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-800 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/5 outline-none transition-all text-sm">
                        <option value="1" {{ ($suara->current_stage ?? 1) == 1 ? 'selected' : '' }}>Tahap 1: Issue Dibuat</option>
                        <option value="2" {{ ($suara->current_stage ?? 1) == 2 ? 'selected' : '' }}>Tahap 2: Penggalangan Aspirasi</option>
                        <option value="3" {{ ($suara->current_stage ?? 1) == 3 ? 'selected' : '' }}>Tahap 3: Pembaruan & Bukti</option>
                        <option value="4" {{ ($suara->current_stage ?? 1) == 4 ? 'selected' : '' }}>Tahap 4: Kajian & Keputusan</option>
                        <option value="5" {{ ($suara->current_stage ?? 1) == 5 ? 'selected' : '' }}>Tahap 5: Aksi Nyata Selesai</option>
                    </select>
                </div>
            </div>

            <!-- WYSIWYG EDITOR FOR UPDATE CONTENT -->
            <div class="space-y-2">
                <div class="flex items-center justify-between ml-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Rincian Perkembangan / Kronologi Terbaru (WYSIWYG)</label>
                    <span class="text-[10px] text-slate-400 font-bold">Gunakan toolbar untuk membuat paragraf & poin-poin</span>
                </div>
                <div id="updateContentEditor"></div>
                <input type="hidden" name="content" id="updateContentInput">
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Lampiran Foto Bukti / Dokumen (Opsional)</label>
                    <div class="relative">
                        <input type="file" name="image" accept="image/*" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl font-medium text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-accent file:text-white hover:file:bg-accent/90 cursor-pointer">
                    </div>
                    <p class="text-[10px] text-slate-400 ml-1">Format: JPG, PNG, WEBP (Maks. 5MB)</p>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Tautan Dokumen / Berita / Drive (Opsional)</label>
                    <div class="relative group">
                        <i data-lucide="link-2" class="absolute left-5 top-3.5 w-5 h-5 text-slate-300 group-focus-within:text-accent transition-colors"></i>
                        <input type="url" name="reference_link" placeholder="https://..." 
                            class="w-full pl-14 pr-6 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl font-medium text-slate-800 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/5 outline-none transition-all text-sm">
                    </div>
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="px-8 py-4 bg-accent text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-xl shadow-accent/20 hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-2">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    Publikasikan Pembaruan
                </button>
            </div>
        </form>
    </div>

    <!-- PUBLISHED UPDATES TIMELINE -->
    <div class="bg-white p-8 md:p-12 rounded-[40px] border border-slate-100 card-shadow space-y-8">
        <div class="flex items-center justify-between pb-6 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <i data-lucide="history" class="w-6 h-6 text-accent"></i>
                <h4 class="text-xl font-bold font-outfit text-slate-900">Riwayat Pembaruan Terpublikasi ({{ $updates->count() }})</h4>
            </div>
            <a href="/suara-detail/{{ $suara->id }}" target="_blank" class="text-xs font-bold text-accent hover:underline flex items-center gap-1.5">
                Lihat di Halaman Publik
                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
            </a>
        </div>

        @if($updates->isEmpty())
            <div class="text-center py-16 px-6 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                <div class="w-16 h-16 rounded-2xl bg-white border border-slate-100 shadow-sm flex items-center justify-center mx-auto mb-4 text-slate-400">
                    <i data-lucide="file-plus" class="w-8 h-8"></i>
                </div>
                <h5 class="text-base font-bold text-slate-700 mb-1">Belum Ada Pembaruan Isu</h5>
                <p class="text-xs text-slate-400 max-w-md mx-auto">Gunakan formulir di atas untuk mengabarkan kemajuan, temuan baru, atau respon instansi terkait kepada masyarakat.</p>
            </div>
        @else
            <div class="space-y-6">
                @php
                    $stageLabels = [
                        1 => 'Issue Dibuat',
                        2 => 'Penggalangan Aspirasi',
                        3 => 'Pembaruan & Bukti',
                        4 => 'Kajian & Keputusan',
                        5 => 'Aksi Nyata Selesai'
                    ];
                @endphp
                @foreach($updates as $update)
                    <div class="p-6 md:p-8 bg-slate-50/70 border border-slate-100 rounded-3xl relative hover:border-slate-200 transition-all space-y-4">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 bg-accent text-white rounded-xl text-[10px] font-black uppercase tracking-wider">
                                    {{ $stageLabels[$update->stage ?? 3] ?? 'Pembaruan' }}
                                </span>
                                <span class="text-xs font-bold text-slate-400 flex items-center gap-1.5">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                    {{ $update->created_at->format('d M Y, H:i') }} WIB
                                </span>
                            </div>

                            <form action="/suara-manage/{{ $suara->id }}/delete-update/{{ $update->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pembaruan ini?')" class="inline">
                                @csrf
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all" title="Hapus Pembaruan">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>

                        <h5 class="text-lg font-bold text-slate-900 font-outfit">{{ $update->title }}</h5>
                        <div class="text-slate-700 text-sm leading-relaxed prose prose-slate max-w-none prose-p:mb-2 prose-ul:list-disc prose-ul:pl-5 prose-ol:list-decimal prose-ol:pl-5">
                            @if(strip_tags($update->content) !== $update->content)
                                {!! $update->content !!}
                            @else
                                {!! nl2br(e($update->content)) !!}
                            @endif
                        </div>

                        @if($update->image)
                            <div class="mt-4 rounded-2xl overflow-hidden border border-slate-200/80 max-w-xl">
                                <img src="{{ $update->image_url }}" alt="{{ $update->title }}" class="w-full h-auto object-cover max-h-96">
                            </div>
                        @endif

                        @if($update->reference_link)
                            <div class="pt-2">
                                <a href="{{ $update->reference_link }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-accent hover:bg-slate-50 transition-all shadow-sm">
                                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                    Dokumen / Tautan Pendukung
                                </a>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
