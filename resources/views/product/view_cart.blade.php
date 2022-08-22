@extends('userpanel.index')
@section('userpanel')
<link rel="stylesheet" href="{{ URL::to('public/front/restaurent/css/restaurant.css' ) }}" type="text/css" />
<link rel="stylesheet" href="{{ URL::to('public/front/restaurent/css/fonts.css' ) }}" type="text/css" />
<section id="page-title">

    <div class="container clearfix">
        <h1>Visa kundvagn</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Hem</a></li>
            <li class="breadcrumb-item"><a href="{{ URL::to('search-catarine') }}">Catarine</a></li>
            <li class="breadcrumb-item active" aria-current="page">Varukorg Kassa</li>
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
            <form id="login-form" name="order-form" class="nobottommargin" action="{{ URL::to('create-order') }}" method="post" enctype="multipart/form-data">
                @csrf
            <div class="table-responsive">
                <table class="table cart">
                    <thead>
                    <tr>
                        <th class="cart-product-remove">&nbsp;</th>
                        <th class="cart-product-thumbnail">&nbsp;</th>
                        <th class="cart-product-name">Produkt</th>
                        <th class="cart-product-price">Enhetspris</th>
                        <th class="cart-product-delivery">Per matleverans</th>
                        <th class="cart-product-delivery">Kostnad per mat med leverans</th>
                        <th class="cart-product-quantity">Kvantitet</th>
                        <th class="cart-product-subtotal">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $delivery=0; $total=0; $i=0; if(!empty($carts)){ ?>
                    <?php foreach($carts as $cart){ ?>
                    <?php $get_product = \App\Models\Product::where('id',$cart['product_id'])->first(); ?>
                    <tr class="cart_item">
                        <td class="cart-product-remove">
                            <a href="{{ URL::to('remove-from-cart-page/'.$cart['product_id']) }}" class="remove" title="Remove this item"><i class="icon-trash2"></i></a>
                            <input type="hidden" name="product_id[]" id="product_id" value="{{ $get_product->id }}"/>
                        </td>

                        <td class="cart-product-thumbnail">
                            <a href="{{ URL::to('catarine-product-details/'.$get_product->url) }}"><img width="64" height="64" src="{{ URL::to('public/products/main_image/'.$get_product->main_image) }}" alt="Checked Canvas Shoes"></a>
                        </td>

                        <td class="cart-product-name">
                            <a href="{{ URL::to('catarine-product-details/'.$get_product->url) }}">{{ $get_product->title }}</a>
                            <input type="hidden" name="title[]" id="title" value="{{ $get_product->title }}"/>
                        </td>

                        <td class="cart-product-price">
                            <span class="amount">{{ $get_product->after_discount_price.' kr' }}</span>
                            <input type="hidden" name="amount[]" id="amount" value="{{ $get_product->after_discount_price }}"/>
                        </td>

                        <td class="cart-product-price">
                            <span class="amount">{{ (!empty($get_product->delivery_cost))?$get_product->delivery_cost.' kr':'Free Delivery' }}</span>
                            <input type="hidden" name="delivery_cost[]" id="delivery_cost" value="{{ $get_product->delivery_cost }}"/>
                        </td>

                        <td class="cart-product-price">
                            <span class="amount">{{ $get_product->after_discount_price + $get_product->delivery_cost.' kr' }}</span>
                            <input type="hidden" name="per_food_cost_with_delivery[]" id="per_food_cost_with_delivery" value="{{ $get_product->after_discount_price + $get_product->delivery_cost }}"/>
                        </td>

                        <td class="cart-product-quantity">
                            <span class="amount">{{ $cart['quantity'] }}</span>
                            <div class="quantity clearfix">
                                <input type="hidden" id="quantity{{ $i }}" name="quantity[]" value="{{ $cart['quantity'] }}" class="qty" />
                            </div>
                        </td>

                        <td class="cart-product-subtotal">
                            <span class="amount">{{ $cart['quantity'] * ($get_product->after_discount_price + $get_product->delivery_cost).' kr' }}</span>
                        </td>
                    </tr>
                    <?php $i++; $total += $cart['sub_total']; $delivery += $get_product->delivery_cost * $cart['quantity']; } } ?>
                    </tbody>

                </table>
            </div>
            <div class="row clearfix">
                <div class="col-lg-6">
                    <div class="col-12 bottommargin-sm">
                        <h4>Välj betalning</h4>

                        <div class="form-check">
                            <input style="margin-top: 16px;" class="form-check-input" type="radio" name="payment_type" id="template-contactform-radio-label3" value="1" checked>
                            <label class="form-check-label" for="template-contactform-radio-label3"><a href="javascript://" title="Payson internetbetalningar" style="width: 170px; height: 70px; background: url('https://www.payson.se/sites/all/files/images/external/PayBtn_BgImg.png') no-repeat scroll 0% 0% transparent; display: block; text-indent: 75px; padding-top: 15px; text-decoration: none; font-size: 16px; font-family: Arial; font-weight: bold; color: #00245D;">Payson</a></label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h4>Totalt vagn</h4>

                    <div class="table-responsive">
                        <table class="table cart">
                            <tbody>
                            <tr class="cart_item">
                                <td class="cart-product-name">
                                    <strong>Kundvagn Subtotal</strong>
                                </td>

                                <td class="cart-product-name">
                                    <span class="amount">{{ $total.' kr' }}</span>
                                    <input type="hidden" name="total_cost" value="{{ $total }}">
                                </td>
                            </tr>
                            <tr class="cart_item">
                                <td class="cart-product-name">
                                    <strong>Frakt</strong>
                                </td>

                                <td class="cart-product-name">
                                    <span class="amount">{{ $delivery.' kr' }}</span>
                                    <input type="hidden" name="total_delivery_charge" value="{{ $delivery }}">
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
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-6">
                    <div class="row checkout-form-billing">
                        <div class="col-12">
                            <h3>Kontoinformation </h3>
                        </div>
                        <div class="col-12 form-group">
                            <label>Förnamn:</label>
                            <input type="text" name="first_name" id="checkout-form-billing-name" class="form-control required" value="{{ (!empty($user_info->first_name))?$user_info->first_name : old('first_name') }}" placeholder="First Name">
                        </div>
                        <div class="col-12 form-group">
                            <label>Efternamn:</label>
                            <input type="text" name="last_name" id="checkout-form-billing-name" class="form-control" value="{{ (!empty($user_info->last_name))?$user_info->last_name : old('last_name') }}" placeholder="Last Name">
                        </div>
                        <div class="col-12 form-group">
                            <label>E-post:</label>
                            <input type="email" name="email" id="checkout-form-billing-email" class="form-control" value="{{ (!empty($user_info->email))?$user_info->email : old('email') }}" placeholder="user@company.com">
                        </div>
                        <?php if(!Auth::check()){ ?>
                        <div class="col-12 form-group">
                            <label>Lösenord:</label>
                            <input type="password" name="password" id="" class="form-control required" value="" placeholder="">
                        </div>
                        <div class="col-12 form-group">
                            <label>Bekräfta lösenord:</label>
                            <input type="password" name="confirm_password" id="" class="form-control required" value="" placeholder="">
                        </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="col-lg-6 mt-5 mt-lg-0">
                        <div class="row checkout-form-shipping">
                        <div class="col-12">
                            <h3>Fraktinformation</h3>
                        </div>
                        <div class="col-12 form-group">
                            <label>Förnamn:</label>
                            <input type="text" name="s_first_name" id="checkout-form-shipping-name" class="form-control required" value="{{ (!empty($user_detail->first_name))?$user_detail->first_name : old('s_first_name') }}" placeholder="">
                        </div>
                        <div class="col-12 form-group">
                            <label>Efternamn:</label>
                            <input type="text" name="s_last_name" id="checkout-form-shipping-name" class="form-control required" value="{{ (!empty($user_detail->last_name))?$user_detail->last_name : old('s_last_name') }}" placeholder="">
                        </div>

                        <div class="col-12 form-group">
                            <label>E-post:</label>
                            <input type="text" name="s_email" id="checkout-form-shipping-name" class="form-control required" value="{{ (!empty($user_detail->email))?$user_detail->email : old('s_email') }}" placeholder="">
                        </div>

                        <div class="col-12 form-group bottommargin-sm">
                            <label for="template-contactform-date">Leveransdatum Tid:</label>
                            <div class="form-group mb-0">
                                <div class="input-group tleft">
                                    <div class="input-group-prepend" data-target=".datetimepicker1" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="icon-calendar3"></i></div>
                                    </div>
                                    <input id="" value="" name="datetime" type="datetime-local" class="form-control datetimepicker-input datetimepicker1" placeholder="Select your Flexible Date & Time" />
                                </div>
                            </div>
                        </div>


                        <div class="col-12 form-group">
                            <label>Tel:</label><br>
                            <input type="text" name="s_phone" id="checkout-form-shipping-phone" class="form-control required" value="{{ (!empty($user_detail->phone))?$user_detail->phone : old('s_phone') }}" placeholder="02-232-2424">
                        </div>
                        <div class="col-12 form-group">
                            <label>Address:</label>
                            <input type="text" name="s_address" id="checkout-form-shipping-street" class="form-control required" value="{{ (!empty($user_detail->address))?$user_detail->address : old('s_address') }}">
                        </div>
                        <div class="col-12 form-group">
                            <label>Lägenhet, svit, enhet etc.:</label>
                            <input type="text" name="s_apartment" id="checkout-form-shipping-apartment" class="form-control required" value="{{ (!empty($user_detail->apartment))?$user_detail->apartment : old('s_apartment') }}">
                        </div>
                        <div class="col-12 form-group">
                            <label>Stad:</label>
                            <input type="text" name="s_city" id="checkout-form-shipping-city" class="form-control required" value="{{ (!empty($user_detail->city))?$user_detail->city : old('s_city') }}">
                        </div>
                        <div class="col-12 form-group">
                            <label>Postnummer:</label>
                            <input type="text" name="s_post_code" id="checkout-form-shipping-post-code" class="form-control required" value="{{ (!empty($user_detail->post_code))?$user_detail->post_code : old('s_post_code') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div style="text-align: center;" class="col-12 nopadding">
                    <button type="submit" class="button button-3d notopmargin">Fortsätt till utcheckningen</button>
                </div>
            </div>
            </form>
        </div>

    </div>

</section><!-- #content end -->
@stop
