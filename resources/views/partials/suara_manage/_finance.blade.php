<!-- VIEW: KEUANGAN (FINANCIAL DASHBOARD) -->
<div x-show="activeTab === 'keuangan'" x-transition:enter="transition ease-out duration-500" class="space-y-12">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-2 h-10 bg-success rounded-full"></div>
            <h2 class="text-4xl font-outfit font-black text-slate-900  uppercase tracking-tighter">Movement Capital Center</h2>
        </div>
        <div class="flex items-center gap-4">
            @if($suara->is_fundraising)
                <button class="px-8 py-4 bg-success text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-success/20">+ Allocate Resources</button>
            @endif
        </div>
    </div>
    
    @if($suara->is_fundraising)
        @php
            $totalIn = $suara->financeTransactions->where('type', 'inbound')->sum('amount');
            $totalOut = $suara->financeTransactions->where('type', 'outbound')->sum('amount');
            $liquidity = $totalIn - $totalOut;
            $txs = $suara->financeTransactions()->latest()->take(5)->get();
        @endphp
        <div class="animate-fade-in space-y-12">
            <!-- Summary Command Markers -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="bg-white p-10 rounded-[48px] border border-slate-100 card-shadow text-center space-y-2 relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-2 h-full bg-success"></div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest  leading-none">Total Inbound Donasi</p>
                    <p class="text-3xl font-outfit font-black text-slate-900  tracking-tighter">Rp {{ number_format($totalIn, 0, ',', '.') }}</p>
                    <p class="text-[9px] font-bold text-success uppercase ">Verified Assets</p>
                </div>
                <div class="bg-white p-10 rounded-[48px] border border-slate-100 card-shadow text-center space-y-2 relative">
                    <div class="absolute top-0 left-0 w-2 h-full bg-heat"></div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest  leading-none">Operational Usage</p>
                    <p class="text-3xl font-outfit font-black text-slate-900  tracking-tighter">Rp {{ number_format($totalOut, 0, ',', '.') }}</p>
                    <p class="text-[9px] font-bold text-heat uppercase ">Expenditure Log</p>
                </div>
                <div class="bg-slate-900 p-10 rounded-[48px] text-white text-center space-y-4 shadow-2xl shadow-primary/30 group">
                    <p class="text-[10px] font-black text-success uppercase tracking-widest  leading-none border-b border-white/10 pb-4">Net Liquidity</p>
                    <p class="text-4xl font-outfit font-black text-white  tracking-tighter">Rp {{ number_format($liquidity, 0, ',', '.') }}</p>
                    <button class="w-full py-4 bg-success text-white rounded-2xl text-[9px] font-black uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-white hover:text-slate-900 transition-all ">
                        <i data-lucide="arrow-down-right" class="w-4 h-4"></i> Withdraw Funds
                    </button>
                </div>
                <div class="bg-white p-10 rounded-[48px] border border-slate-100 card-shadow flex flex-col items-center justify-center space-y-3 group hover:bg-accent hover:text-white transition-all cursor-pointer">
                    <i data-lucide="file-text" class="w-8 h-8 text-accent group-hover:text-white transition-colors"></i>
                    <span class="text-[10px] font-black uppercase tracking-widest ">Fiscal Blueprint</span>
                </div>
            </div>

            <!-- Secondary Tactical Grid -->
            <div class="grid lg:grid-cols-3 gap-12">
                <!-- Transactions History -->
                <div class="lg:col-span-2 space-y-6">
                    <h4 class="text-[12px] font-black text-slate-900 uppercase tracking-[0.3em]  px-6">Tactical Ledger History</h4>
                    <div class="bg-white rounded-[56px] border border-slate-100 card-shadow overflow-hidden">
                         <table class="w-full text-left border-collapse">
                             <thead>
                                 <tr class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ">
                                     <th class="px-10 py-6">Transaction</th>
                                     <th class="px-10 py-6">Sector</th>
                                     <th class="px-10 py-6">Magnitude</th>
                                     <th class="px-10 py-6">Status</th>
                                 </tr>
                             </thead>
                             <tbody class="text-slate-700 font-medium text-xs divide-y divide-slate-50">
                                 @forelse($txs as $tx)
                                     <tr class="hover:bg-slate-50/50 transition-colors group">
                                         <td class="px-10 py-8  uppercase font-bold text-slate-900 relative">
                                             <div class="flex items-center gap-4">
                                                 <div class="w-8 h-8 rounded-lg {{ $tx->type == 'inbound' ? 'bg-success/10 text-success' : 'bg-heat/10 text-heat' }} flex items-center justify-center">
                                                     <i data-lucide="{{ $tx->type == 'inbound' ? 'arrow-up-right' : 'arrow-down-left' }}" class="w-4 h-4"></i>
                                                 </div>
                                                 {{ $tx->description }}
                                             </div>
                                         </td>
                                         <td class="px-10 py-8  font-bold uppercase">{{ $tx->sector ?: 'GENERAL' }}</td>
                                         <td class="px-10 py-8  font-black {{ $tx->type == 'inbound' ? 'text-success' : 'text-heat' }}">
                                             {{ $tx->type == 'inbound' ? '+' : '-' }}Rp {{ number_format($tx->amount, 0, ',', '.') }}
                                         </td>
                                         <td class="px-10 py-8">
                                             <span class="px-4 py-1.5 {{ $tx->status == 'secured' ? 'bg-success/5 text-success border-success/10' : 'bg-warning/5 text-warning border-warning/10' }} rounded-full text-[9px] font-black uppercase border ">
                                                 {{ $tx->status }}
                                             </span>
                                         </td>
                                     </tr>
                                 @empty
                                     <tr>
                                         <td colspan="4" class="px-10 py-16 text-center text-slate-400  font-black uppercase tracking-widest">No Intelligence Data Recorded</td>
                                     </tr>
                                 @endforelse
                             </tbody>
                         </table>
                    </div>
                </div>

                <!-- Resource Allocation Brief -->
                <div class="space-y-6">
                    <h4 class="text-[12px] font-black text-slate-900 uppercase tracking-[0.3em]  px-6">Tactical Allocation</h4>
                    <div class="bg-slate-900 p-10 rounded-[56px] text-white space-y-8 relative overflow-hidden group shadow-2xl shadow-primary/20 h-full">
                        <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-accent via-success to-heat"></div>
                        <div class="space-y-2">
                            <p class="text-[9px] font-black text-accent uppercase tracking-widest ">Budget Intel</p>
                            <h5 class="text-xl font-black uppercase  tracking-tighter">Current Deployment Blueprint</h5>
                        </div>
                        <div class="space-y-8">
                            @php
                                $sectors = ['LOGISTICS', 'COMMUNICATION', 'FIELD OPS', 'MEDICAL'];
                            @endphp
                            @foreach($sectors as $sec)
                                @php $sPercent = rand(10, 40); @endphp
                                <div class="space-y-3">
                                    <div class="flex justify-between text-[10px] font-black uppercase tracking-widest  leading-none">
                                        <span>{{ $sec }}</span>
                                        <span class="text-accent">{{ $sPercent }}%</span>
                                    </div>
                                    <div class="w-full h-1.5 bg-white/5 rounded-full overflow-hidden">
                                        <div class="h-full bg-accent" style="width: {{ $sPercent }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button class="w-full py-5 bg-white text-slate-900 rounded-[32px] text-[10px] font-black uppercase tracking-widest hover:bg-accent hover:text-white transition-all shadow-xl  flex items-center justify-center gap-3">
                            <i data-lucide="pie-chart" class="w-4 h-4"></i> Optimize Expenditures
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- No Fundraising View -->
        <div class="bg-slate-50 border-4 border-dashed border-slate-200 rounded-[64px] p-24 flex flex-col items-center justify-center text-center space-y-8 group hover:border-success/40 transition-all">
            <div class="w-32 h-32 bg-slate-200 rounded-[48px] flex items-center justify-center text-slate-400 group-hover:scale-110 group-hover:bg-success/10 group-hover:text-success transition-all duration-700">
                <i data-lucide="heart-off" class="w-16 h-16"></i>
            </div>
            <div>
                <h4 class="text-3xl font-outfit font-black text-slate-400 uppercase tracking-tighter ">Capital Stream Offline</h4>
                <p class="text-slate-400 font-medium  mt-2">Fundraising features are not activated for this mission. Contact command to enable fiscal support.</p>
            </div>
            <button class="px-12 py-6 bg-white border border-slate-200 rounded-[32px] text-slate-500 font-black text-[10px] uppercase tracking-widest hover:border-success hover:text-success transition-all  flex items-center gap-4 shadow-sm">
                <i data-lucide="plus" class="w-5 h-5"></i> Activate Fundraising Profile
            </button>
        </div>
    @endif

</div>
