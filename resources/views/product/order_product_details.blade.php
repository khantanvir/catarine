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
                        <h4 class="page-title pull-left">Products</h4>
                        <ul class="breadcrumbs pull-left">
                            <li><span>Order Product Details</span></li>
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
                                    <h4 class="header-title">Order Product Detail</h4>
                                    <?php if(!empty($order) && $order->status==0){ ?>
                                    <span style="float: right; background-color: darkgreen; padding: 5px;"><a style="color: white !important;" href="{{ URL::to('order-direct-confirmation/'.$order->url) }}" class="text-secondary">Direct Confirmation</a></span>
                                    <?php }else{ ?>
                                    <span style="float: right; background-color: red; padding: 5px; color: white !important;">Already Confirmed</span>
                                    <?php } ?>
                                    <div class="single-table">
                                        <div class="table-responsive">
                                            <table class="table table-hover progress-table text-center">
                                                <thead class="text-uppercase">
                                                <tr>
                                                    <th scope="col">Product Title</th>
                                                    <th scope="col">Image</th>
                                                    <th scope="col">Catarine</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Total Price</th>
                                                    <th scope="col">Total Delivery Cost</th>
                                                    <th scope="col">Total Product Cost</th>
                                                    <th scope="col">Total Vendor Cost</th>
                                                    <th scope="col">Total Expense</th>
                                                    <th scope="col">Maintan Cost</th>
                                                    <th scope="col">Benefit</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if(!empty($order_products)){ ?>
                                                <?php foreach($order_products as $row){ ?>
                                                <tr>
                                                    <td>{{ $row->product_title }}</td>
                                                    <td><img src="{{ URL::to('public/products/main_image/'.$row->product_image) }}" height="100px" width="100px"></td>
                                                    <td>{{ \App\Models\Product::get_user_name($row->vendor_id) }}</td>
                                                    <td>{{ $row->quantity }}</td>
                                                    <td>{{ $row->price.' kr' }}</td>
                                                    <td>{{ $row->total_price.' kr' }}</td>
                                                    <td>
                                                        {{ $row->total_delivery_cost.' kr' }}<br>
                                                        {{ 'Per cost: '.$row->per_delivery_cost.' kr' }}
                                                    </td>
                                                    <td>{{ $row->total_product_cost.' kr' }}</td>
                                                    <td>{{ $row->vendor_total_price.' kr' }}</td>
                                                    <td>{{ $row->total_expense_cost.' kr' }}</td>
                                                    <td>{{ $row->maintain_cost.' kr' }}</td>
                                                    <td>{{ $row->benefit_of_product.' kr' }}</td>
                                                </tr>
                                                <?php } } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop