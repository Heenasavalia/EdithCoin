<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>

  </ul>
  <style>
    a#logout {
      padding-left: 30px !important;
    }
  </style>

  <div class="">

    <a href="javascript:void(0);" class="nav-btn" id="logout">
      Logout <i class="fa fa-sign-out" aria-hidden="true"></i>
    </a>

    <form id="logout-form" action="{{ url('client/logout') }}" method="POST" style="display: none;">
      {{ csrf_field() }}
    </form>

  </div>
</nav>

@push('scripts')

<script>
  $('#logout').on('click', function() {
    swal({
        html: true,
        title: 'Are you sure?',
        icon: 'info',
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonClass: "btn-primary",
        confirmButtonText: "Yes!",
        showCancelButton: true,
        cancelButtonText: "No",
      },
      function(value) {
        if (value == "true" || value == true) {
          $("#logout-form").submit();
        }
      });
    var top = '50%';
    var left = '50%';
  });
</script>

@endpush('scripts')