@extends('client.layout.client_layout')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
       <div class="col-sm-6">
        <h1 class="m-0"></h1>
      </div> 
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">affilate</li>
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
      <div class="col-12">

        <div class="page-body">
          <div class="card">
            <div class="card-block">

              <div class="table-responsive dt-responsive">
                <h2 style="margin-left:15px;">Affilate history</h2>

                <table id="token_data" class="table table-striped table-bordered nowrap">
                  <thead>
                    <tr>

                      <!-- <th>Currency Code</th> -->
                      <th>User ID</th>
                      <th>Name</th>
                      <th>Token</th>
                      <th>Amount (USD)</th>
                      <th>Created Date</th>
                    </tr>
                  </thead>
                  <tbody>
                   
                    @foreach($token as $my_direct)
                    <tr>
                      <td style="padding: 5px 10px;">{{$my_direct->client->unique_id}}</td>
                      <td style="padding: 5px 10px;">{{$my_direct->client->first_name}} {{$my_direct->client->last_name}}</td>
                      <td style="padding: 5px 10px;">{{$my_direct->no_of_token}}</td>
                      <td style="padding: 5px 10px;">{{$my_direct->total_amount}}</td>
                      <td style="padding: 5px 10px;">{{ date('d M Y H:i:s', strtotime($my_direct->created_at)) }}</td>
                    </tr>

                    @endforeach
                  </tbody>


                </table>

               
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





@endpush('scripts')