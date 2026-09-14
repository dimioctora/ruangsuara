<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suara - Dari Suara Jadi Aksi Nyata</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind CSS 3 CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0F172A',
                        accent: '#2563EB',
                        success: '#10B981',
                        brandAccent: '#F59E0B',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        outfit: ['Outfit', 'sans-serif'],
                    },
                    backgroundImage: {
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800;900&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500&display=swap');

        :root {
            --accent: #2563EB;
            --success: #10B981;
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.4);
        }

        .glass {
            background: var(--glass-bg);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border: 1px solid var(--glass-border);
        }

        .glass-dark {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .blob {
            position: absolute;
            width: 500px;
            height: 500px;
            filter: blur(100px);
            z-index: -10;
            opacity: 0.3;
            pointer-events: none;
        }

        .grid-bg {
            background-image: radial-gradient(circle at 1px 1px, rgba(0,0,0,0.03) 1px, transparent 0);
            background-size: 40px 40px;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-30px) scale(1.05); }
        }

        .animate-float {
            animation: float 10s ease-in-out infinite;
        }

        @keyframes gradient-x {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .animate-gradient-x {
            background-size: 200% 200%;
            animation: gradient-x 15s ease infinite;
        }

        .hover-lift {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .hover-lift:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 30px 60px -12px rgba(50, 50, 93, 0.15), 0 18px 36px -18px rgba(0, 0, 0, 0.2);
        }

        .glow-on-hover:hover {
            box-shadow: 0 0 20px rgba(37, 99, 235, 0.3);
        }

        .text-gradient {
            background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #0f172a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Perspective for high-tech cards */
        .perspective-container {
            perspective: 2000px;
        }
        
        .tech-card {
            transform-style: preserve-3d;
            transition: transform 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .card-content {
            transform: translateZ(50px);
        }

        .rotate-y-2 {
            transform: rotateY(2deg);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans selection:bg-accent/20">
    <!-- Background Blobs (Wrapped in restricted container to prevent overflow) -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-[50]">
        <div class="blob bg-blue-200 top-[-100px] left-[-100px]"></div>
        <div class="blob bg-emerald-100 bottom-[20%] right-[-100px]"></div>
        <div class="blob bg-cyan-100 top-[40%] left-[20%]"></div>
    </div>

    <!-- Header / Navbar -->
    <header class="sticky top-0 z-[100] glass">
        <nav class="container mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo (Left) -->
            <a href="/" class="flex items-center group flex-shrink-0">
                <img src="{{ asset('images/suara-logo-transparent.png') }}" alt="Suara Logo" class="h-8 w-auto group-hover:scale-110 transition-transform drop-shadow-xl">
            </a>

            <!-- Menu Halaman (Tengah) -->
            <div class="hidden md:flex items-center gap-10 text-sm font-black text-slate-500 uppercase tracking-widest">
                <a href="/suara" class="hover:text-accent transition-all">Suara</a>
                <a href="/cara-kerja" class="hover:text-accent transition-all">Cara Kerja</a>
                <a href="/tentang" class="hover:text-accent transition-all">Tentang</a>
                <a href="#" class="hover:text-accent transition-all">Kontak</a>
            </div>

            <!-- Auth/User Module (Kanan) -->
            <div class="flex items-center gap-4">
                @auth
                    <!-- User Profile Module with Hover Dropdown -->
                    <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <div class="flex items-center gap-4 border-l border-slate-100 pl-8 ml-4 group focus:outline-none cursor-pointer py-2">
                            <div class="hidden md:flex flex-col items-end">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] leading-none mb-1">Selamat Datang,</span>
                                <span class="text-sm font-black font-outfit text-slate-900 tracking-tight">{{ auth()->user()->name ?? 'Dimi Octora' }}</span>
                            </div>
                            <div class="relative">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-slate-50 to-slate-100 border border-slate-200/50 flex items-center justify-center shadow-sm group-hover:shadow-md transition-all overflow-hidden relative">
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
                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-success border-2 border-white rounded-full"></div>
                            </div>
                        </div>

                        <!-- Dropdown Menu (Smaller & Hover Triggered) -->
                        <div class="absolute right-0 pt-2 w-52 z-[110]"
                             x-show="open" 
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

    <main>
        <!-- Hero Section -->
        <section class="relative min-h-screen w-full flex items-center justify-center overflow-hidden py-24">
            <!-- Full Page Background Elements -->
            <div class="absolute inset-0 bg-slate-50 -z-10"></div>
            <div class="blob bg-indigo-400/30 top-[-10%] left-[-5%] w-[800px] h-[800px]"></div>
            <div class="blob bg-purple-400/20 bottom-[-10%] right-[-5%] w-[800px] h-[800px]"></div>

            <div class="w-full px-6 md:px-20 grid lg:grid-cols-2 gap-16 items-center relative z-10">
                <!-- Hero Content -->
                <div class="max-w-4xl">
                    <div class="inline-flex items-center gap-3 bg-white/60 backdrop-blur-md px-6 py-2.5 rounded-full text-[10px] font-black uppercase tracking-[0.2em] text-accent border border-white/50 shadow-sm shadow-accent/5 mb-10">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-accent opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-accent"></span>
                        </span>
                        Platform Aspirasi Publik
                    </div>
                    <h1 class="text-7xl md:text-[110px] font-black font-outfit leading-[1.1] text-slate-900 mb-10 tracking-tighter py-4">
                        Ubah <span class="bg-clip-text text-transparent bg-gradient-to-r from-accent via-blue-700 to-indigo-900">Suara</span><br>
                        Jadi <span class="relative inline-block  bg-clip-text text-transparent bg-gradient-to-r from-red-600 to-slate-900 pr-10 py-2">
                            Aksi Nyata
                            <svg class="absolute -bottom-4 left-0 w-full h-4 text-red-600/10" viewBox="0 0 100 10" preserveAspectRatio="none">
                                <path d="M0 5 Q 25 0 50 5 T 100 5" fill="none" stroke="currentColor" stroke-width="6" />
                            </svg>
                        </span>
                    </h1>
                    <p class="text-slate-500 text-xl md:text-3xl leading-relaxed mb-14 max-w-2xl font-medium tracking-tight">
                        Platform transparansi dan kolaborasi massal untuk mewujudkan setiap aspirasi masyarakat secara langsung.
                    </p>
                    <div class="flex flex-wrap items-center gap-6 mb-20">
                        <a href="#" class="bg-gradient-to-r from-accent to-success text-white px-10 py-5 rounded-2xl font-bold font-outfit text-lg shadow-2xl shadow-primary/40 hover:scale-105 transition-all flex items-center gap-3 active:scale-95">
                            Mulai Sekarang <i data-lucide="arrow-right" class="w-6 h-6"></i>
                        </a>
                        <a href="/suara" class="bg-white text-slate-800 px-10 py-5 rounded-2xl font-bold font-outfit text-lg shadow-md border border-slate-100 hover:bg-slate-50 transition-all active:scale-95">
                            Kawal Suara
                        </a>
                    </div>
                    
                    <!-- Hero Stats -->
                    <div class="flex items-center gap-16">
                        <div class="group cursor-default">
                            <div id="heroActiveStats" class="text-4xl font-extrabold text-slate-900 group-hover:text-accent transition-colors">{{ number_format($activeReportsCount, 0, ',', '.') }}</div>
                            <div class="text-sm font-bold text-slate-400 uppercase tracking-[0.2em]">Laporan Aktif</div>
                        </div>
                        <div class="w-px h-14 bg-slate-200"></div>
                        <div class="group cursor-default">
                            <div id="heroVisitorStats" class="text-4xl font-extrabold text-slate-900 group-hover:text-secondary transition-colors">{{ $visitorDisplay }}</div>
                            <div class="text-sm font-bold text-slate-400 uppercase tracking-[0.2em]">Pendukung</div>
                        </div>
                    </div>
                </div>

                <!-- Hero Visual Elements: Floating Balloon Cards -->
                <div class="relative h-[85vh] flex items-center justify-center">
                    <!-- Indonesia Dotted Map Image -->
                    <div class="absolute inset-0 flex items-center justify-center -z-10 bg-no-repeat bg-center opacity-[0.35]">
                        <img src="{{ asset('images/indonesia-map.png') }}" alt="Indonesia Map" class="w-[1400px] h-auto object-contain">
                    </div>

                    <!-- Balloon Simulation Area -->
                    <div class="absolute inset-0">
                        @foreach($recentIssues as $index => $suara)
                        @php
                            $colors = ['bg-red-500', 'bg-orange-500', 'bg-emerald-500', 'bg-blue-500', 'bg-purple-500', 'bg-yellow-500', 'bg-pink-500', 'bg-indigo-500', 'bg-cyan-500', 'bg-teal-500'];
                            $color = $colors[$index % count($colors)];
                            $delay = ($index * 2) . 's';
                            $left = (10 + ($index * 12) % 80);
                            $duration = (18 + ($index * 3) % 15) . 's';
                            $scale = $suara->supporter_count > 5000 ? 'scale-125' : ($suara->supporter_count > 1000 ? 'scale-110' : 'scale-90');
                        @endphp
                        <div class="absolute bottom-[-20%] left-[{{ $left }}%] {{ $scale }} glass rounded-2xl p-5 shadow-2xl animate-balloon opacity-0 border border-white/50" 
                             style="animation-delay: {{ $delay }}; animation-duration: {{ $duration }};">
                            <a href="{{ url('/suara-detail/' . $suara->id) }}" class="absolute inset-0 z-10"></a>
                            <div class="flex items-center justify-between gap-6 mb-4">
                                <div class="w-10 h-10 rounded-xl {{ $color }} flex items-center justify-center text-white shadow-lg">
                                    <i data-lucide="bell" class="w-5 h-5"></i>
                                </div>
                                <span class="bg-slate-100 text-slate-500 text-[10px] font-black px-3 py-1.5 rounded-lg uppercase tracking-wider">AKTIF</span>
                            </div>
                            <h4 class="font-black text-slate-900 text-base mb-3 leading-tight tracking-tight">{{ $suara->title }}</h4>
                            <div class="flex items-center gap-2 text-accent">
                                <i data-lucide="trending-up" class="w-4 h-4"></i>
                                <span class="text-sm font-black font-outfit">{{ number_format($suara->supporter_count, 0, ',', '.') }}</span>
                                <span class="text-[10px] text-slate-400 font-bold ml-1">Penerima Aspirasi</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Glow effect behind balloons -->
                    <div class="absolute inset-0 bg-gradient-radial from-indigo-200/20 via-transparent to-transparent -z-10 rounded-full blur-3xl"></div>
                </div>
            </div>
        </section>

        <!-- Animation Style -->
        <style>
            @keyframes balloon {
                0% { 
                    transform: translateY(0) translateX(0) rotate(0deg); 
                    opacity: 0; 
                }
                10% { opacity: 1; }
                50% { 
                    transform: translateY(-50vh) translateX(30px) rotate(5deg); 
                }
                90% { opacity: 1; }
                100% { 
                    transform: translateY(-110vh) translateX(-20px) rotate(-5deg); 
                    opacity: 0; 
                }
            }
            .animate-balloon {
                animation: balloon linear infinite;
            }
            /* Scroll Reveal Classes */
            .reveal-on-scroll {
                opacity: 0;
                transform: translateY(30px);
                transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .reveal-on-scroll.active {
                opacity: 1;
                transform: translateY(0);
            }
            ::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }

        html, body {
            max-width: 100%;
            overflow-x: hidden !important;
            margin: 0;
            padding: 0;
        }

        /* Prevent double scrollbars */
        ::-webkit-scrollbar {
            width: 8px;
        }
    </style>

        <!-- Bagaimana Kami Bekerja Section -->
        <section class="py-24 relative overflow-hidden reveal-on-scroll bg-white">
            <div class="container mx-auto px-6 relative z-10">
                <div class="text-center mb-20 max-w-4xl mx-auto">
                    <p class="text-accent text-sm font-black mb-4 uppercase tracking-[0.2em]">Transparansi Penuh</p>
                    <h2 class="text-4xl md:text-5xl font-black font-outfit text-slate-900 mb-6 tracking-tight leading-tight">
                        Bagaimana <span class="text-accent">Kami Bekerja</span>
                    </h2>
                    <p class="text-slate-500 text-lg md:text-xl font-medium max-w-2xl mx-auto">
                        Tiga langkah sederhana untuk mengubah setiap aspirasi menjadi tindakan yang dapat diukur dan dipertanggungjawabkan.
                    </p>
                </div>
                
                <div class="grid md:grid-cols-3 gap-8 relative">
                    <!-- Subtle connector line for desktop -->
                    <div class="hidden md:block absolute top-12 left-1/6 right-1/6 h-0.5 bg-gradient-to-r from-transparent via-slate-200 to-transparent z-0"></div>

                    <!-- Step 1 -->
                    <div class="relative bg-slate-50 border border-slate-100 rounded-3xl p-10 text-center hover:bg-white hover:shadow-xl transition-all duration-300 z-10 group">
                        <div class="w-20 h-20 mx-auto rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-accent mb-8 shadow-sm group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="upload-cloud" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 mb-4 font-outfit">Laporkan Isu</h3>
                        <p class="text-slate-500 leading-relaxed font-medium">Dokumentasikan masalah di sekitar Anda dengan foto dan deskripsi yang jelas dan lengkap.</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative bg-slate-50 border border-slate-100 rounded-3xl p-10 text-center hover:bg-white hover:shadow-xl transition-all duration-300 z-10 group mt-0 md:mt-8">
                        <div class="w-20 h-20 mx-auto rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-accent mb-8 shadow-sm group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="users" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 mb-4 font-outfit">Kumpulkan Dukungan</h3>
                        <p class="text-slate-500 leading-relaxed font-medium">Galang dukungan dari masyarakat untuk menvalidasi urgensi dari isu yang dilaporkan.</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative bg-slate-50 border border-slate-100 rounded-3xl p-10 text-center hover:bg-white hover:shadow-xl transition-all duration-300 z-10 group">
                        <div class="w-20 h-20 mx-auto rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-accent mb-8 shadow-sm group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="check-circle-2" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 mb-4 font-outfit">Jadi Aksi Nyata</h3>
                        <p class="text-slate-500 leading-relaxed font-medium">Koordinasikan solusi nyata bersama komunitas setelah ambang batas dukungan tercapai.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Command Center Visual Section -->
        <section class="py-24 bg-slate-50/50 relative overflow-hidden reveal-on-scroll">
            <div class="container mx-auto px-6">
                <div class="grid lg:grid-cols-2 gap-20 items-center">
                    <div class="relative">
                        <div class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100">
                             <div class="flex items-center justify-between mb-10 border-b border-slate-100 pb-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 rounded-full bg-success"></div>
                                    <span class="text-xs font-black text-slate-800 uppercase tracking-widest">Statistik Platform</span>
                                </div>
                             </div>
                             
                             <div class="space-y-6">
                                <!-- Metric 1: Total Gerakan -->
                                <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 flex items-center justify-between group hover:bg-white hover:shadow-md transition-all">
                                    <div>
                                        <p class="text-sm font-bold text-slate-500 mb-1">Total Gerakan</p>
                                        <p id="totalGerakanCount" class="text-4xl font-black text-slate-900 font-outfit" data-target="{{ $activeReportsCount }}">0</p>
                                    </div>
                                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-sm text-accent group-hover:scale-110 transition-transform">
                                        <i data-lucide="layers" class="w-7 h-7"></i>
                                    </div>
                                </div>

                                <!-- Metric 2: Selesai Bulan Ini -->
                                <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 flex items-center justify-between group hover:bg-white hover:shadow-md transition-all">
                                    <div>
                                        <p class="text-sm font-bold text-slate-500 mb-1">Selesai Bulan Ini</p>
                                        <p id="selesaiCount" class="text-4xl font-black text-slate-900 font-outfit" data-target="142">0</p>
                                    </div>
                                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-sm text-success group-hover:scale-110 transition-transform">
                                        <i data-lucide="check-circle-2" class="w-7 h-7"></i>
                                    </div>
                                </div>
                             </div>
                        </div>
                    </div>

                    <div class="lg:pl-10">
                        <div class="inline-flex px-4 py-2 rounded-full bg-accent/10 text-accent text-[10px] font-black uppercase tracking-widest mb-6">
                            Transparansi Data
                        </div>
                        <h2 class="text-4xl md:text-5xl font-black font-outfit text-slate-900 mb-6 tracking-tight leading-tight py-1">Aktivitas <span class="text-accent">Terkini</span></h2>
                        <p class="text-slate-500 text-lg leading-relaxed mb-10 font-medium">Log aktivitas sistem yang memantau pergerakan secara transparan dan seketika.</p>
                        
                        <div class="space-y-4">
                            <!-- Activity Card 1 -->
                            <div class="bg-white border border-slate-100 rounded-2xl p-5 flex items-start gap-4 shadow-sm hover:shadow-md transition-all">
                                <div class="w-2.5 h-2.5 rounded-full bg-accent mt-2"></div>
                                <div>
                                    <p class="text-slate-800 font-bold font-outfit text-base">Sarah mendaftarkan inisiatif baru</p>
                                    <p class="text-slate-400 text-xs font-medium mt-1">2 menit lalu</p>
                                </div>
                            </div>

                            <!-- Activity Card 2 -->
                            <div class="bg-white border border-slate-100 rounded-2xl p-5 flex items-start gap-4 shadow-sm hover:shadow-md transition-all">
                                <div class="w-2.5 h-2.5 rounded-full bg-success mt-2"></div>
                                <div>
                                    <p class="text-slate-800 font-bold font-outfit text-base">156 orang mendukung kampanye kebersihan</p>
                                    <p class="text-slate-400 text-xs font-medium mt-1">15 menit lalu</p>
                                </div>
                            </div>

                            <!-- Activity Card 3 -->
                            <div class="bg-white border border-slate-100 rounded-2xl p-5 flex items-start gap-4 shadow-sm hover:shadow-md transition-all">
                                <div class="w-2.5 h-2.5 rounded-full bg-orange-500 mt-2"></div>
                                <div>
                                    <p class="text-slate-800 font-bold font-outfit text-base">Target pendanaan logistik terpenuhi</p>
                                    <p class="text-slate-400 text-xs font-medium mt-1">1 jam lalu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <!-- Recently Listed Issues Section (Slider) -->
        <section class="py-24 bg-slate-50/30 overflow-hidden reveal-on-scroll">
            <div class="container mx-auto px-6">
                <div class="flex flex-col md:flex-row items-end justify-between mb-24 gap-12">
                    <div class="max-w-2xl">
                        <div class="inline-flex px-4 py-2 rounded-full bg-accent/10 text-accent text-[10px] font-black uppercase tracking-widest mb-6">
                            Kampanye & Petisi
                        </div>
                        <h2 class="text-4xl md:text-5xl font-black font-outfit text-slate-900 leading-tight tracking-tight py-4">Suara <span class="text-accent">Terbaru</span></h2>
                    </div>
                    
                    <!-- Swiper Navigation Arrows -->
                    <div class="flex items-center gap-4">
                        <button id="prevBtn" class="w-14 h-14 rounded-2xl bg-white shadow-xl flex items-center justify-center hover:bg-accent hover:text-white transition-all active:scale-90 group">
                            <i data-lucide="chevron-left" class="w-6 h-6 group-hover:-translate-x-1 transition-transform"></i>
                        </button>
                        <button id="nextBtn" class="w-14 h-14 rounded-2xl bg-white shadow-xl flex items-center justify-center hover:bg-accent hover:text-white transition-all active:scale-90 group">
                            <i data-lucide="chevron-right" class="w-6 h-6 group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>
                </div>

                <!-- Swiper Container -->
                <div class="swiper recentIssuesSwiper overflow-hidden">
                    <div class="swiper-wrapper">
                        @foreach($recentIssues as $index => $suara)
                        @php
                            $tags = ['CRITICAL', 'POPULAR', 'NEW'];
                            $tag = $tags[$index % 3];
                            $tagColor = $tag == 'CRITICAL' ? 'bg-red-500' : ($tag == 'POPULAR' ? 'bg-brandAccent' : 'bg-emerald-500');
                            
                            // Robust Image Loader
                            if ($suara->image) {
                                if (str_starts_with($suara->image, 'http')) {
                                    $img = $suara->image;
                                } else if (str_starts_with($suara->image, 'images/')) {
                                    $img = asset($suara->image);
                                } else {
                                    $img = asset('storage/' . $suara->image);
                                }
                            } else {
                                $img = 'https://images.unsplash.com/photo-1545147986-a9d6f210df77?auto=format&fit=crop&q=80&w=800';
                            }

                            // Dynamic Progress Tracking
                            $proCount = $suara->supporter_count ?? 0;
                            $kontraCount = $suara->opponent_count ?? 0;
                            $totalVoices = $proCount + $kontraCount;
                            
                            if ($totalVoices > 0) {
                                $proPercent = round(($proCount / $totalVoices) * 100);
                                $kontraPercent = 100 - $proPercent;
                            } else {
                                $proPercent = 0;
                                $kontraPercent = 0;
                            }
                            
                            $currentSupport = $suara->supporter_count > 0 ? $suara->supporter_count : rand(100, 500);
                            $target = $suara->target_voice > 0 ? $suara->target_voice : 1000;
                            $prog = min(round(($currentSupport / $target) * 100), 100);
                        @endphp
                        <div class="swiper-slide h-auto pb-8">
                            <div class="group relative h-full">
                                <a href="{{ url('/suara-detail/' . $suara->id) }}" class="absolute inset-0 z-[60] cursor-pointer"></a>
                                <div class="relative bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col h-full">
                                    <div class="w-full aspect-[5/4] relative overflow-hidden">
                                        <img src="{{ $img }}" alt="{{ $suara->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>
                                        <div class="absolute top-6 left-6 px-4 py-2 {{ $tagColor }} rounded-xl text-[10px] font-black text-white uppercase tracking-widest border border-white/20">
                                            {{ $tag }}
                                        </div>
                                        @if($suara->supporter_count > 1000)
                                        <div class="absolute bottom-6 right-6 px-3 py-1.5 bg-accent/90 backdrop-blur rounded-lg flex items-center gap-2 text-white border border-white/20">
                                            <i data-lucide="users" class="w-3.5 h-3.5"></i>
                                            <span class="text-[10px] font-black">{{ number_format($suara->supporter_count / 1000, 1) }}K+ Pendukung</span>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="p-10 flex flex-col flex-1">
                                        <div class="flex items-center gap-2 text-[10px] font-bold text-accent uppercase tracking-widest mb-4">
                                            <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                                            {{ $suara->location }} | {{ $suara->category }}
                                        </div>
                                        <h3 class="text-3xl font-black text-slate-900 mb-10 font-outfit leading-tight tracking-tighter line-clamp-2">{{ $suara->title }}</h3>
                                        
                                        <div class="space-y-4 mb-10 mt-auto">
                                            <div class="flex justify-between items-end">
                                                <span class="text-[10px] font-mono text-slate-400 font-black uppercase tracking-widest">Support Percentage</span>
                                                <span class="text-lg font-black font-outfit text-accent">{{ $proPercent }}%</span>
                                            </div>
                                            <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden flex">
                                                <div class="h-full bg-accent transition-all duration-1000" style="width: {{ $proPercent }}%"></div>
                                                <div class="h-full bg-red-400 transition-all duration-1000" style="width: {{ $kontraPercent }}%"></div>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between border-t border-slate-50 pt-8">
                                            <div class="flex items-center gap-3">
                                                <div class="flex -space-x-3">
                                                    @for($i=1; $i<=3; $i++)
                                                    <img src="https://i.pravatar.cc/100?u={{ $index.$i }}" class="w-11 h-11 rounded-xl border-[4px] border-white bg-slate-200 object-cover" alt="Avatar">
                                                    @endfor
                                                </div>
                                                <span class="text-[10px] font-bold text-slate-400 tracking-tight ml-2">Total {{ $kontraCount }} Suara</span>
                                            </div>
                                            <div class="flex flex-col text-right">
                                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Dibutuhkan</span>
                                                <span class="text-xs font-black text-slate-900 font-outfit">{{ number_format($totalVoices, 0, ',', '.') }}</span>
                                            </div>
                                            <!-- The entire card is now clickable via the stretched link above. This button is for visual only. -->
                                            <div class="w-14 h-14 rounded-2xl bg-slate-900 text-white flex items-center justify-center hover:bg-accent hover:scale-110 transition-all active:scale-95 shadow-xl">
                                                <i data-lucide="arrow-right" class="w-6 h-6"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- Premium CTA Section -->
        <section class="relative pt-32 pb-24 overflow-hidden reveal-on-scroll bg-[#020617]">
            <!-- Animated Mesh Glows -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[600px] bg-gradient-to-b from-red-500/20 to-transparent blur-[120px] rounded-full animate-pulse pointer-events-none"></div>
            <div class="absolute bottom-0 right-[-10%] w-[500px] h-[500px] bg-accent/10 blur-[100px] rounded-full pointer-events-none"></div>
            
            <!-- Clean Grid Overlay -->
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/graphy-dark.png')] opacity-[0.05] mix-blend-overlay pointer-events-none"></div>

            <div class="container mx-auto px-6 relative z-10 text-center">
                <div class="inline-flex items-center gap-2.5 bg-slate-900/50 border border-slate-700/50 px-5 py-2 rounded-full shadow-xl shadow-red-900/20 mb-12 animate-bounce cursor-default backdrop-blur-sm">
                    <div class="w-2 h-2 rounded-full bg-red-500 shadow-[0_0_10px_rgba(239,68,68,0.8)]"></div>
                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-white">Aksi Nyata untuk Indonesia</span>
                </div>
                
                <h2 class="text-7xl md:text-[100px] font-outfit font-black text-white mb-10 leading-tight tracking-tighter drop-shadow-xl">
                    Mulai Perubahan <br> 
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-red-500 via-rose-400 to-orange-400">Hari Ini</span>
                </h2>
                
                <p class="text-slate-300 text-xl md:text-2xl mb-16 max-w-2xl mx-auto leading-relaxed font-medium">
                    Bergabung dengan ribuan pembuat perubahan yang telah bergerak hari ini. Tidak perlu izin khusus, <span class="text-white font-bold">hanya niat tulus.</span>
                </p>
                
                <div class="flex flex-col items-center gap-12">
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-accent via-success to-accent rounded-[2rem] blur opacity-40 group-hover:opacity-75 transition duration-1000 group-hover:duration-200 animate-gradient-x"></div>
                        <button onclick="toggleAuthModal('signup')" class="relative flex items-center gap-4 bg-slate-900 text-white font-black px-14 py-6 rounded-[2rem] shadow-2xl transition-all hover:scale-[1.05] hover:shadow-accent/40 active:scale-95 text-xl group border border-slate-700">
                            <span>Gabung Sekarang</span>
                            <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center group-hover:bg-white/20 transition-colors">
                                <i data-lucide="arrow-right" class="w-5 h-5"></i>
                            </div>
                        </button>
                    </div>
                    
                    <div class="flex flex-wrap justify-center gap-12 border-t border-slate-800 pt-12 w-full max-w-4xl text-slate-300">
                        <div class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-800/50 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform text-emerald-400 border border-slate-700">
                                <i data-lucide="shield-check" class="w-6 h-6"></i>
                            </div>
                            <div class="text-left">
                                <p class="text-xs font-black uppercase tracking-widest text-slate-400 leading-none mb-1">Privasi Aman</p>
                                <p class="text-sm font-bold text-white">Enkripsi End-to-End</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-800/50 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform text-blue-400 border border-slate-700">
                                <i data-lucide="zap" class="w-6 h-6"></i>
                            </div>
                            <div class="text-left">
                                <p class="text-xs font-black uppercase tracking-widest text-slate-400 leading-none mb-1">Instan</p>
                                <p class="text-sm font-bold text-white">Proses < 2 Menit</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-800/50 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform text-orange-400 border border-slate-700">
                                <i data-lucide="globe" class="w-6 h-6"></i>
                            </div>
                            <div class="text-left">
                                <p class="text-xs font-black uppercase tracking-widest text-slate-400 leading-none mb-1">Akses Luas</p>
                                <p class="text-sm font-bold text-white">514 Kabupaten/Kota</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Premium Dark Footer -->
    <footer class="bg-[#020617] relative overflow-hidden pt-24 pb-12 text-slate-400">
        <!-- Subtle Footer Glow -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-px bg-gradient-to-r from-transparent via-slate-700/50 to-transparent"></div>
        <div class="absolute top-[-200px] left-1/2 -translate-x-1/2 w-[600px] h-[400px] bg-accent/5 blur-[120px] rounded-full -z-0"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-12 gap-16 mb-24">
                <!-- Brand Info -->
                <div class="lg:col-span-5">
                    <a href="/" class="flex items-center mb-8 group">
                        <img src="{{ asset('images/suara-logo-transparent.png') }}" alt="Suara Logo" class="h-8 w-auto group-hover:rotate-6 transition-transform drop-shadow-2xl">
                    </a>
                    <p class="text-slate-400 text-lg leading-relaxed mb-10 max-w-md">
                        Menggerakkan perubahan melalui kolaborasi radikal dan transparansi total untuk Indonesia yang lebih baik.
                    </p>
                    <div class="flex items-center gap-4">
                        <a href="#" class="w-12 h-12 bg-slate-900 border border-slate-800 rounded-xl flex items-center justify-center hover:bg-accent hover:border-accent hover:-translate-y-1 transition-all text-slate-500 hover:text-white group">
                            <i data-lucide="instagram" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-slate-900 border border-slate-800 rounded-xl flex items-center justify-center hover:bg-accent hover:border-accent hover:-translate-y-1 transition-all text-slate-500 hover:text-white group">
                            <i data-lucide="twitter" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-slate-900 border border-slate-800 rounded-xl flex items-center justify-center hover:bg-accent hover:border-accent hover:-translate-y-1 transition-all text-slate-500 hover:text-white group">
                            <i data-lucide="linkedin" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-slate-900 border border-slate-800 rounded-xl flex items-center justify-center hover:bg-accent hover:border-accent hover:-translate-y-1 transition-all text-slate-500 hover:text-white group">
                            <i data-lucide="github" class="w-5 h-5"></i>
                        </a>
                    </div>
                </div>

                <!-- Link Columns -->
                <div class="lg:col-span-7 grid md:grid-cols-3 gap-12">
                    <div>
                        <h4 class="text-white font-black font-outfit uppercase tracking-[0.2em] text-xs mb-10">Produk</h4>
                        <ul class="space-y-6 text-sm font-medium">
                            <li><a href="#" class="hover:text-accent transition-all flex items-center gap-2 group "><span class="w-0 group-hover:w-4 h-px bg-accent transition-all"></span>Fitur Utama</a></li>
                            <li><a href="#" class="hover:text-accent transition-all flex items-center gap-2 group "><span class="w-0 group-hover:w-4 h-px bg-accent transition-all"></span>Cara Kerja</a></li>
                            <li><a href="#" class="hover:text-accent transition-all flex items-center gap-2 group "><span class="w-0 group-hover:w-4 h-px bg-accent transition-all"></span>Direktori</a></li>
                            <li><a href="#" class="hover:text-accent transition-all flex items-center gap-2 group "><span class="w-0 group-hover:w-4 h-px bg-accent transition-all"></span>Eksplorasi</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-black font-outfit uppercase tracking-[0.2em] text-xs mb-10">Perusahaan</h4>
                        <ul class="space-y-6 text-sm font-medium">
                            <li><a href="#" class="hover:text-accent transition-all flex items-center gap-2 group "><span class="w-0 group-hover:w-4 h-px bg-accent transition-all"></span>Tentang Kami</a></li>
                            <li><a href="#" class="hover:text-accent transition-all flex items-center gap-2 group "><span class="w-0 group-hover:w-4 h-px bg-accent transition-all"></span>Karir</a></li>
                            <li><a href="#" class="hover:text-accent transition-all flex items-center gap-2 group "><span class="w-0 group-hover:w-4 h-px bg-accent transition-all"></span>Berita</a></li>
                            <li><a href="#" class="hover:text-accent transition-all flex items-center gap-2 group "><span class="w-0 group-hover:w-4 h-px bg-accent transition-all"></span>Kontak</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-black font-outfit uppercase tracking-[0.2em] text-xs mb-10">Legal</h4>
                        <ul class="space-y-6 text-sm font-medium">
                            <li><a href="#" class="hover:text-accent transition-all flex items-center gap-2 group "><span class="w-0 group-hover:w-4 h-px bg-accent transition-all"></span>Privasi</a></li>
                            <li><a href="#" class="hover:text-accent transition-all flex items-center gap-2 group "><span class="w-0 group-hover:w-4 h-px bg-accent transition-all"></span>Syarat</a></li>
                            <li><a href="#" class="hover:text-accent transition-all flex items-center gap-2 group "><span class="w-0 group-hover:w-4 h-px bg-accent transition-all"></span>Cookies</a></li>
                            <li><a href="#" class="hover:text-accent transition-all flex items-center gap-2 group "><span class="w-0 group-hover:w-4 h-px bg-accent transition-all"></span>Mitra</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="pt-12 border-t border-slate-800/50 flex flex-col md:row items-center justify-between gap-8 text-[11px] font-bold uppercase tracking-widest text-slate-500">
                <div class="flex items-center gap-8">
                    <span>&copy; 2026 Suara HQ</span>
                    <span class="hidden md:block w-1 h-1 rounded-full bg-slate-700"></span>
                    <span class="flex items-center gap-2  lowercase text-slate-500 font-medium">
                        Dibuat dengan <i data-lucide="flame" class="w-3.5 h-3.5 text-orange-500 fill-orange-500"></i> untuk Indonesia
                    </span>
                </div>
                
                <div class="flex items-center gap-8 bg-slate-900/50 border border-slate-800/50 px-6 py-3 rounded-2xl">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-success animate-pulse"></div>
                        <span>Status: Sistem Normal</span>
                    </div>
                    <div class="w-px h-4 bg-slate-800"></div>
                    <div class="flex items-center gap-2 lowercase  text-slate-400 font-medium">
                        Bahasa: 
                        <select class="bg-transparent border-none outline-none text-white hover:text-accent transition-colors cursor-pointer">
                            <option value="id">ID</option>
                            <option value="en">EN</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </footer>



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
                            <button type="button" class="flex items-center justify-center gap-3 py-4 border border-slate-100 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 transition-all">
                                <svg class="w-5 h-5" viewBox="0 0 24 24"><path fill="#fbbc05" d="M5.1 12c0-.7.1-1.4.3-2.1L1.1 6.6C.4 8.2 0 10.1 0 12s.4 3.8 1.1 5.4l4.3-3.3c-.2-.7-.3-1.4-.3-2.1z"/><path fill="#ea4335" d="M12 4.1c1.6 0 3.1.6 4.2 1.5l3.1-3.1C17.3 1 14.8 0 12 0 7.3 0 3.3 2.7 1.1 6.6L5.4 9.9c1.1-3.3 4.2-5.8 6.6-5.8z"/><path fill="#34a853" d="M12 19.9c-2.4 0-4.5-2.5-5.6-5.8L2.1 17.4C4.3 21.3 8.3 24 13 24c3.4 0 6.2-1.1 8.3-2.9l-4.1-3.1c-1.2.8-2.6 1.1-4.2 1.1z"/><path fill="#4285f4" d="M24 12c0-.8-.1-1.7-.2-2.5H12v4.8h6.8c-.3 1.5-1.1 2.8-2.4 3.6l4.1 3.1c2.4-2.1 4.5-5.2 4.5-9z"/></svg>
                                <span class="text-xs">Google</span>
                            </button>
                            <button type="button" class="flex items-center justify-center gap-3 py-4 border border-slate-100 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 transition-all">
                                <i data-lucide="apple" class="w-5 h-5"></i>
                                <span class="text-xs">Apple ID</span>
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

    <script>
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
            
            if (tab === 'login') {
                loginBtn.classList.add('text-accent', 'border-primary');
                loginBtn.classList.remove('text-slate-400', 'border-transparent');
                signupBtn.classList.remove('text-accent', 'border-primary');
                signupBtn.classList.add('text-slate-400', 'border-transparent');
                loginView.classList.remove('hidden');
                signupView.classList.add('hidden');
            } else {
                signupBtn.classList.add('text-accent', 'border-primary');
                signupBtn.classList.remove('text-slate-400', 'border-transparent');
                loginBtn.classList.remove('text-accent', 'border-primary');
                loginBtn.classList.add('text-slate-400', 'border-transparent');
                signupView.classList.remove('hidden');
                loginView.classList.add('hidden');
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

        // Intersection Observer for scroll reveal
        const observerOptions = {
            threshold: 0.15
        };

        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    
                    // Trigger count-up for statistics
                    const counters = entry.target.querySelectorAll('[id$="Count"]');
                    counters.forEach(counter => {
                        const target = parseInt(counter.getAttribute('data-target'));
                        const duration = 2000;
                        let start = 0;
                        const increment = target / (duration / 16);
                        
                        const updateCount = () => {
                            start += increment;
                            if (start < target) {
                                counter.innerText = Math.floor(start).toLocaleString();
                                requestAnimationFrame(updateCount);
                            } else {
                                counter.innerText = target.toLocaleString();
                            }
                        };
                        updateCount();
                    });

                    revealObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal-on-scroll').forEach(section => {
            revealObserver.observe(section);
        });

        // Real-time Stats Polling
        async function fetchStats() {
            try {
                const response = await fetch('/api/stats');
                const data = await response.json();
                
                // Update Hero Stats
                const heroActive = document.getElementById('heroActiveStats');
                const heroVisitor = document.getElementById('heroVisitorStats');
                const commandCenterCount = document.getElementById('totalGerakanCount');

                if (heroActive) heroActive.innerText = data.activeReportsCount;
                if (heroVisitor) heroVisitor.innerText = data.visitorDisplay;
                
                // Update Command Center data-target for the counter to use if it hasn't run yet
                // or just update it directly if it already ran.
                if (commandCenterCount) {
                    const currentTarget = parseInt(commandCenterCount.getAttribute('data-target'));
                    if (data.rawActive !== currentTarget) {
                        commandCenterCount.setAttribute('data-target', data.rawActive);
                        // If it's already visible and "active", we might want to update the text directly
                        if (commandCenterCount.closest('.reveal-on-scroll').classList.contains('active')) {
                            commandCenterCount.innerText = data.rawActive.toLocaleString();
                        }
                    }
                }
            } catch (error) {
                console.error('Error fetching stats:', error);
            }
        }

        // Swiper Initialization
        const recentIssuesSwiper = new Swiper('.recentIssuesSwiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            grabCursor: true,
            centeredSlides: false,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },
            navigation: {
                nextEl: '#nextBtn',
                prevEl: '#prevBtn',
            },
            breakpoints: {
                640: {
                    slidesPerView: 1.2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 24,
                },
                1150: {
                    slidesPerView: 3,
                    spaceBetween: 32,
                },
            },
        });

        // Poll every 5 seconds
        setInterval(fetchStats, 5000);
    </script>
</body>
</html>
