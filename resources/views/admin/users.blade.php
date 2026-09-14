@extends('admin.layout')

@section('content')
<div class="space-y-12 animate-fade-in">
    <div class="flex items-center justify-between px-2">
        <div>
            <h2 class="text-3xl font-outfit font-black text-slate-900 tracking-tight">Manajemen User</h2>
            <p class="text-sm text-slate-400 font-medium">Kelola hak akses, peran, dan delegasi reputasi pengguna.</p>
        </div>
        <div class="flex gap-4">
             <div class="relative group">
                <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                <input type="text" placeholder="Cari user..." class="px-10 py-3 bg-white border border-slate-100 rounded-2xl text-sm focus:ring-2 focus:ring-accent/20 transition-all outline-none">
            </div>
            <button class="px-8 py-3 bg-slate-900 text-white font-black rounded-2xl flex items-center gap-2 shadow-xl shadow-slate-900/20 hover:scale-105 active:scale-95 transition-all">
                <i data-lucide="user-plus" class="w-4 h-4"></i> Tambah User
            </button>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-[40px] overflow-hidden border border-slate-50 shadow-sm overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Identitas User</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Peran / Sistem</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Reputasi</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Trust Score</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($users as $user)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-8 py-8">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl overflow-hidden flex-shrink-0 border-2 border-slate-100">
                                <img src="https://i.pravatar.cc/100?u={{ $user->id }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="text-base font-black text-slate-900 leading-tight mb-0.5">{{ $user->name }}</h4>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-8">
                        @php
                            $roleColors = [
                                'Super Admin' => 'bg-danger/10 text-danger border-danger/20',
                                'Moderator' => 'bg-warning/10 text-warning border-warning/20',
                                'Koordinator' => 'bg-accent/10 text-accent border-accent/20',
                                'Verified User' => 'bg-success/10 text-success border-success/20',
                                'Default User' => 'bg-slate-50 text-slate-400 border-slate-100',
                            ];
                        @endphp
                        <span class="px-4 py-2 {{ $roleColors[$user->role] ?? 'bg-slate-50 text-slate-400 border-slate-100' }} border text-[10px] font-black uppercase tracking-widest rounded-full">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-8 py-8 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                             <div class="w-8 h-8 rounded-lg bg-accent/5 text-accent flex items-center justify-center font-black text-[10px]">
                                {{ substr($user->level, 0, 1) }}
                             </div>
                             <div>
                                <h4 class="text-sm font-black text-slate-900">{{ number_format($user->xp) }} XP</h4>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $user->level }}</p>
                             </div>
                        </div>
                    </td>
                    <td class="px-8 py-8 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-24 h-2 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-success rounded-full" style="width: {{ $user->trust_score }}%"></div>
                            </div>
                            <span class="text-sm font-black text-slate-900">{{ $user->trust_score }}%</span>
                        </div>
                    </td>
                    <td class="px-8 py-8 text-right">
                        <div class="flex items-center justify-end gap-2">
                             <button class="w-10 h-10 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all shadow-sm">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </button>
                             <button class="w-10 h-10 rounded-xl bg-danger/5 text-danger flex items-center justify-center hover:bg-danger hover:text-white transition-all shadow-sm">
                                <i data-lucide="shield-off" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center pt-10">
        {{ $users->links() }}
    </div>
</div>
@endsection
