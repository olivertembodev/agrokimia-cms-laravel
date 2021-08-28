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
    <link rel="icon" type="image/png" sizes="16x16" href="{{URL::asset('assets')}}/images/favicon.png">
    <title>Agro Kimia Dashboard</title>
    <!-- This page CSS -->
    <!-- chartist CSS -->
    <link href="{{URL::asset('assets')}}/node_modules/morrisjs/morris.css" rel="stylesheet">
    <!--Toaster Popup message CSS -->
    <link href="{{URL::asset('assets')}}/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{URL::asset('css')}}/style.min.css" rel="stylesheet">
    <!-- Dashboard 1 Page CSS -->
    <link href="{{URL::asset('css')}}/pages/dashboard1.css" rel="stylesheet">
    <link href="{{URL::asset('assets')}}/node_modules/select2/dist/css/select2.css" rel="stylesheet">
    <link href="{{URL::asset('css')}}/dashboard.css" rel="stylesheet">
    @yield('asset')
    @yield('style')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="skin-megna fixed-layout">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Agro Kimia</p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="{{URL::asset('assets')}}/images/logo-icon.png" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="{{URL::asset('assets')}}/images/logo-light-icon.png" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <span class="hidden-xs"><span class="font-bold">Agro</span>Kimia</span>
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ti-bell"></i>
                                @if ($menus['task_count'])
                                <div class="notify" id="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown" id="mailbox">
                                <ul>
                                @if ($menus['task_count'])
                                    <li>
                                        <div class="drop-title"><span id='task_count'>{{ $menus['task_count'] }}</span> Task Sales yang belum diapprove</div>
                                    </li>
                                    <li>
                                        <div class="message-center" id="message-center">
                                            @foreach ( $menus['task_list'] as $val)
                                            <a id='{{$val->id}}' href="{{ route('unsigned-task', 1)}}">
                                                <div class="btn btn-success btn-circle"><i class="ti-bell"></i></div>
                                                <div class="mail-contnet">
                                                    <h6 style="color:black;">{{ $val->tipe_tasks['nama_kode'] }} Pada Kios {{ $val->kioss['nama_Kios'] }}</h6> <span class="mail-desc">Nama Sales : {{ $val->saless['nama_sales'] }}</span> <span class="time">{{$val->date}}</span>
                                                </div>
                                            </a>
                                            @endforeach
                                        </div>
                                    </li>
                                    @if ($menus['task_count'] > 5 )
                                    <li id='lainnya'>
                                        <a class="nav-link text-center link" href="{{ route('unsigned-task', 1)}}"> <strong>Lihat lainnya</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                    @endif
                                @else
                                    <li>
                                        <div class="drop-title">Tidak ada notifikasi terbaru</div>
                                    </li>
                                @endif
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        <!--
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="icon-note"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu mailbox dropdown-menu-right animated bounceInDown" aria-labelledby="2">
                                <ul>
                                    <li>
                                        <div class="drop-title">You have 4 new messages</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            
                                            <a href="javascript:void(0)">
                                                <div class="user-img"> <img src=""> <span class="profile-status online pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span>
                                                </div>
                                            </a>
                                            
                                            
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center link" href="javascript:void(0);"> <strong>See all e-Mails</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <! ============================================================== -->
                        <!-- End mega menu -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- User Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{URL::asset('assets')}}/images/users/1.jpg" alt="user" class=""> <span class="hidden-md-down"> {{ Auth::user()->name }} &nbsp;<i class="fa fa-angle-down"></i></span> </a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <a href="{{route('logout')}}" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End User Profile -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            @include('layouts._sidebar')
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            @yield('content')
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer">
            © 2020 Agro Kimia
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{URL::asset('assets')}}/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap popper Core JavaScript -->
    <script src="{{URL::asset('assets')}}/node_modules/popper/popper.min.js"></script>
    <script src="{{URL::asset('assets')}}/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{URL::asset('js')}}/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="{{URL::asset('js')}}/waves.js"></script>
    <!--Menu sidebar -->
    <script src="{{URL::asset('js')}}/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="{{URL::asset('js')}}/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--morris JavaScript -->
    <script src="{{URL::asset('assets')}}/node_modules/raphael/raphael-min.js"></script>
    <script src="{{URL::asset('assets')}}/node_modules/morrisjs/morris.min.js"></script>
    <script src="{{URL::asset('assets')}}/node_modules/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!-- Popup message jquery -->
    <script src="{{URL::asset('assets')}}/node_modules/toast-master/js/jquery.toast.js"></script>
    <!-- jQuery peity -->
    <script src="{{URL::asset('assets')}}/node_modules/peity/jquery.peity.min.js"></script>
    <script src="{{URL::asset('assets')}}/node_modules/peity/jquery.peity.init.js"></script>
    <script src="{{URL::asset('js')}}/dashboard1.js"></script>
    <!-- Chart Dashboard -->
    <script src="{{URL::asset('js')}}/chart-ds.js"></script>
    <!-- Local Fusion Chart -->
    {{-- <script src="{{URL::asset('js')}}/fusioncharts.js"></script>
    <script src="{{URL::asset('js')}}/jquery-fusioncharts.js"></script>
    <script src="{{URL::asset('js')}}/fusioncharts.jqueryplugin.min.js"></script>
    <script src="{{URL::asset('js')}}/fusioncharts.theme.fusion.js"></script> --}}
    <!-- Online Fusion Chart -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    @yield('script')
</body>

</html>
