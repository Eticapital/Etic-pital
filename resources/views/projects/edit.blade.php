@extends('layouts.site', [
  'title' => 'Actualizar proyecto: ' . $project->name
])

@push('scripts_after')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.googlemaps.key') }}"></script>
@endpush
@section('content')
<div class="container">
      <div class="content">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-justify">
            <p class="text-center"><span class="h2 text-primary">
              Actualizar proyecto: {{$project->name}}
            </span></p>
          </div> <!-- / .col-lg-8 -->
        </div> <!-- / .row -->
      </div> <!-- / .content -->
    </div> <!-- / .container -->
    <project-form
      google-maps-api-key="{{ config('services.googlemaps.key') }}"
      :project-id="{{ $project->id }}"
      :return="'{{ request()->input('return', '') }}'"
    >
      <p class="my-4 h4 text-primary text-center">
        <i class="icon-spinner spinner"></i> Cargando formulario...
      </p>
    </project-form>
@endsection