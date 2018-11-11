
<!--
*
*  INSPINIA - Responsive Admin Theme
*  version 2.7
*
-->

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <title>STIES</title>
    <link rel="icon" href="{{ asset('templates/img/logo-1.png') }}">

    <link href="{{ asset('templates/inspinia_271/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('templates/inspinia_271/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <!-- Toastr style -->
    <link href="{{ asset('templates/inspinia_271/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

    <!-- Gritter -->
    <link href="{{ asset('templates/inspinia_271/js/plugins/gritter/jquery.gritter.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/DataTables/datatables.min.css') }}" rel="stylesheet">

    <link href="{{ asset('plugins/jasny-bootstrap/jasny-bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/iziModal/css/iziModal.min.css') }}" rel="stylesheet" />
    

    <link href="{{ asset('templates/inspinia_271/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('templates/inspinia_271/css/style.css') }}" rel="stylesheet">
    @yield('custom_css')
</head>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            @include('layouts.new_partials/sidebar')
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top black-bg" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                      {{--   <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a> --}}

                      <form class="navbar-form-custom">
                        <a class="navbar-brand-img" href="{{ url('/') }}"><img style="width: 100%; height: 100%" src="{{ asset('templates/img/logo11.png') }}"></a>
                    </form>

                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <span class="m-r-sm text-muted welcome-message"></span>
                    </li>


                    <li>
                        <a onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>

        </nav>
    </div>
    {{-- @yield('page-heading') --}}
    <div class="wrapper wrapper-content">
        @yield('content')
    </div>
    <div class="footer">
        <div class="pull-right">
        </div>
        <div>
            <strong>Copyright</strong> Example Company &copy; 2014-2017
        </div>
    </div>

</div>



</div>

<!-- Mainly scripts -->
<script src="{{ asset('templates/inspinia_271/js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('templates/inspinia_271/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('templates/inspinia_271/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('templates/inspinia_271/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>



{{--  --}}
<!-- Custom and plugin javascript -->
<script src="{{ asset('templates/inspinia_271/js/inspinia.js') }}"></script>
<script src="{{ asset('templates/inspinia_271/js/plugins/pace/pace.min.js') }}"></script>
<script src="{{ asset('/plugins/axios/dist/axios.min.js') }}"></script>
<script src="{{ asset('/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
<script src="{{ asset('/plugins/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('plugins/jasny-bootstrap/jasny-bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/iziModal/js/iziModal.min.js') }}"></script>


<!-- jQuery UI -->
<script src="{{ asset('templates/inspinia_271/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>

</script>
@yield('custom_js')
</body>
</html>
