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
          <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus>
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
          <input id="password" type="password" class="form-control" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        @if ($errors->has('password'))
        <span class="help-block">
          <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif



        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" name="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>


      <!-- /.social-auth-links -->

      <p class="mb-0">
        <a href="{{ url('/client/register') }}" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>

@endsection