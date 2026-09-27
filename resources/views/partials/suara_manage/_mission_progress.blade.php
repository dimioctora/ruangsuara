<!-- ISSUE TIMELINE PHASE (WIDE HORIZONTAL) -->
<div class="bg-white p-10 rounded-[48px] border border-slate-100 card-shadow relative overflow-hidden group">
    <div class="absolute top-0 right-0 w-80 h-80 bg-slate-50 rounded-full -mr-40 -mt-40 transition-transform group-hover:scale-110"></div>
    
    <div class="relative z-10">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]  mb-1">Issue Timeline Phase</h4>
                <h2 class="text-4xl font-outfit font-black text-slate-900 uppercase  tracking-tighter">Strategic Mission Progress</h2>
            </div>
            <div class="flex items-center gap-4">
                @if(auth()->id() == $suara->user_id)
                    <button @click="isPhaseEditing = !isPhaseEditing" 
                        class="px-8 py-3 rounded-2xl border-2 border-slate-100 text-slate-400 text-[10px] font-black uppercase tracking-widest  hover:border-accent hover:text-accent transition-all shadow-sm active:scale-95 flex items-center gap-3 bg-white group"
                        :class="isPhaseEditing ? 'border-accent text-accent shadow-lg shadow-accent/10' : ''">
                        <i data-lucide="settings-2" class="w-4 h-4" :class="isPhaseEditing ? 'rotate-90 text-accent' : ''"></i>
                        <span x-text="isPhaseEditing ? 'EXIT PHASE SELECTOR' : 'MODIFY MISSION PHASE'"></span>
                    </button>
                @endif
                <div class="px-6 py-3 rounded-2xl bg-accent text-white text-[10px] font-black uppercase tracking-[0.2em]  shadow-xl shadow-accent/20">Operation Phase Active</div>
            </div>
        </div>

        @php
            $stages = [
                1 => ['name' => 'Issue', 'icon' => 'alert-circle'],
                2 => ['name' => 'Aspiration', 'icon' => 'megaphone'],
                3 => ['name' => 'Update', 'icon' => 'refresh-cw'],
                4 => ['name' => 'Decision', 'icon' => 'scale'],
                5 => ['name' => 'Action Taken', 'icon' => 'zap'],
            ];
            $outcomes = [
                6 => ['name' => 'Mission Failed', 'icon' => 'x-circle', 'color' => 'heat', 'label' => 'FAILED'],
            ];
            $cStage = $suara->current_stage ?? 1;
            
            // Progress bar calculation (normalized to 100%)
            if ($cStage >= 5) {
                $progressPercent = 100;
            } else {
                $progressPercent = ($cStage - 1) * 25;
            }
        @endphp

        <div class="relative mt-12 mb-12 px-10">
            <!-- Progress Line Base -->
            <div class="absolute top-1/2 left-10 right-10 h-1.5 bg-slate-50 -translate-y-1/2 rounded-full overflow-hidden">
                <div class="h-full bg-accent transition-all duration-1000 shadow-[0_0_15px_rgba(37,99,235,0.3)]" style="width: {{ $progressPercent }}%"></div>
            </div>
            
            <!-- Tactical Markers -->
            <div class="relative flex justify-between items-center w-full">
                @foreach($stages as $num => $s)
                    <div class="flex flex-col items-center gap-6 group/step transition-all duration-500 {{ $num > $cStage ? 'opacity-30' : ($num == $cStage ? 'scale-110' : '') }} relative"
                         :class="isPhaseEditing ? 'cursor-pointer' : 'cursor-default'"
                         @click="if(isPhaseEditing) { if(confirm('Ubah tahap misi ke {{ $s['name'] }}?')) { $el.querySelector('form').submit(); } }">
                        
                        <!-- Phase Edit Indicator -->
                        @if(auth()->id() == $suara->user_id)
                            <div x-show="isPhaseEditing" x-cloak class="absolute -top-10 left-1/2 -translate-x-1/2 px-3 py-1 bg-accent text-white text-[8px] font-black uppercase tracking-widest  rounded-lg shadow-xl animate-bounce">
                                Activate
                            </div>
                        @endif
                        
                        <!-- Node -->
                        <div class="w-18 h-18 rounded-[28px] flex items-center justify-center z-10 transition-all duration-500 shadow-2xl relative
                            {{ ($num < $cStage) ? 'bg-success text-white' : ($num == $cStage ? 'bg-accent text-white ring-8 ring-accent/10 rotate-3' : 'bg-white border-2 border-slate-100 text-slate-300 group-hover/step:border-accent group-hover/step:text-accent') }}"
                            :class="isPhaseEditing && {{ $num }} != {{ $cStage }} ? 'ring-4 ring-accent/30 animate-pulse' : ''">
                            <i data-lucide="{{ ($num < $cStage) ? 'check' : $s['icon'] }}" class="w-8 h-8"></i>
                            @if($num == $cStage)
                                <div class="absolute -top-1 -right-1 w-4 h-4 bg-accent rounded-full border-2 border-white animate-ping"></div>
                            @endif
                        </div>

                        <!-- Label (Relative for better layout integrity) -->
                        <div class="text-center mt-6">
                            <p class="text-[11px] font-black uppercase tracking-widest leading-none {{ $num == $cStage ? 'text-accent ' : 'text-slate-400' }}">{{ $s['name'] }}</p>
                        </div>
                        
                        <form id="stage-input-{{ $num }}" action="/suara-manage/{{ $suara->id }}/update-stage" method="POST" class="hidden">
                            @csrf
                            <input type="hidden" name="stage" value="{{ $num }}">
                        </form>
                    </div>
                @endforeach

                <!-- FINAL OUTCOME BRANCH (STAGES 5 & 6) -->
                <div class="relative flex items-center justify-center">
                    <div class="flex items-center gap-6">
                        @foreach($outcomes as $num => $o)
                            @php
                                $isSelected = ($cStage == $num);
                                $isHidden = ($cStage >= 5 && $cStage != $num);
                            @endphp

                            <div x-show="isPhaseEditing || {{ $isSelected ? 'true' : 'false' }}" 
                                class="flex flex-col items-center gap-4 group/outcome transition-all duration-700 {{ $isHidden ? 'hidden' : '' }} {{ $isSelected ? 'scale-110' : ($cStage < 5 ? 'opacity-30 scale-90' : 'opacity-0 scale-0') }}"
                                :class="isPhaseEditing ? 'cursor-pointer hover:scale-105' : ''"
                                @click="if(isPhaseEditing) { if(confirm('Tandai misi sebagai {{ $o['label'] }}?')) { $el.querySelector('form').submit(); } }">
                                
                                @if(auth()->id() == $suara->user_id)
                                    <div x-show="isPhaseEditing" x-cloak class="absolute -top-10 left-1/2 -translate-x-1/2 px-2 py-1 bg-{{ $o['color'] }} text-white text-[7px] font-black uppercase rounded shadow-lg animate-bounce z-20">Set {{ $o['label'] }}</div>
                                @endif

                                <div class="w-18 h-18 rounded-[28px] flex items-center justify-center z-10 transition-all duration-500 shadow-xl relative
                                    {{ $isSelected ? 'bg-'.$o['color'].' text-white ring-8 ring-'.$o['color'].'/10' : 'bg-white border-2 border-slate-100 text-slate-300 group-hover/outcome:border-'.$o['color'] }}">
                                    <i data-lucide="{{ $o['icon'] }}" class="w-8 h-8"></i>
                                </div>

                                <div class="text-center mt-6">
                                    <p class="text-[11px] font-black uppercase tracking-widest {{ $isSelected ? 'text-'.$o['color'] : 'text-slate-400' }} leading-none">{{ $o['label'] }}</p>
                                    <p class="text-[8px] font-bold text-slate-300 uppercase  mt-1 leading-none">{{ $o['name'] }}</p>
                                </div>


                                <form action="/suara-manage/{{ $suara->id }}/update-stage" method="POST" class="hidden">
                                    @csrf
                                    <input type="hidden" name="stage" value="{{ $num }}">
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
