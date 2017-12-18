@extends('layouts.site', ['is_home' => true])
@section('header')
<div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="display-3 text-center text-sm-left">Conoce nuestro crowfunding</h1>
      </div>
    </div>
    <div class="row align-items-end">
      <div class="col-lg-9">
        <p class="text-justify">Potencializamos el crecimiento de las PyMEs en el área agroalimentaria a través de un sistema virtuoso sustentable entre buenos emprendedores y buenos inversionistas, para que formen y desarrollen buenas empresas comprometidas con el bien común, generando con nuestra asistencia, la máxima rentabilidad y que esta se reparta entre todos los participantes del sistema.</p>
        <p>Sin embargo estamos abiertos a cualquier iniciativa innovadora que represente un potencial de negocio económico y social.</p>
      </div> <!-- / .col-lg-3 -->
      <div class="col-lg-3">
        <p class="text-center"><a href="{{ route('como-funciona') }}" class="btn btn-wide btn-secondary">Ver más</a></p>
      </div> <!-- / .col-lg-3 -->
    </div> <!-- / .row -->
</div> <!-- / .container -->
@endsection

@section('content')
<div class="container">
      <div class="content">
        <div class="row">
          <div class="col">
            <p class="text-center"><span class="h2 text-primary">Así funciona</span></p>
          </div> <!-- / .col -->
        </div> <!-- / .row -->
        <div class="row">
          <div class="col-12 col-md-6 text-center">
            <img src="img/home_icon1.png" class="icon">
            <p><span class="h3">Invierte en empresas</span></p>
            <p class="text-justify">Invierte de una manera fácil y transparente, por medio de nuestra plataforma.</p>
            <p><a href="{{ route('invertir') }}" class="btn btn-wide btn-primary">Ver proyectos</a></p>
          </div> <!-- / .col -->
          <div class="col-12 col-md-6 text-center">
            <img src="img/home_icon2.png" class="icon">
            <p><span class="h3">Usa nuestro fondo de inversión</span></p>
            <p class="text-justify">Invierte a través de nuestro fondo de inversión para proyectos agrícolas. Si necesitas más de $300,000, esta puede ser tu solución.</p>
            <p><a href="{{ route('fondo-de-inversion') }}" class="btn btn-wide btn-primary">Solicitar acceso</a></p>
          </div> <!-- / .col -->
        </div> <!-- / .row -->
      </div> <!-- / .content -->
    </div> <!-- / .container -->

    <div class="container-fluid bg-light">
      <div class="container">
        <div class="content">
          <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
              <img src="img/home_icon3.png" class="icon">
              <p><span class="h2 text-secondary">Fondea tu proyecto</span></p>
              <p>¿Necesitas capital semilla? Inscribe tu idea o proyecto con nosotros.</p>
              <p><a href="{{ route('fondear-mi-proyecto') }}" class="btn btn-wide btn-secondary">Aplicar</a></p>
            </div> <!-- / .col-lg-8 -->
          </div> <!-- / .row -->
        </div> <!-- / .content -->
      </div> <!-- / .container -->
    </div> <!-- / .bg-light -->

    <div class="container">
      <div class="content">
        <div class="row">
          <div class="col text-center">
            <p><span class="h2 text-primary">Proyectos destacados</span></p>
          </div>
        </div> <!-- / .row -->

        @if($projects->count())
          @foreach($projects->chunk(3) as $chunk)
          <div class="row mb-3">
            @foreach($chunk as $project)
            <div class="col-lg-4">
              <div class="card project-card">
                <project-video
                  type="{{ $project->video_type }}"
                  link="{{$project->link}}"
                  id="{{ $project->id }}"
                  image="{{ $project->photo_380_url }}"
                  video="{{ $project->video }}"
                  name="{{ $project->name }}"
                ></project-video>
                <div class="card-body">
                  <p><span class="h3 card-title"><a href="{{ $project->link }}">{{ $project->name }}</a></span></p>
                  <div class="d-flex">
                    <div class="">
                      <small title="{{ $project->address }}" v-b-tooltip.hover class="project-card-address card-text text-muted">Ubicación</small>
                    </div> <!-- / .col -->
                    <div class="ml-auto">
                      <small class="card-text text-muted">{{ $project->sector }}</small>
                    </div> <!-- / .col -->
                  </div> <!-- / .row -->
                  <p class="card-text text-justify">{!! nl2br($project->short_description) !!}</p>
                  <p>
                    <small class="card-text text-muted">Fondos recaudados:</small>
                    <br><span class="h3 text-primary">{{ money($project->collected) }}</span> / {{ money($project->goal) }}
                  </p>
                </div> <!-- / .card-body -->
              </div> <!-- / .project-card -->
            </div><!-- /.col-lg -->
            @endforeach
          </div> <!-- / .card-columns -->
          @endforeach
        @else
          <p class="h5 text-center">Estamos seleccionando los mejores proyectos aún. ¡Regresa pronto!</p>
        @endif
      </div> <!-- / .content -->
    </div> <!-- / .container -->
@endsection