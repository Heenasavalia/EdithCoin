@extends('client.layout.auth')

@section('content')
<style>
  p.login-box-msg {
    margin: 10px 0px 0px 0px;
  }

  .brand-link .brand-image {
    /* float: left; */
    line-height: 2.8;
    margin-left: 12.8rem;
    margin-right: 0.5rem;
    margin-top: -16px;
    max-height: 45px;
    width: auto;
  }
</style>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">


<div class="register-box">
  <div class="register-logo">
    <a href="javascript:void(0)">Client Portal</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <a href="javascript:void(0)" class="brand-link">
        <img src="{{ asset('dist/img/logo.png') }}" alt="Logo" class="brand-image img-circle elevation-3">
      </a>
      </br>
      <p class="login-box-msg">Edith Token</p>

      <form class="form-horizontal" id="client_registration" role="form" method="POST" action="{{ url('/client/register') }}">
        {{ csrf_field() }}


        <div id="fields">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
              <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" autofocus placeholder="First name*">

              @if ($errors->has('first_name'))
              <span class="help-block">{{ $errors->first('first_name') }}</span>
              @endif
            </div>
          </div>

          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
              <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" autofocus placeholder="Last name*">
              @if ($errors->has('last_name'))
              <span class="help-block">{{ $errors->first('last_name') }}</span>
              @endif
            </div>
          </div>

          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <input id="email" type="email" class="form-control" name="email" autocomplete="off" placeholder="E-mail address*">
              @if ($errors->has('email'))
              <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
              </span>
              @endif
            </div>
          </div>

          <!-- <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group{{ $errors->has('client_name') ? ' has-error' : '' }}">
              <input id="client_name" type="text" class="form-control" name="client_name" autocomplete="off" placeholder="User name*">
             
              <div id="client_name_division" class="col-lg-12col-sm-12" style="display:none">
                <label class="business_label" for="client_name"><span id="client_name"></span></label>
              </div>
               @if ($errors->has('client_name'))
              <span class="help-block">{{ $errors->first('client_name') }}</span>
              @endif  
            </div>
          </div> -->

          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group{{ $errors->has('unique_id') ? ' has-error' : '' }}">
              <input readonly id="unique_id" type="text" class="form-control" name="unique_id" value="{{ old('unique_id') }}" autofocus placeholder="User name*">
              @if ($errors->has('unique_id'))
              <span class="help-block">{{ $errors->first('unique_id') }}</span>
              @endif
            </div>
          </div>

          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              <input id="password" type="password" class="form-control" name="password" placeholder="Password*">
              @if ($errors->has('password'))
              <span class="help-block">{{ $errors->first('password') }}</span>
              @endif
            </div>
          </div>

          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} mb-3">
              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
              @if ($errors->has('password_confirmation'))
              <span class="help-block">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
              </span>
              @endif
            </div>
          </div>

          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group{{ $errors->has('sponsor_id') ? ' has-error' : '' }}">
              <input id="sponsor_id" type="text" class="form-control" name="sponsor_id" value="{{ old('sponsor_id') }}" autofocus placeholder="Sponsor Id (Optional)">

              <!-- @if ($errors->has('sponsor_id'))
              <span class="help-block">{{ $errors->first('sponsor_id') }}</span>
              @endif -->

              <div id="name_division" class="col-lg-12col-sm-12" style="display:none">
                <label class="business_label" for="sponsor_id"><span id="sp_name"></span></label>
              </div>

            </div>
          </div>


          <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
              <button type="submit" class="btn btn-primary">
                Register
              </button>
            </div>
          </div>

        </div>

      </form>

      <a href="{{ url('/client/login') }}" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>




@endsection


@push('scripts')


<script>
  function randomString(length, chars) {
    var result = '';
    for (var i = length; i > 0; --i)
      result += chars[Math.round(Math.random() * (chars.length - 1))];
    return result;
  }

  document.getElementById("unique_id").value = 'EDT' + randomString(6, '0123456789');
</script>


<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

<script>

</script>


<script>
  $(document).ready(function() {
    var url = "{{ url('/') }}";
    $("#sponsor_id").keyup(function() {
      var sponsor_id = $("input[name=sponsor_id]").val();
      if (sponsor_id.length == 9) {
        var unique_id = $("#sponsor_id").val();
        $.ajax({
          type: "GET",
          url: "{{ url('/') }}" + "/api/getspid/" + unique_id,
          success: function(res) {
            console.log(res);
            if (res.sponsor_id != null) {
              $("#sp_name").text("Sponsor get").css('color', '#0caf09').css('font-weight', '600');
              $("#name_division").show();
              $('#fields input').attr('disabled', false);
            } else {
              $("#sp_name").text("Incorrect sponsor Id").css('color', '#e03f3f').css('font-weight', '600');
              $("#name_division").show();
            }
          }
        });
      } else {
        $("#sp_name").text("Please enter valid sponsor id").css('color', '#e03f3f').css('font-weight', '600');
        $("#name_division").show();
      }
    });


   
    $('#client_name').on('blur', function() {
      var username = $('#client_name').val();
      $.ajax({
        url: "{{ url('/') }}" + "/api/check_client_name/" + username,
        type: 'GET',
        // data: {
        //   'username': username,
        // },
        success: function(response) {
          console.log(response);
          
          if (response.client_name == 'taken') {
            $("#client_name").text("Sorry... Username already taken").css('color', '#e03f3f').css('font-weight', '600');
            $("#client_name_division").show();
          } else if (response.client_name == 'not_taken') {
            $("#client_name").text("Username available").css('color', '#0caf09').css('font-weight', '600');
            $("#client_name_division").show();
            // $('#client_name').parent().removeClass();
            // $('#client_name').parent().addClass("form_success");
            // $('#client_name').siblings("span").text('Username available');
          }
        }
      });
    });





  });
</script>


@endpush('scripts')