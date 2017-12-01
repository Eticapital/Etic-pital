@extends('layouts.site')

@section('content')
<div class="container">
      <div class="content">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-center">
            <p><span class="h2 text-primary">Invertir</span></p>
            <p class="text-justify">Esta es la lista de los proyectos que hemos seleccionado para abrirlos a la inversión del público en general.</p>
          </div> <!-- / .col-lg-8 -->
        </div> <!-- / .row -->
      </div> <!-- / .content -->

      @foreach($projects as $project)
      <div class="project-preview">
        <div class="row">
          <div class="col-12 col-md-6 col-lg-4 p-0">
            <a class="project-img" href="{{ $project->link }}">
              <img src="{{ $project->photo_380_url }}" alt="{{ $project->name }}" />
            </a>
          </div> <!-- / .col-lg-4 -->
          <div class="col-12 col-md-6 col-lg-8">
            <span class="h3 project-title"><a class="text-default" href="{{ $project->link }}">{{ $project->name }}</a></span>
            <div class="row">
              <div class="col">
                <p><span class="project-card-address small text-muted" title="{{ $project->address }}" v-b-tooltip.hover >Ubicación</span>
              </div> <!-- / .col -->
              <div class="col">
                <p><span class="small text-muted">{{ $project->sector }}</span>
              </div> <!-- / .col -->
            </div> <!-- / .row -->
            <p class="text-justify">{!! nl2br($project->short_description) !!}</p>
            <div class="row">
              <div class="col">
                <p><span class="small text-muted">Fondos recaudados</span>
                <br><span class="h3 text-primary">{{ money($project->collected) }}</span></p>
              </div> <!-- / .col -->
              <div class="col">
                <p><span class="small text-muted">Tamaño de la ronda</span>
                <br>{{ money($project->goal) }}</p>
              </div> <!-- / .col -->
            </div> <!-- / .row -->
            <div class="row">
              <div class="col text-center text-md-left">
                <a href="{{ $project->link }}" class="btn btn-primary">Ver más</a>
              </div> <!-- / .col -->
            </div> <!-- / .row -->
          </div> <!-- / .col-lg-8 -->
        </div> <!-- / .row -->
      </div> <!-- / .project-preview -->
      @endforeach

      <div class="content">
        <nav class="d-flex justify-content-center">
          {{ $projects->links() }}
        </nav>
      </div> <!-- / .content -->

    </div> <!-- / .container -->
@endsection