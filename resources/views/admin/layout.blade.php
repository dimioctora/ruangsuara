<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel — Suara Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0F172A', // Slate 900
                        accent: '#2563EB',  // Elegant Blue
                        success: '#10B981', // Emerald
                        warning: '#F59E0B', // Amber
                        danger: '#EF4444',  // Red
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
        .glass { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); }
        .card-shadow { box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.05); }
        .active-link { background: rgba(37, 99, 235, 0.1); color: #2563EB; border-radius: 16px; font-weight: 800; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
    </style>
</head>
<body class="bg-[#F8FAFC] font-sans text-slate-800 selection:bg-accent/10 selection:text-accent flex overflow-hidden h-screen">

    <!-- Sidebar Admin -->
    <aside class="w-72 h-full bg-white border-r border-slate-100 flex flex-col flex-shrink-0 z-50 overflow-y-auto">
        <div class="p-8 pb-12">
            <div class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 bg-accent rounded-xl flex items-center justify-center shadow-lg shadow-accent/20">
                    <i data-lucide="shield-check" class="w-6 h-6 text-white"></i>
                </div>
                <h2 class="text-xl font-outfit font-black tracking-tight text-slate-900">ADMIN <span class="text-accent">SUARA</span></h2>
            </div>

            <nav class="space-y-2">
                 <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 px-4">Master View</p>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-5 py-4 transition-all hover:bg-slate-50 rounded-2xl group {{ request()->routeIs('admin.dashboard') ? 'active-link' : '' }}">
                    <i data-lucide="layout-grid" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                    Dashboard
                </a>
                
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-8 mb-4 px-4">Management</p>
                <a href="{{ route('admin.suara') }}" class="flex items-center gap-4 px-5 py-4 transition-all hover:bg-slate-50 rounded-2xl group {{ request()->routeIs('admin.suara') ? 'active-link' : '' }}">
                    <i data-lucide="megaphone" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                    Isu Suara
                    <span class="ml-auto text-[10px] bg-danger/10 text-danger px-2 py-0.5 rounded-full font-black">2</span>
                </a>
                <a href="{{ route('admin.users') }}" class="flex items-center gap-4 px-5 py-4 transition-all hover:bg-slate-50 rounded-2xl group {{ request()->routeIs('admin.users') ? 'active-link' : '' }}">
                    <i data-lucide="users" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                    Manajemen User
                </a>
                
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-8 mb-4 px-4">System Settings</p>
                <a href="{{ route('admin.xp') }}" class="flex items-center gap-4 px-5 py-4 transition-all hover:bg-slate-50 rounded-2xl group {{ request()->routeIs('admin.xp') ? 'active-link' : '' }}">
                    <i data-lucide="settings" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                    Konfigurasi XP
                </a>
                <a href="{{ route('admin.logout') }}" class="flex items-center gap-4 px-5 py-4 transition-all hover:bg-danger/10 text-danger rounded-2xl group mt-10">
                    <i data-lucide="log-out" class="w-5 h-5 group-hover:-translate-x-1 transition-transform"></i>
                    Keluar Panel
                </a>
            </nav>
        </div>
        
        <div class="mt-auto p-6 border-t border-slate-50">
            <div class="bg-slate-900 rounded-2xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg overflow-hidden border border-white/20">
                    <img src="https://i.pravatar.cc/150?u=admin" alt="Admin Ava">
                </div>
                <div class="overflow-hidden">
                    <h4 class="text-xs font-black text-white truncate">{{ \Illuminate\Support\Facades\Auth::user()->name }}</h4>
                    <p class="text-[10px] text-slate-400 truncate">{{ \Illuminate\Support\Facades\Auth::user()->email }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Content Area -->
    <main class="flex-grow flex flex-col overflow-hidden">
        <!-- Top Nav -->
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-10 flex-shrink-0">
             <div class="flex items-center gap-2">
                <h1 class="text-lg font-outfit font-bold text-slate-800">Suara Back-Office</h1>
             </div>
             <div class="flex items-center gap-6">
                <div class="relative">
                    <i data-lucide="bell" class="w-5 h-5 text-slate-400"></i>
                    <span class="absolute -top-1 -right-1 w-3 h-3 bg-accent rounded-full border-2 border-white"></span>
                </div>
                <div class="h-10 w-[1px] bg-slate-100 mx-2"></div>
                <span class="text-xs font-black text-slate-400 uppercase tracking-widest">v2.0 Beta</span>
             </div>
        </header>

        <!-- Dynamic Content -->
        <div class="flex-grow overflow-y-auto p-10 custom-scrollbar">
            @yield('content')
        </div>
    </main>

    <script>lucide.createIcons();</script>
</body>
</html>
