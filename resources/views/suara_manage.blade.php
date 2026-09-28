<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Suara: {{ $suara->title }} — Suara</title>
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
                        heat: '#F43F5E',
                        tactical: '#1E293B',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        outfit: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Quill.js WYSIWYG -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #CBD5E1; }
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
        .font-outfit { font-family: 'Outfit', sans-serif; }
        .card-shadow { box-shadow: 0 10px 40px -10px rgba(15, 23, 42, 0.05); }

        /* Custom Quill Styling */
        .ql-toolbar.ql-snow {
            border: 1px solid #E2E8F0 !important;
            border-top-left-radius: 1.25rem !important;
            border-top-right-radius: 1.25rem !important;
            background-color: #F8FAFC !important;
            padding: 0.75rem 1rem !important;
        }
        .ql-container.ql-snow {
            border: 1px solid #E2E8F0 !important;
            border-top: none !important;
            border-bottom-left-radius: 1.25rem !important;
            border-bottom-right-radius: 1.25rem !important;
            background-color: #FFFFFF !important;
            font-family: inherit !important;
            font-size: 0.925rem !important;
        }
        .ql-editor {
            min-height: 220px !important;
            line-height: 1.75 !important;
            color: #1E293B !important;
            padding: 1.25rem !important;
        }
        .ql-editor.ql-blank::before {
            color: #94A3B8 !important;
            font-style: normal !important;
        }
        .ql-editor p {
            margin-bottom: 0.75rem !important;
        }
        .ql-editor ul, .ql-editor ol {
            padding-left: 1.5rem !important;
            margin-bottom: 0.75rem !important;
        }
        .ql-editor ul { list-style-type: disc !important; }
        .ql-editor ol { list-style-type: decimal !important; }
        .ql-editor h2, .ql-editor h3 {
            font-weight: 800 !important;
            margin-top: 1rem !important;
            margin-bottom: 0.5rem !important;
        }
    </style>
</head>
<body class="text-slate-900 selection:bg-accent/10 selection:text-accent font-sans bg-slate-50 min-h-screen" 
    x-data="{ 
        activeTab: new URLSearchParams(window.location.search).get('tab') || 'updates', 
        isEditing: false, 
        isPhaseEditing: false 
    }">

    <!-- Top Navbar -->
    <header class="sticky top-0 z-[100] bg-slate-900 text-white border-b border-slate-800 shadow-xl">
        <div class="container mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="/dashboard?view=suara" class="w-10 h-10 flex items-center justify-center rounded-2xl bg-slate-800 text-slate-300 hover:text-white hover:bg-slate-700 transition-all border border-slate-700" title="Kembali ke Dashboard">
                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                </a>
                <div class="h-8 w-px bg-slate-800 hidden sm:block"></div>
                <div class="max-w-md sm:max-w-xl">
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider bg-accent text-white">Kelola Isu</span>
                        <span class="text-[10px] text-slate-400 font-bold uppercase">ID #{{ str_pad($suara->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <h1 class="text-base sm:text-lg font-outfit font-black text-white leading-tight truncate">{{ $suara->title }}</h1>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="/suara-detail/{{ $suara->id }}" target="_blank" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 border border-slate-700 text-white font-bold text-xs rounded-xl transition-all flex items-center gap-2 shadow-sm">
                    <i data-lucide="external-link" class="w-3.5 h-3.5 text-accent"></i>
                    <span class="hidden sm:inline">Lihat Halaman Publik</span>
                    <span class="sm:hidden">Publik</span>
                </a>

                <button @click="activeTab = 'updates'" class="px-5 py-2.5 bg-accent hover:bg-blue-600 text-white font-bold text-xs rounded-xl transition-all flex items-center gap-2 shadow-lg shadow-accent/20">
                    <i data-lucide="plus-circle" class="w-3.5 h-3.5"></i>
                    <span class="hidden sm:inline">Buat Pembaruan</span>
                    <span class="sm:hidden">Pembaruan</span>
                </button>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 sm:px-6 py-8">
        <!-- Toast Notification -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                class="mb-8 bg-emerald-50 border border-emerald-200 text-emerald-800 p-5 rounded-3xl flex items-center justify-between gap-4 shadow-sm animate-fade-in">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0">
                        <i data-lucide="check" class="w-5 h-5"></i>
                    </div>
                    <p class="text-sm font-bold">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-emerald-600 hover:text-emerald-900 p-1">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
        @endif

        @if(session('error') || (isset($errors) && $errors->any()))
            <div x-data="{ show: true }" x-show="show" class="mb-8 bg-red-50 border border-red-200 text-red-800 p-5 rounded-3xl flex items-center justify-between gap-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-red-500 text-white flex items-center justify-center shrink-0">
                        <i data-lucide="alert-circle" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold">{{ session('error') ?? 'Terdapat kesalahan pada input formulir.' }}</p>
                        @if(isset($errors) && $errors->any())
                            <ul class="text-xs text-red-600 list-disc list-inside mt-1">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <button @click="show = false" class="text-red-600 hover:text-red-900 p-1">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
        @endif

        <!-- Quick Summary Stats Bar -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="p-6 bg-white rounded-3xl border border-slate-100 card-shadow flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-accent flex items-center justify-center shrink-0">
                    <i data-lucide="thumbs-up" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-wider text-slate-400">Dukungan Warga</p>
                    <p class="text-2xl font-black font-outfit text-slate-900">{{ number_format($suara->supporter_count ?? 0) }}</p>
                </div>
            </div>

            <div class="p-6 bg-white rounded-3xl border border-slate-100 card-shadow flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <i data-lucide="refresh-cw" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-wider text-slate-400">Pembaruan Isu</p>
                    <p class="text-2xl font-black font-outfit text-slate-900">{{ number_format($updates->count()) }}</p>
                </div>
            </div>

            <div class="p-6 bg-white rounded-3xl border border-slate-100 card-shadow flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-wider text-slate-400">Aksi Lapangan</p>
                    <p class="text-2xl font-black font-outfit text-slate-900">{{ number_format($missions->count()) }}</p>
                </div>
            </div>

            <div class="p-6 bg-white rounded-3xl border border-slate-100 card-shadow flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                    <i data-lucide="message-square" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-wider text-slate-400">Diskusi Warga</p>
                    <p class="text-2xl font-black font-outfit text-slate-900">{{ number_format($suara->comments()->count()) }}</p>
                </div>
            </div>
        </div>

        <!-- Main Workspace Grid (30/70 split) -->
        <div class="grid lg:grid-cols-10 gap-8">
            
            <!-- LEFT STRATEGIC COLUMN (30%) -->
            @include('partials.suara_manage._sidebar')

            <!-- RIGHT OPERATIONAL COLUMN (70%) -->
            <div class="lg:col-span-7 space-y-8 order-1 lg:order-2">

                <!-- ISSUE TIMELINE PHASE (WIDE HORIZONTAL) -->
                @include('partials.suara_manage._mission_progress')

                <!-- OPERATIONAL VIEWS -->
                @include('partials.suara_manage._updates')
                @include('partials.suara_manage._issue')
                @include('partials.suara_manage._field_mission')
                @if($suara->is_fundraising)
                    @include('partials.suara_manage._finance')
                @endif

            </div>

        </div> <!-- Close Main Grid -->
    </main>

    <script>
        let issueQuill = null;
        let impactQuill = null;
        let updateQuill = null;

        function initQuillEditors() {
            // 1. Issue Description Editor
            const issueElem = document.getElementById('issueDescriptionEditor');
            if (issueElem && !issueQuill) {
                issueQuill = new Quill('#issueDescriptionEditor', {
                    theme: 'snow',
                    placeholder: 'Tuliskan deskripsi permasalahan secara mendalam, kronologi, dan poin-poin penting...',
                    modules: {
                        toolbar: [
                            [{ 'header': [2, 3, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            ['blockquote', 'link'],
                            ['clean']
                        ]
                    }
                });

                const initialContent = {!! json_encode($suara->description) !!};
                if (initialContent) {
                    if (initialContent.includes('<p>') || initialContent.includes('<ul>') || initialContent.includes('<ol>') || initialContent.includes('<br>')) {
                        issueQuill.root.innerHTML = initialContent;
                    } else {
                        issueQuill.setText(initialContent);
                    }
                }
            }

            // 2. Expected Impact Editor
            const impactElem = document.getElementById('issueImpactEditor');
            if (impactElem && !impactQuill) {
                impactQuill = new Quill('#issueImpactEditor', {
                    theme: 'snow',
                    placeholder: 'Tuliskan poin-poin target dan dampak yang diharapkan...',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            ['clean']
                        ]
                    }
                });

                const initialImpact = {!! json_encode($suara->expected_impact) !!};
                if (initialImpact) {
                    if (initialImpact.includes('<p>') || initialImpact.includes('<ul>') || initialImpact.includes('<ol>') || initialImpact.includes('<br>')) {
                        impactQuill.root.innerHTML = initialImpact;
                    } else {
                        impactQuill.setText(initialImpact);
                    }
                }
            }

            // 3. Post Update Content Editor
            const updateElem = document.getElementById('updateContentEditor');
            if (updateElem && !updateQuill) {
                updateQuill = new Quill('#updateContentEditor', {
                    theme: 'snow',
                    placeholder: 'Tuliskan perkembangan terbaru, hasil pertemuan, tindak lanjut di lapangan, atau respon pihak terkait secara transparan...',
                    modules: {
                        toolbar: [
                            [{ 'header': [2, 3, false] }],
                            ['bold', 'italic', 'underline'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            ['blockquote', 'link'],
                            ['clean']
                        ]
                    }
                });
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
            initQuillEditors();

            // Sync on submit
            const editForm = document.getElementById('editIssueForm');
            if (editForm) {
                editForm.addEventListener('submit', function(e) {
                    const hiddenDesc = document.getElementById('issueDescriptionInput');
                    if (issueQuill && hiddenDesc) {
                        hiddenDesc.value = issueQuill.root.innerHTML;
                    }
                    const hiddenImpact = document.getElementById('issueImpactInput');
                    if (impactQuill && hiddenImpact) {
                        hiddenImpact.value = impactQuill.root.innerHTML;
                    }
                });
            }

            const postUpdateForm = document.getElementById('postUpdateForm');
            if (postUpdateForm) {
                postUpdateForm.addEventListener('submit', function(e) {
                    const hiddenInput = document.getElementById('updateContentInput');
                    if (updateQuill && hiddenInput) {
                        hiddenInput.value = updateQuill.root.innerHTML;
                    }
                });
            }
        });
    </script>
</body>
</html>
