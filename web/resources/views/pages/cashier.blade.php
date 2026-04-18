<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier Order Monitor - Laravel Ready</title>
    

    
    <!-- ALPINE.JS (Opsional, untuk logika Modal di HTML murni) -->


 @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        [x-cloak] { display: none !important; }
    </style>


</head>
<body class="bg-slate-50 text-slate-900 antialiased" x-data="{ 
    search: '',
    selectedOrder: null,
    orders: [
        { id: 'ORD-001', name: 'Ahmad Subarjo', table: 'Table 04', items: [{q:2, n:'Nasi Goreng'}, {q:2, n:'Es Teh'}], total: 90000, time: '12:45' },
        { id: 'ORD-002', name: 'Siti Sarah', table: 'Takeaway', items: [{q:1, n:'Ayam Bakar'}, {q:1, n:'Jus Alpukat'}], total: 65000, time: '12:50' },
        { id: 'ORD-003', name: 'Budi Hartono', table: 'Table 12', items: [{q:3, n:'Sate Ayam'}, {q:3, n:'Lontong'}, {q:1, n:'Es Jeruk'}], total: 105000, time: '12:55' },
        { id: 'ORD-005', name: 'Keluarga Bpk. Anton', table: 'Table 20', items: [{q:2, n:'Ikan Gurame'}, {q:3, n:'Cah Kangkung'}, {q:2, n:'Nasi Bakul'}, {q:4, n:'Es Teller'}], total: 511000, time: '13:10' }
    ],
    get filteredOrders() {
        if (this.search === '') return this.orders;
        return this.orders.filter(i => i.name.toLowerCase().includes(this.search.toLowerCase()) || i.id.toLowerCase().includes(this.search.toLowerCase()));
    },
    formatIDR(val) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(val);
    }
}">

    <div class="min-h-screen flex flex-col">
        
        <!-- 1. TOP NAVIGATION -->
        <nav class="sticky top-0 z-40 bg-white border-b border-slate-200">
            <div class="max-w-[1600px] mx-auto px-6 h-20 flex items-center justify-between gap-8">
                
                <!-- Logo & Branding -->
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="8" r="6"/><path d="M18.09 10.37A6 6 0 1 1 10.34 18.06"/><path d="M7 6h1v4"/><path d="m16.71 13.88.7.71-2.82 2.82"/></svg>
                    </div>
                    <div class="hidden sm:block">
                        <h1 class="text-lg font-black text-slate-800 tracking-tight leading-none uppercase">Monitor Pesanan</h1>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-[0.2em] mt-0.5">Console Kasir v1.0</p>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 max-w-xl relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <input 
                        type="text" 
                        x-model="search"
                        placeholder="Cari Nama Pelanggan atau ID Pesanan..." 
                        class="w-full pl-12 pr-4 py-3 bg-slate-100 border-transparent rounded-2xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/10 transition-all outline-none"
                    >
                </div>

                <!-- Time & User (Static for Laravel) -->
                <div class="flex items-center space-x-6">
                    <div class="hidden md:flex flex-col items-end">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Jam Server</span>
                        <span class="text-sm font-mono font-black text-slate-700">12:57:49</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 border border-slate-200">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                </div>
            </div>
        </nav>

        <!-- 2. MAIN CONTENT -->
        <main class="max-w-[1600px] mx-auto px-6 py-8 flex-1 w-full">
            
            <!-- Summary Bar -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm flex items-center space-x-4">
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none mb-1">Total Antrean</p>
                        <h3 class="text-2xl font-black text-slate-800 leading-none" x-text="orders.length + ' Pesanan'"></h3>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm flex items-center space-x-4">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none mb-1">Sudah Dibayar</p>
                        <h3 class="text-2xl font-black text-slate-800 leading-none">42 Selesai</h3>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm flex items-center space-x-4">
                    <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none mb-1">Avg. Processing</p>
                        <h3 class="text-2xl font-black text-slate-800 leading-none">~12 Menit</h3>
                    </div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="bg-white rounded-[32px] border border-slate-200 shadow-xl shadow-slate-200/50 overflow-hidden">
                <div class="p-8 border-b border-slate-100 flex justify-between items-center flex-wrap gap-4">
                    <div>
                        <h2 class="text-xl font-black text-slate-800 tracking-tight leading-none mb-1 uppercase text-left">Daftar Antrean Kasir</h2>
                        <p class="text-xs text-slate-400 font-medium text-left">Klik tombol bayar untuk memproses transaksi pelanggan.</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button class="px-4 py-2 text-xs font-bold text-slate-500 bg-slate-50 rounded-xl hover:bg-slate-100 border border-slate-200 uppercase tracking-widest">Laporan</button>
                        <button class="px-4 py-2 text-xs font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-100 uppercase tracking-widest">Refresh</button>
                    </div>
                </div>

                <div class="overflow-x-auto text-left">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                <th class="py-5 pl-8">Pelanggan</th>
                                <th class="py-5 px-4">Meja</th>
                                <th class="py-5 px-4 hidden sm:table-cell">Waktu</th>
                                <th class="py-5 px-4 hidden lg:table-cell">Detail Pesanan</th>
                                <th class="py-5 px-4">Tagihan</th>
                                <th class="py-5 pr-8 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <template x-for="order in filteredOrders" :key="order.id">
                                <tr class="group hover:bg-slate-50/50 transition-colors">
                                    <td class="py-5 pl-8 text-left">
                                        <div>
                                            <p class="text-sm font-black text-slate-800 uppercase tracking-tight" x-text="order.name"></p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest" x-text="order.id"></p>
                                        </div>
                                    </td>
                                    <td class="py-5 px-4">
                                        <div :class="order.table === 'Takeaway' ? 'bg-amber-50 text-amber-600 border-amber-100' : 'bg-indigo-50 text-indigo-600 border-indigo-100'" class="inline-flex items-center px-3 py-1.5 rounded-xl border font-bold text-xs tracking-tighter">
                                            <template x-if="order.table === 'Takeaway'">
                                                <div class="flex items-center">
                                                    <svg class="mr-1.5" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                                    <span>TAKEAWAY</span>
                                                </div>
                                            </template>
                                            <template x-if="order.table !== 'Takeaway'">
                                                <div class="flex items-center">
                                                    <span class="mr-1.5 text-[10px] opacity-60">TABLE</span>
                                                    <span x-text="order.table.split(' ')[1]"></span>
                                                </div>
                                            </template>
                                        </div>
                                    </td>
                                    <td class="py-5 px-4 hidden sm:table-cell text-left">
                                        <div class="flex items-center text-xs font-bold text-slate-500 bg-slate-100/50 w-fit px-2 py-1 rounded-md">
                                            <svg class="mr-1.5" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                            <span x-text="order.time"></span>
                                        </div>
                                    </td>
                                    <td class="py-5 px-4 hidden lg:table-cell text-left">
                                        <div class="max-h-24 overflow-y-auto custom-scrollbar pr-2 space-y-1.5 max-w-[280px]">
                                            <template x-for="(item, idx) in order.items" :key="idx">
                                                <div class="flex justify-between items-center text-[10px] bg-white border border-slate-100 px-2.5 py-1 rounded-lg text-slate-600 shadow-sm border-l-2 border-l-indigo-200">
                                                    <span class="truncate mr-2"><span class="font-black text-indigo-600" x-text="item.q + 'x'"></span> <span x-text="item.n"></span></span>
                                                </div>
                                            </template>
                                        </div>
                                    </td>
                                    <td class="py-5 px-4 text-left">
                                        <p class="text-sm font-black text-slate-800 tracking-tight" x-text="formatIDR(order.total)"></p>
                                    </td>
                                    <td class="py-5 pr-8 text-right">
                                        <button @click="selectedOrder = order" class="inline-flex items-center px-6 py-2.5 bg-indigo-600 text-white text-xs font-black uppercase tracking-widest rounded-xl shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all active:scale-95 group/btn">
                                            <span>Bayar</span>
                                            <svg class="ml-2 group-hover:translate-x-1 transition-transform" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <!-- 3. PAYMENT MODAL -->
        <div x-show="selectedOrder" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-transition.opacity>
            <div @click.away="selectedOrder = null" class="bg-white rounded-3xl w-full max-w-md overflow-hidden shadow-2xl" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center text-left">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 uppercase tracking-tight">Konfirmasi Bayar</h3>
                        <p class="text-sm text-slate-500" x-text="selectedOrder?.id + ' • ' + selectedOrder?.name"></p>
                    </div>
                    <button @click="selectedOrder = null" class="p-2 hover:bg-slate-100 rounded-full text-slate-400">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </button>
                </div>

                <div class="p-6 space-y-6 text-left">
                    <div class="bg-slate-50 p-6 rounded-2xl flex flex-col items-center justify-center border border-slate-100 italic">
                        <span class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1 font-sans not-italic">Total Tagihan</span>
                        <span class="text-4xl font-black text-indigo-600" x-text="formatIDR(selectedOrder?.total || 0)"></span>
                    </div>

                    <div class="space-y-3">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Metode Pembayaran</label>
                        <div class="grid grid-cols-3 gap-3">
                            <button class="flex flex-col items-center justify-center p-4 rounded-2xl border bg-emerald-50 border-emerald-100 text-emerald-600 ring-2 ring-indigo-500 ring-offset-2">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" class="mb-2"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
                                <span class="text-[10px] font-bold uppercase">Tunai</span>
                            </button>
                            <button class="flex flex-col items-center justify-center p-4 rounded-2xl border bg-white border-slate-200 text-slate-400">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" class="mb-2"><rect width="20" height="14" x="2" y="5" rx="2"/><path d="M2 10h20"/></svg>
                                <span class="text-[10px] font-bold uppercase">Debit</span>
                            </button>
                            <button class="flex flex-col items-center justify-center p-4 rounded-2xl border bg-white border-slate-200 text-slate-400">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" class="mb-2"><circle cx="8" cy="8" r="6"/><path d="M18.09 10.37A6 6 0 1 1 10.34 18.06"/></svg>
                                <span class="text-[10px] font-bold uppercase">QRIS</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-slate-50 flex gap-4">
                    <button @click="selectedOrder = null" class="flex-1 py-4 text-sm font-bold text-slate-400 uppercase tracking-widest">Batal</button>
                    <button @click="selectedOrder = null" class="flex-[2] bg-indigo-600 text-white rounded-2xl py-4 text-sm font-bold shadow-lg shadow-indigo-100 uppercase tracking-widest">Konfirmasi & Cetak</button>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
