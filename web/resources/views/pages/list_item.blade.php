@if(Session::get('level') != "admin")
<script>window.location.href="{{route('home')}}";</script>
@endif
@extends('home')
@section('header' , 'List Item / Menu')
@section('content')
<div class="row">
    <div class="col">
        <div class="float-left">
            <div class="input-group mb-3 col-lg-12">
               <input type="text" name="search"  class="form-control" placeholder="SEARCH" maxlength="70" oninput=search(this.value)>
               <div class="input-group-prepend">
                 <span class="input-group-text"><i class="mdi mdi-flattr"></i></span>
               </div>
            </div>
        </div>
    </div>
</div>
<div class="container" id="load_content">

</div>
<br>
<div class="col-sm-12 col-md-5">
    <nav aria-label="Page navigation example">
        <ul class="pagination" id="pagination_load">
        
        </ul>
    </nav>   
</div>
@endsection

@section('script_footer')
<script type="text/javascript" src="{{ asset('assets/myjs/xhr.js') }}"></script>
<script>
    function load(to_load,page_load,search,page){
        const link = "{{route('post.actionMenu')}}";
        const data = "action=load&cari="+search+"&halaman="+page;
        xml.open('POST',link,true);
        xml.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        xml.setRequestHeader('X-CSRF-TOKEN',token);
        xml.onreadystatechange = function(e){
            if(xml.status==200 && xml.readyState == 4){
                let respon          = xml.responseText;
                let parse           = JSON.parse(respon);
                var buatContent     = "";
                
                const jmlHalaman    = parse.jumlah_halaman;
                const halAktif      = parse.halaman_aktif;
                const jumlah_data   = parse.data.length;
                const hitung_index  = jumlah_data/4;
                let keterangan      = "";
                

                //console.log(parse.data);
                if(Math.floor(hitung_index) < 1){
                    var batas     = 1;
                }else{
                    var batas     = Math.floor(hitung_index);
                }
                
                for(let a = 0; a < jumlah_data; a++){

                        for(let b = 0 ; b < batas; b++){

                            window['splice' + b] = parse.data.splice(0,4);
                            const len_data       = window['splice' + b].length;
                            var buat_row         = "";
                            for(c = 0 ; c < len_data; c++){
                                //console.log(window['splice' + b][c][3]);
                                if(window['splice' + b][c][4] < 1){
                                    keterangan = "<p class='card-text text-danger'>HABIS</p>";
                                }else{
                                    keterangan = "<p class='card-text'>Stock : "+window['splice' + b][c][4]+"</p>";
                                }
                                buat_row += "<div class='col-md-3'>"+
                                "<div class='card'>"+
                                "<img style='height:200px;' class='card-img-top img-fluid' src='{{ asset('folderUser') }}/"+window['splice' + b][c][0]+"/"+window['splice' + b][c][3]+"?t="+Date.now()+"'>"+
                                "<div class='card-body'>"+
                                "<h4 class='card-title'>"+window['splice' + b][c][2]+"</h4>"+
                                keterangan+
                                "<p class='card-text'>Harga : Rp "+window['splice' + b][c][5]+"</p>"+
                                "<p class='card-text'>Disc :  "+window['splice' + b][c][6]+" %</p>"+
                                "<div class='btn-group'>"+
                                "<a onclick=hapus_data('"+window['splice'+b][c][1]+"') class='btn btn-sm btn-outline-secondary'>delete</a>"+
                                "<a href='dataItem/edit_produk/"+window['splice'+b][c][1]+"' class='btn btn-sm btn-outline-secondary'>Edit</a>"+
                                "</div>"+
                                "</div>"+
                                "</div>"+
                                "</div>";
                            }
                            buatContent  += "<div class='row'>"+
                                            buat_row+
                                            "</div>";
                        }
                        
                }
                
                document.querySelector('#load_content').innerHTML = buatContent;
                buat_halaman(page_load,jmlHalaman,halAktif);
            }
        }
        xml.send(data);
    }

    function buat_halaman(load_hal,jumlah_hal,hal_aktif){
        const next_hal = "";
        var prev_hal = "";
        var page     = "";

        if(hal_aktif > 1){
            var prev = hal_aktif - 1;
            prev_hal   = "<li class='page-item'><a style='cursor:default;' class='page-link' href='#' onclick=clickPage('"+prev+"') id='"+prev+"'>Previous</a></li>";
        }

        for(var i = 1 ; i <= jumlah_hal ; i++){
            if( (i <= (hal_aktif + 2)) && (i >= (hal_aktif - 3))){
                if(hal_aktif == i){
                    page += "<li class='page-item'><a style='cursor:default;' onclick=clickPage('"+i+"')  class='page-link bg-primary text-white' >"+i+"</a></li>";
                }else{
                    page += "<li class='page-item'><a style='cursor:default;' onclick=clickPage('"+i+"')  class='page-link' >"+i+"</a></li>";
                }  
            }
        }


        if((hal_aktif < jumlah_hal) && (hal_aktif < (jumlah_hal - 3))){
            const next = hal_aktif + 1;
            next_hal  = "<li class='page-item'><a style='cursor:default;' class='page-link' href='#' onclick=clickPage('"+next+"') id='"+next+"'>Next</a></li>";
        }

        document.querySelector(load_hal).innerHTML = prev_hal+page+next_hal;
        
        
    }

    load('#load_content','#pagination_load','','');

    function clickPage(id){
        const search = document.querySelector('input[name=search]').value;
        load('#load_content','#pagination_load',search,id);
    }

    function search(id){
        load('#load_content','#pagination_load',id,'');
    }
    
</script>
@endsection