@extends('client.layout.auth')

@section('content')

<div class="register-box">
  <div class="register-logo">
    <a href="#">Client Portal</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form class="form-horizontal" role="form" method="POST" action="{{ url('/client/register') }}">
      {{ csrf_field() }}
    
        <div class="input-group{{ $errors->has('name') ? ' has-error' : '' }} mb-3">

        
        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus placeholder="Full name">
          
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
          
        </div>
        @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif


        


        <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }} mb-3">
        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
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
        <input id="password" type="password" class="form-control" name="password" placeholder="Password">
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



        <div class="input-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} mb-3">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>

          
        </div>
        @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif

        

        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
        
      </form>

      <a href="{{ url('/client/login') }}" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>




@endsection
