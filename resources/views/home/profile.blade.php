@extends('userpanel.index')
@section('userpanel')
    <section id="page-title">
        <div class="container clearfix">
            <h1>Profil</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Hem</a></li>
                <li class="breadcrumb-item active" aria-current="page">Min profil</li>
            </ol>
        </div>
    </section><!-- #page-title end -->
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="">
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

                <h3>Mitt konto</h3>

                <ul id="myTab" class="nav nav-tabs boot-tabs">
                    <li class="nav-item"><a class="nav-link {{ (Session::has('nav_menu') || Session::has('nav_menu1'))?'':'active' }}" href="#home" data-toggle="tab">Order</a></li>
                    <li class="nav-item"><a class="nav-link {{ (Session::has('nav_menu'))?Session::get('nav_menu'):'' }}" href="#profile" data-toggle="tab">Kontoinställning</a></li>
                    <li class="nav-item"><a class="nav-link {{ (Session::has('nav_menu1'))?Session::get('nav_menu1'):'' }}" href="#password" data-toggle="tab">Ändra lösenord</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade {{ (Session::has('nav_menu') || Session::has('nav_menu1'))?'':'show active' }}" id="home">
                        <h4>Min orderlista</h4>

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Fakturanummer</th>
                                <th>Referens-id</th>
                                <th>Total betalning</th>
                                <th>Betalningsstatus</th>
                                <th>Orderstatus</th>
                                <th>Verkan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($orders)){ ?>
                            <?php foreach($orders as $row){ ?>
                            <tr>
                                <td><a href="{{ URL::to('order-details/'.$row->url) }}" target="_blank">{{ $row->order_number }}</a></td>
                                <td>{{ $row->purchaseId }}</td>
                                <td>{{ $row->sub_total.' kr' }}</td>
                                <td>
                                    <?php if($row->order_status=="created"){ echo 'Payment Pending'; }elseif($row->order_status=="readyToShip"){ echo 'Payment Complete'; }else{ echo 'Payment Error';} ?>
                                </td>
                                <td>
                                    <?php if($row->order_status=="created"){ echo 'Order Created'; }elseif($row->order_status=="readyToShip"){ echo 'Ready To Shipped'; }else{ echo 'Order Deliverd';} ?>
                                </td>
                                <td><a href="{{ URL::to('order-details/'.$row->url) }}" target="_blank">Details</a></td>
                            </tr>
                            <?php } } ?>
                            </tbody>
                        </table>
                        <ul class="pagination pagination-circle">
                            {{ $orders->links() }}
                        </ul>
                    </div>
                    <div class="tab-pane fade {{ (Session::has('nav_menu'))?'show active':'' }}" id="profile">
                        <div class="accordion accordion-lg divcenter nobottommargin clearfix" style="max-width: 550px;">
                            <div class="acctitle"><i class="acc-closed icon-lock3"></i><i class="acc-open icon-mobile"></i>Uppdatera profilinfo</div>
                            <div class="acc_content clearfix">
                                <form class="nobottommargin" action="{{ URL::to('update-profle-info') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="nav_menu" value="menu_active" />
                                    <div class="col_full">
                                        <label for="register-form-name">Förnamn:</label>
                                        <input type="text" name="first_name" value="{{ (!empty($profile->first_name))?$profile->first_name:'' }}" class="form-control" />
                                    </div>
                                    <div class="col_full">
                                        <label for="register-form-name">Efternamn:</label>
                                        <input type="text" name="last_name" value="{{ (!empty($profile->last_name))?$profile->last_name:'' }}" class="form-control" />
                                    </div>
                                    <div class="col_full">
                                        <label for="register-form-email">Telefon:</label>
                                        <input type="text" name="phone" value="{{ (!empty($profile->phone))?$profile->phone:'' }}" class="form-control" />
                                    </div>
                                    <div class="col_full">
                                        <label for="register-form-email">Address:</label>
                                        <input type="text" name="address" value="{{ (!empty($profile->address))?$profile->address:'' }}" class="form-control" />
                                    </div>

                                    <div class="acctitle"><i class="acc-closed icon-lock3"></i><i class="acc-open icon-mobile"></i>Uppdatera Leveransinformation</div>
                                    <div class="col_full nobottommargin">
                                        <label>Förnamn:</label>
                                        <input type="text" name="s_first_name" id="checkout-form-shipping-name" class="form-control required" value="{{ (!empty($user_detail->first_name))?$user_detail->first_name : old('s_first_name') }}" placeholder="">
                                    </div>
                                    <div class="col_full nobottommargin">
                                        <label>Efternamn:</label>
                                        <input type="text" name="s_last_name" id="checkout-form-shipping-name" class="form-control required" value="{{ (!empty($user_detail->last_name))?$user_detail->last_name : old('s_last_name') }}" placeholder="">
                                    </div>

                                    <div class="col_full nobottommargin">
                                        <label>E-post:</label>
                                        <input type="text" name="s_email" id="checkout-form-shipping-name" class="form-control required" value="{{ (!empty($user_detail->email))?$user_detail->email : old('s_email') }}" placeholder="">
                                    </div>

                                    <div class="col_full nobottommargin">
                                        <label>Telefon:</label><br>
                                        <input type="text" name="s_phone" id="checkout-form-shipping-phone" class="form-control required" value="{{ (!empty($user_detail->phone))?$user_detail->phone : old('s_phone') }}" placeholder="02-232-2424">
                                    </div>
                                    <div class="col_full nobottommargin">
                                        <label>Address:</label>
                                        <input type="text" name="s_address" id="checkout-form-shipping-street" class="form-control required" value="{{ (!empty($user_detail->address))?$user_detail->address : old('s_address') }}">
                                    </div>
                                    <div class="col_full nobottommargin">
                                        <label>Lägenhet, svit, enhet etc:</label>
                                        <input type="text" name="s_apartment" id="checkout-form-shipping-apartment" class="form-control required" value="{{ (!empty($user_detail->apartment))?$user_detail->apartment : old('s_apartment') }}">
                                    </div>
                                    <div class="col_full nobottommargin">
                                        <label>Stad:</label>
                                        <input type="text" name="s_city" id="checkout-form-shipping-city" class="form-control required" value="{{ (!empty($user_detail->city))?$user_detail->city : old('s_city') }}">
                                    </div>
                                    <div class="col_full nobottommargin">
                                        <label>Postnummer:</label>
                                        <input type="text" name="s_post_code" id="checkout-form-shipping-post-code" class="form-control required" value="{{ (!empty($user_detail->post_code))?$user_detail->post_code : old('s_post_code') }}">
                                    </div>

                                    <div class="col_full nobottommargin">
                                        <button class="button button-3d button-black nomargin" type="submit" name="submit" value="register">Uppdatera nu</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade {{ (Session::has('nav_menu1'))?'show active':'' }}" id="password">
                        <div class="accordion accordion-lg divcenter nobottommargin clearfix" style="max-width: 550px;">
                            <div class="acctitle"><i class="acc-closed icon-lock3"></i><i class="acc-open icon-mobile"></i>Ändra lösenord</div>
                            <div class="acc_content clearfix">
                                <form class="nobottommargin" action="{{ URL::to('change-password-store') }}" method="POST">
                                    @csrf
                                    <div class="col_full">
                                        <label for="register-form-name">Gammalt lösenord:</label>
                                        <input type="password" name="current_password" value="" class="form-control" />
                                    </div>
                                    <div class="col_full">
                                        <label for="register-form-name">Nytt Lösenord:</label>
                                        <input type="password" name="new_password" value="" class="form-control" />
                                    </div>
                                    <div class="col_full">
                                        <label for="register-form-name">Bekräfta Nytt Lösenord:</label>
                                        <input type="password" name="retype_password" value="" class="form-control" />
                                    </div>

                                    <div class="col_full nobottommargin">
                                        <button class="button button-3d button-black nomargin" type="submit" name="submit" value="register">Uppdatera lösenord</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop