@extends('userpanel.index')
@section('userpanel')
    <link rel="stylesheet" href="{{ URL::to('public/front/restaurent/css/restaurant.css' ) }}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::to('public/front/restaurent/css/fonts.css' ) }}" type="text/css" />
    <section id="page-title">

        <div class="container clearfix">
            <h1>Kassasida</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Hem</a></li>
                <li class="breadcrumb-item"><a href="{{ URL::to('view-cart') }}">Vagn</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kolla upp</li>
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
                <div class="row clearfix">
                    <div class="col-lg-6">
                        <h4>Dina beställningar</h4>

                        <div class="table-responsive">
                            <table class="table cart">
                                <thead>
                                <tr>
                                    <th class="cart-product-thumbnail">&nbsp;</th>
                                    <th class="cart-product-name">Produkt</th>
                                    <th class="cart-product-quantity">Kvantitet</th>
                                    <th class="cart-product-subtotal">Enhetspris</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $delivery=0; $total=0; $i=0; if(!empty($cart)){ ?>
                                <?php foreach($cart as $row){ ?>
                                <?php $getProduct = \App\Models\Product::where('id',$row['product_id'])->first(); ?>
                                <tr class="cart_item">
                                    <td class="cart-product-thumbnail">
                                        <a target="_blank" href="{{ URL::to('catarine-product-details/'.$getProduct->url) }}"><img width="64" height="64" src="{{ URL::to('public/products/main_image/'.$getProduct->main_image) }}" alt="{{ $getProduct->title }}"></a>
                                    </td>
                                    <td class="cart-product-name">
                                        <a target="_blank" href="{{ URL::to('catarine-product-details/'.$getProduct->url) }}">{{ $getProduct->title }}</a>
                                    </td>
                                    <td class="cart-product-quantity">
                                        <div class="quantity clearfix">
                                            1x{{ $row['quantity'] }}
                                        </div>
                                    </td>
                                    <td class="cart-product-subtotal">
                                        <span class="amount">{{ $getProduct->after_discount_price.' kr' }}</span>
                                    </td>
                                </tr>
                                <?php $i++; $total += $row['sub_total']; $delivery += $getProduct->delivery_cost * $row['quantity']; } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-6">
                    <h4>Totalt vagn</h4>
                    <div class="table-responsive">
                        <table class="table cart">
                            <tbody>
                            <tr class="cart_item">
                                <td class="notopborder cart-product-name">
                                    <strong>Kundvagn Subtotal</strong>
                                </td>
                                <td class="notopborder cart-product-name">
                                    <span class="amount">{{ $total.' kr' }}</span>
                                </td>
                            </tr>
                            <tr class="cart_item">
                                <td class="cart-product-name">
                                    <strong>Frakt</strong>
                                </td>
                                <td class="cart-product-name">
                                    <span class="amount">{{ $delivery.' kr' }}</span>
                                </td>
                            </tr>
                            <tr class="cart_item">
                                <td class="cart-product-name">
                                    <strong>Total</strong>
                                </td>
                                <td class="cart-product-name">
                                    <span class="amount color lead"><strong>{{ $total + $delivery.' kr' }}</strong></span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="accordion clearfix">
                        <?php if(!empty($after_order['snippet'])){echo $after_order['snippet'];} ?>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </section><!-- #content end -->
@stop