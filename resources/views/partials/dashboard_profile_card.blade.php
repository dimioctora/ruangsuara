<div class="bg-white rounded-3xl md:rounded-[40px] p-5 sm:p-8 md:p-12 card-prominent relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-accent/5 rounded-full blur-3xl -mr-32 -mt-32"></div>
    
    <div class="flex flex-col md:flex-row items-center gap-6 sm:gap-8 md:gap-10 relative z-10">
        @php
            $currentLevelData = $levelInfo['current'];
            $levelIndex = $currentLevelData['index'];
            
            $shapeClass = '';
            if ($levelIndex <= 3) $shapeClass = 'rounded-full';
            elseif ($levelIndex <= 6) $shapeClass = 'badge-hexagon';
            elseif ($levelIndex <= 8) $shapeClass = 'badge-shield';
            else $shapeClass = 'badge-diamond';
            
            $effectClass = '';
            if ($levelIndex >= 7) $effectClass .= ' animate-pulse-badge';
            if ($levelIndex == 9) $effectClass .= ' glow-soft';
            if ($levelIndex == 10) $effectClass .= ' glow-heavy shimmer-gold';
        @endphp

        <!-- Avatar with Level Badge -->
        <div class="relative group flex-shrink-0">
            <div class="w-24 h-24 sm:w-32 sm:h-32 md:w-44 md:h-44 rounded-2xl sm:rounded-[32px] md:rounded-[40px] bg-gradient-to-tr from-accent to-success p-1 shadow-xl sm:shadow-2xl relative overflow-hidden">
                <div class="w-full h-full bg-white rounded-[14px] sm:rounded-[28px] md:rounded-[38px] border-2 sm:border-4 border-white flex items-center justify-center overflow-hidden">
                    @if($user->avatar_url)
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover global-user-avatar-card">
                    @else
                        <div class="global-user-avatar-card-svg w-full h-full flex items-center justify-center">
                            <svg class="w-full h-full scale-110" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="50" cy="35" r="20" fill="url(#avatarGrad1)" />
                                <path d="M20,85 Q50,60 80,85 L80,100 L20,100 Z" fill="url(#avatarGrad2)" />
                            </svg>
                        </div>
                    @endif
                </div>
                @if($levelIndex == 10)
                <div class="absolute inset-0 bg-white/10 shimmer-gold opacity-30 mix-blend-overlay"></div>
                @endif
            </div>
            
            <div class="absolute -bottom-2 -right-2 sm:-bottom-3 sm:-right-3 md:-bottom-4 md:-right-4 w-10 h-10 sm:w-12 sm:h-12 md:w-16 md:h-16 bg-white rounded-xl sm:rounded-2xl md:rounded-3xl shadow-xl sm:shadow-2xl flex items-center justify-center p-0.5 sm:p-1 group-hover:scale-110 transition-transform">
                <div class="w-full h-full flex items-center justify-center {{ $shapeClass }} {{ $effectClass }}" 
                     style="background-color: {{ $currentLevelData['color'] }}; color: white;">
                    <i data-lucide="{{ $currentLevelData['icon'] }}" class="w-4 h-4 sm:w-6 sm:h-6 md:w-8 md:h-8"></i>
                </div>
            </div>
        </div>

        <!-- User Info & XP -->
        <div class="flex-1 w-full text-center md:text-left space-y-4 sm:space-y-6 min-w-0">
            <div>
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 sm:gap-3 mb-2">
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-outfit font-black text-slate-900 break-words">{{ $user->name }}</h2>
                    <span class="px-3 py-1 text-white text-[9px] sm:text-[10px] font-black uppercase tracking-wider rounded-full shadow-md" 
                          style="background-color: {{ $currentLevelData['color'] }};">
                        {{ $user->level }}
                    </span>
                </div>
                <p class="text-xs sm:text-sm text-slate-400 font-medium">Role: <span class="text-accent font-black">{{ $user->role }}</span></p>
            </div>

            <div class="space-y-2 sm:space-y-3 max-w-xl xl:max-w-2xl 2xl:max-w-3xl">
                <div class="flex flex-wrap items-center justify-between gap-2 text-[10px] sm:text-xs font-black uppercase tracking-wider">
                    <span class="text-slate-400">Level {{ $levelInfo['current']['index'] }}</span>
                    <span class="text-accent">{{ number_format($user->xp) }} / {{ number_format($nextXp) }} XP</span>
                    <span class="text-slate-400">Next: {{ $levelInfo['next']['name'] ?? 'God' }}</span>
                </div>
                <div class="w-full h-3 sm:h-4 bg-slate-50 rounded-full border border-slate-100 p-0.5 overflow-hidden">
                    <div class="h-full xp-gradient rounded-full shadow-lg shadow-accent/20 relative transition-all duration-700" style="width: {{ $percent }}%">
                        <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                    </div>
                </div>
            </div>

            <!-- Badge Progression -->
            <div class="flex flex-wrap justify-center md:justify-start gap-2 sm:gap-3 pt-1">
                 <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-slate-100 flex items-center justify-center grayscale opacity-50"><i data-lucide="shield" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-slate-400"></i></div>
                 <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-blue-100 flex items-center justify-center"><i data-lucide="star" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-accent"></i></div>
                 <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-green-100 flex items-center justify-center ring-2 ring-success/20"><i data-lucide="zap" class="w-4 h-4 sm:w-5 sm:h-5 text-success"></i></div>
                 <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-slate-50 border border-dashed border-slate-200 flex items-center justify-center opacity-30"><i data-lucide="crown" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-slate-300"></i></div>
                 <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-slate-50 border border-dashed border-slate-200 flex items-center justify-center opacity-30"><i data-lucide="gem" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-slate-300"></i></div>
            </div>
        </div>
    </div>
</div>
