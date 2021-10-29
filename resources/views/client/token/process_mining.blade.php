@extends('client.layout.client_layout')

@section('content')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">


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

<section class="content">
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
            </br>
            Token to be received :-
            <b><span id="total_tokens"></span></b>
          </div>

          @if($mining == "0")
          <div class="row">
            <div class="col-8" id="mine_div">
              <div class="card-body">
                <!-- <a class="btn btn-block btn-success btn-lg btn_mine"> -->
                <a href="{{ url('/client/process_mining_side') }}" class="btn btn-block btn-success btn-lg btn_mine" id="mine_div">
                  <span>Mine Now</span>
                </a>
              </div>
            </div>
          </div>
          @else
          <div class="row">
            <div class="col-8 count_div" id="count_div">
              <div class="card-body">
                <div id="hours"></div>
              </div>
            </div>
          </div>
          @endif

        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- /.col -->
    <div class="col-md-12">
      <div class="card card-primary card-outline">
        <!-- /.card-header -->
        <div class="card-body">
          <div class="table-responsive mailbox-messages">
            <table id="my_mining_token" class="table table-striped table-bordered nowrap">
              <thead>
                <tr>
                  <th>Mined Tokens</th>
                  
                  <th>Mined Time</th>
                </tr>
              </thead>
              <tbody>
                @if ($my_tokens->count() == 0)
                <tr>
                  <td colspan="4" style="text-align:center;">No Mining token to display.</td>
                </tr>
                @endif
                @foreach($my_tokens as $my_token)
                <tr>
                  <td style="padding: 5px 10px;">{{$my_token->no_of_token}}</td>
                 
                  <td style="padding: 5px 10px;">{{ date('d M Y H:i:s', strtotime($my_token->created_at)) }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.mail-box-messages -->
        </div>
        <!-- /.mail-box-messages -->
      </div>
    </div>
    <!-- /. box -->
  </div>
  <!-- /.container-fluid -->
</section>


@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-2.2.3.js" type="text/javascript"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>

<script>
  var d = new Date();
  console.log(d);
  d.setHours(24, 0, 0, 0);
  var countDownDate = d.setHours(24, 0, 0, 0);
  console.log(countDownDate);

  var myfunc = setInterval(function() {
    var now = new Date().getTime();
    // var countDownDate = new Date("Oct 25, 2021 12:40:00").getTime();
    var timeleft = countDownDate - now;

    var days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
    var hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);
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
    // console.log(hours, minutes, seconds);
    $("#hours").html("<a href='javascript:void(0)' class='btn btn-block btn-danger btn-lg'>" + hours + "<span>:</span>" + minutes + "<span>:</span>" + seconds + "<span></span>" + "</a>");
  }, 1000)
</script>





<script>
  var url = "{{ url('/') }}";
  $(document).ready(function() {
    $.ajax({
      url: url + "/client/my_minig_tokens",
      method: "GET",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      dataType: "json",
      success: function(data) {
        $('#total_tokens').text(data);
      }
    });
  });
</script>

<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js" type="text/javascript" defer></script>

<script type="text/javascript">
  var url = "{{ url('/') }}";
  $(document).ready(function() {
    $('#my_mining_token').DataTable({
      "lengthMenu": [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"]
      ],
      order: [1, 'desc'],
    });
  });
</script>

@endpush('scripts')