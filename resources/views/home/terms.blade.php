@extends('userpanel.index')
@section('userpanel')
    <link rel="stylesheet" href="{{ URL::to('public/front/restaurent/css/restaurant.css' ) }}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::to('public/front/restaurent/css/fonts.css' ) }}" type="text/css" />
    <section id="page-title">

        <div class="container clearfix">
            <h1>Confirmation Page</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ URL::to('checkout') }}">Checkout</a></li>
                <li class="breadcrumb-item active" aria-current="page">Confirmation</li>
            </ol>
        </div>

    </section><!-- #page-title end -->
    <!-- Content
            ============================================= -->
    <section id="content">

        <div class="content-wrap">

            <div class="container clearfix">
                <p>
                    Website terms and conditions are vital to the long-term success and security of your online business, as they outline the rules by which you and your users must abide. Without terms, you could be subject to abusive users, intellectual property theft, and unnecessary litigation.

                    Our free terms and conditions template will help provide your business with the legal protection it deserves. Download the standard template below, or simply copy and paste the text onto your site.

                    Alternatively, keep reading to learn more about what a terms and conditions agreement is and how to start writing your own.
                </p>
            </div>

        </div>

    </section><!-- #content end -->
@stop