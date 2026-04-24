@if(Session::get('userId') == "" && Session::get('email') == "")
<script>window.location.href="{{route('dashboard')}}";</script>
@endif