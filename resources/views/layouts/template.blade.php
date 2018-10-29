<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sties</title>
    <!-- Bootstrap Styles-->
    <link href="{{ asset('templates/assets/css/bootstrap.css') }}" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="{{ asset('templates/assets/css/font-awesome.css') }}" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="{{ asset('templates/assets/js/morris/morris-0.4.3.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/jasny-bootstrap/jasny-bootstrap.min.css') }}" rel="stylesheet" />
    

    <link href="{{ asset('plugins/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="{{ asset('templates/assets/css/custom-styles.css') }}" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="{{ asset('templates/assets/js/Lightweight-Chart/cssCharts.css') }}">

    @yield('custom_css') 
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('templates/img/logo11.png') }}" width="165px"></a>
            </div>

            <ul class="nav navbar-top-links navbar-right">

                <!-- /.dropdown -->
                
                <!-- /.dropdown -->
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="{{ asset('templates/#') }}" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{ route('profil.index') }}"><i class="fa fa-user fa-fw"></i> Profil</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{ route('logout') }}"
                         onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                         <i class="fa fa-sign-out fa-fw"></i> Logout</a>

                         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
    </nav>
    <!--/. NAV TOP  -->
    @include('layouts.partial.navbar')
    <!-- /. NAV SIDE  -->

    <div id="page-wrapper">
        @yield('content')

        <!-- /. PAGE INNER  -->
        <footer><p>All right reserved. Template by: <a href="http://webthemez.com">WebThemez</a></p></footer>

    </div>

    <!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->
<!-- JS Scripts-->
<!-- jQuery Js -->
<script src="{{ asset('plugins/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap Js -->
<script src="{{ asset('templates/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>


<script src="{{ asset('plugins/jasny-bootstrap/jasny-bootstrap.min.js') }}"></script>
<!-- Metis Menu Js -->
<script src="{{ asset('templates/assets/js/jquery.metisMenu.js') }}"></script>
<!-- Morris Chart Js -->
<script src="{{ asset('templates/assets/js/morris/raphael-2.1.0.min.js') }}"></script>
<script src="{{ asset('templates/assets/js/morris/morris.js') }}"></script>


<script src="{{ asset('templates/assets/js/easypiechart.js') }}"></script>
<script src="{{ asset('templates/assets/js/easypiechart-data.js') }}"></script>

<script src="{{ asset('templates/assets/js/Lightweight-Chart/jquery.chart.js') }}"></script>
<script src="{{ asset('/plugins/axios/dist/axios.min.js') }}"></script>
<script src="{{ asset('/plugins/vue/dist/vue.min.js') }}"></script>
<script src="{{ asset('/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
<script src="{{ asset('/plugins/ckeditor/ckeditor.js') }}"></script>

<!-- Custom Js -->
<script src="{{ asset('templates/assets/js/custom-scripts.js') }}"></script>

@yield('custom_js')

</body>

</html>