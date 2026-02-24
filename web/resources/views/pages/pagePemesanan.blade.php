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
        <input type="text" placeholder="Cari menu..." class="bg-transparent border-none focus:outline-none w-full ml-3 text-sm">
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
          <input type="text" placeholder="Cari makanan..." class="bg-transparent border-none focus:outline-none w-full text-sm">
        </div>

        <section>
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
              <div class="w-1 h-7 bg-orange-500 rounded-full"></div>
              <h2 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Makanan Utama</h2>
            </div>
            <button class="text-orange-500 text-xs sm:text-sm font-bold">Lihat Semua</button>
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

            <!-- Form Meja & Catatan -->
              <div class="pt-6 border-t border-slate-100 space-y-5">
                <div>
                  <!-- Label dengan Utility Tailwind 3.4 -->
                  <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2 ml-1">
                    Pilih Nomor Meja
                  </label>
                  
                  <div class="relative group">
                    <!-- Select Field: Mengganti input-field dengan utility classes -->
                    <select 
                      id="select-meja" 
                      onchange="updateNavMeja(this.value)" 
                      class="block w-full appearance-none cursor-pointer rounded-xl border border-slate-200 bg-white px-4 py-3 pr-10 text-sm font-medium text-slate-700 transition-all focus:border-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 hover:border-slate-300"
                    >
                      <option value="" disabled selected>Pilih Nomor Meja</option>
                      <optgroup label="Area Indoor" class="font-bold text-slate-900 bg-slate-50">
                        <option value="Meja 01" class="bg-white">Meja 01 (Lantai 1)</option>
                        <option value="Meja 02" class="bg-white">Meja 02 (Lantai 1)</option>
                      </optgroup>
                      <optgroup label="Area Outdoor" class="font-bold text-slate-900 bg-slate-50">
                        <option value="Meja 03" class="bg-white">Meja 03 (Taman)</option>
                        <option value="Meja 04" class="bg-white">Meja 04 (Taman)</option>
                      </optgroup>
                      <option value="Take Away">Bungkus (Take Away)</option>
                    </select>

                    <!-- Icon Dropdown (Custom Arrow) -->
                    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-400 group-hover:text-slate-600 transition-colors">
                      <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                      </svg>
                    </div>
                  </div>
                </div>
              </div>
            <!-- Form Meja & Catatan -->
              <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Catatan Pesanan</label>
                <textarea id="catatan-pesanan" rows="2" placeholder="Contoh: Tidak pakai bawang, pedas..." class="input-field resize-none"></textarea>
              </div>
            </div>
            
              <button class="w-full bg-slate-900 text-white font-black py-4 rounded-2xl shadow-xl hover:bg-black active:scale-[0.98] transition-all flex items-center justify-center gap-2">
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
  <script type="text/javascript" src="{{ asset('assets/myjs/xhr.js') }}"></script>
  <script>
      const getData  = () => {
      const link    = "/pesanan/actionPesanan";
      let data      = "action=loadData";
      xml.open('POST',link,true);
      xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xml.setRequestHeader('X-CSRF-TOKEN',token);
      xml.onreadystatechange = function(){
        if(xml.status == 200 && xml.readyState == 4){
          let respon = xml.responseText;
          console.log(respon);
        }
      }
      xml.send(data);
    }
    const MENU_DATA = [
      {
        id: 1,
        name: 'Nasi Goreng Spesial',
        price: 35000,
        desc: 'Nasi goreng bumbu rahasia dengan topping ayam, telur, dan kerupuk.',
        img: 'https://images.unsplash.com/photo-1512058560366-cd2427ff065b?auto=format&fit=crop&q=80&w=600',
        popular: true
      },
      {
        id: 2,
        name: 'Mie Ayam Jamur',
        price: 30000,
        desc: 'Mie kenyal dengan topping ayam bumbu manis dan jamur kancing segar.',
        img: 'https://images.unsplash.com/photo-1552611052-33e04de081de?auto=format&fit=crop&q=80&w=600',
        popular: false
      },
      {
        id: 3,
        name: 'Sate Ayam Madura',
        price: 45000,
        desc: 'Sate ayam empuk dengan bumbu kacang khas Madura dan lontong.',
        img: 'https://images.unsplash.com/photo-1529566652340-2c41a2c3bc65?auto=format&fit=crop&q=80&w=600',
        popular: false
      }
    ];

    let cart = {};

    function formatRupiah(num) {
      return 'Rp' + num.toLocaleString('id-ID');
    }

    function updateCartUI() {
      const items = Object.values(cart);
      const cartBadge = document.getElementById('cart-badge');
      const mobileBadge = document.getElementById('mobile-cart-badge');
      const container = document.getElementById('cart-items-container');
      const emptyMsg = document.getElementById('empty-cart-msg');
      const subtotalEl = document.getElementById('cart-subtotal');
      const taxEl = document.getElementById('cart-tax');
      const totalEl = document.getElementById('cart-total');
      const mobileTotalEl = document.getElementById('mobile-cart-total');

      const count = items.reduce((sum, item) => sum + item.qty, 0);
      const subtotal = items.reduce((sum, item) => sum + (item.price * item.qty), 0);
      const tax = subtotal * 0.11;
      const total = subtotal + tax;

      cartBadge.textContent = `${count} Item`;
      mobileBadge.textContent = `${count} Item`;
      subtotalEl.textContent = formatRupiah(subtotal);
      taxEl.textContent = formatRupiah(tax);
      totalEl.textContent = formatRupiah(total);
      mobileTotalEl.textContent = formatRupiah(total);

      if (count > 0) {
        container.classList.remove('hidden');
        emptyMsg.classList.add('hidden');
        
        container.innerHTML = items.map(item => `
          <div class="flex gap-4">
            <div class="w-14 h-14 rounded-2xl overflow-hidden shrink-0 shadow-sm">
              <img src="${item.img}" class="w-full h-full object-cover">
            </div>
            <div class="flex-grow min-w-0">
              <h4 class="font-bold text-slate-800 text-sm truncate">${item.name}</h4>
              <p class="text-slate-400 text-[10px] mt-0.5">${formatRupiah(item.price)} x ${item.qty}</p>
              <div class="flex items-center gap-4 mt-2">
                <button onclick="decrement(${item.id})" class="w-7 h-7 flex items-center justify-center border border-slate-300 rounded-full text-slate-400 hover:border-slate-500 hover:text-slate-600 transition-all">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                </button>
                <span class="text-xs font-bold text-slate-700">${item.qty}</span>
                <button onclick="increment(${item.id})" class="w-7 h-7 flex items-center justify-center border border-blue-500 rounded-full text-blue-500 hover:bg-blue-50 transition-all">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                </button>
              </div>
            </div>
            <div class="text-right flex flex-col justify-between shrink-0">
              <span class="font-bold text-slate-800 text-sm italic">${formatRupiah(item.price * item.qty)}</span>
              <button onclick="removeFromCart(${item.id})" class="text-slate-300 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="3 6 5 6 21 6"></polyline>
                  <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path>
                </svg>
              </button>
            </div>
          </div>
        `).join('');
      } else {
        container.classList.add('hidden');
        emptyMsg.classList.remove('hidden');
      }

      renderMenu();
    }

    function increment(id) {
      if (!cart[id]) {
        const item = MENU_DATA.find(i => i.id === id);
        cart[id] = { ...item, qty: 1 };
      } else {
        cart[id].qty++;
      }
      updateCartUI();
    }

    function decrement(id) {
      if (cart[id] && cart[id].qty > 0) {
        cart[id].qty--;
        if (cart[id].qty === 0) {
          delete cart[id];
        }
        updateCartUI();
      }
    }

    function updateQtyFromInput(id, val) {
      const qty = parseInt(val) || 0;
      if (qty < 0) return;
      if (qty === 0) {
        delete cart[id];
      } else {
        if (!cart[id]) {
          const item = MENU_DATA.find(i => i.id === id);
          cart[id] = { ...item, qty: qty };
        } else {
          cart[id].qty = qty;
        }
      }
      updateCartUI();
    }

    function removeFromCart(id) {
      delete cart[id];
      updateCartUI();
    }

    function renderMenu() {
      const grid = document.getElementById('food-menu-grid');

 
      grid.innerHTML = MENU_DATA.map(item => {
        const cartItem = cart[item.id];
        const qty = cartItem ? cartItem.qty : 0;

        return `
          <div class="bg-white rounded-[2rem] overflow-hidden shadow-sm border border-slate-100 flex flex-col group card-transition">
            <div class="relative aspect-video overflow-hidden">
              <img src="${item.img}" class="w-full h-full object-cover group-hover:scale-105 duration-700" alt="${item.name}">
              ${item.popular ? `
                <div class="absolute top-3 left-3">
                  <span class="bg-white/95 px-2.5 py-1 rounded-xl text-[9px] font-black text-orange-600 shadow-sm border border-orange-50">POPULER</span>
                </div>
              ` : ''}
            </div>
            <div class="p-6 flex-grow flex flex-col">
              <h3 class="font-bold text-lg text-slate-800 mb-2 group-hover:text-orange-500 transition-colors">${item.name}</h3>
              <p class="text-slate-500 text-xs sm:text-sm mb-6 leading-relaxed truncate-2">${item.desc}</p>
              <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-50">
                <span class="text-orange-500 font-black text-xl">${formatRupiah(item.price)}</span>
                
                <div class="flex items-center gap-3">
                  <!-- Tombol Minus Bulat Tipis -->
                  <button onclick="decrement(${item.id})" class="w-8 h-8 flex items-center justify-center border border-slate-400 rounded-full text-slate-500 hover:border-slate-500 hover:text-slate-600 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                      <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                  </button>
                  
                  <!-- Input Kuantitas Bergaya Minimalis (Selalu Tampil) -->
                  <input type="number" 
                         value="${qty}" 
                         onchange="updateQtyFromInput(${item.id}, this.value)"
                         class="w-10 bg-transparent text-center text-lg font-bold text-orange-600 focus:outline-none border-none">
                  
                  <!-- Tombol Plus Bulat Biru Tipis -->
                  <button onclick="increment(${item.id})" class="w-8 h-8 flex items-center justify-center border border-blue-500 rounded-full text-blue-500 hover:bg-blue-50 transition-all">
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

    // Initialize
    window.onload = () => {
      renderMenu();
    }


    console.log(MENU_DATA);
    getData();
  </script>
</body>
</html>
