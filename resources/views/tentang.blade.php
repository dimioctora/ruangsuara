<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang — Suara</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800;900&family=JetBrains+Mono:wght@500;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    backgroundImage: {
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                    }
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
            transition: all 0.3s ease;
        }
        .solid-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.1), 0 0 20px rgba(37, 99, 235, 0.08);
            border-color: #cbd5e1;
        }
        
        /* Typography overrides for long-form content */
        .prose-custom p {
            margin-bottom: 1.5rem;
            line-height: 1.8;
            color: #475569; /* text-slate-600 */
        }
        .prose-custom ul {
            margin-bottom: 2rem;
            padding-left: 1.5rem;
        }
        .prose-custom li {
            margin-bottom: 0.75rem;
            position: relative;
            color: #475569;
        }
        .prose-custom li::marker {
            color: #2563EB;
        }
        .nav-link.active {
            color: #2563EB;
            font-weight: 800;
            border-left: 3px solid #2563EB;
            padding-left: 0.75rem;
            background: #eff6ff;
            border-radius: 0 0.5rem 0.5rem 0;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans selection:bg-accent/20 grid-bg relative overflow-x-hidden">

    <!-- Background Decoration -->
    <div class="fixed top-[-10%] right-[-5%] w-[600px] h-[600px] bg-blue-500/5 rounded-full blur-[100px] pointer-events-none -z-10"></div>
    <div class="fixed bottom-[-10%] left-[-5%] w-[600px] h-[600px] bg-emerald-500/5 rounded-full blur-[100px] pointer-events-none -z-10"></div>

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
                <a href="/cara-kerja" class="hover:text-accent transition-all">Cara Kerja</a>
                <a href="/tentang" class="text-accent transition-all border-b-2 border-accent pb-1">Tentang</a>
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
        <section class="container mx-auto px-6 mb-16 relative text-center">
            <div class="max-w-4xl mx-auto py-12">
                <div class="inline-flex items-center gap-2 bg-blue-50 px-5 py-2 rounded-full text-xs font-black uppercase tracking-[0.2em] text-accent border border-blue-100 mb-8 font-mono shadow-sm">
                    <i data-lucide="book-open" class="w-4 h-4"></i> Manifesto Platform
                </div>
                
                <h1 class="text-5xl md:text-7xl font-outfit font-black text-slate-900 mb-6 tracking-tighter leading-tight drop-shadow-sm">
                    Membangun Ekosistem <span class="bg-clip-text text-transparent bg-gradient-to-r from-accent via-indigo-600 to-purple-600  pr-6">Transparansi Publik</span>
                </h1>
                
                <p class="text-slate-600 text-lg md:text-xl font-medium max-w-2xl mx-auto leading-relaxed mt-8">
                    Mengubah akses informasi dan kebebasan berpendapat menjadi pilar utama sebuah ekosistem sosial digital yang sehat dan bertanggung jawab.
                </p>
            </div>
        </section>

        <!-- Content Outline Layout -->
        <section class="container mx-auto px-6">
            <div class="flex flex-col lg:flex-row gap-16 relative">
                
                <!-- Sticky Sidebar Navigation -->
                <div class="hidden lg:block w-3/12">
                    <div class="sticky top-32 p-6 bg-white rounded-2xl border border-slate-200 shadow-sm">
                        <h4 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6 font-mono">Daftar Isi</h4>
                        <nav class="flex flex-col space-y-2 text-sm font-bold text-slate-500 uppercase tracking-widest" id="tableOfContents">
                            <a href="#tentang-suara" class="nav-link p-3 rounded-lg hover:text-accent hover:bg-slate-50 transition-colors">Tentang Suara</a>
                            <a href="#apa-yang-bisa" class="nav-link p-3 rounded-lg hover:text-accent hover:bg-slate-50 transition-colors">Fungsi Platform</a>
                            <a href="#cancel-culture" class="nav-link p-3 rounded-lg hover:text-accent hover:bg-slate-50 transition-colors">Dinamika Publik</a>
                            <a href="#risiko-hukum" class="nav-link p-3 rounded-lg hover:text-accent hover:bg-slate-50 transition-colors">Risiko Hukum</a>
                            <a href="#fitur-keamanan" class="nav-link p-3 rounded-lg hover:text-accent hover:bg-slate-50 transition-colors">Fitur Keamanan</a>
                            <a href="#komitmen-kami" class="nav-link p-3 rounded-lg hover:text-accent hover:bg-slate-50 transition-colors">Komitmen Kami</a>
                        </nav>
                    </div>
                </div>

                <!-- Main Article Content -->
                <div class="w-full lg:w-9/12">
                    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/50 p-8 md:p-14 mb-16 prose-custom">
                        
                        <!-- 1. Tentang Suara -->
                        <div id="tentang-suara" class="scroll-mt-40 border-b border-slate-100 pb-12 mb-12">
                            <h2 class="text-3xl font-outfit font-black text-slate-900 mb-6 tracking-tight flex items-center gap-3">
                                <div class="w-2 h-8 bg-accent rounded-full"></div> Tentang Suara
                            </h2>
                            <p class="text-lg">
                                <strong class="text-slate-800">Suara</strong> adalah platform digital yang menyediakan ruang bagi masyarakat untuk menyuarakan isu, membahas kontroversi publik, serta mendorong transparansi terhadap figur publik maupun institusi. Kami percaya bahwa akses terhadap informasi dan kebebasan berpendapat adalah bagian penting dari ekosistem sosial yang sehat—namun harus dijalankan dengan penuh tanggung jawab.
                            </p>
                        </div>

                        <!-- 2. Apa yang Bisa Dilakukan -->
                        <div id="apa-yang-bisa" class="scroll-mt-40 border-b border-slate-100 pb-12 mb-12">
                            <div class="inline-flex px-3 py-1 bg-slate-100 text-slate-500 text-xs font-black uppercase tracking-widest rounded mb-4 font-mono">Fungsi Utama</div>
                            <h2 class="text-3xl font-outfit font-black text-slate-900 mb-8 tracking-tight">Apa yang Bisa Dilakukan di Suara?</h2>

                            <div class="grid md:grid-cols-2 gap-8 mb-10">
                                <!-- Card 1 -->
                                <div class="bg-slate-50 p-8 rounded-2xl border border-slate-200 hover:border-slate-300 hover:shadow-md transition-all">
                                    <div class="w-14 h-14 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-blue-600 mb-6 shadow-sm">
                                        <i data-lucide="search" class="w-6 h-6"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-800 mb-4">1. Pelaporan Isu Publik</h3>
                                    <p class="text-sm">Pengguna dapat membagikan isu yang sedang terjadi di masyarakat, baik yang berkaitan dengan individu, organisasi, maupun fenomena sosial. Setiap laporan didorong untuk menyertakan:</p>
                                    <ul class="text-sm font-bold text-slate-700 mt-4 space-y-2">
                                        <li class="flex items-center gap-2 before:content-hidden"><i data-lucide="check" class="w-4 h-4 text-accent"></i> Fakta yang dapat diverifikasi</li>
                                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-accent"></i> Sumber atau bukti pendukung</li>
                                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-accent"></i> Kronologi yang jelas</li>
                                    </ul>
                                </div>
                                
                                <!-- Card 2 -->
                                <div class="bg-slate-50 p-8 rounded-2xl border border-slate-200 hover:border-slate-300 hover:shadow-md transition-all">
                                    <div class="w-14 h-14 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-emerald-600 mb-6 shadow-sm">
                                        <i data-lucide="message-square-quote" class="w-6 h-6"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-800 mb-4">2. Diskusi & Opini Terbuka</h3>
                                    <p class="text-sm">Suara menyediakan ruang diskusi bagi publik untuk memberikan perspektif, opini, dan analisis terhadap suatu isu. Kami senantiasa mendorong diskusi yang:</p>
                                    <ul class="text-sm font-bold text-slate-700 mt-4 space-y-2">
                                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-success"></i> Kritis namun tetap sopan</li>
                                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-success"></i> Berbasis argumen rasional</li>
                                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-success"></i> Bebas ujaran kebencian</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Dinamika Cancel Culture -->
                        <div id="cancel-culture" class="scroll-mt-40 border-b border-slate-100 pb-12 mb-12">
                            <div class="bg-rose-50/50 p-8 md:p-10 rounded-[2rem] border border-rose-100 relative overflow-hidden">
                                <i data-lucide="alert-triangle" class="absolute -right-4 -bottom-4 w-40 h-40 text-rose-100 -z-0"></i>
                                <div class="relative z-10">
                                    <div class="flex items-center gap-4 mb-6">
                                        <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center font-black text-xl">
                                            3
                                        </div>
                                        <h3 class="text-2xl font-outfit font-black text-slate-900 tracking-tight">Dinamika "Cancel Culture"</h3>
                                    </div>
                                    <p>Kami memahami bahwa fenomena “cancel culture” adalah bagian dari dinamika sosial digital saat ini, di mana publik dapat memberikan tekanan sosial terhadap individu atau pihak tertentu.</p>
                                    <p class="font-bold text-slate-800 mb-4">Namun patut diingat bahwa di Suara:</p>
                                    <ul class="bg-white p-6 rounded-2xl border border-rose-100 shadow-sm text-sm space-y-4 mb-0">
                                        <li class="flex items-start gap-3"><div class="mt-0.5 bg-rose-100 p-1 rounded"><i data-lucide="x" class="w-3 h-3 text-rose-600 font-bold"></i></div> <strong>Tidak difasilitasi sebagai tujuan utama</strong> melainkan sekadar fenomena yang terjadi secara organik dari diskusi publik.</li>
                                        <li class="flex items-start gap-3"><div class="mt-0.5 bg-rose-100 p-1 rounded"><i data-lucide="x" class="w-3 h-3 text-rose-600 font-bold"></i></div> <strong>Tidak mendorong penghakiman tanpa dasar</strong> yang bersifat destruktif.</li>
                                        <li class="flex items-start gap-3"><div class="mt-0.5 bg-success/20 p-1 rounded"><i data-lucide="check" class="w-3 h-3 text-success font-bold"></i></div> <strong>Selalu memegang prinsip kehati-hatian</strong> dan mengutamakan verifikasi terlebih dahulu dalam setiap isu terkait.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Kesadaran Risiko Hukum -->
                        <div id="risiko-hukum" class="scroll-mt-40 border-b border-slate-100 pb-12 mb-12">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-2 h-8 bg-amber-500 rounded-full"></div> 
                                <h2 class="text-3xl font-outfit font-black text-slate-900 tracking-tight">Kesadaran Risiko Hukum</h2>
                            </div>
                            
                            <p class="text-lg">Suara beroperasi murni sesuai dengan koridor hukum yang berlaku mutlak di negara Republik Indonesia, termasuk namun tidak terbatas pada:</p>
                            <div class="flex flex-wrap gap-4 mb-8">
                                <span class="bg-amber-50 text-amber-700 px-4 py-2 rounded-lg font-mono text-sm font-bold border border-amber-100">UU ITE</span>
                                <span class="bg-amber-50 text-amber-700 px-4 py-2 rounded-lg font-mono text-sm font-bold border border-amber-100">KUHP Pidana</span>
                                <span class="bg-amber-50 text-amber-700 px-4 py-2 rounded-lg font-mono text-sm font-bold border border-amber-100">UU Pelindungan Data Pribadi</span>
                            </div>

                            <p class="font-bold text-slate-800">Kami dengan tegas mengingatkan bahwa:</p>
                            <ul class="text-slate-600">
                                <li>Penyebaran informasi yang tidak benar dapat berpotensi menjadi <strong>pencemaran nama baik</strong>.</li>
                                <li>Pengungkapan data pribadi tanpa izin (doxing) dapat melanggar hukum serius.</li>
                                <li>Ujaran kebencian, pencacian, dan fitnah telanjang dapat memiliki konsekuensi hukuman kurungan & perdata.</li>
                            </ul>
                            
                            <div class="bg-slate-900 text-white p-6 rounded-2xl flex items-center gap-4 mt-8 shadow-xl shadow-slate-900/10">
                                <i data-lucide="shield-alert" class="w-8 h-8 text-amber-400 flex-shrink-0"></i>
                                <span class="font-mono text-sm uppercase tracking-wider font-bold">Setiap pengguna bertanggung jawab secara penuh, personal, dan mutlak atas segala konten yang mereka publikasikan.</span>
                            </div>
                        </div>

                        <!-- 5. Fitur Keamanan & Perlindungan -->
                        <div id="fitur-keamanan" class="scroll-mt-40 border-b border-slate-100 pb-12 mb-12">
                            <h2 class="text-3xl font-outfit font-black text-slate-900 mb-8 tracking-tight flex items-center gap-3">
                                <div class="w-2 h-8 bg-success rounded-full"></div> Fitur Keamanan & Perlindungan
                            </h2>
                            <p class="mb-8">Untuk memelihara ekosistem yang sehat secara berkelanjutan dan meminimalisir risiko hukum para pengguna, platform Suara dilengkapi dengan instrumen proaktif:</p>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="solid-card p-6">
                                    <div class="flex items-center gap-3 mb-3 text-success font-black text-sm uppercase tracking-widest"><i data-lucide="shield-check" class="w-5 h-5"></i> Moderasi Ketat</div>
                                    <h4 class="font-bold text-slate-900 text-base mb-2">Sistem Verifikasi Konten</h4>
                                    <p class="text-sm text-slate-500 m-0 leading-relaxed font-medium">Konten tertentu akan masuk karantina moderasi sebelum di-publish, terutama menyangkut tuduhan serius berdimensi tinggi.</p>
                                </div>
                                <div class="solid-card p-6">
                                    <div class="flex items-center gap-3 mb-3 text-success font-black text-sm uppercase tracking-widest"><i data-lucide="file-search" class="w-5 h-5"></i> Bukti Valid</div>
                                    <h4 class="font-bold text-slate-900 text-base mb-2">Kewajiban Referensi</h4>
                                    <p class="text-sm text-slate-500 m-0 leading-relaxed font-medium">Pengguna selalu didorong (dan dalam kasus sensitif bersyarat mutlak) untuk menyematkan bukti valid atas isunya.</p>
                                </div>
                                <div class="solid-card p-6">
                                    <div class="flex items-center gap-3 mb-3 text-success font-black text-sm uppercase tracking-widest"><i data-lucide="megaphone" class="w-5 h-5"></i> Right to Reply</div>
                                    <h4 class="font-bold text-slate-900 text-base mb-2">Hak Klarifikasi</h4>
                                    <p class="text-sm text-slate-500 m-0 leading-relaxed font-medium">Pihak/institusi yang disorot/disebut diberi alokasi ruang adil untuk memberikan sanggahan secara terbuka.</p>
                                </div>
                                <div class="solid-card p-6">
                                    <div class="flex items-center gap-3 mb-3 text-success font-black text-sm uppercase tracking-widest"><i data-lucide="eye-off" class="w-5 h-5"></i> Regulasi Data</div>
                                    <h4 class="font-bold text-slate-900 text-base mb-2">Perlindungan Data Personal</h4>
                                    <p class="text-sm text-slate-500 m-0 leading-relaxed font-medium">Sistem secara algoritmis akan memoderasi konten yang memuat informasi data pribadi rawan penyalahgunaan dox.</p>
                                </div>
                            </div>
                            
                            <!-- Peringatan Publikasi Section -->
                            <div class="mt-8 border-l-4 border-indigo-500 bg-indigo-50 p-6 rounded-r-2xl">
                                <h4 class="font-bold text-indigo-900 flex items-center gap-2 mb-2"><i data-lucide="bell" class="w-5 h-5 text-indigo-500"></i> Peringatan Pra-Publikasi</h4>
                                <p class="text-sm text-indigo-800 m-0 font-medium">Setiap pengguna akan secara konsisten disapa oleh notifikasi preventif sebelum menekan tombol rilis:</p>
                                <blockquote class="border-l-2 border-indigo-300 pl-4 mt-4  text-indigo-700 font-bold">
                                    "Pastikan informasi yang Anda bagikan akurat secara jurnalistik dan tidak mengekspos pelanggaran hukum. Suara Anda merefleksikan karakter Anda."
                                </blockquote>
                                <div class="mt-4 pt-4 border-t border-indigo-200">
                                    <h4 class="font-bold text-indigo-900 mb-2">Sistem Pelaporan & Takedown</h4>
                                    <p class="text-sm text-indigo-800 m-0 font-medium whitespace-pre-line">Setiap konten dapat di-flag/lapor. Tim operasional berhak: 1. Meninjau Ulang, 2. Membatasi Distribusi Publik, 3. Menghapus (Takedown) mutlak jika melabrak pedoman hukum.</p>
                                </div>
                            </div>
                        </div>

                        <!-- 6. Komitmen & Penutup -->
                        <div id="komitmen-kami" class="scroll-mt-40">
                            <h2 class="text-3xl font-outfit font-black text-slate-900 mb-6 tracking-tight flex items-center gap-3">
                                <div class="w-2 h-8 bg-blue-500 rounded-full"></div> Komitmen Kami
                            </h2>
                            <p>Suara berkomitmen jangka-panjang untuk selalu menjadi:</p>
                            <ul class="text-slate-700 space-y-2 mb-10">
                                <li class="font-bold flex items-center gap-2 before:content-hidden"><i data-lucide="check-circle" class="w-5 h-5 text-blue-500"></i> Platform yang mendorong transparansi dan akuntabilitas.</li>
                                <li class="font-bold flex items-center gap-2 before:content-hidden"><i data-lucide="check-circle" class="w-5 h-5 text-blue-500"></i> Ruang diskusi yang absolut bebas namun tetap bertanggung jawab penuh.</li>
                                <li class="font-bold flex items-center gap-2 before:content-hidden"><i data-lucide="check-circle" class="w-5 h-5 text-blue-500"></i> Ekosistem digital yang dijamin aman secara legislatif hukum dan etika sosial.</li>
                            </ul>
                            
                            <p class="text-xl font-outfit font-black text-slate-800  mb-12 text-center">"Kami amat memvalidasi bahwa suara publik sungguh berpengaruh—tetapi haruslah diformulasikan dengan sangat bijak."</p>

                            <!-- Final Word -->
                            <div class="bg-slate-50 border border-slate-200 p-8 rounded-2xl relative overflow-hidden">
                                <div class="absolute top-0 left-0 w-2 h-full bg-slate-900"></div>
                                <h3 class="text-lg font-black text-slate-900 uppercase tracking-widest font-mono mb-4">Agreement Notice</h3>
                                <p class="text-sm mb-4">Dengan menyetujui, membaca, dan menggunakan fasilitas jaringan Suara OS, Anda mengikat pakta untuk:</p>
                                <ul class="text-sm font-bold text-slate-700 space-y-2">
                                    <li>Tidak merakit atau meledakkan disinformasi (berita pelintiran palsu).</li>
                                    <li>Tidak mengaktivasi serangan privasi, SARA, atau cacian subyektif murahan.</li>
                                    <li>Sangat menjunjung tinggi hukum & hak kekayaan privasi orang lain.</li>
                                </ul>
                                <p class="mt-6 text-sm text-slate-500 bg-white p-4 rounded-xl border border-slate-100 font-bold border-l-4 border-l-slate-400">
                                    Suara bukanlah colosseum untuk menghakimi martabat seseorang di luar yurisdiksi, melainkan tempat beradab untuk membedah masalah, menyampaikan kritik keras berdasar fakta, dan mencari oase kebenaran kolaboratif bersama.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>

    </main>

    <!-- Footer Light -->
    <footer class="bg-white pt-24 pb-12 text-slate-500 font-sans border-t border-slate-200 mt-10 relative z-20">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-4 gap-12 mb-20 text-sm">
                <div class="lg:col-span-1">
                    <a href="/" class="flex items-center mb-8 group">
                        <img src="{{ asset('images/suara-logo-transparent.png') }}" alt="Suara Logo" class="h-8 w-auto group-hover:rotate-6 transition-transform drop-shadow-2xl">
                    </a>
                    <p class="leading-relaxed font-medium">Sistem kolaborasi massal terdesentralisasi. Transparansi tinggi, dampak tanpa limitasi birokrasi, dengan amanat etika.</p>
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

    <script>
        lucide.createIcons();

        // Simple TOC highlight logic
        document.addEventListener('DOMContentLoaded', () => {
            const sections = document.querySelectorAll('main section div[id]');
            const navLinks = document.querySelectorAll('#tableOfContents .nav-link');

            window.addEventListener('scroll', () => {
                let current = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;
                    // Adjusted offset for sticky header
                    if (scrollY >= (sectionTop - 200)) {
                        current = section.getAttribute('id');
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href').substring(1) === current) {
                        link.classList.add('active');
                    }
                });
            });
        });
    </script>
</body>
</html>
