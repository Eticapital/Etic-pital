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

      @foreach(range(1, 5) as $i)
      <div class="project-preview">
        <div class="row">
          <div class="col-12 col-md-6 col-lg-4 p-0">
            <a class="project-img" href="{{ route('proyecto') }}"></a>
          </div> <!-- / .col-lg-4 -->
          <div class="col-12 col-md-6 col-lg-8">
            <span class="h3 project-title"><a class="text-default" href="{{ route('proyecto') }}">Nombre del proyecto</a></span>
            <div class="row">
              <div class="col">
                <p><span class="small text-muted">Ubicación</span>
              </div> <!-- / .col -->
              <div class="col">
                <p><span class="small text-muted">Industria</span>
              </div> <!-- / .col -->
            </div> <!-- / .row -->
            <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc rutrum, nisi eu hendrerit auctor, nisi nulla hendrerit nibh, ac laoreet sapien ex ut odio.</p>
            <div class="row">
              <div class="col">
                <p><span class="small text-muted">Fondos recaudados</span>
                <br><span class="h3 text-primary">$00,000</span></p>
              </div> <!-- / .col -->
              <div class="col">
                <p><span class="small text-muted">Tamaño de la ronda</span>
                <br>$00,000</p>
              </div> <!-- / .col -->
            </div> <!-- / .row -->
            <div class="row">
              <div class="col text-center text-md-left">
                <a href="{{ route('proyecto') }}" class="btn btn-primary">Ver más</a>
              </div> <!-- / .col -->
            </div> <!-- / .row -->
          </div> <!-- / .col-lg-8 -->
        </div> <!-- / .row -->
      </div> <!-- / .project-preview -->
      @endforeach


      <div class="content">
        <nav>
          <ul class="pagination justify-content-center">
            <li class="page-item disabled">
              <a class="page-link" href="#">
                <span>&laquo;</span>
                <span class="sr-only">Anterior</span>
              </a>
            </li> <!-- / .page-item -->
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link" href="#">
                <span>&raquo;</span>
                <span class="sr-only">Siguiente</span>
              </a>
            </li> <!-- / .page-item -->
          </ul> <!-- / .pagination -->
        </nav>
      </div> <!-- / .content -->

    </div> <!-- / .container -->
@endsection