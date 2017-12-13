@extends('layouts.site', [
  'title' => 'Promesa de inversión para el proyecto: ' . $project->name
])

@section('content')
<div class="container">
      <div class="content">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-justify">
            <p class="text-center"><span class="h2 text-primary">Haz una promesa de inversión</span></p>
            <p>Aparta tus ganancias con <strong>{{ $project->name }}</strong>. Llena este breve formulario y nos pondremos en contacto contigo para formalizar el proceso de inversión. Las promesas de inversión no son vinculantes, tendrás la oportunidad de revisar por completo al data room y toda la documentación legal necesaria previa la formalización de la inversión. ¿Aún no estás seguro? <a href="{{ $project->link }}">Vuelve a la página del proyecto.</a></p>
          </div> <!-- / .col-lg-8 -->
        </div> <!-- / .row -->
      </div> <!-- / .content -->
    </div> <!-- / .container -->
    <investment-form :project-id="{{ $project->id }}">
      <p class="my-4 h4 text-primary text-center"><i class="icon-spinner spinner"></i> Cargando formulario...</p>
    </investment-form>
@endsection