<!-- VIEW: SUARA ISSUE (DETAIL & EDIT) -->
<div x-show="activeTab === 'issue'" x-transition:enter="transition ease-out duration-500" class="space-y-10">
    <div class="bg-white p-8 md:p-12 rounded-[40px] border border-slate-100 card-shadow">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-10 pb-6 border-b border-slate-100">
            <div class="flex items-center gap-4">
                <div class="w-3 h-10 bg-accent rounded-full"></div>
                <div>
                    <h3 class="text-xl md:text-2xl font-black font-outfit text-slate-900 tracking-tight" x-text="isEditing ? 'Ubah Informasi Isu' : 'Detail Informasi Isu'"></h3>
                    <p class="text-xs text-slate-400 font-medium">Kelola narasi, kategori, dan data pendukung laporan ini.</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <button @click="isEditing = !isEditing" 
                    class="px-6 py-3 rounded-2xl border border-slate-200 text-slate-700 text-xs font-bold hover:border-accent hover:text-accent transition-all shadow-sm active:scale-95 flex items-center gap-2 bg-white"
                    :class="isEditing ? 'border-amber-500 text-amber-600 bg-amber-50/50' : ''">
                    <i data-lucide="edit-3" class="w-4 h-4" x-show="!isEditing"></i>
                    <i data-lucide="x" class="w-4 h-4" x-show="isEditing"></i>
                    <span x-text="isEditing ? 'Batalkan Edit' : 'Edit Informasi Isu'"></span>
                </button>
            </div>
        </div>

        <!-- LIVE VIEW MODE -->
        <div x-show="!isEditing" class="space-y-10 animate-fade-in">
            <div class="grid md:grid-cols-3 gap-8">
                <div class="md:col-span-2 space-y-3">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Judul Suara / Isu</p>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-outfit font-black text-slate-900 leading-snug">{{ $suara->title }}</h2>
                </div>

                <div class="space-y-3">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Kategori & Lokasi</p>
                    <div class="space-y-2">
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-accent/10 text-accent font-bold rounded-xl text-xs">
                            <i data-lucide="tag" class="w-3.5 h-3.5"></i>
                            {{ $suara->category }}
                        </div>
                        <div class="flex items-center gap-2 text-slate-600 text-xs font-bold">
                            <i data-lucide="map-pin" class="w-4 h-4 text-slate-400"></i>
                            {{ $suara->location }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Box -->
            <div class="p-8 bg-slate-50 rounded-3xl border border-slate-100 space-y-4">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-2">
                    <i data-lucide="align-left" class="w-4 h-4 text-accent"></i>
                    Deskripsi Lengkap
                </p>
                <p class="text-base text-slate-700 leading-relaxed whitespace-pre-line font-medium">{{ $suara->description }}</p>
            </div>

            <!-- Expected Impact & Reference Link -->
            <div class="grid md:grid-cols-2 gap-6">
                @if($suara->expected_impact)
                    <div class="p-6 bg-emerald-50/60 rounded-3xl border border-emerald-100 space-y-2">
                        <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest flex items-center gap-2">
                            <i data-lucide="target" class="w-4 h-4"></i>
                            Dampak yang Diharapkan
                        </p>
                        <p class="text-sm font-medium text-slate-800">{{ $suara->expected_impact }}</p>
                    </div>
                @endif

                @if($suara->reference_link)
                    <div class="p-6 bg-blue-50/60 rounded-3xl border border-blue-100 space-y-2">
                        <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest flex items-center gap-2">
                            <i data-lucide="external-link" class="w-4 h-4"></i>
                            Tautan Bukti / Rujukan
                        </p>
                        <a href="{{ $suara->reference_link }}" target="_blank" class="text-sm font-bold text-accent hover:underline truncate block">
                            {{ $suara->reference_link }}
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- EDIT FORM MODE -->
        <div x-show="isEditing" x-cloak class="animate-fade-in">
            <form action="/suara-manage/{{ $suara->id }}/update-issue" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Judul Isu</label>
                        <input type="text" name="title" value="{{ old('title', $suara->title) }}" required
                            class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl font-bold text-sm text-slate-900 focus:border-accent focus:bg-white focus:ring-4 focus:ring-accent/5 outline-none transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Kategori</label>
                        <select name="category" required
                            class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl font-bold text-sm text-slate-900 focus:border-accent focus:bg-white focus:ring-4 focus:ring-accent/5 outline-none transition-all">
                            @foreach(['Infrastruktur & Jalan', 'Lingkungan Hidup', 'Kesehatan', 'Pendidikan', 'Pelayanan Publik', 'Transparansi & Korupsi', 'Keamanan & Ketertiban', 'Lainnya'] as $cat)
                                <option value="{{ $cat }}" {{ (old('category', $suara->category) == $cat) ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Lokasi Kejadian</label>
                        <input type="text" name="location" value="{{ old('location', $suara->location) }}" required
                            class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl font-bold text-sm text-slate-900 focus:border-accent focus:bg-white focus:ring-4 focus:ring-accent/5 outline-none transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Tautan Referensi / Berita (Opsional)</label>
                        <input type="url" name="reference_link" value="{{ old('reference_link', $suara->reference_link) }}" placeholder="https://..."
                            class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl font-medium text-sm text-slate-900 focus:border-accent focus:bg-white focus:ring-4 focus:ring-accent/5 outline-none transition-all">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Deskripsi Lengkap Masalah</label>
                    <textarea name="description" rows="6" required
                        class="w-full p-6 bg-slate-50 border border-slate-200 rounded-3xl font-medium text-sm text-slate-900 focus:border-accent focus:bg-white focus:ring-4 focus:ring-accent/5 outline-none transition-all leading-relaxed">{{ old('description', $suara->description) }}</textarea>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Dampak yang Diharapkan (Opsional)</label>
                    <input type="text" name="expected_impact" value="{{ old('expected_impact', $suara->expected_impact) }}" placeholder="Contoh: Perbaikan jalan selesai dalam 30 hari..."
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl font-medium text-sm text-slate-900 focus:border-accent focus:bg-white focus:ring-4 focus:ring-accent/5 outline-none transition-all">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Ganti Foto Utama Isu (Opsional)</label>
                    <input type="file" name="image" accept="image/*" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl font-medium text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-accent file:text-white hover:file:bg-accent/90 cursor-pointer">
                </div>

                <div class="pt-4 flex items-center justify-end gap-4">
                    <button type="button" @click="isEditing = false" class="px-8 py-4 bg-slate-100 text-slate-600 font-bold text-xs uppercase tracking-wider rounded-2xl hover:bg-slate-200 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-8 py-4 bg-accent text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-xl shadow-accent/20 hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-2">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
