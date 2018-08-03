<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="{{ app()->getLocale() }}"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <title>{{ config('app.trainerpaneltitle') }}</title> -->
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" href="{{ asset('backend/apple-icon.png')}}">
    <link rel="shortcut icon" href="{{ asset('backend/favicon.ico')}}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/cs-skin-elastic.css') }}">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="{{ asset('backend/assets/scss/style.css')}}">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <script src="{{asset('backend/assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('backend/assets/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('backend/assets/js/additional-methods.js')}}"></script>
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

    <link rel="stylesheet" href="{{ asset('backend/assets/css/totancss/style.css') }}">
  

</head>
<body class="bg-dark">


    @yield('content')


    <script src="{{ asset('backend/assets/js/vendor/jquery-2.1.4.min.js')}}"></script>
    <script src="{{ asset('backend/assets/js/popper.min.js')}}"></script>
    <script src="{{ asset('backend/assets/js/plugins.js')}}"></script>
    <script src="{{ asset('backend/assets/js/main.js')}}"></script>


</body>
</html>