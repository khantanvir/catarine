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
                            <li><span>Update Catarine Info</span></li>
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
                                    <form method="post" action="{{ URL::to('change-catarine-profile-info-post') }}" enctype="multipart/form-data">
                                        @csrf
                                        <h4 class="header-title">Update Catarine Profile</h4>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Company Name</label>
                                            <input class="form-control" name="company_name" type="text" value="{{ (!empty($profile->name))?$profile->name:'' }}" id="example-text-input">
                                        </div>
                                        <div class="form-group">
                                            <label for="address" class="col-form-label">Address</label>
                                            <div>
                                                <input id="searchTextField" name="address" value="{{ (!empty($profile->address))?$profile->address:'' }}" class="form-control" type="text" size="50" placeholder="Enter a location" autocomplete="on" runat="server" />
                                                <input type="hidden" id="city2" name="city2" />
                                                <input type="hidden" id="cityLat" name="cityLat" />
                                                <input type="hidden" id="cityLng" name="cityLng" />
                                                <input type="hidden" id="city" name="city" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Zip Code</label>
                                            <input class="form-control" name="zip_code" type="text" value="{{ (!empty($profile->zip_code))?$profile->zip_code:'' }}" id="example-text-input">
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Phone</label>
                                            <input class="form-control" name="phone" type="text" value="{{ (!empty($profile->phone))?$profile->phone:'' }}" id="example-text-input">
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Contact Person Firstname</label>
                                            <input class="form-control" name="contact_first_name" type="text" value="{{ (!empty($profile->first_name))?$profile->first_name:'' }}" id="example-text-input">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Contact Person Lastname</label>
                                            <input class="form-control" name="contact_last_name" type="text" value="{{ (!empty($profile->last_name))?$profile->last_name:'' }}" id="example-text-input">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Website</label>
                                            <input class="form-control" name="website" type="text" value="{{ (!empty($profile->website))?$profile->website:'' }}" id="example-text-input">
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Main Food Item </label>
                                            <input class="form-control" name="main_items" type="text" value="{{ (!empty($profile->main_items))?$profile->main_items:'' }}" id="example-text-input" placeholder="Main food Item is Kebab,Burger">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Delivery Time</label>
                                            <input class="form-control" name="delivery_time" type="text" value="{{ (!empty($profile->delivery_time))?$profile->delivery_time:'' }}" id="example-text-input" placeholder="3o Min">
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Experience In Year</label>
                                            <input class="form-control" name="experience" type="text" value="{{ (!empty($profile->experience))?$profile->experience:'' }}" id="example-text-input" placeholder="2 year">
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Short Bio</label>
                                            <input class="form-control" name="short_bio" type="text" value="{{ (!empty($profile->short_bio))?$profile->short_bio:'' }}" id="example-text-input" placeholder="Before Work in Mellow Bar">
                                        </div>


                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Bio</label>
                                            <textarea rows="4" class="form-control" name="bio">{{ (!empty($profile->bio))?$profile->bio:'' }}</textarea>
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
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDeEFqdpYAXbeKLGrAnVq7z73aP-2hu2vs&libraries=places"></script>
    <script>
        function initialize() {
            var options = {
                componentRestrictions: {country: "se"}
            };
            var input = document.getElementById('searchTextField');
            var autocomplete = new google.maps.places.Autocomplete(input, options);
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                document.getElementById('city2').value = place.name;
                document.getElementById('cityLat').value = place.geometry.location.lat();
                document.getElementById('cityLng').value = place.geometry.location.lng();
                var placeId = place.place_id;
                var componentForm = {
                    locality: 'short_name',
                };
                for (var i = 0; i < place.address_components.length; i++) {
                    var addressType = place.address_components[i].types[0];
                    if (componentForm[addressType]) {
                        var val = place.address_components[i][componentForm[addressType]];
                        document.getElementById("city").value = val;
                    }
                }
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
@stop