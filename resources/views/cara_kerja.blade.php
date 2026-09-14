<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cara Kerja — Suara</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800;900&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Icons -->
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
                }
            }
        }
    </script>
    <style>
        .grid-bg {
            background-image: radial-gradient(circle at 1px 1px, rgba(0,0,0,0.05) 1px, transparent 0);
            background-size: 32px 32px;
        }
        
        .solid-card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05), 0 0 15px rgba(37, 99, 235, 0.03);
            border-radius: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .solid-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.1), 0 0 20px rgba(37, 99, 235, 0.08);
            border-color: #cbd5e1;
        }

        /* SVG Flow Animation */
        @keyframes flow {
            to { stroke-dashoffset: 0; }
        }
        .animate-flow {
            stroke-dasharray: 12;
            stroke-dashoffset: 120;
            animation: flow 4s linear infinite;
        }

        .step-number {
            font-family: 'Outfit', sans-serif;
            font-size: 8rem;
            line-height: 1;
            font-weight: 900;
            color: rgba(37, 99, 235, 0.05);
            position: absolute;
            top: -20px;
            right: 20px;
            z-index: 0;
            user-select: none;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans selection:bg-accent/20 grid-bg relative overflow-x-hidden">

    <!-- Header / Navbar -->
    <header class="sticky top-0 z-[100] bg-white/90 backdrop-blur-md border-b border-slate-200 shadow-sm transition-all duration-300">
        <nav class="container mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo -->
            <a href="/" class="flex items-center group flex-shrink-0">
                <img src="{{ asset('images/suara-logo-transparent.png') }}" alt="Suara Logo" class="h-8 w-auto group-hover:scale-110 transition-transform drop-shadow-xl">
            </a>

            <!-- Menu -->
            <div class="hidden md:flex items-center gap-10 text-sm font-black text-slate-500 uppercase tracking-widest">
                <a href="/suara" class="hover:text-accent transition-all">Suara</a>
                <a href="/cara-kerja" class="text-accent transition-all border-b-2 border-accent pb-1">Cara Kerja</a>
                <a href="/tentang" class="hover:text-accent transition-all">Tentang</a>
                <a href="#" class="hover:text-accent transition-all">Kontak</a>
            </div>

            <!-- Auth -->
            <div class="flex items-center gap-4">
                @auth
                    <a href="/dashboard" class="flex items-center gap-3 bg-slate-50 border border-slate-200 py-2.5 px-5 rounded-xl hover:bg-white hover:shadow-md transition-all">
                        <div class="w-2 h-2 rounded-full bg-success animate-pulse"></div>
                        <span class="text-xs font-black uppercase text-slate-700">{{ auth()->user()->name ?? 'Dimi Octora' }}</span>
                    </a>
                @else
                    <button onclick="window.location.href='/?auth=login'" class="bg-gradient-to-r from-accent to-success text-white text-sm font-black px-8 py-3 rounded-xl shadow-lg shadow-accent/30 hover:shadow-accent/50 hover:-translate-y-0.5 transition-all flex items-center gap-2">
                        <i data-lucide="user" class="w-4 h-4"></i> Masuk
                    </button>
                @endauth
            </div>
        </nav>
    </header>

    <main class="relative z-10 w-full pt-16 pb-32">
        <!-- Hero Section -->
        <section class="container mx-auto px-6 mb-20 relative text-center" data-aos="fade-down" data-aos-duration="1000">
            <div class="max-w-4xl mx-auto py-12">
                <div class="inline-flex items-center gap-2 bg-blue-50 px-5 py-2 rounded-full text-xs font-bold uppercase tracking-[0.2em] text-accent border border-blue-100 mb-8 shadow-sm">
                    <i data-lucide="layers" class="w-4 h-4"></i> Mekanisme Platform
                </div>
                
                <h1 class="text-5xl md:text-7xl font-outfit font-black text-slate-900 mb-6 tracking-tighter leading-tight drop-shadow-sm">
                    Bagaimana <span class="bg-clip-text text-transparent bg-gradient-to-r from-accent via-indigo-600 to-purple-600  pr-6">Suara Bekerja?</span>
                </h1>
                
                <p class="text-slate-600 text-lg md:text-xl font-medium max-w-2xl mx-auto leading-relaxed mt-8 bg-white/50 border-l-4 border-accent pl-6 py-2">
                    Dari sebuah aspirasi hingga menjadi aksi nyata. Kami merancang proses pelaporan yang terstruktur, berbasis bukti, dan didorong oleh kekuatan konsensus puluhan ribu opini publik.
                </p>
            </div>
        </section>

        <!-- Pipeline Langkah demi Langkah (Vertical Diagram) -->
        <section class="container mx-auto px-6 mb-40 relative">
            
            <!-- Connecting SVG Dotted Timeline Line -->
            <div class="absolute left-[50%] top-0 bottom-0 w-px -translate-x-1/2 hidden md:block opacity-40 pointer-events-none overflow-visible z-0" data-aos="fade-in" data-aos-duration="1500" data-aos-delay="500">
                <svg class="h-full w-3 absolute left-1/2 -translate-x-1/2 top-0" style="height: 100%;">
                    <line x1="1.5" y1="0" x2="1.5" y2="100%" stroke="#2563EB" stroke-width="3" stroke-dasharray="10 10" class="animate-flow" />
                </svg>
            </div>
            
            <div class="space-y-32">
                
                <!-- Langkah 1 -->
                <div class="flex flex-col md:flex-row items-center justify-between gap-12 group relative z-10">
                    <!-- Text (Left Side on Desktop) -->
                    <div class="md:w-5/12 text-right md:order-1 order-2" data-aos="fade-right" data-aos-duration="800">
                        <div class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Langkah Pertama</div>
                        <h3 class="text-3xl font-outfit font-black text-slate-900 mb-4 tracking-tight drop-shadow-sm">Pelaporan Isu Berbasis Bukti</h3>
                        <p class="text-slate-600 font-medium text-base leading-relaxed mb-6 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm text-left md:text-right">
                            Proses dimulai saat publik melaporkan masalah di sekitarnya. Untuk menjaga kredibilitas ekosistem, laporan wajib menyertakan <strong class="text-slate-800">fakta lapangan, referensi/bukti, serta kronologi utuh</strong>. Setiap pengguna sepenuhnya bertanggung jawab atas kebenaran isunya.
                        </p>
                        <div class="flex flex-wrap lg:justify-end gap-3 text-left md:text-right">
                            <span class="bg-blue-50 text-blue-700 text-xs font-bold px-3 py-1.5 rounded-lg border border-blue-100 flex items-center gap-1.5"><i data-lucide="map-pin" class="w-3.5 h-3.5 text-accent"></i> Verifikasi Lokasi</span>
                            <span class="bg-blue-50 text-blue-700 text-xs font-bold px-3 py-1.5 rounded-lg border border-blue-100 flex items-center gap-1.5"><i data-lucide="check" class="w-3.5 h-3.5 text-accent"></i> Fakta Faktual</span>
                        </div>
                    </div>
                    
                    <!-- SVG Node Graphic (Center) -->
                    <div class="md:w-2/12 flex justify-center md:order-2 order-1 relative z-20" data-aos="zoom-in" data-aos-duration="800" data-aos-delay="200">
                        <div class="w-28 h-28 bg-white border-[5px] border-slate-100 rounded-full flex items-center justify-center shadow-[0_15px_30px_rgba(37,99,235,0.15)] group-hover:border-accent group-hover:-translate-y-2 transition-all duration-500 text-accent">
                            <i data-lucide="file-signature" class="w-12 h-12 stroke-[2.5]"></i>
                        </div>
                    </div>
                    
                    <!-- Card Concept (Right Side on Desktop) -->
                    <div class="md:w-5/12 md:order-3 order-3" data-aos="fade-left" data-aos-duration="800" data-aos-delay="400">
                        <div class="solid-card p-8 border-b-8 border-b-accent relative overflow-hidden bg-white group-hover:bg-blue-50/10 transition-colors">
                            <div class="step-number text-blue-500/5 group-hover:text-blue-500/10 transition-colors duration-500">01</div>
                            <div class="relative z-10">
                                <h4 class="font-bold text-slate-800 mb-4 flex items-center gap-2"><i data-lucide="shield-check" class="w-5 h-5 text-accent"></i> Protokol Moderasi</h4>
                                <ul class="space-y-3 text-sm text-slate-600 font-medium">
                                    <li class="flex items-start gap-2"><i data-lucide="x-circle" class="w-4 h-4 mt-0.5 text-rose-500 flex-shrink-0"></i> Menolak hoax tak berdasar.</li>
                                    <li class="flex items-start gap-2"><i data-lucide="check-circle" class="w-4 h-4 mt-0.5 text-success flex-shrink-0"></i> Pra-moderasi aktif untuk isu-isu level elit/tinggi.</li>
                                    <li class="flex items-start gap-2"><i data-lucide="check-circle" class="w-4 h-4 mt-0.5 text-success flex-shrink-0"></i> Distribusi perlindungan kerahasiaan pelapor (jika disetujui).</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Langkah 2 -->
                <div class="flex flex-col md:flex-row items-center justify-between gap-12 group relative z-10">
                    <!-- Card Concept (Left Side on Desktop) -->
                    <div class="md:w-5/12 md:order-1 order-3" data-aos="fade-right" data-aos-duration="800" data-aos-delay="400">
                        <div class="solid-card p-8 border-b-8 border-b-emerald-500 relative bg-emerald-50/30">
                            <div class="step-number text-emerald-500/5 group-hover:text-emerald-500/10 transition-colors duration-500">02</div>
                            <div class="flex items-center gap-4 mb-6 font-bold text-sm uppercase border-b-2 border-emerald-100 pb-4">
                                <span class="text-slate-500 font-bold">Consensus:</span> 
                                <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-md font-black shadow-sm flex items-center gap-2">
                                    <div class="w-2 h-2 bg-success rounded-full animate-ping"></div> Crowd Vote Active
                                </span>
                            </div>
                            <!-- Right to rely graphic -->
                            <div class="bg-white rounded-2xl p-5 border border-emerald-100 shadow-sm flex items-center justify-between mt-6">
                                <div>
                                    <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest text-left leading-relaxed">Fasilitas Khusus</div>
                                    <div class="text-emerald-700 font-outfit text-xl font-black mt-1">Right to Reply</div>
                                </div>
                                <i data-lucide="scale" class="w-10 h-10 text-emerald-200"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- SVG Node Graphic (Center) -->
                    <div class="md:w-2/12 flex justify-center md:order-2 order-1 relative z-20" data-aos="zoom-in" data-aos-duration="800" data-aos-delay="200">
                        <div class="w-28 h-28 bg-white border-[5px] border-slate-100 rounded-full flex items-center justify-center shadow-[0_15px_30px_rgba(16,185,129,0.15)] group-hover:border-success group-hover:-translate-y-2 transition-all duration-500 text-success">
                            <i data-lucide="users" class="w-12 h-12 stroke-[2.5]"></i>
                        </div>
                    </div>
                    
                    <!-- Text (Right Side on Desktop) -->
                    <div class="md:w-5/12 text-left md:order-3 order-2" data-aos="fade-left" data-aos-duration="800">
                        <div class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Langkah Kedua</div>
                        <h3 class="text-3xl font-outfit font-black text-slate-900 mb-4 tracking-tight drop-shadow-sm">Diskusi & Konsensus Publik</h3>
                        <p class="text-slate-600 font-medium text-base leading-relaxed mb-6 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                            Laporan akan ditinjau secara terbuka. Ruang diskusi disediakan bagi sanggahan, opini beradab, serta pemberian <strong class="text-slate-800">dukungan suara/petisi</strong>. Saking pentingnya objektivitas, pihak tertuduh juga diberikan ruang <em class="text-slate-800">Right to Reply</em> (hak jawab) yang transparan.
                        </p>
                    </div>
                </div>

                <!-- Langkah 3 -->
                <div class="flex flex-col md:flex-row items-center justify-between gap-12 group relative z-10">
                    <!-- Text (Left Side on Desktop) -->
                    <div class="md:w-5/12 text-right md:order-1 order-2" data-aos="fade-right" data-aos-duration="800">
                        <div class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Langkah Ketiga</div>
                        <h3 class="text-3xl font-outfit font-black text-slate-900 mb-4 tracking-tight drop-shadow-sm">Pergerakan Menjadi Nyata</h3>
                        <p class="text-slate-600 font-medium text-base leading-relaxed mb-6 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm text-left md:text-right">
                            Saat sentimen masyarakat dirasa bulat dan urgensinya tervalidasi, opini berubah menjadi eskalasi mutlak. <strong class="text-slate-800">Mulai dari pendanaan operasional (crowdfunding) hingga logistik penerjunan relawan mutakhir</strong> menuntaskan masalah faktual di lapangan.
                        </p>
                    </div>
                    
                    <!-- SVG Node Graphic (Center) -->
                    <div class="md:w-2/12 flex justify-center md:order-2 order-1 relative z-20" data-aos="zoom-in" data-aos-duration="800" data-aos-delay="200">
                        <div class="w-28 h-28 bg-white border-[5px] border-slate-100 rounded-full flex items-center justify-center shadow-[0_15px_30px_rgba(79,70,229,0.15)] group-hover:border-indigo-600 group-hover:-translate-y-2 transition-all duration-500 text-indigo-600">
                            <i data-lucide="flag" class="w-12 h-12 stroke-[2.5]"></i>
                        </div>
                    </div>
                    
                    <!-- Card Concept (Right Side on Desktop) -->
                    <div class="md:w-5/12 md:order-3 order-3" data-aos="fade-left" data-aos-duration="800" data-aos-delay="400">
                        <div class="solid-card p-8 border-b-8 border-b-indigo-600 relative bg-white">
                            <div class="step-number text-indigo-500/5 group-hover:text-indigo-500/10 transition-colors duration-500">03</div>
                            <div class="relative z-10">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-indigo-50 p-5 rounded-xl border border-indigo-100 text-center shadow-inner hover:bg-white transition-colors">
                                        <i data-lucide="coins" class="w-8 h-8 mx-auto text-indigo-600 mb-2"></i>
                                        <div class="text-[10px] uppercase font-black tracking-widest leading-tight mb-2 text-indigo-900/50">Solidaritas Dana</div>
                                    </div>
                                    <div class="bg-indigo-50 p-5 rounded-xl border border-indigo-100 text-center shadow-inner hover:bg-white transition-colors">
                                        <i data-lucide="users" class="w-8 h-8 mx-auto text-indigo-600 mb-2"></i>
                                        <div class="text-[10px] uppercase font-black tracking-widest leading-tight mb-2 text-indigo-900/50">Pasukan Relawan</div>
                                    </div>
                                    <div class="col-span-2 bg-indigo-50 p-3 rounded-xl border border-indigo-100 flex items-center justify-center text-center shadow-inner hover:bg-white gap-2 transition-colors">
                                        <i data-lucide="file-text" class="w-5 h-5 text-indigo-600"></i>
                                        <div class="text-[10px] uppercase font-black tracking-widest text-indigo-900/50">Legislasi Petisi Massal</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- Separator Section -->
        <div class="container mx-auto px-6 mb-24 relative overflow-hidden" data-aos="fade-up">
            <div class="flex items-center justify-center gap-6">
                <div class="h-px flex-1 bg-gradient-to-r from-transparent via-slate-200 to-slate-300"></div>
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 bg-white border-2 border-slate-100 rounded-2xl flex items-center justify-center shadow-lg text-slate-400">
                        <i data-lucide="shield-alert" class="w-6 h-6"></i>
                    </div>
                    <span class="mt-3 text-[10px] font-black uppercase tracking-[0.4em] text-slate-400 font-mono">Transition_Protocol</span>
                </div>
                <div class="h-px flex-1 bg-gradient-to-l from-transparent via-slate-200 to-slate-300"></div>
            </div>
        </div>

        <!-- Cancel Culture Engine (Clear, High-Contrast Red Theme) -->
        <section class="container mx-auto px-6 relative z-10 mt-12" data-aos="fade-up" data-aos-duration="1000">
            <div class="bg-white rounded-[3rem] p-1.5 border-[3px] border-rose-200 xl:max-w-6xl mx-auto shadow-[0_20px_60px_-15px_rgba(225,29,72,0.15)] overflow-hidden">
                <div class="bg-rose-50 rounded-[2.8rem] p-10 md:p-14 relative overflow-hidden h-full w-full">
                    
                    <div class="absolute -right-20 -top-20 opacity-[0.03] text-rose-900 pointer-events-none">
                        <i data-lucide="gavel" class="w-96 h-96"></i>
                    </div>

                    <div class="flex flex-col lg:flex-row items-center gap-16 relative z-10">
                        <!-- Icon Side -->
                        <div class="lg:w-1/3 flex justify-center text-center">
                            <div>
                                <div class="w-24 h-24 mx-auto bg-white rounded-full shadow-xl shadow-rose-200 flex items-center justify-center relative z-20 border-[4px] border-rose-100 mb-6">
                                    <i data-lucide="alert-circle" class="w-10 h-10 text-rose-500 animate-pulse"></i>
                                </div>
                                <h3 class="text-3xl font-outfit font-black text-slate-900 mb-2 tracking-tight leading-tight">Pengorganisasian<br>Dorongan Publik</h3>
                                <p class="text-xs font-mono font-bold text-rose-500 uppercase tracking-widest">Dinamika "Cancel Culture"</p>
                            </div>
                        </div>

                        <!-- Content Side -->
                        <div class="lg:w-2/3">
                            <p class="text-slate-700 text-lg leading-relaxed mb-8 border-l-4 border-rose-400 pl-6 font-medium bg-white/60 py-4 pr-4 rounded-r-2xl">
                                Di dunia digital, <strong class="text-rose-700">"Cancel Culture"</strong> sering terjadi sebagai bentuk luapan kemarahan / tekanan saat pihak berwenang dirasa kebal dari hukum konvensional.
                            </p>
                            
                            <p class="text-slate-600 text-base leading-relaxed mb-6 font-medium">
                                Di Suara, kami menyikapi energi organik ini bukan sebagai ajang penghakiman tak mendasar, melainkan <strong class="text-slate-800">sebagai sarana korektif bersama</strong>. Oleh karena itu patut dicermati:
                            </p>
                            
                            <ul class="space-y-4 text-slate-600 font-bold mb-4">
                                <li class="flex items-start gap-4 bg-white p-4 rounded-xl border border-rose-100 shadow-sm">
                                    <span class="mt-0.5 w-6 h-6 flex items-center justify-center bg-rose-100 text-rose-600 rounded-full flex-shrink-0"><i data-lucide="x" class="w-3.5 h-3.5"></i></span>
                                    <span>Kami tidak memfasilitasi doxing (pembocoran data privat yang tak terkait kasus pidana) karena menabrak UU PDP.</span>
                                </li>
                                <li class="flex items-start gap-4 bg-white p-4 rounded-xl border border-rose-100 shadow-sm">
                                    <span class="mt-0.5 w-6 h-6 flex items-center justify-center bg-rose-100 text-rose-600 rounded-full flex-shrink-0"><i data-lucide="x" class="w-3.5 h-3.5"></i></span>
                                    <span>Kami mencegah ujaran kebencian berbasis SARA atau serangan personal buta yang tidak relevan dengan esensi kasus.</span>
                                </li>
                                <li class="flex items-start gap-4 bg-white p-4 rounded-xl border border-success/20 shadow-sm hover:border-success/50 transition-colors">
                                    <span class="mt-0.5 w-6 h-6 flex items-center justify-center bg-success/20 text-success rounded-full flex-shrink-0"><i data-lucide="check" class="w-4 h-4"></i></span>
                                    <span>Kami <strong>memberikan wadah untuk memutus dukungan secara sadar (yaitu boikot konsolidatif dan pemburukan rekam jejak korporat/figur)</strong> yang terukur dan dilandasi fakta utuh, bukan lewat sensasi sekejap.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer Light -->
    <footer class="bg-white pt-24 pb-12 text-slate-500 font-sans border-t border-slate-200 mt-20 relative z-20">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-4 gap-12 mb-20 text-sm">
                <div class="lg:col-span-1">
                    <a href="/" class="flex items-center mb-8 group">
                        <img src="{{ asset('images/suara-logo-transparent.png') }}" alt="Suara Logo" class="h-8 w-auto group-hover:rotate-6 transition-transform drop-shadow-2xl">
                    </a>
                    <p class="leading-relaxed font-medium">Sistem kolaborasi massal terdesentralisasi. Merubah tuntutan masyarakat menjadi tindakan terstruktur yang cepat dan transparan.</p>
                </div>
                
                <div>
                     <h4 class="text-slate-900 font-bold font-mono tracking-widest text-xs uppercase mb-6">Portal Pintar</h4>
                     <ul class="space-y-4">
                         <li><a href="/suara" class="hover:text-accent font-medium">Direktori Isu</a></li>
                         <li><a href="/cara-kerja" class="hover:text-accent font-medium">Metode Operasional</a></li>
                         <li><a href="/tentang" class="hover:text-accent font-medium">Pedoman Platform</a></li>
                     </ul>
                </div>
            </div>

            <div class="border-t border-slate-200 pt-8 flex flex-col md:row items-center justify-between gap-6 text-[10px] uppercase tracking-widest font-black text-slate-400 font-mono">
                <div class="flex items-center gap-4">
                    <span class="w-2 h-2 rounded-full bg-success animate-pulse"></span>
                    <span>System Normal</span>
                    <span>|</span>
                    <span>v2.0.26</span>
                </div>
                <div>&copy; 2026 SUARA INTEGRATED. ALL RIGHTS RESERVED.</div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <!-- AOS Animate on scroll script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true, // whether animation should happen only once - while scrolling down
            offset: 50, // offset (in px) from the original trigger point
            duration: 800, // values from 0 to 3000, with step 50ms
        });
        
        lucide.createIcons();
    </script>
</body>
</html>
