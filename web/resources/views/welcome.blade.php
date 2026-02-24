<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}"/>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}" />
        <title>Login page</title>
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
                        <h4>Hello! let's get started</h4>
                        <h6 class="font-weight-light">Sign in to continue.</h6>
                        <form class="pt-3" method="POST" action="{{ route('pos.login') }}" onsubmit="return loginProgress();" >
                            @csrf
                            <div class="form-group">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-primary text-white"><i class="mdi mdi-account"></i></span>
                                    <input type="text" class="form-control form-control-lg" id="userId" name="userId" placeholder="User ID">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-primary text-white"><i class="mdi mdi-key"></i></span>
                                    <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="password" autocomplete="off">
                                </div>
                            </div>
                            <div class="mt-3">
                                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">LOG IN</button>
                            </div>
                            <div class="text-center mt-4 font-weight-light">
                                Belum Punya akun? Silahkan <a class="text-primary" href="/register">register</a>
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
        
            function loginProgress(){
                const user = document.querySelector('input[name=userId]').value;
                const pass = document.querySelector('input[name=password]').value;
                if(user == ""){
                    alert('user id tidak boleh kosong');
                    document.querySelector('input[name=userId]').focus();
                    return false;
                }else if(pass == ""){
                    alert('password tidak boleh kosong');
                    document.querySelector('input[name=password]').focus;
                    return false;
                }else{
                    return true;
                }
         
         }
    </script>
</body>
</html>
