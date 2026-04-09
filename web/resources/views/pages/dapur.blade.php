@if(Session::get('userId') == "" && Session::get('email') == "" &&  Session::get('password') == "" && Session::get('kodeTemp') == "")
<script>window.location.href="{{ route('logout') }}"</script>
@endif
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodOrder Monitor - Dashboard</title>
    <!-- Tailwind CSS 3.4.19 (Latest 3.x) -->
  
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Font Awesome 6.5.1 (Easy to use icons) -->
  
    <!-- Alpine.js for interactivity (Perfect for Laravel/Blade) -->
      @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    

</head>
<body class="bg-slate-50 text-slate-900" x-data="orderApp()">
    <div class="min-h-screen flex flex-col">
        
        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Header -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-3 mr-4">

                        <span class="font-bold text-xl tracking-tight hidden sm:block">FoodMonitor</span>
                    </div>
                    <div class="flex items-center bg-slate-100 rounded-full px-4 py-2 gap-2 w-48 sm:w-64 lg:w-96">
                        <i class="fa-solid fa-magnifying-glass text-xs text-slate-400"></i>
                        <input 
                            type="text" 
                            x-model="searchQuery"
                            placeholder="Cari pesanan..." 
                            class="bg-transparent border-none focus:ring-0 text-sm w-full outline-none"
                        >
                    </div>
                </div>

                <div class="flex items-center gap-2 lg:gap-4">
                    <button class="p-2 hover:bg-slate-100 rounded-full relative">
                        <i class="fa-solid fa-bell text-slate-600"></i>
                        <span class="absolute top-1.5 right-1.5 size-2 bg-rose-500 rounded-full border-2 border-white"></span>
                    </button>
                    <div class="h-8 w-px bg-slate-200 mx-2 hidden sm:block"></div>
                    <div class="hidden sm:block text-right">
                        <p class="text-sm font-medium">Restoran Utama</p>
                        <p class="text-xs text-emerald-600 font-semibold">Online</p>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="flex-1 overflow-y-auto p-4 lg:p-8">
                <div class="max-w-7xl mx-auto space-y-8">
                    
                    <!-- Stats Overview -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-white p-4 lg:p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-4">
                            <div class="w-2 h-12 rounded-full bg-indigo-600 shadow-indigo-100"></div>
                            <div>
                                <p class="text-xs lg:text-sm font-medium text-slate-500 uppercase tracking-wider">Total Pesanan</p>
                                <p class="text-xl lg:text-3xl font-bold mt-1" x-text="stats.total"></p>
                            </div>
                        </div>
                        <div class="bg-white p-4 lg:p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-4">
                            <div class="w-2 h-12 rounded-full bg-amber-500 shadow-amber-100"></div>
                            <div>
                                <p class="text-xs lg:text-sm font-medium text-slate-500 uppercase tracking-wider">Menunggu</p>
                                <p class="text-xl lg:text-3xl font-bold mt-1" x-text="stats.pending"></p>
                            </div>
                        </div>
                        <div class="bg-white p-4 lg:p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-4">
                            <div class="w-2 h-12 rounded-full bg-blue-500 shadow-blue-100"></div>
                            <div>
                                <p class="text-xs lg:text-sm font-medium text-slate-500 uppercase tracking-wider">Dimasak</p>
                                <p class="text-xl lg:text-3xl font-bold mt-1" x-text="stats.preparing"></p>
                            </div>
                        </div>
                        <div class="bg-white p-4 lg:p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-4">
                            <div class="w-2 h-12 rounded-full bg-emerald-500 shadow-emerald-100"></div>
                            <div>
                                <p class="text-xs lg:text-sm font-medium text-slate-500 uppercase tracking-wider">Siap Saji</p>
                                <p class="text-xl lg:text-3xl font-bold mt-1" x-text="stats.ready"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs / Filter -->
                    <div class="flex items-center gap-2 overflow-x-auto pb-2 no-scrollbar">
                        <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'bg-slate-900 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:border-slate-300'" class="px-6 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-all">Semua</button>
                        <button @click="activeTab = 'pending'" :class="activeTab === 'pending' ? 'bg-slate-900 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:border-slate-300'" class="px-6 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-all">Menunggu</button>
                        <button @click="activeTab = 'preparing'" :class="activeTab === 'preparing' ? 'bg-slate-900 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:border-slate-300'" class="px-6 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-all">Dimasak</button>
                        <button @click="activeTab = 'ready'" :class="activeTab === 'ready' ? 'bg-slate-900 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:border-slate-300'" class="px-6 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-all">Siap Saji</button>
                        <button @click="activeTab = 'delivered'" :class="activeTab === 'delivered' ? 'bg-slate-900 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:border-slate-300'" class="px-6 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-all">Selesai</button>
                    </div>

                    <!-- Orders Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        <template x-for="order in filteredOrders" :key="order.id">
                            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col h-full hover:shadow-md transition-shadow">
                                <div class="p-5 border-b border-slate-100 flex justify-between items-start">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded uppercase tracking-wider" x-text="order.id"></span>
                                            <span 
                                                class="text-[10px] font-bold px-2 py-0.5 rounded-full border flex items-center gap-1"
                                                :class="getStatusClasses(order.status)"
                                            >
                                                <i :class="getStatusIcon(order.status)" class="text-[10px]"></i>
                                                <span x-text="order.status.toUpperCase()"></span>
                                            </span>
                                        </div>
                                        <h3 class="font-bold text-lg" x-text="order.customerName"></h3>
                                        <div class="flex items-center gap-3 mt-1 text-xs text-slate-500 font-medium">
                                            <span class="flex items-center gap-1">
                                                <i class="fa-solid fa-utensils text-[10px]"></i>
                                                <span x-text="order.tableNumber ? 'Meja ' + order.tableNumber : 'Takeaway'"></span>
                                            </span>
                                            <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                                            <span class="flex items-center gap-1">
                                                <i class="fa-solid fa-clock text-[10px]"></i>
                                                <span x-text="getTimeAgo(order.createdAt)"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <button class="p-1 hover:bg-slate-50 rounded-lg text-slate-400">
                                        <i class="fa-solid fa-ellipsis-vertical px-1"></i>
                                    </button>
                                </div>

                                <div class="p-5 flex-1 space-y-3">
                                    <template x-for="item in order.items" :key="item.id">
                                        <div class="flex justify-between items-center">
                                            <div class="flex items-center gap-3">
                                                <span class="size-6 bg-slate-100 rounded flex items-center justify-center text-xs font-bold text-slate-600" x-text="item.quantity + 'x'"></span>
                                                <span class="text-sm font-medium text-slate-700" x-text="item.name"></span>
                                            </div>
                                            <span class="text-sm text-slate-400" x-text="'Rp ' + (item.price * item.quantity).toLocaleString()"></span>
                                        </div>
                                    </template>
                                </div>

                                <div class="p-5 bg-slate-50 border-t border-slate-100 space-y-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Tagihan</span>
                                        <span class="text-lg font-black text-slate-900" x-text="'Rp ' + order.total.toLocaleString()"></span>
                                    </div>
                                    
                                    <template x-if="getNextStatus(order.status)">
                                        <button 
                                            @click="updateStatus(order.id, getNextStatus(order.status))"
                                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition-colors shadow-lg shadow-indigo-100"
                                        >
                                            <span x-text="getNextStatusLabel(order.status)"></span>
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <!-- Empty State -->
                        <div x-show="filteredOrders.length === 0" class="col-span-full py-20 text-center" x-cloak>
                            <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-200 inline-block">
                                <i class="fa-solid fa-utensils text-4xl text-slate-200 mb-4 block"></i>
                                <p class="text-slate-500 font-medium">Tidak ada pesanan ditemukan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function orderApp() {
            return {
                isSidebarOpen: false,
                activeTab: 'all',
                searchQuery: '',
                orders: [
                    {
                        id: 'ORD-001',
                        customerName: 'Ahmad Fauzi',
                        tableNumber: '05',
                        items: [
                            { id: '1', name: 'Nasi Goreng Spesial', quantity: 2, price: 25000 },
                            { id: '2', name: 'Es Teh Manis', quantity: 2, price: 5000 }
                        ],
                        status: 'pending',
                        createdAt: new Date(Date.now() - 1000 * 60 * 5).toISOString(),
                        total: 60000,
                        type: 'dine-in'
                    },
                    {
                        id: 'ORD-002',
                        customerName: 'Siti Aminah',
                        items: [
                            { id: '3', name: 'Ayam Bakar Madu', quantity: 1, price: 35000 },
                            { id: '4', name: 'Jus Alpukat', quantity: 1, price: 15000 }
                            
                        ],
                        status: 'preparing',
                        createdAt: new Date(Date.now() - 1000 * 60 * 15).toISOString(),
                        total: 50000,
                        type: 'takeaway'
                    },
                    {
                        id: 'ORD-003',
                        customerName: 'Budi Santoso',
                        tableNumber: '12',
                        items: [
                            { id: '5', name: 'Sate Ayam (10 tusuk)', quantity: 1, price: 28000 },
                            { id: '6', name: 'Lontong', quantity: 2, price: 4000 },
                            { id: '7', name: 'sayur', quantity: 2, price: 4000 },
                            { id: '8', name: 'gado gado', quantity: 2, price: 4000 }
                        ],
                        status: 'ready',
                        createdAt: new Date(Date.now() - 1000 * 60 * 25).toISOString(),
                        total: 36000,
                        type: 'dine-in'
                    }
                ],

                get filteredOrders() {
                    return this.orders.filter(order => {
                        const matchesTab = this.activeTab === 'all' || order.status === this.activeTab;
                        const matchesSearch = order.customerName.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                                              order.id.toLowerCase().includes(this.searchQuery.toLowerCase());
                        return matchesTab && matchesSearch;
                    });
                },

                get stats() {
                    return {
                        total: this.orders.length,
                        pending: this.orders.filter(o => o.status === 'pending').length,
                        preparing: this.orders.filter(o => o.status === 'preparing').length,
                        ready: this.orders.filter(o => o.status === 'ready').length,
                    };
                },

                updateStatus(id, newStatus) {
                    const order = this.orders.find(o => o.id === id);
                    if (order) {
                        order.status = newStatus;
                    }
                },

                getStatusClasses(status) {
                    switch (status) {
                        case 'pending': return 'bg-amber-100 text-amber-700 border-amber-200';
                        case 'preparing': return 'bg-blue-100 text-blue-700 border-blue-200';
                        case 'ready': return 'bg-emerald-100 text-emerald-700 border-emerald-200';
                        case 'delivered': return 'bg-slate-100 text-slate-700 border-slate-200';
                        default: return 'bg-gray-100 text-gray-700 border-gray-200';
                    }
                },

                getStatusIcon(status) {
                    switch (status) {
                        case 'pending': return 'fa-solid fa-clock';
                        case 'preparing': return 'fa-solid fa-kitchen-set';
                        case 'ready': return 'fa-solid fa-circle-check';
                        case 'delivered': return 'fa-solid fa-bag-shopping';
                        default: return 'fa-solid fa-circle-question';
                    }
                },

                getNextStatus(status) {
                    switch (status) {
                        case 'pending': return 'preparing';
                        case 'preparing': return 'ready';
                        case 'ready': return 'delivered';
                        default: return null;
                    }
                },

                getNextStatusLabel(status) {
                    switch (status) {
                        case 'pending': return 'Mulai Memasak';
                        case 'preparing': return 'Siap Disajikan';
                        case 'ready': return 'Selesaikan Pesanan';
                        default: return '';
                    }
                },

                getTimeAgo(date) {
                    const mins = Math.floor((Date.now() - new Date(date).getTime()) / 60000);
                    return `${mins}m yang lalu`;
                },

                init() {
                    // No initialization needed for Font Awesome
                }
            }
        }
    </script>
</body>
</html>

