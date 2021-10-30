@extends('client.layout.client_layout')

@section('content')

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

<section class="content">
  <div class="row">
    <div class="col-md-6">
      @include('client.layout.flash')
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-5">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Withdraw</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form id="add_withdraw" class="form-horizontal" method="POST" action="{{ url('/client/withdrawn') }}">
            {{ csrf_field() }}
            <div class="card-body">

              <div class="col-lg-12 col-md-12 col-sm-12">

                <div class="form-group{{ $errors->has('withdrawn_amount') ? ' has-error' : '' }}">
                  <input id="withdrawn_amount" type="text" class="form-control" name="withdrawn_amount" autocomplete="off" placeholder="Enter withdrawn amount*">

                  @if ($errors->has('withdrawn_amount'))
                  <span class="help-block">{{ $errors->first('withdrawn_amount') }}</span>
                  @endif
                </div>
              </div>

              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group{{ $errors->has('withdrawn_address') ? ' has-error' : '' }}">
                  <input id="withdrawn_address" type="text" class="form-control" name="withdrawn_address" autocomplete="off" placeholder="Enter withdrawn address*">

                  @if ($errors->has('withdrawn_address'))
                  <span class="help-block">{{ $errors->first('withdrawn_address') }}</span>
                  @endif
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
</section>


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
    errorClass: 'help-block text-danger',
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
      withdraw_amount: {
        required: true,
        digits: true,
        noSpace: true,
      },
      withdraw_address: {
        required: true,
      },
    },
    messages: {
      withdraw_amount: {
        required: "Please enter withdrawn amount",
      },
      withdraw_address: {
        required: "Please enter withdrawn address",
      },
    },

    submitHandler: function(form) {
      $('#send').attr('disabled', true);
      form.submit();
    }

  });
</script>



@endpush('scripts')