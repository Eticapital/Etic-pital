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
  <div id="app" @if(@$is_home)class="home"@endif>
    @if(@$is_home)
    <div class="jumbotron-fluid bg-blue" id="header">
    @endif
<b-navbar v-cloak id="navbarheader" class="{{ @$is_home ? 'navbar navbar-expand-lg navbar-dark sticky-top' : 'navbar navbar-expand-lg navbar-light bg-white sticky-top'}}">
  <div class="container">

    <a class="navbar-brand" href="{{ route('home') }}">
      @if(@$is_home)
      <img id="logohome" src="{{ asset('img/logolight.png') }}" alt="Eticapital">
      @endif
      <img id="logo" src="{{ asset('img/firma.png') }}" alt="Eticapital">
    </a>

  <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>
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
        {{-- <li class="nav-item">
          <a class="nav-link" href="{{ route('nosotros') }}">Nosotros</a>
        </li> --}}
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


  </div><!-- /.container -->
</b-navbar>

      @yield('header')
    @if(@$is_home)
    </div> <!-- / #header -->
    @endif

    @include('flash::message')

    @yield('content')

    @include('layouts._footer')


    <growl-notifications v-cloak></growl-notifications>
    </div><!-- /#app -->
    @stack('scripts_after')
    <script src="{{ mix('js/site.js')}}"></script>
  </body>
</html>
