@if(Session::get('level') != "admin")
<script>window.location.href="{{route('dashboard')}}";</script>
@endif
@extends('home')
@section('header' , 'Halaman Item')
@section('content')
<div class="row">
    <div class="cm-spinner" style="display: none"></div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">FORM INPUT</h4>
                
                <form class="form-sample" action="">
                    <div class="form-group row"> 
                        <label for="kode_item" class="col-sm-3 col-form-label">Kode Item</label>
                        <div class="col-sm-4">
                            <div class="input-group-append">
                                <span class="input-group-text bg-primary text-white"><i class="mdi mdi-code-tags"></i></span>
                                <input type="text" class="form-control form-control-lg" readonly="true" id="kode_item" name="kode_item" maxlength="3" placeholder="Masukkan kode item" value="{{helpers::buat_kode('tabel_item',Session::get('kodeTemp').'A',12,1,'kode_temp')}}">
                            </div>
                        </div>
                    </div>

                    <div  class="form-group row">
                        <label for="jenis_item" class="col-sm-3 col-form-label">Jenis</label>
                        <div class="col-sm-4">
                            <div class="input-group-append"> 
                            <span class="input-group-text bg-primary text-white"><i class="mdi mdi-code-greater-than"></i></span>
                            <select name="jenis_item" id="jenis_item" class="form-control form-control-lg">
                                <option value="">Pilih Jenis</option>
                                <option value="makanan">makanan</option>
                                <option value="minuman">minuman</option>
                            </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="nama_item">Nama Item</label>
                        <div class="col-sm-4">
                            <div class="input-group-append">
                                <span class="input-group-text bg-primary text-white"><i class="mdi mdi-food"></i></span>
                                <input type="text" class="form-control form-control-lg" id="nama_item" name="nama_item" placeholder="Nama makanan/minuman" maxlength="100">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="file">File/Gambar</label>
                        <div class="col-sm-4">
                            <div class="input-group-append">
                            <span class="input-group-text bg-primary text-white">
                                <i class="mdi mdi-file-image"></i>
                                <input type="file" class="form-control-file" name="file_gambar" id="file_gambar">
                            </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="stock">stock</label>  
                        <div class="col-sm-3">
                            <div class="input-group-append">
                                <span class="input-group-text bg-primary text-white"><i class="mdi mdi-format-vertical-align-center"></i></span>
                                <input type="number" class="form-control form-control-lg" id="stock" name="stock" placeholder="jumlah stock" maxlength="4">
                            </div>
                        </div>         
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="harga_jual">Harga</label>
                        <div class="col-sm-4">
                            <div class="input-group-append">
                                <span class="input-group-text bg-primary text-white"><i class="mdi mdi-coin">Rp</i></span>
                                <input type="number" maxlength="7"  class="form-control form-control-lg" id="harga_jual" name="harga_jual" placeholder="Harga">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="diskon">Diskon</label>
                        <div class="col-sm-3">
                            <div class="input-group-append">
                                <input type="number" maxlength="3" class="form-control form-control-lg" id="diskon" name="diskon" placeholder="Diskon">
                                <span class="input-group-text bg-primary text-white"><i class="mdi mdi-percent"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="type">Type</label>
                        <div class="col-sm-3">
                            <div class="input-group-append">
                                <span class="input-group-text bg-primary text-white"><i class="mdi mdi-format-list-bulleted-type"></i></span>
                                <select name="type" id="type" class="form-control form-control-lg">
                                        <option value="satuan">satuan</option>
                                        <option value="paket">paket</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary btn-icon-text" name="simpan" id="simpan" onClick="save()">
                                <i class="ti-file btn-icon-prepend"></i>
                                Submit
                            </button>

                            <button type="reset" class="btn btn-warning btn-icon-text">
                                <i class="ti-reload btn-icon-prepend"></i>                                                    
                                Reset
                            </button>
                        </div>
                    </div>
              

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script_footer')
<script type="text/javascript" src="{{ asset('assets/myjs/xhr.js') }}"></script>
<script type="text/javascript">
    function save(){
        const kode_item = document.querySelector('input[name=kode_item]').value;
        const jenis     = document.querySelector('select[name=jenis_item]').value;
        const nama_item = document.querySelector('input[name=nama_item]').value;
        let file        = document.querySelector('input[name=file_gambar]').files[0];
        const stok      = document.querySelector('input[name=stock]').value;
        const harga     = document.querySelector('input[name=harga_jual]').value;
        const diskon    = document.querySelector('input[name=diskon]').value;
        const type      = document.querySelector('select[name=type]').value;

        if(jenis == ""){
            alert('Jenis tidak boleh kosong');     
            document.querySelector('select[name=jenis_item]').focus();
            return false;      
        }

        if(nama_item == ""){
            alert('Nama Item tidak boleh kosong');
            document.querySelector('input[name=nama_item]').focus();
            return false;
        }

        if(document.querySelector('input[name=file_gambar]').files.length == 0){
            alert('File harus Di isi');
            document.querySelector('input[name=file_gambar]').focus();
            return false;
        }

        if(stok == ""){
            alert('Stok harus Di isi');
            document.querySelector('input[name=stock]').focus();
            return false;
        }

        if(harga == ""){
            alert('Harga Jual harus Di isi');
            document.querySelector('input[name=harga_jual]').focus();
            return false;
        }

        if(diskon == ""){
            alert('Diskon harus Di isi');
            document.querySelector('input[name=diskon]').focus();
            return false;
        }

        let frmData = new FormData();
        document.querySelector('.cm-spinner').style.display = "block";
        frmData.append('action', 'save');
        frmData.append('kodeItem', kode_item);
        frmData.append('jenis_item', jenis);
        frmData.append('nama_item', nama_item);
        frmData.append('file', file);
        frmData.append('stok', stok);
        frmData.append('harga', harga);
        frmData.append('disc', diskon);
        frmData.append('tipe', type);
        const link = "{{route('post.actionMenu')}}";
        xml.open('POST',link,true);
        xml.setRequestHeader('enctype','multipart/form-data');
        xml.setRequestHeader('X-CSRF-TOKEN',token);
        xml.onreadystatechange = function(e){
            if(xml.status==200 && xml.readyState == 4){
                    const respon = xml.responseText;
                    if(respon == "extension salah"){
                        document.querySelector('.cm-spinner').style.display = "none";
                        Swal.fire({
                            icon  : "error",
                            title : "oops",
                            text  : "extensi File yang di upload tidak sesuai"
                        });
                    }else if(respon == "berhasil"){
                        document.querySelector('.cm-spinner').style.display = "none";
                        Swal.fire({
                                icon: "success",
                                title: "Data Berhasil disimpan",
                                showConfirmButton: true,
                                
                        }).then((result) => {
                            if(result.isConfirmed){
                                location.reload();
                            }
                        });
                        
                    }else{
                        alert('gagal menyimpan');
                    }
            }
        }
        xml.send(frmData);
    }
</script>
@endsection