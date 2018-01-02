@extends('layouts.site')

@section('content')
<div class="container">
      <div class="content">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-justify">
            <p class="text-center"><span class="h2 text-primary">Aplica para nuestro fondo de inversión</span></p>
            <p>Invierte a través de nuestro fondo de inversión para proyectos agrícolas. Si necesitas más de $300,000, esta puede ser tu solución.</p>
            <p>¿Quieres saber más antes de aplicar? <a href="{{ route('como-funciona') }}">Consulta aquí cómo funciona</a>.</p>
          </div> <!-- / .col-lg-8 -->
        </div> <!-- / .row -->
      </div> <!-- / .content -->
    </div> <!-- / .container -->

    <fondo-de-inversion-form>
      <p class="my-4 h4 text-primary text-center"><i class="icon-spinner spinner"></i> Cargando formulario...</p>
    </fondo-de-inversion-form>

@endsection