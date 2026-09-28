@php
    // Robust Image Loader
    if ($m->image) {
        if (str_starts_with($m->image, 'http')) {
            $img = $m->image;
        } else if (str_starts_with($m->image, 'images/')) {
            $img = asset($m->image);
        } else {
            $img = asset('storage/' . $m->image);
        }
    } else {
        $img = 'https://images.unsplash.com/photo-1545147986-a9d6f210df77?auto=format&fit=crop&q=80&w=800';
    }

    // Dynamic Progress Tracking
    $total = $m->supporter_count + $m->opponent_count;
    $proPct = $total > 0 ? round(($m->supporter_count / $total) * 100) : 0;
    $contraPct = $total > 0 ? (100 - $proPct) : 0;
@endphp
<div class="bg-white rounded-[40px] shadow-sm border border-slate-50 card-hover transition-all duration-300 group flex flex-col overflow-hidden relative animate-fade-in">
    <!-- Stretched Link for the entire card -->
    <a href="{{ url('/suara-detail/' . $m->id) }}" class="absolute inset-0 z-0" aria-label="Lihat Detail {{ $m->title }}"></a>
    
    <!-- Card Image -->
    <div class="relative w-full aspect-[5/4] overflow-hidden pointer-events-none">
        <img src="{{ $img }}" alt="{{ $m->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
        <div class="absolute top-6 left-6 flex gap-2">
            <span class="px-3 py-1 bg-white/90 backdrop-blur-md text-slate-800 text-[10px] font-black uppercase tracking-widest rounded-lg shadow-sm">{{ $m->category }}</span>
        </div>
        <div class="absolute bottom-6 left-6 flex items-center gap-2 text-white">
            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-brandAccent"></i>
            <span class="text-xs font-bold tracking-wide">{{ $m->location }}</span>
        </div>
    </div>

    <!-- Card Body -->
    <div class="p-8 flex flex-col flex-1 relative z-10">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-2 text-primary">
                <i data-lucide="megaphone" class="w-5 h-5"></i>
                <span class="text-xs font-bold uppercase tracking-widest">Suara Aktif</span>
            </div>
            <div class="flex items-center gap-1 relative z-20">
                <button onclick="event.preventDefault(); event.stopPropagation();" class="w-10 h-10 rounded-full flex items-center justify-center text-slate-300 hover:text-red-500 hover:bg-red-50 transition-all" title="Sukai">
                    <i data-lucide="heart" class="w-5 h-5"></i>
                </button>
                @php
                    $isCardBookmarked = auth()->check() ? $m->isBookmarkedBy(auth()->user()) : false;
                @endphp
                <button onclick="event.preventDefault(); event.stopPropagation(); toggleCardBookmark({{ $m->id }}, this);" class="w-10 h-10 rounded-full flex items-center justify-center transition-all bookmark-btn-{{ $m->id }} {{ $isCardBookmarked ? 'text-amber-500 bg-amber-50 shadow-sm' : 'text-slate-300 hover:text-amber-500 hover:bg-amber-50' }}" title="{{ $isCardBookmarked ? 'Tersimpan (Klik untuk batal)' : 'Simpan / Pantau Isu' }}">
                    <i data-lucide="bookmark" class="w-5 h-5 {{ $isCardBookmarked ? 'fill-current text-amber-500' : '' }}"></i>
                </button>
            </div>
        </div>

        <h3 class="text-xl font-outfit font-extrabold text-slate-800 mb-3 leading-snug group-hover:text-primary transition-colors line-clamp-2 uppercase tracking-tighter">
            {{ $m->title }}
        </h3>
        
        <p class="text-slate-500 text-sm mb-8 line-clamp-2 font-medium leading-relaxed">
            {{ strip_tags($m->description) }}
        </p>

        <!-- Pro vs Contra Progress Bar -->
        <div class="mt-auto pt-8 border-t border-slate-50">
            <div class="flex items-center justify-between mb-3 text-sm">
                <span class="text-xs font-black text-emerald-600 uppercase tracking-widest">Support Percentage</span>
                <div class="flex gap-4">
                    <span class="text-xs font-black text-emerald-600">{{ $proPct }}% Pro</span>
                    <span class="text-xs font-black text-rose-500">{{ $contraPct }}% Kontra</span>
                </div>
            </div>
            <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden flex mb-8">
                <div class="h-full bg-emerald-400 transition-all duration-1000 ease-out" style="width: {{ $proPct }}%"></div>
                <div class="h-full bg-rose-400 transition-all duration-1000 ease-out" style="width: {{ $contraPct }}%"></div>
            </div>
            
            <div class="flex items-center justify-between relative z-20">
                @php
                    $supporters = ($m && $m->votes) ? $m->votes->where('type', 'pro')->pluck('user')->filter()->unique('id') : collect();
                    $totalSupporters = (int) ($m->supporter_count ?? 0);
                @endphp
                <div class="flex items-center gap-3">
                    <div class="flex -space-x-2">
                        @if($supporters->isNotEmpty())
                            @foreach($supporters->take(2) as $sup)
                                @if($sup && $sup->avatar_url)
                                    <img class="w-8 h-8 rounded-full border-2 border-white shadow-sm object-cover" src="{{ $sup->avatar_url }}" alt="{{ $sup->name }}" title="{{ $sup->name }}">
                                @else
                                    <div class="w-8 h-8 rounded-full border-2 border-white bg-gradient-to-tr from-accent to-blue-700 text-white font-black text-[10px] flex items-center justify-center shadow-sm uppercase" title="{{ $sup->name ?? 'Warga' }}">
                                        {{ substr($sup->name ?? 'W', 0, 2) }}
                                    </div>
                                @endif
                            @endforeach
                        @elseif($m->user)
                            @if($m->user->avatar_url)
                                <img class="w-8 h-8 rounded-full border-2 border-white shadow-sm object-cover" src="{{ $m->user->avatar_url }}" alt="{{ $m->user->name }}" title="Inisiator: {{ $m->user->name }}">
                            @else
                                <div class="w-8 h-8 rounded-full border-2 border-white bg-gradient-to-tr from-accent to-blue-700 text-white font-black text-[10px] flex items-center justify-center shadow-sm uppercase" title="Inisiator: {{ $m->user->name }}">
                                    {{ substr($m->user->name ?? 'W', 0, 2) }}
                                </div>
                            @endif
                        @else
                            <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-100 flex items-center justify-center text-slate-400">
                                <i data-lucide="user" class="w-4 h-4"></i>
                            </div>
                        @endif

                        @if($totalSupporters > 2)
                            <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-600 shadow-sm">
                                +{{ $totalSupporters - min(2, $supporters->count()) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[10px] font-black text-slate-900 leading-none">{{ number_format($m->supporter_count, 0, ',', '.') }}</span>
                        <span class="text-[8px] font-bold text-slate-400 uppercase tracking-tighter leading-none">Voices</span>
                    </div>
                </div>
                <button onclick="event.preventDefault(); event.stopPropagation(); copyShareLinkModal('{{ url('/suara-detail/' . $m->id) }}', '{{ addslashes($m->title) }}')" class="flex items-center gap-1.5 text-slate-400 hover:text-accent transition-colors uppercase text-[10px] font-black tracking-widest">
                    <i data-lucide="share-2" class="w-4 h-4"></i> Bagikan
                </button>
            </div>
        </div>
    </div>
</div>
