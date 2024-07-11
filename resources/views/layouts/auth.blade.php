<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    
    <link rel="icon" href="{{$companySetting->favicon_url}}" type="image/x-icon"/>
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    <title>{{ $setting->company_name }}</title>

    <style>
        :root {
            --main-color: {{ $frontTheme->primary_color }};
        }

    </style>
    <!-- page css -->
    <link href="{{ asset('assets/dist/css/adminlte.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/iCheck/square/blue.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="hold-transition login-page" style="background-image:url({{ asset('assets/images/background/auth.jpg') }})">

<div class="login-box" >
    <div class="login-logo" style="padding: 10px 0; background: var(--main-color);">
        <a href="#" >
            <img src="{{ $setting->logo_url }}" style="max-height: 40px" alt="">
        </a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">

            @yield('content')
            <div class="form-actions  pt-3">
                <a href="{{route('jobs.jobOpenings')}}" class="btn btn-sm btn-block btn-rounded btn-outline-success text-uppercase">{{__('messages.VisitJobOpening')}}</a>
            </div>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>


<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{ asset('assets/node_modules/jquery/jquery-3.2.1.min.js') }}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('assets/node_modules/popper/popper.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>
<!--Custom JavaScript -->
<script type="text/javascript">
    $(function() {
        // $(".preloader").fadeOut();
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
        })
    });
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    });
    // ==============================================================
    // Login and Recover Password
    // ==============================================================
    $('#to-recover').on("click", function() {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
</script>

</body>

</html>