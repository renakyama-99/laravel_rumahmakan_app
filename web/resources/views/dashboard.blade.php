@if(Session::get('userId') == "" && Session::get('email') == "")
<script>window.location.href="{{route('home')}}";</script>
@endif
@extends('home')
@section('header', 'DASHBOARD')
@section('content')
@foreach ($data As $index => $value)
<div class="row">
    <div class="col-md-6 mb-4 stretch-card transparent">
        <div class="card card-light-danger">
            <div class="card-body">
                <p class="mb-4">Nama Usaha/tempat usaha</p>
                <p class="mb-4">{{ $value->nama_temp}}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4 stretch-card transparent">
        <div class="card card-dark-blue">
            <div class="card-body">
                <p class="mb-4">Alamat</p>
                <p class="mb-4">{{ $value->alamat }}</p>
                <p class="mb-4">{{ $value->no_telpon }}</p>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection