@extends('layouts.site', [
  'title' => 'Mi cuenta'
])
@section('header')
<div class="container">
  <div class="row my-3">
    <div class="col-lg-5">
      <b-card v-cloak no-body title="Hola, {{ $user->name }}">
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
      <b-card v-cloak title="Mis proyectos">
        <p>Proyectos que registraste en nuestro sitio para buscar financiamiento.</p>
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
          <p class="text-center">
            <a href="{{ route('account.projects') }}" class="btn btn-primary">Ver mas detalles<a>
          </p>
        @else
        <p class="m-0"><i>No has registrado ningun proyecto.</i> <a href="{{ route('fondear-mi-proyecto') }}">Registrar un proyecto</a></p>
        @endif
      </b-card>

      <b-card v-cloak class="mt-3" title="Mis promesas de inversión">
        <p>Promesas de inversión realizadas a otros proyectos.</p>
        @if($investments->count())
          <table class="table">
            <thead>
              <tr>
                <th>Proyecto</th>
                <th>Monto</th>
                <th>Estatus</th>
              </tr>
            </thead>
            <tbody>
              @foreach($investments as $investment)
              <tr>
                <td>
                  @if($investment->project)
                    @can('show', $investment->project)
                    <a href="{{ $investment->project->link }}">{{ $investment->project->name }}</a>
                    @else
                    {{ $investment->project->name }}
                    @endcan
                  @else
                  -
                  @endif
                </td>
                <td>{{ money($investment->amount) }}</td>
                <td>
                  <span class="text-nowrap text-{{ $investment->status_class }}">
                    <i class="icon-{{ $investment->status_icon }}"></i>
                    {{ $investment->status_label }}
                  </span>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table><!-- /.table -->
        @else
        <p class="m-0"><i>No has realizado ninguna promesa de inversión</i></p>
        @endif
      </b-card>
    </div>
  </div><!-- /.row -->
</div><!-- /.container -->
@endsection