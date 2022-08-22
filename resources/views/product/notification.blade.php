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
            </div>

        </div>

    </section><!-- #content end -->
@stop