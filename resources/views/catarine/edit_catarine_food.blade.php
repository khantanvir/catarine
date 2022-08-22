@extends('adminpanel.index')
@section('adminpanel')
    <div class="main-content">
        <div class="header-area">
            <div class="row align-items-center">
                <!-- nav and search button -->
                <div class="col-md-6 col-sm-8 clearfix">
                    <div class="nav-btn pull-left">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <!-- profile info & task notification -->
            </div>
        </div>
        <!-- header area end -->
        <!-- page title area start -->
        <div class="page-title-area">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="breadcrumbs-area clearfix">
                        <h4 class="page-title pull-left">Catarine Home</h4>
                        <ul class="breadcrumbs pull-left">
                            <li><span>Create Product</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 clearfix">
                    <div class="user-profile pull-right">
                        <img class="avatar user-thumb" src="{{ URL::to('public/admin/assets/images/author/avatar.png' ) }}" alt="avatar">
                        <h4 class="user-name dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->name }} <i class="fa fa-angle-down"></i></h4>
                        <div class="dropdown-menu">
                            <?php if(Auth::check()){ ?>
                            <a class="dropdown-item" href="{{ URL::to('signout') }}">Log Out</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-content-inner">
            <div class="row">
                <div class="col-lg-6 col-ml-12">
                    <div class="row">
                        <div class="col-md-12">
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
                        <!-- Textual inputs start -->
                        <div class="col-12 mt-5">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" action="{{ URL::to('edit-product-by-catarine-post') }}" enctype="multipart/form-data">
                                        @csrf
                                        <h4 class="header-title">Edit Your Selling Product</h4>
                                        <div class="form-group">
                                            <input type="hidden" name="id" value="{{ $product->id }}">
                                            <label for="example-text-input" class="col-form-label">Title</label>
                                            <input class="form-control" name="title" type="text" value="{{ $product->title }}" id="example-text-input">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Description</label>
                                            <textarea class="form-control" name="description">{{ $product->description }}</textarea>
                                        </div>


                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Select Product Type</label>
                                            <select class="form-control" name="product_type">
                                                <option>-</option>
                                                <option {{ (!empty($product->product_type) && $product->product_type==1)?'selected':'' }} value="1">Regular</option>
                                                <option {{ (!empty($product->product_type) && $product->product_type==2)?'selected':'' }} value="2">Special</option>
                                                <option {{ (!empty($product->product_type) && $product->product_type==3)?'selected':'' }} value="2">Salad & Drink</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Catarine Price</label>
                                            <input class="form-control" name="catarine_price" type="text" value="{{ $product->catarine_price }}" id="example-text-input">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Selling Price</label>
                                            <input class="form-control" id="selling_price" name="selling_price" type="text" value="{{ $product->selling_price }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Discount</label>
                                            <input class="form-control" id="discount" name="discount" type="text" value="{{ $product->discount }}" onchange="getDiscount()">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">After Discount Price</label>
                                            <input class="form-control" name="after_discount_price" type="text" value="{{ $product->after_discount_price }}" id="after_discount_price">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Delivery Cost</label>
                                            <input class="form-control" name="delivery_cost" type="text" value="{{ $product->delivery_cost }}" id="example-text-input">
                                        </div>

                                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        function getDiscount(){
            var discount = $('#discount').val();
            var selling_price = $('#selling_price').val();
            if(discount !=="" && selling_price !==""){
                $.ajax({
                    url: '{{ URL::to('products/get_discount') }}',
                    data: { 'selling_price':selling_price,'discount':discount },
                    type: 'POST',
                    dataType: 'html',
                    success:function (result) {
                        console.log(JSON.stringify(result));
                        data = JSON.parse(result)
                        if(data['result']['key'] == "200"){
                            $('#after_discount_price').val(data['result']['val']);
                        }
                        if(data['result']['key'] == "102"){
                            alert(data['result']['val']);
                        }
                        if(data['result']['key'] == "101"){
                            alert(data['result']['val']);
                            $('#selling_price').val("");
                            $('#discount').val("");
                        }
                    },
                    error:function(exception){alert('Exeption:'+JSON.stringify(exception));}
                });
            }else{
                return false;
            }
        }
    </script>
@stop