@if(Session::get('userId') == "" && Session::get('email') == "")
<script>window.location.href="{{route('dashboard')}}";</script>
@endif
@extends('pages.cashier')
@section('content')
<main class="max-w-[1600px] mx-auto w-full px-6 py-8 overflow-hidden flex flex-col md:flex-row gap-8 flex-1">
<!-- Left: List Items (Original + Extra Catalog + Added) -->
                <div class="flex-[1.5] space-y-6 overflow-y-auto custom-scrollbar pr-2 pb-10">
                    
                    <!-- Section: Orderan Utama -->
                    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm" id="listOrder">
                        <div class="p-5 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center">
                                <svg class="mr-2 text-indigo-500" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                List Orderan Utama
                            </h3>
                            <span class="text-[10px] font-bold text-slate-400 uppercase" id="orderItemCount"></span>
                        </div>
                        <div class="divide-y divide-slate-50" id="mainItemList">
                    
                        </div>
                    </div>

                    <!-- Section: Katalog Item Tambahan -->
                    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm border-dashed border-2">
                        <div class="p-5 bg-amber-50/30 border-b border-slate-100 flex items-center justify-between">
                            <h3 class="text-xs font-black text-amber-600 uppercase tracking-widest flex items-center">
                                <svg class="mr-2" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v8"/><path d="M8 12h8"/></svg>
                                Katalog Item Tambahan
                            </h3>
                            <span class="text-[9px] font-bold text-amber-500 uppercase tracking-widest bg-amber-100 px-2 py-1 rounded-md">Ketuk Item untuk Menambah</span>
                        </div>
                        
                        <!-- Extra Item Catalog Grid -->
                        <div class="p-5 bg-slate-50/30 border-b border-slate-100 grid grid-cols-2 sm:grid-cols-5 gap-4" id="extraCatalog">

                        </div>

                        <!-- Panel Added Items -->
                        <div class="p-5 bg-white">
                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Item Tambahan Terpilih</h4>
                            <div class="divide-y divide-slate-50 min-h-[100px]" id="extraItemList">
                                <div class="p-10 text-center text-slate-300 italic text-sm" id="emptyExtraMsg">
                                    Belum ada item tambahan terpilih. Ketuk salah satu item di katalog.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Summary & Payment -->
                <div class="flex-1 space-y-6">
                    <!-- Billing Summary -->
                    <div class="bg-indigo-600 rounded-[32px] p-8 text-white shadow-2xl shadow-indigo-200 text-left">
                        <h3 class="text-[10px] font-black text-indigo-200 uppercase tracking-widest mb-6 text-left">Ringkasan Pembayaran</h3>
                        
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between items-center text-sm">
                                <span class="opacity-70 font-medium">Subtotal Orderan</span>
                                <span class="font-black" id="subtotalOrder">Rp 90.000</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="opacity-70 font-medium">Subtotal Tambahan</span>
                                <span class="font-black text-amber-300" id="subtotalExtra">Rp 0</span>
                            </div>
                            <div class="h-px bg-white/10 my-4"></div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black text-indigo-300 uppercase tracking-widest mb-1">Total Bayar</span>
                                <span class="text-4xl font-black tracking-tighter" id="grandTotal">Rp 90.000</span>
                            </div>
                        </div>

                        <!-- Action -->
                        <div class="space-y-3">
                            <label class="text-[10px] font-bold text-white/60 uppercase tracking-widest">Metode Pembayaran</label>
                            <div class="grid grid-cols-3 gap-2">
                                <button class="p-3 bg-white/20 border border-white/20 rounded-2xl transition-all flex flex-col items-center">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" class="mb-1.5"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
                                    <span class="text-[9px] font-black uppercase">Tunai</span>
                                </button>
                                <button class="p-3 bg-white/10 opacity-50 border border-white/20 rounded-2xl flex flex-col items-center">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" class="mb-1.5"><rect width="20" height="14" x="2" y="5" rx="2"/><path d="M2 10h20"/></svg>
                                    <span class="text-[9px] font-black uppercase">Debit</span>
                                </button>
                                <button class="p-3 bg-white/10 opacity-50 border border-white/20 rounded-2xl flex flex-col items-center">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" class="mb-1.5"><circle cx="8" cy="8" r="6"/><path d="M18.09 10.37A6 6 0 1 1 10.34 18.06"/></svg>
                                    <span class="text-[9px] font-black uppercase">QRIS</span>
                                </button>
                            </div>
                        </div>

                        <button class="w-full mt-8 bg-white text-indigo-600 py-5 rounded-2xl font-black uppercase text-sm tracking-widest shadow-xl hover:scale-[1.02] active:scale-95 transition-all">Simpan Transaksi</button>
                    </div>
                </div>
</main>                
@endsection

@section('script')
    <script type="text/javascript">
        let token           = document.querySelector('meta[name="csrf-token"]').content;
        let itemTambahan    = [];
        let dataPesanan     = [];
        
        const getOrder = () => {
            return new Promise((resolve,reject) => {
                const xml               = new XMLHttpRequest();
                const link              = "{{route('actKasir')}}";
                const nomorPenjualan    = "{{$noPenjualan}}";
                const data              = "action=getDataBayar&kodeJual="+nomorPenjualan;
                xml.open('POST',link,true);
                xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xml.setRequestHeader('X-CSRF-TOKEN', token);
                xml.timeout = 15000; // 15s timeout
                xml.onreadystatechange = function() {
                         if(xml.readyState === 4){
                             if(xml.status === 200){
                                    try {
                                        const res = xml.responseText;
                                        const json = JSON.parse(res);
                                        dataPesanan = json || [];
                                        
                                        resolve(json);
                                    } catch (error) {
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

        const getTambahan = () => {
                return new Promise((resolve,reject) => {
                const xml               = new XMLHttpRequest();
                const link              = "{{route('actKasir')}}";
                const nomorPenjualan    = "{{$noPenjualan}}";
                const data              = "action=getItemTambahan";
                xml.open('POST',link,true);
                xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xml.setRequestHeader('X-CSRF-TOKEN', token);
                xml.timeout = 15000; // 15s timeout
                xml.onreadystatechange = function() {
                         if(xml.readyState === 4){
                             if(xml.status === 200){
                                    try {
                                        const res = xml.responseText;
                                        const json = JSON.parse(res);
                                        itemTambahan = json || [];
                                        resolve(json);
                                        
                                    } catch (error) {
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
        const renderMenu = () => {
            const mainList = document.getElementById('mainItemList');
            if(dataPesanan.length < 1){
                mainList.innerHTML = "";
            }else if(dataPesanan.length > 0){
                countOrder = document.getElementById('orderItemCount');
                countOrder.innerHTML = `${dataPesanan.length} Item`;
                mainList.innerHTML   = dataPesanan.map((item) => {
                    return `
                        <div class="p-4 flex items-center justify-between text-left">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-[10px] font-black">${item.qty} x</div>
                                <div class="font-bold text-slate-700 text-sm">${item.namaItem}</div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-black text-slate-800">${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(item.total)}</p>
                                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(item.hargaJual)}</p>
                            </div>
                        </div>
                    `;
                }).join('');
            }
        }

    const renderItemTambahan = () => {
        const catalog = document.getElementById('extraCatalog');
            if(itemTambahan.length < 1){
                catalog.innerHTML = '<p class="items-center text-slate-500 font-medium">Tidak ada item Tambahan</p>';
            }else if(itemTambahan.length > 0){
                catalog.innerHTML = itemTambahan.map((item) => {
                    return `
                            <button onclick="addFromCatalog('${item.kodeTemp}','${item.kodeItem}','${item.namaItem}','{{$noPenjualan}}','{{$kodeMeja}}','{{$user}}',${item.hargaJual},${item.diskon},'${item.type}')" class="group flex flex-col items-center p-3 bg-white border border-slate-100 rounded-2xl hover:border-amber-300 hover:shadow-lg hover:shadow-amber-100 transition-all">
                                <div class="w-full aspect-square rounded-xl overflow-hidden mb-3">
                                    <img src="{{asset('folderUser')}}/${item.locationFile}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                </div>
                                <p class="text-[10px] font-black text-slate-700 uppercase leading-tight text-center">${item.namaItem}</p>
                                <p class="text-[10px] font-bold py-0.5 bg-slate-50 border border-slate-100 rounded text-slate-400 uppercase tracking-tighter">stok = ${item.stok}</p>
                                <p class="text-[9px] font-bold text-amber-600 mt-1">${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(item.hargaJual)}</p>
                            </button>
                    `;
                }).join('');
            }
    }

    const addFromCatalog = (kdTemp,kdItem,nItem,noJual,kdMeja,user,hrgJual,diskon,type) => {
            const xml               = new XMLHttpRequest();
            const link              = "{{route('actKasir')}}";
            const data              = `action=tambahItem&ktemp=${kdTemp}&kItem=${kdItem}&namaItem=${nItem}&noJual=${noJual}&kMeja=${kdMeja}&user=${user}&hJual=${hrgJual}&diskon=${diskon}&type=${type}`;
            xml.open('POST',link,true);
            xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xml.setRequestHeader('X-CSRF-TOKEN', token);
            xml.timeout = 15000; // 15s timeout
              xml.onreadystatechange = function() {
                if(xml.readyState === 4 && xml.status === 200){
                    const respon = xml.responseText;
                    const json   = JSON.parse(respon);  
                   
                 }
              }
            xml.ontimeout = () => reject(new Error('Timeout 15s'));
            xml.onerror = () => reject(new Error('Network Error'));
            xml.send(data);
    }

    const getKatalogTambahan = () => {
            const xml               = new XMLHttpRequest();
            const link              = "{{route('actKasir')}}";
            const nomorPenjualan    = "{{$noPenjualan}}";
            const data              = "action=catalogTambahan&noPenjualan="+nomorPenjualan;
            xml.open('POST',link,true);
            xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xml.setRequestHeader('X-CSRF-TOKEN', token);
            xml.timeout = 15000; // 15s timeout
            xml.onreadystatechange = function() { 
                if(xml.readyState === 4 && xml.status === 200){
                    const respon = xml.responseText;
                    const jsn    = JSON.parse(respon);
                    console.log(jsn);
                 }
            }
            xml.ontimeout = () => reject(new Error('Timeout 15s'));
            xml.onerror = () => reject(new Error('Network Error'));
            xml.send(data);
    }

    const runApp = async()=> {
            try {
                await getOrder();
                renderMenu();
                await getTambahan();
                renderItemTambahan();
            }catch (error) {
                console.log(`Error function ${error}`);
            }
        }

    runApp();
    getKatalogTambahan();
    </script>
@endsection