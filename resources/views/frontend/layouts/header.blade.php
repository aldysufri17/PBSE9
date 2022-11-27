  <!-- ======= Top Bar ======= -->
  <div id="topbar" class="fixed-top d-flex align-items-center topbar-inner-pages">
      <div class="container d-flex align-items-center justify-content-center justify-content-md-between">
          <div class="contact-info d-flex align-items-center">
              <i class="bi bi-envelope-fill"></i><a href="mailto:contact@example.com">info@example.com</a>
              <i class="bi bi-phone-fill phone-icon"></i> +1 5589 55488 55
          </div>
          <div class="cta d-none d-md-block">
              <a href="#about" class="scrollto">Get Started</a>
          </div>
      </div>
  </div>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center header-inner-pages">
      <div class="container d-flex align-items-center justify-content-between">

          <h1 class="logo"><a href="/"><i class="bi bi-droplet-half"></i>PUBE</a></h1>
          <!-- Uncomment below if you prefer to use an image logo -->
          <nav id="navbar" class="navbar">
              <ul>
                  <li><a class="nav-link scrollto" href="/">Home</a></li>
                  <li><a class="nav-link scrollto" href="#about">About</a></li>
                  <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
                  @if (!Auth::check())
                  <li><a class="nav-link scrollto" href="{{route('login')}}">Login</a></li>
                  @else
                  <li class="dropdown"><a href="#"><span>Audit</span> <i class="bi bi-chevron-down"></i></a>
                      <ul>
                          <li><a href="{{route('master.audit')}}">Master Data</a></li>
                          <li><a href="{{route('audit.input')}}">Input Data</a></li>
                          {{-- <li><a href="{{route('riwayat.audit')}}">Riwayat Audit</a>
                  </li> --}}
              </ul>
              </li>
              @if (Auth::user()->role_id == 1)
              <li class="dropdown" style="width: 30px"><a href="#"><img class="my-2" style="border-radius: 50%"
                          width="30px"
                          src="{{ asset(auth()->user()->foto ? 'images/profil/'. auth()->user()->foto : 'backend/assets/img/avatar/avatar-1.png') }}"></a>
                  <ul>
                      {{-- <li><a href="{{route('profile.detail')}}">Profile</a>
              </li> --}}
              <li><a class="nav-link scrollto" href="{{ route('logout') }}"
                      onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
              </li>
              </ul>
              </li>
              @else
              <li><a class="btn btn-danger" href="/dashboard">Admin Panel</a></li>
              @endif
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
              @endif
              </ul>
              <i class="bi bi-list mobile-nav-toggle"></i>
          </nav><!-- .navbar -->

      </div>
  </header><!-- End Header -->