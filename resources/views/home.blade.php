@extends('layouts.site', ['is_home' => true])
@section('header')
<div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="display-3 text-center text-sm-left">Invierte en proyectos agrícolas innovadores</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-9">
        <p class="text-justify">Potencializamos el crecimiento de las PyMEs agroindustriales a través de un sistema virtuoso sustentable entre buenos emprendedores y buenos inversionistas, estamos comprometidos con el bien común; generando con nuestra asistencia, la máxima rentabilidad para todos los participantes del sistema.</p>
      </div> <!-- / .col-lg-3 -->
      <div class="col-lg-3">
        <p class="text-center"><a href="{{ route('como-funciona') }}" class="btn btn-secondary">Ver más</a></p>
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
            <p><a href="{{ route('invertir') }}" class="btn btn-primary">Ver proyectos</a></p>
          </div> <!-- / .col -->
          <div class="col-12 col-md-6 text-center">
            <img src="img/home_icon2.png" class="icon">
            <p><span class="h3">Usa nuestro fondo de inversión</span></p>
            <p class="text-justify">Invierte a través de nuestro fondo de inversión para proyectos agrícolas. Si necesitas más de $300,000, esta puede ser tu solución.</p>
            <p><a href="fondoinversion.html" class="btn btn-primary">Solicitar acceso</a></p>
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
              <p><a href="{{ route('fondear-mi-proyecto') }}" class="btn btn-secondary">Aplicar</a></p>
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

        <div class="card-columns project-card-columns">

          @foreach(range(1, 6) as $i)
          <a href="="{{ route('fondear-mi-proyecto') }}" class="card project-card">
            <div class="project-img"></div>
            <div class="card-body">
              <p><span class="h3 card-title">Nombre del proyecto</span></p>
              <div class="row">
                <div class="col">
                  <small class="card-text text-muted">Ubicación</small>
                </div> <!-- / .col -->
                <div class="col text-right">
                  <small class="card-text text-muted">Industria</small>
                </div> <!-- / .col -->
              </div> <!-- / .row -->
              <p class="card-text text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc rutrum, nisi eu hendrerit auctor, nisi nulla hendrerit nibh, ac laoreet sapien ex ut odio.</p>
              <p>
                <small class="card-text text-muted">Fondos recaudados:</small>
                <br><span class="h3 text-primary">$00,000</span> / $00,000
              </p>
            </div> <!-- / .card-body -->
          </a> <!-- / .project-card -->
          @endforeach
        </div> <!-- / .card-columns -->
      </div> <!-- / .content -->
    </div> <!-- / .container -->
@endsection