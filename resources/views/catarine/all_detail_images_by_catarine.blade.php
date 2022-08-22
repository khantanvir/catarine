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
                            <li><span>All Detail Images By Catarine</span></li>
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
                                    <h4 class="header-title">Catarine Food Item Image List</h4>
                                    <form method="post" action="{{ URL::to('create-product-images-by-catarine-post') }}" enctype="multipart/form-data">
                                        @csrf
                                        <h4 class="header-title">Add new Images</h4>
                                        <div class="form-group">
                                            <div id="TextBoxContainer">
                                                <label for="example-text-input" class="col-form-label">Chose More Images</label>
                                                <div class="input-group">
                                                    <input type="hidden" name="product_url" value="{{ $product->url }}">
                                                    <div class="custom-file">
                                                        <input type="file" name="more_images[]" class="custom-file-input" id="exampleInputFile">
                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <input style="width: 45px;" class="pull-right add-btn" id="btnAdd" type="button" value="+" class="btn btn-block"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Upload</button>
                                    </form>
                                    <div class="single-table">
                                        <div class="table-responsive">
                                            <table class="table table-hover progress-table text-center">
                                                <thead class="text-uppercase">
                                                <tr>
                                                    <th scope="col">Id</th>
                                                    <th scope="col">Image</th>
                                                    <th scope="col">action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach($product_images as $row){ ?>
                                                <tr>
                                                    <td>{{ $row->id }}</td>
                                                    <td><img src="{{ URL::to('public/products/more_images/'.$row->image) }}" height="250px" width="250px" /> </td>
                                                    <td>
                                                        <ul class="d-flex justify-content-center">
                                                            <li class="mr-3"><a href="{{ URL::to('delete-detail-image/'.$row->id) }}" class="text-secondary"><i class="ti-trash"></i></a></li>
                                                            <!--<li><a href="#" class="text-danger"><i class="ti-trash"></i></a></li>-->
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                            {{ $product_images->links() }}
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
        function GetDynamicTextBox() {
            return '<div id="appending" class="add-image clearfix">'+
                '<div style="margin-top: 10px;" class="input-group">'+
                '<div class="custom-file">'+
                '<input type="file" name="more_images[]" class="custom-file-input" id="exampleInputFile">'+
                '<label class="custom-file-label" for="exampleInputFile">Choose file</label>'+
                '</div>'+
                '<div class="input-group-append">'+
                '<input style="width: 45px;" type="button" value="-" class="remove btn red pull-right" />'+
                '</div>'+
                '</div>'+
                '</div>'
        }
        $(function () {
            $("#btnAdd").bind("click", function () {
                var div = $("<div />");
                div.html(GetDynamicTextBox(""));
                $("#TextBoxContainer").append(div);
            });
            $("#btnGet").bind("click", function () {
                var values = "";
                $("input[name=DynamicTextBox[]]").each(function () {
                    values += $(this).val() + "\n";
                });
                alert(values);
            });
            $("body").on("click", ".remove", function () {
                $(this).closest("#appending").remove();
            });
        });
    </script>
@stop