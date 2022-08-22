@extends('userpanel.index')
@section('userpanel')
    <link rel="stylesheet" href="{{ URL::to('public/front/restaurent/css/restaurant.css' ) }}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::to('public/front/restaurent/css/fonts.css' ) }}" type="text/css" />

    <style>
        .pagination>.page-item>.page-link{
            border: 1px solid #c4cfda !important
        }
    </style>
    <section id="page-title" class="page-title-parallax page-title-dark page-title-center" style="background-image: url({{ (!empty($details->cover_image))?URL::to('public/catarine/cover/'.$details->cover_image):URL::to('public/front/restaurent/images/sections/food-menu.jpg')  }}); background-size: cover; padding: 120px 0 180px;" data-bottom-top="background-position:0 0px;" data-top-bottom="background-position:0px -300px;">

        <div class="container clearfix">
            <h1 class="font-secondary capitalize ls0" style="font-size: 74px;">{{ $details->name }}</h1>
            <span class="t400">Välj objekt från vår meny</span>
        </div>

    </section>

    <section id="content" style="overflow: visible;">

        <div class="content-wrap nopadding">

            <div class="container">

                <div class="tabs tabs-justify clear-bottommargin clearfix" id="tab-1">

                    <ul class="tab-nav clearfix border-bottom-0">
                        <li><a href="#tabs-breakfast"><img src="{{ URL::to('public/front/restaurent/images/icons/lunch.png' ) }}" alt="">Meny</a></li>
                        <li><a href="#tabs-salad"><img src="{{ URL::to('public/front/restaurent/images/icons/special.png' ) }}" alt="">Special</a></li>
                        <li><a href="#tabs-pizza"><img src="{{ URL::to('public/front/restaurent/images/icons/about1.png' ) }}" alt="">Sallad och dryck</a></li>
                        <li><a href="#tabs-dessert"><img src="{{ URL::to('public/front/restaurent/images/icons/route.svg' ) }}" alt="">Om kocken</a></li>
                    </ul>

                    <div class="tab-container mt-4">

                        <div class="tab-content clearfix" id="tabs-breakfast">
                            <div class="row clearfix">
                                <?php $i=0; if(!empty($foods)){ ?>
                                <?php foreach($foods as $food){ ?>
                                    <div class="col-lg-3 col-md-6">
                                    <div class="iportfolio mb-4 clearfix">
                                        <input type="hidden" name="product_url" id="product_url<?=$i?>" value="{{ $food->url }}" />
                                        <a href="{{ URL::to('catarine-product-details/'.$food->url) }}" class="portfolio-image"><img src="{{ URL::to('public/products/main_image/'.$food->main_image ) }}" alt="1" class="rounded"></a>
                                        <div class="portfolio-desc pt-2">
                                            <h4 class="mb-1"><a href="{{ URL::to('catarine-product-details/'.$food->url) }}">{{ $food->title }}</a></h4>
                                            <div class="item-price">{{ $food->after_discount_price.' kr' }}<a onclick="addToCartFromList(<?=$i?>)" style="float: right;" href="javascript://"><i class="icon-cart-plus"></i></a></div>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++; } } ?>
                            </div>
                            <div class="row  col-lg-12">
                                <ul class="pagination pagination-circle">
                                    {{ $foods->links() }}
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content clearfix" id="tabs-salad">
                            <div class="row clearfix">
                                <?php $y=0; if(!empty($specials)){ ?>
                                <?php foreach($specials as $special){ ?>
                                <div class="col-lg-3 col-md-6">
                                    <div class="iportfolio mb-4 clearfix">
                                        <input type="hidden" name="product_url" id="product_url<?=$i?>" value="{{ $special->url }}" />
                                        <a href="{{ URL::to('catarine-product-details/'.$food->url) }}" class="portfolio-image"><img src="{{ URL::to('public/products/main_image/'.$special->main_image ) }}" alt="1" class="rounded"></a>
                                        <div class="portfolio-desc pt-2">
                                            <h4 class="mb-1"><a href="{{ URL::to('catarine-product-details/'.$food->url) }}">{{ $special->title }}</a></h4>
                                            <div class="item-price">{{ $special->after_discount_price.' kr' }}<a onclick="addToCartFromList(<?=$y?>)" style="float: right;" href="javascript://"><i class="icon-cart-plus"></i></a></div>
                                        </div>
                                    </div>
                                </div>
                                <?php $y++; } } ?>
                            </div>
                        </div>
                        <div class="tab-content clearfix" id="tabs-pizza">
                            <div class="row clearfix">
                                <?php $z=0; if(!empty($salads)){ ?>
                                <?php foreach($salads as $salad){ ?>
                                <div class="col-lg-3 col-md-6">
                                    <div class="iportfolio mb-4 clearfix">
                                        <input type="hidden" name="product_url" id="product_url<?=$z?>" value="{{ $salad->url }}" />
                                        <a href="{{ URL::to('catarine-product-details/'.$salad->url) }}" class="portfolio-image"><img src="{{ URL::to('public/products/main_image/'.$salad->main_image ) }}" alt="1" class="rounded"></a>
                                        <div class="portfolio-desc pt-2">
                                            <h4 class="mb-1"><a href="{{ URL::to('catarine-product-details/'.$salad->url) }}">{{ $salad->title }}</a></h4>
                                            <div class="item-price">{{ $salad->after_discount_price.' kr' }}<a onclick="addToCartFromList(<?=$z?>)" style="float: right;" href="javascript://"><i class="icon-cart-plus"></i></a></div>
                                        </div>
                                    </div>
                                </div>
                                <?php $z++; } } ?>
                            </div>
                        </div>
                        <div class="tab-content clearfix" id="tabs-dessert">
                            <div class="row clearfix">
                                <div class="col-lg-3 col-md-6">
                                    <div class="clearfix">
                                        <div class="iportfolio mb-4 clearfix">
                                            <img height="250px" width="250px" src="{{ URL::to('public/catarine/main/'.$details->main_image ) }}" alt="1" class="rounded">
                                            <h3>Annan information</h3>
                                            <abbr title="Food Details"><strong>Food Item:</strong></abbr> {{ (!empty($details->main_items))?$details->main_items:'' }}<br>
                                            <abbr title="Delivery Time"><strong>Delivery Time:</strong></abbr> {{ (!empty($details->delivery_time))?$details->delivery_time:'' }}<br>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="portfolio-desc">
                                        <div class="team-title"><h4>{{ $details->name }}</h4><span>Online matleverans</span></div>
                                        <div class="team-content">
                                            <p>{{ $details->short_bio }}</p>
                                        </div>
                                        <div class="team-content">
                                            <p>Experience: {{ $details->experience }}</p>
                                        </div>
                                        <div class="team-content">
                                            <p>{{ $details->address }}</p>
                                        </div>
                                        <a href="#" class="social-icon si-rounded si-small si-light si-facebook">
                                            <i class="icon-facebook"></i>
                                            <i class="icon-facebook"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <h1>Om företag</h1>
                                    <p>{{ (!empty($details->bio))?$details->bio:'' }}</p>
                                    <h3>Kontaktperson</h3>
                                    <abbr title="Contact Person"><strong>Kontaktperson:</strong></abbr> {{ (!empty($details->first_name))?$details->first_name.' '.$details->last_name:'' }}<br>
                                    <abbr title="Phone Number"><strong>Tel:</strong></abbr> {{ (!empty($details->alt_contact))?$details->alt_contact:'' }}<br>
                                    <abbr title="Phone Number"><strong>E-post:</strong></abbr> {{ (!empty($details->email))?$details->email:'' }}<br>
                                    <p></p>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-8 col-md-8">
                                    <div class="mb-8 clearfix">
                                        <div style="margin-left: 9px;" class="">

                                            <section id="google-map" class="gmap" style="height: 410px;"></section>

                                        </div><!-- Google Map End -->

                                        <div class="clear"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4">
                                    <div class="iportfolio mb-4 clearfix">
                                        <div class="">

                                            <address>
                                                <strong>Huvudkontor:</strong><br>
                                                {{ (!empty($details->address))?$details->address:'' }}<br>
                                                {{ (!empty($details->city))?$details->city:'' }}<br>
                                            </address>
                                            <abbr title="Phone Number"><strong>Tel:</strong></abbr> {{ (!empty($details->alt_contact))?$details->alt_contact:'' }}<br>
                                            <abbr title="Fax"><strong>Hemsida:</strong></abbr> {{ (!empty($details->website))?$details->website:'' }}<br>
                                            <abbr title="Email Address"><strong>E-post:</strong></abbr> {{ (!empty($details->email))?$details->email:'' }}

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="section mb-0 mt-3" style="padding: 80px 0; background: #F5F5F5 url({{ URL::to('public/front/restaurent/images/food-pattern.png') }}) repeat center center;">
                <div class="container">
                    <div class="heading-block nobottomborder center bottommargin-sm">
                        <span class="font-primary ls1 color">Steg för ordning</span>
                        <h3 class="nott font-secondary ls0" style="font-size: 52px; line-height: 1.3;">Hur får du din mat</h3>
                    </div>

                    <div class="clear"></div>

                    <div class="row mt-5 clearfix">
                        <div class="col-lg-4 col-sm-6 bottommargin-sm">
                            <div class="feature-box media-box">
                                <div class="fbox-media" style="width: 60px; height: 60px">
                                    <img src="{{ URL::to('public/front/restaurent/images/icons/route.svg' ) }}" alt="">
                                </div>
                                <h3>1. Välj din plats</h3>
                                <p>Välj först din nuvarande plats. Se sedan katarinservice med en radie på 7 km.!</p>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6 bottommargin-sm">
                            <div class="feature-box media-box">
                                <div class="fbox-media" style="width: 60px; height: 60px">
                                    <img src="{{ URL::to('public/front/restaurent/images/icons/shop.svg' ) }}" alt="">
                                </div>
                                <h3>2. Välj din mat</h3>
                                <p>Välj matvaran från catarine-menyn. Beställ sedan det. Var försiktig så att du inte kan välja matvaror utanför radien på 7 km.</p>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6 bottommargin-sm">
                            <div class="feature-box media-box">
                                <div class="fbox-media" style="width: 75px; height: 60px">
                                    <img src="{{ URL::to('public/front/restaurent/images/icons/delivery-bg.svg' ) }}" alt="">
                                </div>
                                <h3>3. Din artikel är på väg</h3>
                                <p>När katarinservice får denna beställning. De kommer att bekräfta denna beställning via telefon eller e-post. Med inom 40 minuter får du din beställningsmat.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="position: absolute; bottom: 0; left: 0; width: 100%; z-index: 3; background: url({{ URL::to('public/front/restaurent/images/sketch-header.png') }}) repeat center bottom; background-size: auto 100%; height: 40px; margin-bottom: -10px;"></div>
    </section>
    <link rel="icon" href="{{ URL::to('public/front/images/icons/dotted.png' ) }}" type="text/html" />
    <script src="{{ URL::to('public/front/js/jquery.js' ) }}"></script>
    <script src="{{ URL::to('public/front/js/plugins.js' ) }}"></script>
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyBKI8oyydmgWAtwdNXuX5K5l9E4eSbBCdk"></script>
    <script src="{{ URL::to('public/front/js/jquery.gmap.js' ) }}"></script>
    <script>

        jQuery('#google-map').gMap({
            address: '<?php echo $details->address; ?>',
            maptype: 'ROADMAP',
            longitude: '<?php echo $details->longitude; ?>',
            latitude: '<?php echo $details->latitude; ?>',
            zoom: 12,
            markers: [
                {
                    address: "<?php echo $details->address; ?>",
                    html: '<div style="width: auto;"><h4 style="margin-bottom: 8px;">Hi, we\'re <span>Envato</span></h4><p class="nobottommargin">Our mission is to help people to <strong>earn</strong> and to <strong>learn</strong> online. We operate <strong>marketplaces</strong> where hundreds of thousands of people buy and sell digital goods every day, and a network of educational blogs where millions learn <strong>creative skills</strong>.</p></div>',
                    icon: {
                        image: "{{ URL::to('public/front/images/icons/map-icon-red.png') }}",
                        iconsize: [32, 39],
                        iconanchor: [32,39]
                    }
                }
            ],
            doubleclickzoom: false,
            controls: {
                panControl: true,
                zoomControl: true,
                mapTypeControl: true,
                scaleControl: false,
                streetViewControl: false,
                overviewMapControl: false
            }
        });
    </script>
@stop