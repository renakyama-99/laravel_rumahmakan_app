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
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-3 mr-4">
                        <div class="size-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                            <i class="fa-solid fa-utensils text-lg"></i>
                        </div>
                        <span class="font-bold text-xl tracking-tight hidden sm:block">FoodMonitor</span>
                    </div>

                </div>

                <div class="flex items-center gap-2 lg:gap-4">
                    @yield('picker')
                    <button class="p-2 hover:bg-slate-100 rounded-full relative">
                        <i class="fa-solid fa-bell text-slate-600"></i>
                        <span class="absolute top-1.5 right-1.5 size-2 bg-rose-500 rounded-full border-2 border-white"></span>
                    </button>
                    <div class="h-8 w-px bg-slate-200 mx-2 hidden sm:block"></div>
                    <div class="hidden sm:block text-right" id="statConnection">

                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="flex-1 overflow-y-auto p-4 lg:p-8">
                    <!-- Tabs / Filter -->
                    <div class="flex items-center gap-2 overflow-x-auto pb-2 no-scrollbar">
                        <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'bg-slate-900 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:border-slate-300'" class="px-6 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-all">Semua</button>
                        <button @click="activeTab = 'pending'" :class="activeTab === 'pending' ? 'bg-slate-900 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:border-slate-300'" class="px-6 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-all">Menunggu</button>
                        <button @click="activeTab = 'preparing'" :class="activeTab === 'preparing' ? 'bg-slate-900 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:border-slate-300'" class="px-6 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-all">Dimasak</button>
                        <button @click="activeTab = 'ready'" :class="activeTab === 'ready' ? 'bg-slate-900 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:border-slate-300'" class="px-6 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-all">Siap Saji</button>
                        <button @click="activeTab = 'delivered'" :class="activeTab === 'delivered' ? 'bg-slate-900 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:border-slate-300'" class="px-6 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-all">Selesai</button>
                    </div>                  
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
