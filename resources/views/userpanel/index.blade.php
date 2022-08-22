<!DOCTYPE html>
<html lang="en">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="NCIEHOME" />

    <!-- Stylesheets
    ============================================= -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Raleway:300,400,500,600,700|Crete+Round:400i" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ URL::to('public/front/css/bootstrap.css' ) }}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::to('public/front/custom/style.css' ) }}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::to('public/front/css/dark.css' ) }}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::to('public/front/css/font-icons.css' ) }}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::to('public/front/css/animate.css' ) }}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::to('public/front/css/magnific-popup.css' ) }}" type="text/css" />



    <link rel="stylesheet" href="{{ URL::to('public/front/css/components/datepicker.css' ) }}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::to('public/front/css/components/timepicker.css' ) }}" type="text/css" />

    <link rel="stylesheet" href="{{ URL::to('public/front/css/responsive.css' ) }}" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- SLIDER REVOLUTION 5.x CSS SETTINGS -->
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/front/include/rs-plugin/css/settings.css' ) }}" media="screen" />
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/front/include/rs-plugin/css/layers.css' ) }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/front/include/rs-plugin/css/navigation.css' ) }}">

    <link rel="stylesheet" href="{{ URL::to('public/front/restaurent/css/restaurant.css' ) }}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::to('public/front/restaurent/css/fonts.css' ) }}" type="text/css" />
    <!-- Document Title
    ============================================= -->
    <title>Nciehome | {{ (!empty($page_title))?$page_title:'Hem' }}</title>

    <style>

        .revo-slider-emphasis-text {
            font-size: 64px;
            font-weight: 700;
            letter-spacing: -1px;
            font-family: 'Raleway', sans-serif;
            padding: 15px 20px;
            border-top: 2px solid #FFF;
            border-bottom: 2px solid #FFF;
        }

        .revo-slider-desc-text {
            font-size: 20px;
            font-family: 'Lato', sans-serif;
            width: 650px;
            text-align: center;
            line-height: 1.5;
        }

        .revo-slider-caps-text {
            font-size: 16px;
            font-weight: 400;
            letter-spacing: 3px;
            font-family: 'Raleway', sans-serif;
        }
        .tp-video-play-button { display: none !important; }

        .tp-caption { white-space: nowrap; }

        @media screen and (max-width: 600px) {
            .retina-logo{
                margin-top: 15px !important;
            }
            #top-cart-trigger{
                margin-top: 15px !important;
                margin-right: 10px !important;
            }
        }

    </style>

</head>

<body class="stretched">

<!-- Document Wrapper
============================================= -->
<div id="wrapper" class="clearfix">

    <!-- Header
    ============================================= -->
    <header id="header" class="sticky-header">

        <div id="header-wrap">

            <div class="container clearfix">

                <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

                <!-- Logo
                ============================================= -->
                <div id="logo">
                    <a href="{{ URL::to('/') }}" class="standard-logo" data-dark-logo="{{ URL::to('public/front/images/logo-dark.png' ) }}"><img src="{{ URL::to('public/front/images/logo-resto.png' ) }}" alt="Nciehome Logo"></a>
                    <a href="{{ URL::to('/') }}" class="retina-logo" data-dark-logo="{{ URL::to('public/front/images/logo-dark.png' ) }}"><img src="{{ URL::to('public/front/images/logo-resto.png' ) }}" alt="Nciehome Logo"></a>
                </div><!-- #logo end -->

                <!-- Primary Navigation
                ============================================= -->
                <nav id="primary-menu" class="style-5">

                    <ul class="norightborder norightpadding norightmargin">
                        <li class="{{ (!empty($home_current) && $home_current==true)?'current':'' }}"><a href="{{ URL::to('/') }}"><div><i class="icon-home2"></i>HEM</div></a></li>
                        <!--<li><a href="#"><div><i class="icon-file-alt"></i>Menu</div></a></li>-->
                        <li class="{{ (!empty($search_current) && $search_current==true)?'current':'' }}"><a href="{{ URL::to('search-catarine') }}"><div><i class="icon-shop"></i>SÖK</div></a></li>
                        <li class="{{ (!empty($contact_current) && $contact_current==true)?'current':'' }}"><a href="{{ URL::to('contact-us') }}"><div><i class="icon-map-marker2"></i>KONTAKT</div></a></li>
                        <?php if(Auth::check()){ ?>
                        <li class="{{ (!empty($profile_current) && $profile_current==true)?'current':'' }}"><a href="{{ URL::to('profile') }}"><div><i class="icon-line2-user-following"></i>PROFIL</div></a></li>
                        <li><a href="{{ URL::to('signout') }}"><div><i class="icon-line2-logout"></i>LOGGA UT</div></a></li>
                        <?php }else{ ?>
                        <li class="{{ (!empty($login_current) && $login_current==true)?'current':'' }}"><a href="{{ URL::to('user-login') }}"><div><i class="icon-line2-login"></i>LOGGA IN</div></a></li>
                        <?php } ?>
                    </ul>
                    <div id="top-cart">
                        <?php $cart = \Illuminate\Support\Facades\Session::get('cart'); ?>
                        <a href="#" id="top-cart-trigger"><i class="icon-shopping-cart"></i><span id="cart_count">{{ (!empty($cart))?count($cart):'0' }}</span></a>
                        <div class="top-cart-content">
                            <div class="top-cart-title">
                                <h4>Kundvagn</h4>
                            </div>
                            <div id="show_cart">

                                <?php if(!empty($cart)){ ?>

                                <div class="top-cart-items">
                                    <?php $subtotal = 0; $var = 0; ?>
                                    <?php foreach($cart as $cartRow){ ?>
                                    <?php $get_product = \App\Models\Product::where('id',$cartRow['product_id'])->first(); ?>
                                    <div class="top-cart-item clearfix">
                                        <div class="top-cart-item-image">
                                            <a href="{{ URL::to('catarine-product-details/'.$get_product->url) }}"><img src="{{ URL::to('public/products/main_image/'.$get_product->main_image) }}" alt="{{ $get_product->title }}" /></a>
                                        </div>
                                        <div class="top-cart-item-desc">
                                            <input type="hidden" name="product_id" value="{{ $cartRow['product_id'] }}" id="product_id{{ $var }}"/>
                                            <a href="{{ URL::to('catarine-product-details/'.$get_product->url) }}">{{ $get_product->title }}</a>
                                            <span class="top-cart-item-price">{{ $get_product->after_discount_price.' kr' }} <a onclick="deleteFromCart({{ $var }})" style="float: right; color: red;" href="javascript://"><i class="icon-line-delete"></i></a></span>
                                            <span class="top-cart-item-quantity">x {{ $cartRow['quantity'] }} </span>

                                        </div>
                                    </div>
                                    <?php $subtotal += $cartRow['sub_total']; $var++; } ?>
                                </div>
                                <div class="top-cart-action clearfix">
                                    <span class="fleft top-checkout-price">{{ $subtotal.' kr' }}</span>
                                    <a href="{{ URL::to('view-cart') }}" class="button button-3d button-small nomargin fright">Visa kundvagn</a>
                                </div>
                                <?php }else{ ?>
                                    <div class="top-cart-action clearfix">
                                        <span class="fleft top-checkout-price">Din vagn är tom</span>
                                    </div>
                                <?php } ?>
                            </div>

                        </div>
                    </div><!-- #top-cart end -->

                </nav><!-- #primary-menu end -->

            </div>

        </div>

    </header><!-- #header end -->
    <!--<a href="#" data-toggle="modal" data-target="#reviewFormModal" class="button button-3d nomargin fright">Lägg till en recension</a>-->

    <div class="modal fade" id="reviewFormModal2" tabindex="-1" role="dialog" aria-labelledby="reviewFormModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="reviewFormModalLabel">Välj din plats</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="nobottommargin" id="template-reviewform">
                        <div class="col_8">
                            <label for="template-reviewform-address">Välj Plats <small>*</small></label>
                            <div class="input-group">
                                <p>Tillåt din nuvarande plats.</p>
                                <p>Du kan beställa din mat på 7 km område med katarin.</p>
                                <span style="color: red;">Vänligen don, gör inte någon typ av beställning utsidan av catarine plats.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="modal-data-dismiss" class="btn btn-secondary" data-dismiss="modal">Stänga</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    @yield('userpanel')


    <footer id="footer" class="dark">
        <div class="container">
            <div class="footer-widgets-wrap clearfix">
                <div class="col_full">
                    <div class="heading-block center nobottommargin">
                        <h2>Har du frågor ring och prata med oss <strong>Ring upp +460703338161</strong></h2>
                    </div>
                </div>
            </div>
        </div>
        <div id="copyrights">
            <div class="container clearfix">
                <div class="col_half">
                    Upphovsrätt &copy; {{ date('Y') }} Alla rättigheter förbehållna.<br>
                    <div class="copyright-links"><a href="#">Villkor</a> / <a href="#">Integritetspolicy</a></div>
                </div>
                <div class="col_half col_last tright">
                    <div class="fright clearfix">
                        <a href="#" class="social-icon si-small si-borderless si-facebook">
                            <i class="icon-facebook"></i>
                            <i class="icon-facebook"></i>
                        </a>
                        <a href="#" class="social-icon si-small si-borderless si-twitter">
                            <i class="icon-twitter"></i>
                            <i class="icon-twitter"></i>
                        </a>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </footer>
</div>
<div id="gotoTop" class="icon-angle-up"></div>

<!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<?php if(empty($_COOKIE['latitude']) && empty($_COOKIE['longitude'])){ ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#reviewFormModal2').modal('show');
    });
</script>
<?php } ?>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>



<!-- External JavaScripts
============================================= -->
<!--<script src="{{ URL::to('public/front/js/jquery.js' ) }}"></script>-->
<script src="{{ URL::to('public/front/js/plugins.js' ) }}"></script>

<!-- Footer Scripts
============================================= -->
<script src="{{ URL::to('public/front/js/functions.js' ) }}"></script>

<!-- SLIDER REVOLUTION 5.x SCRIPTS  -->
<script src="{{ URL::to('public/front/include/rs-plugin/js/jquery.themepunch.tools.min.js' ) }}"></script>
<script src="{{ URL::to('public/front/include/rs-plugin/js/jquery.themepunch.revolution.min.js' ) }}"></script>



<script src="{{ URL::to('public/front/include/rs-plugin/js/extensions/revolution.extension.actions.min.js' ) }}"></script>
<script src="{{ URL::to('public/front/include/rs-plugin/js/extensions/revolution.extension.layeranimation.min.js' ) }}"></script>
<script src="{{ URL::to('public/front/include/rs-plugin/js/extensions/revolution.extension.kenburn.min.js' ) }}"></script>
<script src="{{ URL::to('public/front/include/rs-plugin/js/extensions/revolution.extension.navigation.min.js' ) }}"></script>
<script src="{{ URL::to('public/front/include/rs-plugin/js/extensions/revolution.extension.migration.min.js' ) }}"></script>
<script src="{{ URL::to('public/front/include/rs-plugin/js/extensions/revolution.extension.parallax.min.js' ) }}"></script>


<script type="text/javascript" src="{{ URL::to('public/front/js/main_page.js ') }}"></script>
<script type="text/javascript">
    tryGeolocation();
</script>

<script type="text/javascript">
    function addToCart(){
        var quantity = $('#quantity').val();
        var product_url = $('#product_url').val();
        if(quantity !=="" && product_url !==""){
            $.ajax({
                url: '{{ URL::to('add-to-cart') }}',
                data: { 'quantity':quantity,'product_url':product_url },
                type: 'POST',
                dataType: 'html',
                success:function (result) {
                    data = JSON.parse(result);
                    if(data['result']['key'] == "200"){
                        $('#show_cart').html(data['result']['val']);
                        $('#cart_count').html(data['result']['count']);
                        $('#top-cart').addClass("top-cart-open");
                        if(window.matchMedia("(max-width: 500px)").matches){
                            setTimeout(function() {
                                $('html, body').animate({scrollTop:0}, 800);
                            },200);//call every 2000 miliseconds
                        }
                    }
                    if(data['result']['key'] == "101"){
                        alert(data['result']['val']);
                    }
                    if(data['result']['key'] == "102"){
                        alert(data['result']['val']);
                    }
                },
                error:function(exception){alert('Exeption:'+JSON.stringify(exception));}
            });
        }else{
            return false;
        }
    }
    function addToCartFromList(x) {
        var quantity = 1;
        var product_url = $('#product_url'+x).val();
        if(quantity !=="" && product_url !==""){
            $.ajax({
                url: '{{ URL::to('add-to-cart') }}',
                data: { 'quantity':quantity,'product_url':product_url },
                type: 'POST',
                dataType: 'html',
                success:function (result) {
                    data = JSON.parse(result);
                    if(data['result']['key'] == "200"){
                        $('#show_cart').html(data['result']['val']);
                        $('#cart_count').html(data['result']['count']);
                        $('#top-cart').addClass("top-cart-open");
                        if(window.matchMedia("(max-width: 500px)").matches){
                            setTimeout(function() {
                                $('html, body').animate({scrollTop:0}, 800);
                            },200);//call every 2000 miliseconds
                        }
                    }
                    if(data['result']['key'] == "101"){
                        alert(data['result']['val']);
                    }
                    if(data['result']['key'] == "102"){
                        alert(data['result']['val']);
                    }
                },
                error:function(exception){alert('Exeption:'+JSON.stringify(exception));}
            });
        }else{
            return false;
        }
    }
    function deleteFromCart(x){
        var product_id = $('#product_id'+x).val();
        if(product_id !==""){
            $.ajax({
                url: '{{ URL::to('delete-from-cart') }}',
                data: { 'product_id':product_id },
                type: 'POST',
                dataType: 'html',
                success:function (result) {
                    data = JSON.parse(result);
                    if(data['result']['key'] == "200"){
                        $('#show_cart').html(data['result']['val']);
                        $('#cart_count').html(data['result']['count']);
                        $('#top-cart').addClass("top-cart-open");
                    }
                    if(data['result']['key'] == "101"){
                        alert(data['result']['val']);
                    }
                    if(data['result']['key'] == "102"){
                        alert(data['result']['val']);
                    }
                },
                error:function(exception){alert('Exeption:'+JSON.stringify(exception));}
            });
        }else{
            return false;
        }
    }
    function submitReview(){
        var name = $('#name').val();
        var email = $('#email').val();
        var rating = $('#rating').val();
        var message = $('#message').val();
        var product_url = $('#product_url').val();
        if(name !== "" && email !== "" && rating !== "" && message !== "" && product_url !== ""){
            $.ajax({
                url: '{{ URL::to('post-product-comment') }}',
                data: { 'name':name, 'email':email, 'rating':rating,'message':message,'product_url':product_url },
                type: 'POST',
                dataType: 'html',
                success:function (result) {
                    data = JSON.parse(result);
                    if(data['result']['key'] == "200"){
                        $('#modal-data-dismiss').click();
                        $('#feedback-list').html(data['result']['val']);
                        $('#count-feedback').html(data['result']['count']);
                        $('#name').val("");
                        $('#email').val("");
                        $('#rating').val("");
                        $('#message').val("");

                    }
                    if(data['result']['key'] == "101"){
                        alert(data['result']['val']);
                    }
                    if(data['result']['key'] == "102"){
                        alert(data['result']['val']);
                    }
                },
                error:function(exception){alert('Exeption:'+JSON.stringify(exception));}
            });
        }else{
            alert("All field is required!");
        }
    }
</script>
</body>
</html>
