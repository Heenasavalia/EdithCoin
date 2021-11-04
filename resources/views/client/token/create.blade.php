@extends('client.layout.client_layout')

@section('content')
<style>
  span#amount-error,
  span#no_of_token-error {
    color: red;
  }

  .input-icon {
    position: relative;
  }

  .input-icon>i {
    position: absolute;
    display: block;
    transform: translate(0, -50%);
    top: 50%;
    pointer-events: none;
    width: 25px;
    text-align: center;
    font-style: normal;
  }

  .input-icon>input {
    padding-left: 25px;
    padding-right: 0;
  }
</style>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <!-- <h1 class="m-0">Purchase a Token</h1> -->
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/client/home') }}">Home</a></li>
          <li class="breadcrumb-item active">Purchase token</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<section class="content">
  <div class="row">
    <div class="col-md-6">
      @include('client.layout.flash')
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><b>Purchase Token</b></h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form id="add_token" class="form-horizontal" method="POST" action="{{ url('/client/token') }}">
            {{ csrf_field() }}
            <div class="card-body">
              <input type="hidden" name="is_bonus" id="is_bonus" value="0" />

              <div class="form-group">
                <label for="exampleInputEmail1">How do you want to purchase fix amout or token ? </label>
                </br>
                <input type="radio" name="plan" checked value="amount"> Amount &nbsp;&nbsp;
                <input type="radio" name="plan" value="token"> No Of Tokens
              </div>

              <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}" id="amt_div">
                  <label for="exampleInputPassword1">Enter your amount</label>
                  <div class="input-icon">
                    <input type="text" name="amount" class="form-control" id="amount" placeholder="Amount" autocomplete="off" required>
                    <i>$</i>
                  </div>
                  <small class="text-danger">{{ $errors->first('amount') }}</small>
                  Token Price:- {{ Config::get('constants.one_token_price') }} <b>$</b> </br>
                  Total Token count:-
                  <b><span id="total_records"></span></b>
                  </br>
                </div>
              </div>

              <div class="col-lg-4 col-md-4 col-sm-4">
                <!-- <p>OR</p> -->
                <div class="form-group{{ $errors->has('no_of_token') ? ' has-error' : '' }}" id="tkn_div">
                  <label for="exampleInputEmail1">Enter No of Token</label>
                  <input type="text" name="no_of_token" class="form-control" id="no_of_token" placeholder="Token" autocomplete="off" required>
                  <small class="text-danger">{{ $errors->first('no_of_token') }}</small>
                  Token Price:- {{ Config::get('constants.one_token_price') }} <b>$</b> </br>
                  Total Amount:-
                  <b><span id="total_amount"></span></b>
                  </br>
                </div>
              </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button id="send" type="submit" class="btn btn-primary"><b>Submit</b></button>
              <!-- <button type="submit" class="btn btn-primary" ><b>Buy from Bounce</b></button> -->
              <!-- <a href="javascript:void(0)" class="btn btn-primary saveasbonus"><b>Buy from Bounce</b></a> -->
            </div>
          </form>
        </div>
        <!-- /.card -->



      </div>
    </div>
  </div>
  <!-- /.container-fluid -->
</section>


@endsection

@push('scripts')
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>






<script type="text/javascript">
  $(document).ready(function() {
    var url = "{{ url('/') }}";
    $("#amount").keyup(function() {
      var amount = $("input[name=amount]").val();
      $.ajax({
        "url": url + '/client/getamttoken/amount' + '/' + amount,
        method: "GET",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function(data) {

          $('#total_records').text(data.result);

        }
      })
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    var url = "{{ url('/') }}";
    $("#no_of_token").keyup(function() {
      var token = $("input[name=no_of_token]").val();
      $.ajax({
        "url": url + '/client/getamttoken/token' + '/' + token,
        method: "GET",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function(data) {
          $('#total_amount').text(data.result);
        }

      })
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {

    $('#amt_div').show();
    $("#tkn_div").hide();
    $('input[type=radio][name=plan]').change(function() {
      if (this.value == "amount") {
        $('#amt_div').show();
        $("#tkn_div").hide();
      } else if (this.value == "token") {
        $('#amt_div').hide();
        $("#tkn_div").show();
      }

    });

  });


  jQuery.validator.addMethod("noSpace", function(value, element) {
    return (value.indexOf(" ") == 0 && value == "") ? false : true;
  }, "Don't leave it empty");


  $("#add_token").validate({
    errorElement: 'span',
    errorClass: 'help-block',
    highlight: function(element, errorClass, validClass) {
      $(element).closest('.form-group').addClass("has-error");
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).closest('.form-group').removeClass("has-error");
    },
    errorPlacement: function(error, element) {
      $(element).closest(".form-group").append(error);
      //error.appendTo();
    },
    rules: {
      amount: {
        required: true,
        digits: true,
        noSpace: true,
      },
      no_of_token: {
        required: true,
        digits: true,
        noSpace: true,
      },
    },
    messages: {
      amount: {
        required: "Please enter Amount",
      },
      no_of_token: {
        required: "Please enter Token",
      },
    },

    submitHandler: function(form) {
      $('#send').attr('disabled', true);
      form.submit();
    }

  });
</script>


<script type="text/javascript">
  $(document).ready(function() {
    $(".saveasbonus").click(function() {
      console.log('click save btn');
      $("input[name=is_bonus]").val("1");
      console.log($("input[name=is_bonus]").val("1"));
      $('#send').removeAttr("type").attr("type", "button");

      $("#add_token").submit();
    });
  });
</script>



@endpush('scripts')