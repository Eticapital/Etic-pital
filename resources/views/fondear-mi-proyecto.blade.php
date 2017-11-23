@extends('layouts.site')

@push('scripts_after')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.googlemaps.key') }}"></script>
@endpush
@section('content')
<div class="container">
      <div class="content">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-justify">
            <p class="text-center"><span class="h2 text-primary">Aplica para fondear tu proyecto</span></p>
            <p>Gracias por darnos la oportunidad de recibir tu proyecto, llena este formulario para poder evaluar las condiciones en las que resulte más adecuado el financiamiento para tu empresa.</p>
            <p>¿Quieres saber más antes de aplicar? <a href="{{ route('como-funciona') }}#levantar-fondos">Consulta aquí cómo funciona</a>.</p>
          </div> <!-- / .col-lg-8 -->
        </div> <!-- / .row -->
      </div> <!-- / .content -->
    </div> <!-- / .container -->

    <project-form google-maps-api-key="{{ config('services.googlemaps.key') }}" v-cloak></project-form>
@endsection