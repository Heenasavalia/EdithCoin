@extends('client.layout.client_layout')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{$all_tokens}}</h3>

            <p>Tokens</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{$all_tokens_mining}}</h3>

            <p>Mined Tokens</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{$total}}</h3>

            <p>Total Tokens</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>0$</h3>

            <p>Affilate Income</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
        </div>
      </div>
      <!-- /.col-md-6 -->
    </div>
    <!-- /.col-md-6 -->



    <div class="row">
      <div class="col-12">

        <div class="page-body">
          <div class="card">
            <div class="card-block">

              <div class="table-responsive dt-responsive">
                <h2 style="margin-left:15px;">Token details</h2>

                <div class="row">
                  <div class="date_search">
                    <div class="row">


                      <!-- <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="input-daterange">
                          <input type="text" name="start_date" id="start_date" class="start_date form-control" placeholder="From Date" autocomplete="off" />
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="input-daterange">
                          <input type="text" name="end_date" id="end_date" class="end_date form-control" placeholder="End Date" autocomplete="off" />
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-12">
                        <input type="button" name="search" id="search" value="Search" class="btn btn-info btn-block" />
                      </div> -->

                    </div>
                  </div>
                </div>


                <table id="token_data" class="table table-striped table-bordered nowrap">
                  <thead>
                    <tr>

                      <!-- <th>Currency Code</th> -->
                      <th>Total Amount (USD)</th>
                      <th>Total Token</th>


                      <th>Transaction Time</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if ($tokens->count() == 0)
                    <tr>
                      <td colspan="4" style="text-align:center;">No Token to display.</td>
                    </tr>
                    @endif
                    @foreach($tokens as $token)
                    <tr>
                      <!-- <td style="padding: 5px 10px;">{{$token->currency_code}}</td> -->
                      <td style="padding: 5px 10px;">{{$token->amount_total_fiat}}</td>
                      <td style="padding: 5px 10px;">
                        <?php

                        $one_token_price  = 0.05;
                        $created_at = $token->created_at;
                        $mytime = \Carbon\Carbon::now();
                        $date = $mytime->toDateTimeString();
                        $from = \Carbon\Carbon::parse($mytime->format("Y-m-d"));
                        $to = \Carbon\Carbon::parse($created_at->format("Y-m-d"));
                        $diff_in_days = $to->diffInDays($from);

                        if ($diff_in_days > 30) {
                          $one_token_price  = 0.08;
                        }

                        $amount = (float) $token->amount_total_fiat;
                        $result = $amount / $one_token_price;
                        ?>
                        {{$result}}
                      </td>

                      <td style="padding: 5px 10px;">{{ date('d M Y H:i:s', strtotime($token->created_at)) }}</td>
                    </tr>

                    @endforeach
                  </tbody>


                </table>

                <div id="page_div">
                  {!! $tokens->links() !!}
                  <h6>
                    <b>Displaying {{$tokens->count()}} of {{ $tokens->total() }} Token(s).</b>
                  </h6>
                </div>


                <div class="col-md-5" id="search_div">
                  <h6>
                    Search Records Data-
                    <b><span id="total_records"></span></b>
                  </h6>
                </div>




              </div>
            </div>
          </div>
        </div>

      </div>
    </div>


  </div>

  <!-- /.row -->
</div>
<!-- /.container-fluid -->
</div>
<!-- /.content -->


@endsection

@push('scripts')



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>



<script type="text/javascript">
  $("#search_div").hide();
  $('.start_date').datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true
  });
  $('.end_date').datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true
  });

  var url = "{{ url('/') }}";

  function fetch_data(from_date = '', to_date = '') {
    $.ajax({
      "url": url + '/client/fetch_data',
      method: "POST",
      data: {
        from_date: from_date,
        to_date: to_date,
        client_id: '{{Auth::user()->id}}'
      },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      dataType: "json",
      success: function(data) {
        var output = '';
        console.log(data.length);
        if (data.length > 0) {
          $('#total_records').text(data.length);
        } else {
          $("#total_records").append("<b>No record in this date</b>");
          output += '<tr>';
          output += '<td colspan="4" style="text-align:center;">No Token to display.</td>';
          output += '<tr>';
          $('#tbody').append(output);

        }

        $.each(data, function(key, value) {
          
          output += '<tr>';
          output += '<td>' + value.id + '</td>';
          output += '<td>' + value.currency_code + '</td>';
          output += '<td>' + value.amount_total_fiat + '</td>';
          output += '<td>' + value.created_at + '</td>';
          output += '<tr>';
        });
        $('tbody').html(output);
        $("#search_div").show();
        $("#page_div").hide();
      }

    })
  }

  $('#search').click(function() {
    var from_date = $('#start_date').val();
    var to_date = $('#end_date').val();
    fetch_data(from_date, to_date);
  });
</script>

@endpush('scripts')