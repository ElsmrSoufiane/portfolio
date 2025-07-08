<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Portfolio professionnel de Soufiane Lasmar, Technicien spécialisé en développement digital">
  <title>Soufiane Lasmar | Portfolio</title>
  <!-- Bootstrap CSS -->
  <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/templatemo-seo-dream.css') }}">
  <!-- Animation CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/animated.css') }}">
  <!-- Owl Carousel -->
  <link rel="stylesheet" href="{{ asset('assets/css/owl.css') }}">
</head>
<body>

  <!-- Preloader -->
  @if(Request::is('/'))
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
  @endif

  <!-- Header -->
  <header style='text-align: left;' class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav" >
            <!-- Logo -->
            <a href="" class="logo" style='text-align: left;padding-left: 0;margin-left: 0;left: 0;'>
              <h4 style='margin: 0;' >Soufiane Lasmar</h4>
            </a>
            <!-- Menu -->
            <ul class="nav">
              @guest()
              <li class="scroll-to-section"><a href="/#top" >Accueil</a></li>
              <li class="scroll-to-section"><a href="/#about">propos</a></li>
              <li class="scroll-to-section"><a href="/#projects">Projets</a></li>
              <li class="scroll-to-section"><a href="/#tutorials">Tutoriels</a></li>
              <li class="scroll-to-section"><a href="/#skills">Compétences</a></li>
              <li class="scroll-to-section"><a href="/#contact">Contact</a></li>
              <li class="scroll-to-section"><div class="main-blue-button"><a href="{{ route('download.cv') }}">Télécharger CV</a></div></li>
              @endguest
              @auth()
              <li><a href="/projets">Projets</a></li>
              <li><a href="/tutos">Tutoriels</a></li>
              <li><a href="/messages">messages</a></li>
              <li><a href="/logout">Déconnexion</a></li>
              @endauth
            </ul>
            <a class='menu-trigger'>
              <span>Menu</span>
            </a>
          </nav>
        </div>
      </div>
    </div>
  </header>

  
 
    @include("alert")
  
  @yield('content')
 
  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <p>Copyright © 2023 Soufiane Lasmar. Tous droits réservés.</p>
        </div>
      </div>
    </div>
  </footer>
  <center><a href="/login">Accès admin</a></center>

  <!-- Scripts -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/animation.js"></script>
  <script src="assets/js/imagesloaded.js"></script>
  <script src="assets/js/custom.js"></script>

</body>
</html