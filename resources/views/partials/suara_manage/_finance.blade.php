<!-- VIEW: KEUANGAN & TRANSPARANSI DANA -->
<div x-show="activeTab === 'keuangan'" x-transition:enter="transition ease-out duration-500" class="space-y-10">
    <div class="bg-white p-8 md:p-12 rounded-[40px] border border-slate-100 card-shadow">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-8 pb-6 border-b border-slate-100">
            <div class="flex items-center gap-4">
                <div class="w-3 h-10 bg-emerald-500 rounded-full"></div>
                <div>
                    <h3 class="text-xl md:text-2xl font-black font-outfit text-slate-900 tracking-tight">Transparansi Dana & Logistik</h3>
                    <p class="text-xs text-slate-400 font-medium">Laporan penerimaan dan penggunaan dana secara terbuka dan akuntabel.</p>
                </div>
            </div>
        </div>

        @if($suara->is_fundraising)
            @php
                $totalIn = $suara->financeTransactions->where('type', 'inbound')->sum('amount');
                $totalOut = $suara->financeTransactions->where('type', 'outbound')->sum('amount');
                $balance = $totalIn - $totalOut;
                $txs = $suara->financeTransactions()->latest()->get();
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="p-6 bg-emerald-50/70 border border-emerald-100 rounded-3xl">
                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1">Total Dana Terkumpul</p>
                    <p class="text-2xl font-black font-outfit text-slate-900">Rp {{ number_format($totalIn, 0, ',', '.') }}</p>
                </div>

                <div class="p-6 bg-red-50/70 border border-red-100 rounded-3xl">
                    <p class="text-[10px] font-black text-red-600 uppercase tracking-widest mb-1">Total Pengeluaran / Aksi</p>
                    <p class="text-2xl font-black font-outfit text-slate-900">Rp {{ number_format($totalOut, 0, ',', '.') }}</p>
                </div>

                <div class="p-6 bg-slate-900 text-white rounded-3xl shadow-xl">
                    <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-1">Sisa Saldo Transparan</p>
                    <p class="text-2xl font-black font-outfit text-white">Rp {{ number_format($balance, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- ADD TRANSACTION FORM -->
            <div class="p-6 md:p-8 bg-slate-50 rounded-3xl border border-slate-200/80 mb-10 space-y-4">
                <h5 class="text-xs font-black uppercase tracking-wider text-slate-700">Catat Transaksi Dana Baru</h5>
                <form action="/suara-manage/{{ $suara->id }}/add-finance" method="POST" class="grid sm:grid-cols-12 gap-4">
                    @csrf
                    <div class="sm:col-span-3">
                        <select name="type" required class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl font-bold text-xs text-slate-800 outline-none">
                            <option value="inbound">Pemasukan / Donasi (+)</option>
                            <option value="outbound">Pengeluaran / Biaya (-)</option>
                        </select>
                    </div>
                    <div class="sm:col-span-3">
                        <input type="number" name="amount" required min="1" placeholder="Nominal (Rp)" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl font-bold text-xs text-slate-800 outline-none">
                    </div>
                    <div class="sm:col-span-4">
                        <input type="text" name="description" required placeholder="Keterangan transaksi..." class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl font-medium text-xs text-slate-800 outline-none">
                    </div>
                    <div class="sm:col-span-2">
                        <button type="submit" class="w-full py-3 bg-accent text-white font-black text-xs uppercase tracking-wider rounded-2xl hover:bg-accent/90 transition-all">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>

            <!-- TRANSACTIONS LIST -->
            <div class="space-y-3">
                <h5 class="text-xs font-black uppercase tracking-wider text-slate-400 px-1">Riwayat Aliran Dana</h5>
                @if($txs->isEmpty())
                    <p class="text-xs text-slate-400 py-6 text-center">Belum ada catatan transaksi keuangan.</p>
                @else
                    <div class="divide-y divide-slate-100 bg-slate-50/50 rounded-3xl border border-slate-100 overflow-hidden">
                        @foreach($txs as $tx)
                            <div class="p-4 sm:p-5 flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl {{ $tx->type == 'inbound' ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-600' }} flex items-center justify-center shrink-0">
                                        <i data-lucide="{{ $tx->type == 'inbound' ? 'arrow-down-left' : 'arrow-up-right' }}" class="w-4 h-4"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900">{{ $tx->description }}</p>
                                        <p class="text-[10px] text-slate-400">{{ $tx->created_at ? $tx->created_at->format('d M Y, H:i') : '' }}</p>
                                    </div>
                                </div>
                                <span class="text-sm font-black font-outfit {{ $tx->type == 'inbound' ? 'text-emerald-600' : 'text-red-500' }}">
                                    {{ $tx->type == 'inbound' ? '+' : '-' }}Rp {{ number_format($tx->amount, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div class="text-center py-16 px-6 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                <div class="w-16 h-16 rounded-2xl bg-white border border-slate-100 shadow-sm flex items-center justify-center mx-auto mb-4 text-slate-400">
                    <i data-lucide="wallet" class="w-8 h-8"></i>
                </div>
                <h5 class="text-base font-bold text-slate-700 mb-1">Penggalangan Dana Tidak Diaktifkan</h5>
                <p class="text-xs text-slate-400 max-w-md mx-auto">Isu ini berjalan secara sukarela tanpa penggalangan dana publik.</p>
            </div>
        @endif
    </div>
</div>
