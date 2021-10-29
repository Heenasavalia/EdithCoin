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
          <li class="breadcrumb-item active">Withdraw</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Withdraw</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form id="add_withdraw" class="form-horizontal" method="POST" action="{{ url('/client/token') }}">
            {{ csrf_field() }}
            <div class="card-body">

              

              <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}" id="amt_div">
                  <label for="exampleInputPassword1">Enter your amount</label>

                </div>
              </div>

              

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button id="send" type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
        <!-- /.card -->



      </div>
    </div>
  </div>
  <!-- /.container-fluid -->
</div>


@endsection

@push('scripts')
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>



<script type="text/javascript">
  jQuery.validator.addMethod("noSpace", function(value, element) {
    return (value.indexOf(" ") == 0 && value == "") ? false : true;
  }, "Don't leave it empty");


  $("#add_withdraw").validate({
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



@endpush('scripts')