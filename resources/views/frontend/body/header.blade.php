<div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
</div>
  <!-- ***** Preloader End ***** -->

<div class="sub-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <ul class="info">
                <li><i class="fa fa-envelope"></i> dreamcarstogo@gmail.com</li>
                <li><i class="fa fa-map"></i>Adidogomé-Pharmacie Bethel </li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-4">
                <ul class="social-links">
                <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                <li><a href="https://x.com/minthu" target="_blank"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>


    <!-- Replace your existing success message display with this -->
    @if (session('success'))
    <div id="success-toast" class="toast align-items-right text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          {{ session('success') }}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
    @endif

<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="{{route('accueil')}}" class="logo">
                        <img src="{{asset('frontend/assets/images/logo2.png')}}" alt="Logo" height="50px" style="margin-top: 5px">
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <li><a class="{{ request()->routeIs('accueil') ? 'active' : '' }}" href="{{route('accueil')}}">Accueil</a></li>
                        <li>
                            <a class="{{ request()->routeIs('all_properties', 'dispo_properties','properties') ? 'active' : '' }}" href="{{route('properties')}}">Nos Voitures</a>
                        </li>                        
                        <li><a class="{{ request()->routeIs('services') ? 'active' : '' }}" href="{{route('services')}}">Nos services</a></li>
                        <li><a class="{{ request()->routeIs('contact') ? 'active' : '' }}" href="{{route('contact')}}">Contactez-nous</a></li>
                        <li>
                            @auth
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="background-color: #284898; border-radius: 25px; display: flex; align-items: center; padding: 5px 10px; text-decoration: none; color: white;">
                                    {{ strtoupper(substr(auth()->user()->name ?? '', 0, 1)) }} | Déconnexion
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            @else
                                <a href="{{ route('login') }}" style="background-color: #284898; border-radius: 25px; display: flex; align-items: center; padding: 5px 2px; text-decoration: none; color: white;">
                                    <i class="fas fa-sign-in-alt" style="margin-right: 5px;"></i> Se Connecter
                                </a>
                            @endauth
                        </li>
                        
                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
               
                <div>
                </div>
            </div>
        </div>
        
    </div>
    
</header>
