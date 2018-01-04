@extends('layouts.site', [
  'title' => 'Activar mi cuenta'
])
@section('header')
<div class="container">
  <div class="row my-3 justify-content-center">

    <div class="col-lg-6">
      <b-card title="Activa tu cuenta {{ $user->name }}">
        <p>¡Estás a un solo paso!</p>
        <p>Tu cuenta de usuario será tu correo electrónico: <strong>{{ $user->email }}</strong>, solo te hace falta una contraseña.</p>
        <p>Define tu contraseña en el siguiente formulario:</p>
        <activate-form email="{{ $user->email }}" token="{{ $token }}"></activate-form>
      </b-card>
    </div><!-- /.col-lg-5 -->
  </div><!-- /.row -->
</div><!-- /.container -->
@endsection