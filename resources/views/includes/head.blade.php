<meta charset="utf-8" />
<title>ITM Systems | @yield('title')</title>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
<meta content="" name="description" />
<meta content="" name="author" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- ================== BEGIN BASE CSS STYLE ================== -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
<link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet" />
<link href="/assets/css/bundle.css" rel="stylesheet" />
<link href="/assets/css/apple/style.min.css" rel="stylesheet" />
<link href="/assets/css/apple/style-responsive.min.css" rel="stylesheet" />
<link href="/assets/css/apple/theme/green.css" rel="stylesheet" id="theme" />
<link href="/css/itm_style.css" rel="stylesheet" />

<link href="/assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.css" rel="stylesheet" />
<!-- ================== END BASE CSS STYLE ================== -->

<!-- ================== BEGIN BASE JS ================== -->
<script src="/assets/plugins/pace/pace.min.js"></script>
<!-- ================== END BASE JS ================== -->


        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    

@stack('css')
