<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Saya — Suara</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0F172A',
                        accent: '#2563EB',  // Elegant Blue
                        success: '#10B981', // Forest Green
                        warning: '#F59E0B', // Gold/Amber
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
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.4);
        }
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        .card-prominent {
            background: #ffffff;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
            border: 1px solid #e2e8f0;
        }
        .xp-gradient {
            background: linear-gradient(90deg, #2563EB, #10B981);
        }
        .tab-active {
            color: #2563EB;
            border-bottom: 2px solid #2563EB;
        }
        @keyframes slide-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: slide-in 0.5s ease-out forwards;
        }
        .custom-scrollbar::-webkit-scrollbar {
            height: 4px;
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #E2E8F0;
            border-radius: 10px;
            @keyframes float-up {
            0% { opacity: 0; transform: translateY(0) scale(0.9); }
            20% { opacity: 1; transform: translateY(-10px) scale(1.1); }
            80% { opacity: 1; transform: translateY(-25px) scale(1); }
            100% { opacity: 0; transform: translateY(-40px) scale(1); }
        }
        .animate-float-up { animation: float-up 1.2s ease-out forwards; }
        
        .shine-sweep {
            position: relative;
            overflow: hidden;
        }
        .shine-sweep::after {
            content: '';
            position: absolute;
            top: -50%; left: -50%; width: 200%; height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
            transform: rotate(45deg);
            transition: 0.5s;
        }
        .shine-sweep:hover::after { left: 100%; transition: 0.8s; }
        
        @keyframes pulse-gold {
            0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4); }
            70% { box-shadow: 0 0 0 15px rgba(245, 158, 11, 0); }
            100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
        }
        .pulse-gold { animation: pulse-gold 2s infinite; }

        /* Badge Shapes */
        .badge-hexagon { clip-path: polygon(25% 0%, 75% 0%, 100% 50%, 75% 100%, 25% 100%, 0% 50%); }
        .badge-shield { clip-path: polygon(0% 0%, 100% 0%, 100% 80%, 50% 100%, 0% 80%); }
        .badge-diamond { clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%); }

        /* Effects */
        .glow-soft { filter: drop-shadow(0 0 8px currentColor); }
        .glow-heavy { filter: drop-shadow(0 0 15px currentColor); }
        
        @keyframes pulse-badge {
            0% { transform: scale(1); }
            50% { transform: scale(1.08); }
            100% { transform: scale(1); }
        }
        .animate-pulse-badge { animation: pulse-badge 2s infinite ease-in-out; }

        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        .shimmer-gold {
            background: linear-gradient(90deg, #F59E0B 0%, #FFD700 25%, #FFFFFF 50%, #FFD700 75%, #F59E0B 100%);
            background-size: 200% auto;
            animation: shimmer 4s linear infinite;
        }
    </style>
</head>
<body class="bg-[#F8FAFC] font-sans text-slate-900 selection:bg-accent/10 selection:text-accent overflow-x-hidden" 
      x-data="dashboard">
    <!-- Global SVG Assets -->
    <svg style="position: absolute; width: 0; height: 0; overflow: hidden;" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <linearGradient id="avatarGrad1" x1="50" y1="15" x2="50" y2="55" gradientUnits="userSpaceOnUse">
                <stop stop-color="#BFDBFE" />
                <stop offset="1" stop-color="#2563EB" />
            </linearGradient>
            <linearGradient id="avatarGrad2" x1="50" y1="65" x2="50" y2="95" gradientUnits="userSpaceOnUse">
                <stop stop-color="#93C5FD" />
                <stop offset="1" stop-color="#1E40AF" />
            </linearGradient>
            <!-- Navbar specific -->
            <linearGradient id="navAvatarGrad1" x1="50" y1="15" x2="50" y2="55" gradientUnits="userSpaceOnUse">
                <stop stop-color="#93C5FD" />
                <stop offset="1" stop-color="#2563EB" />
            </linearGradient>
            <linearGradient id="navAvatarGrad2" x1="50" y1="65" x2="50" y2="95" gradientUnits="userSpaceOnUse">
                <stop stop-color="#DBEAFE" />
                <stop offset="1" stop-color="#3B82F6" />
            </linearGradient>
        </defs>
    </svg>

    <!-- Header / Navbar (Fixed on Top) -->
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

            <!-- User Module (Kanan) -->
            <div class="flex items-center gap-4">
                <div class="relative flex items-center gap-3 pl-4 border-l border-slate-100 group" x-data="{ userOpen: false }" @mouseenter="userOpen = true" @mouseleave="userOpen = false">
                    <div class="flex items-center gap-3 focus:outline-none group cursor-pointer py-2">
                        <div class="text-right hidden sm:block">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Selamat Datang,</p>
                            <p class="text-sm font-bold text-slate-900">{{ $user->name ?? 'Dimi Octora' }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-accent to-success p-0.5 shadow-lg shadow-accent/20 group-hover:scale-110 transition-transform overflow-hidden relative">
                             <div class="relative w-full h-full rounded-[14px] bg-white flex items-center justify-center overflow-hidden">
                                @if($user->avatar_url)
                                    <img id="navbarAvatarImg" src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover global-user-avatar">
                                @else
                                    <div id="navbarAvatarSvg" class="w-full h-full flex items-center justify-center">
                                        <svg class="w-full h-full" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="50" cy="35" r="20" fill="url(#navAvatarGrad1)" />
                                            <path d="M20,85 Q50,60 80,85 L80,100 L20,100 Z" fill="url(#navAvatarGrad2)" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Dropdown Menu (Smaller & Hover Triggered) -->
                    <div class="absolute right-0 top-full pt-2 w-52 z-[110]"
                         x-show="userOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                         style="display: none;">
                        <div class="bg-white rounded-[1.5rem] shadow-2xl border border-slate-100 py-2 overflow-hidden">
                            <div class="px-5 py-3 border-b border-slate-50 mb-1">
                                <p class="text-[8px] font-black uppercase tracking-widest text-slate-400 mb-0.5">Akses Akun</p>
                                <p class="text-[10px] font-black text-slate-900 truncate">{{ auth()->user()->email ?? 'dimi@suara.com' }}</p>
                            </div>
                            <a href="/dashboard" class="flex items-center gap-3 px-5 py-3 hover:bg-slate-50 text-slate-600 hover:text-accent transition-all group">
                                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center group-hover:bg-accent/10 transition-colors">
                                    <i data-lucide="layout-dashboard" class="w-3.5 h-3.5"></i>
                                </div>
                                <span class="text-xs font-bold">Dashboard</span>
                            </a>
                            <a href="/logout" class="flex items-center gap-3 px-5 py-3 hover:bg-red-50 text-slate-600 hover:text-red-500 transition-all group">
                                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center group-hover:bg-red-100 transition-colors">
                                    <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                                </div>
                                <span class="text-xs font-bold">Signout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mx-auto px-6 py-8 md:py-12">
    @php
        $currentXp = $user->xp;
        $minXp = $levelInfo['current']['min_xp'];
        $nextXp = $levelInfo['next']['min_xp'] ?? ($user->xp + 1000);
        $percent = ($nextXp - $minXp) > 0 ? (($currentXp - $minXp) / ($nextXp - $minXp)) * 100 : 100;
        $remainingXp = max(0, $nextXp - $currentXp);
    @endphp
        @if(session('error'))
            <div id="error-alert" class="mb-8 p-6 bg-orange-50 border border-orange-100 rounded-[32px] flex items-center justify-between animate-fade-in max-w-7xl mx-auto shadow-sm">
                <div class="flex items-center gap-4 text-warning">
                    <div class="w-10 h-10 bg-white rounded-2xl flex items-center justify-center shadow-sm">
                        <i data-lucide="lock" class="w-6 h-6 text-orange-500"></i>
                    </div>
                    <div>
                        <p class="text-sm font-black uppercase tracking-widest leading-none mb-1 text-orange-600">Fitur Terkunci</p>
                        <p class="text-xs font-medium text-slate-600">{{ session('error') }}</p>
                    </div>
                </div>
                <button onclick="document.getElementById('error-alert').remove()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
        @endif

        @if(session('success'))
            <div id="success-alert" class="mb-8 p-6 bg-green-50 border border-green-100 rounded-[32px] flex items-center justify-between animate-fade-in max-w-7xl mx-auto shadow-sm">
                <div class="flex items-center gap-4 text-success">
                    <div class="w-10 h-10 bg-white rounded-2xl flex items-center justify-center shadow-sm">
                        <i data-lucide="check-circle" class="w-6 h-6 text-success"></i>
                    </div>
                    <div>
                        <p class="text-sm font-black uppercase tracking-widest leading-none mb-1">Berhasil!</p>
                        <p class="text-xs font-medium text-slate-600">{{ session('success') }}</p>
                    </div>
                </div>
                <button onclick="document.getElementById('success-alert').remove()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-10">
            <!-- Sidebar -->
            <aside class="lg:w-72 flex-shrink-0 space-y-6 animate-fade-in" style="animation-delay: 0.1s">
                <div class="sticky top-32 space-y-6">
                    <!-- 1. Reputation Summary Card (Premium Dark) -->
                    <div class="bg-[#0F172A] rounded-[40px] p-8 shadow-2xl shadow-slate-900/20 relative overflow-hidden group">
                        <!-- Abstract Background Glow -->
                        <div class="absolute -top-24 -right-24 w-48 h-48 bg-accent/20 rounded-full blur-[80px]"></div>
                        
                        <div class="relative z-10 space-y-8">
                            <!-- Trust Score Bars -->
                            <div class="h-20 flex items-end justify-between gap-1 px-2">
                                @for($i=1; $i<=10; $i++)
                                <div class="flex-1 rounded-full {{ $user->trust_score >= ($i*10) ? 'bg-accent shadow-[0_0_15px_rgba(37,99,235,0.4)]' : 'bg-slate-800' }}" style="height: {{ 30 + ($i*7) }}%"></div>
                                @endfor
                            </div>

                            <div class="text-center">
                                <h3 class="text-4xl font-black text-white leading-none mb-1">{{ $user->trust_score }}%</h3>
                                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest leading-none mb-6">Trust Score Kredibilitas</p>
                                
                                <div class="pt-6 border-t border-slate-800/50 space-y-3">
                                    <div class="flex items-center justify-between text-[10px] font-black uppercase tracking-widest">
                                        <span class="text-slate-500">Level {{ $levelInfo['current']['index'] }}</span>
                                        <span class="text-accent">{{ number_format($user->xp) }} XP</span>
                                    </div>
                                    <div class="w-full h-1.5 bg-slate-800 rounded-full overflow-hidden">
                                        <div class="h-full bg-accent rounded-full shadow-[0_0_10px_rgba(37,99,235,0.5)]" style="width: {{ $percent }}%"></div>
                                    </div>
                                    <p class="text-[8px] text-slate-500 font-bold  text-left">
                                        Butuh <span class="text-white">{{ number_format($remainingXp) }} XP</span> lagi untuk ke <span class="text-accent underline decoration-accent/30">{{ $levelInfo['next']['name'] ?? 'Puncak' }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Navigation Menu Card (White) -->
                    <div class="bg-white rounded-[40px] p-8 card-prominent">
                        <!-- Navigation Section -->
                        <div class="mb-8">
                            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 px-2">Layanan Utama</h3>
                            <nav class="space-y-3">
                                <button onclick="setDashboardView('dashboard')" id="side-dashboard" class="w-full flex items-center gap-4 px-6 py-5 rounded-3xl text-sm font-bold transition-all group text-left">
                                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                                    Dashboard
                                </button>
                                <button onclick="setDashboardView('monitoring')" id="side-monitoring" class="w-full flex items-center gap-4 px-6 py-5 rounded-3xl text-slate-600 hover:bg-slate-50 hover:text-accent font-bold transition-all text-sm group text-left hover:pl-8 active:scale-[0.98]">
                                    <i data-lucide="eye" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                                    Monitoring
                                </button>
                                <button onclick="setDashboardView('suara')" id="side-suara" class="w-full flex items-center gap-4 px-6 py-5 rounded-3xl text-slate-600 hover:bg-slate-50 hover:text-accent font-bold transition-all text-sm group text-left hover:pl-8 active:scale-[0.98]">
                                    <i data-lucide="compass" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                                    Suara Saya
                                </button>
                            </nav>
                        </div>

                        <!-- User & Rep Section -->
                        <div>
                            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 px-2">Reputasi & Akun</h3>
                            <nav class="space-y-3">
                                <button onclick="setDashboardView('reputasi')" id="side-reputasi" class="w-full flex items-center gap-4 px-6 py-5 rounded-3xl text-slate-600 hover:bg-slate-50 hover:text-accent font-bold transition-all text-sm group text-left hover:pl-8 active:scale-[0.98]">
                                    <i data-lucide="medal" class="w-5 h-5 group-hover:scale-110 transition-transform text-warning"></i>
                                    Sistem Reputasi
                                </button>
                                <button onclick="setDashboardView('pengaturan')" id="side-pengaturan" class="w-full flex items-center gap-4 px-6 py-5 rounded-3xl text-slate-600 hover:bg-slate-50 hover:text-accent font-bold transition-all text-sm group text-left hover:pl-8 active:scale-[0.98]">
                                    <i data-lucide="settings" class="w-5 h-5 group-hover:rotate-45 transition-transform duration-500"></i>
                                    Pengaturan Profil
                                </button>
                            </nav>
                        </div>

                        <div class="mt-12 pt-8 border-t border-slate-50">
                            <a href="/" class="flex items-center gap-4 px-6 py-5 rounded-3xl text-red-400 hover:bg-red-50 font-bold transition-all text-sm group">
                                <i data-lucide="log-out" class="w-5 h-5"></i>
                                Keluar
                            </a>
                        </div>
                    </div>


                </div>
            </aside>

            <!-- Main Content Container -->
            <main class="flex-grow space-y-10 min-w-0">
                
                <!-- View: Dashboard (Profile & Summary) -->
                <div id="view-dashboard" class="space-y-10">
                    <!-- 1. Top Profile & Gamification Section -->
                    <section class="animate-fade-in" style="animation-delay: 0.1s">
                         <!-- ... Profile Card Content (Existing 284-333) -->
                         @include('partials.dashboard_profile_card')
                    </section>
                    
                    <!-- 2. Contribution Stats -->
                    <section class="grid grid-cols-1 sm:grid-cols-3 gap-6 animate-fade-in" style="animation-delay: 0.2s">
                         <!-- ... Stats Boxes (Existing 338-360) -->
                         @include('partials.dashboard_stats')
                    </section>
                </div>
                
                <!-- View: Monitoring (Issue Tracking) -->
                <div id="view-monitoring" class="hidden space-y-10">
                    <section class="space-y-6 animate-fade-in">
                        <div class="flex items-center justify-between mb-4 px-2">
                            <h3 class="text-xl font-outfit font-extrabold text-slate-800">Isu yang Dikawal</h3>
                            @php $publishedCount = \App\Models\Suara::count(); @endphp
                            <span class="text-xs font-bold text-accent px-3 py-1 bg-accent/5 rounded-full ring-1 ring-accent/10">{{ $publishedCount }} Isu Aktif</span>
                        </div>

                        <div class="space-y-6">
                            @php $monitoringSuaras = \App\Models\Suara::latest()->get(); @endphp
                            
                            @if($monitoringSuaras->isEmpty())
                                <div class="bg-white rounded-[32px] p-12 border border-slate-100 card-shadow text-center space-y-4">
                                    <div class="w-16 h-16 bg-slate-50 text-slate-200 rounded-full flex items-center justify-center mx-auto">
                                        <i data-lucide="eye-off" class="w-8 h-8"></i>
                                    </div>
                                    <h4 class="text-xl font-outfit font-black text-slate-900 ">Belum Ada Monitoring Aktif</h4>
                                    <p class="text-sm text-slate-400 font-medium max-w-sm mx-auto">Semua laporan yang masuk akan melewati tahap verifikasi sebelum tampil di lini masa pemantauan publik.</p>
                                </div>
                            @else
                                @foreach($monitoringSuaras as $suara)
                                    <!-- Monitoring Card Item -->
                                    <div class="bg-white rounded-[32px] p-8 card-prominent space-y-8 hover:border-accent/20 transition-all">
                                        <div class="flex flex-col md:flex-row items-start justify-between gap-6">
                                            <div class="flex gap-6">
                                                <div class="w-16 h-16 rounded-2xl bg-slate-50 border border-slate-100 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                                    @if($suara->image)
                                                        <img src="{{ Storage::url($suara->image) }}" class="w-full h-full object-cover">
                                                    @else
                                                        <i data-lucide="image" class="w-6 h-6 text-slate-200"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <span class="text-[10px] font-black tracking-widest text-slate-400 uppercase">{{ $suara->category }} — {{ $suara->location }}</span>
                                                    <h4 class="text-lg font-outfit font-black text-slate-900 mb-1">{{ $suara->title }}</h4>
                                                    <p class="text-sm text-slate-500 font-medium ">Laporan: {{ $suara->created_at->format('d M Y') }} • Oleh: {{ $suara->user->name ?? 'Anonim' }}</p>
                                                </div>
                                            </div>
                                            <div class="flex flex-col items-end gap-2">
                                                 <div class="flex items-center gap-2 px-3 py-1 bg-blue-50 text-accent rounded-full text-[10px] font-black uppercase tracking-widest ring-1 ring-accent/10">
                                                    <span class="w-1.5 h-1.5 bg-accent rounded-full animate-pulse"></span>
                                                    {{ ucfirst($suara->status) }}
                                                </div>
                                                @if($suara->is_fundraising)
                                                    <div class="flex items-center gap-1.5 text-success">
                                                        <i data-lucide="banknote" class="w-4 h-4"></i>
                                                        <span class="text-xs font-black">Funding Active</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Horizontal Timeline (Mini) -->
                                        <div class="relative overflow-x-auto pb-2 custom-scrollbar">
                                            <div class="flex items-center gap-8 px-2 max-w-full">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-6 h-6 rounded-full bg-accent text-white flex items-center justify-center text-[10px] font-bold">1</div>
                                                    <span class="text-[9px] font-black uppercase tracking-widest text-accent">Issue</span>
                                                </div>
                                                <div class="w-8 h-px bg-slate-100"></div>
                                                <div class="flex items-center gap-2 opacity-30">
                                                    <div class="w-6 h-6 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-[10px] font-bold">2</div>
                                                    <span class="text-[9px] font-black uppercase tracking-widest text-slate-400">Aspiration</span>
                                                </div>
                                                <div class="w-8 h-px bg-slate-100"></div>
                                                <div class="flex items-center gap-2 opacity-30">
                                                    <div class="w-6 h-6 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-[10px] font-bold">3</div>
                                                    <span class="text-[9px] font-black uppercase tracking-widest text-slate-400">Decision</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </section>
                </div>

                <!-- View: Suara Saya (New) -->
                <div id="view-suara" class="hidden space-y-10">
                    <!-- Header with Search & Filter -->
                    <div class="flex flex-col md:row md:items-center justify-between gap-6 px-2">
                        <div class="space-y-1">
                            <h2 class="text-3xl font-outfit font-black text-slate-900 tracking-tight">Suara Saya</h2>
                            <p class="text-sm text-slate-400 font-medium">Kelola dan pantau setiap kontribusi Anda</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="relative group">
                                <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 group-focus-within:text-accent transition-colors"></i>
                                <input type="text" placeholder="Cari suara..." class="pl-11 pr-6 py-3 bg-white border border-slate-100 rounded-2xl outline-none focus:ring-4 focus:ring-accent/5 focus:border-accent transition-all text-sm font-medium w-full md:w-64">
                            </div>
                            <button class="w-12 h-12 flex items-center justify-center bg-white border border-slate-100 rounded-2xl hover:bg-slate-50 transition-all shadow-sm">
                                <i data-lucide="sliders-horizontal" class="w-5 h-5 text-slate-600"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tabs / Segmentation -->
                    <nav class="flex items-center gap-8 border-b border-slate-100 px-2 overflow-x-auto custom-scrollbar whitespace-nowrap">
                        <button class="pb-4 text-sm font-black text-accent border-b-2 border-accent transition-all tracking-wide">Dibuat ({{ $suaras->count() }})</button>
                        <button class="pb-4 text-sm font-bold text-slate-400 hover:text-slate-600 transition-all tracking-wide">Didukung ({{ $stats['user_votes_count'] ?? 0 }})</button>
                        <button class="pb-4 text-sm font-bold text-slate-400 hover:text-slate-600 transition-all tracking-wide">Aksi Bergabung ({{ $stats['total_aksi'] ?? 0 }})</button>
                    </nav>

                    <!-- Movement List (Card-Based UI) -->
                    <div class="grid grid-cols-1 gap-6">
                        @if($suaras->isEmpty())
                            <div class="bg-white rounded-[40px] p-12 card-shadow border border-slate-100 text-center space-y-4">
                                <div class="w-16 h-16 bg-slate-50 text-slate-200 rounded-full flex items-center justify-center mx-auto">
                                    <i data-lucide="folder-open" class="w-8 h-8"></i>
                                </div>
                                <h4 class="text-xl font-outfit font-black text-slate-900">Belum Ada Suara</h4>
                                <p class="text-sm text-slate-400 font-medium max-w-sm mx-auto ">Anda belum mempublikasikan suara apapun. Jadilah inisiator pertama di lingkunganmu!</p>
                                <div class="pt-4">
                                     <a href="/create-suara" class="inline-flex items-center gap-3 px-8 py-3 bg-accent text-white font-black rounded-2xl text-[10px] uppercase tracking-widest hover:scale-105 active:scale-95 transition-all">
                                         Buat Suara Sekarang
                                         <i data-lucide="plus" class="w-4 h-4"></i>
                                     </a>
                                </div>
                            </div>
                        @endif

                        @foreach($suaras as $suara)
                            <!-- Card: {{ $suara->title }} -->
                            <div class="bg-white rounded-[40px] p-8 card-shadow border border-slate-100 hover:border-accent/30 transition-all group relative">
                                <div class="flex flex-col md:flex-row gap-8">
                                    <!-- Thumbnail -->
                                    <div class="w-full md:w-48 h-48 md:h-auto rounded-[32px] overflow-hidden flex-shrink-0 relative bg-slate-100 group">
                                        @if($suara->image)
                                            <img src="{{ Storage::url($suara->image) }}" alt="{{ $suara->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <i data-lucide="image" class="w-8 h-8"></i>
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                                        <div class="absolute bottom-4 left-4">
                                             <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-lg text-[8px] font-black text-white uppercase tracking-widest border border-white/20">{{ $suara->category ?? 'Lainnya' }}</span>
                                        </div>
                                    </div>

                                    <div class="flex-1 space-y-4">
                                        <div class="flex items-start justify-between">
                                            <div class="space-y-1">
                                                <h4 class="text-xl font-outfit font-black text-slate-900 leading-tight">{{ $suara->title }}</h4>
                                                <div class="flex items-center gap-2 text-slate-400">
                                                    <i data-lucide="map-pin" class="w-3 h-3"></i>
                                                    <span class="text-[10px] font-bold uppercase tracking-widest">{{ $suara->location ?? 'Lokasi Tidak Ditentukan' }}</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="px-3 py-1 bg-blue-50 text-accent text-[9px] font-black uppercase tracking-widest rounded-full ring-1 ring-accent/10">Bakal Aspiration</span>
                                                <div class="flex items-center gap-1 bg-warning/10 px-2 py-1 rounded-full">
                                                    <i data-lucide="flame" class="w-3 h-3 text-warning fill-warning/20"></i>
                                                    <span class="text-[9px] font-black text-warning">New</span>
                                                </div>
                                            </div>
                                        </div>

                                        <p class="text-sm text-slate-500 font-medium line-clamp-2 ">{{ $suara->description ?? 'Tidak ada deskripsi.' }}</p>

                                        <!-- Mini Timeline -->
                                        <div class="flex items-center gap-2 py-2">
                                            <div class="flex-1 h-1.5 bg-slate-100 rounded-full overflow-hidden flex">
                                                <div class="h-full bg-accent w-1/4"></div>
                                                <div class="h-full bg-slate-200 w-1/4 opacity-20"></div>
                                                <div class="h-full bg-slate-100 w-1/4 opacity-20"></div>
                                                <div class="h-full bg-slate-100 w-1/4 opacity-20"></div>
                                            </div>
                                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Issue Phase</span>
                                        </div>

                                        <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                                            <div class="flex items-center gap-6">
                                                <div class="flex items-center gap-2 text-slate-400 group/item">
                                                    <i data-lucide="megaphone" class="w-4 h-4 group-hover/item:text-accent transition-colors"></i>
                                                    <span class="text-xs font-bold">0</span>
                                                </div>
                                                <div class="flex items-center gap-2 text-slate-400 group/item">
                                                    <i data-lucide="message-square" class="w-4 h-4 group-hover/item:text-accent transition-colors"></i>
                                                    <span class="text-xs font-bold">0</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:text-accent hover:bg-white hover:shadow-sm transition-all shadow-sm md:shadow-none">
                                                    <i data-lucide="share-2" class="w-4 h-4"></i>
                                                </button>
                                                <button onclick="window.location.href='/suara-manage/{{ $suara->id }}'" class="px-6 py-2.5 bg-accent text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:scale-105 active:scale-95 transition-all shadow-lg shadow-accent/20">
                                                    Kelola
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- View: Reputasi (New) -->
                <div id="view-reputasi" class="hidden space-y-10">
                    <div class="px-2 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-3xl font-outfit font-black text-slate-900 tracking-tight">Sistem Reputasi & Tingkatan</h2>
                            <p class="text-sm text-slate-400 font-medium">Transparansi jenjang karir, peringkat komunitas, dan kredibilitas akun Anda</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-4 py-2 bg-accent/10 text-accent font-black text-xs uppercase tracking-widest rounded-2xl ring-1 ring-accent/20">
                                Posisi: {{ $user->level }} (Lv. {{ $levelInfo['current']['index'] ?? 1 }})
                            </span>
                        </div>
                    </div>

                    <!-- 1. Top Highlights Grid (3 Cards) -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Card 1: Level & XP Progress -->
                        <div class="bg-white rounded-[36px] p-8 card-shadow border border-slate-100 flex flex-col justify-between space-y-6 relative overflow-hidden group hover:border-accent/30 transition-all">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Level Anda</p>
                                    <h4 class="text-2xl font-outfit font-black text-slate-900">{{ $user->level }}</h4>
                                </div>
                                <div class="w-12 h-12 bg-accent/10 text-accent rounded-2xl flex items-center justify-center font-black text-sm">
                                    Lv.{{ $levelInfo['current']['index'] ?? 1 }}
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between text-xs font-bold">
                                    <span class="text-slate-500">Total XP</span>
                                    <span class="text-slate-900 font-black">{{ number_format($user->xp) }} XP</span>
                                </div>
                                <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-accent rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                                </div>
                                <div class="flex items-center justify-between text-[10px] text-slate-400 font-medium">
                                    <span>Target: {{ $levelInfo['next']['name'] ?? 'Puncak' }}</span>
                                    <span>{{ number_format($remainingXp) }} XP lagi</span>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: Peringkat Komunitas -->
                        <div class="bg-white rounded-[36px] p-8 card-shadow border border-slate-100 flex flex-col justify-between space-y-6 relative overflow-hidden group hover:border-warning/30 transition-all">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Peringkat Klasemen</p>
                                    <h4 class="text-2xl font-outfit font-black text-slate-900">#{{ $userRank }} <span class="text-xs font-bold text-slate-400 tracking-normal">/ {{ $totalUsers }} Warga</span></h4>
                                </div>
                                <div class="w-12 h-12 bg-warning/10 text-warning rounded-2xl flex items-center justify-center">
                                    <i data-lucide="trophy" class="w-6 h-6"></i>
                                </div>
                            </div>
                            <div class="space-y-2">
                                @php
                                    $percentile = max(1, round(($userRank / max(1, $totalUsers)) * 100));
                                @endphp
                                <div class="flex items-center gap-2 px-3 py-2 bg-amber-50 text-amber-800 rounded-xl text-xs font-bold">
                                    <i data-lucide="sparkles" class="w-4 h-4 text-warning flex-shrink-0"></i>
                                    <span>Top {{ $percentile }}% Kontributor Teraktif</span>
                                </div>
                                <p class="text-[10px] text-slate-400 font-medium">Peringkat dihitung berdasarkan akumulasi XP & Trust Score</p>
                            </div>
                        </div>

                        <!-- Card 3: Trust Score & Status -->
                        <div class="bg-white rounded-[36px] p-8 card-shadow border border-slate-100 flex flex-col justify-between space-y-6 relative overflow-hidden group hover:border-success/30 transition-all">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Trust Score</p>
                                    <h4 class="text-2xl font-outfit font-black text-success">{{ $user->trust_score }}%</h4>
                                </div>
                                <div class="w-12 h-12 bg-success/10 text-success rounded-2xl flex items-center justify-center">
                                    <i data-lucide="shield-check" class="w-6 h-6"></i>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between text-xs font-bold">
                                    <span class="text-slate-500">Status Peran</span>
                                    <span class="px-3 py-1 bg-success/10 text-success text-[10px] font-black uppercase tracking-widest rounded-full">{{ $user->role ?? 'Verified User' }}</span>
                                </div>
                                <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-success rounded-full" style="width: {{ $user->trust_score }}%"></div>
                                </div>
                                <p class="text-[10px] text-slate-400 font-medium">Tingkat kepercayaan publik terhadap validitas laporan Anda</p>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Jenjang 10 Tingkatan Level & Posisi Existing User Saat Ini -->
                    <div class="bg-white rounded-[40px] p-8 md:p-10 card-shadow border border-slate-100 space-y-8">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-50 pb-6">
                            <div>
                                <h3 class="text-xl font-outfit font-extrabold text-slate-900">Jenjang Tingkatan Level</h3>
                                <p class="text-xs text-slate-400 font-medium">Struktur tingkatan reputasi dan posisi level Anda saat ini</p>
                            </div>
                            <div class="flex items-center gap-3 text-xs font-bold">
                                <span class="flex items-center gap-1.5 text-accent"><span class="w-2.5 h-2.5 rounded-full bg-accent animate-pulse"></span> Posisi Anda Saat Ini</span>
                                <span class="text-slate-300">•</span>
                                <span class="flex items-center gap-1.5 text-slate-400"><i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-success"></i> Terlampaui</span>
                            </div>
                        </div>

                        <!-- Level Cards Grid (10 Levels) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                            @php
                                $userLevelIndex = $levelInfo['current']['index'] ?? 1;
                            @endphp
                            @foreach($allLevels as $idx => $lvl)
                                @php
                                    $levelNum = $idx + 1;
                                    $isCurrent = ($levelNum === $userLevelIndex);
                                    $isPassed = ($levelNum < $userLevelIndex);
                                    $isLocked = ($levelNum > $userLevelIndex);
                                @endphp
                                <div class="rounded-3xl p-5 transition-all relative flex flex-col justify-between min-h-[190px]
                                    {{ $isCurrent ? 'bg-gradient-to-b from-blue-50/80 to-white border-2 border-accent shadow-xl shadow-accent/10 ring-4 ring-accent/10 scale-[1.02]' : '' }}
                                    {{ $isPassed ? 'bg-white border border-slate-200 hover:border-slate-300' : '' }}
                                    {{ $isLocked ? 'bg-slate-50/60 border border-dashed border-slate-200 opacity-70' : '' }}">
                                    
                                    @if($isCurrent)
                                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-0.5 bg-accent text-white text-[8px] font-black uppercase tracking-widest rounded-full shadow-md whitespace-nowrap">
                                            POSISI ANDA
                                        </div>
                                    @endif

                                    <!-- Level Header -->
                                    <div class="flex items-start justify-between">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-black
                                            {{ $isCurrent ? 'bg-accent text-white shadow-md shadow-accent/30' : '' }}
                                            {{ $isPassed ? 'bg-emerald-50 text-success border border-emerald-100' : '' }}
                                            {{ $isLocked ? 'bg-slate-200 text-slate-400' : '' }}">
                                            @if($isPassed)
                                                <i data-lucide="check" class="w-4 h-4"></i>
                                            @else
                                                {{ $levelNum }}
                                            @endif
                                        </div>
                                        <span class="text-[9px] font-black uppercase tracking-wider
                                            {{ $isCurrent ? 'text-accent' : ($isPassed ? 'text-success' : 'text-slate-400') }}">
                                            {{ $isCurrent ? 'Sedang Aktif' : ($isPassed ? 'Unlocked' : 'Locked') }}
                                        </span>
                                    </div>

                                    <!-- Level Title & Info -->
                                    <div class="my-2 space-y-1">
                                        <h5 class="text-base font-outfit font-black {{ $isCurrent ? 'text-accent' : 'text-slate-900' }}">{{ $lvl['name'] }}</h5>
                                        <p class="text-[11px] font-bold text-slate-400">Min. {{ number_format($lvl['min_xp']) }} XP</p>
                                    </div>

                                    <!-- Footer Status -->
                                    <div class="pt-2 border-t {{ $isCurrent ? 'border-accent/20' : 'border-slate-100' }}">
                                        @if($isCurrent)
                                            <div class="text-[9px] font-black text-accent uppercase tracking-wider flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 bg-accent rounded-full animate-ping"></span>
                                                Level Aktif Anda
                                            </div>
                                        @elseif($isPassed)
                                            <div class="text-[9px] font-bold text-slate-400">
                                                Telah Tercapai
                                            </div>
                                        @else
                                            <div class="text-[9px] font-bold text-slate-400 flex items-center gap-1">
                                                <i data-lucide="lock" class="w-3 h-3 text-slate-300"></i>
                                                Butuh {{ number_format(max(0, $lvl['min_xp'] - $user->xp)) }} XP
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 3. Papan Peringkat / Leaderboard Komunitas -->
                    <div class="bg-white rounded-[40px] p-8 md:p-10 card-shadow border border-slate-100 space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-50 pb-4">
                            <div>
                                <h3 class="text-xl font-outfit font-extrabold text-slate-900">Papan Peringkat Kontributor</h3>
                                <p class="text-xs text-slate-400 font-medium">Daftar pengguna dengan reputasi dan kontribusi tertinggi</p>
                            </div>
                            <span class="text-xs font-bold text-slate-400 px-3 py-1 bg-slate-50 rounded-full border border-slate-100">
                                Total: {{ $totalUsers }} Kontributor
                            </span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="bg-slate-50/70 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                        <th class="px-6 py-4 rounded-l-2xl">Rank</th>
                                        <th class="px-6 py-4">Kontributor</th>
                                        <th class="px-6 py-4 text-center">Level Tier</th>
                                        <th class="px-6 py-4 text-center">Trust Score</th>
                                        <th class="px-6 py-4 text-right rounded-r-2xl">Total XP</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @php $userInTop5 = false; @endphp
                                    @foreach($topUsers as $index => $topUser)
                                        @php
                                            $isMe = ($topUser->id === $user->id);
                                            if ($isMe) $userInTop5 = true;
                                            $rank = $index + 1;
                                        @endphp
                                        <tr class="transition-colors {{ $isMe ? 'bg-blue-50/50 font-bold' : 'hover:bg-slate-50/50' }}">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-2">
                                                    @if($rank === 1)
                                                        <span class="w-7 h-7 rounded-xl bg-amber-400 text-slate-900 flex items-center justify-center font-black text-xs shadow-md shadow-amber-400/20">🥇</span>
                                                    @elseif($rank === 2)
                                                        <span class="w-7 h-7 rounded-xl bg-slate-300 text-slate-900 flex items-center justify-center font-black text-xs shadow-md shadow-slate-300/20">🥈</span>
                                                    @elseif($rank === 3)
                                                        <span class="w-7 h-7 rounded-xl bg-amber-600 text-white flex items-center justify-center font-black text-xs shadow-md shadow-amber-600/20">🥉</span>
                                                    @else
                                                        <span class="w-7 h-7 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center font-black text-xs">#{{ $rank }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-9 h-9 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center overflow-hidden">
                                                        <span class="text-xs font-black text-slate-700">{{ strtoupper(substr($topUser->name, 0, 2)) }}</span>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-bold text-slate-900 flex items-center gap-2">
                                                            {{ $topUser->name }}
                                                            @if($isMe)
                                                                <span class="px-2 py-0.5 bg-accent text-white text-[8px] font-black uppercase tracking-widest rounded-full">Anda</span>
                                                            @endif
                                                        </p>
                                                        <p class="text-[10px] text-slate-400 font-medium">{{ $topUser->city ?? 'Indonesia' }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="px-3 py-1 bg-slate-100 text-slate-700 text-[10px] font-black uppercase tracking-widest rounded-full">
                                                    {{ $topUser->level }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="text-xs font-black text-success">{{ $topUser->trust_score }}%</span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <span class="text-sm font-black font-outfit text-slate-900">{{ number_format($topUser->xp) }} XP</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <!-- If current user is outside Top 5, show a pinned row -->
                                    @if(!$userInTop5)
                                        <tr class="bg-slate-50/30">
                                            <td colspan="5" class="px-6 py-2 text-center text-slate-400 text-xs tracking-widest">• • •</td>
                                        </tr>
                                        <tr class="bg-blue-50/70 border-2 border-accent/30 font-bold">
                                            <td class="px-6 py-4">
                                                <span class="w-7 h-7 rounded-xl bg-accent text-white flex items-center justify-center font-black text-xs shadow-md shadow-accent/20">
                                                    #{{ $userRank }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-9 h-9 rounded-xl bg-accent/10 border border-accent/20 flex items-center justify-center overflow-hidden">
                                                        <span class="text-xs font-black text-accent">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-black text-slate-900 flex items-center gap-2">
                                                            {{ $user->name }}
                                                            <span class="px-2 py-0.5 bg-accent text-white text-[8px] font-black uppercase tracking-widest rounded-full">Posisi Anda</span>
                                                        </p>
                                                        <p class="text-[10px] text-slate-400 font-medium">{{ $user->city ?? 'Indonesia' }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="px-3 py-1 bg-accent/10 text-accent text-[10px] font-black uppercase tracking-widest rounded-full">
                                                    {{ $user->level }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="text-xs font-black text-success">{{ $user->trust_score }}%</span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <span class="text-sm font-black font-outfit text-accent">{{ number_format($user->xp) }} XP</span>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 4. Badge Collection -->
                    <div class="space-y-6">
                        <div class="flex items-center justify-between px-2">
                            <h3 class="text-xl font-outfit font-extrabold text-slate-800">Koleksi Badge</h3>
                            <span class="text-xs font-bold text-slate-400">{{ $user->badges->count() }} Terbuka</span>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-6">
                            @foreach($user->badges as $badge)
                                <div class="bg-white p-6 rounded-[32px] border border-slate-100 flex flex-col items-center text-center gap-3 hover:-translate-y-1 transition-all">
                                    <div class="w-12 h-12 bg-accent/5 text-accent rounded-2xl flex items-center justify-center">
                                        <i data-lucide="{{ $badge->icon ?? 'award' }}" class="w-6 h-6"></i>
                                    </div>
                                    <h5 class="text-xs font-black text-slate-900 leading-tight">{{ $badge->name }}</h5>
                                </div>
                            @endforeach
                            
                            @php $lockedCount = 6 - $user->badges->count(); @endphp
                            @if($lockedCount > 0)
                                @for($i=0; $i<$lockedCount; $i++)
                                    <div class="bg-slate-50/50 p-6 rounded-[32px] border border-dashed border-slate-200 flex flex-col items-center text-center gap-3 opacity-40">
                                        <div class="w-12 h-12 bg-slate-100 text-slate-300 rounded-2xl flex items-center justify-center">
                                            <i data-lucide="lock" class="w-5 h-5"></i>
                                        </div>
                                        <h5 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Locked</h5>
                                    </div>
                                @endfor
                            @endif
                        </div>
                    </div>

                    <!-- 5. Activity History -->
                    <div class="space-y-6">
                        <h3 class="text-xl font-outfit font-extrabold text-slate-800 px-2">Riwayat Reputasi</h3>
                        <div class="bg-white rounded-[40px] border border-slate-100 overflow-hidden shadow-sm">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50 border-b border-slate-100">
                                    <tr>
                                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Aktivitas</th>
                                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">XP</th>
                                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse($user->reputationLogs()->latest()->take(10)->get() as $log)
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-8 py-5">
                                                <p class="text-sm font-bold text-slate-900">{{ $log->description ?: $log->action_type }}</p>
                                                <p class="text-[10px] font-medium text-slate-400">{{ $log->action_type }}</p>
                                            </td>
                                            <td class="px-8 py-5 text-center">
                                                <span class="text-xs font-black {{ $log->xp_change >= 0 ? 'text-success' : 'text-danger' }}">
                                                    {{ $log->xp_change >= 0 ? '+' : '' }}{{ $log->xp_change }}
                                                </span>
                                            </td>
                                            <td class="px-8 py-5 text-right text-[10px] font-bold text-slate-400">
                                                {{ $log->created_at->diffForHumans() }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-8 py-8 text-center text-slate-400 text-xs font-medium">
                                                Belum ada riwayat aktivitas reputasi.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- View: Profile Management (Settings) -->
                <div id="view-pengaturan" class="hidden space-y-10 animate-fade-in">
                    <div class="px-2">
                        <h2 class="text-3xl font-outfit font-black text-slate-900 tracking-tight">Manajemen Profil</h2>
                        <p class="text-sm text-slate-400 font-medium">Perbarui identitas dan keamanan akun Anda</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                        <!-- Left: Profile Info -->
                        <div class="lg:col-span-2 space-y-8">
                            <div class="bg-white rounded-[40px] p-10 card-prominent space-y-8">
                                <!-- Avatar Upload & Crop Section -->
                                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-8 pb-8 border-b border-slate-100">
                                    <div class="relative group cursor-pointer flex-shrink-0" onclick="triggerAvatarUpload()">
                                        <div class="w-28 h-28 rounded-[32px] bg-slate-50 border-2 border-slate-200/80 flex items-center justify-center overflow-hidden relative shadow-md group-hover:border-accent group-hover:shadow-lg transition-all">
                                            <div id="settingsAvatarContainer" class="w-full h-full flex items-center justify-center">
                                                @if($user->avatar_url)
                                                    <img id="settingsAvatarImg" src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div id="settingsAvatarSvg" class="w-full h-full flex items-center justify-center">
                                                        <svg class="w-full h-full" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <circle cx="50" cy="35" r="20" fill="url(#avatarGrad1)" />
                                                            <path d="M20,85 Q50,60 80,85 L80,100 L20,100 Z" fill="url(#navAvatarGrad2)" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-all flex flex-col items-center justify-center text-white backdrop-blur-[2px]">
                                                <i data-lucide="camera" class="w-7 h-7 mb-1 text-white"></i>
                                                <span class="text-[9px] font-black uppercase tracking-wider">Ubah Foto</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hidden File Input for Avatar -->
                                    <input type="file" id="avatarFileInput" accept="image/png, image/jpeg, image/webp" class="hidden" onchange="handleAvatarFileSelect(this)">

                                    <div class="text-center sm:text-left space-y-3 flex-1">
                                        <div>
                                            <h4 class="text-xl font-bold text-slate-900">{{ $user->name }}</h4>
                                            <p class="text-xs font-medium text-slate-400 mt-0.5">
                                                @if($user->is_verified)
                                                    <span class="text-emerald-600 font-bold inline-flex items-center gap-1"><i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Terverifikasi sebagai Inisiator</span>
                                                @else
                                                    Lengkapi data diri untuk membuka fitur inisiator
                                                @endif
                                            </p>
                                        </div>

                                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2.5 pt-1">
                                            <button type="button" onclick="triggerAvatarUpload()" class="px-4 py-2 bg-accent/10 text-accent hover:bg-accent hover:text-white rounded-xl text-xs font-black uppercase tracking-wider transition-all flex items-center gap-2">
                                                <i data-lucide="upload-cloud" class="w-4 h-4"></i>
                                                Upload Foto
                                            </button>
                                            <button type="button" id="btnDeleteAvatar" onclick="deleteUserAvatar()" class="px-4 py-2 bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-xl text-xs font-black uppercase tracking-wider transition-all flex items-center gap-2 {{ $user->avatar ? '' : 'hidden' }}">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <form action="{{ route('profile.update') }}" method="POST" class="space-y-8">
                                    @csrf
                                    <input type="hidden" name="avatar_base64" id="avatarBase64FormInput">

                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">No. ID (KTP / Passport) <span class="text-red-500">*</span></label>
                                        <input type="text" name="id_number" value="{{ $user->id_number ?? '' }}" placeholder="Contoh: 317XXXXXXXXXXXXX" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-4 focus:ring-accent/5 focus:bg-white focus:border-accent transition-all font-medium">
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                            <input type="text" name="name" value="{{ $user->name }}" required class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-4 focus:ring-accent/5 focus:bg-white focus:border-accent transition-all font-medium">
                                        </div>
                                        <div class="space-y-2 relative">
                                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Email <span class="text-slate-400 font-normal">(Terhubung)</span></label>
                                            <div class="relative group">
                                                <input type="email" value="{{ $user->email }}" readonly class="w-full px-6 py-4 bg-slate-100/70 border border-slate-200/60 rounded-2xl text-slate-500 cursor-not-allowed font-medium pr-28">
                                                <span class="absolute right-3 top-1/2 -translate-y-1/2 px-3 py-1.5 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-wider rounded-lg border border-emerald-200/50">Aktif</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">No Telp <span class="text-red-500">*</span></label>
                                            <input type="text" name="phone" value="{{ $user->phone ?? '' }}" placeholder="+62 8XX XXXX XXXX" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-4 focus:ring-accent/5 focus:bg-white focus:border-accent transition-all font-medium">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Kota <span class="text-red-500">*</span></label>
                                            <input type="text" name="city" value="{{ $user->city ?? '' }}" placeholder="Jakarta" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-4 focus:ring-accent/5 focus:bg-white focus:border-accent transition-all font-medium">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                                            <input type="text" name="address" value="{{ $user->address ?? '' }}" placeholder="Jl. Sudirman No. 12..." class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-4 focus:ring-accent/5 focus:bg-white focus:border-accent transition-all font-medium">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Negara <span class="text-red-500">*</span></label>
                                            <input type="text" name="country" value="{{ $user->country ?? 'Indonesia' }}" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-4 focus:ring-accent/5 focus:bg-white focus:border-accent transition-all font-medium">
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">TagLine</label>
                                        <textarea name="tagline" rows="3" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-4 focus:ring-accent/5 focus:bg-white focus:border-accent transition-all font-medium" placeholder="Tuliskan slogan inspiratif Anda...">{{ $user->tagline ?? $user->bio ?? 'Pejuang perubahan untuk lingkungan yang lebih baik.' }}</textarea>
                                    </div>
                                    <div class="pt-4 flex justify-end">
                                        <button type="submit" class="px-10 py-4 bg-accent text-white font-black rounded-2xl shadow-xl shadow-accent/20 hover:scale-105 active:scale-95 transition-all text-sm tracking-widest uppercase flex items-center gap-2">
                                            <i data-lucide="check" class="w-4 h-4"></i>
                                            Simpan Perubahan & Verifikasi
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Right: Security & Others -->
                        <div class="space-y-8">
                            <div class="bg-white rounded-[40px] p-8 card-prominent space-y-6">
                                <h4 class="text-sm font-black uppercase tracking-widest text-slate-400 mb-6">Keamanan Akun</h4>
                                <div class="space-y-4">
                                    <button class="w-full flex items-center justify-between p-4 rounded-2xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100 group">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-orange-50 text-orange-500 rounded-xl flex items-center justify-center">
                                                <i data-lucide="key-round" class="w-5 h-5"></i>
                                            </div>
                                            <div class="text-left">
                                                <p class="text-sm font-bold text-slate-800">Ganti Password</p>
                                                <p class="text-[10px] text-slate-400 font-medium">Update secara berkala</p>
                                            </div>
                                        </div>
                                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:translate-x-1 transition-transform"></i>
                                    </button>
                                    <button class="w-full flex items-center justify-between p-4 rounded-2xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100 group">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center">
                                                <i data-lucide="shield-check" class="w-5 h-5"></i>
                                            </div>
                                            <div class="text-left">
                                                <p class="text-sm font-bold text-slate-800">Verifikasi Akun</p>
                                                <p class="text-[10px] text-slate-400 font-medium hover:text-blue-500">Status: Terverifikasi</p>
                                            </div>
                                        </div>
                                        <i data-lucide="check" class="w-4 h-4 text-success"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="bg-red-50 rounded-[40px] p-8 border border-red-100 space-y-6">
                                <h4 class="text-sm font-black uppercase tracking-widest text-red-400 mb-4">Zona Bahaya</h4>
                                <button class="w-full text-center py-4 bg-white border border-red-100 text-red-500 text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                    Hapus Akun Saya
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                    <!-- Floating Action Button -->
                    <div class="fixed bottom-10 right-10 z-[150]">
                         <a @click="addNotification('+20 XP', 'xp')" href="/create-suara" class="bg-primary text-white p-6 rounded-[32px] shadow-2xl shadow-primary/40 hover:scale-110 active:scale-95 transition-all flex items-center gap-4 group shine-sweep">
                             <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center group-hover:rotate-90 transition-transform duration-500">
                                 <i data-lucide="plus" class="w-6 h-6"></i>
                             </div>
                             <span class="font-black uppercase tracking-widest text-xs pr-4">Buat Suara</span>
                         </a>
                    </div>
                </div>

                <!-- XP Float Notifications Container -->
                <div class="fixed top-1/2 left-1/2 -translate-x-1/2 pointer-events-none z-[1000] flex flex-col items-center">
                    <template x-for="n in notifications" :key="n.id">
                        <div class="animate-float-up bg-white px-6 py-2 rounded-full shadow-2xl border border-slate-100 flex items-center gap-2 mb-2">
                            <span class="w-4 h-4 bg-warning/20 rounded-full flex items-center justify-center">
                                <i data-lucide="zap" class="w-2.5 h-2.5 text-warning fill-warning"></i>
                            </span>
                            <span class="text-sm font-black text-slate-900" x-text="n.val"></span>
                        </div>
                    </template>
                </div>

                <!-- Level Up Modal -->
                <div x-show="showLevelUp" 
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 scale-90"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="fixed inset-0 z-[2000] flex items-center justify-center bg-primary/80 backdrop-blur-xl p-6"
                     style="display: none;">
                     <div class="bg-white rounded-[50px] p-12 max-w-sm w-full text-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-b from-accent/5 to-transparent"></div>
                        <div class="relative z-10 space-y-8">
                            <div class="w-40 h-40 bg-white shadow-2xl rounded-[40px] flex items-center justify-center mx-auto p-2">
                                <div class="w-full h-full flex items-center justify-center text-white"
                                     :class="getShapeClass(currentLevelName) + ' ' + getEffectClass(currentLevelName)"
                                     :style="'background-color: ' + getLevelData(currentLevelName).color">
                                    <i :data-lucide="getLevelData(currentLevelName).icon" class="w-20 h-20"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Pencapaian Baru</h3>
                                <h2 class="text-3xl font-outfit font-black text-slate-900">LEVEL UP!</h2>
                                <p class="text-slate-500 font-medium mt-4">Selamat! Anda sekarang menyandang gelar <span class="text-accent font-black underline" x-text="currentLevelName"></span></p>
                            </div>
                            <button @click="showLevelUp = false" class="w-full py-5 bg-accent text-white font-black rounded-[25px] hover:scale-105 active:scale-95 transition-all shadow-xl shadow-accent/20">
                                LANJUTKAN KERJA NYATA
                            </button>
                        </div>
                     </div>
                </div>

                <!-- Badge Unlock Modal -->
                <div x-show="showBadgeUnlock" 
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 translateY(50px)"
                     x-transition:enter-end="opacity-100 translateY(0)"
                     class="fixed bottom-10 left-10 z-[1500] max-w-sm w-full"
                     style="display: none;">
                     <div class="bg-white rounded-3xl p-6 shadow-2xl border border-slate-100 flex items-center gap-6 shine-sweep">
                        <div class="w-16 h-16 bg-success/10 text-success rounded-2xl flex items-center justify-center">
                            <i :data-lucide="currentBadge.icon" class="w-8 h-8 text-success"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-[10px] font-black text-success uppercase tracking-widest mb-1">Badge Baru Terbuka</h4>
                            <h3 class="text-lg font-outfit font-black text-slate-900" x-text="currentBadge.name"></h3>
                        </div>
                        <button @click="showBadgeUnlock = false" class="text-slate-300 hover:text-slate-600">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                     </div>
                </div>

                <!-- Empty State Motivation -->
                <section id="empty-state-motivation" class="py-16 text-center animate-fade-in" style="animation-delay: 0.6s">
                     <div class="max-w-md mx-auto space-y-6">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto text-slate-200">
                            <i data-lucide="search-sparkles" class="w-10 h-10"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-outfit font-bold text-slate-800 mb-2">Belum ada aksi baru?</h4>
                            <p class="text-slate-500 font-medium ">"Setiap suara kecil adalah benih perubahan besar. Mulailah kawal isu di sekitarmu sekarang!"</p>
                        </div>
                        <a href="/suara" class="inline-flex items-center gap-2 px-8 py-4 bg-accent text-white font-black rounded-2xl shadow-xl shadow-accent/20 hover:scale-105 active:scale-95 transition-all">
                            Jelajahi Suara <i data-lucide="arrow-right" class="w-5 h-5"></i>
                        </a>
                     </div>
                </section>

            </main>

    <!-- Bottom Mobile Nav Indicator -->
    <div class="fixed bottom-0 left-0 right-0 h-1 bg-slate-100 md:hidden z-[110]">
        <div class="h-full bg-accent w-1/4 translate-x-3/4"></div>
    </div>

    <!-- Script to trigger animations and initialize icons -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dashboard', () => ({
                notifications: [],
                userOpen: false,
                showLevelUp: false,
                showBadgeUnlock: false,
                currentBadge: { name: '', icon: '' },
                currentLevelName: '{{ $user->level }}',
                levels: @json(\App\Services\ReputationService::getAllLevels()),
                getLevelData(name) {
                    return this.levels.find(l => l.name === name) || this.levels[0];
                },
                getShapeClass(name) {
                    const idx = this.levels.findIndex(l => l.name === name) + 1;
                    if (idx <= 3) return 'rounded-full';
                    if (idx <= 6) return 'badge-hexagon';
                    if (idx <= 8) return 'badge-shield';
                    return 'badge-diamond';
                },
                getEffectClass(name) {
                    const idx = this.levels.findIndex(l => l.name === name) + 1;
                    let cls = '';
                    if (idx >= 7) cls += ' animate-pulse-badge';
                    if (idx == 9) cls += ' glow-soft';
                    if (idx == 10) cls += ' glow-heavy shimmer-gold';
                    return cls;
                },
                addNotification(val, type = 'xp') {
                    const id = Date.now();
                    this.notifications.push({ id, val, type });
                    setTimeout(() => {
                        this.notifications = this.notifications.filter(n => n.id !== id);
                    }, 1200);
                },
                triggerLevelUp(name) {
                    this.currentLevelName = name;
                    this.showLevelUp = true;
                    confetti({ particleCount: 150, spread: 70, origin: { y: 0.6 }, colors: ['#2563EB', '#10B981', '#F59E0B'] });
                },
                triggerBadge(name, icon) {
                    this.currentBadge = { name, icon };
                    this.showBadgeUnlock = true;
                    confetti({ particleCount: 80, spread: 50, origin: { y: 0.7 } });
                }
            }));
        });

        lucide.createIcons();
        setDashboardView('dashboard');

        // Alpine Watchers for Icons
        document.addEventListener('alpine:init', () => {
            Alpine.effect(() => {
                // Re-run lucide when modals open
                setTimeout(() => lucide.createIcons(), 10);
            });
        });

        // Developer Simulation Helpers (For testing animations)
        window.suaraSimulate = {
            levelUp: () => {
                const el = document.querySelector('[x-data]');
                if (el) el.__x.$data.triggerLevelUp('Penggerak');
            },
            badge: () => {
                const el = document.querySelector('[x-data]');
                if (el) el.__x.$data.triggerBadge('Veteran', 'shield-check');
            },
            xp: () => {
                const el = document.querySelector('[x-data]');
                if (el) el.__x.$data.addNotification('+50 XP', 'xp');
            }
        };

        function setDashboardView(view) {
            // Sidebar buttons
            const buttons = ['dashboard', 'monitoring', 'suara', 'reputasi', 'pengaturan'];
            buttons.forEach(b => {
                const btn = document.getElementById('side-' + b);
                const viewEl = document.getElementById('view-' + b);
                
                if (btn) {
                    if (b === view) {
                        btn.classList.add('bg-accent', 'text-white', 'shadow-xl', 'shadow-accent/20');
                        btn.classList.remove('text-slate-600', 'hover:bg-slate-50', 'hover:text-accent');
                    } else {
                        btn.classList.remove('bg-accent', 'text-white', 'shadow-xl', 'shadow-accent/20');
                        btn.classList.add('text-slate-600', 'hover:bg-slate-50', 'hover:text-accent');
                    }
                }

                if (viewEl) {
                    if (b === view) {
                        viewEl.classList.remove('hidden');
                    } else {
                        viewEl.classList.add('hidden');
                    }
                }
            });

            // Handle bottom motivation visibility
            const emptyState = document.getElementById('empty-state-motivation');
            if (emptyState) {
                if (view === 'monitoring') {
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                }
            }

            setTimeout(() => {
                if (window.lucide) {
                    lucide.createIcons();
                }
            }, 30);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const initialView = urlParams.get('view') || 'dashboard';
            setDashboardView(initialView);
        });

        // ==========================================
        // AVATAR UPLOAD, CROP & COMPRESSION LOGIC
        // ==========================================
        let cropperInstance = null;
        let currentCropBlob = null;
        let currentFlipX = 1;

        function triggerAvatarUpload() {
            const input = document.getElementById('avatarFileInput');
            if (input) {
                input.value = '';
                input.click();
            }
        }

        function handleAvatarFileSelect(input) {
            if (!input.files || !input.files[0]) return;
            const file = input.files[0];

            if (!file.type.match(/^image\/(jpeg|png|webp|gif|jpg)$/i)) {
                alert('Silakan pilih file gambar yang valid (JPG, PNG, atau WebP).');
                return;
            }

            if (file.size > 10 * 1024 * 1024) {
                alert('Ukuran file gambar maksimal 10 MB.');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                openAvatarCropModal(e.target.result);
            };
            reader.readAsDataURL(file);
        }

        function openAvatarCropModal(imageSrc) {
            const modal = document.getElementById('avatarCropModal');
            const image = document.getElementById('avatarCropImage');
            if (!modal || !image) return;

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            image.src = imageSrc;

            if (cropperInstance) {
                cropperInstance.destroy();
                cropperInstance = null;
            }

            currentFlipX = 1;

            image.onload = function() {
                cropperInstance = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 1,
                    dragMode: 'move',
                    autoCropArea: 0.9,
                    restore: false,
                    guides: true,
                    center: true,
                    highlight: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false,
                    preview: '#cropCirclePreview',
                    crop(event) {
                        updateCompressEstimate();
                    }
                });

                setTimeout(() => {
                    if (window.lucide) lucide.createIcons();
                }, 50);
            };
        }

        function closeAvatarCropModal() {
            const modal = document.getElementById('avatarCropModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
            if (cropperInstance) {
                cropperInstance.destroy();
                cropperInstance = null;
            }
            const input = document.getElementById('avatarFileInput');
            if (input) input.value = '';
        }

        function cropperZoom(ratio) {
            if (cropperInstance) cropperInstance.zoom(ratio);
        }

        function cropperRotate(degree) {
            if (cropperInstance) cropperInstance.rotate(degree);
        }

        function cropperFlip() {
            if (!cropperInstance) return;
            currentFlipX = currentFlipX === 1 ? -1 : 1;
            cropperInstance.scaleX(currentFlipX);
        }

        function cropperReset() {
            if (!cropperInstance) return;
            currentFlipX = 1;
            cropperInstance.reset();
        }

        function updateCompressEstimate() {
            if (!cropperInstance) return;
            try {
                const canvas = cropperInstance.getCroppedCanvas({
                    width: 400,
                    height: 400,
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high'
                });
                if (!canvas) return;

                canvas.toBlob((blob) => {
                    if (!blob) return;
                    currentCropBlob = blob;
                    const kb = Math.round(blob.size / 1024);
                    const badge = document.getElementById('compressSizeBadge');
                    if (badge) badge.innerText = '~' + kb + ' KB (Terkompresi)';
                }, 'image/jpeg', 0.85);
            } catch (err) {
                console.error(err);
            }
        }

        function saveCroppedAvatar() {
            if (!cropperInstance) return;

            const btn = document.getElementById('btnSaveCrop');
            const originalBtnHtml = btn ? btn.innerHTML : '';
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = `<span class="inline-block animate-spin mr-2">⏳</span> Memproses...`;
            }

            const canvas = cropperInstance.getCroppedCanvas({
                width: 400,
                height: 400,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high'
            });

            if (!canvas) {
                alert('Gagal memproses pemotongan gambar.');
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = originalBtnHtml;
                }
                return;
            }

            // High efficiency JPEG compression (0.85 quality)
            const base64Data = canvas.toDataURL('image/jpeg', 0.85);

            // Update hidden input in form
            const formInput = document.getElementById('avatarBase64FormInput');
            if (formInput) formInput.value = base64Data;

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            fetch('{{ route("profile.avatar") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ image: base64Data })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    updatePageAvatars(data.avatar_url);

                    const delBtn = document.getElementById('btnDeleteAvatar');
                    if (delBtn) delBtn.classList.remove('hidden');

                    closeAvatarCropModal();
                    showFloatingToast('Foto profil berhasil di-crop, di-kompres, dan disimpan!');
                } else {
                    alert(data.message || 'Gagal menyimpan foto profil.');
                }
            })
            .catch(err => {
                console.error('Avatar upload error:', err);
                updatePageAvatars(base64Data);
                closeAvatarCropModal();
                showFloatingToast('Foto profil siap disimpan bersama data form.');
            })
            .finally(() => {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = originalBtnHtml;
                }
            });
        }

        function deleteUserAvatar() {
            if (!confirm('Apakah Anda yakin ingin menghapus foto profil ini dan kembali ke avatar default?')) return;

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            fetch('{{ route("profile.avatar.remove.post") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    resetPageAvatarsToDefault();
                    const delBtn = document.getElementById('btnDeleteAvatar');
                    if (delBtn) delBtn.classList.add('hidden');

                    const formInput = document.getElementById('avatarBase64FormInput');
                    if (formInput) formInput.value = '';

                    showFloatingToast('Foto profil berhasil dihapus.');
                }
            })
            .catch(err => {
                console.error('Error delete avatar:', err);
            });
        }

        function updatePageAvatars(imageUrl) {
            // Settings avatar container
            const settingsContainer = document.getElementById('settingsAvatarContainer');
            if (settingsContainer) {
                settingsContainer.innerHTML = `<img id="settingsAvatarImg" src="${imageUrl}" alt="User Avatar" class="w-full h-full object-cover">`;
            }

            // Navbar avatar
            const navImg = document.getElementById('navbarAvatarImg');
            const navSvg = document.getElementById('navbarAvatarSvg');
            if (navImg) {
                navImg.src = imageUrl;
            } else if (navSvg && navSvg.parentElement) {
                navSvg.parentElement.innerHTML = `<img id="navbarAvatarImg" src="${imageUrl}" alt="User Avatar" class="w-full h-full object-cover global-user-avatar">`;
            }

            // Dashboard profile card
            const cardImgs = document.querySelectorAll('.global-user-avatar-card');
            cardImgs.forEach(img => { img.src = imageUrl; });
            const cardSvgs = document.querySelectorAll('.global-user-avatar-card-svg');
            cardSvgs.forEach(svg => {
                if (svg.parentElement) {
                    svg.parentElement.innerHTML = `<img src="${imageUrl}" alt="User Avatar" class="w-full h-full object-cover global-user-avatar-card">`;
                }
            });
        }

        function resetPageAvatarsToDefault() {
            const settingsContainer = document.getElementById('settingsAvatarContainer');
            if (settingsContainer) {
                settingsContainer.innerHTML = `
                    <svg id="settingsAvatarSvg" class="w-full h-full" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="35" r="20" fill="url(#avatarGrad1)" />
                        <path d="M20,85 Q50,60 80,85 L80,100 L20,100 Z" fill="url(#navAvatarGrad2)" />
                    </svg>
                `;
            }

            const navImg = document.getElementById('navbarAvatarImg');
            if (navImg && navImg.parentElement) {
                navImg.parentElement.innerHTML = `
                    <div id="navbarAvatarSvg" class="w-full h-full flex items-center justify-center">
                        <svg class="w-full h-full" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="35" r="20" fill="url(#navAvatarGrad1)" />
                            <path d="M20,85 Q50,60 80,85 L80,100 L20,100 Z" fill="url(#navAvatarGrad2)" />
                        </svg>
                    </div>
                `;
            }

            const cardImgs = document.querySelectorAll('.global-user-avatar-card');
            cardImgs.forEach(img => {
                if (img.parentElement) {
                    img.parentElement.innerHTML = `
                        <div class="global-user-avatar-card-svg w-full h-full flex items-center justify-center">
                            <svg class="w-full h-full scale-110" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="50" cy="35" r="20" fill="url(#avatarGrad1)" />
                                <path d="M20,85 Q50,60 80,85 L80,100 L20,100 Z" fill="url(#avatarGrad2)" />
                            </svg>
                        </div>
                    `;
                }
            });
        }

        function showFloatingToast(msg) {
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-8 right-8 z-[300] bg-slate-900 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 border border-slate-700 animate-fade-in text-sm font-bold';
            toast.innerHTML = `<i data-lucide="check-circle" class="w-5 h-5 text-emerald-400 flex-shrink-0"></i> <span>${msg}</span>`;
            document.body.appendChild(toast);
            if (window.lucide) lucide.createIcons();
            setTimeout(() => {
                toast.style.transition = 'all 0.4s ease';
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(10px)';
                setTimeout(() => toast.remove(), 400);
            }, 3500);
        }
    </script>

    <!-- Modal: Crop & Compress Avatar -->
    <div id="avatarCropModal" class="fixed inset-0 z-[200] hidden items-center justify-center p-4 bg-slate-950/70 backdrop-blur-md transition-all duration-300">
        <div class="bg-white rounded-[32px] w-full max-w-2xl shadow-2xl border border-slate-100 overflow-hidden flex flex-col max-h-[92vh] animate-fade-in">
            <!-- Modal Header -->
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-accent/10 text-accent flex items-center justify-center">
                        <i data-lucide="crop" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-outfit font-black text-slate-900">Crop & Kompres Foto Profil</h3>
                        <p class="text-xs text-slate-400 font-medium">Sesuaikan posisi, zoom, dan rotasi foto</p>
                    </div>
                </div>
                <button type="button" onclick="closeAvatarCropModal()" class="w-9 h-9 rounded-xl hover:bg-slate-200/60 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                    <!-- Cropper Area (Left) -->
                    <div class="md:col-span-2">
                        <div class="w-full h-72 sm:h-80 bg-slate-950 rounded-2xl overflow-hidden relative flex items-center justify-center border border-slate-200">
                            <img id="avatarCropImage" src="" alt="Crop image" class="max-w-full">
                        </div>
                    </div>

                    <!-- Live Preview & Controls (Right) -->
                    <div class="flex flex-col items-center text-center space-y-4">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Hasil Preview Bulat</p>
                        <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-accent shadow-xl relative bg-slate-100">
                            <div id="cropCirclePreview" class="w-full h-full overflow-hidden"></div>
                        </div>

                        <!-- Compression Info Badge -->
                        <div class="w-full bg-slate-50 border border-slate-100 rounded-2xl p-3 space-y-1">
                            <div class="flex items-center justify-between text-[11px] font-bold text-slate-600">
                                <span class="flex items-center gap-1"><i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-500"></i> Smart Compress</span>
                                <span id="compressSizeBadge" class="text-emerald-600 font-black">~50 KB</span>
                            </div>
                            <p class="text-[9px] text-slate-400 leading-tight">Foto dioptimasi otomatis agar loading super cepat.</p>
                        </div>
                    </div>
                </div>

                <!-- Toolbar Controls -->
                <div class="flex flex-wrap items-center justify-between gap-3 p-3 bg-slate-50 rounded-2xl border border-slate-100">
                    <div class="flex items-center gap-1.5">
                        <button type="button" onclick="cropperZoom(0.1)" title="Zoom In" class="p-2.5 bg-white hover:bg-slate-100 text-slate-700 rounded-xl border border-slate-200/80 shadow-sm transition-all flex items-center justify-center">
                            <i data-lucide="zoom-in" class="w-4 h-4"></i>
                        </button>
                        <button type="button" onclick="cropperZoom(-0.1)" title="Zoom Out" class="p-2.5 bg-white hover:bg-slate-100 text-slate-700 rounded-xl border border-slate-200/80 shadow-sm transition-all flex items-center justify-center">
                            <i data-lucide="zoom-out" class="w-4 h-4"></i>
                        </button>
                        <button type="button" onclick="cropperRotate(-90)" title="Putar Kiri 90°" class="p-2.5 bg-white hover:bg-slate-100 text-slate-700 rounded-xl border border-slate-200/80 shadow-sm transition-all flex items-center justify-center">
                            <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                        </button>
                        <button type="button" onclick="cropperRotate(90)" title="Putar Kanan 90°" class="p-2.5 bg-white hover:bg-slate-100 text-slate-700 rounded-xl border border-slate-200/80 shadow-sm transition-all flex items-center justify-center">
                            <i data-lucide="rotate-cw" class="w-4 h-4"></i>
                        </button>
                        <button type="button" onclick="cropperFlip()" title="Balik Horizontal" class="p-2.5 bg-white hover:bg-slate-100 text-slate-700 rounded-xl border border-slate-200/80 shadow-sm transition-all flex items-center justify-center">
                            <i data-lucide="flip-horizontal" class="w-4 h-4"></i>
                        </button>
                    </div>

                    <button type="button" onclick="cropperReset()" class="px-3 py-2 text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors flex items-center gap-1">
                        <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i> Reset
                    </button>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="button" onclick="closeAvatarCropModal()" class="px-5 py-2.5 text-slate-600 hover:text-slate-900 font-bold text-sm transition-colors">
                    Batal
                </button>
                <button type="button" id="btnSaveCrop" onclick="saveCroppedAvatar()" class="px-6 py-2.5 bg-accent hover:bg-accent/90 text-white font-black text-sm uppercase tracking-wider rounded-xl shadow-lg shadow-accent/20 hover:scale-105 active:scale-95 transition-all flex items-center gap-2">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Terapkan & Simpan Foto</span>
                </button>
            </div>
        </div>
    </div>
</body>
</html>
