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
                            <li><span>All Confirmed Orders</span></li>
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
                                    <h4 class="header-title">Confirmed Order List</h4>
                                    <div class="single-table">
                                        <div class="table-responsive">
                                            <table class="table table-hover progress-table text-center">
                                                <thead class="text-uppercase">
                                                <tr>
                                                    <th scope="col">Order By</th>
                                                    <th scope="col">Order Number</th>
                                                    <th scope="col">Order Date</th>
                                                    <th scope="col">Order Status</th>
                                                    <th scope="col">Total Cost</th>
                                                    <th scope="col">Total Delivery Cost</th>
                                                    <th scope="col">Sub Total</th>
                                                    <th scope="col">action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if(!empty($confirmed_orders)){ ?>
                                                <?php foreach($confirmed_orders as $row){ ?>
                                                <tr>
                                                    <td>{{ \App\Models\Product::get_user_name($row->order_by) }}</td>
                                                    <td>{{ $row->order_number }}</td>
                                                    <td>{{ date("F j, Y, g:i a",$row->order_date) }}</td>
                                                    <td>{{ $row->order_status }}</td>
                                                    <td>{{ $row->total_cost }}</td>
                                                    <td>{{ $row->delivery_charge }}</td>
                                                    <td>{{ $row->sub_total }}</td>
                                                    <td>
                                                        <a href="{{ URL::to('get-order-details-by-admin/'.$row->url) }}" class="text-secondary" target="_blank"><i class="fa fa-book"></i></a>
                                                    </td>
                                                </tr>
                                                <?php } } ?>
                                                </tbody>
                                            </table>
                                            {{ $confirmed_orders->links() }}
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