<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $suara->title }} — Ruang Suara</title>
    <meta name="description" content="{{ Str::limit(strip_tags($suara->description), 160) }}">
    <meta property="og:title" content="{{ $suara->title }} — Ruang Suara">
    <meta property="og:description" content="{{ Str::limit(strip_tags($suara->description), 160) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="article">
    @php
        $ogImg = 'https://images.unsplash.com/photo-1545147986-a9d6f210df77?auto=format&fit=crop&q=80&w=2000';
        if ($suara->image) {
            if (str_starts_with($suara->image, 'http')) {
                $ogImg = $suara->image;
            } else if (str_starts_with($suara->image, 'images/')) {
                $ogImg = asset($suara->image);
            } else {
                $ogImg = asset('storage/' . $suara->image);
            }
        }
    @endphp
    <meta property="og:image" content="{{ $ogImg }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $suara->title }}">
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($suara->description), 160) }}">
    <meta name="twitter:image" content="{{ $ogImg }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0F172A', // Slate 900 for elegance
                        accent: '#2563EB',  // Professional Blue
                        success: '#10B981', // Emerald Green
                        warning: '#F59E0B', // Amber
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        outfit: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
        .timeline-step::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 100%;
            width: 100%;
            height: 2px;
            background: #E2E8F0;
            z-index: -1;
        }
        .timeline-step:last-child::after {
            display: none;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #E2E8F0;
            border-radius: 10px;
        }
        @keyframes subtle-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        .animate-subtle {
            animation: subtle-float 4s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-900 selection:bg-accent/10">
    <!-- Apply global overflow fix -->
    <style>
        html, body {
            max-width: 100%;
            overflow-x: hidden !important;
            margin: 0;
            padding: 0;
        }
    </style>

    <header class="fixed top-0 left-0 right-0 z-[100] bg-white/80 backdrop-blur-xl border-b border-slate-200/60 shadow-sm transition-all duration-300">
        <nav class="w-full max-w-[1720px] mx-auto px-4 sm:px-6 lg:px-12 py-4 flex items-center justify-between">
            <!-- Logo (Left) -->
            <a href="/" class="flex items-center group flex-shrink-0">
                <img src="{{ asset('images/suara-logo-transparent.png') }}" alt="Suara Logo" class="h-8 w-auto group-hover:scale-110 transition-transform drop-shadow-xl">
            </a>

            <!-- Menu Halaman (Tengah) -->
            <div class="hidden md:flex items-center gap-10 text-sm font-black text-slate-500 uppercase tracking-widest">
                <a href="/suara" class="hover:text-accent transition-all">Suara</a>
                <a href="#" class="hover:text-accent transition-all">Cara Kerja</a>
                <a href="#" class="hover:text-accent transition-all">Tentang</a>
                <a href="#" class="hover:text-accent transition-all">Kontak</a>
            </div>

            <!-- Auth/User Module (Kanan) -->
            <div class="flex items-center gap-4">
                @auth
                    <!-- User Profile Module (Matching Image 2) -->
                    <div class="flex items-center gap-4 border-l border-slate-100 pl-8 ml-4">
                        <div class="hidden md:flex flex-col items-end">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] leading-none mb-1">Selamat Datang,</span>
                            <span class="text-sm font-black font-outfit text-slate-900 tracking-tight">{{ auth()->user()->name ?? 'Dimi Octora' }}</span>
                        </div>
                        <a href="/dashboard" class="relative group">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-slate-50 to-slate-100 border border-slate-200/50 flex items-center justify-center shadow-sm group-hover:shadow-md transition-all overflow-hidden relative">
                                <!-- Avatar Background Gradient Ring (Matching Image 2) -->
                                <div class="absolute inset-0 border-2 border-transparent bg-gradient-to-br from-accent to-success [mask-image:linear-gradient(white,white)] [mask-clip:content-box] -m-[2px] rounded-2xl opacity-20 group-hover:opacity-40 transition-opacity"></div>
                                
                                @if(auth()->user()->avatar_url)
                                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-full h-full p-2" viewBox="0 0 100 100">
                                        <defs>
                                            <linearGradient id="navAvatarGradGlobal" x1="0%" y1="0%" x2="100%" y2="100%">
                                                <stop offset="0%" style="stop-color:#2563EB;stop-opacity:1" />
                                                <stop offset="100%" style="stop-color:#10B981;stop-opacity:1" />
                                            </linearGradient>
                                        </defs>
                                        <path fill="url(#navAvatarGradGlobal)" d="M50 50c11.046 0 20-8.954 20-20s-8.954-20-20-20-20 8.954-20 20 8.954 20 20 20zm0 10c-16.569 0-30 13.431-30 30h60c0-16.569-13.431-30-30-30z" opacity="0.8" />
                                    </svg>
                                @endif
                            </div>
                        </a>
                    </div>
                @else
                    <!-- Login Button (Guest) -->
                    <button onclick="toggleAuthModal('login')" class="bg-gradient-to-r from-accent to-success text-white text-sm font-black px-8 py-3 rounded-xl shadow-lg shadow-accent/30 hover:shadow-accent/50 hover:-translate-y-0.5 transition-all flex items-center gap-2">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        Masuk
                    </button>
                @endauth
            </div>
        </nav>
    </header>

    <main class="w-full max-w-[1720px] mx-auto px-4 sm:px-6 lg:px-12 pt-20 md:pt-24 pb-24">
        <!-- Hero Section -->
        <section class="w-full">
            <div class="relative w-full aspect-[16/10] sm:aspect-[16/8] lg:aspect-[21/8] xl:aspect-[24/8] min-h-[360px] md:min-h-[460px] rounded-[32px] md:rounded-[40px] overflow-hidden shadow-2xl mb-8 md:mb-12">
                @php
                    if ($suara->image) {
                        if (str_starts_with($suara->image, 'http')) {
                            $img = $suara->image;
                        } else if (str_starts_with($suara->image, 'images/')) {
                            $img = asset($suara->image);
                        } else {
                            $img = asset('storage/' . $suara->image);
                        }
                    } else {
                        $img = 'https://images.unsplash.com/photo-1545147986-a9d6f210df77?auto=format&fit=crop&q=80&w=2000';
                    }
                @endphp
                <img src="{{ $img }}" alt="{{ $suara->title }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/30 to-transparent"></div>
                
                <!-- Quick Share on Hero -->
                <div class="absolute top-6 right-6 z-20">
                    <button type="button" onclick="shareNative('{{ addslashes($suara->title) }}', '{{ url()->current() }}')" class="px-4 py-2.5 bg-slate-900/50 hover:bg-slate-900/80 backdrop-blur-md text-white rounded-2xl border border-white/20 shadow-xl transition-all active:scale-95 flex items-center gap-2 font-outfit text-xs font-bold">
                        <i data-lucide="share-2" class="w-4 h-4 text-emerald-400"></i>
                        <span>Bagikan</span>
                    </button>
                </div>

                <div class="absolute bottom-6 sm:bottom-10 left-6 sm:left-10 right-6 sm:right-10 text-white max-w-5xl">
                    <div class="flex flex-wrap gap-3 mb-4 md:mb-6">
                        <span class="px-4 py-1.5 bg-accent text-white text-[10px] font-black uppercase tracking-widest rounded-full shadow-lg shadow-accent/20">{{ $suara->category }}</span>
                        <span class="px-4 py-1.5 bg-white/20 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-widest rounded-full border border-white/30 flex items-center gap-2">
                            <i data-lucide="map-pin" class="w-3 h-3 text-emerald-400"></i> {{ $suara->location }}
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-outfit font-extrabold mb-4 leading-tight tracking-tight uppercase">{{ $suara->title }}</h1>
                    <div class="flex items-center gap-3 text-slate-300 font-medium">
                        <div class="flex -space-x-2">
                            <img class="w-8 h-8 rounded-full border-2 border-white/20" src="https://i.pravatar.cc/100?u=1" alt="">
                            <img class="w-8 h-8 rounded-full border-2 border-white/20" src="https://i.pravatar.cc/100?u=2" alt="">
                            <div class="w-8 h-8 rounded-full border-2 border-white/20 bg-accent flex items-center justify-center text-[10px] font-bold">+9</div>
                        </div>
                        <span class="text-xs sm:text-sm">Didukung oleh <strong class="text-white">{{ number_format($suara->supporter_count, 0, ',', '.') }}+</strong> Voices</span>
                    </div>
                </div>
            </div>

            <!-- Heat Index Timeline -->
            <div class="bg-white rounded-[32px] md:rounded-[40px] p-6 sm:p-8 md:p-10 shadow-sm border border-slate-100 mb-8 md:mb-12 overflow-hidden">
                <div class="flex items-center justify-between mb-8 md:mb-10">
                    <h3 class="text-lg sm:text-xl font-outfit font-bold text-slate-800 flex items-center gap-3">
                        <i data-lucide="activity" class="text-accent w-6 h-6"></i>
                        Heat Index Timeline
                    </h3>
                    <div class="flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold ring-1 ring-emerald-100">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></span>
                        Status: Sedang Berlangsung
                    </div>
                </div>

                <!-- Horizontal Scrollable / Full Width Responsive Timeline -->
                <div class="overflow-x-auto pb-4 custom-scrollbar">
                    <div class="flex items-start justify-between min-w-[750px] lg:min-w-full relative px-2 sm:px-6">
                        <!-- Step 1 (Done) -->
                        <div class="flex flex-col items-center text-center flex-1 relative z-10">
                            <div class="w-12 h-12 rounded-full bg-accent text-white flex items-center justify-center mb-4 shadow-lg shadow-accent/30 ring-4 ring-white">
                                <i data-lucide="alert-circle" class="w-6 h-6"></i>
                            </div>
                            <span class="text-xs font-black uppercase tracking-widest text-accent mb-1">Issue</span>
                            <span class="text-[10px] font-bold text-slate-400">12 Jan 2026</span>
                            <div class="absolute top-6 left-1/2 w-full h-1 bg-accent -z-10"></div>
                        </div>

                        <!-- Step 2 (Done) -->
                        <div class="flex flex-col items-center text-center flex-1 relative z-10">
                            <div class="w-12 h-12 rounded-full bg-accent text-white flex items-center justify-center mb-4 shadow-lg shadow-accent/30 ring-4 ring-white animate-subtle">
                                <i data-lucide="megaphone" class="w-6 h-6"></i>
                            </div>
                            <span class="text-xs font-black uppercase tracking-widest text-accent mb-1">Aspiration</span>
                            <span class="text-[10px] font-bold text-slate-400">1 Feb 2026</span>
                            <div class="absolute top-6 left-1/2 w-full h-1 bg-accent -z-10"></div>
                        </div>

                        <!-- Step 3 (Active) -->
                        <div class="flex flex-col items-center text-center flex-1 relative z-10">
                            <div class="w-14 h-14 rounded-full bg-white border-4 border-accent text-accent flex items-center justify-center mb-4 shadow-xl shadow-accent/10 ring-4 ring-white scale-110">
                                <i data-lucide="scale" class="w-7 h-7"></i>
                            </div>
                            <span class="text-xs font-black uppercase tracking-widest text-slate-900 mb-1">Decision</span>
                            <span class="text-[10px] font-bold text-accent">Sedang Proses</span>
                            <div class="absolute top-7 left-1/2 w-full h-1 bg-slate-100 -z-10"></div>
                        </div>

                        <!-- Step 4 (Future) -->
                        <div class="flex flex-col items-center text-center flex-1 relative z-10">
                            <div class="w-12 h-12 rounded-full bg-slate-50 border border-slate-200 text-slate-300 flex items-center justify-center mb-4 ring-4 ring-white">
                                <i data-lucide="check-circle" class="w-6 h-6"></i>
                            </div>
                            <span class="text-xs font-black uppercase tracking-widest text-slate-400 mb-1">Realized</span>
                            <span class="text-[10px] font-bold text-slate-300">Mendatang</span>
                            <div class="absolute top-6 left-1/2 w-full h-1 bg-slate-100 -z-10"></div>
                        </div>

                        <!-- Step 5 (Future) -->
                        <div class="flex flex-col items-center text-center flex-1 relative z-10">
                            <div class="w-12 h-12 rounded-full bg-slate-50 border border-slate-200 text-slate-300 flex items-center justify-center mb-4 ring-4 ring-white">
                                <i data-lucide="fast-forward" class="w-6 h-6"></i>
                            </div>
                            <span class="text-xs font-black uppercase tracking-widest text-slate-400 mb-1">Next Steps</span>
                            <div class="absolute top-6 left-1/2 w-full h-1 bg-slate-100 -z-10"></div>
                        </div>

                        <!-- Step 6 (Future) -->
                        <div class="flex flex-col items-center text-center flex-1 relative z-10">
                            <div class="w-12 h-12 rounded-full bg-slate-50 border border-slate-200 text-slate-300 flex items-center justify-center mb-4 ring-4 ring-white">
                                <i data-lucide="zap" class="w-6 h-6"></i>
                            </div>
                            <span class="text-xs font-black uppercase tracking-widest text-slate-400 mb-1">Action Taken</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-12 gap-8 lg:gap-10 xl:gap-12">
                <!-- Main Content (Left) -->
                <div class="lg:col-span-8 space-y-8 md:space-y-12">
                    <!-- Issue Description -->
                    <article class="bg-white rounded-[32px] md:rounded-[40px] p-6 sm:p-8 md:p-12 shadow-sm border border-slate-100 prose prose-slate max-w-none">
                        <h2 class="text-3xl font-outfit font-extrabold text-slate-900 mb-8">Deskripsi Masalah</h2>
                        <p class="text-slate-600 leading-relaxed text-lg mb-8 whitespace-pre-line">
                            {{ $suara->description }}
                        </p>
                        
                        <div class="grid md:grid-cols-2 gap-8 mb-10">
                            <!-- Poin Kritis -->
                            <div class="p-8 bg-red-50/50 rounded-3xl border border-red-100/80">
                                <h4 class="font-bold text-slate-900 mb-4 flex items-center gap-2 font-outfit text-base">
                                    <i data-lucide="shield-alert" class="w-5 h-5 text-red-500"></i>
                                    Poin Kritis & Kondisi Lapangan
                                </h4>
                                <ul class="space-y-4 text-sm font-medium text-slate-600 list-none p-0">
                                    <li class="flex gap-3 items-start">
                                        <span class="w-2 h-2 rounded-full bg-red-500 mt-1.5 flex-shrink-0"></span>
                                        <span>Lokasi Masalah: <strong class="text-slate-900">{{ $suara->location ?? 'Tidak ditentukan' }}</strong></span>
                                    </li>
                                    <li class="flex gap-3 items-start">
                                        <span class="w-2 h-2 rounded-full bg-red-500 mt-1.5 flex-shrink-0"></span>
                                        <span>Kategori Isu: <strong class="text-slate-900">{{ $suara->category ?? 'Laporan Warga' }}</strong></span>
                                    </li>
                                    @if($suara->reference_link)
                                        <li class="flex gap-3 items-start">
                                            <span class="w-2 h-2 rounded-full bg-red-500 mt-1.5 flex-shrink-0"></span>
                                            <span class="break-all">Dokumen / Bukti: <a href="{{ $suara->reference_link }}" target="_blank" class="text-accent font-bold hover:underline inline-flex items-center gap-1">Cek Referensi Validasi <i data-lucide="external-link" class="w-3.5 h-3.5"></i></a></span>
                                        </li>
                                    @else
                                        <li class="flex gap-3 items-start">
                                            <span class="w-2 h-2 rounded-full bg-red-500 mt-1.5 flex-shrink-0"></span>
                                            <span>Membutuhkan keterlibatan publik untuk mempercepat penanganan otoritas terkait.</span>
                                        </li>
                                    @endif
                                </ul>
                            </div>

                            <!-- Target Solusi -->
                            <div class="p-8 bg-accent/5 rounded-3xl border border-accent/10">
                                <h4 class="font-bold text-accent mb-4 flex items-center gap-2 font-outfit text-base">
                                    <i data-lucide="target" class="w-5 h-5"></i>
                                    Target Solusi & Harapan
                                </h4>
                                <div class="space-y-4 text-sm font-medium text-slate-700 leading-relaxed">
                                    @if(!empty($suara->expected_impact))
                                        <div class="p-4 bg-white rounded-2xl border border-accent/10 shadow-sm text-slate-900 font-semibold">
                                            "{{ $suara->expected_impact }}"
                                        </div>
                                    @else
                                        <p class="text-slate-500 italic">Mendorong kolaborasi warga dan pemangku kebijakan untuk menyelesaikan isu ini secara tuntas.</p>
                                    @endif

                                    @if($suara->is_fundraising)
                                        <div class="flex items-center gap-2 text-xs font-black text-emerald-600 bg-emerald-50 p-3 rounded-xl ring-1 ring-emerald-100">
                                            <i data-lucide="banknote" class="w-4 h-4"></i>
                                            <span>Target Pendanaan: Rp {{ number_format($suara->fund_target, 0, ',', '.') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <p class="text-slate-600 leading-relaxed">
                            Mari bersatu mengawal isu ini. Setiap dukungan, masukan, dan aksi Anda membawa dampak nyata bagi perubahan sosial di lingkungan sekitar.
                        </p>
                    </article>

                    @php
                        $hasVoted = false;
                        if (auth()->check()) {
                            $hasVoted = \App\Models\SuaraVote::where('user_id', auth()->id())->where('suara_id', $suara->id)->exists();
                        }
                    @endphp

                    <!-- Interaction Options (Kontribusi Bersama) -->
                    <div class="space-y-6">
                        <div class="flex items-center justify-between px-2">
                            <h3 class="text-2xl font-outfit font-extrabold text-slate-900">Kontribusi Bersama</h3>
                            <span class="text-xs font-bold text-slate-400">Pilih bentuk kontribusi Anda</span>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 font-outfit">
                            <!-- Support by Voice -->
                            <button onclick="handleVote('vote')" id="proVoteBtn" 
                                class="group p-6 md:p-8 bg-white rounded-[32px] border border-slate-100 shadow-sm transition-all text-center relative overflow-hidden {{ $hasVoted ? 'opacity-60 cursor-not-allowed' : 'hover:shadow-xl hover:shadow-accent/10 hover:-translate-y-2' }}"
                                {{ $hasVoted ? 'disabled' : '' }}>
                                <div class="w-16 h-16 md:w-20 md:h-20 {{ $hasVoted ? 'bg-slate-100 text-slate-400' : 'bg-accent/5 flex items-center justify-center mx-auto mb-4 md:mb-6 group-hover:bg-accent group-hover:text-white transition-all' }} rounded-[24px] flex items-center justify-center mx-auto mb-4 md:mb-6">
                                     <i data-lucide="{{ $hasVoted ? 'check-circle' : 'megaphone' }}" class="w-8 h-8 md:w-10 md:h-10"></i>
                                </div>
                                <h4 class="font-bold text-base md:text-lg text-slate-900 mb-1">{{ $hasVoted ? 'Didukung' : 'Dukung' }}</h4>
                                <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest mb-3 leading-none">Support by Voice</p>
                                <span id="proCountDisplay" class="text-accent font-black text-2xl md:text-3xl tracking-tighter block text-center w-full">{{ number_format($suara->supporter_count, 0, ',', '.') }}</span>
                            </button>

                            <!-- Support by Voice (KONTRA) -->
                            <button onclick="handleVote('oppose')" id="kontraVoteBtn" 
                                class="group p-6 md:p-8 bg-white rounded-[32px] border border-slate-100 shadow-sm transition-all text-center relative overflow-hidden {{ $hasVoted ? 'opacity-60 cursor-not-allowed' : 'hover:shadow-xl hover:shadow-rose-500/10 hover:-translate-y-2' }}"
                                {{ $hasVoted ? 'disabled' : '' }}>
                                <div class="w-16 h-16 md:w-20 md:h-20 {{ $hasVoted ? 'bg-slate-100 text-slate-400' : 'bg-rose-50 flex items-center justify-center mx-auto mb-4 md:mb-6 group-hover:bg-rose-500 group-hover:text-white transition-all' }} rounded-[24px] flex items-center justify-center mx-auto mb-4 md:mb-6">
                                     <i data-lucide="{{ $hasVoted ? 'check-circle' : 'thumbs-down' }}" class="w-8 h-8 md:w-10 md:h-10"></i>
                                </div>
                                <h4 class="font-bold text-base md:text-lg text-slate-900 mb-1">{{ $hasVoted ? 'Sanggahan' : 'Sanggah' }}</h4>
                                <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest mb-3 leading-none">Support by Kontra</p>
                                <span id="kontraCountDisplay" class="text-rose-500 font-black text-2xl md:text-3xl tracking-tighter block text-center w-full">{{ number_format($suara->opponent_count, 0, ',', '.') }}</span>
                            </button>

                            <!-- Support by Fund -->
                            <div class="p-6 md:p-8 bg-white rounded-[32px] border border-slate-100 shadow-sm text-center">
                                <div class="w-16 h-16 md:w-20 md:h-20 bg-emerald-50 text-emerald-600 rounded-[24px] flex items-center justify-center mx-auto mb-4 md:mb-6">
                                     <i data-lucide="wallet" class="w-8 h-8 md:w-10 md:h-10"></i>
                                </div>
                                <h4 class="font-bold text-base md:text-lg text-slate-900 mb-1">Donasi</h4>
                                <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest mb-3 leading-none">Support by Fund</p>
                                <span class="text-emerald-500 font-black text-xl md:text-2xl tracking-tighter block">
                                    Rp {{ number_format($totalDonation, 0, ',', '.') }}
                                </span>
                            </div>

                            <!-- Support by Action -->
                            <div class="p-6 md:p-8 bg-white rounded-[32px] border border-slate-100 shadow-sm text-center">
                                <div class="w-16 h-16 md:w-20 md:h-20 bg-amber-50 text-amber-500 rounded-[24px] flex items-center justify-center mx-auto mb-4 md:mb-6">
                                     <i data-lucide="users" class="w-8 h-8 md:w-10 md:h-10"></i>
                                </div>
                                <h4 class="font-bold text-base md:text-lg text-slate-900 mb-1">Aksi Relawan</h4>
                                <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest mb-3 leading-none">Support by Action</p>
                                <span class="text-warning font-black text-xl md:text-2xl tracking-tighter block">
                                    {{ $activeMissionsCount > 0 ? $activeMissionsCount . ' Misi Aktif' : ($totalAksi > 0 ? $totalAksi . ' Personel' : '1 Siap Aksi') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Diskusi Publik -->
                    <div class="bg-white rounded-[40px] p-8 md:p-12 shadow-sm border border-slate-100" id="diskusi-publik-section">
                        <h3 class="text-2xl font-outfit font-extrabold text-slate-900 mb-8 flex items-center justify-between">
                            <span>Diskusi Publik</span>
                            <span id="commentCountBadge" class="text-xs font-black uppercase tracking-wider px-3 py-1 bg-accent/10 text-accent rounded-full">
                                {{ $comments->count() }} Komentar
                            </span>
                        </h3>
                        
                        <!-- Comment Form -->
                        <form id="commentForm" onsubmit="handleCommentSubmit(event)" class="flex gap-4 md:gap-6 mb-12">
                            @csrf
                            <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-accent/10 text-accent flex items-center justify-center flex-shrink-0 font-bold overflow-hidden">
                                @if(auth()->check() && auth()->user()->avatar_url)
                                    <img src="{{ auth()->user()->avatar_url }}" class="w-full h-full object-cover">
                                @else
                                    <i data-lucide="user" class="w-6 h-6"></i>
                                @endif
                            </div>
                            <div class="flex-grow space-y-3">
                                <textarea name="comment" id="commentText" placeholder="{{ auth()->check() ? 'Tuliskan tanggapan, bukti tambahan, atau saran solusi Anda...' : 'Silakan masuk ke akun Anda untuk ikut berdiskusi...' }}" {{ !auth()->check() ? 'onclick=toggleAuthModal("login") readonly' : '' }} class="w-full p-5 bg-slate-50 border border-slate-100 rounded-3xl outline-none focus:ring-4 focus:ring-accent/10 focus:bg-white focus:border-accent transition-all min-h-[100px] font-medium text-sm resize-none"></textarea>
                                <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                                    <span class="text-[10px] text-slate-400 font-bold tracking-tight">
                                        <i data-lucide="shield-check" class="w-3.5 h-3.5 inline text-emerald-500"></i> Partisipasi aktif memberikan +5 XP Reputasi
                                    </span>
                                    @auth
                                        <button type="submit" id="btnSubmitComment" class="w-full sm:w-auto bg-primary hover:bg-slate-800 text-white font-black text-xs uppercase tracking-widest px-8 py-3.5 rounded-2xl hover:shadow-lg transition-all active:scale-95 shadow-xl shadow-slate-900/10 flex items-center justify-center gap-2">
                                            <span>Kirim Masukan</span>
                                            <i data-lucide="send" class="w-3.5 h-3.5"></i>
                                        </button>
                                    @else
                                        <button type="button" onclick="toggleAuthModal('login')" class="w-full sm:w-auto bg-accent text-white font-black text-xs uppercase tracking-widest px-8 py-3.5 rounded-2xl hover:bg-accent/90 transition-all flex items-center justify-center gap-2">
                                            <span>Masuk untuk Berpendapat</span>
                                        </button>
                                    @endauth
                                </div>
                            </div>
                        </form>

                        <!-- Comments List -->
                        <div class="space-y-8" id="commentsListContainer">
                            @forelse($comments as $comment)
                                <div class="flex gap-4 md:gap-6 group" id="comment-item-{{ $comment->id }}">
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-accent to-success text-white flex items-center justify-center flex-shrink-0 font-bold overflow-hidden shadow-sm">
                                        @if($comment->user && $comment->user->avatar_url)
                                            <img src="{{ $comment->user->avatar_url }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-xs font-black uppercase">{{ substr($comment->user->name ?? 'Warga', 0, 2) }}</span>
                                        @endif
                                    </div>
                                    <div class="flex-grow border-b border-slate-50 pb-8 transition-transform duration-300">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center gap-2">
                                                <h5 class="font-bold text-slate-900 text-sm md:text-base">{{ $comment->user->name ?? 'Warga Komunitas' }}</h5>
                                                <span class="text-[9px] font-black uppercase px-2 py-0.5 bg-slate-100 text-slate-500 rounded-md">
                                                    {{ $comment->user->level ?? 'Partisipan' }}
                                                </span>
                                            </div>
                                            <span class="text-[11px] font-bold text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-slate-600 font-medium leading-relaxed text-sm whitespace-pre-line">{{ $comment->comment }}</p>
                                        <div class="flex items-center gap-6 mt-4">
                                            <button onclick="handleLikeComment({{ $comment->id }}, this)" class="flex items-center gap-2 text-xs font-black text-slate-400 hover:text-accent transition-colors uppercase tracking-widest">
                                                <i data-lucide="thumbs-up" class="w-4 h-4 text-emerald-500"></i> Setuju (<span class="like-counter">{{ $comment->likes_count ?? 0 }}</span>)
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div id="emptyCommentsState" class="p-10 text-center space-y-3 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                                    <div class="w-12 h-12 bg-white rounded-2xl shadow-sm text-slate-300 flex items-center justify-center mx-auto">
                                        <i data-lucide="message-square" class="w-6 h-6"></i>
                                    </div>
                                    <h5 class="font-bold text-slate-700 text-sm">Belum Ada Diskusi</h5>
                                    <p class="text-xs text-slate-400 max-w-xs mx-auto font-medium">Jadilah yang pertama menyampaikan pendapat atau masukan untuk isu ini!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Info Sidebar (Right) -->
                <div class="lg:col-span-4 space-y-8">
                    <!-- Progress Card -->
                    <div class="bg-white rounded-[32px] p-8 shadow-sm border border-slate-100">
                        @php
                            $total = $suara->supporter_count + $suara->opponent_count;
                            $proPct = $total > 0 ? round(($suara->supporter_count / $total) * 100) : 0;
                        @endphp
                        <div class="flex items-center justify-between mb-6">
                            <span class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Indeks Dukungan</span>
                            <span class="text-accent font-black">{{ $proPct }}%</span>
                        </div>
                        <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden mb-8">
                            <div class="h-full bg-accent rounded-full relative overflow-hidden" style="width: {{ $proPct }}%">
                                <div class="absolute inset-0 bg-white/30 animate-pulse"></div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-sm border-t border-slate-50 pt-6">
                            <div class="text-center flex-1 border-r border-slate-100 px-2">
                                <p class="text-[9px] font-black text-slate-400 mb-1 uppercase tracking-widest">PRO</p>
                                <p id="sidebarProCount" class="text-xl font-black text-slate-900">{{ number_format($suara->supporter_count, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-center flex-1 px-2">
                                <p class="text-[9px] font-black text-slate-400 mb-1 uppercase tracking-widest">KONTRA</p>
                                <p id="sidebarKontraCount" class="text-xl font-black text-rose-500">{{ number_format($suara->opponent_count, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sebarkan Aspirasi (Sidebar Share Widget) -->
                    @php
                        $shareUrl = url()->current();
                        $shareTitle = $suara->title;
                        $shareText = "Ayo kawal bersama aspirasi: \"{$shareTitle}\" di Ruang Suara!\n\n{$shareUrl}";
                        $waUrl = "https://api.whatsapp.com/send?text=" . urlencode($shareText);
                        $xUrl = "https://twitter.com/intent/tweet?text=" . urlencode("Ayo kawal aspirasi: \"{$shareTitle}\"") . "&url=" . urlencode($shareUrl);
                        $fbUrl = "https://www.facebook.com/sharer/sharer.php?u=" . urlencode($shareUrl);
                        $tgUrl = "https://t.me/share/url?url=" . urlencode($shareUrl) . "&text=" . urlencode("Ayo kawal aspirasi: {$shareTitle}");
                    @endphp
                    <div class="bg-white rounded-[32px] p-8 shadow-sm border border-slate-100 space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-50 pb-4">
                            <h4 class="text-lg font-outfit font-black text-slate-900 flex items-center gap-2">
                                <i data-lucide="share-2" class="w-5 h-5 text-accent"></i>
                                Sebarkan Aspirasi
                            </h4>
                            <span class="text-[10px] font-black uppercase tracking-wider text-accent bg-accent/10 px-2.5 py-1 rounded-full">Viral</span>
                        </div>
                        
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">
                            Bantu suara ini didengar lebih banyak orang dengan membagikannya ke jejaring Anda.
                        </p>

                        <!-- Social Quick Buttons -->
                        <div class="grid grid-cols-4 gap-2.5">
                            <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" title="Bagikan ke WhatsApp" class="h-12 flex items-center justify-center bg-[#25D366]/10 hover:bg-[#25D366] text-[#25D366] hover:text-white rounded-2xl transition-all hover:scale-105 active:scale-95">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            </a>
                            <a href="{{ $xUrl }}" target="_blank" rel="noopener noreferrer" title="Bagikan ke X" class="h-12 flex items-center justify-center bg-black/5 hover:bg-black text-slate-800 hover:text-white rounded-2xl transition-all hover:scale-105 active:scale-95">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                            <a href="{{ $fbUrl }}" target="_blank" rel="noopener noreferrer" title="Bagikan ke Facebook" class="h-12 flex items-center justify-center bg-[#1877F2]/10 hover:bg-[#1877F2] text-[#1877F2] hover:text-white rounded-2xl transition-all hover:scale-105 active:scale-95">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            <a href="{{ $tgUrl }}" target="_blank" rel="noopener noreferrer" title="Bagikan ke Telegram" class="h-12 flex items-center justify-center bg-[#24A1DE]/10 hover:bg-[#24A1DE] text-[#24A1DE] hover:text-white rounded-2xl transition-all hover:scale-105 active:scale-95">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                            </a>
                        </div>

                        <!-- One-Click Copy Link -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Salin Tautan</label>
                            <div class="flex items-center gap-2 bg-slate-50 p-1.5 rounded-2xl border border-slate-100">
                                <input type="text" id="shareUrlInputSidebar" value="{{ $shareUrl }}" readonly class="w-full text-xs font-semibold text-slate-600 outline-none bg-transparent pl-2.5 select-all truncate">
                                <button type="button" onclick="copyShareLink('shareUrlInputSidebar', this)" class="copy-link-btn flex items-center gap-1.5 px-4 py-2 bg-accent hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm active:scale-95 flex-shrink-0">
                                    <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                                    <span>Salin</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tim Pengawal -->
                    <div class="bg-white rounded-[32px] p-8 shadow-sm border border-slate-100 space-y-6">
                        <h4 class="text-lg font-outfit font-black text-slate-900 border-b border-slate-50 pb-4">Tim Pengawal</h4>
                        
                        <!-- Inisiator / Creator -->
                        @php $creator = $suara->user ?? null; @endphp
                        <div class="flex items-center gap-4 group">
                            <div class="w-14 h-14 bg-gradient-to-tr from-accent to-blue-700 text-white rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-accent/20 overflow-hidden">
                                @if($creator && $creator->avatar_url)
                                    <img src="{{ $creator->avatar_url }}" class="w-full h-full object-cover">
                                @else
                                    <i data-lucide="user" class="w-6 h-6"></i>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Inisiator Suara</span>
                                <h5 class="font-bold text-slate-900 truncate">{{ $creator->name ?? 'Warga Komunitas' }}</h5>
                                <p class="text-xs text-slate-500">{{ $creator->level ?? 'Partisipan' }} • {{ $suara->location ?? 'Indonesia' }}</p>
                            </div>
                        </div>

                        <!-- Moderator / Verifikator -->
                        <div class="flex items-center gap-4 group">
                            <div class="w-14 h-14 bg-emerald-500 text-white rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-emerald-500/20">
                                <i data-lucide="shield-check" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Moderator</span>
                                <h5 class="font-bold text-slate-900">Tim Suara</h5>
                                <p class="text-xs text-slate-500">Verifikator Publik & AI</p>
                            </div>
                        </div>

                        <!-- Coordinator / Field Leaders or Top Supporters -->
                        @if($topSupporters->isNotEmpty())
                            @php $topSupporter = $topSupporters->first()->user; @endphp
                            @if($topSupporter)
                                <div class="flex items-center gap-4 group">
                                    <div class="w-14 h-14 bg-primary text-white rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-primary/20 overflow-hidden">
                                        @if($topSupporter->avatar_url)
                                            <img src="{{ $topSupporter->avatar_url }}" class="w-full h-full object-cover">
                                        @else
                                            <i data-lucide="crown" class="w-6 h-6 text-amber-400"></i>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Pendukung Teratas</span>
                                        <h5 class="font-bold text-slate-900 truncate">{{ $topSupporter->name }}</h5>
                                        <p class="text-xs text-slate-500">{{ $topSupporter->level ?? 'Warga Aktif' }}</p>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="flex items-center gap-4 group">
                                <div class="w-14 h-14 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="users" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Kolaborasi</span>
                                    <h5 class="font-bold text-slate-900">Warga Terbuka</h5>
                                    <p class="text-xs text-slate-500">Mari bergabung mengawal</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- CTA Bar Mobile -->
                    <div class="fixed bottom-0 left-0 right-0 p-4 bg-white/80 backdrop-blur-xl border-t border-slate-100 md:hidden z-[60]">
                        <button onclick="handleVote('vote')" class="w-full bg-accent text-white font-black py-4 rounded-2xl shadow-xl shadow-accent/20 hover:scale-[1.02] transition-all">Support by Voice</button>
                    </div>
                </div>
            </div>

            <!-- Suara Terkait (Related Issues from Database) -->
            <div class="mt-24">
                <div class="flex items-center justify-between mb-10">
                    <div>
                        <h3 class="text-3xl font-outfit font-extrabold text-slate-900">Suara Terkait</h3>
                        <p class="text-sm text-slate-400 font-medium mt-1">Aspirasi lain dalam kategori yang sama</p>
                    </div>
                    <a href="/suara" class="text-accent font-bold hover:underline text-sm uppercase tracking-wider flex items-center gap-1">
                        <span>Lihat Semua</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
                
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse($relatedSuaras as $relSuara)
                        @php
                            $relImg = 'https://images.unsplash.com/photo-1540553016722-983e48a2cd10?auto=format&fit=crop&q=80&w=800';
                            if ($relSuara->image) {
                                if (str_starts_with($relSuara->image, 'http')) {
                                    $relImg = $relSuara->image;
                                } else if (str_starts_with($relSuara->image, 'images/')) {
                                    $relImg = asset($relSuara->image);
                                } else {
                                    $relImg = asset('storage/' . $relSuara->image);
                                }
                            }
                        @endphp
                        <a href="/suara-detail/{{ $relSuara->id }}" class="bg-white rounded-[32px] overflow-hidden border border-slate-100 shadow-sm group hover:shadow-xl hover:border-accent/30 transition-all flex flex-col justify-between">
                            <div>
                                <div class="h-44 relative overflow-hidden">
                                    <img src="{{ $relImg }}" alt="{{ $relSuara->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                                    <span class="absolute top-4 left-4 bg-white/20 backdrop-blur-md text-white text-[10px] font-black px-3 py-1 rounded-lg border border-white/20 uppercase tracking-widest">{{ $relSuara->category ?? 'Lainnya' }}</span>
                                </div>
                                <div class="p-6">
                                    <h4 class="font-bold text-slate-900 mb-2 line-clamp-2 group-hover:text-accent transition-colors font-outfit text-base">{{ $relSuara->title }}</h4>
                                    <p class="text-xs text-slate-400 font-medium line-clamp-2">{{ $relSuara->description }}</p>
                                </div>
                            </div>
                            <div class="p-6 pt-0 flex items-center justify-between text-xs font-bold border-t border-slate-50 mt-4">
                                <span class="text-slate-400 flex items-center gap-1">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-accent"></i>
                                    {{ $relSuara->location ?? 'Indonesia' }}
                                </span>
                                <span class="text-accent flex items-center gap-1">
                                    <i data-lucide="megaphone" class="w-3.5 h-3.5"></i>
                                    {{ number_format($relSuara->supporter_count, 0, ',', '.') }}
                                </span>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-center p-12 bg-white rounded-[32px] border border-slate-100 text-slate-400">
                            Belum ada suara terkait lainnya.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </main>

    <!-- Footer Mobile Buffer -->
    <div class="h-20 md:hidden"></div>

    <script>
        // Initialize Lucide
        lucide.createIcons();

        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const button = input.nextElementSibling;
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }

        function toggleAuthModal(mode = 'login') {
            const modal = document.getElementById('authModal');
            const backdrop = document.getElementById('modalBackdrop');
            const container = document.getElementById('modalContainer');
            
            if (!modal) return;

            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setAuthTab(mode);
                setTimeout(() => {
                    backdrop.classList.add('opacity-100');
                    container.classList.add('scale-100', 'opacity-100');
                    container.classList.remove('scale-90', 'opacity-0');
                }, 10);
            } else {
                backdrop.classList.remove('opacity-100');
                container.classList.remove('scale-100', 'opacity-100');
                container.classList.add('scale-90', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }, 300);
            }
        }

        function setAuthTab(tab) {
            const loginBtn = document.getElementById('loginTabBtn');
            const signupBtn = document.getElementById('signupTabBtn');
            const loginView = document.getElementById('loginView');
            const signupView = document.getElementById('signupView');
            
            if (!loginBtn || !signupBtn) return;

            if (tab === 'login') {
                loginBtn.classList.add('text-accent', 'border-primary');
                loginBtn.classList.remove('text-slate-400', 'border-transparent');
                signupBtn.classList.remove('text-accent', 'border-primary');
                signupBtn.classList.add('text-slate-400', 'border-transparent');
                if (loginView) loginView.classList.remove('hidden');
                if (signupView) signupView.classList.add('hidden');
            } else {
                signupBtn.classList.add('text-accent', 'border-primary');
                signupBtn.classList.remove('text-slate-400', 'border-transparent');
                loginBtn.classList.remove('text-accent', 'border-primary');
                loginBtn.classList.add('text-slate-400', 'border-transparent');
                if (signupView) signupView.classList.remove('hidden');
                if (loginView) loginView.classList.add('hidden');
            }
        }

        // Auto-open modal based on query parameter
        window.addEventListener('load', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const authType = urlParams.get('auth');
            if (authType === 'login' || authType === 'signup') {
                toggleAuthModal(authType);
            }
        });

        async function handleVote(type) {
            @guest
                toggleAuthModal('login');
                return;
            @endguest

            try {
                const btn = type === 'vote' ? document.getElementById('proVoteBtn') : document.getElementById('kontraVoteBtn');
                btn.classList.add('opacity-50', 'pointer-events-none');

                const response = await fetch(`/suara/{{ $suara->id }}/${type}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                if (response.status === 401) {
                    toggleAuthModal('login');
                    return;
                }

                const data = await response.json();
                               if (data.success) {
                    // Update displays
                    if (type === 'vote') {
                        document.getElementById('proCountDisplay').innerText = data.count;
                        document.getElementById('sidebarProCount').innerText = data.count;
                    } else {
                        document.getElementById('kontraCountDisplay').innerText = data.count;
                        document.getElementById('sidebarKontraCount').innerText = data.count;
                    }                    
                    // Success UI Update
                    btn.classList.add('opacity-60', 'cursor-not-allowed');
                    btn.setAttribute('disabled', 'true');
                    btn.querySelector('h4').innerText = type === 'vote' ? 'Sudah Didukung' : 'Pilihan Tercatat';
                    btn.querySelector('p').innerText = 'Suara Anda Telah Tercatat';
                    const iconBox = btn.querySelector('div');
                    iconBox.className = 'w-20 h-20 bg-slate-100 text-slate-400 rounded-[24px] flex items-center justify-center mx-auto mb-6';
                    iconBox.querySelector('i').setAttribute('data-lucide', 'check-circle');
                    
                    // If one is voted, disable both
                    const otherBtnId = type === 'vote' ? 'kontraVoteBtn' : 'proVoteBtn';
                    const otherBtn = document.getElementById(otherBtnId);
                    if (otherBtn) {
                        otherBtn.classList.add('opacity-60', 'cursor-not-allowed');
                        otherBtn.setAttribute('disabled', 'true');
                    }

                    lucide.createIcons();
                    btn.classList.remove('opacity-50', 'pointer-events-none');
                } else {
                    alert(data.message || 'Gagal memberikan suara');
                    btn.classList.remove('opacity-50', 'pointer-events-none');
                }
            } catch (error) {
                console.error('Error voting:', error);
                const btn = type === 'vote' ? document.getElementById('proVoteBtn') : document.getElementById('kontraVoteBtn');
                btn.classList.remove('opacity-50', 'pointer-events-none');
            }
        }

        async function handleCommentSubmit(e) {
            e.preventDefault();
            @guest
                toggleAuthModal('login');
                return;
            @endguest

            const textarea = document.getElementById('commentText');
            const submitBtn = document.getElementById('btnSubmitComment');
            const commentVal = textarea.value.trim();
            if (!commentVal) return;

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50');
            }

            try {
                const response = await fetch(`/suara/{{ $suara->id }}/comment`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ comment: commentVal })
                });

                if (response.status === 401) {
                    toggleAuthModal('login');
                    return;
                }

                const data = await response.json();
                if (data.success && data.comment) {
                    textarea.value = '';
                    const container = document.getElementById('commentsListContainer');
                    const emptyState = document.getElementById('emptyCommentsState');
                    if (emptyState) emptyState.remove();

                    // Create comment element
                    const newEl = document.createElement('div');
                    newEl.className = 'flex gap-4 md:gap-6 group animate-fadeIn';
                    newEl.id = `comment-item-${data.comment.id}`;

                    const avatarHtml = data.comment.user_avatar 
                        ? `<img src="${data.comment.user_avatar}" class="w-full h-full object-cover">`
                        : `<span class="text-xs font-black uppercase">${data.comment.user_initials}</span>`;

                    newEl.innerHTML = `
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-accent to-success text-white flex items-center justify-center flex-shrink-0 font-bold overflow-hidden shadow-sm">
                            ${avatarHtml}
                        </div>
                        <div class="flex-grow border-b border-slate-50 pb-8 transition-transform duration-300">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <h5 class="font-bold text-slate-900 text-sm md:text-base">${escapeHtml(data.comment.user_name)}</h5>
                                    <span class="text-[9px] font-black uppercase px-2 py-0.5 bg-slate-100 text-slate-500 rounded-md">
                                        ${escapeHtml(data.comment.user_level)}
                                    </span>
                                </div>
                                <span class="text-[11px] font-bold text-slate-400">Baru saja</span>
                            </div>
                            <p class="text-slate-600 font-medium leading-relaxed text-sm whitespace-pre-line">${escapeHtml(data.comment.comment)}</p>
                            <div class="flex items-center gap-6 mt-4">
                                <button onclick="handleLikeComment(${data.comment.id}, this)" class="flex items-center gap-2 text-xs font-black text-slate-400 hover:text-accent transition-colors uppercase tracking-widest">
                                    <i data-lucide="thumbs-up" class="w-4 h-4 text-emerald-500"></i> Setuju (<span class="like-counter">0</span>)
                                </button>
                            </div>
                        </div>
                    `;

                    container.prepend(newEl);
                    lucide.createIcons();

                    // Update count
                    const badge = document.getElementById('commentCountBadge');
                    if (badge) {
                        const currentCount = parseInt(badge.innerText) || 0;
                        badge.innerText = `${currentCount + 1} Komentar`;
                    }
                } else {
                    alert(data.message || 'Gagal mengirim komentar');
                }
            } catch (err) {
                console.error('Error submitting comment:', err);
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50');
                }
            }
        }

        async function handleLikeComment(commentId, btn) {
            try {
                const response = await fetch(`/suara-comment/${commentId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();
                if (data.success) {
                    const counter = btn.querySelector('.like-counter');
                    if (counter) counter.innerText = data.likes_count;
                    btn.classList.add('text-accent');
                }
            } catch (err) {
                console.error('Error liking comment:', err);
            }
        }

        function escapeHtml(text) {
            if (!text) return '';
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.toString().replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        async function copyShareLink(inputId, btn) {
            const input = document.getElementById(inputId);
            const urlToCopy = input ? input.value : window.location.href;

            try {
                if (navigator.clipboard && window.isSecureContext) {
                    await navigator.clipboard.writeText(urlToCopy);
                } else {
                    // Fallback for non-https or older browsers
                    if (input) {
                        input.select();
                        input.setSelectionRange(0, 99999);
                        document.execCommand('copy');
                    }
                }

                // Visual feedback on button
                if (btn) {
                    const originalHtml = btn.innerHTML;
                    btn.innerHTML = `<i data-lucide="check" class="w-3.5 h-3.5 text-emerald-400"></i><span>Tersalin!</span>`;
                    btn.classList.add('bg-emerald-600', 'text-white');
                    lucide.createIcons();

                    setTimeout(() => {
                        btn.innerHTML = originalHtml;
                        btn.classList.remove('bg-emerald-600', 'text-white');
                        lucide.createIcons();
                    }, 2000);
                }

                showShareToast('Tautan berhasil disalin ke clipboard!');
            } catch (err) {
                console.error('Gagal menyalin tautan:', err);
                showShareToast('Tautan telah disorot, silakan salin.');
            }
        }

        async function shareNative(title, url) {
            if (navigator.share) {
                try {
                    await navigator.share({
                        title: title || document.title,
                        text: `Ayo kawal bersama aspirasi: "${title}" di Ruang Suara!`,
                        url: url || window.location.href,
                    });
                } catch (err) {
                    if (err.name !== 'AbortError') {
                        copyShareLink(null, null);
                    }
                }
            } else {
                copyShareLink('shareUrlInputSidebar', null);
            }
        }

        function showShareToast(message) {
            const toast = document.getElementById('shareToastNotification');
            const msgEl = document.getElementById('shareToastMessage');
            if (!toast) return;

            if (msgEl) msgEl.innerText = message;
            toast.classList.remove('translate-y-24', 'opacity-0', 'pointer-events-none');
            toast.classList.add('translate-y-0', 'opacity-100');

            setTimeout(() => {
                toast.classList.add('translate-y-24', 'opacity-0', 'pointer-events-none');
                toast.classList.remove('translate-y-0', 'opacity-100');
            }, 3000);
        }
    </script>
    
    <!-- Auth Modal (Login / Signup) -->
    <div id="authModal" class="fixed inset-0 z-[200] hidden overflow-y-auto px-6 py-12 flex items-center justify-center">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-md opacity-0 transition-opacity duration-300" id="modalBackdrop"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white w-full max-w-md rounded-[48px] shadow-2xl overflow-hidden scale-90 opacity-0 transition-all duration-300 transform" id="modalContainer">
            <!-- Close Button (Repositioned to top right corner of the entire modal, slightly adjusted) -->
            <button onclick="toggleAuthModal()" class="absolute top-6 right-6 w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all z-[50] group shadow-sm">
                <i data-lucide="x" class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300"></i>
            </button>

            <!-- Tabs -->
            <div class="flex border-b border-slate-100 relative pr-16 bg-white">
                <button onclick="setAuthTab('login')" id="loginTabBtn" class="flex-1 py-8 text-sm font-black uppercase tracking-widest text-accent border-b-2 border-primary">Masuk</button>
                <button onclick="setAuthTab('signup')" id="signupTabBtn" class="flex-1 py-8 text-sm font-black uppercase tracking-widest text-slate-400 border-b-2 border-transparent hover:text-accent transition-all">Daftar Akun</button>
            </div>

            <div class="p-8 md:p-10 space-y-8">
                <!-- Login View -->
                <form id="loginView" method="POST" action="/login" class="space-y-6">
                    @csrf
                    @if($errors->has('auth') && session('auth') == 'login')
                        <div class="bg-red-50 text-red-500 text-xs p-3 rounded-xl font-bold">{{ $errors->first('auth') }}</div>
                    @endif
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Email</label>
                        <div class="relative group">
                            <i data-lucide="mail" class="absolute left-6 top-5 w-5 h-5 text-slate-300 group-focus-within:text-accent transition-colors"></i>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com" class="w-full pl-16 pr-8 py-5 bg-slate-50 border border-slate-100 rounded-3xl outline-none focus:ring-4 focus:ring-primary/5 focus:bg-white focus:border-primary transition-all font-medium">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center ml-1">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Password</label>
                            <a href="#" class="text-[10px] font-black text-accent hover:underline">Lupa Password?</a>
                        </div>
                        <div class="relative group">
                            <i data-lucide="lock" class="absolute left-6 top-5 w-5 h-5 text-slate-300 group-focus-within:text-accent transition-colors"></i>
                            <input type="password" name="password" id="loginPassword" required placeholder="••••••••" class="w-full pl-16 pr-14 py-5 bg-slate-50 border border-slate-100 rounded-3xl outline-none focus:ring-4 focus:ring-primary/5 focus:bg-white focus:border-primary transition-all font-medium">
                            <button type="button" onclick="togglePassword('loginPassword')" class="absolute right-6 top-5 text-slate-300 hover:text-accent transition-colors">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-accent py-5 rounded-3xl text-white font-black text-lg shadow-xl shadow-accent/20 hover:scale-[1.02] active:scale-95 transition-all">
                        Masuk Sekarang
                    </button>

                    <!-- Google & Apple Auth (Login Only) -->
                    <div class="space-y-4 pt-4">
                        <div class="relative py-2">
                            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-100"></div></div>
                            <span class="relative bg-white px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mx-auto block w-max">Atau dengan</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('auth.google') }}" class="flex items-center justify-center gap-3 py-4 border border-slate-100 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 hover:border-slate-200 transition-all shadow-sm">
                                <svg class="w-5 h-5" viewBox="0 0 24 24"><path fill="#fbbc05" d="M5.1 12c0-.7.1-1.4.3-2.1L1.1 6.6C.4 8.2 0 10.1 0 12s.4 3.8 1.1 5.4l4.3-3.3c-.2-.7-.3-1.4-.3-2.1z"/><path fill="#ea4335" d="M12 4.1c1.6 0 3.1.6 4.2 1.5l3.1-3.1C17.3 1 14.8 0 12 0 7.3 0 3.3 2.7 1.1 6.6L5.4 9.9c1.1-3.3 4.2-5.8 6.6-5.8z"/><path fill="#34a853" d="M12 19.9c-2.4 0-4.5-2.5-5.6-5.8L2.1 17.4C4.3 21.3 8.3 24 13 24c3.4 0 6.2-1.1 8.3-2.9l-4.1-3.1c-1.2.8-2.6 1.1-4.2 1.1z"/><path fill="#4285f4" d="M24 12c0-.8-.1-1.7-.2-2.5H12v4.8h6.8c-.3 1.5-1.1 2.8-2.4 3.6l4.1 3.1c2.4-2.1 4.5-5.2 4.5-9z"/></svg>
                                <span class="text-xs font-bold">Google</span>
                            </a>
                            <button type="button" class="flex items-center justify-center gap-3 py-4 border border-slate-100 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 transition-all">
                                <i data-lucide="apple" class="w-5 h-5"></i>
                                <span class="text-xs font-bold">Apple ID</span>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Signup View -->
                <form id="signupView" method="POST" action="/signup" class="hidden space-y-6">
                    @csrf
                    @if($errors->any() && (!session('auth') || session('auth') != 'login'))
                        <div class="bg-red-50 text-red-500 text-xs p-3 rounded-xl font-bold">Terdapat kesalahan pada input Anda. Silakan periksa kembali.</div>
                    @endif
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Nama Lengkap</label>
                        <div class="relative group">
                            <i data-lucide="user" class="absolute left-6 top-5 w-5 h-5 text-slate-300 group-focus-within:text-accent transition-colors"></i>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama lengkap" class="w-full pl-16 pr-8 py-5 bg-slate-50 border border-slate-100 rounded-3xl outline-none focus:ring-4 focus:ring-primary/5 focus:bg-white focus:border-primary transition-all font-medium">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Email</label>
                        <div class="relative group">
                            <i data-lucide="mail" class="absolute left-6 top-5 w-5 h-5 text-slate-300 group-focus-within:text-accent transition-colors"></i>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com" class="w-full pl-16 pr-8 py-5 bg-slate-50 border border-slate-100 rounded-3xl outline-none focus:ring-4 focus:ring-primary/5 focus:bg-white focus:border-primary transition-all font-medium">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Password</label>
                        <div class="relative group">
                            <i data-lucide="lock" class="absolute left-6 top-5 w-5 h-5 text-slate-300 group-focus-within:text-accent transition-colors"></i>
                            <input type="password" name="password" id="signupPassword" required placeholder="Min. 8 Karakter" class="w-full pl-16 pr-14 py-5 bg-slate-50 border border-slate-100 rounded-3xl outline-none focus:ring-4 focus:ring-primary/5 focus:bg-white focus:border-primary transition-all font-medium">
                            <button type="button" onclick="togglePassword('signupPassword')" class="absolute right-6 top-5 text-slate-300 hover:text-accent transition-colors">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Konfirmasi Password</label>
                        <div class="relative group">
                            <i data-lucide="check-circle" class="absolute left-6 top-5 w-5 h-5 text-slate-300 group-focus-within:text-accent transition-colors"></i>
                            <input type="password" name="password_confirmation" id="signupConfirmPassword" required placeholder="Ulangi Password" class="w-full pl-16 pr-14 py-5 bg-slate-50 border border-slate-100 rounded-3xl outline-none focus:ring-4 focus:ring-primary/5 focus:bg-white focus:border-primary transition-all font-medium">
                            <button type="button" onclick="togglePassword('signupConfirmPassword')" class="absolute right-6 top-5 text-slate-300 hover:text-accent transition-colors">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-accent py-5 rounded-3xl text-white font-black text-lg shadow-xl shadow-accent/20 hover:scale-[1.02] active:scale-95 transition-all mt-4">
                        Daftar Secepatnya
                    </button>
                </form>
            </div>
        </div>
    </div>


    <!-- Share / Copy Link Toast Notification -->
    <div id="shareToastNotification" class="fixed bottom-8 right-8 z-[250] bg-slate-900 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 border border-slate-700/50 transform translate-y-24 opacity-0 pointer-events-none transition-all duration-300 ease-out font-outfit">
        <div class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-200" id="shareToastMessage">Tautan berhasil disalin ke clipboard!</p>
        </div>
    </div>

</body>
</html>
