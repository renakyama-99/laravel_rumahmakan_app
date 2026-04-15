@if(Session::get('userId') == "" && Session::get('email') == "" &&  Session::get('password') == "" && Session::get('kodeTemp') == "")
<script>window.location.href="{{ route('logout') }}"</script>
@endif
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Restoran Kita - Premium Food Ordering</title>
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
  <!-- Font Modern -->
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/index.css') }}">
  <!-- Tailwind Play CDN -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    :root {
      --orange-500: #f97316;
      --slate-50: #f8fafc;
      --slate-800: #1e293b;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--slate-50);
      margin: 0;
      -webkit-font-smoothing: antialiased;
    }

    svg {
      display: block;
      flex-shrink: 0;
      max-width: 100%;
    }

    .glass-nav {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      position: sticky;
      top: 0;
      z-index: 50;
      border-bottom: 1px solid rgba(226, 232, 240, 0.6);
    }

    .card-transition {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .custom-scrollbar::-webkit-scrollbar {
      width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
      background: #e2e8f0;
      border-radius: 10px;
    }

    .truncate-2 {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    /* Input appearance reset for numeric */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    @media (max-width: 1024px) {
      body {
        padding-bottom: 110px;
      }
    }
  </style>


</head>
<body class="bg-slate-50 text-slate-900">
    <div class="loading-overlay">
            <div class="floating-box">
              <div class="float-spinner"></div>
              <div class="loading-text">Sedang Memuat...</div>
            </div>
        </div>
      </div>
  </div>
  <!-- NAVBAR -->
  <nav class="glass-nav w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 sm:h-20 flex justify-between items-center">
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 sm:w-11 sm:h-11 bg-orange-500 rounded-xl sm:rounded-2xl flex items-center justify-center text-white shadow-lg shadow-orange-100 shrink-0">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="sm:w-6 sm:h-6">
            <path d="M17 8h1a4 4 0 1 1 0 8h-1"></path>
            <path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V8z"></path>
            <line x1="6" y1="2" x2="6" y2="4"></line>
            <line x1="10" y1="2" x2="10" y2="4"></line>
            <line x1="14" y1="2" x2="14" y2="4"></line>
          </svg>
        </div>
        <h1 class="text-lg sm:text-xl font-extrabold text-slate-800 tracking-tight">
          Restoran <span class="text-orange-500">Kita</span>
        </h1>
      </div>

      <div class="hidden md:flex flex-1 max-w-sm mx-10 items-center bg-slate-100 rounded-2xl px-4 py-2 border border-slate-200">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
        <input type="text" id="searchMenu"  oninput="cariData()" placeholder="Cari menu..." class="bg-transparent border-none focus:outline-none w-full ml-3 text-sm">
      </div>

      <div class="flex items-center gap-3">
        <div class="text-right hidden sm:block">
          <p class="text-[11px] font-bold text-slate-800 leading-none mb-1">Pelanggan Setia</p>
          <p class="text-[10px] text-orange-500 font-bold leading-none">Gold Member</p>
        </div>
        <div class="w-10 h-10 rounded-full border-2 border-orange-100 p-0.5 overflow-hidden">
          <img src="https://ui-avatars.com/api/?name=User&background=f97316&color=fff" class="rounded-full w-full h-full object-cover" alt="Avatar">
        </div>
      </div>
    </div>
  </nav>

  <main class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-10">
    <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
      
      <!-- MENU (LEFT) -->
      <div class="flex-grow order-2 lg:order-1 space-y-10">
        
        <div class="md:hidden flex items-center bg-white border border-slate-200 rounded-2xl px-4 py-3.5 shadow-sm">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 mr-3">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
          </svg>
          <input type="text"  placeholder="Cari makanan..." class="bg-transparent border-none focus:outline-none w-full text-sm">
        </div>

        <section>
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
              <div class="w-1 h-7 bg-orange-500 rounded-full"></div>
              <h2 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">MENU</h2>
            </div>
             <div class="flex mb-6">
                  <select id="mejaData"
                       
                      onchange="updateNavMeja()" 
                      class="block w-full appearance-none cursor-pointer rounded-xl border border-slate-200 bg-white px-4 py-3 pr-10 text-sm font-medium text-slate-700 transition-all focus:border-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 hover:border-slate-300"
                    > 
                    <option value="" disabled selected>Pilih Nomor Meja</option> 
                    <optgroup id="select_meja" label="List meja">       
                    
                    </optiongroup>
                    </select>
              </div>      
          </div>

          <!-- Menu Container for Dynamic Rendering -->
          <div id="food-menu-grid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
            <!-- Items injected by JS -->
          </div>
        </section>
      </div>

      <!-- SIDEBAR (RIGHT) -->
      <aside class="lg:w-[380px] order-1 lg:order-2 shrink-0">
        <div class="lg:sticky lg:top-28">
          <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden flex flex-col">
            <div class="p-6 bg-slate-50/50 border-b border-slate-100 flex justify-between items-center">
              <h3 class="font-black text-slate-800">Keranjang Saya</h3>
              <span id="cart-badge" class="bg-orange-500 text-white text-[10px] font-black px-2.5 py-1.5 rounded-xl uppercase tracking-widest">0 Item</span>
            </div>

            <div class="p-6 bg-slate-50/50 border-b border-slate-100 flex justify-between items-center">
                  <h3 class="font-black text-slate-800">Pelanggan</h3>
                  <input type="text" id="namaPelanggan" class="" maxlength="100" placeholder="Nama pelanggan">
            
            </div>
            <div class="p-6 bg-slate-50/50 border-b border-slate-100 flex justify-between items-center">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 ml-6">Catatan Pesanan</label>
                <textarea id="catatan_pesanan" rows="2" placeholder="Contoh: Tidak pakai bawang, pedas..." class="input-field"></textarea>
            </div>   
            <!-- Empty Cart Message -->
            <div id="empty-cart-msg" class="p-10 text-center space-y-3">
              <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto text-slate-300">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
              </div>
              <p class="text-slate-400 text-sm font-medium">Keranjang masih kosong</p>
            </div>

            <div id="cart-items-container" class="p-6 space-y-6 max-h-[350px] overflow-y-auto custom-scrollbar hidden">
              <!-- Cart items injected by JS -->
            </div>

            <div id="cart-footer" class="p-6 bg-slate-50 border-t border-slate-100 space-y-5">
              <div class="space-y-2.5">
                <div class="flex justify-between text-xs text-slate-500">
                  <span>Subtotal</span>
                  <span id="cart-subtotal" class="text-slate-800 font-bold">Rp0</span>
                </div>
                <div class="flex justify-between text-xs text-slate-500">
                  <span>Pajak (11%)</span>
                  <span id="cart-tax" class="text-slate-800 font-bold">Rp0</span>
                </div>
                <div class="flex justify-between items-center pt-3 mt-1 border-t border-slate-200">
                  <span class="text-lg font-black text-slate-800">Total</span>
                  <span id="cart-total" class="text-xl font-black text-orange-600">Rp0</span>
                </div>
              </div>
        
              <div>
              
              </div>
            </div>
            
              <button onclick="kirimPesanan()" class="w-full bg-slate-900 text-white font-black py-4 rounded-2xl shadow-xl hover:bg-black active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                Konfirmasi Pesanan
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </aside>
    </div>
  </main>

  <!-- MOBILE FLOATING ACTION BAR -->
  <div id="mobile-cart-bar" class="lg:hidden fixed bottom-6 left-5 right-5 z-40">
    <button class="w-full bg-orange-600 text-white p-4.5 rounded-[1.75rem] shadow-2xl flex items-center justify-between font-black active:scale-95 transition-all ring-4 ring-white">
      <div class="flex items-center gap-3 ml-2">
        <div class="bg-white/20 p-2 rounded-xl shrink-0">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
            <path d="M3 6h18"></path>
            <path d="M16 10a4 4 0 0 1-8 0"></path>
          </svg>
        </div>
        <div class="text-left">
          <p class="text-[9px] uppercase opacity-70 leading-none mb-1">Cek Keranjang</p>
          <p id="mobile-cart-total" class="text-lg leading-none">Rp0</p>
        </div>
      </div>
      <div class="flex items-center gap-2 mr-2">
        <span id="mobile-cart-badge" class="bg-black/10 px-2.5 py-1.5 rounded-xl text-[10px]">0 Item</span>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="18 15 12 9 6 15"></polyline>
        </svg>
      </div>
    </button>
  </div>
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
      let MENU_DATA = [];

const getData = () => {
    return new Promise((resolve, reject) => {
        const xml = new XMLHttpRequest();
        const link = "{{route('actionpesanan')}}";
        const search = document.getElementById('searchMenu').value;
        const data = "action=loadData&cari="+search;
        
        // 🚀 Prioritas tinggi + no cache
        xml.open('POST', link, true);
        xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xml.setRequestHeader('X-CSRF-TOKEN', token);
        xml.timeout = 15000; // 15s timeout
        
        xml.onreadystatechange = function() {
            if (xml.readyState === 4) {
                if (xml.status === 200) {
                    try {
                        const jsn = JSON.parse(xml.responseText);
                        MENU_DATA = jsn.arr || [];
                        console.log(`✅ ${MENU_DATA.length} items loaded`);
                        renderMenu(); 
                        resolve(jsn);
                    } catch (e) {
                        reject(new Error('JSON Parse Error'));
                    }
                } else {
                    reject(new Error(`HTTP ${xml.status}`));
                }
            }
        };
        
        xml.ontimeout = () => reject(new Error('Timeout 15s'));
        xml.onerror = () => reject(new Error('Network Error'));
        
        xml.send(data);
    });
};

const getKeranjang = () => {
  return new Promise((resolve,reject) => {
          const xml       = new XMLHttpRequest();
          const link      = "{{route('actionpesanan')}}";
          const meja      = document.querySelector('#mejaData').value;
          const kodetemp  = "{{Session::get('kodeTemp')}}";
          const data      = `action=getkeranjang&meja=${meja}&kodeTempat=${kodetemp}`;
          xml.open('POST',link,true);
          xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xml.setRequestHeader('X-CSRF-TOKEN', token);
          xml.timeout = 15000; // 15s timeout
          xml.onreadystatechange = function(){
            if(xml.readyState === 4){
              if(xml.status === 200){
                  try {
                    const res = xml.responseText;
                    let json  = JSON.parse(res);       
                    resolve(json);                      
                  } catch(e){
                    reject(new Error('Json Parse Error'));
                  }
              }else{
                reject(new Error(`HTTP ${xml.status}`));
              }
            }
          }
          xml.ontimeout = () => reject(new Error('Timeout 15 second'));
          xml.onerror = () => reject(new Error('Network Error'));
          xml.send(data);
          

  });
}

const renderCart = (json) => {
  const cartBadge = document.getElementById('cart-badge');
  const container = document.getElementById('cart-items-container');
  const emptyMsg = document.getElementById('empty-cart-msg');
  const subtotalEl = document.getElementById('cart-subtotal');
  const taxEl = document.getElementById('cart-tax');
  const totalEl = document.getElementById('cart-total');
  const checkoutBtn = document.getElementById('checkout-btn');
  const mobiCartBadge       = document.getElementById('mobile-cart-badge');
  const mobiTotal           = document.getElementById('mobile-cart-total');
  if (json.jmlData > 0) {
    container.innerHTML = '';
    
    let subtotal = 0;
    json.load.forEach((item, index) => {
      subtotal += item.sub;
      const itemHTML = `
        <div class="cart-item group relative flex gap-4 p-4 bg-white/50 backdrop-blur-sm rounded-2xl border border-slate-100 hover:border-slate-200 transition-all duration-200 hover:shadow-md" data-index="${index}">
          <button class="remove-item absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs font-bold opacity-0 group-hover:opacity-100 transition-all duration-200 hover:bg-red-600 shadow-lg" title="Hapus">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
          
          <div class="w-16 h-16 flex-shrink-0 rounded-xl overflow-hidden bg-slate-100">
            <img src="{{asset('folderUser')}}/${item.locationFile}" alt="${item.namaItem}" class="w-full h-full object-cover" onerror="this.src='/placeholder.jpg'">
          </div>
          
          <div class="flex-1 min-w-0">
            <h4 class="font-bold text-sm text-slate-800 leading-tight line-clamp-2">${item.namaItem}</h4>
            <div class="flex items-center gap-2 mt-2">
              <span class="text-xs text-slate-500">Rp ${parseInt(item.hargaJual).toLocaleString('id-ID')}</span>
              <span class="text-xs text-slate-400">x</span>
              <div class="qty-controls flex items-center gap-2 bg-slate-100 px-3 py-1 rounded-full">
                    <span class="qty font-bold text-sm min-w-[20px] text-center">${item.qty}</span>
              </div>
            </div>
          </div>
          
          <div class="text-right flex flex-col items-end flex-shrink-0">
            <span class="font-bold text-sm text-slate-800">Rp ${item.sub.toLocaleString('id-ID')}</span>
          </div>
        </div>
      `;
      container.insertAdjacentHTML('beforeend', itemHTML);
    });

    //const tax = Math.round(subtotal * 0.11);
    const total = subtotal;

    cartBadge.textContent = `${json.jmlData} Item${json.jmlData > 1 ? 's' : ''}`;
    mobiCartBadge.textContent = `${json.jmlData} Item${json.jmlData > 1 ? 's' : ''}`;
    container.classList.remove('hidden');
    emptyMsg.classList.add('hidden');
    
    subtotalEl.textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
    //taxEl.textContent = `Rp ${tax.toLocaleString('id-ID')}`;
    totalEl.textContent = `Rp ${total.toLocaleString('id-ID')}`;
    mobiTotal.textContent = `Rp ${total.toLocaleString('id-ID')}`;
    
    if(checkoutBtn) {
      checkoutBtn.disabled = false;
      checkoutBtn.textContent = `Checkout (Rp ${total.toLocaleString('id-ID')})`;
    }

  } else {
    container.classList.add('hidden');
    emptyMsg.classList.remove('hidden');
    cartBadge.textContent = '0 Item';
    mobiCartBadge.textContent = '0 Item';
    subtotalEl.textContent = 'Rp 0';
    taxEl.textContent = 'Rp 0';
    totalEl.textContent = 'Rp 0';
    mobiTotal.textContent = 'Rp 0';
    if(checkoutBtn) {
      checkoutBtn.disabled = true;
      checkoutBtn.textContent = 'Checkout';
    }
  }
};

    let cart = {};

    function formatRupiah(num) {
      return 'Rp' + num.toLocaleString('id-ID');
    }



    function increment(kodetemp,kodeItem,harga,diskon,namaItem) {
      const meja = document.querySelector('#mejaData').value;
      if(meja == ""){
            Swal.fire({
                    icon  : "error",
                    title : "oops",
                    text  : "pilih meja terlebih dahulu",
                    showConfirmButton: true,
                      didClose: () => {
                       document.getElementById("mejaData").focus(); 
                      }
             });
        
      }else{
          const xml     = new XMLHttpRequest();
          const link    = "{{route('actionpesanan')}}";
          const meja    = document.getElementById("mejaData").value; 
          let data      = "action=addPesanan&kodeTemp="+kodetemp+"&kode_item="+kodeItem+"&harga="+harga+"&disc="+diskon+"&meja="+meja+"&nama_item="+namaItem;
          xml.open("POST",link,true);
          xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xml.setRequestHeader('X-CSRF-TOKEN', token);
          xml.onreadystatechange = function(){
              if(xml.status == 200 && xml.readyState == 4){
                  const res = xml.responseText;
                  const jsn = JSON.parse(res);
                  if(jsn.msg == "insert sukses"){
                      document.getElementById(`#${kodeItem}`).value = jsn.qty;
                  }else if(jsn.msg == "update sukses"){
                      document.getElementById(`#${kodeItem}`).value = jsn.qty;
                  }
                  loadKeranjang();
              }
            }
          xml.send(data);
      }

    }

    function decrement(kodetemp,kodeItem,harga,diskon,namaItem) {
       const meja = document.querySelector('#mejaData').value;
      if(meja == ""){
            Swal.fire({
                    icon  : "error",
                    title : "oops",
                    text  : "pilih meja terlebih dahulu",
                    showConfirmButton: true,
                      didClose: () => {
                       document.getElementById("mejaData").focus(); 
                      }
             });
      }else{
        const xml     = new XMLHttpRequest();
          const link    = "{{route('actionpesanan')}}";
          const meja    = document.getElementById("mejaData").value; 
          let data      = "action=delPesanan&kodeTemp="+kodetemp+"&kode_item="+kodeItem+"&harga="+harga+"&disc="+diskon+"&meja="+meja+"&nama_item="+namaItem;
          xml.open("POST",link,true);
          xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xml.setRequestHeader('X-CSRF-TOKEN', token);
          xml.onreadystatechange = function(){
              if(xml.status == 200 && xml.readyState == 4){
                  const res = xml.responseText;
                  const jsn = JSON.parse(res);
                  if(jsn.msg == "update sukses"){
                    document.getElementById(`#${kodeItem}`).value = jsn.qty;
                  }else if(jsn.msg == "data kosong"){
                    document.getElementById(`#${kodeItem}`).value = jsn.qty;
                    console.log('belum ada data yang di pilih');
                  }
                  loadKeranjang();
              }
            }
          xml.send(data);
      }

    }

  
    function getMeja(){
        const xml = new XMLHttpRequest();
        const link        = "{{route('actionpesanan')}}";
        let frmData       = new FormData();
        frmData.append('action', 'getMeja');
        frmData.append('kode',"{{Session::get('kodeTemp')}}");
        xml.open('POST',link,true);
        xml.setRequestHeader('X-CSRF-TOKEN',token);
        xml.onreadystatechange = function(e) {
          if(xml.status==200 && xml.readyState == 4){
            try {
                let res = xml.responseText;
                const jsn   = JSON.parse(res);
                
                let   option= "";
                if(jsn.jmlData > 0){
                  for(let i =0; i < jsn.jmlData; i++){
                    option += "<option value="+jsn.arrData[i].kodeMeja+">"+jsn.arrData[i].nomorMeja+"</option>";
                  }
                }
                document.querySelector('#select_meja').innerHTML = option;
            } catch (e) {
                console.error("Error:", e);
            }
        } else if (xml.readyState == 4) {
            console.error("Error HTTP:", xml.status);
        }
    };
        xml.send(frmData);
    
    }

      function loadKeranjang() {
        getKeranjang().then(renderCart).catch(console.error);
      }
    
      const updateNavMeja = (e) => {
        loadKeranjang();
       }
    
    function renderMenu() {
      if(MENU_DATA.length < 1){
        console.log("no Data Menu For Load");
      }else if(MENU_DATA.length > 0){
      const grid = document.getElementById('food-menu-grid');
      grid.innerHTML = MENU_DATA.map(item => {
        const cartItem = cart[item.id];
        const qty = cartItem ? cartItem.qty : 0;

        return `
          <div class="bg-white rounded-[2rem] overflow-hidden shadow-sm border border-slate-100 flex flex-col group card-transition">
            <div class="relative aspect-video overflow-hidden">
              <img src="{{asset('folderUser')}}/${item.locationFile}" class="w-full h-full object-cover group-hover:scale-105 duration-700" alt="${item.namaItem}">
         
            </div>
            <div class="p-6 flex-grow flex flex-col">
              <h3 class="font-bold text-lg text-slate-800 mb-2 group-hover:text-orange-500 transition-colors">${item.namaItem}</h3>
              <p class="text-slate-500 text-xs sm:text-sm mb-6 leading-relaxed truncate-2">Diskon = ${item.diskon} %</p>
              <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-50">
                <span class="text-orange-500 font-black text-xl">${formatRupiah(item.harga)}</span>
                
                <div class="flex items-center gap-3">
                  <!-- Tombol Minus Bulat Tipis -->
                  <button onclick="decrement('${item.kodeTem}','${item.kodeItem}',${item.harga},${item.diskon},'${item.namaItem}')" class="w-8 h-8 flex items-center justify-center border border-slate-400 rounded-full text-slate-500 hover:border-slate-500 hover:text-slate-600 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                      <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                  </button>
                  
                  <!-- Input Kuantitas Bergaya Minimalis (Selalu Tampil) -->
                  <input type="number" id="#${item.kodeItem}"
                         value="" 
                         onchange="updateQtyFromInput(${item.kodeItem})"
                         class="w-10 bg-transparent text-center text-lg font-bold text-orange-600 focus:outline-none border-none">
                  
                  <!-- Tombol Plus Bulat Biru Tipis -->
                  <button onclick="increment('${item.kodeTem}','${item.kodeItem}',${item.harga},${item.diskon},'${item.namaItem}')" class="w-8 h-8 flex items-center justify-center border border-blue-500 rounded-full text-blue-500 hover:bg-blue-50 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                      <line x1="12" y1="5" x2="12" y2="19"></line>
                      <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
        `;
      }).join('');
      }
     
    }

const cariData = async () => {
    try {
        await getData();
    } catch(e) {
        console.error('Search failed:', e);
    }
};
const initApp = async () => {
    try {
        await getMeja();
        await getData();
        renderMenu();
        console.log('✅ Ready!');
    } catch (e) {
        console.error('❌ Load failed:', e);
    }
};
initApp();

let socket;
let reconnectCount = 0;
const kodeTemp  = "{{ Session::get('kodeTemp') }}";
const userId    = "{{ Session::get('userId') }}";
socket = new WebSocket("ws://localhost:10000/layanan?kodeTemp="+encodeURIComponent(kodeTemp)+"&userId="+encodeURIComponent(userId)+"&token="+encodeURIComponent(token));
socket.onopen = () => {
  console.log("TERHUBUNG ✅");
};

socket.onerror = (e) => {
  console.log("ERROR ❌", e);
};

socket.onclose = () => {
  console.log("CLOSED ❌", reconnectCount);
    setTimeout(() => {
        reconnectCount++;
        console.log("Reconnect ke-" + reconnectCount + "...");
        const newSocket = new WebSocket("ws://localhost:10000/layanan?kodeTemp="+encodeURIComponent(kodeTemp)+"&userId="+encodeURIComponent(userId)+"&token="+encodeURIComponent(token));
        newSocket.onopen = socket.onopen;
        newSocket.onerror  = socket.onerror;
        newSocket.onclose = socket.onclose;
        newSocket.onmessage =  socket.onmessage;
        socket= newSocket;
    },5000)  
  
};

socket.onmessage = function(e){
    if(e.data == 'berhasil'){
      loadKeranjang();
      loadingStop();
      document.getElementById('namaPelanggan').value = "";
      Swal.fire({
        title: "Transaksi suskes!",
        text: "data telah disimpan",
        icon: "success"
      });
    }
  console.log(e.data);
 }

 const kirimPesanan = () => {
    const xml         = new XMLHttpRequest();
    const meja        = document.getElementById("mejaData").value; 
    const user        = "{{Session::get('userId')}}";
    const pelanggan   = document.getElementById('namaPelanggan').value;
    const catatan     = document.getElementById('catatan_pesanan').value;
    const data        =  `action=cekPesanan&meja=${meja}&user=${user}`;
    const link        = "{{route('actionpesanan')}}";
    xml.open('POST',link,true);
    xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xml.setRequestHeader('X-CSRF-TOKEN',token);
    xml.timeout = 15000; // 15s timeout
    xml.onreadystatechange = function(){
      if(xml.status == 200 && xml.readyState == 4){
        const respon = xml.responseText;
        if(respon === 'kosong'){
            Swal.fire({
                    icon  : "error",
                    title : "oops",
                    text  : "Anda belum memilih pesanan",
                    showConfirmButton: true
             });
        }else if(respon === "ada"){
          if(socket.readyState === WebSocket.OPEN){
            if(pelanggan == ""){
                  Swal.fire({
                    icon  : "warning",
                    title : "oops",
                    text  : "Nama Pemesan Belum Di isi, isi nama pemesan terlebih dahulu !",
                    showConfirmButton: true,
                      didClose: () => {
                       document.getElementById("namaPelanggan").focus(); 
                    }
             });
            }else if(pelanggan != ""){
              loadingStart();
              const jsnData = JSON.stringify({
                action : "savePesanan",
                meja   : meja,
                user   : user,
                namaPelanggan : pelanggan,
                catatan : catatan,
                kodeTemp : "{{Session::get('kodeTemp')}}"
            })
            socket.send(jsnData);
            }
        
          }else{
                Swal.fire({
                    icon  : "error",
                    title : "oops",
                    text  : "Tidak terkoneksi ke server tidak dapat melanjutkan proses",
                    showConfirmButton: true
             });
          }
      
        }
      }
    }
    xml.send(data);
 }
</script>

</body>
</html>
