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

    <!-- Header / Navbar -->
    <header class="sticky top-0 z-[100] glass">
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
                    <select class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-primary/20 transition-all font-medium appearance-none">
                        <option>Seluruh Indonesia</option>
                        <option>Jakarta</option>
                        <option>Bandung</option>
                        <option>Surabaya</option>
                        <option>Medan</option>
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
                        <input type="checkbox" class="hidden peer">
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
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-red-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                    </label>
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0 p-8 border-t border-slate-100 bg-white grid grid-cols-2 gap-4">
            <button class="py-4 border border-slate-200 text-slate-600 font-bold rounded-2xl hover:bg-slate-50 transition-colors">Reset</button>
            <button class="py-4 bg-primary text-white font-bold rounded-2xl hover:shadow-lg shadow-primary/20 transition-all">Terapkan</button>
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
                                <button onclick="event.preventDefault(); event.stopPropagation();" class="w-10 h-10 rounded-full flex items-center justify-center text-slate-300 hover:text-red-500 hover:bg-red-50 transition-all">
                                    <i data-lucide="heart" class="w-5 h-5"></i>
                                </button>
                                <button onclick="event.preventDefault(); event.stopPropagation();" class="w-10 h-10 rounded-full flex items-center justify-center text-slate-300 hover:text-primary hover:bg-primary/5 transition-all">
                                    <i data-lucide="bookmark" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </div>

                        <h3 class="text-xl font-outfit font-extrabold text-slate-800 mb-3 leading-snug group-hover:text-primary transition-colors line-clamp-2 uppercase  tracking-tighter">
                            {{ $m->title }}
                        </h3>
                        
                        <p class="text-slate-500 text-sm mb-8 line-clamp-2 font-medium leading-relaxed ">
                            {{ $m->description }}
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
                                <div class="flex items-center gap-3">
                                    <div class="flex -space-x-2">
                                        <img class="w-8 h-8 rounded-full border-2 border-white shadow-sm" src="https://i.pravatar.cc/150?u=1" alt="">
                                        <img class="w-8 h-8 rounded-full border-2 border-white shadow-sm" src="https://i.pravatar.cc/150?u=2" alt="">
                                        <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-500 shadow-sm">+9</div>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-black text-slate-900 leading-none">{{ number_format($m->supporter_count, 0, ',', '.') }}</span>
                                        <span class="text-[8px] font-bold text-slate-400 uppercase tracking-tighter leading-none">Voices</span>
                                    </div>
                                </div>
                                <button onclick="event.preventDefault(); event.stopPropagation();" class="flex items-center gap-1.5 text-slate-400 hover:text-slate-600 transition-colors uppercase text-[10px] font-black tracking-widest">
                                    <i data-lucide="share-2" class="w-4 h-4"></i> Bagikan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="col-span-full py-20 flex flex-col items-center justify-center text-center">
                        <i data-lucide="inbox" class="w-20 h-20 text-slate-200 mb-6"></i>
                        <h4 class="text-2xl font-black text-slate-400 uppercase ">Belum ada Suara aktif</h4>
                        <p class="text-slate-400  mt-2">Jadilah yang pertama menyuarakan perubahan!</p>
                        <a href="/create-suara" class="mt-8 px-10 py-4 bg-primary text-white rounded-3xl font-black text-[10px] uppercase tracking-widest shadow-xl shadow-primary/20 hover:scale-105 transition-all">Publikasikan Isu</a>
                    </div>
                @endforelse

                <!-- Skeleton Mockup for Load More -->
                <div id="skeletonCard" class="bg-white rounded-[32px] p-8 border border-slate-50 shadow-sm animate-pulse hidden">
                    <div class="w-14 h-14 bg-slate-100 rounded-2xl mb-8"></div>
                    <div class="h-4 w-20 bg-slate-100 rounded-full mb-6"></div>
                    <div class="h-7 w-full bg-slate-100 rounded-full mb-3"></div>
                    <div class="h-7 w-3/4 bg-slate-100 rounded-full mb-8"></div>
                    <div class="h-20 w-full bg-slate-100 rounded-2xl mb-8"></div>
                    <div class="h-8 w-full bg-slate-100 rounded-full"></div>
                </div>
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
            <div id="scrollTrigger" class="flex justify-center py-12">
                <button onclick="simulateSearch()" class="flex items-center gap-3 px-8 py-4 bg-white border border-slate-100 rounded-2xl font-bold text-slate-600 hover:bg-slate-50 hover:border-slate-200 shadow-sm transition-all group active:scale-95">
                    <div class="w-5 h-5 border-2 border-slate-200 border-t-primary rounded-full animate-spin"></div>
                    Memuat Lebih Banyak Suara...
                </button>
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
                    <div class="flex items-center gap-4">
                        <a href="#" class="w-10 h-10 bg-slate-800 rounded-full flex items-center justify-center hover:bg-primary transition-colors hover:text-white">
                            <i data-lucide="instagram" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 rounded-full flex items-center justify-center hover:bg-primary transition-colors hover:text-white">
                            <i data-lucide="twitter" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 rounded-full flex items-center justify-center hover:bg-primary transition-colors hover:text-white">
                            <i data-lucide="facebook" class="w-5 h-5"></i>
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
                <div id="loginView" class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Email</label>
                        <div class="relative group">
                            <i data-lucide="mail" class="absolute left-6 top-5 w-5 h-5 text-slate-300 group-focus-within:text-accent transition-colors"></i>
                            <input type="email" placeholder="nama@email.com" class="w-full pl-16 pr-8 py-5 bg-slate-50 border border-slate-100 rounded-3xl outline-none focus:ring-4 focus:ring-primary/5 focus:bg-white focus:border-primary transition-all font-medium">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center ml-1">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Password</label>
                            <a href="#" class="text-[10px] font-black text-accent hover:underline">Lupa Password?</a>
                        </div>
                        <div class="relative group">
                            <i data-lucide="lock" class="absolute left-6 top-5 w-5 h-5 text-slate-300 group-focus-within:text-accent transition-colors"></i>
                            <input type="password" id="loginPassword" placeholder="••••••••" class="w-full pl-16 pr-14 py-5 bg-slate-50 border border-slate-100 rounded-3xl outline-none focus:ring-4 focus:ring-primary/5 focus:bg-white focus:border-primary transition-all font-medium">
                            <button type="button" onclick="togglePassword('loginPassword')" class="absolute right-6 top-5 text-slate-300 hover:text-accent transition-colors">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>
                    <button onclick="window.location.href='/dev-login'" class="w-full bg-accent py-5 rounded-3xl text-white font-black text-lg shadow-xl shadow-accent/20 hover:scale-[1.02] active:scale-95 transition-all">
                        Masuk Sekarang
                    </button>

                    <!-- Google & Apple Auth (Login Only) -->
                    <div class="space-y-4 pt-4">
                        <div class="relative py-2">
                            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-100"></div></div>
                            <span class="relative bg-white px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mx-auto block w-max">Atau dengan</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <button class="flex items-center justify-center gap-3 py-4 border border-slate-100 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 transition-all">
                                <svg class="w-5 h-5" viewBox="0 0 24 24"><path fill="#fbbc05" d="M5.1 12c0-.7.1-1.4.3-2.1L1.1 6.6C.4 8.2 0 10.1 0 12s.4 3.8 1.1 5.4l4.3-3.3c-.2-.7-.3-1.4-.3-2.1z"/><path fill="#ea4335" d="M12 4.1c1.6 0 3.1.6 4.2 1.5l3.1-3.1C17.3 1 14.8 0 12 0 7.3 0 3.3 2.7 1.1 6.6L5.4 9.9c1.1-3.3 4.2-5.8 6.6-5.8z"/><path fill="#34a853" d="M12 19.9c-2.4 0-4.5-2.5-5.6-5.8L2.1 17.4C4.3 21.3 8.3 24 13 24c3.4 0 6.2-1.1 8.3-2.9l-4.1-3.1c-1.2.8-2.6 1.1-4.2 1.1z"/><path fill="#4285f4" d="M24 12c0-.8-.1-1.7-.2-2.5H12v4.8h6.8c-.3 1.5-1.1 2.8-2.4 3.6l4.1 3.1c2.4-2.1 4.5-5.2 4.5-9z"/></svg>
                                <span class="text-xs">Google</span>
                            </button>
                            <button class="flex items-center justify-center gap-3 py-4 border border-slate-100 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 transition-all">
                                <i data-lucide="apple" class="w-5 h-5"></i>
                                <span class="text-xs">Apple ID</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Signup View -->
                <div id="signupView" class="hidden space-y-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Nama Lengkap</label>
                        <div class="relative group">
                            <i data-lucide="user" class="absolute left-6 top-5 w-5 h-5 text-slate-300 group-focus-within:text-accent transition-colors"></i>
                            <input type="text" placeholder="Masukkan nama lengkap" class="w-full pl-16 pr-8 py-5 bg-slate-50 border border-slate-100 rounded-3xl outline-none focus:ring-4 focus:ring-primary/5 focus:bg-white focus:border-primary transition-all font-medium">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Email</label>
                        <div class="relative group">
                            <i data-lucide="mail" class="absolute left-6 top-5 w-5 h-5 text-slate-300 group-focus-within:text-accent transition-colors"></i>
                            <input type="email" placeholder="nama@email.com" class="w-full pl-16 pr-8 py-5 bg-slate-50 border border-slate-100 rounded-3xl outline-none focus:ring-4 focus:ring-primary/5 focus:bg-white focus:border-primary transition-all font-medium">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Password</label>
                        <div class="relative group">
                            <i data-lucide="lock" class="absolute left-6 top-5 w-5 h-5 text-slate-300 group-focus-within:text-accent transition-colors"></i>
                            <input type="password" id="signupPassword" placeholder="Min. 8 Karakter" class="w-full pl-16 pr-14 py-5 bg-slate-50 border border-slate-100 rounded-3xl outline-none focus:ring-4 focus:ring-primary/5 focus:bg-white focus:border-primary transition-all font-medium">
                            <button type="button" onclick="togglePassword('signupPassword')" class="absolute right-6 top-5 text-slate-300 hover:text-accent transition-colors">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Konfirmasi Password</label>
                        <div class="relative group">
                            <i data-lucide="check-circle" class="absolute left-6 top-5 w-5 h-5 text-slate-300 group-focus-within:text-accent transition-colors"></i>
                            <input type="password" id="signupConfirmPassword" placeholder="Ulangi Password" class="w-full pl-16 pr-14 py-5 bg-slate-50 border border-slate-100 rounded-3xl outline-none focus:ring-4 focus:ring-primary/5 focus:bg-white focus:border-primary transition-all font-medium">
                            <button type="button" onclick="togglePassword('signupConfirmPassword')" class="absolute right-6 top-5 text-slate-300 hover:text-accent transition-colors">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>

                    <button onclick="window.location.href='/dev-login'" class="w-full bg-accent py-5 rounded-3xl text-white font-black text-lg shadow-xl shadow-accent/20 hover:scale-[1.02] active:scale-95 transition-all mt-4">
                        Daftar Secepatnya
                    </button>
                </div>
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
    </script>
</body>
</html>
