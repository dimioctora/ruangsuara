<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Suara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0F172A',
                        accent: '#2563EB',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        outfit: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#0F172A] font-sans text-slate-900 flex items-center justify-center min-h-screen relative overflow-hidden">
    
    <!-- Abstract Background -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-accent/20 rounded-full blur-[100px]"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-success/10 rounded-full blur-[100px]"></div>

    <div class="w-full max-w-lg px-6 relative z-10">
        <div class="bg-white rounded-[50px] p-14 shadow-2xl border border-white/10">
            <div class="text-center mb-12">
                <div class="w-20 h-20 bg-accent rounded-[30px] flex items-center justify-center mx-auto mb-8 shadow-2xl shadow-accent/30">
                    <i data-lucide="shield-check" class="w-10 h-10 text-white"></i>
                </div>
                <h1 class="text-3xl font-outfit font-black text-slate-900 tracking-tight">Backend <span class="text-accent">Auth</span></h1>
                <p class="text-sm font-bold text-slate-400 mt-3 uppercase tracking-widest">Akses SuperUser Terbatas</p>
            </div>

            @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 text-red-600 rounded-2xl text-[10px] font-black uppercase tracking-widest border border-red-100 flex items-center gap-3">
                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-2">Admin Email</label>
                    <div class="relative group">
                         <i data-lucide="mail" class="absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-300 group-focus-within:text-accent transition-all"></i>
                         <input type="email" name="email" required placeholder="name@suara.id" 
                                class="w-full pl-14 pr-8 py-5 bg-slate-50 border-2 border-transparent focus:border-accent/10 focus:bg-white rounded-3xl outline-none transition-all text-base font-bold">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-2">Key Passphrase</label>
                    <div class="relative group">
                         <i data-lucide="lock" class="absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-300 group-focus-within:text-accent transition-all"></i>
                         <input type="password" name="password" required placeholder="••••••••" 
                                class="w-full pl-14 pr-8 py-5 bg-slate-50 border-2 border-transparent focus:border-accent/10 focus:bg-white rounded-3xl outline-none transition-all text-base font-bold">
                    </div>
                </div>

                <button type="submit" class="w-full py-6 bg-accent text-white font-black rounded-[30px] shadow-2xl shadow-accent/30 hover:scale-[1.02] active:scale-[0.98] transition-all tracking-widest uppercase text-sm mt-6">
                    Unlock Access <i data-lucide="arrow-right" class="w-5 h-5 inline ml-3"></i>
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-slate-50 text-center">
                 <a href="/" class="text-[10px] font-black text-slate-300 uppercase tracking-widest hover:text-slate-500 transition-colors">Kembali ke Situs Utama</a>
            </div>
        </div>
        
        <p class="text-center mt-8 text-[10px] font-black text-slate-500 uppercase tracking-widest">Secure Environment v2.0</p>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>
