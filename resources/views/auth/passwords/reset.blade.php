@extends('layouts.site')

@section('content')
<div class="content bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <h1 class="h2 text-center text-primary">Actualizar contraseña</h1>

        <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
          {{ csrf_field() }}

          <input type="hidden" name="token" value="{{ $token }}">

          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email">Correo electrónico</label>

            <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

            @if ($errors->has('email'))
            <span class="help-block">
              <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password">Contraseña</label>

            <input id="password" type="password" class="form-control" name="password" required>

            @if ($errors->has('password'))
            <span class="help-block">
              <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <label for="password-confirm">Confirmar contraseña</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

            @if ($errors->has('password_confirmation'))
            <span class="help-block">
              <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
            @endif
          </div>

          <p class="text-center">
            <button type="submit" class="btn btn-primary">
              Actualizar contraseña
            </button>
          </p>
        </form>
      </div> <!-- / .col-lg-8 -->
    </div> <!-- / .row -->
  </div> <!-- / .container -->
</div> <!-- / .content -->
@endsection
