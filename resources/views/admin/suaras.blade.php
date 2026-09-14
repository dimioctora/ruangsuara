@extends('admin.layout')

@section('content')
<div class="space-y-12 animate-fade-in">
    <div class="flex items-center justify-between px-2">
        <div>
            <h2 class="text-3xl font-outfit font-black text-slate-900 tracking-tight">Manajemen Isu Suara</h2>
            <p class="text-sm text-slate-400 font-medium">Validasi dan kawal setiap suara masyarakat untuk perubahan nyata.</p>
        </div>
        <div class="flex gap-4">
            <div class="relative group">
                <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                <input type="text" placeholder="Cari isu..." class="px-10 py-3 bg-white border border-slate-100 rounded-2xl text-sm focus:ring-2 focus:ring-accent/20 transition-all outline-none">
            </div>
            <button class="px-6 py-3 bg-accent text-white font-black rounded-2xl flex items-center gap-2 shadow-xl shadow-accent/20 hover:scale-105 active:scale-95 transition-all">
                <i data-lucide="filter" class="w-4 h-4"></i> Filter
            </button>
        </div>
    </div>

    <!-- Issues Table -->
    <div class="bg-white rounded-[40px] overflow-hidden border border-slate-50 shadow-sm overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest min-w-[300px]">Isu / Laporan</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pelapor</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($suaras as $s)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-8 py-8">
                        <div class="flex items-center gap-6">
                            <div class="w-16 h-16 rounded-2xl overflow-hidden flex-shrink-0 border border-slate-100 bg-slate-50 shadow-sm group relative">
                                @if($s->image)
                                <img src="{{ Str::startsWith($s->image, 'http') ? $s->image : asset('storage/' . $s->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300"><i data-lucide="image" class="w-6 h-6"></i></div>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-base font-black text-slate-900 leading-tight mb-1">{{ $s->title }}</h4>
                                <div class="flex items-center gap-2">
                                    <span class="text-[9px] font-black bg-accent/5 text-accent px-2 py-0.5 rounded-full uppercase tracking-widest">{{ $s->category }}</span>
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $s->location }}</span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-8">
                        <div class="flex items-center gap-3">
                            <img src="https://i.pravatar.cc/100?u={{ $s->user_id }}" class="w-8 h-8 rounded-full border border-slate-100 bg-slate-50">
                            <span class="text-sm font-bold text-slate-700">{{ $s->user->name }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-8 text-sm font-medium text-slate-500 whitespace-nowrap">
                        {{ $s->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="px-8 py-8">
                        <form action="{{ route('admin.suara.status', $s->id) }}" method="POST">
                            @csrf
                            <select name="status" onchange="this.form.submit()" class="px-4 py-2 bg-white border border-slate-100 rounded-xl text-[10px] font-black uppercase tracking-widest focus:ring-2 focus:ring-accent/20 outline-none
                                {{ $s->status == 'Pending' ? 'text-warning' : '' }}
                                {{ $s->status == 'Approved' ? 'text-success' : '' }}
                                {{ $s->status == 'Completed' ? 'text-accent' : '' }}
                                {{ $s->status == 'Rejected' ? 'text-danger' : '' }}
                            ">
                                <option value="Pending" {{ $s->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Approved" {{ $s->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                <option value="In Review" {{ $s->status == 'In Review' ? 'selected' : '' }}>In Review</option>
                                <option value="Completed" {{ $s->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Rejected" {{ $s->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-8 py-8 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('suara.detail', $s->id) }}" target="_blank" class="w-10 h-10 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center hover:bg-accent hover:text-white transition-all shadow-sm">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <a href="{{ route('admin.suara.edit', $s->id) }}" class="w-10 h-10 rounded-xl bg-accent/5 text-accent flex items-center justify-center hover:bg-accent hover:text-white transition-all shadow-sm">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('admin.suara.delete', $s->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus isu ini? Tindakan ini tidak dapat dibatalkan.')">
                                @csrf
                                <button type="submit" class="w-10 h-10 rounded-xl bg-danger/5 text-danger flex items-center justify-center hover:bg-danger hover:text-white transition-all shadow-sm">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination Placeholder -->
    <div class="flex justify-center pt-10">
        {{ $suaras->links() }}
    </div>
</div>
@endsection
