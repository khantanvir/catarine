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
                                    <form method="post" action="{{ URL::to('create-product-by-catarine-post') }}" enctype="multipart/form-data">
                                        @csrf
                                        <h4 class="header-title">Create Your Selling Product</h4>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Title</label>
                                            <input class="form-control" name="title" type="text" value="{{ old('title') }}" id="example-text-input">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Description</label>
                                            <textarea class="form-control" name="description">{{ old('description') }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Chose Main Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="main_image" class="custom-file-input" id="exampleInputFile">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="">Upload</span>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div id="TextBoxContainer">
                                                <label for="example-text-input" class="col-form-label">Chose More Images</label>
                                                <div class="input-group">
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



                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Select Product Type</label>
                                            <select class="form-control" name="product_type">
                                                <option>-</option>
                                                <option value="1">Regular</option>
                                                <option value="2">Special</option>
                                                <option value="3">Salad & Drink</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Catarine Price</label>
                                            <input class="form-control" name="catarine_price" type="text" value="{{ old('catarine_price') }}" id="example-text-input">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Selling Price</label>
                                            <input class="form-control" id="selling_price" name="selling_price" type="text" value="{{ old('selling_price') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Discount</label>
                                            <input class="form-control" id="discount" name="discount" type="text" value="{{ old('discount') }}" onchange="getDiscount()">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">After Discount Price</label>
                                            <input class="form-control" name="after_discount_price" type="text" value="{{ old('after_discount_price') }}" id="after_discount_price">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Delivery Cost</label>
                                            <input class="form-control" name="delivery_cost" type="text" value="{{ old('delivery_cost') }}" id="example-text-input">
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