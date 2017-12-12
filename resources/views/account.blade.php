@extends('layouts.site', [
  'title' => 'Mi cuenta'
])
@section('header')
<div class="container">
  <div class="row my-3">
    <div class="col-lg-5">
      <b-card no-body title="Hola, {{ $user->name }}">
        <b-card-body>
          <h5 class="text-center">Datos de mi cuenta</h5>
        </b-card-body>
        <b-list-group flush>
            <b-list-group-item><strong>Nombre: </strong> {{ $user->name }}</b-list-group-item>
            <b-list-group-item><strong>Correo: </strong> {!! $user->email_link !!}</b-list-group-item>
        </b-list-group>
        <b-card-body>
          <ul class="list-unstyled m-0">
            <li>
              <a href="{{ route('account.edit') }}"><i class="icon-pencil"></i> Actualizar mis datos</a>
            </li>
            <li>
              <a href="{{ route('account.password-form') }}"><i class="icon-pencil"></i> Actualizar contraseña</a>
            </li>
            <li>
              <logout-link>
                <i class="icon-exit"></i>
                Cerrar sesión
              </logout-link>
            </li>
          </ul>
        </b-card-body>
      </b-card>
    </div><!-- /.col-lg-5 -->

    <div class="col-lg-7">
      <b-card title="Mis proyectos">
      </b-card>

      <b-card class="mt-3" title="Proyectos para financiar">
      </b-card>
    </div>
  </div><!-- /.row -->
</div><!-- /.container -->
@endsection