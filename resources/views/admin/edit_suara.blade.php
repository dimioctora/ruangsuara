@extends('admin.layout')

@section('content')
<div class="max-w-none mx-auto animate-fade-in px-4 md:px-10">
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ route('admin.suara') }}" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-slate-400 hover:text-accent transition-all border border-slate-100 shadow-sm">
            <i data-lucide="arrow-left" class="w-6 h-6"></i>
        </a>
        <div>
            <h2 class="text-3xl font-outfit font-black text-slate-900 tracking-tight uppercase ">Edit <span class="text-accent underline">Suara</span></h2>
            <p class="text-sm text-slate-400 font-bold uppercase tracking-widest mt-1">Sistem Koreksi Data Pusat</p>
        </div>
    </div>

    @if ($errors->any())
    <div class="mb-8 p-6 bg-red-50 border border-red-100 rounded-3xl animate-fade-in shadow-sm shadow-red-900/5">
        <div class="flex items-center gap-3 mb-4 text-red-600 font-black uppercase text-[10px] tracking-widest">
            <i data-lucide="alert-circle" class="w-4 h-4"></i>
            Ops! Ada kesalahan input:
        </div>
        <ul class="space-y-1">
            @foreach ($errors->all() as $error)
                <li class="text-sm text-red-500 font-medium list-disc ml-6">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.suara.update', $suara->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        
        <!-- Main Form Card -->
        <div class="bg-white rounded-[40px] p-12 shadow-2xl border border-slate-50 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-accent/5 blur-[100px] -z-0"></div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 relative z-10">
                <!-- Left Side: Basic Info -->
                <div class="space-y-8">
                    <div class="group">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block px-2">Judul Laporan</label>
                        <input type="text" name="title" value="{{ $suara->title }}" required
                               class="w-full px-8 py-5 bg-slate-50 border-2 border-transparent focus:border-accent/10 focus:bg-white rounded-3xl outline-none transition-all font-bold text-slate-800">
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block px-2">Kategori</label>
                            <select name="category" required class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent focus:border-accent/10 focus:bg-white rounded-3xl outline-none transition-all font-bold text-slate-800 appearance-none">
                                <option value="Social" {{ $suara->category == 'Social' ? 'selected' : '' }}>Social</option>
                                <option value="Infrastruktur" {{ $suara->category == 'Infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                                <option value="Economy" {{ $suara->category == 'Economy' ? 'selected' : '' }}>Economy</option>
                                <option value="Legal" {{ $suara->category == 'Legal' ? 'selected' : '' }}>Legal</option>
                                <option value="Environment" {{ $suara->category == 'Environment' ? 'selected' : '' }}>Environment</option>
                                <option value="Policy" {{ $suara->category == 'Policy' ? 'selected' : '' }}>Policy</option>
                                <option value="Finance" {{ $suara->category == 'Finance' ? 'selected' : '' }}>Finance</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block px-2">Lokasi</label>
                            <input type="text" name="location" value="{{ $suara->location }}" required
                                   class="w-full px-8 py-5 bg-slate-50 border-2 border-transparent focus:border-accent/10 focus:bg-white rounded-3xl outline-none transition-all font-bold text-slate-800">
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block px-2">Deskripsi Isu</label>
                        <textarea name="description" rows="6" required
                                  class="w-full px-8 py-5 bg-slate-50 border-2 border-transparent focus:border-accent/10 focus:bg-white rounded-3xl outline-none transition-all font-medium text-slate-600 leading-relaxed ">{{ $suara->description }}</textarea>
                    </div>
                </div>

                <!-- Right Side: Stats & Media -->
                <div class="space-y-8">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block px-2">Cover Image (Update)</label>
                        <div x-data="{ photoName: null, photoPreview: null }" class="relative group h-64 bg-slate-50 rounded-[32px] overflow-hidden border-2 border-dashed border-slate-200 hover:border-accent transition-all">
                            <!-- Background Image -->
                            <div class="absolute inset-0">
                                @if($suara->image)
                                <img src="{{ Str::startsWith($suara->image, 'http') ? $suara->image : asset('storage/' . $suara->image) }}" 
                                     class="w-full h-full object-cover" x-show="!photoPreview">
                                @endif
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-full h-full object-cover animate-fade-in">
                                </template>
                            </div>

                            <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center text-white p-6 text-center">
                                <i data-lucide="camera" class="w-10 h-10 mb-2"></i>
                                <span class="text-[10px] font-black uppercase tracking-widest" x-text="photoName ? 'File Terpilih: ' + photoName : 'Klik untuk ubah foto'"></span>
                                <span class="text-[8px] opacity-60 mt-1 uppercase tracking-widest">Format: JPG, PNG, WEBP (Max 5MB)</span>
                            </div>
                            
                            <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                   @change="
                                        photoName = $event.target.files[0].name;
                                        const reader = new FileReader();
                                        reader.onload = (e) => {
                                            photoPreview = e.target.result;
                                        };
                                        reader.readAsDataURL($event.target.files[0]);
                                   ">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-3 block px-2">Total Pro (Support)</label>
                            <input type="number" name="supporter_count" value="{{ $suara->supporter_count }}"
                                   class="w-full px-8 py-5 bg-emerald-50/50 border-2 border-transparent focus:border-emerald-500/20 focus:bg-white rounded-3xl outline-none transition-all font-black text-emerald-600">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-rose-500 uppercase tracking-widest mb-3 block px-2">Total Kontra (Oppose)</label>
                            <input type="number" name="opponent_count" value="{{ $suara->opponent_count }}"
                                   class="w-full px-8 py-5 bg-rose-50/50 border-2 border-transparent focus:border-rose-500/20 focus:bg-white rounded-3xl outline-none transition-all font-black text-rose-500">
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block px-2">Sistem Status</label>
                        <select name="status" required class="w-full px-8 py-5 bg-slate-900 text-white rounded-3xl outline-none border-none font-black uppercase tracking-widest appearance-none cursor-pointer">
                            <option value="Pending" {{ $suara->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Approved" {{ $suara->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                            <option value="In Review" {{ $suara->status == 'In Review' ? 'selected' : '' }}>In Review</option>
                            <option value="Completed" {{ $suara->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Rejected" {{ $suara->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Impact Info -->
            <div class="mt-12 pt-12 border-t border-slate-50 space-y-6">
                <div class="group">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block px-2">Referensi / Bukti Tautan</label>
                    <input type="url" name="reference_link" value="{{ $suara->reference_link }}" placeholder="https://..."
                           class="w-full px-8 py-5 bg-slate-50 border-2 border-transparent focus:border-accent/10 focus:bg-white rounded-3xl outline-none transition-all font-bold text-blue-600 ">
                </div>
            </div>

            <div class="mt-16 flex items-center justify-end gap-6">
                <a href="{{ route('admin.suara') }}" class="px-10 py-5 bg-slate-100 text-slate-500 font-black rounded-3xl hover:bg-slate-200 transition-all uppercase tracking-widest text-xs">Batalkan</a>
                <button type="submit" class="px-12 py-5 bg-accent text-white font-black rounded-3xl shadow-2xl shadow-accent/40 hover:scale-105 active:scale-95 transition-all uppercase tracking-widest text-xs">Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>
@endsection
