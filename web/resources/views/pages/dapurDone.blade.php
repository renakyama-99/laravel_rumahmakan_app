@if(Session::get('userId') == "" && Session::get('email') == "")
<script>window.location.href="{{route('home')}}";</script>
@endif
@extends('pages.dapur')
@section('picker')
                    <!-- Date Range Picker -->
                    <div class="md:flex items-center bg-white border border-slate-200 rounded-xl px-3 py-2 gap-2 shadow-sm hover:border-indigo-300 transition-colors cursor-pointer" id="date-range-picker">
                        <i class="fa-solid fa-calendar-days text-indigo-600 text-sm"></i>
                        <input type="text" 
                        x-data="{ 
                                fp: null,
                                init() {
                                    const today = new Date();
                                    const sevenDaysAgo = new Date(today);
                                    sevenDaysAgo.setDate(today.getDate() - 7);
                                    
                                    this.fp = flatpickr(this.$el, { 
                                        mode: 'range', 
                                        dateFormat: 'Y-m-d',
                                        defaultDate: [
                                            sevenDaysAgo.toISOString().split('T')[0],
                                            today.toISOString().split('T')[0]
                                        ]
                                    });
                                }
                            }" 
                        id="date-input" placeholder="Pilih Tanggal" class="bg-transparent border-none focus:ring-0 text-xs font-semibold text-slate-600 w-40 cursor-pointer outline-none" readonly>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                    </div>

                    <button onclick="terapkanTgl()" class="md:block bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-xs font-bold transition-colors shadow-sm">
                        Terapkan
                    </button>
@endsection

@section('footer')
<script>
let token = document.querySelector('meta[name="csrf-token"]').content;
let data_pesanan = [];
const getDoneData = () => {
    return new Promise((resolve,reject) => {
        const xml = new XMLHttpRequest();
        const link = "{{route('actionDapur')}}";
        const page = "";
        const date = document.getElementById('date-input').value;
        const data = "action=loadDoneData&hal="+page+"&date="+date;
        xml.open('POST', link, true);
        xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xml.setRequestHeader('X-CSRF-TOKEN', token);
        xml.timeout = 15000; // 15s timeout
        xml.onreadystatechange = function() {
             if (xml.readyState === 4) {
                 if (xml.status === 200) {
                    try {
                        const res = xml.responseText;
                        const jsn = JSON.parse(res);
                        data_pesanan = jsn || [];
                        
                        resolve(jsn);
                    } catch (e) {
                        reject(new Error('JSON Parse Error'));
                    }
                } else {
                    reject(new Error(`HTTP ${xml.status}`));
                }
             }
         }
        xml.ontimeout = () => reject(new Error('Timeout 15s'));
        xml.onerror = () => reject(new Error('Network Error'));
        xml.send(data);
    })
}

const renderTabel = () => {
    const container = document.getElementById('orders-container');
    if(data_pesanan.loadData.length < 1){
        container.innerHTML = `<div class="py-20 text-center">
                                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-200 inline-block">
                                        <i class="fa-solid fa-utensils text-4xl text-slate-200 mb-4 block"></i>
                                        <p class="text-slate-500 font-medium">Tidak ada pesanan ditemukan</p>
                                    </div>
                                </div>
                            `;
                            return;
    }
    container.innerHTML  = `
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">No. Penjualan</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Pelanggan</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Detail Pesanan</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Waktu</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                        
                        </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">  
                        <button onclick="window.changePage(${data_pesanan.halAktif - 1})"
                                ${data_pesanan.halAktif === 1 ? 'disabled' : ''}
                                class="size-8 flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                            >
                                <i class="fa-solid fa-chevron-left text-[10px]"></i>
                        </button>
                        <div class="flex items-center gap-1" id="item_pagination">

                        </div>
                </div>
            </div>
        </div>
    `;
}
const terapkanTgl = () => {
   run(); 
}
const run = async() => {
    try{
        await getDoneData();
        renderTabel();
    }catch(e){
        console.log(e);
    }
}

run();
</script>

@endsection