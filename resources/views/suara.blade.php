<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelajahi Suara — Suara</title>
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
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .card-hover:hover {
            transform: translateY(-8px) scale(1.01);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.1);
        }
        .filter-panel {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
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

    <!-- Header / Navbar (Fixed on Top) -->
    <header class="fixed top-0 left-0 right-0 z-[100] bg-white/80 backdrop-blur-xl border-b border-slate-200/60 shadow-sm transition-all duration-300">
        <nav class="container mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo (Left) -->
            <a href="/" class="flex items-center group flex-shrink-0">
                <img src="{{ asset('images/suara-logo-transparent.png') }}" alt="Suara Logo" class="h-8 w-auto group-hover:scale-110 transition-transform drop-shadow-xl">
            </a>

            <!-- Menu Halaman (Tengah) -->
            <div class="hidden md:flex items-center gap-10 text-sm font-black text-slate-500 uppercase tracking-widest">
                <a href="/suara" class="hover:text-accent transition-all text-accent">Suara</a>
                <a href="/cara-kerja" class="hover:text-accent transition-all">Cara Kerja</a>
                <a href="/tentang" class="hover:text-accent transition-all">Tentang</a>
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

    <!-- Filter Side Panel -->
    <div id="filterOverlay" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[70] hidden opacity-0 transition-opacity duration-300" onclick="toggleFilter()"></div>
    <aside id="filterPanel" class="fixed top-0 right-0 h-full w-full max-w-[400px] bg-white z-[80] shadow-2xl translate-x-full filter-panel p-8">
        <div class="flex items-center justify-between mb-10">
            <h2 class="text-2xl font-outfit font-bold text-slate-800">Filter Pencarian</h2>
            <button onclick="toggleFilter()" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:text-slate-800 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <div class="space-y-10 overflow-y-auto max-h-[calc(100vh-200px)] pr-2">
            <!-- Location -->
            <div>
                <label class="block text-sm font-bold text-slate-500 uppercase tracking-widest mb-4">Lokasi</label>
                <div class="relative">
                    <i data-lucide="map-pin" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                    <select id="filterLocation" class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-primary/20 transition-all font-medium appearance-none">
                        <option value="">Seluruh Indonesia</option>
                        <option value="Jakarta">Jakarta</option>
                        <option value="Bandung">Bandung</option>
                        <option value="Surabaya">Surabaya</option>
                        <option value="Medan">Medan</option>
                    </select>
                </div>
            </div>

            <!-- Categories -->
            <div>
                <label class="block text-sm font-bold text-slate-500 uppercase tracking-widest mb-6">Kategori Isu</label>
                <div class="grid grid-cols-1 gap-4">
                    @php
                        $categories = [
                            ['name' => 'Lingkungan', 'icon' => 'leaf', 'count' => 523],
                            ['name' => 'Keadilan', 'icon' => 'scale', 'count' => 412],
                            ['name' => 'Hak Asasi Manusia', 'icon' => 'fingerprint', 'count' => 284],
                            ['name' => 'Pemerintah & Politik', 'icon' => 'landmark', 'count' => 612],
                            ['name' => 'Pendidikan', 'icon' => 'graduation-cap', 'count' => 312],
                            ['name' => 'Entertainment', 'icon' => 'tv', 'count' => 184],
                            ['name' => 'Suara Konsumen', 'icon' => 'shopping-cart', 'count' => 421],
                            ['name' => 'Infrastruktur', 'icon' => 'building-2', 'count' => 842],
                            ['name' => 'Lainnya', 'icon' => 'more-horizontal', 'count' => 95],
                        ];
                    @endphp
                    @foreach($categories as $cat)
                    <label class="flex items-center group cursor-pointer">
                        <input type="checkbox" name="filter_category" value="{{ $cat['name'] }}" class="hidden peer category-checkbox">
                        <div class="w-6 h-6 border-2 border-slate-200 rounded-lg flex items-center justify-center peer-checked:bg-primary peer-checked:border-primary transition-all group-hover:border-primary">
                            <i data-lucide="check" class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100"></i>
                        </div>
                        <div class="ml-4 flex-1 flex items-center justify-between">
                            <span class="font-semibold text-slate-600 group-hover:text-slate-900 transition-colors">{{ $cat['name'] }}</span>
                            <span class="text-xs font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full">{{ $cat['count'] }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Urgent Toggle -->
            <div class="p-6 bg-red-50 rounded-[24px] border border-red-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-500 text-white rounded-xl flex items-center justify-center">
                            <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <span class="block font-bold text-red-900 text-sm">Butuh Segera</span>
                            <span class="text-xs text-red-700/70 font-medium">Tampilkan isu kritis</span>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="urgentToggle" class="sr-only peer">
                        <div class="w-11 h-6 bg-red-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                    </label>
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0 p-8 border-t border-slate-100 bg-white grid grid-cols-2 gap-4">
            <button onclick="resetFilters()" class="py-4 border border-slate-200 text-slate-600 font-bold rounded-2xl hover:bg-slate-50 transition-colors">Reset</button>
            <button onclick="applyFilters()" class="py-4 bg-primary text-white font-bold rounded-2xl hover:shadow-lg shadow-primary/20 transition-all">Terapkan</button>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="pt-32 pb-40">
        <div class="container mx-auto px-6">
            <!-- Hero Header -->
            <div class="mb-14">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-outfit font-extrabold text-slate-900 mb-2">Halaman Suara</h1>
                        <p class="text-slate-500 font-medium ">Temukan dan kawal suara sosial di seluruh Indonesia</p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
                        <div class="relative flex-1 md:w-96 group">
                            <i data-lucide="search" class="absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-primary transition-colors"></i>
                            <input id="searchInput" type="text" placeholder="Cari isu, lokasi, atau tag..." class="w-full pl-14 pr-6 py-4 bg-white border border-slate-100 rounded-3xl shadow-sm focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all font-medium text-lg">
                        </div>
                        <button onclick="toggleFilter()" class="flex items-center gap-3 px-6 py-4 bg-white border border-slate-100 rounded-3xl shadow-sm hover:bg-slate-50 transition-all group active:scale-95">
                            <i data-lucide="sliders-horizontal" class="w-5 h-5 text-slate-500 group-hover:text-primary"></i>
                            <span class="font-bold text-slate-700">Filter</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- List Grid -->
            <div id="suaraContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 mb-16">
                @forelse($suaras as $m)
                    @include('partials.suara_card', ['m' => $m])
                @empty
                    <div id="initialEmptyState" class="col-span-full py-20 flex flex-col items-center justify-center text-center">
                        <i data-lucide="inbox" class="w-20 h-20 text-slate-200 mb-6"></i>
                        <h4 class="text-2xl font-black text-slate-400 uppercase">Belum ada Suara aktif</h4>
                        <p class="text-slate-400 mt-2">Jadilah yang pertama menyuarakan perubahan!</p>
                        <a href="/create-suara" class="mt-8 px-10 py-4 bg-primary text-white rounded-3xl font-black text-[10px] uppercase tracking-widest shadow-xl shadow-primary/20 hover:scale-105 transition-all">Publikasikan Isu</a>
                    </div>
                @endforelse
            </div>

            <!-- Empty State Illustration -->
            <div id="emptyState" class="hidden py-32 flex-col items-center justify-center text-center max-w-lg mx-auto">
                <div class="relative mb-12">
                    <div class="absolute inset-0 bg-primary/5 rounded-full blur-3xl scale-150"></div>
                    <div class="w-48 h-48 relative flex items-center justify-center">
                        <i data-lucide="search-x" class="w-32 h-32 text-slate-200"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-outfit font-black text-slate-800 mb-4">Suara Belum Ditemukan</h3>
                <p class="text-slate-500 font-medium leading-relaxed">Maaf, kami tidak menemukan suara yang cocok dengan pencarian Anda. Coba hilangkan beberapa filter atau cari dengan kata kunci lain.</p>
                <button onclick="resetFilters()" class="mt-10 px-8 py-4 bg-slate-900 text-white font-bold rounded-2xl hover:bg-slate-800 transition-all">Muat Ulang Semua Suara</button>
            </div>

            <!-- Loader / Scroll Trigger -->
            <div id="scrollTrigger" class="flex flex-col items-center justify-center py-8">
                <button id="loadMoreBtn" onclick="loadMoreSuaras()" class="{{ $suaras->hasMorePages() ? 'flex' : 'hidden' }} items-center gap-3 px-8 py-4 bg-white border border-slate-200 text-slate-700 font-bold rounded-2xl hover:bg-slate-50 hover:border-slate-300 shadow-sm transition-all group active:scale-95">
                    <span id="loadMoreSpinner" class="w-5 h-5 border-2 border-slate-300 border-t-accent rounded-full animate-spin hidden"></span>
                    <span id="loadMoreText">Muat Lebih Banyak Suara</span>
                    <i id="loadMoreIcon" data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-hover:text-slate-600 transition-transform group-hover:translate-y-0.5"></i>
                </button>

                <div id="endOfSuaras" class="{{ !$suaras->hasMorePages() && $suaras->count() > 0 ? 'flex' : 'hidden' }} items-center gap-2 text-slate-400 text-xs font-bold uppercase tracking-widest bg-slate-100/80 px-6 py-3 rounded-full">
                    <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500"></i>
                    <span>Semua Suara telah ditampilkan</span>
                </div>
            </div>
        </div>
    </main>

    <!-- Floating Action Button -->
    <a href="/create-suara" title="Buat Suara Baru" class="fixed bottom-10 right-10 w-18 h-18 p-5 bg-gradient-to-br from-accent to-success text-white rounded-3xl flex items-center justify-center shadow-2xl shadow-primary/40 hover:scale-110 hover:-rotate-6 active:scale-90 transition-all z-[90] group">
        <i data-lucide="plus" class="w-10 h-10 group-hover:rotate-90 transition-transform duration-500 font-black"></i>
        <div class="absolute right-full mr-6 bg-slate-900 text-white text-xs font-bold px-4 py-3 rounded-2xl opacity-0 translate-x-4 pointer-events-none group-hover:opacity-100 group-hover:translate-x-0 transition-all whitespace-nowrap shadow-xl">
            Ayo buat perubahan baru!
        </div>
    </a>

    <!-- Footer -->
    <footer class="bg-slate-900 pt-24 pb-12 text-slate-400">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-12 mb-20">
                <div class="col-span-2 md:col-span-1">
                    <a href="/" class="flex items-center mb-8 group">
                        <img src="{{ asset('images/suara-logo-transparent.png') }}" alt="Suara Logo" class="h-8 w-auto group-hover:rotate-6 transition-transform drop-shadow-2xl">
                    </a>
                    <p class="text-sm leading-relaxed  mb-8">Platform perubahan sosial terdepan di Indonesia. Mengubah setiap aspirasi menjadi solusi nyata.</p>
                    <div class="flex items-center gap-3">
                        <a href="https://discord.com" target="_blank" rel="noopener noreferrer" title="Discord" class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center hover:bg-[#5865F2] transition-all hover:text-white text-slate-400 group">
                            <svg class="w-4 h-4 fill-current transition-transform group-hover:scale-110" viewBox="0 0 24 24">
                                <path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028c.462-.63.874-1.295 1.226-1.994.021-.041.001-.09-.041-.106a13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.061 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.894.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.028zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z"/>
                            </svg>
                        </a>
                        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" title="Instagram" class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center hover:bg-gradient-to-tr hover:from-[#f09433] hover:via-[#dc2743] hover:to-[#bc1888] transition-all hover:text-white text-slate-400 group">
                            <svg class="w-4 h-4 fill-current transition-transform group-hover:scale-110" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="https://threads.net" target="_blank" rel="noopener noreferrer" title="Threads" class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center hover:bg-white hover:text-slate-900 transition-all text-slate-400 group">
                            <svg class="w-4 h-4 fill-current transition-transform group-hover:scale-110" viewBox="0 0 24 24">
                                <path d="M12.186 24C5.518 24 0 18.57 0 12.002 0 5.434 5.518.003 12.186.003c3.486 0 6.643 1.458 8.914 3.824 2.227 2.32 3.4 5.474 3.3 8.878-.22 7.49-6.07 10.74-11.758 10.74h-.056c-3.15-.015-5.642-.995-7.408-2.91-1.695-1.838-2.585-4.436-2.585-7.534 0-3.097.89-5.696 2.585-7.534C6.95 3.55 9.444 2.57 12.593 2.555h.056c2.404.01 4.542.668 6.182 1.898a.968.968 0 0 1 .236 1.348.97.97 0 0 1-1.347.237c-1.332-.994-3.09-1.536-5.07-1.545h-.047c-2.613.013-4.664.81-5.932 2.305-1.34 1.576-2.02 3.805-2.02 6.623 0 2.818.68 5.047 2.02 6.623 1.268 1.495 3.319 2.292 5.932 2.305h.047c4.615 0 9.28-2.457 9.47-8.77.085-2.884-.916-5.556-2.82-7.525-1.92-1.986-4.603-3.21-7.556-3.21C6.545 1.938 1.938 6.456 1.938 12.002c0 5.546 4.607 10.064 10.248 10.064 2.917 0 5.372-1.077 7.098-3.116a.97.97 0 0 1 1.368-.13.97.97 0 0 1 .13 1.368C18.672 22.757 15.688 24 12.186 24zm-.095-8.087c-2.127 0-3.834-.82-4.57-2.193-.526-.983-.564-2.193-.105-3.32.553-1.356 1.77-2.29 3.257-2.502.463-.066.935-.098 1.418-.098 1.748 0 3.328.47 4.453 1.325.295.224.498.54.58.905.08.364.004.743-.217 1.053-.518.728-1.42 1.157-2.54 1.21-1.076.05-2.08-.26-2.83-.872a.968.968 0 0 1 .15-1.503.97.97 0 0 1 1.503.15c.42.343.996.516 1.636.486.663-.03 1.16-.264 1.408-.663-.79-.586-1.956-.91-3.273-.91-.355 0-.702.023-1.038.07-1.002.143-1.808.766-2.158 1.666-.307.788-.276 1.595.084 2.268.487.91 1.69 1.464 3.197 1.464 1.206 0 2.29-.356 3.136-1.03.327-.26.804-.213 1.066.113.26.326.213.803-.114 1.066-1.12.893-2.553 1.366-4.143 1.366z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-8 uppercase tracking-widest text-xs">Produk</h4>
                    <ul class="space-y-4 text-sm">
                        <li><a href="#" class="hover:text-primary transition-colors ">Fitur Utama</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors ">Cara Kerja</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors ">Direktori Suara</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors ">API Dokumentasi</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-8 uppercase tracking-widest text-xs">Perusahaan</h4>
                    <ul class="space-y-4 text-sm">
                        <li><a href="#" class="hover:text-primary transition-colors ">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors ">Karir</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors ">Kontak</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors ">Press Kit</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-8 uppercase tracking-widest text-xs">Legal</h4>
                    <ul class="space-y-4 text-sm">
                        <li><a href="#" class="hover:text-primary transition-colors ">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors ">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors ">Keamanan</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-800 pt-8 flex flex-col md:row items-center justify-between gap-6 text-xs ">
                <p>&copy; 2026 Suara All rights reserved.</p>
                <div class="flex items-center gap-8">
                    <span>Dibuat dengan <i data-lucide="heart" class="w-3 h-3 inline text-red-500 fill-red-500"></i> di Jakarta</span>
                    <div class="flex items-center gap-2">
                        <span>Bahasa: </span>
                        <select class="bg-slate-800 text-white rounded px-2 py-1 outline-none font-bold">
                            <option>Indonesian (ID)</option>
                            <option>English (EN)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Login Modal -->
    <div id="loginModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-6 bg-slate-900/60 backdrop-blur-md transition-opacity">
        <div class="bg-white w-full max-w-md rounded-[32px] p-10 shadow-2xl relative">
            <button onclick="toggleLoginModal()" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
            
            <div class="text-center mb-10">
                <div class="w-16 h-16 bg-gradient-to-br from-accent to-success rounded-2xl flex items-center justify-center shadow-xl mx-auto mb-6">
                    <span class="text-white font-outfit font-extrabold text-3xl">S</span>
                </div>
                <h3 class="text-3xl font-outfit font-bold text-slate-800">Selamat Datang</h3>
                <p class="text-slate-500 mt-2  font-medium">Masuk untuk memulai perubahan nyata</p>
            </div>

            <form action="#" class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Email</label>
                    <input type="email" placeholder="nama@email.com" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:border-primary focus:bg-white transition-all font-medium">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Kata Sandi</label>
                    <input type="password" placeholder="••••••••" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:border-primary focus:bg-white transition-all font-medium">
                </div>
                <div class="flex items-center justify-between text-xs font-bold text-slate-500">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" class="accent-primary w-4 h-4"> Ingat Saya
                    </label>
                    <a href="#" class="hover:text-primary transition-colors">Lupa Sandi?</a>
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-accent to-success text-white font-bold py-5 rounded-2xl shadow-xl shadow-primary/20 hover:scale-[1.02] transition-all">Masuk Sekarang</button>
            </form>

            <div class="mt-8 text-center text-sm font-medium text-slate-400">
                Belum punya akun? <a href="#" class="text-primary font-bold hover:underline">Daftar Sekarang</a>
            </div>
        </div>
    </div>

    <script>
        // Initialize Lucide
        lucide.createIcons();

        function toggleLoginModal() {
            const modal = document.getElementById('loginModal');
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }

        // Close on escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !document.getElementById('loginModal').classList.contains('hidden')) {
                toggleLoginModal();
            }
        });

        // Close on background click
        document.getElementById('loginModal').addEventListener('click', (e) => {
            if (e.target === document.getElementById('loginModal')) {
                toggleLoginModal();
            }
        });

        function toggleFilter() {
            const panel = document.getElementById('filterPanel');
            const overlay = document.getElementById('filterOverlay');
            
            if (panel.classList.contains('translate-x-full')) {
                // Open
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.add('opacity-100'), 10);
                panel.classList.remove('translate-x-full');
                document.body.style.overflow = 'hidden';
            } else {
                // Close
                overlay.classList.remove('opacity-100');
                setTimeout(() => overlay.classList.add('hidden'), 300);
                panel.classList.add('translate-x-full');
                document.body.style.overflow = 'auto';
            }
        }

        function simulateSearch() {
            const container = document.getElementById('suaraContainer');
            const trigger = document.getElementById('scrollTrigger');
            const skeleton = document.getElementById('skeletonCard');
            
            // Show skeleton
            skeleton.classList.remove('hidden');
            trigger.classList.add('opacity-50', 'pointer-events-none');
            
            setTimeout(() => {
                const searchVal = document.getElementById('searchInput').value.toLowerCase();
                if (searchVal === 'kosong') {
                    // Show empty state for demo
                    container.classList.add('hidden');
                    document.getElementById('emptyState').classList.remove('hidden');
                    document.getElementById('emptyState').classList.add('flex');
                    trigger.classList.add('hidden');
                } else {
                    skeleton.classList.add('hidden');
                    trigger.classList.remove('opacity-50', 'pointer-events-none');
                    alert('Logika pagination atau API-fetch akan diimplementasikan di sini untuk memuat data riil dari database.');
                }
            }, 1500);
        }

        function resetFilters() {
            document.getElementById('emptyState').classList.add('hidden');
            document.getElementById('emptyState').classList.remove('flex');
            document.getElementById('suaraContainer').classList.remove('hidden');
            document.getElementById('scrollTrigger').classList.remove('hidden');
            document.getElementById('searchInput').value = '';
        }

        // Search Input Interactivity
        document.getElementById('searchInput').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                simulateSearch();
            }
        });
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

    <script>
        lucide.createIcons();

        // State for Pagination & Filtering
        let currentPage = {{ $suaras->currentPage() }};
        let hasMorePages = {{ $suaras->hasMorePages() ? 'true' : 'false' }};
        let isLoadingSuara = false;
        let activeSearch = '';
        let activeLocation = '';
        let activeCategories = [];

        // Filter Sidebar Toggle
        function toggleFilter() {
            const panel = document.getElementById('filterPanel');
            const overlay = document.getElementById('filterOverlay');
            if (!panel || !overlay) return;

            const isOpen = !panel.classList.contains('translate-x-full');
            if (isOpen) {
                panel.classList.add('translate-x-full');
                overlay.classList.add('opacity-0');
                setTimeout(() => overlay.classList.add('hidden'), 300);
            } else {
                overlay.classList.remove('hidden');
                setTimeout(() => {
                    overlay.classList.remove('opacity-0');
                    panel.classList.remove('translate-x-full');
                }, 10);
            }
        }

        // Apply filters from sidebar
        function applyFilters() {
            const locSelect = document.getElementById('filterLocation');
            activeLocation = locSelect ? locSelect.value : '';

            const catCheckboxes = document.querySelectorAll('input[name="filter_category"]:checked');
            activeCategories = Array.from(catCheckboxes).map(cb => cb.value);

            toggleFilter();
            fetchSuaras(1, true);
        }

        // Reset all filters
        function resetFilters() {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) searchInput.value = '';
            activeSearch = '';

            const locSelect = document.getElementById('filterLocation');
            if (locSelect) locSelect.value = '';
            activeLocation = '';

            const catCheckboxes = document.querySelectorAll('input[name="filter_category"]');
            catCheckboxes.forEach(cb => cb.checked = false);
            activeCategories = [];

            const panel = document.getElementById('filterPanel');
            if (panel && !panel.classList.contains('translate-x-full')) {
                toggleFilter();
            }

            fetchSuaras(1, true);
        }

        // Fetch Suaras (page 1 or pagination append)
        async function fetchSuaras(page = 1, isReset = false) {
            if (isLoadingSuara) return;
            isLoadingSuara = true;

            const loadMoreBtn = document.getElementById('loadMoreBtn');
            const loadMoreSpinner = document.getElementById('loadMoreSpinner');
            const loadMoreText = document.getElementById('loadMoreText');
            const loadMoreIcon = document.getElementById('loadMoreIcon');
            const endOfSuaras = document.getElementById('endOfSuaras');
            const container = document.getElementById('suaraContainer');
            const emptyState = document.getElementById('emptyState');
            const initialEmpty = document.getElementById('initialEmptyState');

            if (isReset) {
                if (loadMoreBtn) loadMoreBtn.classList.add('hidden');
                if (endOfSuaras) endOfSuaras.classList.add('hidden');
            } else {
                if (loadMoreSpinner) loadMoreSpinner.classList.remove('hidden');
                if (loadMoreIcon) loadMoreIcon.classList.add('hidden');
                if (loadMoreText) loadMoreText.innerText = 'Memuat...';
            }

            try {
                const params = new URLSearchParams();
                params.set('page', page);
                if (activeSearch) params.set('search', activeSearch);
                if (activeLocation) params.set('location', activeLocation);
                if (activeCategories.length > 0) params.set('category', activeCategories.join(','));

                const res = await fetch(`/suara?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                if (!res.ok) throw new Error('Network error');

                const data = await res.json();
                currentPage = page;
                hasMorePages = data.hasMore;

                if (isReset) {
                    container.innerHTML = data.html;
                    if (data.count === 0) {
                        if (emptyState) emptyState.classList.remove('hidden');
                    } else {
                        if (emptyState) emptyState.classList.add('hidden');
                        if (initialEmpty) initialEmpty.classList.add('hidden');
                    }
                } else {
                    container.insertAdjacentHTML('beforeend', data.html);
                }

                lucide.createIcons();

                // Update Load More Button & End text
                if (hasMorePages) {
                    if (loadMoreBtn) {
                        loadMoreBtn.classList.remove('hidden');
                        loadMoreBtn.classList.add('flex');
                    }
                    if (endOfSuaras) endOfSuaras.classList.add('hidden');
                } else {
                    if (loadMoreBtn) loadMoreBtn.classList.add('hidden');
                    if (data.total > 0 && endOfSuaras) {
                        endOfSuaras.classList.remove('hidden');
                        endOfSuaras.classList.add('flex');
                    } else {
                        if (endOfSuaras) endOfSuaras.classList.add('hidden');
                    }
                }
            } catch (err) {
                console.error('Failed to load suaras:', err);
            } finally {
                isLoadingSuara = false;
                if (loadMoreSpinner) loadMoreSpinner.classList.add('hidden');
                if (loadMoreIcon) loadMoreIcon.classList.remove('hidden');
                if (loadMoreText) loadMoreText.innerText = 'Muat Lebih Banyak Suara';
            }
        }

        // Triggered by Load More button
        function loadMoreSuaras() {
            if (hasMorePages && !isLoadingSuara) {
                fetchSuaras(currentPage + 1, false);
            }
        }

        // Toggle Card Bookmark
        async function toggleCardBookmark(suaraId, btn) {
            @guest
                toggleAuthModal('login');
                return;
            @endguest

            try {
                const response = await fetch(`/suara/${suaraId}/bookmark`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();
                if (data.success) {
                    const isBookmarked = data.bookmarked;
                    const icon = btn.querySelector('i');
                    if (isBookmarked) {
                        btn.className = `w-10 h-10 rounded-full flex items-center justify-center transition-all bookmark-btn-${suaraId} text-amber-500 bg-amber-50 shadow-sm`;
                        if (icon) icon.className = 'w-5 h-5 fill-current text-amber-500';
                        btn.title = 'Tersimpan (Klik untuk batal)';
                    } else {
                        btn.className = `w-10 h-10 rounded-full flex items-center justify-center transition-all bookmark-btn-${suaraId} text-slate-300 hover:text-amber-500 hover:bg-amber-50`;
                        if (icon) icon.className = 'w-5 h-5';
                        btn.title = 'Simpan / Pantau Isu';
                    }
                    lucide.createIcons();
                    showShareToastSuara(data.message);
                }
            } catch (err) {
                console.error('Error bookmarking card:', err);
            }
        }

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

        async function copyShareLinkModal(url, title) {
            if (navigator.share) {
                try {
                    await navigator.share({
                        title: title || document.title,
                        text: `Ayo kawal bersama aspirasi: "${title}" di Ruang Suara!`,
                        url: url
                    });
                    return;
                } catch (e) {}
            }

            try {
                if (navigator.clipboard && window.isSecureContext) {
                    await navigator.clipboard.writeText(url);
                } else {
                    const tempInput = document.createElement('input');
                    tempInput.value = url;
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    document.execCommand('copy');
                    document.body.removeChild(tempInput);
                }
                showShareToastSuara('Tautan aspirasi berhasil disalin ke clipboard!');
            } catch (err) {
                alert('Tautan: ' + url);
            }
        }

        function showShareToastSuara(message) {
            let toast = document.getElementById('suaraShareToast');
            if (!toast) return;
            const msg = document.getElementById('suaraShareToastMsg');
            if (msg) msg.innerText = message;
            toast.classList.remove('translate-y-24', 'opacity-0', 'pointer-events-none');
            toast.classList.add('translate-y-0', 'opacity-100');
            setTimeout(() => {
                toast.classList.add('translate-y-24', 'opacity-0', 'pointer-events-none');
                toast.classList.remove('translate-y-0', 'opacity-100');
            }, 3000);
        }

        // Auto-open modal based on query parameter
        window.addEventListener('load', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const authType = urlParams.get('auth');
            if (authType === 'login' || authType === 'signup') {
                toggleAuthModal(authType);
            }
        });
    </script>

    <!-- Share Toast Notification -->
    <div id="suaraShareToast" class="fixed bottom-8 right-8 z-[250] bg-slate-900 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 border border-slate-700/50 transform translate-y-24 opacity-0 pointer-events-none transition-all duration-300 ease-out font-outfit">
        <div class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-200" id="suaraShareToastMsg">Tautan berhasil disalin ke clipboard!</p>
        </div>
    </div>
</body>
</html>
