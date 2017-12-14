@extends('layouts.site', [
  'title' => 'Mis proyectos'
])
@section('header')
<div class="container">
  <p><a href="{{route('account.index')}}"><i class="icon-arrow-left2"></i> Regresar</a></p>
  <h2 class="text-primary">Mis proyectos</h2>
  @if($projects->count())
    <table class="table">
      <thead>
        <tr>
          <th>Nombre del proyecto</th>
          <th>Promesas de inversión</th>
          <th>Fondos recaudados</th>
          <th>Tamaño de la ronda</th>
          <th>Estatus</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($projects as $project)
        <tr>
          <td>
            @can('show', $project)
              <a href="{{ $project->link }}">{{ $project->name }}</a>
            @else
            {{ $project->name }}
            @endcan
          </td>
          <td>
            @if(auth()->user()->policyCan('investments', $project)&&$project->investments()->active()->count())
            <a href="{{ route('account.investments', $project) }}">{{ $project->investments()->active()->count() }}</a>
            @else
            {{ $project->investments()->active()->count() }}
            @endif
          </td>
          <td>{{ money($project->collected) }}</td>
          <td>{{ money($project->goal) }}</td>
          <td>{{ $project->status }}</td>
          <td>
            <div class="btn-group btn-group-sm">
              @can('show', $project)
                <a href="{{ $project->link }}" class="btn btn-default">Ver</a>
              @endcan
              @can('edit', $project)
              <a href="{{ route('projects.edit', $project) }}" class="btn btn-default">Editar</a>
              @endif
              @can('investments', $project)
              <a href="{{ route('account.investments', $project) }}" class="btn btn-default">Promesas de inversión</a>
              @endcan
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table><!-- /.table -->
    @if($projects->hasMorePages())
    <nav class="mt-3 d-flex justify-content-center">
      {!! $projects->links() !!}
    </nav>
    @endif
  @else
    <p class="m-0"><i>No has registrado ningun proyecto.</i> <a href="{{ route('fondear-mi-proyecto') }}">Registrar un proyecto</a></p>
  @endif
</div><!-- /.container -->
@endsection