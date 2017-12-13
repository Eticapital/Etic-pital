@extends('layouts.site')

@section('content')
@if(!$project->is_published)
<b-alert variant="info" show v-cloak class="container my-3">
  <h5 class="alert-heading"><i class="icon-warning"></i> Aún no compartas este enlace solo tu lo puedes ver.</h5>
  <p>Tu proyecto se encuentra actualmente en revisión y mientras tanto eres libre de <a class="alert-link" href="{{ route('projects.edit', $project) }}">modificar todos los detalles.</a></p>
</b-alert>
@endif
<div class="jumbotron-fluid">
      <div class="container-fluid">
        <div class="row no-gutters text-center text-md-left">
          <div class="col-12 col-md-6">
            <project-video
              type="{{ $project->video_type }}"
              link="{{$project->link}}"
              id="{{ $project->id }}"
              image="{{ $project->photo_854_url }}"
              video="{{ $project->video }}"
              name="{{ $project->name }}"
            ></project-video>
          </div> <!-- / .col-md-6 -->
          <div class="col-12 col-md-6 d-flex flex-column justify-content-between flex">
            <div class="container d-flex justify-content-center flex-column" style="flex-grow: 1" >
                <div class="row pt-3">
                  <div class="col">
                    <p>
                        <a href="#ubicacion" class="text-muted project-card-address" title="{{ $project->address }}" v-b-tooltip.hover>
                          <i class="fa fa-map-marker" aria-hidden="true" ></i> Ubicación</a>
                      </p>
                  </div> <!-- / .col -->
                  <div class="col">
                    <p class="text-muted"  v-b-tooltip.hover title="{{ $project->sectors_names }}">{{ $project->sector }}</p>
                  </div> <!-- / .col -->
                </div> <!-- / .row -->
              <p><span class="h2 text-primary">{{ $project->name }}</span></p>
              <div class="row py-3">
                <div class="col">
                  <p>Fondos recaudados
                  <br><span class="h3">{{ money($project->collected) }}</span></p>
                </div> <!-- / .col -->
                <div class="col">
                  <p>Tamaño de la ronda
                  <br>{{ money($project->goal) }}</p>
                </div> <!-- / .col -->
              </div> <!-- / .row -->
              <p class="py-3"><button class="btn btn-primary btn-wide">Invertir</button></p>
            </div> <!-- / .container -->
            <div class="container-fluid bg-light d-inline-flex align-items-center">
                <img class="user-img rounded-circle m-3" src="/img/placeholdergrey.png">
                <p class="pl-4 mb-0">Titular del proyecto:
                <br><span class="h3">{{ $project->owner->name }}</span></p>
            </div> <!-- / .container-fluid -->
          </div> <!-- / .col-md-6 -->
        </div> <!-- / .row -->
      </div> <!-- / .container-fluid -->
    </div> <!-- / .team-member-->

    <div class="container">
      <div class="content">
        <div class="row">

          <div class="col-12 col-md-6 col-lg-8 order-md-12">
            <p><span class="h3">Sobre el proyecto</span></p>
            <div class="text-justify">{!! $project->description !!}</div>
            <p><span class="h3">Oportunidad de inversión</span></p>
            <div class="text-justify">{!! $project->opportunity !!}</div>
            <p><span class="h3">Modelo de negocio</span></p>
            <div class="text-justify">{!! $project->business_model !!}</div>
            <p><span class="h3">Competencia</span></p>
            <div class="text-justify">{!! $project->competition !!}</div>
            @if($team->count())
            <p><span class="h3">Equipo</span></p>
            @foreach($team as $member)
              <div class="team-member bg-light">
                <img class="team-img" src="{{ asset('img/placeholdergrey.png') }}">
                <p><strong>{{ $member->name }}</strong></p>
                {{-- <p>Puesto</p> --}}
              </div> <!-- / .team-member-->
              @endforeach
            @endif

          </div> <!-- / .col-lg-8 -->

          <div class="col-12 col-md-6 col-lg-4 order-md-1">
            @if($project->has_latitude_longitude)
            <p><span class="h3" id="ubicacion">Ubicación</span>
            <p>
              {!! $project->map() !!}
            </p>
            <p><span class="h3">Etapa de desarrollo del capital</span></p>
            @endif
            @if($kpis->count())
            <p>Crecimiento</p>
            <p><span class="h3">KPIs</span></p>
            <table>
              @foreach($kpis as $kpi)
              <tr>
                <td class="text-muted kpi-name">{{ $kpi->time }}</td>
                <td class="kpi-line"><div class="bullet"></div></td>
                <td class="kpi-text">{{ $kpi->description }}</td>
              </tr>
              @endforeach
            </table>
            @endif
          </div> <!-- / .col-lg-4 -->

        </div> <!-- / .row -->
      </div> <!-- / .content -->
    </div> <!-- / .container -->

    {{-- <div class="container-fluid bg-light">
      <div class="container">

        <div class="content">
          <p class="text-center"><span class="h3">Fotos y video</span></p>
          <project-carousel :project-id="{{ $project->id }}"></project-carousel>
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
              <!-- indicadores -->
              <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
              </ol>

            <div class="carousel-inner">
              <div class="carousel-item active">
                <img class="d-block w-100" src="img/placeholderproyecto.png" alt="First slide">
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="img/placeholderproyecto.png" alt="Second slide">
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="img/placeholderproyecto.png" alt="Third slide">
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div> <!-- / .slide -->
        </div> <!-- / .content -->

      </div> <!-- / .container -->
    </div> <!-- / .container-fluid --> --}}

    <div class="jumbotron-fluid">
      <div class="content">
        <div class="container">
          <p><span class="h3">Data Room</span></p>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc rutrum, nisi eu hendrerit auctor, nisi nulla hendrerit nibh, ac laoreet sapien ex ut odio.</p>
        </div> <!-- / .container -->
        <div class="documents">
          <div class="container">
            @if($documents->count())
            <ul class="list-group">
              @foreach($documents as $document)
              <li class="list-group-item">{{ $document->name }}</li>
              @endforeach
            </ul> <!-- / .list-group -->
            @endif
          </div> <!-- / .container -->
          <div class="no-access">
            <span class="h3">El acceso es sólo para inversionistas</span>
          </div> <!-- / .no-access -->
        </div> <!-- / .documents -->
      </div> <!-- / .content -->
    </div> <!-- / .jumbotron-fluid -->
@endsection