@if(Session::get('userId') == "")
<script>window.location.href="{{ route('logout') }}"</script>
@elseif(Session::get('userId') != "" && Session::get('verify_at') != NULL)
<script>window.location.href="{{ route('home') }}"</script>
@endif
<!DOCTYPE HTML>
<html>
    <head>
        <title>verifycation notice</title>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- plugins:css -->
        <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
        <!-- endinject -->
        <link rel="stylesheet" href="{{ asset ('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
        <link rel="stylesheet" href="{{ asset ('assets/vendors/ti-icons/css/themify-icons.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/js/select.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
        <!-- endinject -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
    </head>
    <body>
        <div class=" container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="main-panel w-100  documentation">
                    <div class="content-wrapper">
                        <div class="container-fluid">
                            <div class="row pt-5 mt-5">
                                <div class="col-12 pt-5 text-center">
                                    <i class="text-primary mdi mdi-file-document-box-multiple-outline display-1"></i>
                                    <h3 class="text-primary font-weight-light mt-5">
                                    Email Anda Belum Ter verifykasi, Silahkan Verifykasi Email anda terlebih dahulu untuk menggunakan layanan di website kami
                                    </h3>
                                    <h4 class="mt-4 font-weight-light text-primary">
                                    Silahkan clik tombol dibawah ini untuk verifykasi email 
                                    </h4>
                                    <a href="{{ route('sendEmail_verify') }}" class="btn btn-primary">VERIFY EMAIL</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- FOOTER -->
                    <footer class="footer">
                            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Jika Ada keluhan silahkan hubungi Kami di : 082</span>
                                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
                            </div>
                    </footer>
                    <!-- FOOTER-->
                </div>
            </div>
        </div>
    </body>
</html>