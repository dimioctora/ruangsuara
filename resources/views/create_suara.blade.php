<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Suara — Platform Perubahan Masyarakat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0F172A',
                        accent: '#2563EB',
                        success: '#10B981',
                        warning: '#F59E0B',
                        danger: '#EF4444',
                    }
                }
            }
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
        :root {
            --primary: #0F172A;
            --accent: #2563EB;
            --accent-soft: #EFF6FF;
            --success: #10B981;
            --warning: #F59E0B;
            --card-radius: 40px;
        }
        
        body { 
            font-family: 'Inter', sans-serif;
            background-color: #F8FAFC;
        }
        
        .font-outfit { font-family: 'Outfit', sans-serif; }
        
        /* Glassmorphism */
        .glass { 
            background: rgba(255, 255, 255, 0.85); 
            backdrop-filter: blur(20px); 
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.5); 
        }
        
        /* Premium Shadows */
        .card-shadow {
            box-shadow: 0 20px 50px -12px rgba(15, 23, 42, 0.08);
        }
        .inner-shadow {
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.02);
        }
        
        /* Step Progress Styles */
        .step-circle {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .step-active { 
            background: white;
            color: var(--accent);
            border-color: var(--accent);
            box-shadow: 0 0 20px rgba(37, 99, 235, 0.2), 0 0 0 4px rgba(37, 99, 235, 0.05);
            transform: scale(1.1);
        }
        .step-completed {
            background: var(--success);
            color: white;
            border-color: var(--success);
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.2);
        }
        .step-inactive {
            background: #F1F5F9;
            color: #94A3B8;
            border-color: #E2E8F0;
        }

        /* Animations */
        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeInOut {
            0% { opacity: 0; scale: 0.98; }
            100% { opacity: 1; scale: 1; }
        }

        .section-animate {
            animation: fadeInOut 0.4s ease-out forwards;
        }

        /* Input Styling */
        .input-premium {
            @apply w-full px-8 py-5 bg-slate-50 border border-slate-100 rounded-[24px] outline-none transition-all font-semibold placeholder:text-slate-300;
        }
        .input-premium:focus {
            @apply bg-white border-accent shadow-[0_0_0_4px_rgba(37,99,235,0.08)];
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #F8FAFC; }
        ::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #CBD5E1; }

        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Section Management */
        .form-section { display: none; }
        .form-section.active { display: block; }
    </style>
</head>
<body class="text-slate-900 selection:bg-accent/10 selection:text-accent overflow-x-hidden antialiased">
    <!-- Global SVG Assets -->
    <svg style="position: absolute; width: 0; height: 0; overflow: hidden;" xmlns="http://www.w3.org/2000/svg">
        <defs>
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

    <!-- Navbar Minimalis -->
    <header class="sticky top-0 z-[100] bg-white/80 backdrop-blur-xl border-b border-slate-200/60 shadow-sm transition-all duration-300">
        <nav class="container mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="/dashboard" class="w-11 h-11 flex items-center justify-center rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-accent hover:border-accent/20 hover:shadow-lg hover:shadow-accent/5 transition-all outline-none">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <div class="h-8 w-px bg-slate-100 hidden sm:block"></div>
                <div class="hidden sm:block">
                    <h1 class="text-xl font-outfit font-black text-primary tracking-tight">Buat Suara Baru</h1>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 leading-none mt-1">Movement Creator Panel</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="hidden sm:block text-right">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Creator</p>
                    <p class="text-sm font-bold text-slate-900">{{ $user->name ?? 'Dimi Octora' }}</p>
                </div>
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-accent to-success p-0.5 shadow-lg shadow-accent/20 overflow-hidden relative">
                     <div class="relative w-full h-full rounded-[14px] bg-white flex items-center justify-center overflow-hidden">
                        <svg class="w-full h-full" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="35" r="20" fill="url(#navAvatarGrad1)" />
                            <path d="M20,85 Q50,60 80,85 L80,100 L20,100 Z" fill="url(#navAvatarGrad2)" />
                        </svg>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-4 sm:px-6 py-10 min-h-[calc(100vh-80px)]">
        <div class="max-w-7xl mx-auto flex flex-col lg:row lg:flex-row gap-12">
            
            <!-- Left Side: Form Container -->
            <div class="flex-1 w-full lg:max-w-3xl">
                
                <!-- Horizontal Stepper - Modern Version -->
                <div class="relative flex items-center justify-between px-4 sm:px-10 mb-12">
                    <!-- Progress Line Background -->
                    <div class="absolute left-10 right-10 top-6 h-0.5 bg-slate-100 -z-10"></div>
                    <div id="step-progress-line" class="absolute left-10 top-6 h-0.5 bg-accent transition-all duration-700 -z-10" style="width: 0%"></div>
                    
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center gap-4 group cursor-pointer" onclick="goToStep(1)">
                        <div id="step-1-circle" class="w-12 h-12 rounded-2xl flex items-center justify-center border-2 step-circle shadow-inner step-active">
                            <i data-lucide="info" class="w-5 h-5"></i>
                        </div>
                        <span id="step-1-label" class="text-[10px] font-black uppercase tracking-widest text-accent whitespace-nowrap">Informasi</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center gap-4 group cursor-pointer" onclick="goToStep(2)">
                        <div id="step-2-circle" class="w-12 h-12 rounded-2xl flex items-center justify-center border-2 step-circle shadow-inner step-inactive">
                            <i data-lucide="align-left" class="w-5 h-5"></i>
                        </div>
                        <span id="step-2-label" class="text-[10px] font-black uppercase tracking-widest text-slate-400 whitespace-nowrap">Deskripsi</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center gap-4 group cursor-pointer" onclick="goToStep(3)">
                        <div id="step-3-circle" class="w-12 h-12 rounded-2xl flex items-center justify-center border-2 step-circle shadow-inner step-inactive">
                            <i data-lucide="target" class="w-5 h-5"></i>
                        </div>
                        <span id="step-3-label" class="text-[10px] font-black uppercase tracking-widest text-slate-400 whitespace-nowrap">Target</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center gap-4 group cursor-pointer" onclick="goToStep(4)">
                        <div id="step-4-circle" class="w-12 h-12 rounded-2xl flex items-center justify-center border-2 step-circle shadow-inner step-inactive">
                            <i data-lucide="users" class="w-5 h-5"></i>
                        </div>
                        <span id="step-4-label" class="text-[10px] font-black uppercase tracking-widest text-slate-400 whitespace-nowrap">Tim</span>
                    </div>
                </div>

                <!-- Main Card Dashboard -->
                <form id="createSuaraForm" action="/create-suara" method="POST" enctype="multipart/form-data" onsubmit="return validateAndSubmit(event)" class="bg-white rounded-[40px] border border-slate-100 card-shadow overflow-hidden relative">
                    @csrf
                    <input type="hidden" name="contribution_type" id="hidden-contribution-type" value="voice">
                    
                    <!-- Section A: Basic Info -->
                    <div id="section-1" class="form-section active p-8 md:p-14 section-animate">
                        @if ($errors->any())
                            <div class="mb-8 p-6 bg-red-50 border border-red-100 rounded-[32px] animate-fade-in shadow-sm">
                                <div class="flex items-center gap-4 text-red-500 mb-2">
                                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                                    <p class="text-sm font-black uppercase tracking-widest">Ada Kesalahan Input</p>
                                </div>
                                <ul class="list-disc list-inside text-xs text-slate-600 font-medium space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="space-y-2 mb-10">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-3 py-1 bg-accent/10 text-accent text-[9px] font-black uppercase tracking-widest rounded-lg">Langkah 1</span>
                                <div class="h-px flex-1 bg-slate-50"></div>
                            </div>
                            <h2 class="text-3xl font-outfit font-black text-primary">Informasi Utama</h2>
                            <p class="text-sm text-slate-400 font-medium">Mari mulai dengan identitas Suara Anda. Judul yang kuat melahirkan dukungan yang luas.</p>
                        </div>

                        <div class="space-y-8">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between ml-1">
                                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-500">Judul Suara</label>
                                    <span id="title-char-count" class="text-[10px] font-bold text-slate-300">0 / 100</span>
                                </div>
                                <div class="relative group">
                                    <input type="text" name="title" id="input-title" value="{{ old('title') }}" placeholder="Contoh: Revitalisasi Danau Sunter untuk Wisata Gratis" class="w-full px-8 py-5 pr-14 bg-slate-50 border border-slate-100 rounded-[24px] outline-none transition-all font-semibold placeholder:text-slate-300 focus:bg-white focus:border-accent focus:shadow-[0_0_0_4px_rgba(37,99,235,0.08)]" maxlength="100">
                                    <div id="title-status-icon" class="absolute right-6 top-1/2 -translate-y-1/2 hidden transition-all scale-110">
                                        <!-- Will be injected by JS -->
                                    </div>
                                </div>
                                <div id="title-error" class="ml-1 hidden">
                                    <p class="text-[10px] font-bold text-red-500 flex items-center gap-2">
                                        <i data-lucide="x-circle" class="w-3.5 h-3.5"></i>
                                        Isu serupa ditemukan: Mohon buatlah judul yang lebih spesifik.
                                    </p>
                                </div>
                                <div id="title-success" class="ml-1 hidden">
                                    <p class="text-[10px] font-bold text-success flex items-center gap-2">
                                        <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                                        Judul tersedia dan siap dipublikasikan.
                                    </p>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-8">
                                <div class="space-y-3">
                                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Kategori Isu</label>
                                    <div class="relative group">
                                        <select id="input-category" name="category" class="w-full px-8 py-5 bg-slate-50 border border-slate-100 rounded-[24px] outline-none transition-all font-semibold appearance-none cursor-pointer focus:bg-white focus:border-accent focus:shadow-[0_0_0_4px_rgba(37,99,235,0.08)]">
                                            <option value="">Pilih Kategori</option>
                                            <option value="Lingkungan" {{ old('category') == 'Lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                                            <option value="Keadilan" {{ old('category') == 'Keadilan' ? 'selected' : '' }}>Keadilan</option>
                                            <option value="Hak Asasi Manusia" {{ old('category') == 'Hak Asasi Manusia' ? 'selected' : '' }}>Hak Asasi Manusia</option>
                                            <option value="Pemerintah & Politik" {{ old('category') == 'Pemerintah & Politik' ? 'selected' : '' }}>Pemerintah & Politik</option>
                                            <option value="Pendidikan" {{ old('category') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                            <option value="Entertainment" {{ old('category') == 'Entertainment' ? 'selected' : '' }}>Entertainment</option>
                                            <option value="Suara Konsumen" {{ old('category') == 'Suara Konsumen' ? 'selected' : '' }}>Suara Konsumen</option>
                                            <option value="Infrastruktur" {{ old('category') == 'Infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                                            <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                        <i data-lucide="chevron-down" class="absolute right-6 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none group-focus-within:text-accent transition-colors"></i>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Lokasi Isu</label>
                                    <div class="relative group">
                                        <i data-lucide="map-pin" class="absolute left-6 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300 group-focus-within:text-accent transition-colors"></i>
                                        <input type="text" id="input-location" name="location" value="{{ old('location') }}" placeholder="Misal: Jakarta Utara" class="w-full pl-14 pr-8 py-5 bg-slate-50 border border-slate-100 rounded-[24px] outline-none transition-all font-semibold placeholder:text-slate-300 focus:bg-white focus:border-accent focus:shadow-[0_0_0_4px_rgba(37,99,235,0.08)]">
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3 bg-slate-50/50 p-6 rounded-[32px] border border-dashed border-slate-200">
                                <label class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1 flex items-center gap-2">
                                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-success"></i>
                                    Sumber / Link Referensi (Validasi)
                                </label>
                                <div class="relative group">
                                    <i data-lucide="link" class="absolute left-6 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300 group-focus-within:text-accent transition-colors"></i>
                                    <input type="url" id="input-link" name="reference_link" value="{{ old('reference_link') }}" placeholder="Link berita atau dokumen pendukung" class="w-full pl-14 pr-8 py-5 bg-white border border-slate-100 rounded-[24px] outline-none transition-all font-semibold placeholder:text-slate-300 focus:border-accent">
                                </div>
                                <p class="text-[10px] text-slate-400 font-medium  ml-1 leading-relaxed">Penyertaan referensi resmi meningkatkan kepercayaan publik dan mempercepat moderasi.</p>
                            </div>
                        </div>

                        <div class="pt-12 flex items-center justify-between border-t border-slate-50 mt-10">
                            <a href="/dashboard" class="px-8 py-5 text-slate-400 font-bold hover:text-slate-600 transition-all flex items-center gap-2">
                                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                                Batal & Kembali
                            </a>
                             <button type="button" onclick="goToStep(2)" class="group px-10 py-5 bg-accent text-white font-black rounded-[24px] shadow-xl shadow-accent/20 hover:scale-105 active:scale-95 transition-all flex items-center gap-3">
                                Lanjut Langkah Berikutnya
                                <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Section B: Description & Media -->
                    <div id="section-2" class="form-section p-8 md:p-14 section-animate">
                         <div class="space-y-2 mb-10">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-3 py-1 bg-accent/10 text-accent text-[9px] font-black uppercase tracking-widest rounded-lg">Langkah 2</span>
                                <div class="h-px flex-1 bg-slate-50"></div>
                            </div>
                            <h2 class="text-3xl font-outfit font-black text-primary">Deskripsi Isu</h2>
                            <p class="text-sm text-slate-400 font-medium">Beri tahu dunia secara detail mengapa isu ini penting untuk diselesaikan.</p>
                        </div>

                        <div class="space-y-10">
                            <div class="space-y-4">
                                <label class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Penjelasan Detail Isu</label>
                                <div class="relative">
                                    <textarea id="input-description" name="description" rows="8" placeholder="Ceritakan permasalahan secara mendalam, siapa yang terdampak, dan solusi apa yang Anda tawarkan..." class="w-full px-8 py-7 bg-slate-50 border border-slate-100 rounded-[32px] outline-none focus:bg-white focus:border-accent focus:shadow-[0_0_0_4px_rgba(37,99,235,0.08)] transition-all font-medium resize-none leading-relaxed">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <label class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Media Pendukung (Foto)</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div id="upload-zone" onclick="document.getElementById('file-upload').click()" class="aspect-video sm:aspect-auto sm:h-48 border-2 border-dashed border-slate-200 rounded-[32px] bg-slate-50/50 flex flex-col items-center justify-center gap-4 group cursor-pointer hover:bg-white hover:border-accent transition-all overflow-hidden relative">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-12 h-12 rounded-2xl bg-white shadow-sm flex items-center justify-center text-slate-400 group-hover:text-accent group-hover:scale-110 transition-all">
                                                <i data-lucide="image-plus" class="w-6 h-6"></i>
                                            </div>
                                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 group-hover:text-accent">Unggah Media</p>
                                        </div>
                                        <input type="file" name="image" id="file-upload" class="hidden" accept="image/*" onchange="handleFile(this)">
                                        <img id="image-preview" class="hidden absolute inset-0 w-full h-full object-cover">
                                    </div>
                                    <div class="bg-slate-50/50 rounded-[32px] border border-slate-100 p-8 flex flex-col justify-center gap-3">
                                        <div class="flex items-center gap-3 text-accent">
                                            <i data-lucide="help-circle" class="w-5 h-5"></i>
                                            <span class="text-xs font-black uppercase tracking-widest">Tips Unggah</span>
                                        </div>
                                        <p class="text-xs text-slate-500 leading-relaxed font-medium ">
                                            "Gunakan foto dengan aspek rasio 16:9 atau 4:3 untuk hasil pratinjau terbaik pada timeline warga."
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-12 flex items-center justify-between border-t border-slate-50 mt-10">
                             <button type="button" onclick="goToStep(1)" class="px-8 py-5 text-slate-400 font-bold hover:text-slate-600 transition-all flex items-center gap-2">
                                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                                Kembali
                            </button>
                             <button type="button" onclick="goToStep(3)" class="group px-10 py-5 bg-primary text-white font-black rounded-[24px] shadow-xl shadow-primary/20 hover:scale-105 active:scale-95 transition-all flex items-center gap-3">
                                Langkah Opsi Target
                                <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Section C: Targets & Goals -->
                    <div id="section-3" class="form-section p-8 md:p-14 section-animate">
                         <div class="space-y-2 mb-10">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-3 py-1 bg-accent/10 text-accent text-[9px] font-black uppercase tracking-widest rounded-lg">Langkah 3</span>
                                <div class="h-px flex-1 bg-slate-50"></div>
                            </div>
                            <h2 class="text-3xl font-outfit font-black text-primary">Target & Goals</h2>
                            <p class="text-sm text-slate-400 font-medium">Tetapkan target capaian untuk Suara Anda.</p>
                        </div>

                        <div class="space-y-10">
                        <div class="space-y-8">
                            <div class="space-y-3">
                                <label class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Hasil yang Diharapkan</label>
                                <div class="relative group">
                                    <i data-lucide="award" class="absolute left-6 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300 group-focus-within:text-accent transition-colors"></i>
                                    <input type="text" id="input-goal" name="expected_impact" value="{{ old('expected_impact') }}" placeholder="Misal: Janji tertulis Pemprov untuk pembangunan jembatan penyeberangan..." class="w-full pl-14 pr-8 py-5 bg-slate-50 border border-slate-100 rounded-[24px] outline-none transition-all font-bold placeholder:text-slate-300 focus:bg-white focus:border-accent">
                                </div>
                                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter ml-1">Gambarkan target konkrit yang ingin dicapai dari Suara ini.</p>
                            </div>

                            <div class="space-y-3">
                                <label class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Fundraising (Penggalangan Dana)</label>
                                <div class="flex items-center justify-between p-5 bg-slate-50 border border-slate-100 rounded-[24px]">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-slate-400">
                                            <i data-lucide="banknote" class="w-5 h-5"></i>
                                        </div>
                                        <div>
                                            <span class="text-xs font-black text-slate-700 block  leading-none">Aktifkan Donasi Kolektif?</span>
                                            <span class="text-[9px] text-slate-400 font-medium tracking-tight">Butuh dana operasional untuk aksi nyata ini?</span>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_fundraising" value="1" id="toggle-fund" class="sr-only peer" onchange="toggleFundraising(this.checked)" {{ old('is_fundraising') ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent"></div>
                                    </label>
                                </div>
                            </div>

                            <div id="fund-target-container" class="hidden animate-fade-in space-y-3 bg-accent/5 p-8 rounded-[32px] border border-accent/10">
                                <label class="text-[11px] font-black uppercase tracking-widest text-accent ml-1">Target Penggalangan Dana (Rp)</label>
                                <div class="relative group">
                                    <span class="absolute left-6 top-1/2 -translate-y-1/2 text-sm font-black text-accent">Rp</span>
                                    <input type="number" name="fund_target" id="input-fund-target" value="{{ old('fund_target') }}" placeholder="Contoh: 50.000.000" class="w-full pl-14 pr-8 py-5 bg-white border border-accent/20 rounded-[24px] outline-none transition-all font-bold placeholder:text-accent/30 focus:border-accent focus:ring-4 focus:ring-accent/5">
                                </div>
                                <p class="text-[9px] text-accent/60 font-medium  ml-1">*Dana yang terkumpul akan dikelola secara transparan oleh sistem Suara. Masukkan angka target dana yang dibutuhkan.</p>
                            </div>
                        </div>

                            <div class="space-y-6 pt-4 border-t border-slate-50">
                                <label class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Metode Kontribusi Unggulan</label>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                     <div onclick="selectContribution('voice')" id="btn-voice" class="p-8 rounded-[32px] border-2 border-accent bg-accent/5 flex flex-col items-center justify-center gap-4 group cursor-pointer transition-all">
                                         <div class="w-14 h-14 rounded-2xl bg-white shadow-lg flex items-center justify-center text-accent"><i data-lucide="megaphone" class="w-6 h-6"></i></div>
                                         <div class="text-center">
                                            <p class="text-sm font-black text-slate-900 group-hover:text-accent">Voice Only</p>
                                            <p class="text-[8px] font-black uppercase tracking-widest text-slate-400 mt-1">Hanya Dukungan</p>
                                         </div>
                                     </div>
                                     <div onclick="selectContribution('action')" id="btn-action" class="p-8 rounded-[32px] border-2 border-slate-100 hover:border-accent transition-all flex flex-col items-center justify-center gap-4 group cursor-pointer group">
                                         <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center text-slate-300 group-hover:text-accent transition-all"><i data-lucide="users" class="w-6 h-6"></i></div>
                                         <div class="text-center">
                                            <p class="text-sm font-black text-slate-900 group-hover:text-accent">Real Action</p>
                                            <p class="text-[8px] font-black uppercase tracking-widest text-slate-400 mt-1">Aksi Lapangan</p>
                                         </div>
                                     </div>
                                     <div onclick="selectContribution('fund')" id="btn-fund" class="p-8 rounded-[32px] border-2 border-slate-100 hover:border-accent transition-all flex flex-col items-center justify-center gap-4 group cursor-pointer group">
                                         <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center text-slate-300 group-hover:text-accent transition-all"><i data-lucide="banknote" class="w-6 h-6"></i></div>
                                         <div class="text-center">
                                            <p class="text-sm font-black text-slate-900 group-hover:text-accent">Fundraising</p>
                                            <p class="text-[8px] font-black uppercase tracking-widest text-slate-400 mt-1">Donasi Kolektif</p>
                                         </div>
                                     </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-12 flex items-center justify-between border-t border-slate-100 mt-10">
                            <button type="button" onclick="goToStep(2)" class="px-8 py-5 text-slate-400 font-bold hover:text-slate-600 transition-all flex items-center gap-2">
                                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                                Kembali
                            </button>
                             <button type="button" onclick="goToStep(4)" class="group px-10 py-5 bg-gradient-to-r from-accent to-blue-700 text-white font-black rounded-[24px] shadow-xl shadow-accent/20 hover:scale-105 active:scale-95 transition-all flex items-center gap-3">
                                Persiapan Tim & Publish
                                <i data-lucide="party-popper" class="w-5 h-5 group-hover:rotate-12 transition-transform"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Section D: Team & Review -->
                    <div id="section-4" class="form-section p-8 md:p-14 section-animate">
                         <div class="space-y-2 mb-10">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-3 py-1 bg-accent/10 text-accent text-[9px] font-black uppercase tracking-widest rounded-lg">Langkah 4</span>
                                <div class="h-px flex-1 bg-slate-50"></div>
                            </div>
                            <h2 class="text-3xl font-outfit font-black text-primary">Tim Kolaborator</h2>
                            <p class="text-sm text-slate-400 font-medium">Selesaikan pendaftaran dan undang tim pembantu jika ada.</p>
                        </div>

                        <div class="space-y-10">
                             <div class="bg-primary/5 rounded-[40px] p-10 border border-primary/5 flex flex-col items-center text-center gap-6 relative overflow-hidden group transition-all hover:bg-white hover:border-primary/10 hover:shadow-2xl">
                                 <div class="absolute -right-10 -top-10 w-40 h-40 bg-accent/5 rounded-full blur-3xl group-hover:bg-accent/10 transition-all"></div>
                                 <div class="w-20 h-20 rounded-[28px] bg-white shadow-xl flex items-center justify-center text-primary border border-slate-50 relative z-10">
                                     <i data-lucide="mail-plus" class="w-9 h-9"></i>
                                 </div>
                                 <div class="relative z-10 space-y-2">
                                     <h3 class="text-xl font-outfit font-black text-primary tracking-tight">Undang Rekan atau Aksivitas</h3>
                                     <p class="text-xs text-slate-400 font-medium max-w-sm mx-auto ">Isi alamat email mereka untuk memberi akses kolaborator pada kontrol panel Suara ini kelak.</p>
                                 </div>
                                 <div class="w-full max-w-md relative z-10">
                                     <input type="text" name="collaborator_email" placeholder="email-rekan@gmail.com (opsional)" class="w-full px-8 py-5 bg-white border border-slate-100 rounded-[24px] outline-none shadow-sm focus:border-accent transition-all font-bold text-center">
                                 </div>
                                 <button type="button" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-accent transition-colors">Lewati langkah ini sementara</button>
                             </div>

                             <div class="p-8 bg-slate-50 rounded-[40px] flex items-center gap-6 border border-slate-100">
                                 <div class="w-12 h-12 rounded-2xl bg-success/10 text-success flex items-center justify-center"><i data-lucide="shield-check" class="w-6 h-6"></i></div>
                                 <div>
                                     <h4 class="text-sm font-black text-slate-900 ">Verifikasi Meta-Data</h4>
                                     <p class="text-[10px] text-slate-400 font-medium leading-none mt-1">Otomatisasi pengecekan hoax & integrasi API Geolokasi telah aktif.</p>
                                 </div>
                             </div>
                        </div>

                        <div class="pt-12 flex items-center justify-between border-t border-slate-100 mt-10">
                            <button type="button" onclick="goToStep(3)" class="px-8 py-5 text-slate-400 font-bold hover:text-slate-600 transition-all flex items-center gap-2">
                                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                                Kembali
                            </button>
                            <div class="flex items-center gap-4">
                                <button type="button" onclick="document.getElementById('card-preview')?.scrollIntoView({behavior: 'smooth'})" class="hidden sm:block px-8 py-5 bg-white border border-slate-100 text-slate-400 text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-slate-50 transition-all">Preview</button>
                                <button type="submit" id="btn-submit-suara" class="px-10 py-5 bg-accent hover:bg-accent/90 text-white font-black rounded-[24px] shadow-2xl shadow-accent/30 hover:scale-[1.02] active:scale-95 transition-all text-lg flex items-center gap-3">
                                    <span>Publish Suara</span>
                                    <i data-lucide="send" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Context Support Info (Bottom) -->
                 <div class="mt-8 grid sm:grid-cols-2 gap-6 opacity-60 hover:opacity-100 transition-opacity">
                      <div class="flex items-start gap-4 p-6 bg-white rounded-[32px] border border-slate-100 card-shadow">
                          <div class="w-10 h-10 rounded-xl bg-accent/5 text-accent flex items-center justify-center flex-shrink-0"><i data-lucide="help-circle" class="w-5 h-5"></i></div>
                          <div>
                              <p class="text-xs font-black text-slate-900 uppercase">Butuh Bantuan?</p>
                              <p class="text-[10px] text-slate-400 font-medium mt-1">Cek panduan penulisan isu publik yang efektif di Pusat Bantuan Suara.</p>
                          </div>
                      </div>
                      <div class="flex items-start gap-4 p-6 bg-white rounded-[32px] border border-slate-100 card-shadow">
                          <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center flex-shrink-0"><i data-lucide="shield-alert" class="w-5 h-5"></i></div>
                          <div>
                              <p class="text-xs font-black text-slate-900 uppercase">Community Guides</p>
                              <p class="text-[10px] text-slate-400 font-medium mt-1">Pastikan isu Anda tidak mengandung unsur SARA dan ujaran kebencian.</p>
                          </div>
                      </div>
                 </div>
            </div>

            <!-- Right Side: Live Preview (Sticky) -->
            <div class="hidden lg:block lg:w-[400px]">
                <div class="sticky top-32 space-y-8">
                    <div class="flex items-center justify-between px-4">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] font-outfit">Live Appearance</h3>
                        <div class="flex items-center gap-2">
                             <div class="w-1.5 h-1.5 rounded-full bg-success animate-pulse"></div>
                             <span class="text-[8px] font-black text-slate-300 uppercase tracking-widest leading-none">Realtime Syncing</span>
                        </div>
                    </div>

                    <!-- The Actual Component-level Preview -->
                    <div id="card-preview" class="bg-white rounded-[40px] overflow-hidden card-shadow border border-slate-100 group transition-all duration-500 hover:-translate-y-2">
                         <div class="w-full h-56 bg-white relative overflow-hidden flex items-center justify-center">
                             <img id="preview-img" src="https://images.unsplash.com/photo-1540553016722-983e48a2cd10?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale opacity-10 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-700">
                             <div id="preview-img-placeholder" class="absolute flex flex-col items-center gap-4 text-slate-200">
                                 <i data-lucide="image" class="w-12 h-12"></i>
                                 <p class="text-[10px] font-black uppercase tracking-widest text-slate-300">Belum ada media</p>
                             </div>
                             <div class="absolute bottom-6 left-6 flex gap-2">
                                <span id="preview-category" class="px-4 py-1.5 bg-black/40 backdrop-blur-xl rounded-[14px] text-[9px] font-black text-white uppercase tracking-widest border border-white/10 ">Laporan Warga</span>
                             </div>
                         </div>
                         <div class="p-10 space-y-6">
                             <div class="space-y-2">
                                <h4 id="preview-title" class="text-2xl font-outfit font-black text-slate-900 leading-tight">Judul Isu Utama Anda Akan Tampil di Sini</h4>
                                <div class="flex items-center gap-2 text-slate-400">
                                    <i data-lucide="map-pin" class="w-4 h-4 text-accent"></i>
                                    <span id="preview-location" class="text-[10px] font-black uppercase tracking-widest">LOKASI BELUM DIATUR</span>
                                </div>
                             </div>
                             <div class="space-y-2">
                                 <p id="preview-description" class="text-sm text-slate-400 font-medium leading-relaxed  line-clamp-3">Deskripsi yang detail akan memancing empati dan dukungan publik yang lebih besar di platform Suara kita bersama.</p>
                                 <div class="w-12 h-1 bg-accent/10 rounded-full mt-4"></div>
                             </div>
                             
                             <div class="pt-8 border-t border-slate-50 flex items-center justify-between">
                                 <div class="flex items-center gap-6 opacity-30">
                                     <div class="flex items-center gap-2">
                                         <i data-lucide="megaphone" class="w-5 h-5"></i>
                                         <span class="text-xs font-black">0</span>
                                     </div>
                                     <div class="flex items-center gap-2">
                                         <i data-lucide="message-square" class="w-5 h-5"></i>
                                         <span class="text-xs font-black">0</span>
                                     </div>
                                 </div>
                                 <div class="flex items-center gap-3">
                                     <div class="w-11 h-11 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-300">
                                         <i data-lucide="bookmark" class="w-4 h-4"></i>
                                     </div>
                                     <div class="w-11 h-11 rounded-2xl bg-accent text-white flex items-center justify-center shadow-lg shadow-accent/20">
                                         <i data-lucide="share-2" class="w-4 h-4"></i>
                                     </div>
                                 </div>
                             </div>
                         </div>
                    </div>

                    <div class="p-10 bg-gradient-to-br from-primary to-slate-800 rounded-[40px] text-white relative overflow-hidden group shadow-2xl shadow-primary/20">
                         <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/5 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                         <h4 class="text-[11px] font-black uppercase tracking-[0.2em] opacity-40 mb-4 font-outfit ">Author System</h4>
                         <div class="flex items-center gap-5">
                             <div class="w-16 h-16 rounded-[24px] overflow-hidden border-2 border-white/20 shadow-xl group-hover:scale-110 transition-transform">
                                 <img src="https://i.pravatar.cc/100?u=current" class="w-full h-full object-cover">
                             </div>
                             <div>
                                 <p class="text-lg font-outfit font-black tracking-tight leading-none mb-1">Dimi Octora</p>
                                 <div class="flex items-center gap-2">
                                     <div class="w-1.5 h-1.5 rounded-full bg-success"></div>
                                     <span class="text-[8px] font-black uppercase tracking-widest opacity-60">Reputasi Terverifikasi</span>
                                 </div>
                             </div>
                         </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Success Toast - Hidden by default -->
    <div id="toast-success" class="fixed bottom-10 left-1/2 -translate-x-1/2 px-10 py-6 bg-slate-900 text-white rounded-[32px] shadow-2xl flex items-center gap-6 z-[200] opacity-0 translate-y-20 transition-all duration-700">
        <div class="w-12 h-12 bg-success rounded-2xl flex items-center justify-center shadow-lg shadow-success/20"><i data-lucide="check" class="w-6 h-6"></i></div>
        <div class="pr-8">
            <h5 class="text-sm font-black uppercase tracking-widest">Progress Tersimpan</h5>
            <p class="text-[10px] font-medium text-slate-400 mt-0.5">Lanjut ke langkah berikutnya...</p>
        </div>
    </div>

    <script>
        lucide.createIcons();

        let activeStep = 1;

        function goToStep(step) {
            // Validate when moving forward
            if (step > activeStep) {
                if (activeStep === 1) {
                    const title = (document.getElementById('input-title')?.value || '').trim();
                    const category = document.getElementById('input-category')?.value || '';
                    const location = (document.getElementById('input-location')?.value || '').trim();
                    if (!title) {
                        alert('Silakan isi Judul Suara terlebih dahulu.');
                        document.getElementById('input-title')?.focus();
                        return;
                    }
                    if (!category) {
                        alert('Silakan pilih Kategori Isu.');
                        document.getElementById('input-category')?.focus();
                        return;
                    }
                    if (!location) {
                        alert('Silakan isi Lokasi Isu.');
                        document.getElementById('input-location')?.focus();
                        return;
                    }
                } else if (activeStep === 2) {
                    const description = (document.getElementById('input-description')?.value || '').trim();
                    if (!description) {
                        alert('Silakan isi Deskripsi Isu terlebih dahulu.');
                        document.getElementById('input-description')?.focus();
                        return;
                    }
                }
            }

            // Update UI transition
            const sections = document.querySelectorAll('.form-section');
            sections.forEach(s => s.classList.remove('active'));
            
            setTimeout(() => {
                const targetSection = document.getElementById('section-' + step);
                if (targetSection) targetSection.classList.add('active');
            }, 50);

            // Update Progress Line
            const progressPercentage = (step - 1) * 33.33;
            const progressLine = document.getElementById('step-progress-line');
            if (progressLine) progressLine.style.width = progressPercentage + '%';

            // Update Circles
            for(let i=1; i<=4; i++) {
                const circle = document.getElementById('step-' + i + '-circle');
                const label = document.getElementById('step-' + i + '-label');
                if (!circle || !label) continue;
                
                if(i < step) {
                    circle.className = 'w-12 h-12 rounded-2xl flex items-center justify-center border-2 step-circle shadow-inner step-completed';
                    circle.innerHTML = '<i data-lucide="check" class="w-5 h-5"></i>';
                    label.className = "text-[10px] font-black uppercase tracking-widest text-success whitespace-nowrap";
                } else if(i === step) {
                    circle.className = 'w-12 h-12 rounded-2xl flex items-center justify-center border-2 step-circle shadow-inner step-active';
                    circle.innerHTML = getOriginalIcon(i);
                    label.className = "text-[10px] font-black uppercase tracking-widest text-accent whitespace-nowrap";
                } else {
                    circle.className = 'w-12 h-12 rounded-2xl flex items-center justify-center border-2 step-circle shadow-inner step-inactive';
                    circle.innerHTML = getOriginalIcon(i);
                    label.className = "text-[10px] font-black uppercase tracking-widest text-slate-400 whitespace-nowrap";
                }
            }

            // Show Toast feedback
            if(step > activeStep) showToast();
            
            activeStep = step;
            if (window.lucide) lucide.createIcons();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function validateAndSubmit(e) {
            if (e) e.preventDefault();
            
            const title = (document.getElementById('input-title')?.value || '').trim();
            const category = document.getElementById('input-category')?.value || '';
            const location = (document.getElementById('input-location')?.value || '').trim();
            const description = (document.getElementById('input-description')?.value || '').trim();
            
            if (!title) {
                alert('Mohon lengkapi Judul Suara pada Langkah 1.');
                goToStep(1);
                document.getElementById('input-title')?.focus();
                return false;
            }
            
            if (!category) {
                alert('Mohon pilih Kategori Isu pada Langkah 1.');
                goToStep(1);
                document.getElementById('input-category')?.focus();
                return false;
            }
            
            if (!location) {
                alert('Mohon isi Lokasi Isu pada Langkah 1.');
                goToStep(1);
                document.getElementById('input-location')?.focus();
                return false;
            }
            
            if (!description) {
                alert('Mohon lengkapi Deskripsi Isu pada Langkah 2.');
                goToStep(2);
                document.getElementById('input-description')?.focus();
                return false;
            }
            
            // Disable button to prevent double-submit & show loader
            const submitBtn = document.getElementById('btn-submit-suara');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
                submitBtn.innerHTML = `
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Memublikasikan Suara...</span>
                `;
            }
            
            document.getElementById('createSuaraForm').submit();
            return true;
        }

        function getOriginalIcon(i) {
            if(i === 1) return '<i data-lucide="info" class="w-5 h-5"></i>';
            if(i === 2) return '<i data-lucide="align-left" class="w-5 h-5"></i>';
            if(i === 3) return '<i data-lucide="target" class="w-5 h-5"></i>';
            if(i === 4) return '<i data-lucide="users" class="w-5 h-5"></i>';
        }

        function showToast() {
            const toast = document.getElementById('toast-success');
            toast.classList.remove('opacity-0', 'translate-y-20');
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-20');
            }, 2500);
        }

        function selectContribution(type) {
            document.getElementById('hidden-contribution-type').value = type;
            const types = ['voice', 'action', 'fund'];
            types.forEach(t => {
                const btn = document.getElementById('btn-' + t);
                const iconContainer = btn.querySelector('.w-14');
                const title = btn.querySelector('p:nth-child(1)');
                
                if(t === type) {
                    btn.className = "p-8 rounded-[32px] border-2 border-accent bg-accent/5 flex flex-col items-center justify-center gap-4 group cursor-pointer transition-all";
                    iconContainer.classList.add('shadow-lg', 'text-accent');
                    title.classList.add('text-accent');
                } else {
                    btn.className = "p-8 rounded-[32px] border-2 border-slate-100 hover:border-accent transition-all flex flex-col items-center justify-center gap-4 group cursor-pointer group";
                    iconContainer.classList.remove('shadow-lg', 'text-accent');
                    title.classList.remove('text-accent');
                }
            });
            lucide.createIcons();
        }

        function toggleFundraising(isActive) {
            const container = document.getElementById('fund-target-container');
            if (isActive) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
            lucide.createIcons();
        }

        function handleFile(input) {
            const preview = document.getElementById('image-preview');
            const placeholder = document.querySelector('#upload-zone .flex-col');
            const mainPreviewImg = document.getElementById('preview-img');
            const mainPlaceholder = document.getElementById('preview-img-placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    
                    mainPreviewImg.src = e.target.result;
                    mainPreviewImg.classList.remove('grayscale', 'opacity-10');
                    mainPlaceholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Live Realtime Preview System
        const existingTitles = @json(\App\Models\Suara::pluck('title')->toArray());

        const liveSync = () => {
             const title = document.getElementById('input-title').value;
             const location = document.getElementById('input-location').value;
             const category = document.getElementById('input-category').value;
             const description = document.getElementById('input-description').value;

             // Realtime Validation: Check Overlapping Words (>= 2)
             const errorEl = document.getElementById('title-error');
             const successEl = document.getElementById('title-success');
             const inputEl = document.getElementById('input-title');
             const statusIcon = document.getElementById('title-status-icon');
             
             if (title.length >= 5) {
                 const newWords = title.toLowerCase().split(/\s+/).filter(w => w.length > 2);
                 let isTooSimilar = false;
                 
                 for (const existing of existingTitles) {
                     const existingWords = existing.toLowerCase().split(/\s+/).filter(w => w.length > 2);
                     const overlap = newWords.filter(w => existingWords.includes(w));
                     
                     if (overlap.length >= 2) {
                         isTooSimilar = true;
                         break;
                     }
                 }
                 
                 statusIcon.classList.remove('hidden');
                 if (isTooSimilar) {
                     errorEl.classList.remove('hidden');
                     successEl.classList.add('hidden');
                     inputEl.classList.add('border-red-500', 'bg-red-50/50');
                     inputEl.classList.remove('border-slate-100', 'bg-slate-50', 'border-success', 'bg-success/5');
                     statusIcon.innerHTML = '<i data-lucide="x" class="w-5 h-5 text-red-500"></i>';
                 } else {
                     errorEl.classList.add('hidden');
                     successEl.classList.remove('hidden');
                     inputEl.classList.add('border-success', 'bg-success/5');
                     inputEl.classList.remove('border-slate-100', 'bg-slate-50', 'border-red-500', 'bg-red-50/50');
                     statusIcon.innerHTML = '<i data-lucide="check" class="w-5 h-5 text-success"></i>';
                 }
             } else {
                 errorEl.classList.add('hidden');
                 successEl.classList.add('hidden');
                 statusIcon.classList.add('hidden');
                 inputEl.classList.remove('border-red-500', 'bg-red-50/50', 'border-success', 'bg-success/5');
                 inputEl.classList.add('border-slate-100', 'bg-slate-50');
             }

             document.getElementById('preview-title').innerText = title || "Judul Isu Utama Anda Akan Tampil di Sini";
             document.getElementById('preview-location').innerText = (location || "LOKASI BELUM DIATUR").toUpperCase();
             document.getElementById('preview-category').innerText = (category || "LAPORAN WARGA").toUpperCase();
             document.getElementById('preview-description').innerText = description || "Deskripsi yang detail akan memancing empati dan dukungan publik yang lebih besar di platform Suara kita bersama.";
             
             document.getElementById('title-char-count').innerText = `${title.length} / 100`;
             lucide.createIcons();
        };

        const inputs = ['input-title', 'input-location', 'input-category', 'input-description'];
        inputs.forEach(id => {
            const el = document.getElementById(id);
            if(el) el.addEventListener('input', liveSync);
        });

    </script>
</body>
</html>
