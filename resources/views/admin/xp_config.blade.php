@extends('admin.layout')

@section('content')
<form action="{{ route('admin.xp.update') }}" method="POST" class="space-y-10 animate-fade-in">
    @csrf
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-outfit font-black text-slate-900 tracking-tight">Konfigurasi XP & Reputasi</h2>
            <p class="text-sm text-slate-400 font-medium  mt-1 pb-4">Atur sirkulasi ekonomi reputasi dalam ekosistem Suara</p>
        </div>
        <button type="submit" class="px-8 py-3 bg-accent text-white font-black rounded-2xl shadow-xl shadow-accent/20 hover:scale-105 active:scale-95 transition-all text-xs flex items-center gap-3">
             <i data-lucide="save" class="w-4 h-4"></i>
             SIMPAN PERUBAHAN
        </button>
    </div>

    @if(session('success'))
    <div class="bg-success/10 border border-success/20 text-success p-4 rounded-2xl flex items-center gap-3 animate-fade-in">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        <span class="text-sm font-bold">{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-10">
        <!-- XP Settings List -->
        <div class="xl:col-span-2 space-y-6">
            <div class="bg-white rounded-[40px] border border-slate-50 shadow-sm overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Aktivitas User</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Reward XP</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Trust Bonus (%)</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Preview</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($config as $idx => $item)
                        <tr class="hover:bg-slate-50/30 transition-colors group">
                            <td class="px-8 py-6">
                                <input type="hidden" name="config[{{ $idx }}][id]" value="{{ $item->id }}">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-800">{{ $item->action_name }}</span>
                                    <span class="text-[10px] text-slate-400 font-medium ">{{ $item->description }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <input type="number" 
                                       name="config[{{ $idx }}][xp_reward]" 
                                       value="{{ $item->xp_reward }}" 
                                       class="w-24 px-3 py-2 bg-slate-50 border border-slate-100 rounded-xl text-center font-black text-warning outline-none focus:ring-4 focus:ring-warning/5 focus:border-warning/30 transition-all">
                            </td>
                            <td class="px-8 py-6 text-center">
                                <input type="number" 
                                       step="0.1"
                                       name="config[{{ $idx }}][trust_bonus]" 
                                       value="{{ $item->trust_bonus }}" 
                                       class="w-24 px-3 py-2 bg-slate-50 border border-slate-100 rounded-xl text-center font-black text-success outline-none focus:ring-4 focus:ring-success/5 focus:border-success/30 transition-all">
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="inline-flex items-center gap-1 bg-accent/5 text-accent px-3 py-1 rounded-lg border border-accent/10 opacity-40 group-hover:opacity-100 transition-opacity">
                                    <span class="text-[10px] font-black">ACTIVE</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Visual Info Card -->
            <div class="bg-slate-900 rounded-[40px] p-10 text-white relative overflow-hidden shadow-2xl">
                <div class="absolute top-0 right-0 w-64 h-64 bg-accent/20 rounded-full blur-[100px] -mr-20 -mt-20"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-center gap-10">
                    <div class="w-20 h-20 bg-accent rounded-3xl flex items-center justify-center flex-shrink-0 animate-pulse">
                        <i data-lucide="trending-up" class="w-10 h-10"></i>
                    </div>
                    <div>
                        <h4 class="text-xl font-outfit font-black mb-2">Tips Manajemen XP</h4>
                        <p class="text-sm text-slate-400 leading-relaxed max-w-xl font-medium ">
                            "Menjaga XP tetap langka meningkatkan nilai kebanggaan user. Pastikan reward tinggi hanya untuk aksi nyata yang diverifikasi secara kolektif."
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Preview / Preview Visual Levels -->
        <div class="space-y-6">
            <div class="bg-white rounded-[40px] p-8 border border-slate-50 shadow-sm space-y-8">
                <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2 border-b border-slate-50 pb-4">Simulasi Leveling</h4>
                
                <div class="space-y-6">
                    @php
                        $previewLevels = \App\Services\ReputationService::getAllLevels();
                    @endphp

                    @foreach($previewLevels as $idx => $lvl)
                    @if($idx < 5)
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white text-[8px] font-black" 
                             style="background-color: {{ $lvl['color'] }}">
                            <i data-lucide="{{ $lvl['icon'] }}" class="w-5 h-5"></i>
                        </div>
                        <div class="flex-grow">
                            <p class="text-xs font-black text-slate-900">{{ $lvl['name'] }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Minimal {{ number_format($lvl['min_xp']) }} XP</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-200"></i>
                    </div>
                    @endif
                    @endforeach
                </div>

                <div class="pt-6 border-t border-slate-50">
                    <button class="w-full py-4 bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-slate-100 transition-all border border-slate-100 ">
                        Unduh Laporan Inflasi XP
                    </button>
                </div>
            </div>

            <!-- Trust Multiplier -->
            <div class="bg-success/5 rounded-[40px] p-8 border border-success/10 space-y-4">
                <div class="flex items-center gap-4 text-success">
                    <i data-lucide="verified" class="w-6 h-6"></i>
                    <h4 class="text-sm font-black uppercase tracking-widest">Trust Multiplier</h4>
                </div>
                <p class="text-xs text-slate-500 font-medium">User dengan Trust Score > 80% mendapatkan bonus XP 1.2x lipat secara otomatis.</p>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-success rounded-full"></span>
                    <span class="text-[10px] font-black text-success uppercase tracking-widest">Active System</span>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
