<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<style>
  img.img-circle.elevation-2 {
    margin-top: 14px;
  }

  span.space {
    margin-right: 1%;
  }

  input#myInput {
    display: none;
  }

  i.fa.fa-link.fa-2x {
    background: #c2c7d0;
    border-radius: 13%;
  }
</style>

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
      <a><img src="{{ asset('image/user.png') }}" class="img-circle elevation-2" alt="User Image"></a>
      <div class="info">
        <a href="{{ url('/client/home') }}" class="d-block">
          @if(Auth::user()->name !=null )
          {{Auth::user()->name}}
          @else
          {{Auth::user()->first_name}} {{ Auth::user()->last_name}}

          @endif
          </br>
          User ID :-
          @if(Auth::user()->unique_id ==null )
          @else
          ({{ Auth::user()->unique_id }})
          @endif

        </a>
      </div>

    </div>

    <div class="row">

      <?php
      $sponsor_link = url('/') . "/client/register?sponsor_id=" . Auth::user()->unique_id;
      if ($is_mobile == true) {
        $wp_url = "https://api.whatsapp.com/send?text=" . $sponsor_link;
      } else {
        $wp_url = "https://web.whatsapp.com/send?text=" . $sponsor_link;
      }

      $fb_url = "http://www.facebook.com/share.php?u=" . $sponsor_link;
      $tw_url = "https://twitter.com/share?url=" . $sponsor_link . "&amp;text=Edith Token Sponsor Registration Link";
      $ln_url = "http://www.linkedin.com/shareArticle?mini=true&amp;url=" . $sponsor_link;


      ?>
      <div class="col-lg-12 col-md-12 col-sm-12">
        <p class="p_social">
          <span class="space wp"><a target="_blank" href="{{$wp_url}}"><i class="fab fa-whatsapp-square fa-2x" aria-hidden="true"></i></a></span>
          <span class="space"><a target="_blank" href="{{$fb_url}}"><i class="fab fa-facebook-square fa-2x" aria-hidden="true"></i></a></span>
          <span class="space"><a target="_blank" href="{{$tw_url}}"><i class="fab fa-twitter-square fa-2x" aria-hidden="true"></i></a></span>
          <span class="space"><a target="_blank" href="{{$ln_url}}"><i class="fab fa-linkedin fa-2x" aria-hidden="true"></i></a></span>
          <span class="space"><a target="_blank" href="sms:?body={{$sponsor_link}}"><i class="fas fa-sms fa-2x" aria-hidden="true"></i></a></span>

          <input class="sponsor_link" type="text" value="{{$sponsor_link}}" id="myInput">
          <span title="Copy" onclick="myFunction()"><i class="fa fa-link fa-2x" aria-hidden="true"></i>
        </p>
        <!-- <span class="space"><a target="_blank" href=""><i class="far fa-copy fa-2x"></i></a></span> -->
        </p>
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

        <?php
        $current_time = \Carbon\Carbon::now()->timestamp;
        ?>

        <li class="nav-item">
          <a id="my_token" href="{{ url('/client/process_mining/'.$current_time) }}" class="nav-link">
            <!-- <a href="javascript:void(0);" class="nav-link" id="process_mining"> -->
            <i class="nav-icon fas fa-ellipsis-h"></i>
            <p>
              Process Mining
            </p>
          </a>
        </li>

        <!-- <li class="nav-item">
           <a href="{{ url('/client/affilate/'.$current_time) }}" class="nav-link"> 
          <a href="javascript:void(0);" class="nav-link">
            <i class="fas fa-circle nav-icon"></i>&nbsp;
            <p>
              Affilate
            </p>
          </a>
        </li> -->

        <li class="nav-item">
          <a id="tree" href="javascript:void(0);" class="nav-link">
            <i class="fas fa-sitemap"></i>&nbsp;
            <p>
              Affiliate
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a id="affiliate_user" href="{{ url('client/affiliates/'.$current_time) }}" class="nav-link">
                <i class="fas fa-user"></i>&nbsp;
                <p>Affiliate</p>
              </a>
            </li>
            <li class="nav-item">
              <a id="affiliate_history" href="{{ url('/client/affiliate-history/'.$current_time)}}" class="nav-link" id="process_mining">
                <!-- <a href="javascript:void(0);" class="nav-link"> -->
                <i class="fas fa-clock"></i>&nbsp;
                <p>Affiliate History</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">

          <!-- <a href="{{ url('/client/withdrawn/') }}" class="nav-link"> -->
          <a href="javascript:void(0);" class="nav-link">
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
  var url = "{{ url('/') }}";
  $('.nav-pills').find('li a').each(function() {
    str1 = window.location.href;
    str2 = "process_mining";
    str3 = "affiliates";
    str4 = "javascript:void(0);";
    str5 = "withdrawn";
    str6 = "affilate-history";


    if ($(this).attr('href') == window.location.href) {
      $(this).addClass('active');
    } else if ((str1.indexOf(str2) != -1)) {
      $("#my_token").addClass('active');
    } else if ((str1.indexOf(str3) != -1)) {
      $("#affiliate_user").addClass('active');
    } else if ((str1.indexOf(str4) != -1)) {
      $("#tree").addClass('active');
    } else if ((str1.indexOf(str5) != -1)) {
      $("#withdrawn").addClass('active');
    } else if ((str1.indexOf(str6) != -1)) {
      $("#affiliate_history").addClass('active');
    }
  });
</script>
<!-- 
<script type="text/javascript">
  $('.nav-pills').find('li a').each(function() {
    if ($(this).attr('href') == window.location.href) {
      $(this).addClass('active');
    }
  });
</script> -->
<script type="text/javascript">
  $("#process_mining").click(function() {
    var url = "{{ url('/') }}";
    $.ajax({
      type: "GET",
      url: url + "/client/get_token_record",
      success: function(data) {
        console.log(data);
        if (data == 1) {
          swal({
            html: true,
            title: 'Please wait, work in progress!',
            icon: 'info',
            focusConfirm: false,
            confirmButtonClass: "btn-primary",
            confirmButtonText: "Ok",

          });
        } else {
          swal({
            html: true,
            title: 'Please wait, work in progress.',
            icon: 'info',
            focusConfirm: false,
            confirmButtonClass: "btn-primary",
          });
        }
      }
    });
  });
</script>


<script>
  function myFunction() {
    var copyText = document.getElementById("myInput");
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */
    navigator.clipboard.writeText(copyText.value);
  }
</script>

@endpush('scripts')