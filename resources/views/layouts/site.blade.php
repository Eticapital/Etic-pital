<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ isset($title) ? $title . ' - ' . config('app.name', 'Eticapital') : config('app.name', 'Eticapital') }}</title>
    @if(isset($description) && $description)
    <meta name="description" content="{{ $description }}"ve>
    @endif


    <link rel="stylesheet" href="{{ mix('/css/site.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        window.App = {!! json_encode([
          'csrfToken' => csrf_token(),
          'maxFileSize' => intval(file_upload_max_size()),
          'user' => auth()->user() ? auth()->user()->toPublicArray() : null,
        ]) !!};
    </script>
  </head>
  <body>
  <div id="app">
    @if(@$is_home)
    <div class="jumbotron-fluid" id="header">
      <div class="container-fluid">
    @endif
<b-navbar v-cloak  id="navbarheader" class="{{ @$is_home ? 'navbar navbar-expand-lg navbar-dark pt-3 px-0' : 'navbar navbar-expand-lg navbar-light bg-white sticky-top'}}">

  <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

  <a class="navbar-brand" href="{{ route('home') }}">
    @if(@$is_home)
    <img id="logo" src="{{ asset('img/logolight.png') }}" alt="Eticapital">
    @else
    <img id="logo" src="{{ asset('img/logodark.png') }}" alt="Eticapital">
    @endif
  </a>

  <b-collapse is-nav id="nav_collapse">

    <b-navbar-nav class="ml-auto">
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
              <b-nav-item-dropdown right v-cloak>
                <!-- Using button-content slot -->
                <template slot="button-content">
                  Logueado
                </template>
                <b-dropdown-item href="{{ route('account.index') }}">Mi perfil</b-dropdown-item>
                @if(auth()->user()->is_admin)
                <b-dropdown-item href="{{ route('admin') }}">Administración</b-dropdown-item>
                @endif
                <logout-link class="dropdown-item">Cerrar sesión</logout-link>
              </b-nav-item-dropdown>
              @else
              <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Ingresar</a>
              </li>
              @endif
    </b-navbar-nav>

  </b-collapse>
</b-navbar>

      @if(@$is_home)
      </div> <!-- / .container-fluid -->
      @endif

      @yield('header')
    @if(@$is_home)
    </div> <!-- / #header -->
    @endif

    @include('flash::message')

    @yield('content')

    <footer class="bg-dark footer">
      <div class="container text-white">
        <div class="row">
          <div class="col-sm-6">
            <p><a href="{{ route('como-funciona') }}" class="h3">¿Cómo funciona?</a></p>
            <div class="row mb-3">
              <div class="col-12 col-lg-6">
                <a href="{{ route('invertir') }}">Invertir en un proyecto</a>
                <br><a href="{{ route('fondo-de-inversion') }}">Usar un fondo de inversión</a>
              </div> <!-- / .col-lg-6 -->
              <div class="col-12 col-lg-6">
                <a href="{{ route('fondear-mi-proyecto') }}">Fondear mi proyecto</a>
                <br>
                @if(auth()->user())
                <a href="{{ route('account.index') }}">Mi cuenta</a>
                @else
                <a href="{{ route('login') }}">Login</a>
                @endif
              </div> <!-- / .col-lg-6 -->
            </div> <!-- / .row -->
          </div> <!-- / .col -->
          <div class="col-sm-6">
            <p><a href="{{ route('nosotros') }}" class="h3">Nosotros</a></p>
            <div class="row mb-3">
              <div class="col-12 col-lg-6">
                <a href="{{ route('terminos-y-condiciones') }}">Términos y condiciones</a>
                <br><a href="{{ route('aviso-de-privacidad') }}">Aviso de privacidad</a>
                <br><a href="/corporativo">Etic@pital Corporativo</a>
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
    <growl-notifications v-cloak></growl-notifications>
    </div><!-- /#app -->
    @stack('scripts_after')
    <script src="{{ mix('js/site.js')}}"></script>
  </body>
</html>
