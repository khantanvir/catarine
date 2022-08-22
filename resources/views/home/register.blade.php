@extends('userpanel.index')
@section('userpanel')
    <section id="page-title">
        <div class="container clearfix">
            <h1>Konto</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Hem</a></li>
                <li class="breadcrumb-item active" aria-current="page">Registrera</li>
            </ol>
        </div>
    </section>
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
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
                <div class="accordion accordion-lg divcenter nobottommargin clearfix" style="max-width: 550px;">
                    <div class="acctitle"><i class="acc-closed icon-lock3"></i><i class="acc-open icon-mobile"></i>Skapa nytt konto</div>
                    <div class="acc_content clearfix">
                        <form class="nobottommargin" action="{{ URL::to('user-ragistration-process') }}" method="POST">
                            @csrf
                            <div class="col_full">
                                <label for="register-form-name">Förnamn:</label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control" />
                            </div>
                            <div class="col_full">
                                <label for="register-form-name">Efternamn:</label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control" />
                            </div>

                            <div class="col_full">
                                <label for="register-form-email">E-post:</label>
                                <input type="text" name="email" value="{{ old('email') }}" class="form-control" />
                            </div>
                            <div class="col_full">
                                <label for="register-form-password">Lösenord:</label>
                                <input type="password" name="password" value="" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="example-text-input" class="col-form-label">Bekräfta lösenord:</label>
                                <input class="form-control" name="confirm_password" type="password" value="" id="example-text-input">
                            </div>

                            <div class="col_full nobottommargin">
                                <button class="button button-3d button-black nomargin" type="submit" name="submit" value="register">Registrera nu</button>
                            </div>
                        </form>
                    </div>
                    <a style="margin-left: 28px; font-size: 20px;" href="{{ URL::to('user-login') }}" class="title"><i class="acc-closed icon-user4"></i><i style="padding: 10px;" class="acc-open icon-ok-sign"></i>Har du redan konto? Logga in här</a>
                </div>
            </div>
        </div>
    </section>
 @stop