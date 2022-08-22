@extends('userpanel.index')
@section('userpanel')

    <style>
        .blink{
            width:auto;
            height: auto;
            background-color: green;
            padding: 5px;
            text-align: center;
            line-height: 25px;
        }
        .blink-spn{
            font-size: 20px;
            font-family: cursive;
            color: WHITE;
            animation: blink 3s linear infinite;
        }
        @keyframes blink{
            0%{opacity: 0;}
            50%{opacity: .5;}
            100%{opacity: 1;}
        }
    </style>
    <!-- Page Title
		============================================= -->
    <link rel="stylesheet" href="{{ URL::to('public/front/restaurent/css/restaurant.css' ) }}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::to('public/front/restaurent/css/fonts.css' ) }}" type="text/css" />
    <section id="page-title">

        <div class="container clearfix">
            <h1>{{ $details->title }}</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Hem</a></li>
                <li class="breadcrumb-item"><a href="{{ URL::to('search-catarine') }}">Catarine</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ (!empty($catarine->name))?$catarine->name:'' }}</li>
            </ol>
        </div>

    </section><!-- #page-title end -->

    <section id="content">

        <div class="content-wrap">

            <div class="container clearfix">

                <div class="postcontent nobottommargin clearfix">

                    <div class="single-product">

                        <div class="product">

                            <div class="col_half">

                                <!-- Product Single - Gallery
                                ============================================= -->
                                <div class="product-image">
                                    <div class="fslider" data-pagi="false" data-arrows="false" data-thumbs="true">
                                        <div class="flexslider">
                                            <div class="slider-wrap" data-lightbox="gallery">
                                                <?php if(!empty($more_images)){ ?>
                                                <?php foreach($more_images as $image){ ?>
                                                    <div style="height: 540px;" class="slide" data-thumb="{{ URL::to('public/products/more_images/'.$image->image ) }}"><a href="{{ URL::to('public/products/more_images/'.$image->image ) }}" title="{{ $details->title }} - Front View" data-lightbox="gallery-item"><img height="540px" src="{{ URL::to('public/products/more_images/'.$image->image ) }}" alt="{{ $details->title }}"></a></div>
                                                <?php } } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sale-flash">Försäljning!</div>
                                </div><!-- Product Single - Gallery End -->

                            </div>

                            <div class="col_half col_last product-desc">

                                <!-- Product Single - Price
                                ============================================= -->
                                <div class="product-price"><?php if(!empty($details->discount==0)){ ?><ins>{{ $details->after_discount_price.' kr' }}</ins> <?php }else{ ?><del>{{ $details->selling_price.' kr' }}</del> <ins>{{ $details->after_discount_price.' kr' }}</ins> <?php } ?></div><!-- Product Single - Price End -->

                                <!-- Product Single - Rating
                                ============================================= -->
                                <div class="product-rating">
                                    <?php for($j=1; $j<=5; $j++){ ?>
                                    <?php if($j <= $msg_count){ ?>
                                        <i class="icon-star3"></i>
                                    <?php }else{ ?>
                                        <i class="icon-star-empty"></i>
                                    <?php } ?>
                                    <?php } ?>
                                </div><!-- Product Single - Rating End -->

                                <div class="clear"></div>
                                <div class="line"></div>

                                <!-- Product Single - Quantity & Cart Button
                                ============================================= -->
                                <div class="cart nobottommargin clearfix">
                                    <div class="quantity clearfix">
                                        <input type="hidden" name="product_url" id="product_url" value="{{ $details->url }}" />
                                        <input type="button" value="-" class="minus">
                                        <input type="text" step="1" min="1"  name="quantity" id="quantity" value="1" title="Qty" class="qty" size="4" />
                                        <input type="button" value="+" class="plus">
                                    </div>
                                    <button onclick="addToCart()" class="add-to-cart button nomargin">Lägg till i kundvagn</button>
                                </div><!-- Product Single - Quantity & Cart Button End -->

                                <div class="clear"></div>
                                <div class="line"></div>

                                <!-- Product Single - Short Description
                                ============================================= -->
                                <div class="blink"><span class="blink-spn">Direktkontakt: +460703338161</span></div>
                                <h2>{{ $details->title }}</h2>
                                <p>{{ $details->description }}</P>

                            </div>

                            <div class="col_full nobottommargin">

                                <div class="tabs clearfix nobottommargin" id="tab-1">

                                    <ul class="tab-nav clearfix">
                                        <li><a href="#tabs-1"><i class="icon-align-justify2"></i><span class="d-none d-md-inline-block">Katarinbeskrivning</span></a></li>
                                        <li><a href="#tabs-3"><i class="icon-star3"></i><span id="count-feedback" class="d-none d-md-inline-block"> Recensioner ({{ count($feedbacks) }})</span></a></li>
                                    </ul>

                                    <div class="tab-container">

                                        <div class="tab-content clearfix" id="tabs-1">
                                            <p>{{ (!empty($catarine->bio))?$catarine->bio:'' }}</p>
                                        </div>
                                        <div class="tab-content clearfix" id="tabs-3">

                                            <div id="reviews" class="clearfix">

                                                <ol id="feedback-list" class="commentlist clearfix">
                                                    <?php $z=0; if(!empty($feedbacks)){ ?>
                                                    <?php foreach($feedbacks as $msg){ ?>
                                                    <?php if($z < 3){ ?>
                                                    <li class="comment even thread-even depth-1" id="li-comment-1">
                                                        <div id="comment-1" class="comment-wrap clearfix">
                                                            <div class="comment-meta">
                                                                <div class="comment-author vcard">
																		<span class="comment-avatar clearfix">
																		<img alt="" src="{{ URL::to(\App\Models\Redlep::randomProfileImage()) }}" height="60" width="60" /></span>
                                                                </div>
                                                            </div>
                                                            <div class="comment-content clearfix">
                                                                <div class="comment-author">{{ $msg->name }}<span><a href="#" title="Permalink to this comment">{{ date('d F Y, h:i:s A',$msg->date) }}</a></span></div>
                                                                <p>{{ $msg->message }}</p>
                                                                <div class="review-comment-ratings">
                                                                    <?php for($i=1; $i<=5; $i++){ ?>
                                                                    <?php if($i <= $msg->rating){ ?>
                                                                        <i class="icon-star3"></i>
                                                                    <?php }else{ ?>
                                                                        <i class="icon-star-empty"></i>
                                                                    <?php } ?>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>

                                                            <div class="clear"></div>

                                                        </div>
                                                    </li>
                                                    <?php $z++; } } } ?>

                                                </ol>

                                                <!-- Modal Reviews
                                                ============================================= -->
                                                <a href="#" data-toggle="modal" data-target="#reviewFormModal" class="button button-3d nomargin fright">Lägg till en recension</a>

                                                <div class="modal fade" id="reviewFormModal" tabindex="-1" role="dialog" aria-labelledby="reviewFormModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="reviewFormModalLabel">Skicka en recension</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="nobottommargin" id="template-reviewform">
                                                                    <input type="hidden" name="product_url" id="product_url" value="{{ $details->url }}" />

                                                                    <div class="col_half">
                                                                        <label for="template-reviewform-name">Namn <small>*</small></label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <div class="input-group-text"><i class="icon-user"></i></div>
                                                                            </div>
                                                                            <input type="text" id="name" name="name" value="" class="form-control required" />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col_half col_last">
                                                                        <label for="template-reviewform-email">E-post <small>*</small></label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><div class="input-group-text">@</div></div>
                                                                            <input type="text" id="email" name="email" value="" class="required email form-control" />
                                                                        </div>
                                                                    </div>

                                                                    <div class="clear"></div>

                                                                    <div class="col_full col_last">
                                                                        <label for="template-reviewform-rating">Betyg</label>
                                                                        <select id="rating" name="rating" class="form-control">
                                                                            <option value="">-- Välj en --</option>
                                                                            <option value="1">1</option>
                                                                            <option value="2">2</option>
                                                                            <option value="3">3</option>
                                                                            <option value="4">4</option>
                                                                            <option value="5">5</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="clear"></div>

                                                                    <div class="col_full">
                                                                        <label for="template-reviewform-comment">Kommentar <small>*</small></label>
                                                                        <textarea class="required form-control" id="message" name="message" rows="6" cols="30"></textarea>
                                                                    </div>

                                                                    <div class="col_full nobottommargin">
                                                                        <button class="button button-3d nomargin" id="template-reviewform-submit" onclick="submitReview()" name="template-reviewform-submit" value="submit">Skicka recension</button>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" id="modal-data-dismiss" class="btn btn-secondary" data-dismiss="modal">Stänga</button>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                                <!-- Modal Reviews End -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="line"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>

                    <div class="col_full nobottommargin">

                        <h4>Relaterade produkter</h4>

                        <div id="oc-product" class="tab-container mt-4" data-margin="30" data-pagi="false" data-autoplay="5000" data-items-xs="1" data-items-md="2" data-items-xl="4">

                            <div class="tab-content clearfix" id="tabs-salad">
                                <div class="row clearfix">
                                    <?php $i=0; if(!empty($related)){ ?>
                                    <?php foreach($related as $row){ ?>
                                        <input type="hidden" name="product_url" id="product_url<?=$i?>" value="{{ $row->url }}" />
                                        <div class="col-lg-3 col-md-6">
                                        <div class="iportfolio mb-4 clearfix">
                                            <a href="{{ URL::to('catarine-product-details/'.$row->url) }}" class="portfolio-image"><img src="{{ URL::to('public/products/main_image/'.$row->main_image ) }}" alt="1" class="rounded"></a>
                                            <div class="portfolio-desc pt-2">
                                                <h4 class="mb-1"><a href="{{ URL::to('catarine-product-details/'.$row->url) }}">{{ $row->title }}</a></h4>
                                                <div class="item-price">{{ $row->after_discount_price.' kr' }} <a onclick="addToCartFromList(<?=$i?>)" style="float: right;" href="javascript://"><i class="icon-cart-plus"></i></a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $i++; } } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section><!-- #content end -->
@stop
