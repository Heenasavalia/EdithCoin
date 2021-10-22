<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="javascript:void(0)" class="brand-link">
    <img src="{{ asset('dist/img/logo.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Edith Token</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">

      <div class="info">
        <a href="{{ url('/client/home') }}" class="d-block">
          @if(Auth::user()->name !=null )
          {{Auth::user()->name}}
          @else
          {{Auth::user()->first_name}} {{ Auth::user()->last_name}}

          @endif

          @if(Auth::user()->unique_id ==null )
          @else
          ({{ Auth::user()->unique_id }})
          @endif
          
        </a>

      </div>
    </div>



    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

        <li class="nav-item has-treeview">
          <a href="{{ url('/client/home') }}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard

            </p>
          </a>
        </li>




        <li class="nav-item">
          <a href="{{ url('/client/token/create') }}" class="nav-link">
            <i class="nav-icon far fa-plus-square"></i>
            <p>
              Buy Token

            </p>
          </a>
        </li>

        <li class="nav-item">
          <!-- <a href="{{ url('/client/process_mining') }}" class="nav-link" id="process_mining"> -->
          <a href="javascript:void(0);" class="nav-link" id="process_mining">
            <i class="nav-icon fas fa-ellipsis-h"></i>
            <p>
              Process Mining
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ url('/client/affilate') }}" class="nav-link">
            <!-- <a href="javascript:void(0);" class="nav-link" id="process_mining"> -->
            <i class="fas fa-circle nav-icon"></i>&nbsp;
            <p>
              Affilate History
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ url('/client/withdraw') }}" class="nav-link">
            <!-- <a href="javascript:void(0);" class="nav-link" id="process_mining"> -->
            <i class="fa fa-th-list"></i>&nbsp;
            <p>
              Withdraw
            </p>
          </a>
        </li>




      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

@push('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script type="text/javascript">
  $('.nav-pills').find('li a').each(function() {
    if ($(this).attr('href') == window.location.href) {
      $(this).addClass('active');
    }
  });
</script>

<script type="text/javascript">
  $("#process_mining").click(function() {
    var url = "{{ url('/') }}";
    $.ajax({
      type: "GET",
      url: url + "/client/get_token_record",
      success: function(data) {
        console.log(data);
        if (data == 1) {
          // console.log("it's One");
          // window.location.href = url + "/client/process_mining";

          swal({
            // text: "<img src='{{asset('image/1.png')}}' style='width:150px;'>",
            html: true,
            title: 'Please wait, mining in progress!',
            icon: 'info',
            focusConfirm: false,
            confirmButtonClass: "btn-primary",
            confirmButtonText: "Ok",

          });
        } else {
          swal({
            html: true,
            title: 'Please create at least one Token.',
            icon: 'info',
            focusConfirm: false,
            confirmButtonClass: "btn-primary",
          });
        }
      }
    });
  });
</script>
@endpush('scripts')