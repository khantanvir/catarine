@extends('userpanel.index')
@section('userpanel')
    <section id="page-title">
        <div class="container clearfix">
            <h1>KONTAKTA OSS</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Hem</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kontakta Oss</li>
            </ol>
        </div>
    </section>
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="">
                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            <strong> {{ Session::get('success') }}</strong>
                        </div>
                    @endif
                    @if(Session::has('error'))
                        <div class="alert alert-danger">
                            <strong> {{ Session::get('error') }}</strong>
                        </div>
                    @endif

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="col_half">
                    <div class="fancy-title title-dotted-border">
                        <h3>Skicka oss ett e-mail</h3>
                    </div>
                    <div class="acc_content clearfix">
                        <form id="login-form" name="login-form" class="nobottommargin" action="{{ URL::to('contact-us-post-data') }}" method="post">
                            @csrf
                            <div class="col_two_third">
                                <label for="login-form-username">Namn:</label>
                                <input type="text" id="login-form-username" name="name" value="" class="form-control" />
                            </div>
                            <div class="col_two_third">
                                <label for="login-form-username">E-post/Telefon:</label>
                                <input type="text" id="login-form-username" name="email" value="" class="form-control" />
                            </div>
                            <div class="col_full">
                                <label for="login-form-username">Ämne:</label>
                                <input type="text" id="login-form-username" name="subject" value="" class="form-control" />
                            </div>

                            <div class="col_full">
                                <label for="template-contactform-message">Meddelande <small>*</small></label>
                                <textarea class="sm-form-control" name="message" rows="6" cols="30"></textarea>
                            </div>
                            <div class="col_full nobottommargin">
                                <button class="button button-3d button-black nomargin" id="login-form-submit" name="login-form-submit" value="submit" type="submit">Skicka in</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col_half col_last">
                    <section id="google-map" class="gmap" style="height: 410px;"></section>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </section>
    <link rel="icon" href="{{ URL::to('public/front/images/icons/dotted.png' ) }}" type="text/html" />
    <script src="{{ URL::to('public/front/js/jquery.js' ) }}"></script>
    <script src="{{ URL::to('public/front/js/plugins.js' ) }}"></script>
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyBKI8oyydmgWAtwdNXuX5K5l9E4eSbBCdk"></script>
    <script src="{{ URL::to('public/front/js/jquery.gmap.js' ) }}"></script>
    <script>

        jQuery('#google-map').gMap({
            address: 'kista Stockholm, Sweden',
            maptype: 'ROADMAP',
            longitude: 17.8876479,
            latitude: 59.2635432,
            zoom: 14,
            markers: [
                {
                    address: "kista Stockholm, Sweden",
                    html: '<div style="width: 300px;"><h4 style="margin-bottom: 8px;">Hi, we\'re <span>Envato</span></h4><p class="nobottommargin">Our mission is to help people to <strong>earn</strong> and to <strong>learn</strong> online. We operate <strong>marketplaces</strong> where hundreds of thousands of people buy and sell digital goods every day, and a network of educational blogs where millions learn <strong>creative skills</strong>.</p></div>',
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