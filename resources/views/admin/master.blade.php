<!DOCTYPE html>
<html>
<head>
    {{-- <title>{{Voyager::setting('admin_title')}} - {{Voyager::setting('admin_description')}}</title> --}}
    <title>@yield('page_title', 'admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?= csrf_token() ?>"/>
    <!-- Fonts -->
    <!--
    <link href='//fonts.useso.com/css?family=Roboto+Condensed:300,400|Lato:300,400,700,900' rel='stylesheet'
          type='text/css'>
     -->

    <!-- CSS Libs -->
    <link rel="stylesheet" type="text/css" href="{!! asset('/lib/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('/lib/css/animate.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('/lib/css/bootstrap-switch.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('/lib/css/checkbox3.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('/lib/css/jquery.dataTables.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('/lib/css/dataTables.bootstrap.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('/lib/css/select2.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('/lib/css/toastr.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('/css/bootstrap-toggle.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('/js/icheck/icheck.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('/js/datetimepicker/bootstrap-datetimepicker.min.css') !!}">
    <!-- CSS App -->
    <link rel="stylesheet" type="text/css" href="{!! asset('/css/style.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('/css/themes/flat-blue.css') !!}">

    <!--
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,300italic">
    -->

    <!-- Favicon -->
    <link rel="shortcut icon" href="{!! asset('/images/logo-icon.png') !!}" type="image/x-icon">

    <!-- CSS Fonts -->
    <link rel="stylesheet" href="{!! asset('/fonts/voyager/styles.css') !!}">
    <script type="text/javascript" src="{!! asset('/lib/js/jquery.min.js') !!}"></script>
    <!--
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/themes/smoothness/jquery-ui.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
    -->
    <script type="text/javascript" src="{!! asset('/js/vue.min.js') !!}"></script>

    @yield('css')

<!-- Voyager CSS -->
    <link rel="stylesheet" href="{!! asset('/css/voyager.css') !!}">

    @yield('head')

</head>

<body class="flat-blue">

<div id="voyager-loader">
    <img src="{!! asset('/images/logo-icon.png') !!}" alt="Voyager Loader">
</div>

<?php
if ((substr(Auth::user()->avatar, 0, 7) == 'http://') || (substr(Auth::user()->avatar, 0, 8) == 'https://')) {
    $user_avatar = Auth::user()->avatar;
}
$menuExpanded = isset($_COOKIE['expandedMenu']) && $_COOKIE['expandedMenu'] == 1;
?>

<div class="app-container @if ($menuExpanded) expanded @endif ">
    <div class="row content-container">
    @include('admin.dashboard.navbar')
    @include('admin.dashboard.sidebar')
    <!-- Main Content -->
        <div class="container-fluid">
            <div class="side-body padding-top">
                @yield('page_header')
                @yield('content')
            </div>
        </div>
    </div>
</div>
<footer class="app-footer">
    <div class="site-footer-right">
       version 0.1
    </div>
</footer>
<!-- Javascript Libs -->

<script type="text/javascript" src="{!! asset('/lib/js/bootstrap.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('/lib/js/bootstrap-switch.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('/lib/js/jquery.matchHeight-min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('/lib/js/jquery.dataTables.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('/lib/js/dataTables.bootstrap.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('/lib/js/select2.full.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('/js/bootstrap-toggle.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('/js/jquery.cookie.js') !!}"></script>
<script type="text/javascript" src="{!! asset('/js/moment-with-locales.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('/js/datetimepicker/bootstrap-datetimepicker.min.js') !!}"></script>
<!-- Javascript -->

<script type="text/javascript" src="{!! asset('/js/readmore.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('/js/app.js') !!}"></script>
<script type="text/javascript" src="{!! asset('/lib/js/toastr.min.js') !!}"></script>
<script>
            @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch (type) {
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    @endif
</script>
@yield('javascript')
</body>
</html>
