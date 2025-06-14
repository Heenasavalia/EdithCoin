@extends('client.layout.auth')

@section('content')
<style>
    .brand-link .brand-image {
        /* float: left; */
        line-height: 2.8;
        margin-left: 7.8rem;
        margin-right: 0.5rem;
        margin-top: -16px;
        max-height: 45px;
        width: auto;
    }
</style>
<div class="login-box">
    <div class="login-logo">
        <a href="#">Client Portal</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <a href="javascript:void(0)" class="brand-link">
                <img src="{{ asset('dist/img/logo.png') }}" alt="Logo" class="brand-image img-circle elevation-3">
            </a>
            </br>
            <p class="login-box-msg">Edith Token</p>

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/client/login') }}">
                {{ csrf_field() }}


                <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }} mb-3">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus placeholder="E-mail address*">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif





                <div class="input-group{{ $errors->has('password') ? ' has-error' : '' }} mb-3">
                    <input id="password" type="password" class="form-control" name="password" placeholder="Password*">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="input-group-addon my_addon" id="show_pwd" onclick="show_pwd()"><i class="fa fa-eye-slash"></i></span>
                            <span class="input-group-addon my_addon" id="hide_pwd" onclick="hide_pwd()" style="display: none;"><i class="fa fa-eye"></i></span>
                            <!-- <span class="fas fa-lock"><i class="fa fa-eye"></i></span> -->
                        </div>
                    </div>
                </div>

                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif



                <div class="row">
                    <!-- <div class="col-8">
                        <div class="icheck-primary" id="remeber_div">
                            <input type="checkbox" name="remember">
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div> -->
                    <!-- /.col -->
                    <div class="col-4 submit_div">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>


            <!-- /.social-auth-links -->

            <p class="mb-0">
            <p class="mb-1 forgot_link">

                <a href="{{ url('/client/password/reset') }}">Forgot Password?</a>
            </p>
            <a href="{{ url('/client/register') }}" class="text-center">Register a new membership</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>

@endsection
@push('scripts')
<script>
    function show_pwd() {
        var type = $('input[name=password]').attr('type');
        if (type == "password") {
            $('input[name=password]').attr('type', 'text')
            document.getElementById('hide_pwd').style.display = 'block';
            document.getElementById('show_pwd').style.display = 'none';
        } else {
            $('input[name=password]').attr('type', 'password')
        }
    };

    function hide_pwd() {
        var type = $('input[name=password]').attr('type');
        if (type == "password") {
            $('input[name=password]').attr('type', 'text')
        } else {
            $('input[name=password]').attr('type', 'password')
            document.getElementById('show_pwd').style.display = 'block';
            document.getElementById('hide_pwd').style.display = 'none';
        }
    };
</script>
@endpush('scripts')