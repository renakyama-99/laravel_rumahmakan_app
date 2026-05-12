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
                                <span class="font-black" id="subtotalOrder"></span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="opacity-70 font-medium">Subtotal Tambahan</span>
                                <span class="font-black text-amber-300" id="subtotalExtra"></span>
                            </div>
                            <div class="h-px bg-white/10 my-4"></div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black text-indigo-300 uppercase tracking-widest mb-1">Total Bayar</span>
                                <span class="text-4xl font-black tracking-tighter" id="grandTotal"></span>
                            </div>
                        </div>

                        <!-- Action -->
                        <div class="space-y-3">
                            <label class="text-[10px] font-bold text-white/60 uppercase tracking-widest">Metode Pembayaran</label>
                            <div class="grid grid-cols-3 gap-2" id="paymentMethodsList">
                 
                            </div>
                        </div>

                        <button onclick="saveData()" class="w-full mt-8 bg-white text-indigo-600 py-5 rounded-2xl font-black uppercase text-sm tracking-widest shadow-xl hover:scale-[1.02] active:scale-95 transition-all" id="saveTrans">Simpan Transaksi</button>
                    </div>
                </div>
</main>                
@endsection

@section('script')
    <script src="{{ asset('assets/js/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/host.js') }}"></script>
    <script type="text/javascript">
        let token           = document.querySelector('meta[name="csrf-token"]').content;
        let itemTambahan    = [];
        let dataPesanan     = [];
        
      const loadingStop = () => {
        document.querySelector('.loading-overlay').style.display='none';
      }
      const loadingStart = () => {
        document.querySelector('.loading-overlay').style.display='';
      }

      loadingStop();
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
                    if(json.msg === "update data"){
                        getKatalogTambahan();
                        refreshMenu();
                        createCard();
                    }else if(json.msg === "insert data"){
                        getKatalogTambahan();
                        refreshMenu();
                        createCard();
                    }
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
                    const container = document.getElementById('extraItemList');
                    container.innerHTML = jsn.map((item) => {
                        return `
                    <div class="py-3 flex items-center justify-between text-left group/row extra-item-row bg-white border-b border-slate-50 last:border-0 lowercase">
                        <div class="flex items-center space-x-3 uppercase">
                            <div class="w-10 h-10 rounded-lg overflow-hidden border border-slate-100">
                                <img src="{{asset('folderUser')}}/${item.locationFile}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex flex-col">
                                <div class="font-bold text-slate-700 text-sm truncate max-w-[120px]"></div>
                                <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl overflow-hidden font-bold text-xs w-fit mt-2">
                                    <button type="button" class="px-4 py-1.5 hover:bg-slate-200 active:bg-slate-300 transition-colors" onclick="delQty('${item.kodeTemp}','${item.kodeItem}','${item.namaItem}','{{$noPenjualan}}','${item.kodeMeja}','{{$user}}',${item.hargaJual},${item.diskon},'${item.type}')">-</button>
                                    <span class="px-2 py-1.5 min-w-[32px] text-center bg-white border-x border-slate-100">${item.qty}</span>
                                    <button type="button" 
                                        class="px-4 py-1.5 hover:bg-slate-200 active:bg-slate-300 transition-colors disabled:opacity-30 disabled:cursor-not-allowed" 
                                        onclick="addQty('${item.kodeTemp}','${item.kodeItem}','${item.namaItem}','{{$noPenjualan}}','${item.kodeMeja}','{{$user}}',${item.hargaJual},${item.diskon},'${item.type}')"
                                       >+</button>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <button type="button" onclick="removeExtra('${item.kodeTemp}', '${item.kodeItem}', '{{$noPenjualan}}', '${item.kodeMeja}','${item.qty}')" class="p-2 text-slate-200 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-all group-hover/row:opacity-100">
                               <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="3"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                               Delete
                            </button>
                        </div>
                    </div>
                        `;
                    }).join('');
                 }
            }
            xml.ontimeout = () => reject(new Error('Timeout 15s'));
            xml.onerror = () => reject(new Error('Network Error'));
            xml.send(data);
    }

    const addQty = (kTemp,kItem,nItem,nJual,kMeja,user,hJual,diskon,type) => {
            const xml               = new XMLHttpRequest();
            const link              = "{{route('actKasir')}}";
            const data              = `action=tambahItem&ktemp=${kTemp}&kItem=${kItem}&namaItem=${nItem}&noJual=${nJual}&kMeja=${kMeja}&user=${user}&hJual=${hJual}&diskon=${diskon}&type=${type}`;
            xml.open('POST',link,true);
            xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xml.setRequestHeader('X-CSRF-TOKEN', token);
            xml.timeout = 15000; // 15s timeout
              xml.onreadystatechange = function() {
                if(xml.readyState === 4 && xml.status === 200){
                    const respon = xml.responseText;
                    const json   = JSON.parse(respon);  
                    if(json.msg === "update data"){
                        getKatalogTambahan();
                        refreshMenu();
                        createCard();
                    }
                 }
              }
            xml.ontimeout = () => reject(new Error('Timeout 15s'));
            xml.onerror = () => reject(new Error('Network Error'));
            xml.send(data);
    }

    const delQty = (kTemp,kItem,nItem,nJual,kMeja,user,hJual,diskon,type) => {
            const xml               = new XMLHttpRequest();
            const link              = "{{route('actKasir')}}";
            const data              = `action=kurangiItem&ktemp=${kTemp}&kItem=${kItem}&namaItem=${nItem}&noJual=${nJual}&kMeja=${kMeja}&user=${user}&hJual=${hJual}&diskon=${diskon}&type=${type}`;
            xml.open('POST',link,true);
            xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xml.setRequestHeader('X-CSRF-TOKEN', token);
            xml.timeout = 15000; // 15s timeout
              xml.onreadystatechange = function() {
                if(xml.readyState === 4 && xml.status === 200){
                    const respon = xml.responseText;
                    if(respon === "update"){
                            refreshMenu();
                            getKatalogTambahan();
                            createCard();
                    }else if(respon === "delete"){
                            refreshMenu();
                            getKatalogTambahan();
                            createCard();
                    }
                    //console.log(respon);    
                 }
              }
            xml.ontimeout = () => reject(new Error('Timeout 15s'));
            xml.onerror = () => reject(new Error('Network Error'));
            xml.send(data);
    }

    const removeExtra = (kTemp,kItem,noJual,kMeja,qty) => {
            const xml        = new XMLHttpRequest();
            const link       = "{{route('actKasir')}}";
            const data       = "action=removeItemTambahan&kodeTemp="+kTemp+"&kodeItem="+kItem+"&noJual="+noJual+"&kodeMeja="+kMeja+"&qty="+qty;
            xml.open('POST',link,true);
            xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xml.setRequestHeader('X-CSRF-TOKEN', token);
            xml.timeout = 15000; // 15s timeout
            xml.onreadystatechange = function() {
                if(xml.readyState === 4 && xml.status === 200){
                    const res = xml.responseText;
                    if(res === "delete"){
                        refreshMenu();
                        getKatalogTambahan();
                        createCard();
                    }
                }
            }
            xml.ontimeout = () => reject(new Error('Timeout 15s'));
            xml.onerror = () => reject(new Error('Network Error')); 
            xml.send(data);

    }

    const createCard = () => {
         const xml        = new XMLHttpRequest();
         const link       = "{{route('actKasir')}}";
         const noJual     = "{{$noPenjualan}}";
         const data       = "action=getChart&noJual="+noJual;
         xml.open('POST',link,true);
         xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
         xml.setRequestHeader('X-CSRF-TOKEN', token);
         xml.timeout = 15000; // 15s timeout
         xml.onreadystatechange = function() {
                if(xml.readyState === 4 && xml.status === 200){
                    const res = xml.responseText;
                    const json = JSON.parse(res);
                    const result = json.load.reduce((acc,item) => {
                        if(item.type === 'tambahan'){
                            acc.tambahan += item.subtotal;
                        }else{
                            acc.utama    += item.subtotal;
                        }
                        return acc;
                    }, {tambahan : 0, utama:0});
                    const subtotal = document.querySelector('#subtotalOrder');
                    const extra    = document.querySelector('#subtotalExtra');
                    subtotal.innerHTML = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(result.utama);
                    extra.innerHTML = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(result.tambahan);
                    document.querySelector('#grandTotal').innerHTML = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(parseInt(result.tambahan) + parseInt(result.utama));

                    subtotal.setAttribute('val' , result.utama);
                    extra.setAttribute('val' , result.tambahan);
                    if(json.statBayar === "sudah bayar"){
                        document.querySelector('#saveTrans').setAttribute('disabled', true);
                    }else if(json.statBayar === "belum bayar"){
                        document.querySelector('#saveTrans').removeAttribute('disabled');
                    }
                }
         }
         xml.ontimeout = () => reject(new Error('Timeout 15s'));
         xml.onerror = () => reject(new Error('Network Error')); 
         xml.send(data);
    }

    const refreshMenu = async () => {
        try {
            await getOrder();
            renderMenu();
        } catch (error) {
            console.log(`Error refresh menu: ${error}`);
        }
    }
    const runApp = async()=> {
            try {
                await refreshMenu();
                await getTambahan();
                renderItemTambahan();
            }catch (error) {
                console.log(`Error function ${error}`);
            }
        }

    runApp();
    getKatalogTambahan();
    createCard();

     let paymentMethods = [
            { id: 'cash', n: 'Tunai', icon: '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" class="mb-1.5"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>' },
            { id: 'debit', n: 'Debit', icon: '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" class="mb-1.5"><rect width="20" height="14" x="2" y="5" rx="2"/><path d="M2 10h20"/></svg>' },
            { id: 'qris', n: 'QRIS', icon: '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" class="mb-1.5"><circle cx="8" cy="8" r="6"/><path d="M18.09 10.37A6 6 0 1 1 10.34 18.06"/></svg>' },
            { id: 'transfer', n: 'Transfer', icon: '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" class="mb-1.5"><path d="M7 7h10v10H7z"/><path d="M16 16h4v4h-4z"/><path d="M4 4h4v4H4z"/><path d="M12 12h4v4h-4z"/></svg>' }
        ];
    let selectedPaymentMethod = 'cash';


    function renderPaymentMethods() {
            const list = document.getElementById('paymentMethodsList');
            if (!list) return;

            list.innerHTML = paymentMethods.map(pm => {
                const isActive = selectedPaymentMethod === pm.id;
                return `
                    <button onclick="selectPaymentMethod('${pm.id}')" 
                        class="p-3 rounded-2xl transition-all flex flex-col items-center border ${isActive ? 'bg-white text-indigo-600 border-white shadow-lg scale-105' : 'bg-white/10 text-white/60 border-white/10 hover:bg-white/20'}">
                        ${pm.icon}
                        <span class="text-[9px] font-black uppercase tracking-widest">${pm.n}</span>
                    </button>
                `;
            }).join('');
        }
        renderPaymentMethods();
        window.selectPaymentMethod = (id) => {
                    selectedPaymentMethod = id;
                    renderPaymentMethods();
        };


    let socket;
    let reconnectCount = 0;
    let maxReconnection = 20;
    const kodeTemp  = encodeURIComponent("{{ Session::get('kodeTemp') }}");
    const userId    = encodeURIComponent("{{ Session::get('userId') }}");
    const tokenSend = encodeURIComponent(token);
    socket = new WebSocket("ws://"+host+":10000/pembayaran?kodeTemp="+kodeTemp+"&userId="+userId+"&token="+tokenSend);

    socket.onopen = () => {
        console.log("TERHUBUNG ✅");
    }

    socket.onclose = () => {
        if(reconnectCount <= maxReconnection){
            console.log("CLOSED ❌", reconnectCount);
            setTimeout(() => {
               reconnectCount++;
               console.log("Reconnect ke-" + reconnectCount + "..."); 
               const newSocket = new WebSocket("ws://"+host+":10000/pembayaran?kodeTemp="+kodeTemp+"&userId="+userId+"&token="+tokenSend);
                newSocket.onopen = socket.onopen;
                newSocket.onerror  = socket.onerror;
                newSocket.onclose = socket.onclose;
                newSocket.onmessage =  socket.onmessage;
                socket= newSocket;
            },5000)
        }else{
            Swal.fire({
                icon : 'question',
                title : 'connection',
                text : 'gagal menghubungkan ke server, coba logout kemudian login kembali !'
            });
        }
    }

    socket.onerror = (e) => {
        console.log("ERROR ❌", e);
    };
    const saveData = () => {
     if(socket.readyState === WebSocket.OPEN){
        loadingStart();
        const total = document.querySelector('#subtotalOrder').getAttribute('val');
        const tambahan = document.querySelector('#subtotalExtra').getAttribute('val');
        const jsnData = JSON.stringify({
            action : "bayar",
            noPenjulan : "{{$noPenjualan}}",
            kodeTemp : "{{Session::get('kodeTemp')}}",
            metodBayar : selectedPaymentMethod,
            total : total,
            bayarTambahan : tambahan
        });

        socket.send(jsnData);
     }else{
        Swal.fire({
            icon : "error",
            title : "oops",
            text : "Tidak terkoneksi ke server... tidak dapat melanjutkan proses",
            showConfirmButton : true
        })
     }
    }

    socket.onmessage = (e) => {
        if(e.data === 'update berhasil'){
            window.location.href = `${window.location.origin}/cashierMonitor/nota/{{$noPenjualan}}`;
        }
    }
    </script>
@endsection