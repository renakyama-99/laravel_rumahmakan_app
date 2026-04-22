<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cashier Order Monitor - Laravel Ready</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />

    
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
<body class="bg-slate-50 text-slate-900 antialiased">

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
                        <h1 class="text-lg font-black text-slate-800 tracking-tight leading-none uppercase">HALAMAN KASIR</h1>
                    </div>
                </div>
                @yield('searchBar')

                <!-- Time & User (Static for Laravel) -->
                <div class="flex items-center space-x-6">
                    <div class="hidden md:flex flex-col items-end">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Jam Server</span>
                        <span class="text-sm font-mono font-black text-slate-700">12:57:49</span>
                    </div>
                    
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 border border-slate-200 hover:text-indigo-600 hover:border-indigo-200 transition-all focus:outline-none">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </button>

                        <div 
                            x-show="open" 
                            x-cloak
                            @click.away="open = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-3 w-48 bg-white border border-slate-200 rounded-2xl shadow-xl py-2 z-50 overflow-hidden"
                        >
                            <a href="{{route('dashboard')}}" class="flex items-center space-x-3 px-4 py-3 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-colors">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                <span>Home</span>
                            </a>
                            <div class="h-px bg-slate-100 mx-2"></div>
                            <a href="{{ route('logout') }}" class="flex items-center space-x-3 px-4 py-3 text-sm font-bold text-rose-500 hover:bg-rose-50 transition-colors">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- 2. MAIN CONTENT -->
        <main class="max-w-[1600px] mx-auto px-6 py-8 flex-1 w-full">
            @yield('content')
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
@yield('script')
</body>
</html>
