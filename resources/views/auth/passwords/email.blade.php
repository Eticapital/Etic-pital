@extends('layouts.site')

@section('content')
<div class="content bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <h1 class="h2 text-center text-primary">Recuperar contraseña</h1>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">Correo electrónico</label>

                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                  {{ $errors->first('email') }}
                                </span>
                                @endif
                        </div>

                        <p class="text-center">
                            <button type="submit" class="btn btn-primary">
                                Enviar enlace para recuperar contraseña
                            </button>
                        </p><!-- /.text-center -->
                    </form>
        </div> <!-- / .col-lg-8 -->
    </div> <!-- / .row -->
  </div> <!-- / .container -->
</div> <!-- / .content -->
@endsection
