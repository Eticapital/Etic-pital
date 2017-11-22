@extends('layouts.site')

@section('content')
<div class="content bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <p class="text-center"><span class="h2 text-primary">Registrarme</span></p>
        <form class="form-horizontal" method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="control-label">Nombre</label>

                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="control-label">Correo electrónico</label>

                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="control-label">Contraseña</label>

                    <input id="password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
            </div>

            <div class="form-group">
                <label for="password-confirm" class="control-label">Repite tu contraseña</label>

                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>

            <p class="text-center">
                <button type="submit" class="btn btn-primary">
                    Registrarme
                </button>
            </p>
        </form>
      </div> <!-- / .col-lg-8 -->
    </div> <!-- / .row -->
  </div> <!-- / .container -->
</div> <!-- / .content -->
@endsection
