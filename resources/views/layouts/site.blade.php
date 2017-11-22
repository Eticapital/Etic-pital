<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700|Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="css/eticapital.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/project-card.css"> -->

    <title>{{ config('app.name', 'Eticapital') }}</title>

    <link rel="stylesheet" href="{{ mix('/css/site.css') }}">
  </head>
  <body>

    @if(@$is_home)
    <div class="jumbotron-fluid" id="header">
      <div class="container-fluid">
    @endif
        <!-- navbar navbar-expand-lg navbar-dark pt-3 px-0 -->
        <nav id="navbarheader" class="{{ @$is_home ? 'navbar navbar-expand-lg navbar-dark pt-3 px-0' : 'navbar navbar-expand-lg navbar-light bg-white sticky-top'}}">
          <a class="navbar-brand" href="{{ route('home') }}">
            @if(@$is_home)
            <img id="logo" src="{{ asset('img/logolight.png') }}" alt="Eticapital">
            @else
            <img id="logo" src="{{ asset('img/logodark.png') }}" alt="Eticapital">
            @endif
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="{{ route('como-funciona') }}">¿Cómo funciona?</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('invertir') }}">Invertir</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('fondear-mi-proyecto') }}">Fondear mi proyecto</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('nosotros') }}">Nosotros</a>
              </li>
              @if(auth()->user())
              <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}"><i class="fa fa-user"></i> Logueado</a>
              </li>
              @else
              <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Ingresar</a>
              </li>
              @endif
            </ul> <!-- / .navbar-nav -->
          </div> <!-- / #navbarSupportedContent -->
        </nav> <!-- / #navbarheader -->
      @if(@$is_home)
      </div> <!-- / .container-fluid -->
      @endif

      @yield('header')
    @if(@$is_home)
    </div> <!-- / #header -->
    @endif

    @yield('content')

    <footer class="bg-dark footer">
      <div class="container text-white">
        <div class="row">
          <div class="col-sm-6">
            <p><a href="{{ route('como-funciona') }}" class="h3">¿Cómo funciona?</a></p>
            <div class="row mb-3">
              <div class="col-12 col-lg-6">
                <a href="{{ route('invertir') }}">Invertir en un proyecto</a>
                <br><a href="{{ route('invertir') }}">Usar un fondo de inversión</a>
              </div> <!-- / .col-lg-6 -->
              <div class="col-12 col-lg-6">
                <a href="{{ route('fondear-mi-proyecto') }}">Fondear mi proyecto</a>
                <br><a href="{{ route('login') }}">Login</a>
              </div> <!-- / .col-lg-6 -->
            </div> <!-- / .row -->
          </div> <!-- / .col -->
          <div class="col-sm-6">
            <p><a href="{{ route('nosotros') }}" class="h3">Nosotros</a></p>
            <div class="row mb-3">
              <div class="col-12 col-lg-6">
                <a href="#">Términos y condiciones</a>
                <br><a href="#">Aviso de privacidad</a>
                <br><a href="#">Etic@pital Corporativo</a>
              </div> <!-- / .col-lg-6 -->
              <div class="col-12 col-lg-6">
                <strong>Contáctanos:</strong>
                <br>informes@eticapital.mx
              </div> <!-- / .col-lg-6 -->
            </div> <!-- / .row -->
          </div> <!-- / .col -->
        </div> <!-- / .row -->
      </div> <!-- / .container -->
    </footer>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="js/eticapital.js"></script>
  </body>
</html>