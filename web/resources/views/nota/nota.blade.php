<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Nota - {{ $order_id ?? 'INV-001' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&display=swap');

        /* Gaya Khusus Struk */
        .receipt {
            width: 80mm;
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            line-height: 1.2;
            padding: 10px;
            background: white;
        }

        @media print {
            @page {
                margin: 0;
                size: 80mm auto; /* Secara otomatis menyesuaikan panjang konten */
            }
            body {
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .receipt {
                width: 80mm;
                box-shadow: none;
                border: none;
            }
        }

        /* Dekorasi zigzag di layar (hilang saat print) */
        .zigzag {
            height: 10px;
            background: linear-gradient(-45deg, transparent 5px, white 5px), linear-gradient(45deg, transparent 5px, white 5px);
            background-size: 10px 10px;
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center py-10">

    <!-- Tombol Aksi (Hilang saat print) -->
    <div class="no-print mb-6 space-x-2">
        <button onclick="window.print()" class="bg-black text-white px-6 py-2 rounded-lg font-bold shadow-lg hover:bg-gray-800 transition">
            CETAK NOTA
        </button>
        <button onclick="window.location.href = `{{route('monitorKasir')}}`" class="bg-white border border-gray-300 px-6 py-2 rounded-lg font-bold hover:bg-gray-50 transition">
            KEMBALI
        </button>
    </div>

    <!-- Container Nota -->
    <div class="receipt shadow-2xl border border-gray-200">
        
        <!-- Header -->
        <div class="text-center mb-4 uppercase">
            <h1 class="font-bold text-lg leading-tight">{{ $restoran ?? 'WARUNG RASA NUSANTARA' }}</h1>
            <p class="text-[10px]">{{ $alamat ?? 'Jl. Merdeka No. 123, Jakarta' }}</p>
            <p class="text-[10px]">Telp: {{ $telp ?? '0812-3456-7890' }}</p>
        </div>

        <div class="border-t border-dashed border-black my-2"></div>

        <!-- Info Transaksi -->
        <table class="w-full mb-2">
            <tr>
                <td>Nota:</td>
                <td class="text-right">{{ $order_id ?? 'INV-2026-001' }}</td>
            </tr>
            <tr>
                <td>Tgl:</td>
                <td class="text-right">{{ now()->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td>Kasir:</td>
                <td class="text-right">{{ $kasir ?? 'Staff' }}</td>
            </tr>
        </table>

        <div class="border-t border-dashed border-black my-2"></div>

        <!-- Daftar Item -->
        <div class="space-y-2 mb-4">
            {{-- Loop data item di Laravel --}}
            {{-- @foreach($items as $item) --}}
            <div class="flex flex-col">
                <span class="font-bold uppercase text-xs">NASI GORENG SPESIAL</span>
                <div class="flex justify-between">
                    <span>2 x 35.000</span>
                    <span>70.000</span>
                </div>
            </div>
            <div class="flex flex-col">
                <span class="font-bold uppercase text-xs">ES TEH MANIS</span>
                <div class="flex justify-between">
                    <span>3 x 8.000</span>
                    <span>24.000</span>
                </div>
            </div>
            {{-- @endforeach --}}
        </div>

        <div class="border-t border-dashed border-black my-2"></div>

        <!-- Total -->
        <table class="w-full">
            <tr>
                <td>Subtotal</td>
                <td class="text-right">94.000</td>
            </tr>
            <tr>
                <td>Pajak (10%)</td>
                <td class="text-right">9.400</td>
            </tr>
            <tr class="font-bold">
                <td>TOTAL</td>
                <td class="text-right">103.400</td>
            </tr>
        </table>

        <div class="border-t border-dashed border-black my-2"></div>

        <!-- Pembayaran -->
        <table class="w-full mb-4">
            <tr>
                <td>Bayar (Tunai)</td>
                <td class="text-right text-xs">150.000</td>
            </tr>
            <tr>
                <td>Kembali</td>
                <td class="text-right text-xs">46.600</td>
            </tr>
        </table>

        <!-- Footer -->
        <div class="text-center mt-6">
            <p class="font-bold">TERIMA KASIH</p>
            <p class="text-[10px]">Silahkan Datang Kembali</p>
        </div>

    </div>

    <!-- Efek zigzag dekoratif di bawah nota (hanya terlihat di web) -->
    <div class="no-print receipt shadow-none border-none scale-y-[-1] mt-[-1px] relative opacity-20">
        <div class="zigzag"></div>
    </div>

</body>
</html>
