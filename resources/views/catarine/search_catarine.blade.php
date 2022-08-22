@extends('userpanel.index')
@section('userpanel')
    <link rel="stylesheet" href="{{ URL::to('public/front/custom/search.css' ) }}" type="text/css" />
    <style>
        h4{
            margin-bottom: 0px !important;
        }
        p{
            margin-bottom: 10px !important;
        }
        .custom-h4-title{
            font-size: 12px !important;
        }
        @media screen and (min-width: 800px) {
            .custom-search-box{
                float: right !important;
            }
        }
    </style>
    <section id="page-title">
        <div class="container clearfix">
            <h1>Sök i Catarine</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Hem</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sök i Catarine Sida</li>
            </ol>
        </div>
    </section><!-- #page-title end -->
    <section id="content" style="overflow: visible;">
        <div class="content-wrap">
            <div class="container">
            <div class="col-md-3 custom-search-box">
                <h4><span class="fw-semi-bold">Sökning efter plats</span></h4>
                <div>
                    {{--<p id="change-p-location">Change your location <a onclick="showAddText()" href="javascript://">Click</a> Here</p>--}}
                    <div style="" class="row locaion-text">
                        <div style="margin-bottom: 6px; margin-top: 10px;" class="col-md-12">
                            <input style="max-width: 280px;" id="searchTextField" class="form-control" type="text" size="50" placeholder="Ange din plats" autocomplete="off" runat="server">
                            <input type="hidden" id="city2" name="city2">
                            <input type="hidden" id="cityLat" name="cityLat">
                            <input type="hidden" id="cityLng" name="cityLng">
                            <input type="hidden" id="city" name="city">
                        </div>
                    </div>
                    <button onclick="searchByAddress()" class="btn btn-dark">Sok</button>
                </div>
            </div>
            <div class="col-md-9">
                <div class="">
                    @if(Session::has('success'))
                        <div class="alert alert-success col-12">
                            <strong> {{ Session::get('success') }}</strong>
                        </div>
                    @endif
                    @if(Session::has('error'))
                        <div class="alert alert-danger col-12">
                            <strong> {{ Session::get('error') }}</strong>
                        </div>
                    @endif

                    @if (count($errors) > 0)
                        <div class="alert alert-danger col-12">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <span class="search-results-count">Visa närmaste kock. Din nuvarande plats: <span id="current-location"></span></span>
                <?php if(!$users->isEmpty()){ ?>
                <?php foreach($users as $row){ ?>
                    <section class="search-result-item">
                    <a title="{{ (!empty($row->name))?$row->name:'' }}" class="image-link" href="{{ URL::to('catarine-details/'.$row->url) }}"><img style="border-radius: 50%;" title="{{ (!empty($row->name))?$row->name:'' }}" class="image custom-image" src="{{ (!empty($row->main_image))?URL::to('public/catarine/main/'.$row->main_image):URL::to('public/front/restaurent/images/menu/salads/1.jpg') }}">
                    </a>
                    <div class="search-result-item-body">
                        <div class="row">
                            <div class="col-sm-9">
                                <h4 class="search-result-item-heading0"><a class="custom-name-title" title="{{ (!empty($row->name))?$row->name:'' }}" href="{{ URL::to('catarine-details/'.$row->url) }}">{{ (!empty($row->name))?$row->name:'' }}&nbsp;<span class="spn-experience"></span></a></h4>
                                <input type="hidden" id="user_url0" data-name="" name="user_url" value="">
                                <p class="custom-p info"><i class="fa fa-map-marker"></i> {{ (!empty($row->address))?$row->address:'' }} {{ (!empty($row->city))?$row->city:'' }}</p>
                                <div id="showContactDiv0">
                                    <h5 class="custom-h5"><a onclick="showNumber(0)" href="javascript://" class="custom-p-m">Leveranstid: {{ (!empty($row->delivery_time))?$row->delivery_time:'' }}</a></h5>
                                </div>
                                <p class="custom-p info"><i class="fa fa-map-marker"></i> {{ (!empty($row->experience))?'Erfarenhet:'.$row->experience:'' }}</p>
                                <p class="custom-p info"><i class="fa fa-map-marker"></i> {{ (!empty($row->short_bio))?$row->short_bio:'' }}</p>
                                <p class="custom-p description">{{ (!empty($row->main_items))?$row->main_items:'' }}</p>
                                <p class="custom-p">
                                <div class="tab-content clearfix ui-tabs-panel ui-corner-bottom ui-widget-content" id="tabs-breakfast" aria-labelledby="ui-id-1" role="tabpanel" aria-hidden="false">
                                    <div class="row clearfix">
                                        <?php $foods = \App\Models\Product::where('catarine_id',$row->id)->where('status',0)->where('is_deleted',0)->take(4)->get(); ?>
                                        <?php if(!empty($foods)){ ?>
                                        <?php foreach($foods as $food){ ?>
                                            <div class="col-lg-3 col-md-6">
                                            <div class="iportfolio mb-4 clearfix">
                                                <a href="{{ URL::to('catarine-product-details/'.$food->url) }}" class="portfolio-image"><img style="max-height: 120px; max-width: 120px;" src="{{ URL::to('public/products/main_image/'.$food->main_image) }}" alt="1" class="rounded"></a>
                                                <div class="portfolio-desc pt-2">
                                                    <span class="custom-h4-title"><a href="{{ URL::to('catarine-product-details/'.$food->url) }}">{{ $food->title }}</a></span>
                                                    <div class="item-price">{{ $food->after_discount_price }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 text-align-center">
                                <p class="value3 mt-sm cutom-miles"><?=round(\App\Models\Redlep::distance((!empty($latitude_p))? $latitude_p : 59.2635432,(!empty($longitude_p))? $longitude_p : 17.8876479,$row->latitude,$row->longitude,"K"),2)." miles"?></p>
                                <p class="fs-mini text-muted custom-district">{{ (!empty($row->city))?$row->city:'Stockholm' }}</p><a class="btn btn-dark" href="{{ URL::to('catarine-details/'.$row->url) }}">Detaljer</a>
                            </div>
                        </div>
                    </div>
                </section>
                <?php } ?>
                <div style="margin-top: 10px;" class="text-align-center">
                    <ul class="pagination pagination-circle">
                        {{ $users->links() }}
                    </ul>
                </div>
                <?php }else{ ?>
                <section class="search-result-item">
                    <div class="search-result-item-body">
                        <p style="font-size: 15px; color: #62b127;">Katarindata hittades inte i ditt område. Du kan beställa maten i 7km radie av katarin!</p>
                        <p style="font-size: 15px; color: #62b127;">Vi levererar maten från följande område i 7 km radie!</p>
                        <?php $catarine= \App\Models\User::where('role','catarine')->get(); ?>
                        <?php foreach($catarine as $cat){ ?>
                        <h4>{{ $cat->name.', '.$cat->address }}<span style="font-size: 16px; font-weight: lighter; color: red;"> (7km radius)</span></h4>
                        <?php } ?>
                    </div>
                </section>
                <?php } ?>
            </div>
        </div>
        </div>
    </section>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDeEFqdpYAXbeKLGrAnVq7z73aP-2hu2vs&libraries=places?sensor=false"></script>
    <script type="text/javascript">
        function GetAddress() {
            var lat = parseFloat(<?=$latitude_p?>);
            var lng = parseFloat(<?=$longitude_p?>);
            var latlng = new google.maps.LatLng(lat, lng);
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        //alert("Location: " + results[1].formatted_address);
                        document.getElementById("current-location").innerHTML=results[1].formatted_address;
                    }
                }
            });
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDeEFqdpYAXbeKLGrAnVq7z73aP-2hu2vs&libraries=places"></script>
    <script type="text/javascript">
        function initialize() {
            var options = {
                componentRestrictions: {country: "se"}
            };
            var input = document.getElementById('searchTextField');
            var autocomplete = new google.maps.places.Autocomplete(input, options);
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                document.getElementById('city2').value = place.name;
                document.getElementById('cityLat').value = place.geometry.location.lat();
                document.getElementById('cityLng').value = place.geometry.location.lng();
                var placeId = place.place_id;
                var componentForm = {
                    locality: 'short_name',
                };
                for (var i = 0; i < place.address_components.length; i++) {
                    var addressType = place.address_components[i].types[0];
                    if (componentForm[addressType]) {
                        var val = place.address_components[i][componentForm[addressType]];
                        document.getElementById("city").value = val;
                    }
                }
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <script type="text/javascript">
        function searchByAddress(){
            var latId = $("#cityLat").val();
            var lonId = $("#cityLng").val();
            window.location.href = "{{ URL::to('search-catarine') }}"+'/'+latId+'/'+lonId;
        }
    </script>
    <script>
        $(document).ready(function(){
            GetAddress();
        });
    </script>
@stop
