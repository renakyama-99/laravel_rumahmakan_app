@if(Session::get('userId') == "" && Session::get('email') == "" &&  Session::get('password') == "" && Session::get('kodeTemp') == "")
<script>window.location.href="{{ route('logout') }}"</script>
@endif
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FoodOrder Monitor - Dashboard</title>
    <!-- Tailwind CSS 3.4.19 (Latest 3.x) -->
     <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/index.css') }}">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Font Awesome 6.5.1 (Easy to use icons) -->
  
    <!-- Alpine.js for interactivity (Perfect for Laravel/Blade) -->
      @vite(['resources/css/app.css', 'resources/js/app.js'])
      <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />

        <style>
        [x-cloak] { display: none !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Presisi Grid: Memastikan kartu memiliki alignment yang sempurna */
        .order-grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }
        
        @media (min-width: 1024px) {
            .order-grid-container {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>

</head>
<body class="bg-slate-50 text-slate-900" >
    <div class="min-h-screen flex flex-col">
        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Header -->
            <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm">
                <div class="h-16 px-4 lg:px-8 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-3">
                            <div class="size-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                                <i class="fa-solid fa-utensils text-lg"></i>
                            </div>
                            <span class="font-bold text-xl tracking-tight hidden xl:block">FoodMonitor</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 lg:gap-4 ml-auto">
                     @yield('picker')
                        

                        <button class="p-2 hover:bg-slate-100 rounded-full relative">
                            <i class="fa-solid fa-bell text-slate-600"></i>
                            <span class="absolute top-1.5 right-1.5 size-2 bg-rose-500 rounded-full border-2 border-white"></span>
                        </button>
                        
                        <div class="h-8 w-px bg-slate-200 mx-2 hidden sm:block"></div>
                        <div class="hidden sm:block text-right">
                            <div id="tx-stat">
                                
                            </div>
                            <div class="hidden sm:block text-right" id="statConnection">

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs Filter (Unified row for all devices) -->
                <div class="border-t border-slate-100 px-4 lg:px-8 py-2 bg-slate-50/50">
                    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1">
                        <a href="{{route('dashboard')}}" class="px-5 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition-all">Home</a>
                        <button @click="activeTab = 'pending'" :class="activeTab === 'pending' ? 'bg-amber-600 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200'" class="px-5 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition-all">Menunggu</button>
                        <button @click="activeTab = 'preparing'" :class="activeTab === 'preparing' ? 'bg-blue-600 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200'" class="px-5 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition-all">Dimasak</button>
                        <button @click="activeTab = 'ready'" :class="activeTab === 'ready' ? 'bg-emerald-600 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200'" class="px-5 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition-all">Siap Saji</button>
                        <button @click="activeTab = 'delivered'" :class="activeTab === 'delivered' ? 'bg-slate-900 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200'" class="px-5 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition-all">Selesai</button>
                    </div>

                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="flex-1 overflow-y-auto p-4 lg:p-8">
                  
                    <div class="flex items-center rounded-full px-4 py-2 gap-2 w-48 sm:w-64 lg:w-96">
                        @yield('head_content')
                    </div>
                <div class="max-w-7xl mx-auto space-y-8">
                    <!-- Orders Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 lg:gap-5" id="orders-grid">
                        <!-- Orders will be injected here via innerHTML -->
                    </div>
                </div>
                <div id="orders-container">
                        <!-- Orders will be injected here via innerHTML -->
                </div
            </div>
        </main>
    </div>
    @yield('footer')
</body>
</html>
