<!DOCTYPE HTML>
<html>
    <head>
        <title>Message</title>
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
    @foreach((array)$token as $tkn)
    <div class=" container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="main-panel w-100  documentation">
                    <div class="content-wrapper">
                        <div class="container-fluid">
                            <div class="row pt-5 mt-5">
                                <div class="col-12 pt-5 text-center">
                                    <i class="text-primary mdi mdi-file-document-box-multiple-outline display-1"></i>
                                    <h4 class="mt-4 font-weight-light text-primary">
                                    VERIFYKASI SUCCESS silahkan <a href="{{ route('login') }}">Login</a> 
                                    </h4>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- FOOTER -->
                    <footer class="footer">
                            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">{{ $tkn }}</span>
                                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
                            </div>
                    </footer>
                    <!-- FOOTER-->
                </div>
            </div>
        </div>
        @endforeach
    </body>
</html>