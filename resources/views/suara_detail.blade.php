<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Suara — Suara</title>
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
        <nav class="container mx-auto px-6 py-4 flex items-center justify-between">
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
                                
                                <svg class="w-full h-full p-2" viewBox="0 0 100 100">
                                    <defs>
                                        <linearGradient id="navAvatarGradGlobal" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" style="stop-color:#2563EB;stop-opacity:1" />
                                            <stop offset="100%" style="stop-color:#10B981;stop-opacity:1" />
                                        </linearGradient>
                                    </defs>
                                    <path fill="url(#navAvatarGradGlobal)" d="M50 50c11.046 0 20-8.954 20-20s-8.954-20-20-20-20 8.954-20 20 8.954 20 20 20zm0 10c-16.569 0-30 13.431-30 30h60c0-16.569-13.431-30-30-30z" opacity="0.8" />
                                </svg>
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

    <main class="max-w-7xl mx-auto pb-24">
               <!-- Hero Section -->
        <section class="p-4 md:p-8">
            <div class="relative w-full aspect-[16/9] md:aspect-[21/9] rounded-[32px] overflow-hidden shadow-2xl mb-12">
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
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>
                
                <div class="absolute bottom-8 left-8 right-8 text-white">
                    <div class="flex flex-wrap gap-3 mb-6">
                        <span class="px-4 py-1.5 bg-accent text-white text-[10px] font-black uppercase tracking-widest rounded-full shadow-lg shadow-accent/20">{{ $suara->category }}</span>
                        <span class="px-4 py-1.5 bg-white/20 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-widest rounded-full border border-white/30 flex items-center gap-2">
                            <i data-lucide="map-pin" class="w-3 h-3 text-emerald-400"></i> {{ $suara->location }}
                        </span>
                    </div>
                    <h2 class="text-3xl md:text-5xl font-outfit font-extrabold mb-4 leading-tight tracking-tight uppercase ">{{ $suara->title }}</h2>
                    <div class="flex items-center gap-3 text-slate-300 font-medium">
                        <div class="flex -space-x-2">
                            <img class="w-8 h-8 rounded-full border-2 border-white/20" src="https://i.pravatar.cc/100?u=1" alt="">
                            <img class="w-8 h-8 rounded-full border-2 border-white/20" src="https://i.pravatar.cc/100?u=2" alt="">
                            <div class="w-8 h-8 rounded-full border-2 border-white/20 bg-accent flex items-center justify-center text-[10px] font-bold">+9</div>
                        </div>
                        <span class="text-sm">Didukung oleh {{ number_format($suara->supporter_count, 0, ',', '.') }}+ Voices</span>
                    </div>
                </div>
            </div>

            <!-- Heat Index Timeline -->
            <div class="bg-white rounded-[32px] p-8 md:p-12 shadow-sm border border-slate-100 mb-12 overflow-hidden">
                <div class="flex items-center justify-between mb-10">
                    <h3 class="text-xl font-outfit font-bold text-slate-800 flex items-center gap-3">
                        <i data-lucide="activity" class="text-accent w-6 h-6"></i>
                        Heat Index Timeline
                    </h3>
                    <div class="flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold ring-1 ring-emerald-100">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></span>
                        Status: Sedang Berlangsung
                    </div>
                </div>

                <!-- Horizontal Scrollable Timeline on Mobile -->
                <div class="overflow-x-auto pb-6 custom-scrollbar">
                    <div class="flex items-start min-w-[1000px] justify-between relative px-4">
                        <!-- Step 1 (Done) -->
                        <div class="flex flex-col items-center text-center w-32 relative z-10">
                            <div class="w-12 h-12 rounded-full bg-accent text-white flex items-center justify-center mb-4 shadow-lg shadow-accent/30 ring-4 ring-white">
                                <i data-lucide="alert-circle" class="w-6 h-6"></i>
                            </div>
                            <span class="text-xs font-black uppercase tracking-widest text-accent mb-1">Issue</span>
                            <span class="text-[10px] font-bold text-slate-400">12 Jan 2026</span>
                            <div class="absolute top-6 left-1/2 w-full h-1 bg-accent -z-10"></div>
                        </div>

                        <!-- Step 2 (Done) -->
                        <div class="flex flex-col items-center text-center w-32 relative z-10">
                            <div class="w-12 h-12 rounded-full bg-accent text-white flex items-center justify-center mb-4 shadow-lg shadow-accent/30 ring-4 ring-white animate-subtle">
                                <i data-lucide="megaphone" class="w-6 h-6"></i>
                            </div>
                            <span class="text-xs font-black uppercase tracking-widest text-accent mb-1">Aspiration</span>
                            <span class="text-[10px] font-bold text-slate-400">1 Feb 2026</span>
                            <div class="absolute top-6 left-1/2 w-full h-1 bg-accent -z-10"></div>
                        </div>

                        <!-- Step 3 (Active) -->
                        <div class="flex flex-col items-center text-center w-32 relative z-10">
                            <div class="w-14 h-14 rounded-full bg-white border-4 border-accent text-accent flex items-center justify-center mb-4 shadow-xl shadow-accent/10 ring-4 ring-white scale-110">
                                <i data-lucide="scale" class="w-7 h-7"></i>
                            </div>
                            <span class="text-xs font-black uppercase tracking-widest text-slate-900 mb-1">Decision</span>
                            <span class="text-[10px] font-bold text-accent">Sedang Proses</span>
                            <div class="absolute top-7 left-1/2 w-full h-1 bg-slate-100 -z-10"></div>
                        </div>

                        <!-- Step 4 (Future) -->
                        <div class="flex flex-col items-center text-center w-32 relative z-10">
                            <div class="w-12 h-12 rounded-full bg-slate-50 border border-slate-200 text-slate-300 flex items-center justify-center mb-4 ring-4 ring-white">
                                <i data-lucide="check-circle" class="w-6 h-6"></i>
                            </div>
                            <span class="text-xs font-black uppercase tracking-widest text-slate-400 mb-1">Realized</span>
                            <span class="text-[10px] font-bold text-slate-300">Mendatang</span>
                            <div class="absolute top-6 left-1/2 w-full h-1 bg-slate-100 -z-10"></div>
                        </div>

                        <!-- Step 5 (Future) -->
                        <div class="flex flex-col items-center text-center w-32 relative z-10">
                            <div class="w-12 h-12 rounded-full bg-slate-50 border border-slate-200 text-slate-300 flex items-center justify-center mb-4 ring-4 ring-white">
                                <i data-lucide="fast-forward" class="w-6 h-6"></i>
                            </div>
                            <span class="text-xs font-black uppercase tracking-widest text-slate-400 mb-1">Next Steps</span>
                            <div class="absolute top-6 left-1/2 w-full h-1 bg-slate-100 -z-10"></div>
                        </div>

                        <!-- Step 6 (Future) -->
                        <div class="flex flex-col items-center text-center w-32 relative z-10">
                            <div class="w-12 h-12 rounded-full bg-slate-50 border border-slate-200 text-slate-300 flex items-center justify-center mb-4 ring-4 ring-white">
                                <i data-lucide="zap" class="w-6 h-6"></i>
                            </div>
                            <span class="text-xs font-black uppercase tracking-widest text-slate-400 mb-1">Action Taken</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-12">
                <!-- Main Content (Left) -->
                <div class="lg:col-span-2 space-y-12">
                    <!-- Issue Description -->
                    <article class="bg-white rounded-[40px] p-8 md:p-12 shadow-sm border border-slate-100 prose prose-slate max-w-none">
                        <h2 class="text-3xl font-outfit font-extrabold text-slate-900 mb-8">Deskripsi Masalah</h2>
                        <p class="text-slate-600 leading-relaxed text-lg mb-8 ">
                            {{ $suara->description }}
                        </p>
                        <div class="grid md:grid-cols-2 gap-8 mb-10">
                            <div class="p-8 bg-slate-50 rounded-3xl border border-slate-100">
                                <h4 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                                    <i data-lucide="shield-alert" class="w-5 h-5 text-red-500"></i>
                                    Poin Kritis
                                </h4>
                                <ul class="space-y-4 text-sm font-medium text-slate-600 list-none p-0">
                                    <li class="flex gap-3"><span class="w-1.5 h-1.5 rounded-full bg-red-400 mt-2 flex-shrink-0"></span> Tangga utama telah miring 15 derajat</li>
                                    <li class="flex gap-3"><span class="w-1.5 h-1.5 rounded-full bg-red-400 mt-2 flex-shrink-0"></span> Kabel listrik terkelupas di pegangan besi</li>
                                    <li class="flex gap-3"><span class="w-1.5 h-1.5 rounded-full bg-red-400 mt-2 flex-shrink-0"></span> Rawan aksi kriminal saat malam hari</li>
                                </ul>
                            </div>
                            <div class="p-8 bg-accent/5 rounded-3xl border border-accent/10">
                                <h4 class="font-bold text-accent mb-4 flex items-center gap-2">
                                    <i data-lucide="target" class="w-5 h-5"></i>
                                    Target Solusi
                                </h4>
                                <ul class="space-y-4 text-sm font-medium text-slate-600 list-none p-0">
                                    <li class="flex gap-3"><span class="w-1.5 h-1.5 rounded-full bg-accent mt-2 flex-shrink-0"></span> Renovasi total struktur utama</li>
                                    <li class="flex gap-3"><span class="w-1.5 h-1.5 rounded-full bg-accent mt-2 flex-shrink-0"></span> Pemasangan 12 lampu solar LED</li>
                                    <li class="flex gap-3"><span class="w-1.5 h-1.5 rounded-full bg-accent mt-2 flex-shrink-0"></span> CCTV terintegrasi ke pos polisi</li>
                                </ul>
                            </div>
                        </div>
                        <p class="text-slate-600 leading-relaxed">
                            Kami mengajak seluruh elemen masyarakat, khususnya pengguna jalan di area ini, untuk bersatu mendesak pihak berkepentingan agar segera melakukan tindakan nyata sebelum terjadi hal-hal yang tidak diinginkan.
                        </p>
                    </article>

                    @php
                        $hasVoted = false;
                        if (auth()->check()) {
                            $hasVoted = \App\Models\SuaraVote::where('user_id', auth()->id())->where('suara_id', $suara->id)->exists();
                        }
                    @endphp
                    <!-- Interaction Options -->
                    <div class="space-y-6">
                        <h3 class="text-2xl font-outfit font-extrabold text-slate-900 px-4">Kontribusi Bersama</h3>
                        <div class="grid sm:grid-cols-4 gap-4 font-outfit">
                            <!-- Support by Voice -->
                            <button onclick="handleVote('vote')" id="proVoteBtn" 
                                class="group p-8 bg-white rounded-[32px] border border-slate-100 shadow-sm transition-all text-center relative overflow-hidden {{ $hasVoted ? 'opacity-60 cursor-not-allowed' : 'hover:shadow-xl hover:shadow-accent/10 hover:-translate-y-2' }}"
                                {{ $hasVoted ? 'disabled' : '' }}>
                                <div class="w-20 h-20 {{ $hasVoted ? 'bg-slate-100 text-slate-400' : 'bg-accent/5 flex items-center justify-center mx-auto mb-6 group-hover:bg-accent group-hover:text-white transition-all' }} rounded-[24px] flex items-center justify-center mx-auto mb-6">
                                     <i data-lucide="{{ $hasVoted ? 'check-circle' : 'megaphone' }}" class="w-10 h-10"></i>
                                </div>
                                <h4 class="font-bold text-lg text-slate-900 mb-1">{{ $hasVoted ? 'Sudah Didukung' : 'Dukung' }}</h4>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-4 leading-none">{{ $hasVoted ? 'Suara Anda Telah Tercatat' : 'Support by Voice' }}</p>
                                <span id="proCountDisplay" class="text-accent font-black text-3xl  tracking-tighter block text-center w-full">{{ number_format($suara->supporter_count, 0, ',', '.') }}</span>
                            </button>

                            <!-- Support by Voice (KONTRA) -->
                            <button onclick="handleVote('oppose')" id="kontraVoteBtn" 
                                class="group p-8 bg-white rounded-[32px] border border-slate-100 shadow-sm transition-all text-center relative overflow-hidden {{ $hasVoted ? 'opacity-60 cursor-not-allowed' : 'hover:shadow-xl hover:shadow-rose-500/10 hover:-translate-y-2' }}"
                                {{ $hasVoted ? 'disabled' : '' }}>
                                <div class="w-20 h-20 {{ $hasVoted ? 'bg-slate-100 text-slate-400' : 'bg-rose-50 flex items-center justify-center mx-auto mb-6 group-hover:bg-rose-500 group-hover:text-white transition-all' }} rounded-[24px] flex items-center justify-center mx-auto mb-6">
                                     <i data-lucide="{{ $hasVoted ? 'check-circle' : 'thumbs-down' }}" class="w-10 h-10"></i>
                                </div>
                                <h4 class="font-bold text-lg text-slate-900 mb-1">{{ $hasVoted ? 'Pilihan Tercatat' : 'Sanggah' }}</h4>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-4 leading-none">{{ $hasVoted ? 'Suara Anda Telah Tercatat' : 'Support by Kontra' }}</p>
                                <span id="kontraCountDisplay" class="text-rose-500 font-black text-3xl  tracking-tighter block text-center w-full">{{ number_format($suara->opponent_count, 0, ',', '.') }}</span>
                            </button>

                            <!-- Support by Fund -->
                            <button class="group p-8 bg-white rounded-[32px] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-emerald-500/10 hover:-translate-y-2 transition-all text-center">
                                <div class="w-20 h-20 bg-emerald-50 rounded-[24px] flex items-center justify-center mx-auto mb-6 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                                     <i data-lucide="wallet" class="w-10 h-10"></i>
                                </div>
                                <h4 class="font-bold text-lg text-slate-900 mb-1">Donasi</h4>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-4 leading-none">Support by Fund</p>
                                <span class="text-emerald-500 font-black text-3xl group-hover:scale-110 transition-transform  tracking-tighter block">Rp 45.2M</span>
                            </button>

                            <!-- Support by Action -->
                            <button class="group p-8 bg-white rounded-[32px] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-amber-500/10 hover:-translate-y-2 transition-all text-center">
                                <div class="w-20 h-20 bg-amber-50 rounded-[24px] flex items-center justify-center mx-auto mb-6 group-hover:bg-amber-500 group-hover:text-white transition-all">
                                     <i data-lucide="users" class="w-10 h-10"></i>
                                </div>
                                <h4 class="font-bold text-lg text-slate-900 mb-1">Terjun</h4>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-4 leading-none">Support by Action</p>
                                <span class="text-warning font-black text-3xl  tracking-tighter block">142 Aktif</span>
                            </button>
                        </div>
                    </div>

                    <!-- Comment Section -->
                    <div class="bg-white rounded-[40px] p-8 md:p-12 shadow-sm border border-slate-100">
                        <h3 class="text-2xl font-outfit font-extrabold text-slate-900 mb-10 flex items-center justify-between">
                            Diskusi Publik
                            <span class="text-sm font-bold text-slate-400">124 Komentar</span>
                        </h3>
                        
                        <div class="flex gap-6 mb-12">
                            <img src="https://ui-avatars.com/api/?name=User&background=2563EB&color=fff" class="w-14 h-14 rounded-2xl flex-shrink-0" alt="Avatar">
                            <div class="flex-grow space-y-4">
                                <textarea placeholder="Berikan pendapat atau masukan Anda..." class="w-full p-6 bg-slate-50 border border-slate-100 rounded-3xl outline-none focus:ring-4 focus:ring-accent/10 focus:bg-white focus:border-accent transition-all min-h-[120px] font-medium"></textarea>
                                <div class="flex justify-end">
                                    <button class="bg-primary text-white font-bold px-10 py-4 rounded-2xl hover:bg-slate-800 hover:shadow-lg transition-all active:scale-95 shadow-xl shadow-slate-900/10">Kirim Masukan</button>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-10">
                            <!-- Single Comment -->
                            <div class="flex gap-6 group">
                                <img src="https://i.pravatar.cc/100?u=a" class="w-12 h-12 rounded-2xl flex-shrink-0" alt="User">
                                <div class="flex-grow border-b border-slate-50 pb-8 transition-transform duration-300 group-hover:translate-x-2">
                                    <div class="flex items-center justify-between mb-2">
                                        <h5 class="font-bold text-slate-900">Aris Prastyo</h5>
                                        <span class="text-xs font-bold text-slate-400">2 Jam Lalu</span>
                                    </div>
                                    <p class="text-slate-600 font-medium leading-relaxed">Sangat setuju! JPO ini tiap pagi ramai sekali sama anak sekolah. Takut banget kalo tiba-tiba ada pijakan yang jebol.</p>
                                    <div class="flex items-center gap-6 mt-4">
                                        <button class="flex items-center gap-2 text-xs font-black text-slate-400 hover:text-accent transition-colors uppercase tracking-widest">
                                            <i data-lucide="thumbs-up" class="w-4 h-4 text-emerald-500"></i> Setuju (24)
                                        </button>
                                        <button class="text-xs font-black text-slate-400 hover:text-accent transition-colors uppercase tracking-widest">Balas</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Comment -->
                            <div class="flex gap-6 group">
                                <img src="https://i.pravatar.cc/100?u=b" class="w-12 h-12 rounded-2xl flex-shrink-0" alt="User">
                                <div class="flex-grow border-b border-slate-50 pb-8 transition-transform duration-300 group-hover:translate-x-2">
                                    <div class="flex items-center justify-between mb-2">
                                        <h5 class="font-bold text-slate-900">Siti Rahmawati</h5>
                                        <span class="text-xs font-bold text-slate-400">5 Jam Lalu</span>
                                    </div>
                                    <p class="text-slate-600 font-medium leading-relaxed">Bukan cuma infrastruktur, pencahayaan juga krusial bgt. Kalo malem gelap bgt, sering ada penodongan di situ.</p>
                                    <div class="flex items-center gap-6 mt-4">
                                        <button class="flex items-center gap-2 text-xs font-black text-slate-400 hover:text-accent transition-colors uppercase tracking-widest">
                                            <i data-lucide="thumbs-up" class="w-4 h-4"></i> Setuju (8)
                                        </button>
                                        <button class="text-xs font-black text-slate-400 hover:text-accent transition-colors uppercase tracking-widest">Balas</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Sidebar (Right) -->
                <div class="space-y-8">
                    <!-- Progress Card -->
                    <div class="bg-white rounded-[32px] p-8 shadow-sm border border-slate-100">
                        @php
                            $total = $suara->supporter_count + $suara->opponent_count;
                            $proPct = $total > 0 ? round(($suara->supporter_count / $total) * 100) : 0;
                        @endphp
                        <div class="flex items-center justify-between mb-6">
                            <span class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Support Percentage</span>
                            <span class="text-accent font-black">{{ $proPct }}%</span>
                        </div>
                        <div class="w-full h-3 bg-slate-50 rounded-full overflow-hidden mb-8">
                            <div class="h-full bg-accent rounded-full w-[{{ $proPct }}%] relative overflow-hidden">
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

                    <!-- Stakeholders Info -->
                    <div class="bg-white rounded-[32px] p-8 shadow-sm border border-slate-100 space-y-8">
                        <h4 class="text-lg font-outfit font-black text-slate-900 border-b border-slate-50 pb-4">Tim Pengawal</h4>
                        
                        <!-- Creator -->
                        <div class="flex items-center gap-4 group cursor-pointer">
                            <div class="w-14 h-14 bg-accent text-white rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                <i data-lucide="user" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Creator</span>
                                <h5 class="font-bold text-slate-900">Budi Santoso</h5>
                                <p class="text-xs text-slate-500">Aliansi Warga Peduli Cileungsi</p>
                            </div>
                        </div>

                        <!-- Moderator -->
                        <div class="flex items-center gap-4 group cursor-pointer">
                            <div class="w-14 h-14 bg-emerald-500 text-white rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                <i data-lucide="shield-check" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Moderator</span>
                                <h5 class="font-bold text-slate-900">Tim Suara</h5>
                                <p class="text-xs text-slate-500">Verifikator Independen</p>
                            </div>
                        </div>

                        <!-- Coordinator -->
                        <div class="flex items-center gap-4 group cursor-pointer">
                            <div class="w-14 h-14 bg-primary text-white rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                <i data-lucide="crown" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Coordinator</span>
                                <h5 class="font-bold text-slate-900">H. Ridwan Hakim</h5>
                                <p class="text-xs text-slate-500">Ketua RW 08 Cileungsi</p>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Bar Mobile -->
                    <div class="fixed bottom-0 left-0 right-0 p-4 bg-white/80 backdrop-blur-xl border-t border-slate-100 md:hidden z-[60]">
                        <button onclick="handleVote('vote')" class="w-full bg-accent text-white font-black py-4 rounded-2xl shadow-xl shadow-accent/20 hover:scale-[1.02] transition-all">Support by Voice</button>
                    </div>
                </div>
            </div>

            <!-- Related Suggestions -->
            <div class="mt-24">
                <div class="flex items-center justify-between mb-10">
                    <h3 class="text-3xl font-outfit font-extrabold text-slate-900">Suara Terkait</h3>
                    <a href="/suara" class="text-accent font-bold hover:underline">Lihat Semua</a>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Related 1 -->
                    <div class="bg-white rounded-[32px] overflow-hidden border border-slate-100 shadow-sm group hover:shadow-xl transition-all cursor-pointer">
                        <div class="h-44 relative">
                            <img src="https://images.unsplash.com/photo-1544333346-64e4ba984fa3?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                            <span class="absolute top-4 left-4 bg-white/20 backdrop-blur-md text-white text-[10px] font-black p-2 rounded-lg border border-white/20">Lingkungan</span>
                        </div>
                        <div class="p-8">
                            <h4 class="font-bold text-slate-900 mb-4 line-clamp-1 group-hover:text-accent transition-colors">Program Bersih-Bersih Kali Indonesia</h4>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-400">Jakarta Utara</span>
                                <span class="text-emerald-500 font-bold text-xs uppercase tracking-widest">Active</span>
                            </div>
                        </div>
                    </div>
                    <!-- Related 2 -->
                    <div class="bg-white rounded-[32px] overflow-hidden border border-slate-100 shadow-sm group hover:shadow-xl transition-all cursor-pointer">
                        <div class="h-44 relative">
                            <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                            <span class="absolute top-4 left-4 bg-white/20 backdrop-blur-md text-white text-[10px] font-black p-2 rounded-lg border border-white/20">Pendidikan</span>
                        </div>
                        <div class="p-8">
                            <h4 class="font-bold text-slate-900 mb-4 line-clamp-1 group-hover:text-accent transition-colors">Donasi Gadget Layak Pakai Pelosok</h4>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-400">Malang</span>
                                <span class="text-emerald-500 font-bold text-xs uppercase tracking-widest">Active</span>
                            </div>
                        </div>
                    </div>
                    <!-- Related 3 -->
                    <div class="bg-white rounded-[32px] overflow-hidden border border-slate-100 shadow-sm group hover:shadow-xl transition-all cursor-pointer">
                        <div class="h-44 relative">
                            <img src="https://images.unsplash.com/photo-1585822719534-90ae8669c6fc?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                            <span class="absolute top-4 left-4 bg-white/20 backdrop-blur-md text-white text-[10px] font-black p-2 rounded-lg border border-white/20">Lainnya</span>
                        </div>
                        <div class="p-8">
                            <h4 class="font-bold text-slate-900 mb-4 line-clamp-1 group-hover:text-accent transition-colors">Revitalisasi Taman Kota Terbengkalai</h4>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-400">Bandung</span>
                                <span class="text-emerald-500 font-bold text-xs uppercase tracking-widest">Active</span>
                            </div>
                        </div>
                    </div>
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


</body>
</html>
