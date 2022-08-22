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
                        <h4 class="page-title pull-left">Catarine</h4>
                        <ul class="breadcrumbs pull-left">
                            <li><span>All Catarine Food</span></li>
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
                                    <h4 class="header-title">Catarine Food List</h4>
                                    <div class="single-table">
                                        <div class="table-responsive">
                                            <table class="table table-hover progress-table text-center">
                                                <thead class="text-uppercase">
                                                <tr>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Main Image</th>
                                                    <th scope="col">Catarine Price</th>
                                                    <th scope="col">Selling Price</th>
                                                    <th scope="col">action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach($all as $row){ ?>
                                                <tr>
                                                    <td>{{ $row->title }}</td>
                                                    <td>{{ $row->description }}</td>
                                                    <td><img src="{{ URL::to('public/products/main_image/'.$row->main_image) }}" height="200px" width="200px" /> </td>
                                                    <td>{{ $row->catarine_price }}</td>
                                                    <td>{{ $row->after_discount_price }}</td>
                                                    <td>
                                                        <ul class="d-flex justify-content-center">
                                                            <li class="mr-3"><a href="{{ URL::to('edit-catarine-food/'.$row->url) }}" class="text-secondary"><i class="fa fa-edit"></i></a></li>
                                                            <li title="change main image" class="mr-3"><a href="{{ URL::to('change-image-by-catarine/'.$row->url) }}" class="text-secondary"><i class="fa fa-image"></i></a></li>
                                                            <li title="show detail images" class="mr-3"><a href="{{ URL::to('all-detail-images-by-catarine/'.$row->url) }}" class="text-secondary"><i class="fa fa-image"></i></a></li>
                                                            <!--<li><a href="#" class="text-danger"><i class="ti-trash"></i></a></li>-->
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                            {{ $all->links() }}
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