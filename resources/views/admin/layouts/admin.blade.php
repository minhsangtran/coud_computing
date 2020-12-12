<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>FoodOrder| Admin Page</title>

    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <!-- Toastr style -->
    <link href="{{ asset('frontend/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

    <link href="{{ asset('frontend/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/custom.css') }}" rel="stylesheet">
    <meta property="og:image" content="https://yt3.ggpht.com/a-/ACSszfG6SiS4096AdxOv4vjhBXJphsGQuBWBBwkLww=s900-mo-c-c0xffffffff-rj-k-no" />
    <meta property="og:image:secure_url" content="https://yt3.ggpht.com/a-/ACSszfG6SiS4096AdxOv4vjhBXJphsGQuBWBBwkLww=s900-mo-c-c0xffffffff-rj-k-no" />

    @yield('css')

    <style>
    .dataTables_length{
        display: none;
    }
    label{
        margin-top:5px !important;
        margin-bottom:10px !important;
    }
    .form-horizontal .control-label {
        padding-top: 0px;
    }
    .breakline-when-overflow{
        word-wrap: break-word!important;      /* IE 5.5-7 */
        white-space: -moz-pre-wrap!important; /* Firefox 1.0-2.0 */
    }
    .nav-header{
        text-align: center;
    }
    .nav-header span{
        font-weight: bold!important;
        font-size: 16px;
        color: white;
    }
    </style>
    @yield('header')
</head>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <span>
                                ADMIN
                            </span>
                            <span class="block m-t-xs"> <strong class="font-bold">{{Auth::user()->name}}</strong></span>
                        </div>
                    </li>
                    <li class="{{($url == 'carts' || $url == 'edit-cart') ? 'active' : ''}}" data-toggle="tooltip" title="Thêm/Xóa/Sửa đơn hàng">
                        <a><i class="fa fa-shopping-cart"></i> <span class="nav-label">Quản lí đơn hàng</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li class="{{($url == 'carts') ? 'active' : ''}}"><a href="/admin/carts/new" id="admin-list-cart">Danh sách đơn hàng</a></li>
                            <!-- <li class="{{($url == 'create-cart') ? 'active' : ''}}"><a href="/admin/create-cart">Thống kê</a></li> -->
                        </ul>
                    </li>
                    <li class="{{($url == 'analyst-revenue' || $url == 'analyst-food' || $url == 'analyst-cart') ? 'active' : ''}}" data-toggle="tooltip" title="Thống kê">
                        <a><i class="fa fa-pie-chart"></i> <span class="nav-label">Thống kê</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li class="{{($url == 'analyst-revenue') ? 'active' : ''}}"><a href="/admin/analyst-revenue" id="">Doanh thu</a></li>
                            <li class="{{($url == 'analyst-cart') ? 'active' : ''}}"><a href="/admin/analyst-cart" id="">Đơn hàng</a></li>
                            <li class="{{($url == 'analyst-food') ? 'active' : ''}}"><a href="/admin/analyst-food" id="">Sản phẩm</a></li>

                        </ul>
                    </li>
                    <li class="{{($url == 'users' || $url == 'create-user' || $url == 'edit-user') ? 'active' : ''}}" data-toggle="tooltip" title="Thêm/Xóa/Sửa người dùng">
                        <a><i class="fa fa-users"></i> <span class="nav-label">Quản lí người dùng</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li class="{{($url == 'users') ? 'active' : ''}}"><a href="/admin/users" id="admin-list-user">Danh sách người dùng</a></li>
                            <li class="{{($url == 'create-user') ? 'active' : ''}}"><a href="/admin/create-user">Thêm người dùng</a></li>
                        </ul>
                    </li>
                    <li class="{{($url == 'categories' || $url == 'create-category') ? 'active' : ''}}" data-toggle="tooltip" title="Thêm/Xóa/Sửa category">
                        <a><i class="fa fa-folder"></i> <span class="nav-label">Quản lí category</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li class="{{($url == 'categories') ? 'active' : ''}}"><a href="/admin/categories" id="admin-list-category">Danh sách category</a></li>
                            <li class="{{($url == 'create-category') ? 'active' : ''}}"><a href="/admin/create-category">Thêm category</a></li>
                        </ul>
                    </li>
                    <li class="{{($url == 'foods' || $url == 'create-food' || $url == 'analytics-food' || $url == 'edit-food') ? 'active' : ''}}" data-toggle="tooltip" title="Thêm/Xóa/Sửa món ăn">
                        <a><i class="fa fa-cutlery"></i> <span class="nav-label">Quản lí món ăn</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li class="{{($url == 'foods') ? 'active' : ''}}"><a href="/admin/foods" id="admin-list-food">Danh sách món ăn</a></li>
                            <li class="{{($url == 'create-food') ? 'active' : ''}}"><a href="/admin/create-food">Thêm món ăn</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <a href="/admin/logout">
                                <i class="fa fa-sign-out"></i> Log out
                            </a>
                        </li>
                    </ul>

                </nav>
            </div>
            @yield('content')
            <div class="footer">
                <div>
                    <strong>Copyright</strong> <a href="">vunquitk11@gmail.com</a> &copy; {{date('Y')}}
                </div>
            </div>
        </div>
    </div>


    <!-- Mainly scripts -->
    <script src="{{ asset('frontend/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('frontend/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('frontend/js/inspinia.js') }}"></script>
    <script src="{{ asset('frontend/js/plugins/pace/pace.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('frontend/js/plugins/toastr/toastr.min.js') }}"></script>

    @yield('script')
    <script>
        $(document).ready(function() {
            @if(session('success'))
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 2000
                };
                toastr.success('{{session("success")}}', 'FoodOrder Admin');
            }, 300);
            @endif
            @if(session('danger'))
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 2000
                };
                toastr.error('{{session("danger")}}', 'FoodOrder Admin');
            }, 300);
            @endif
            @if(session('warning'))
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 1200
                };
                toastr.warning('{{session("warning")}}', 'FoodOrder Admin');
            }, 300);
            @endif
        });
    </script>
</body>

</html>
