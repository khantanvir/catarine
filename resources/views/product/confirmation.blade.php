@extends('userpanel.index')
@section('userpanel')
    <link rel="stylesheet" href="{{ URL::to('public/front/restaurent/css/restaurant.css' ) }}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::to('public/front/restaurent/css/fonts.css' ) }}" type="text/css" />
    <section id="page-title">

        <div class="container clearfix">
            <h1>Bekräftelsessida</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Hem</a></li>
                <li class="breadcrumb-item"><a href="{{ URL::to('checkout') }}">Kolla upp</a></li>
                <li class="breadcrumb-item active" aria-current="page">Bekräftelse</li>
            </ol>
        </div>

    </section><!-- #page-title end -->
    <!-- Content
            ============================================= -->
    <section id="content">

        <div class="content-wrap">

            <div class="container clearfix">
                <h3>Tack För Din Beställning <span><a href="{{ URL::to('profile') }}">Gå Till Beställningslista</a></span></h3>
            </div>
            <div>
                <?php if(!empty($info['snippet'])){ ?>
                <?php echo $info['snippet']; ?>
                <?php } ?>
            </div>
        </div>

    </section><!-- #content end -->
@stop