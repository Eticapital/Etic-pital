@extends('layouts.site')

@section('content')
<div class="content bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <p class="text-center"><span class="h2 text-primary">Iniciar sesión</span></p>
        <form method="POST" action="{{ route('login') }}">
          {{ csrf_field() }}
          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email">Correo electrónico</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
            @if ($errors->has('email'))
            <span class="help-block">
              <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
          </div> <!-- / .form-group -->
          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="password">Contraseña</label>
            <input id="password" type="password" class="form-control" name="password" required>

            @if ($errors->has('password'))
            <span class="help-block">
              <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
          </div> <!-- / .form-group -->
          <p class="text-center"><button type="submit" class="btn btn-primary">Iniciar sesión</button></p>
        </form>
        <p class="text-center">
          <a href="{{ route('password.request') }}">
            Olvidé mi contraseña
          </a>
        </p>
        {{-- <p class="text-center">¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate</a></p> --}}
      </div> <!-- / .col-lg-8 -->
    </div> <!-- / .row -->
  </div> <!-- / .container -->
</div> <!-- / .content -->
@endsection
