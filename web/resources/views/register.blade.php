<!DOCTYPE html>
<html lang="en">
    <head>
        <title>REGISTRASI FORM</title>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}"/>
        <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}"/>
        <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}"/>
        <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}"/>
        <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
    </head>
    <body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="{{ asset('assets/images/logo.svg') }}" alt="logo">
                            </div>
                            <h6 class="font-weight-light">Silahkan isi form berikut sesuai dengan data tempat usaha anda</h6>
                            <form class="pt-3" method="POST" action="{{ route('post.regis') }}" onsubmit="return register();" >
                                @csrf
                                <div class="form-group">
                                    <label for="name_location">Nama Brand / tempat usaha</label>
                                    <input type="text" id="name_location" name="name_location" class="form-control" maxlength="150" placeholder="Nama tempat usaha anda">
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat tempat usaha</label>
                                    <textarea name="alamat" id="alamat" cols="20" rows="10" class="form-control" placeholder="ALAMAT" maxlength="150"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="email">email</label>
                                    <input type="email" id="email" name="email" class="form-control" maxlength="100" placeholder="EMAIL">
                                </div>
                                <div class="form-group">
                                    <label for="no_telpon">Nomor Telepon / HP</label>
                                    <input type="text" id="no_telpon" name="no_telpon" class="form-control"  placeholder="NO. TELPON / HP" maxlength="14">
                                </div>
                                <div class="form-group">
                                    <label for="pos_code">Kode POS</label>
                                    <input type="text" id="pos_code" name="pos_code" class="form-control"  placeholder="KODE POS" maxlength="10">
                                </div>
                                <div class="form-group">
                                    <label for="user_id">User ID</label>
                                    <input type="text" id="user_id" name="user_id" class="form-control"  placeholder="Buat User id" maxlength="100">
                                </div>
                                <div class="form-group">                
                                    <label for="pass">Password</label>
                                    <input type="password" id="pass" name="pass" class="form-control"  placeholder="Buat Password" maxlength="100">
                                </div>
                                <div class="form-group">
                                    <label for="pass_again">Masukkan Kembali password</label>
                                    <input type="password" id="pass_again" name="pass_again" class="form-control"  placeholder="Password" maxlength="100">
                                </div>
                                <input type="hidden" id="code" name="code" maxlength="5" value="{{ helpers::buat_kode('tblprimary','P',5,0,'') }}">
                                <div class="form-check form-check-flat form-check-primary">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="cek" id="cek" class="form-check-input">
                                        Saya menyetujui semua Syarat & Ketentuan
                                    <i class="input-helper"></i></label>
                                </div>
                                <div class="mt-3">
                                <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">REGISTER</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>   
    <script type="text/javascript" src="{{ asset('assets/myjs/xhr.js') }}"></script>
    <script type="text/javascript">
             function register(){
            const pass1         = document.querySelector('input[name=pass]').value;
            const pass2         = document.querySelector('input[name=pass_again]').value;
            const chekcbox      = document.getElementById("cek");
            const nama_tempat   = document.querySelector('input[name=name_location]').value;
            const alamat        = document.querySelector('#alamat').value;
            const email         = document.querySelector('input[name=email]').value;
            const no_telp       = document.querySelector('input[name=no_telpon]').value;
            const kode_pos      = document.querySelector('input[name=pos_code]').value;
            const userId        = document.querySelector('input[name=user_id]').value;
            
            if(nama_tempat == ""){
                alert('Nama tempat / lokasi Tidak boleh kosong');
                document.querySelector('input[name=name_location]').focus();
                return false;
            }else if(alamat == ""){
                alert('Alamat tidak boleh kosong');
                document.querySelector('#alamat').focus();
                return false;
            }else if(email == ""){
                alert('email tidak boleh kosong');
                document.querySelector('input[name=email]').focus();
                return false;
            }else if(userId == ""){
                alert('User Id tidak boleh kosong');
                document.querySelector('input[name=user_id]').focus();
                return false;
            }else if(pass1 == ""){
                alert('Password tidak boleh kosong');
                document.querySelector('input[name=pass]').focus();
                return false;
            }else if(chekcbox.checked === false){
                alert('Anda Belum mencentang persetujuan');
                return false;
            }else if(pass1 != pass2){
                alert('Periksa kembali password yang anda masukkan');
                return false;
            }else if(no_telp == ""){
                alert('No Telpon / HP tidak boleh kosong');
                document.querySelector('input[name=no_telpon]').focus();
                return false;
            }else if(kode_pos == ""){
                alert('Kode Pos tidak boleh kosong');
                document.querySelector('input[name=pos_code]').focus();
                return false;
            }
            else{
                return true;
            }
        }
    </script> 
    </body>
</html>