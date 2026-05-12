<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Tidak Ditemukan</title>
    <!-- Pastikan Tailwind CSS terpasang di proyek Laravel Anda -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(20px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        @keyframes ping-slow {
            0% { transform: scale(1); opacity: 0.2; }
            50% { transform: scale(1.2); opacity: 0.1; }
            100% { transform: scale(1); opacity: 0.2; }
        }
        .animate-fade-up {
            animation: fade-up 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
        .animate-ping-slow {
            animation: ping-slow 2s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-white font-sans antialiased">

    <div class="relative min-h-screen w-full bg-white overflow-hidden flex items-center justify-center p-6">
        <!-- Decorative Background Elements -->
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-50 rounded-full blur-[80px] opacity-60"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-slate-100 rounded-full blur-[80px] opacity-60"></div>
        
        <div class="relative z-10 max-w-lg w-full text-center animate-fade-up">
            <!-- Illustration with Floating Effect -->
            <div class="relative inline-flex items-center justify-center w-32 h-32 mb-10 animate-float">
                <div class="absolute inset-0 bg-indigo-600/5 rounded-full"></div>
                <div class="absolute inset-4 bg-indigo-600/10 rounded-full animate-ping-slow"></div>
                
                <!-- Icon SearchX -->
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-600 relative z-10">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/><path d="m13.5 8.5-5 5"/><path d="m8.5 8.5 5 5"/>
                </svg>
            </div>

            <!-- Text Content -->
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">
                Oops! Data Tidak Ditemukan.
            </h1>
            <p class="text-lg text-slate-500 mb-12 max-w-md mx-auto leading-relaxed">
                Sepertinya apa yang Anda cari sedang bersembunyi atau belum ditambahkan ke sistem kami. 
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                
                <a href="{{ url()->previous() }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-transparent border-2 border-slate-200 text-slate-600 font-bold rounded-2xl transition-all hover:bg-slate-50 active:scale-95">
                    <!-- Icon ArrowLeft -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                    Kembali ke halaman sebelumnya
                </a>
            </div>

            <!-- Footer/Tips Section -->
            <div class="mt-16 flex flex-col items-center gap-6 opacity-0 animate-fade-up" style="animation-delay: 0.4s; animation-fill-mode: forwards;">
                <div class="h-px w-24 bg-slate-200"></div>
                <div class="flex flex-wrap justify-center gap-x-8 gap-y-3 text-sm text-slate-400 font-medium">
                    <span class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-indigo-400"></div>
                        Periksa Ejaan
                    </span>
                    <span class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-indigo-400"></div>
                        Gunakan Filter Umum
                    </span>
                    <span class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-indigo-400"></div>
                        Hubungi Admin
                    </span>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
