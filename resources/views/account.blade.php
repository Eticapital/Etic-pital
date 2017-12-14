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
            <b-list-group-item><strong>Teléfono: </strong> {!! $user->phone or '-' !!}</b-list-group-item>
            <b-list-group-item><strong>Organización: </strong> {!! $user->organization or '-' !!}</b-list-group-item>
            <b-list-group-item><strong>Residencia: </strong> {!! $user->residence or '-' !!}</b-list-group-item>
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
        @if($projects->count())
          <table class="table">
            <thead>
              <tr>
                <th>Nombre del proyecto</th>
                <th>Estatus</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($projects as $project)
              <tr>
                <td>{{ $project->name }}</td>
                <td>{{ $project->status }}</td>
                <td>
                  <div class="btn-group btn-group-sm">
                    @can('show', $project)
                      <a href="{{ $project->link }}" class="btn btn-primary">Ver</a>
                    @endcan
                    @can('edit', $project)
                    <a href="{{ route('projects.edit', $project) }}" class="btn btn-primary">Editar</a>
                    @endif
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table><!-- /.table -->
          {{-- @if($projects->hasMorePages())
          <p class="text-center">
            <a href="" class="btn btn-primary">Ver más...</a>
          </p>
          @endif --}}
        @else
        <p class="m-0"><i>No has registrado ningun proyecto.</i> <a href="{{ route('fondear-mi-proyecto') }}">Registrar un proyecto</a></p>
        @endif
      </b-card>

      <b-card class="mt-3" title="Proyectos para financiar">
        <p class="m-0"><i>Sin proyectos para financiar</i></p>
      </b-card>
    </div>
  </div><!-- /.row -->
</div><!-- /.container -->
@endsection