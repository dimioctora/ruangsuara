@extends('admin.layout')

@section('content')
<div class="space-y-12 animate-fade-in">
    <!-- 1. Stats Grid -->
    <section class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="bg-white p-10 rounded-[40px] shadow-sm border border-slate-50 hover:border-accent/10 transition-all hover:translate-y-[-5px]">
            <div class="w-14 h-14 bg-accent/10 text-accent rounded-2xl flex items-center justify-center mb-6">
                <i data-lucide="users" class="w-8 h-8"></i>
            </div>
            <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Total User</h4>
            <div class="text-4xl font-outfit font-black text-slate-900 tracking-tight">{{ number_format($stats['total_users']) }}</div>
        </div>

        <div class="bg-white p-10 rounded-[40px] shadow-sm border border-slate-50 hover:border-accent/10 transition-all hover:translate-y-[-5px]">
            <div class="w-14 h-14 bg-success/10 text-success rounded-2xl flex items-center justify-center mb-6">
                <i data-lucide="megaphone" class="w-8 h-8"></i>
            </div>
            <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Total Isu</h4>
            <div class="text-4xl font-outfit font-black text-slate-900 tracking-tight">{{ number_format($stats['total_suara']) }}</div>
        </div>

        <div class="bg-white p-10 rounded-[40px] shadow-sm border border-slate-50 hover:border-accent/10 transition-all hover:translate-y-[-5px]">
            <div class="w-14 h-14 bg-warning/10 text-warning rounded-2xl flex items-center justify-center mb-6">
                <i data-lucide="zap" class="w-8 h-8"></i>
            </div>
            <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Total XP Sirkulasi</h4>
            <div class="text-4xl font-outfit font-black text-slate-900 tracking-tight">{{ number_format($stats['total_xp']) }}</div>
        </div>

        <div class="bg-white p-10 rounded-[40px] shadow-sm border border-slate-50 hover:border-accent/10 transition-all hover:translate-y-[-5px]">
            <div class="w-14 h-14 bg-danger/10 text-danger rounded-2xl flex items-center justify-center mb-6">
                <i data-lucide="shield-check" class="w-8 h-8"></i>
            </div>
            <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Trust Average</h4>
            <div class="text-4xl font-outfit font-black text-slate-900 tracking-tight">{{ $stats['total_trust'] }}%</div>
        </div>
    </section>

    <!-- 2. Split Tables Views -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Recent Issues -->
        <div class="bg-white rounded-[40px] overflow-hidden border border-slate-50 shadow-sm">
             <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                <h3 class="text-xl font-outfit font-black text-slate-900">Isu Terbaru</h3>
                <a href="{{ route('admin.suara') }}" class="text-xs font-black text-accent uppercase tracking-widest">Semua Isu <i data-lucide="chevron-right" class="w-4 h-4 inline"></i></a>
             </div>
             <div class="divide-y divide-slate-50">
                @foreach($recent_suara as $s)
                <div class="p-6 flex items-center gap-6 hover:bg-slate-50 transition-colors">
                    <div class="w-14 h-14 rounded-xl overflow-hidden flex-shrink-0 border border-slate-100 bg-slate-50">
                        @if($s->image)
                        <img src="{{ Str::startsWith($s->image, 'http') ? $s->image : asset('storage/' . $s->image) }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-slate-300"><i data-lucide="image" class="w-6 h-6"></i></div>
                        @endif
                    </div>
                    <div class="flex-grow overflow-hidden">
                        <h4 class="text-sm font-bold text-slate-900 truncate mb-1">{{ $s->title }}</h4>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $s->category }} — {{ $s->location }}</p>
                    </div>
                    <div class="text-right">
                        @php
                            $colorMap = [
                                'Pending' => 'bg-warning/5 text-warning border-warning/10',
                                'Approved' => 'bg-success/5 text-success border-success/10',
                                'Completed' => 'bg-accent/5 text-accent border-accent/10',
                                'Rejected' => 'bg-slate-50 text-slate-400 border-slate-100'
                            ];
                        @endphp
                        <span class="px-4 py-1.5 {{ $colorMap[$s->status] ?? 'bg-slate-50 text-slate-400 border-slate-100' }} border text-[10px] font-black uppercase tracking-widest rounded-full">
                            {{ $s->status }}
                        </span>
                    </div>
                </div>
                @endforeach
             </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white rounded-[40px] overflow-hidden border border-slate-50 shadow-sm">
             <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                <h3 class="text-xl font-outfit font-black text-slate-900">User Baru</h3>
                <a href="{{ route('admin.users') }}" class="text-xs font-black text-accent uppercase tracking-widest">Semua User <i data-lucide="chevron-right" class="w-4 h-4 inline"></i></a>
             </div>
             <div class="overflow-x-auto">
                 <table class="w-full text-left">
                     <thead>
                         <tr class="bg-slate-50/50">
                             <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">User</th>
                             <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Reputasi</th>
                             <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                         </tr>
                     </thead>
                     <tbody class="divide-y divide-slate-50">
                        @foreach($recent_users as $u)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full border border-slate-100 bg-slate-50 overflow-hidden">
                                        <img src="https://i.pravatar.cc/100?u={{ $u->id }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-900 leading-tight">{{ $u->name }}</h4>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $u->role }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-slate-900">{{ number_format($u->xp) }} XP</span>
                                    <span class="text-[10px] text-success font-bold uppercase tracking-widest">T: {{ $u->trust_score }}%</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <button class="w-8 h-8 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center hover:bg-accent hover:text-white transition-all"><i data-lucide="chevron-right" class="w-4 h-4"></i></button>
                            </td>
                        </tr>
                        @endforeach
                     </tbody>
                 </table>
             </div>
        </div>
    </div>
</div>
@endsection
