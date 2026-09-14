<!-- VIEW: SUARA ISSUE (MISSION BRIEFING) -->
<div x-show="activeTab === 'issue'" x-transition:enter="transition ease-out duration-500" class="space-y-10">
    <div class="bg-white p-12 rounded-[56px] border border-slate-100 card-shadow">
        <div class="flex items-center justify-between mb-16">
            <div class="flex items-center gap-4">
                <div class="w-2 h-10 bg-accent rounded-full"></div>
                <h3 class="text-2xl font-black uppercase tracking-[0.3em] text-slate-900 " x-text="isEditing ? 'Modify Mission Briefing' : 'Original Mission Briefing'"></h3>
            </div>
            <div class="flex items-center gap-4">
                @if(auth()->id() == $suara->user_id)
                    <button @click="isEditing = !isEditing" 
                        class="px-8 py-3 rounded-2xl border-2 border-slate-100 text-slate-400 text-[10px] font-black uppercase tracking-widest  hover:border-accent hover:text-accent transition-all shadow-sm active:scale-95 flex items-center gap-3 bg-white group"
                        :class="isEditing ? 'border-heat/20 text-heat bg-heat/5' : ''">
                        <template x-if="!isEditing">
                            <div class="flex items-center gap-3">
                                <i data-lucide="edit-3" class="w-4 h-4 group-hover:rotate-12 transition-transform"></i>
                                EDIT ISSUE
                            </div>
                        </template>
                        <template x-if="isEditing">
                            <div class="flex items-center gap-3">
                                <i data-lucide="x" class="w-4 h-4 text-heat"></i>
                                ABORT MISSION EDIT
                            </div>
                        </template>
                    </button>
                @endif
                <span class="px-6 py-3 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest  shadow-xl">
                    {{ auth()->id() == $suara->user_id ? 'MISSION COMMANDER ACCESS' : 'INTEL VIEW ONLY' }}
                </span>
            </div>
        </div>

        <!-- LIVE PREVIEW MODE -->
        <div x-show="!isEditing" class="space-y-16 animate-fade-in" x-transition:enter="transition-all duration-500 delay-200">
            <div class="grid md:grid-cols-2 gap-16">
                <div class="space-y-4">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]  leading-none px-1">Tactical Objective</p>
                    <h2 class="text-5xl font-outfit font-black text-slate-900  leading-tight tracking-tighter">{{ $suara->title }}</h2>
                </div>
                <div class="space-y-4">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]  leading-none px-1">Strategic Sector</p>
                    <div class="inline-flex px-8 py-4 bg-slate-50 border border-slate-100 rounded-[32px] font-black uppercase tracking-[0.2em] text-[12px]  text-accent shadow-inner items-center gap-4">
                        <i data-lucide="globe" class="w-4 h-4"></i>
                        {{ $suara->category }}
                    </div>
                </div>
            </div>

            <div class="p-12 bg-slate-50 rounded-[64px] border border-slate-100 relative overflow-hidden group shadow-inner">
                <div class="absolute top-0 right-0 w-64 h-64 bg-accent/5 rounded-full -mr-32 -mt-32 transition-transform duration-1000 group-hover:scale-150"></div>
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]  mb-8 flex items-center gap-3">
                        <i data-lucide="file-text" class="w-4 h-4 text-accent"></i>
                        Detailed Intelligence Briefing
                    </p>
                    <p class="text-2xl font-medium text-slate-800 leading-[1.6]  font-outfit">{{ $suara->description }}</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                <div class="flex items-center gap-8 group">
                    <div class="w-20 h-20 rounded-[32px] bg-white border border-slate-100 shadow-2xl flex items-center justify-center text-accent transition-transform group-hover:rotate-6 group-hover:scale-110"><i data-lucide="map-pin" class="w-8 h-8"></i></div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest  mb-2">Operation Base</p>
                        <p class="text-xl font-black text-slate-900 uppercase  tracking-tighter">{{ $suara->location }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-8 group">
                    <div class="w-20 h-20 rounded-[32px] bg-white border border-slate-100 shadow-2xl flex items-center justify-center text-accent transition-transform group-hover:-rotate-6 group-hover:scale-110"><i data-lucide="external-link" class="w-8 h-8"></i></div>
                    <div class="overflow-hidden">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest  mb-2">Digital Blueprint</p>
                        <a href="{{ $suara->reference_link }}" target="_blank" class="text-xl font-black text-accent uppercase  tracking-tighter truncate block hover:underline">{{ $suara->reference_link ?: 'NO DATA LINK' }}</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- EDIT FORM MODE (CREATOR ONLY) -->
        @if(auth()->id() == $suara->user_id)
            <div x-show="isEditing" x-cloak class="animate-fade-in" x-transition:enter="transition ease-out duration-500">
                <form action="/suara-manage/{{ $suara->id }}/update-issue" method="POST" class="space-y-12">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-12">
                        <div class="space-y-4">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]  px-4">Mission Call-Sign (Title)</label>
                            <input type="text" name="title" value="{{ $suara->title }}" 
                                class="w-full px-10 py-6 bg-slate-50 border-2 border-slate-100 rounded-[32px] font-black text-[15px]  text-slate-900 focus:border-accent focus:bg-white outline-none transition-all shadow-inner uppercase tracking-widest">
                        </div>
                        <div class="space-y-4">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]  px-4">Categorization Profile</label>
                            <select name="category" 
                                class="w-full px-10 py-6 bg-slate-50 border-2 border-slate-100 rounded-[32px] font-black text-[15px]  text-slate-900 focus:border-accent focus:bg-white outline-none transition-all shadow-inner uppercase tracking-widest appearance-none">
                                <option value="Lingkungan" {{ $suara->category == 'Lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                                <option value="Keadilan" {{ $suara->category == 'Keadilan' ? 'selected' : '' }}>Keadilan</option>
                                <option value="Hak Asasi Manusia" {{ $suara->category == 'Hak Asasi Manusia' ? 'selected' : '' }}>Hak Asasi Manusia</option>
                                <option value="Pemerintah & Politik" {{ $suara->category == 'Pemerintah & Politik' ? 'selected' : '' }}>Pemerintah & Politik</option>
                                <option value="Pendidikan" {{ $suara->category == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                <option value="Entertainment" {{ $suara->category == 'Entertainment' ? 'selected' : '' }}>Entertainment</option>
                                <option value="Suara Konsumen" {{ $suara->category == 'Suara Konsumen' ? 'selected' : '' }}>Suara Konsumen</option>
                                <option value="Infrastruktur" {{ $suara->category == 'Infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                                <option value="Lainnya" {{ $suara->category == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        <div class="md:col-span-2 space-y-4">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]  px-4">Operational Briefing Content</label>
                            <textarea name="description" rows="6" 
                                class="w-full px-10 py-8 bg-slate-50 border-2 border-slate-100 rounded-[40px] font-medium text-lg  text-slate-900 focus:border-accent focus:bg-white outline-none transition-all shadow-inner resize-none leading-relaxed">{{ $suara->description }}</textarea>
                        </div>
                        <div class="space-y-4">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]  px-4">Strategic Location Base</label>
                            <input type="text" name="location" value="{{ $suara->location }}"
                                class="w-full px-10 py-6 bg-slate-50 border-2 border-slate-100 rounded-[32px] font-black text-[15px]  text-slate-900 focus:border-accent focus:bg-white outline-none transition-all shadow-inner uppercase tracking-widest">
                        </div>
                        <div class="space-y-4">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]  px-4">Intelligence Blueprint Link</label>
                            <input type="url" name="reference_link" value="{{ $suara->reference_link }}"
                                class="w-full px-10 py-6 bg-slate-50 border-2 border-slate-100 rounded-[32px] font-black text-[15px]  text-slate-900 focus:border-accent focus:bg-white outline-none transition-all shadow-inner">
                        </div>
                    </div>
                    
                    <div class="pt-10 flex justify-end gap-6">
                        <button type="button" @click="isEditing = false" class="px-10 py-5 bg-slate-100 text-slate-500 font-black text-[11px] uppercase tracking-[0.2em] rounded-[28px] hover:bg-slate-200 transition-all ">Discard Changes</button>
                        <button type="submit" class="px-14 py-6 bg-accent text-white font-black text-[12px] uppercase tracking-[0.3em] rounded-[32px] shadow-2xl shadow-accent/40 hover:scale-105 active:scale-95 transition-all flex items-center gap-6  group">
                            <i data-lucide="send" class="w-6 h-6 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                            UPDATE MISSION BRIEFING
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
