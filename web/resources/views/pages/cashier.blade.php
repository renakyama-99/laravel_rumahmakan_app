<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cashier Order Monitor - Laravel Ready</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/index.css') }}">
    
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
<div class="loading-overlay">
            <div class="floating-box">
              <div class="float-spinner"></div>
              <div class="loading-text">Sedang Memuat...</div>
            </div>
        </div>
      </div>
</div>
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
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right" id="tx_stat"></span>
                        <span class="text-sm font-mono font-black text-slate-700" id="statConnection"></span>
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
        
            @yield('content')
       
    </div>
@yield('script')
</body>
</html>
