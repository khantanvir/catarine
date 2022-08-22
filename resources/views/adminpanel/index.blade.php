<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ (!empty($page_title))?$page_title:'' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{ URL::to('public/admin/assets/images/icon/favicon.ico' ) }}">
    <link rel="stylesheet" href="{{ URL::to('public/admin/assets/css/bootstrap.min.css' ) }}">
    <link rel="stylesheet" href="{{ URL::to('public/admin/assets/css/font-awesome.min.css' ) }}">
    <link rel="stylesheet" href="{{ URL::to('public/admin/assets/css/themify-icons.css' ) }}">
    <link rel="stylesheet" href="{{ URL::to('public/admin/assets/css/metisMenu.css' ) }}">
    <link rel="stylesheet" href="{{ URL::to('public/admin/assets/css/owl.carousel.min.css' ) }}">
    <link rel="stylesheet" href="{{ URL::to('public/admin/assets/css/slicknav.min.css' ) }}">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css' ) }}" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="{{ URL::to('public/admin/assets/css/typography.css' ) }}">
    <link rel="stylesheet" href="{{ URL::to('public/admin/assets/css/default-css.css' ) }}">
    <link rel="stylesheet" href="{{ URL::to('public/admin/assets/css/styles.css' ) }}">
    <link rel="stylesheet" href="{{ URL::to('public/admin/assets/css/responsive.css' ) }}">
    <!-- modernizr css -->
    <script src="{{ URL::to('public/admin/assets/js/vendor/modernizr-2.8.3.min.js' ) }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div id="preloader">
    <div class="loader"></div>
</div>
<div class="page-container">
    <div class="sidebar-menu">
        <div class="sidebar-header">
            <div class="logo">
                <a href="{{ URL::to('dashboard') }}"><img src="{{ URL::to('public/front/images/logo-resto.png' ) }}" alt="logo"></a>
            </div>
        </div>
        <div class="main-menu">
            <div class="menu-inner">
                <nav>
                    <ul class="metismenu" id="menu">
                        <?php if(Auth::check() && Auth::user()->role=="admin"){ ?>
                        <li @if(!empty($dashboard) && $dashboard==true) class="active" @endif>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>dashboard</span></a>
                            <ul class="collapse">
                                <li @if(!empty($dashboard_page) && $dashboard_page==true) class="active" @endif><a href="{{ URL::to('dashboard') }}">Dashboard Main</a></li>
                                <li @if(!empty($create_user) && $create_user==true) class="active" @endif><a href="{{ URL::to('create-user') }}">Create Delivery User</a></li>
                                <li @if(!empty($all_user) && $all_user==true) class="active" @endif><a href="{{ URL::to('all-users') }}">All Delivery Users</a></li>
                            </ul>
                        </li>

                        <li @if(!empty($catarine) && $catarine==true) class="active" @endif>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>Catarine Service</span></a>
                            <ul class="collapse">
                                <li @if(!empty($create_catarine_user) && $create_catarine_user==true) class="active" @endif><a href="{{ URL::to('create-catarine-user') }}">Create Catarine User</a></li>
                                <li @if(!empty($all_catarine_user) && $all_catarine_user==true) class="active" @endif><a href="{{ URL::to('all-catarine-users') }}">All Catarine Users</a></li>
                            </ul>
                        </li>

                        <li @if(!empty($order_list) && $order_list==true) class="active" @endif>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>Orders</span></a>
                            <ul class="collapse">
                                <li @if(!empty($new_order) && $new_order==true) class="active" @endif><a href="{{ URL::to('all-incoming-orders') }}">New Order <span class="badge" id="new_order_come" style="color:#e5efec; background-color: #10ce53; float: right; width: 22px;">{{ \App\Models\Product::get_order_list_by_admin() }}</span></a></li>
                                <li @if(!empty($all_confirmed_order) && $all_confirmed_order==true) class="active" @endif><a href="{{ URL::to('all-confirmed-orders') }}">All Confirmed Order</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                        <?php if(Auth::check() && Auth::user()->role=="catarine"){ ?>
                        <li @if(!empty($catarine_home) && $catarine_home==true) class="active" @endif>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>Catarine Service</span></a>
                            <ul class="collapse">
                                <li @if(!empty($create_main_image) && $create_main_image==true) class="active" @endif><a href="{{ URL::to('create-main-image') }}">Create Main Image</a></li>
                                <li @if(!empty($create_cover_image) && $create_cover_image==true) class="active" @endif><a href="{{ URL::to('create-cover-image') }}">Create Cover Image</a></li>
                                <li @if(!empty($change_catarine_profile_info) && $change_catarine_profile_info==true) class="active" @endif><a href="{{ URL::to('change-catarine-profile-info') }}">Update Catarine Info</a></li>
                            </ul>
                        </li>
                        <li @if(!empty($product_catarine) && $product_catarine==true) class="active" @endif>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>Catarine Service</span></a>
                            <ul class="collapse">
                                <li @if(!empty($create_product_by_catarine) && $create_product_by_catarine==true) class="active" @endif><a href="{{ URL::to('create-product-by-catarine') }}">Create Product</a></li>
                                <li @if(!empty($all_catarine_food) && $all_catarine_food==true) class="active" @endif><a href="{{ URL::to('all-catarine-food') }}">All Catarine Food</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    @yield('adminpanel')
    <footer>
        <div class="footer-area">
            <p>© Copyright {{ date('Y') }}. All right reserved.</p>
        </div>
    </footer>
</div>

<script src="{{ URL::to('public/admin/assets/js/vendor/jquery-2.2.4.min.js' ) }}"></script>
<!-- bootstrap 4 js -->
<script src="{{ URL::to('public/admin/assets/js/popper.min.js' ) }}"></script>
<script src="{{ URL::to('public/admin/assets/js/bootstrap.min.js' ) }}"></script>
<script src="{{ URL::to('public/admin/assets/js/owl.carousel.min.js' ) }}"></script>
<script src="{{ URL::to('public/admin/assets/js/metisMenu.min.js' ) }}"></script>
<script src="{{ URL::to('public/admin/assets/js/jquery.slimscroll.min.js' ) }}"></script>
<script src="{{ URL::to('public/admin/assets/js/jquery.slicknav.min.js' ) }}"></script>

<!-- start chart js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<!-- start highcharts js -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<!-- start zingchart js -->
<script src="https://cdn.zingchart.com/zingchart.min.js"></script>
<script>
    zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
</script>
<!-- all line chart activation -->
<script src="{{ URL::to('public/admin/assets/js/line-chart.js' ) }}"></script>
<!-- all pie chart -->
<script src="{{ URL::to('public/admin/assets/js/pie-chart.js' ) }}"></script>
<script src="{{ URL::to('public/admin/assets/js/plugins.js' ) }}"></script>
<script src="{{ URL::to('public/admin/assets/js/scripts.js' ) }}"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        setInterval(function(){
            $.ajax({
                url: '{{ URL::to('get-current-order') }}',
                type: 'POST',
                dataType: 'html',
                success:function (result) {
                    console.log(JSON.stringify(result));
                    data = JSON.parse(result)
                    if(data['result']['key'] == "200"){
                        $('#new_order_come').html(data['result']['val']);
                    }
                    if(data['result']['key'] == "102"){
                        alert(data['result']['val']);
                    }
                    if(data['result']['key'] == "101"){
                        alert(data['result']['val']);
                        window.location.href();
                    }
                },
                error:function(exception){alert('Exeption:'+JSON.stringify(exception));}
            });
        },15000);
    });
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

</body>

</html>
