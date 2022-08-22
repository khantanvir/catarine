@extends('userpanel.index')
@section('userpanel')
<section id="page-title">
    <div class="container clearfix">
        <h1>Konto</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Hem</a></li>
            <li class="breadcrumb-item active" aria-current="page">Logga in</li>
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
                <div class="acctitle"><i class="acc-closed icon-lock"></i><i class="acc-open icon-unlock"></i>Logga in på ditt konto</div>
                <div class="acc_content clearfix">
                    <form id="login-form" name="login-form" class="nobottommargin" action="{{ URL::to('custom/login') }}" method="post">
                        @csrf
                        <div class="col_full">
                            <label for="login-form-username">E-post:</label>
                            <input type="text" id="login-form-username" name="email" value="" class="form-control" />
                        </div>

                        <div class="col_full">
                            <label for="login-form-password">Lösenord:</label>
                            <input type="password" id="login-form-password" name="password" value="" class="form-control" />
                        </div>

                        <div class="col_full nobottommargin">
                            <button class="button button-3d button-black nomargin" id="login-form-submit" name="login-form-submit" value="login">Logga in</button>
                            <a href="#" class="fright">Glömt ditt lösenord?</a>
                        </div>
                    </form>
                </div>
                <a style="margin-left: 28px; font-size: 20px;" href="{{ URL::to('user-register') }}" class="title"><i class="acc-closed icon-user4"></i><i style="padding: 10px;" class="acc-open icon-ok-sign"></i>Ny registrering? Registrera dig för ett konto</a>
            </div>
        </div>
    </div>
</section>
@stop