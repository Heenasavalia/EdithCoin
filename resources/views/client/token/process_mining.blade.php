@extends('client.layout.client_layout')

@section('content')
<style>
  div#mine_div {
    display: none;
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
          <li class="breadcrumb-item active">Process minnig</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="content">
  <div class="row">
    <div class="col-md-4">
      @include('client.layout.flash')
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4">

        <!-- general form elements -->
        <div class="card card-primary">

          <div class="card-header">
            <h3 class="card-title">Process Mining</h3>
          </div>

          <div class="row">
            <div class="col-8" id="mine_div">
              <div class="card-body">
                <a class="btn btn-block btn-success btn-lg btn_mine">
                  <!-- <a href="{{ url('/client/process_mining_side') }}" class="btn btn-block btn-success btn-lg btn_mine" id="mine_div"> -->
                  <span>Mine</span>
                </a>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-8 count_div" id="count_div">
              <div class="card-body">

                <div id="hours"></div>

              </div>
            </div>
          </div>

        </div>


        <span id="countdown" class="timer"></span>



        <!-- <h3 style="color:#FF0000" align="center">
          You will be logged out in : <span id='timer'></span> -->


      </div>
    </div>
  </div>
  <!-- /.container-fluid -->
</div>


@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
  function makeTimer() {
    var expired_at = '{{ $expired_at }}';

    var currentdate = new Date();
    var dateStringWithTime = moment(currentdate).format('YYYY-MM-DD HH:mm:ss');


    expired_at = (Date.parse(expired_at) / 1000);
    dateStringWithTime = (Date.parse(dateStringWithTime) / 1000);

    var timeLeft = expired_at - dateStringWithTime;



    var days = Math.floor(timeLeft / 86400);
    var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
    var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600)) / 60);
    var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

    // console.log(hours, minutes, seconds);

    if (hours < "10") {
      hours = "0" + hours;
    }
    if (minutes < "10") {
      minutes = "0" + minutes;
    }
    if (seconds < "10") {
      seconds = "0" + seconds;
    }

    console.log(hours, minutes, seconds);

    if (hours == '00' && minutes == '00' && seconds == '00') {
        $("#mine_div").show();
        $("#count_div").hide();
    } else {
      // $("#hours").html("<a href='javascript:void(0)' class='btn btn-block btn-danger btn-lg'>" + hours + "<span>:</span>" + minutes + "<span>:</span>" + seconds + "<span></span>" + "</a>");
    }


  }
  setInterval(function() {
    makeTimer();
  }, 1000);
</script>

<script>

</script>


<script src="https://code.jquery.com/jquery-1.10.2.js"></script>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>





@endpush('scripts')