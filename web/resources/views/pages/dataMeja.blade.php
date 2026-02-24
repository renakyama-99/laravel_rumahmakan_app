@if(Session::get('level') != "admin")
<script>window.location.href="{{route('home')}}";</script>
@endif
@extends('home')
@section('header', 'MANAGEMENT DATA MEJA')
@section('content')
<div class="row">
<div class="cm-spinner" style="display: none"></div>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card position-relative">
            <div class="card-body">
                <p class="card-title">Form Meja</p>
                <br>
            <form class="forms-sample">
                <div class="form-group row">
                    <label for="kode_temp" class="col-sm-4 col-form-label">Kode Tempat</label>
                    <div class="col-sm-4">
                            <div class="input-group-append">
                                <span class="input-group-text bg-primary text-white"><i class="mdi mdi-archive"></i></span>
                                <input type="text" class="form-control form-control-lg" id="kode_tempat" name="kode_tempat" readonly value="{{ Session::get('kodeTemp') }}">
                            </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nomor_meja" class="col-sm-4 col-form-label" >No meja</label>
                    <div class="col-sm-4">
                        <div class="input-group-append">
                                <span class="input-group-text bg-primary text-white"><i class="mdi mdi-format-strikethrough-variant"></i></span>
                                <input type="text" class="form-control form-control-lg" id="no_meja" name="no_meja" maxlength="3" placeholder="Masukkan Nomor meja">
                            </div>
                    </div>
                </div>
                <input type="hidden" class="form-control form-control-lg" id="kode_meja" name="kode_meja" value="{{ helpers::buat_kode('tabel_meja',Session::get('kodeTemp').'M',9,1,'kode_temp') }}">
                
                </form>
                <button class="btn btn-info" type="button" onclick="simpan_meja()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card position-relative">
            <div class="card-body">
                <p class="card-title">List Meja</p>
                <br>
                <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>no</td>
                                <td>Nomor Meja</td>
                                <td colspan="2">action</td>
                            </tr>
                        </thead>
                        <tbody id="loadMeja">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script_footer')
<script type="text/javascript" src="{{ asset('assets/myjs/xhr.js') }}"></script>
<script type="text/javascript">
    function simpan_meja(){0
        const kode_temp = document.querySelector('input[name=kode_tempat]').value;
        const kode_meja = document.querySelector('input[name=kode_meja]').value;
        const no_meja   = document.querySelector('input[name=no_meja]').value;
        const link      = "{{ route('post.meja') }}";
        if(no_meja == ""){
            document.querySelector('input[name=no_meja]').focus();
            Swal.fire({
                title : 'Pesan',
                text  : 'Nomor Meja Tidak boleh kosong',
                icon  : 'warning',

        });
        
        }else{
            let fmData = new FormData();
            fmData.append('action' , 'saveData');
            fmData.append('kodeTemp' , kode_temp);
            fmData.append('kodeMeja' , kode_meja);
            fmData.append('noMeja' , no_meja);
            xml.open('POST',link,true);
            xml.setRequestHeader('enctype','multipart/form-data');
            xml.setRequestHeader("X-CSRF-TOKEN",token);
            xml.onreadystatechange = function(){
            if(xml.readyState == 4 && xml.status == 200){
                const respon = xml.responseText;
                if(respon == "berhasil"){
                    location.reload();
                }else{
                    alert('gagal');
                }
            }
        }
        xml.send(fmData);
        }

    }

    function load_meja(){
        const kode_temp = "{{ Session::get('kodeTemp') }}";
        let fData = new FormData();
        fData.append('action', 'load');
        fData.append('kode_temp', kode_temp);
        const link = "{{ route('post.meja') }}";
        xml.open('POST', link, true);
        xml.setRequestHeader('enctype', 'multipart/form-data');
        xml.setRequestHeader('X-CSRF-TOKEN', token);
        xml.onreadystatechange = function(){
            if(xml.readyState == 4 && xml.status == 200){
                const respon = xml.responseText;
                const jsn    = JSON.parse(respon);
                let nomor  = 1;
                let buatTabel = "";
                for(let i = 0; i < jsn.dataTable.length; i++){
                    buatTabel += "<tr>"+
                    "<td>"+nomor+"</td>"+
                    "<td>"+jsn.dataTable[i][2]+"</td>"+
                    "<td><a onclick='deleteMeja(/"+jsn.dataTable[i][1]+"/)'><i class='mdi mdi-delete mb-0 ml-1'></i></a></td>"+
                    "</tr>";
                   nomor++;
                }
                document.getElementById('loadMeja').innerHTML = buatTabel;
            }
        }
        xml.send(fData);
    }

    function deleteMeja(id){
        swal.fire({
            title               : 'anda Yakin akan menghapus data ini ?',
            showCancelButton    : true,
            showConfirmButton   : true,
            confirmButtonText   : 'delete',
            cancelButtonText    : 'cancel'
        }).then((result) => {
            if(result.isConfirmed){
                document.querySelector('.cm-spinner').style.display = "block";
                let rep         = String(id);
                const idDel     = rep.replaceAll('/','');
                const kode_temp = "{{ Session::get('kodeTemp') }}";
                const link      = "{{route('post.meja')}}";
                let fData       = new FormData();
                fData.append('action','delete');
                fData.append('id',idDel);
                fData.append('kodeTemp',kode_temp);
                xml.open('POST',link,true);
                xml.setRequestHeader('enctype', 'multipart/form-data');
                xml.setRequestHeader('X-CSRF-TOKEN',token);
                xml.onreadystatechange = function(){
                    if(xml.readyState == 4 && xml.status == 200){
                        const respon = xml.responseText;
                        if(respon == "berhasil"){
                            Swal.fire('Berhasil dihapus', '', 'success')
                            document.querySelector('.cm-spinner').style.display = "none";
                            load_meja();
                        }else if(respon == "gagal"){
                            document.querySelector('.cm-spinner').style.display = "none";
                            Swal.fire('data gagal dihapus', '', 'info')
                        }
                    }
                }
                xml.send(fData);
            }
        });

    }

    load_meja();
</script>
@endsection