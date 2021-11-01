
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>

  </ul>

  <div class="">

    <a href="{{ url('client/logout') }}" onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
      Logout <i class="fa fa-sign-out" aria-hidden="true"></i>
    </a>

    <form id="logout-form" action="{{ url('client/logout') }}" method="POST" style="display: none;">
      {{ csrf_field() }}
    </form>
    
  </div>
</nav>