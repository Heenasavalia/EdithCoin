@extends('client.layout.client_layout')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{url('client/home')}}">Home</a></li>
          <li class="breadcrumb-item active">Affiliate</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">

  <div class="row">

    <!-- /.col -->
    <div class="col-md-12">
      <div class="card card-primary card-outline">
        <!-- /.card-header -->
        <div class="card-body">
          <div class="table-responsive mailbox-messages">
            <table id="affilate_users" class="table table-striped table-bordered nowrap">
              <thead>
                <tr>
                  <th>User ID</th>
                  <th>User Name</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Join Time</th>
                </tr>
              </thead>
              <tbody>
                @if ($my_directs->count() == 0)
                <tr>
                  <td colspan="5" style="text-align:center;">No Affilate to display.</td>
                </tr>
                @endif
                @foreach($my_directs as $my_direct)
                <tr>
                  <td style="padding: 5px 10px;">{{$my_direct->unique_id}}</td>
                  <td style="padding: 5px 10px;">{{$my_direct->client_name}}</td>
                  <td style="padding: 5px 10px;">{{$my_direct->first_name}} {{$my_direct->last_name}}</td>
                  <td style="padding: 5px 10px;">{{$my_direct->email}}</td>
                  <td style="padding: 5px 10px;">{{ date('d M Y H:i:s', strtotime($my_direct->created_at)) }}</td>
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
  <!-- /.col -->
</section>


@endsection
@push('scripts')

<script src="https://code.jquery.com/jquery-2.2.3.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js" type="text/javascript" defer></script>

<script type="text/javascript">
  var url = "{{ url('/') }}";
  $(document).ready(function() {
    $('#affilate_users').DataTable({

      "lengthMenu": [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"]
      ],
      order: [4, 'desc'],

    });
  });
</script>
@endpush('scripts')