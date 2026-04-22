@if(Session::get('userId') == "" && Session::get('email') == "")
<script>window.location.href="{{route('dashboard')}}";</script>
@endif
@extends('pages.cashier')
@section('searchBar')
    <!-- Search Bar -->
    <div class="flex-1 max-w-xl relative">
        <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        <input 
                        type="text" 
                        x-model="search"
                        placeholder="Cari Nama Pelanggan atau ID Pesanan..." 
                        class="w-full pl-12 pr-4 py-3 bg-slate-100 border-transparent rounded-2xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/10 transition-all outline-none"
                        id="search" oninput="cariData()"
                        >
    </div>
@endsection
@section('content')
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
                            
                            <tr class="group hover:bg-slate-50/50 transition-colors">
                                <td class="py-5 pl-8">
                                    <div>
                                        <p class="text-sm font-black text-slate-800 uppercase tracking-tight">Ahmad Subarjo</p>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">ORD-001</p>
                                    </div>
                                </td>
                                <td class="py-5 px-4">
                                    <div class="inline-flex items-center px-3 py-1.5 rounded-xl border font-bold text-xs bg-indigo-50 text-indigo-600 border-indigo-100">
                                        <span class="mr-1.5 text-[10px] opacity-60 uppercase">Table</span>
                                        <span>04</span>
                                    </div>
                                </td>
                                <td class="py-5 px-4 hidden sm:table-cell">
                                    <div class="flex items-center text-xs font-bold text-slate-500 bg-slate-100/50 w-fit px-2 py-1 rounded-md">
                                        <svg class="mr-1.5" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        <span>12:45</span>
                                    </div>
                                </td>
                                <td class="py-5 px-4 hidden lg:table-cell text-left">
                                    <div class="max-h-24 overflow-y-auto custom-scrollbar pr-2 space-y-1.5 max-w-[280px]">
                                       
                                        <div class="flex justify-between items-center text-[10px] bg-white border border-slate-100 px-2.5 py-1 rounded-lg text-slate-600 shadow-sm border-l-2 border-l-indigo-200">
                                            <span class="truncate mr-2"><span class="font-black text-indigo-600">2x</span> Nasi Goreng Spesial</span>
                                        </div>
                                        <div class="flex justify-between items-center text-[10px] bg-white border border-slate-100 px-2.5 py-1 rounded-lg text-slate-600 shadow-sm border-l-2 border-l-indigo-200">
                                            <span class="truncate mr-2"><span class="font-black text-indigo-600">2x</span> Es Teh Manis</span>
                                        </div>
                                       
                                    </div>
                                </td>
                                <td class="py-5 px-4">
                                    <p class="text-sm font-black text-slate-800 tracking-tight">Rp 90.000</p>
                                </td>
                                <td class="py-5 pr-8 text-right">
                                    <button class="pay-btn inline-flex items-center px-6 py-2.5 bg-indigo-600 text-white text-xs font-black uppercase tracking-widest rounded-xl shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all active:scale-95 group/btn" data-id="ORD-001" data-name="Ahmad Subarjo" data-total="Rp 90.000">
                                        <span>Bayar</span>
                                        <svg class="ml-2 group-hover:translate-x-1 transition-transform" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                    </button>
                                </td>
                            </tr>
                            <!-- LARAVEL END: -->

                            <!-- Mock Row 2 -->
                            <tr class="group hover:bg-slate-50/50 transition-colors">
                                <td class="py-5 pl-8">
                                    <div>
                                        <p class="text-sm font-black text-slate-800 uppercase tracking-tight">Siti Sarah</p>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">ORD-002</p>
                                    </div>
                                </td>
                                <td class="py-5 px-4">
                                    <div class="inline-flex items-center px-3 py-1.5 rounded-xl border font-bold text-xs bg-amber-50 text-amber-600 border-amber-100">
                                        <svg class="mr-1.5" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                        <span>TAKEAWAY</span>
                                    </div>
                                </td>
                                <td class="py-5 px-4 hidden sm:table-cell">
                                    <div class="flex items-center text-xs font-bold text-slate-500 bg-slate-100/50 w-fit px-2 py-1 rounded-md">
                                        <svg class="mr-1.5" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        <span>12:50</span>
                                    </div>
                                </td>
                                <td class="py-5 px-4 hidden lg:table-cell text-left">
                                    <div class="max-h-24 overflow-y-auto custom-scrollbar pr-2 space-y-1.5 max-w-[280px]">
                                        <div class="flex justify-between items-center text-[10px] bg-white border border-slate-100 px-2.5 py-1 rounded-lg text-slate-600 shadow-sm border-l-2 border-l-indigo-200">
                                            <span class="truncate mr-2"><span class="font-black text-indigo-600">1x</span> Ayam Bakar Madu</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-5 px-4">
                                    <p class="text-sm font-black text-slate-800 tracking-tight">Rp 65.000</p>
                                </td>
                                <td class="py-5 pr-8 text-right">
                                    <button class="pay-btn inline-flex items-center px-6 py-2.5 bg-indigo-600 text-white text-xs font-black uppercase tracking-widest rounded-xl shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all active:scale-95 group/btn" data-id="ORD-002" data-name="Siti Sarah" data-total="Rp 65.000">
                                        <span>Bayar</span>
                                        <svg class="ml-2 group-hover:translate-x-1 transition-transform" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
@endsection

@section('script')
<script type="text/javascript">
let token       = document.querySelector('meta[name="csrf-token"]').content;
let dataPesanan = [];

const getData = () => {
    return new Promise((resolve,reject) => {
        const xml = new XMLHttpRequest();
        const link = "{{route('actKasir')}}";
        const cari = document.getElementById('search').value;
        const data = "action=getData&search="+cari;
        xml.open('POST', link,true);
        xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xml.setRequestHeader('X-CSRF-TOKEN', token);
        xml.timeout = 15000; // 15s timeout
        xml.onreadystatechange = function() {
            if(xml.readyState === 4){
                if(xml.status === 200){
                    try{
                        const res = xml.responseText;
                        const jsn = JSON.parse(res);
                        dataPesanan = jsn || [];
                        resolve(jsn);
                    }catch(e){
                        reject (new Error('JSON parse error'));
                    }
                }else{
                    reject(new Error(`HTTP ${xml.status}`));
                }
            }
         }
        xml.ontimeout = () => reject(new Error('Timeout 15s'));
        xml.onerror = () => reject(new Error('Network Error'));
        xml.send(data);
    })
}

const cariData = () => {
    run();
}
const run = async() =>{
    try{
        get = await  getData();
    }catch(e){
        console.log(`Error function ${e}`);
    }
    
}

run();

</script>
@endsection