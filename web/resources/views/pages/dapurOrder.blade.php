@if(Session::get('userId') == "" && Session::get('email') == "")
<script>window.location.href="{{route('dashboard')}}";</script>
@endif
@extends('pages.dapur')
@section('head_content')
    <div class="loading-overlay">
            <div class="floating-box">
              <div class="float-spinner"></div>
              <div class="loading-text">Sedang Memuat...</div>
            </div>
    </div>
@endsection
@section('footer')
<script src="{{ asset('assets/js/sweetalert2.js') }}"></script>
 <script>
      const loadingStop = () => {
        document.querySelector('.loading-overlay').style.display='none';
      }
      const loadingStart = () => {
        document.querySelector('.loading-overlay').style.display='';
      }
      loadingStop();
        let token = document.querySelector('meta[name="csrf-token"]').content;
         let data_pesanan = [];
         const getData = () => {
            return new Promise((resolve,reject) => {
            const xml = new XMLHttpRequest();
            const link = "{{route('actionDapur')}}";
            const data = "action=loadData";

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
                        console.log(jsn);
                        data_pesanan = jsn.load || [];
                       
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
            });
         }

        function getTimeAgo(dateString) {
                           const diffInMs = Date.now() - new Date(dateString).getTime();
    
                            const seconds = Math.floor(diffInMs / 1000);
                            const minutes = Math.floor(seconds / 60);
                            const hours = Math.floor(minutes / 60);
                            const days = Math.floor(hours / 24);
                            const weeks = Math.floor(days / 7);
                            
                            if (seconds < 60) return `${seconds}s yang lalu`;
                            if (minutes < 60) return `${minutes}m yang lalu`;
                            if (hours < 24) return `${hours}j yang lalu`;
                            if (days < 7) return `${days}h yang lalu`;
                            return `${weeks}mg yang lalu`;
         }
         
         function renderPesanan(){
            if(data_pesanan.length < 1){
                console.log('No Order for Load');
                const container = document.getElementById('orders-grid');
                container.innerHTML = "";
            }else if(data_pesanan.length > 0){
                const container = document.getElementById('orders-grid');
                container.innerHTML = data_pesanan.map(item => {
                    return `
                     <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col h-full hover:shadow-md transition-shadow">
                                <div class="p-5 border-b border-slate-100 flex justify-between items-start">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded uppercase tracking-wider">${item.no_penjualan}</span>
                                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full border flex items-center gap-1 ${item.statusPesanan}">
                                                <i class="${item.kodeTemp} text-[10px]"></i>
                                                <span>${item.statusPesanan.toUpperCase()}</span>
                                            </span>
                                        </div>
                                        <h3 class="font-bold text-lg">${item.pelanggan}</h3>
                                        <div class="flex items-center gap-3 mt-1 text-xs text-slate-500 font-medium">
                                            <span class="flex items-center gap-1">
                                                <i class="fa-solid fa-utensils text-[10px]"></i>
                                                <span>${item.nomorMeja}</span>
                                            </span>
                                            <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                                            <span class="flex items-center gap-1">
                                                <i class="fa-solid fa-clock text-[10px]"></i>
                                                <span>${getTimeAgo(item.waktuPesan)}</span>
                                            </span>
                                        </div>
                                    </div>
                                    <button class="p-1 hover:bg-slate-50 rounded-lg text-slate-400">
                                        <i class="fa-solid fa-ellipsis-vertical px-1"></i>
                                    </button>
                                </div>

                                <div class="p-5 flex-1 space-y-3">
                                    ${item.loadItem.map(itemOrder => `
                                        <div class="flex justify-between items-center">
                                            <div class="flex items-center gap-3">
                                                <span class="size-6 bg-slate-100 rounded flex items-center justify-center text-xs font-bold text-slate-600">${itemOrder.qty}x</span>
                                                <span class="text-sm font-medium text-slate-700">${itemOrder.namaItem}</span>
                                            </div>
                                            <span class="text-sm text-slate-400">Rp ${itemOrder.harga.toLocaleString()}</span>
                                        </div>
                                    `).join('')}
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm font-medium text-slate-700">note : ${item.note}</span>
                                    </div>
                                </div>

                                <div class="p-5 bg-slate-50 border-t border-slate-100 space-y-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Tagihan</span>
                                        <span class="text-lg font-black text-slate-900">Rp ${item.subtotal.toLocaleString()}</span>
                                    </div>
                                    
                                    <button 
                                        onclick="updateStatus('${item.no_penjualan}')"
                                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition-colors shadow-lg shadow-indigo-100"
                                    >
                                        <span>Update Status</span>
                                        <i class="fa-solid fa-rotate"></i>
                                    </button>
                                </div>
                            </div>
                    `;
                }).join('');

     
            }
         }

        const runApp = async() => {
            try{
                await getData();
                renderPesanan();
            }catch (e) {
                console.error('❌ Load failed:', e);
            }
        }

        runApp();

        let socket;
        let reconnectCount = 0;
        let maxReconnection = 20;
        const kodeTemp  = "{{ Session::get('kodeTemp') }}";
        const userId    = "{{ Session::get('userId') }}";
        socket = new WebSocket("ws://localhost:10000/dapur?kodeTemp="+encodeURIComponent(kodeTemp)+"&userId="+encodeURIComponent(userId)+"&token="+encodeURIComponent(token));
        socket.onopen = () => {
             const stat             = document.getElementById('statConnection');
             const tx_stat          = document.getElementById('tx-stat');
             tx_stat.innerHTML      = '<p class="text-sm font-medium leading-tight">STATUS</p>';
             stat.innerHTML         = '<p class="text-xs text-emerald-600 font-semibold">Online</p>';
             console.log("TERHUBUNG ✅");
        }

        socket.onerror = (e) => {
            
            console.log("ERROR ❌", e);
        };

        socket.onclose = () => {
             const stat         = document.getElementById('statConnection');
             const tx_stat      = document.getElementById('tx-stat');
             tx_stat.innerHTML  = '<p class="text-sm font-medium leading-tight">STATUS</p>';
             stat.innerHTML     = '<p class="text-xs text-rose-600 font-semibold">Offline</p>';
             console.log("CLOSED ❌", reconnectCount);
             if(maxReconnection >= reconnectCount){
                    setTimeout(() =>{
                        reconnectCount++;
                        console.log(" Reconnect ke-" + reconnectCount + "...");
                        const newSocket     = new WebSocket("ws://localhost:10000/dapur?kodeTemp="+encodeURIComponent(kodeTemp)+"&userId="+encodeURIComponent(userId)+"&token="+encodeURIComponent(token));
                        newSocket.onopen    = socket.onopen;
                        newSocket.onerror   = socket.onerror;
                        newSocket.onclose   = socket.onclose;
                        newSocket.onmessage = socket.onmessage;
                        socket = newSocket;
                    }, 5000);
                }
                else{
                    Swal.fire({
                        icon : 'question',
                        title : 'connection',
                        text : 'gagal menghubungkan ke server, coba logout kemudian login kembali !'
                    })
                }
        }

        socket.onmessage = (e) => {
            if(e.data == "order baru masuk"){
                loadingStop();
                 runApp();
            }else if(e.data == "update sukses"){
                loadingStop();
                 runApp();
            }
        }

       const updateStatus = (nomor) => {
        if(socket.readyState === WebSocket.OPEN){
            loadingStart();
            const jsn = JSON.stringify({
                action      : "updatePesanan",
                user        : "{{Session::get('userId')}}",
                kodeTemp    : "{{Session::get('kodeTemp')}}",
                noPenjualan : nomor
            });
           socket.send(jsn);
        }else if(socket.readyState !== WebSocket.OPEN){
                Swal.fire({
                    icon  : "error",
                    title : "oops",
                    text  : "Tidak rehubung ke server, tidak dapat melanjutkan proses",
                    showConfirmButton: true
             });
        }

       }

       const statConnection = () => {
        if(socket.readyState !== WebSocket.OPEN){
            const stat = document.getElementById('statConnection');
            stat.innerHTML = '<p class="text-xs text-rose-600 font-semibold">Offline</p>';
         }
       }
    statConnection();
</script>
@endsection