<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('site/layouts/css/master.css')}}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="shortcut icon" href="{{ asset(env('logo')) }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{asset('admin/layouts/plugins/overlayScrollbars/css/OverlayScrollbars.css')}}">
    <link rel="stylesheet" href="{{asset('admin/layouts/plugins/toastr/toastr.min.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:100,400,600">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Exo&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quattrocento&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
    <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"
/>    <link rel="shortcut icon" href="{{ App\Helper\Configs::getConfigLogo() }}">
    <script type="module" src="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.13.1/cdn/shoelace.js"></script>

    @stack('style')
    @livewireStyles

</head>
<!doctype html>
<html lang="pt-br">


<body class="layout-top-nav">

<div class="wrapper">
    @include('site.layouts.navbar')

    <div class="content-wrapper">
        @yield('content')
    </div>

    @include('admin.layouts.assets.footer')


</div>
<script src="{{asset('site/layouts/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('site/layouts/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('site/layouts/js/master.js')}}"></script>


<script src="{{asset('admin/layouts/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('admin/layouts/plugins/overlayScrollbars/js/OverlayScrollbars.js')}}"></script>
<script src="{{asset('admin/layouts/plugins/toastr/toastr.min.js')}}"></script>
<script src="{{asset('admin/layouts/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/layouts/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
   toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

</script>
@stack('scripts')
@livewireScripts




</body>

</html>
