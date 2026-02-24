@if(Session::get('level') != "admin")
<script>window.location.href="{{route('home')}}";</script>
@endif
@extends('home')
@section('header', 'Edit Item')
@section('content')
<div class="row">
    <div class="cm-spinner" style="display: none"></div>
    @foreach($data as $val)
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Form Edit Item</h4>
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label for="code_item" class="form-control-label">Kode Item</label>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="mdi mdi-dumbbell"></i>
                                    </span>
                                    <input type="text" class="form-control" id="code_item" value="{{ $val->kode_item }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label for="item_name" class="form-control-label">Nama Item</label>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="mdi mdi-bone"></i>
                                    </span>
                                    <input type="text" class="form-control" id="item_name" value="{{ $val->nama_item }}">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label for="jenis_item" class="form-control-label">Jenis</label>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="mdi mdi-arrow-down-drop-circle"></i>
                                    </span>
                                    <select class="form-control" name="jenis" id="jenis">
                                            <option value="">Pilih Jenis</option>
                                            @php
                                                $arr_jenis = array("makanan","minuman");
                                                $db_jenis  = $val->jenis;
                                                foreach($arr_jenis As $jenis){
                                                    if($jenis == $db_jenis){
                                                        $cek = "selected";
                                                    }else{
                                                        $cek = "";
                                                    }
                                                    echo "<option value='$jenis' $cek>$jenis</option>";
                                                }
                                            @endphp
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label for="file" class="form-control-label">Gambar Produk</label>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="mdi mdi-file-image"></i>
                                        <input type="file" name="img_update" id="img_update" class="form-control-file"/>
                                    </span>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 col-form-label" for="stock">stock</label>  
                            <div class="col-sm-4">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-primary text-white"><i class="mdi mdi-format-vertical-align-center"></i></span>
                                    <input type="number" class="form-control form-control-lg" value="{{ $val->stok }}" id="stock" name="stock" placeholder="jumlah stock" maxlength="4">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 col-form-label" for="harga_jual">Harga</label>
                            <div class="col-sm-4">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-primary text-white"><i class="mdi mdi-coin">Rp</i></span>
                                    <input type="number" maxlength="7" value="{{ $val->harga }}" class="form-control form-control-lg" id="harga_jual" name="harga_jual" placeholder="Harga">                                              
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 col-form-label" for="diskon">Diskon</label>
                            <div class="col-sm-3">
                                <div class="input-group-append">
                                    <input type="number" maxlength="3"  value="{{ $val->diskon }}" class="form-control form-control-lg" id="diskon" name="diskon" placeholder="Diskon">
                                    <span class="input-group-text bg-primary text-white"><i class="mdi mdi-percent"></i></span>
                                </div>                                
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 col-form-label" for="type">Type</label>
                            <div class="col-sm-3">
                                <div class="input-group-append">
                                    <select name="type" id="type" class="form-control">
                                        @php
                                            $arrType = array('satuan','paket');
                                            $dbType  = $val->type;
                                            foreach($arrType As $type){
                                                if($type == $dbType){
                                                    $cek = "selected";
                                                }else{
                                                    $cek = "";
                                                }
                                                echo "<option value='$type' $cek>$type</option>";
                                            }
                                        @endphp
                                    </select>    

                                </div>
                            </div>

                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-primary btn-icon-text" name="simpan" id="simpan" onClick="save()">
                                <i class="ti-file btn-icon-prepend"></i>
                                Submit
                            </button>                  
                         </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <img style="height:auto; width:100%;" class="card-img-top img-fluid" src="{{ asset('folderUser')}}/{{Session::get('kodeTemp')}}/{{$val->nama_file}}?t=={{ time()}}" alt="gambar item">
                <div cclass="card-body">

                </div>
            </div>   
        </div>

    @endforeach
</div>
@endsection

@section('script_footer')
<script type="text/javascript" src="{{ asset('assets/myjs/xhr.js') }}"></script>
<script type="text/javascript">
    const save = () => {
        const kode_item = document.querySelector('#code_item').value;
        const nama_item = document.querySelector('#item_name').value;
        const jenis     = document.querySelector('#jenis').value;
        let file        = document.querySelector('input[name=img_update]').files[0];
        const stok      = document.querySelector('#stock').value;
        const harga     = document.querySelector('#harga_jual').value;
        const diskon    = document.querySelector('#diskon').value;
        const type      = document.querySelector('#type').value;
        let namaFile    = "{{$val->nama_file}}";
         if(jenis == ""){
            alert('Jenis tidak boleh kosong');     
            document.querySelector('#jenis').focus();
            return false;      
        }

        if(nama_item == ""){
            alert('Nama Item tidak boleh kosong');
            document.querySelector('#item_name').focus();
            return false;
        }

        if(stok == ""){
            alert('Stok harus Di isi');
            document.querySelector('#stock').focus();
            return false;
        }

        if(harga == ""){
            alert('Harga Jual harus Di isi');
            document.querySelector('#harga_jual').focus();
            return false;
        }

        if(diskon == ""){
            alert('Diskon harus Di isi');
            document.querySelector('#diskon').focus();
            return false;
        }
                let frmData = new FormData();
                document.querySelector('.cm-spinner').style.display = "block";
                frmData.append('action', 'update');
                frmData.append('kode_item', kode_item);
                frmData.append('jenis', jenis);
                frmData.append('nama_item', nama_item);
                frmData.append('file', file);
                frmData.append('stok', stok);
                frmData.append('harga', harga);
                frmData.append('diskon', diskon);
                frmData.append('type', type);
                frmData.append('filename',namaFile);
                const link  = "{{route('post.actionMenu')}}";
                xml.open('POST',link,true);
                xml.setRequestHeader('enctype','multipart/form-data');
                xml.setRequestHeader('X-CSRF-TOKEN',token);
                xml.onreadystatechange = function(e) {
                    if(xml.status == 200 && xml.readyState == 4){
                        let response = xml.responseText;
                        if(response == "extensi file salah"){
                            document.querySelector('.cm-spinner').style.display = "none";
                            Swal.fire({
                            icon  : "error",
                            title : "oops",
                            text  : "extensi File yang di upload tidak sesuai"
                         });
                        }else if(response == "update berhasil"){
                            document.querySelector('.cm-spinner').style.display = "none";
                            Swal.fire({
                                icon: "success",
                                title: "Data Berhasil di update",
                                showConfirmButton: true,
                                
                            }).then((result) => {
                                if(result.isConfirmed){
                                    location.reload();
                                }
                            });
                        }else{
                            document.querySelector('.cm-spinner').style.display = "none";
                            Swal.fire({
                                icon  : "error",
                                title : "oops",
                                text  : "GAGAL Meng UPDATE"
                            });
                        }
                    }
                }
                xml.send(frmData);
    }
</script>
@endsection