@if(Session::get('userId') == "" && Session::get('email') == "")
<script>window.location.href="{{route('dashboard')}}";</script>
@endif
@extends('pages.cashier')
@section('content')
<main class="mx-auto w-full px-6 py-8 overflow-hidden flex flex-col md:flex-row gap-8 flex-1 items-center justify-center min-h-screen">
    <!-- Right: Summary & Payment -->
    <!-- Menghapus flex-1 agar lebarnya terkunci pada max-w-md, bukan melebar penuh -->
    <div class="w-full space-y-6 max-w-md">
        <!-- Billing Summary -->
        <div class="bg-indigo-600 rounded-[32px] p-8 text-white shadow-2xl shadow-indigo-200 text-left">
            <h3 class="text-[10px] font-black text-indigo-200 uppercase tracking-widest mb-6 text-left">Ringkasan Pembayaran</h3>
            
            <div class="space-y-4 mb-8">
                <div class="flex justify-between items-center text-sm">
                    <span class="opacity-70 font-medium">Subtotal Orderan</span>
                    <span class="font-black" id="subtotalOrder"></span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="opacity-70 font-medium">Subtotal Tambahan</span>
                    <span class="font-black text-amber-300" id="subtotalExtra"></span>
                </div>
                <div class="h-px bg-white/10 my-4"></div>
                <div class="flex flex-col">
                    <span class="text-[10px] font-black text-indigo-300 uppercase tracking-widest mb-1">Total Bayar</span>
                    <span class="text-4xl font-black tracking-tighter" id="grandTotal"></span>
                </div>
            </div>

            <!-- Action -->
            <div class="space-y-3">
                <label class="text-[10px] font-bold text-white/60 uppercase tracking-widest">Metode Pembayaran</label>
                <div class="grid grid-cols-3 gap-2" id="paymentMethodsList">
     
                </div>
            </div>

            <button onclick="cetakNota()" class="w-full mt-8 bg-white text-indigo-600 py-5 rounded-2xl font-black uppercase text-sm tracking-widest shadow-xl hover:scale-[1.02] active:scale-95 transition-all">Cetak Nota</button>
        </div>
    </div>
</main>
@endsection
@section('script')
    <script type="text/javascript">
        let token           = document.querySelector('meta[name="csrf-token"]').content;
        let itemTambahan    = [];
        let dataPesanan     = [];
        
      const loadingStop = () => {
        document.querySelector('.loading-overlay').style.display='none';
      }
      const loadingStart = () => {
        document.querySelector('.loading-overlay').style.display='';
      }

      loadingStop()
          const createCard = () => {
         const xml        = new XMLHttpRequest();
         const link       = "{{route('actKasir')}}";
         const noJual     = "{{$noPenjualan}}";
         const data       = "action=getChart&noJual="+noJual;
         xml.open('POST',link,true);
         xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
         xml.setRequestHeader('X-CSRF-TOKEN', token);
         xml.timeout = 15000; // 15s timeout
         xml.onreadystatechange = function() {
                if(xml.readyState === 4 && xml.status === 200){
                    const res = xml.responseText;
                    const json = JSON.parse(res);
                    const result = json.load.reduce((acc,item) => {
                        if(item.type === 'tambahan'){
                            acc.tambahan += item.subtotal;
                        }else{
                            acc.utama    += item.subtotal;
                        }
                        return acc;
                    }, {tambahan : 0, utama:0});
                    const subtotal = document.querySelector('#subtotalOrder');
                    const extra    = document.querySelector('#subtotalExtra');
                    subtotal.innerHTML = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(result.utama);
                    extra.innerHTML = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(result.tambahan);
                    document.querySelector('#grandTotal').innerHTML = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(parseInt(result.tambahan) + parseInt(result.utama));
                }
         }
         xml.ontimeout = () => reject(new Error('Timeout 15s'));
         xml.onerror = () => reject(new Error('Network Error')); 
         xml.send(data);
    }
    createCard();

    const cetakNota = () => {
         window.location.href = `${window.location.origin}/cashierMonitor/nota/{{$noPenjualan}}`; 
        }
    </script>
@endsection