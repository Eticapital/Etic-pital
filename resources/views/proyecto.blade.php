@extends('layouts.site')

@section('content')
<div class="jumbotron-fluid">
      <div class="container-fluid">
        <div class="row no-gutters text-center text-md-left">
          <div class="col-12 col-md-6">
            <div class="project-img">
              <img src="{{ $project->photo_854_url }}" alt="{{ $project->name }}" />
            </div>
          </div> <!-- / .col-md-6 -->
          <div class="col-12 col-md-6">
            <div class="container">
                <div class="row pt-3">
                  <div class="col">
                    <p>
                        <a href="#ubicacion" class="text-muted project-card-address" title="{{ $project->address }}" v-b-tooltip.hover>
                          <i class="fa fa-map-marker" aria-hidden="true" ></i> Ubicación</a>
                      </p>
                  </div> <!-- / .col -->
                  <div class="col">
                    <p class="text-muted"  v-b-tooltip.hover title="{{ $project->sectors }}">{{ $project->sector }}</p>
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
              <p class="py-3"><button class="btn btn-primary">Invertir</button></p>
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
            <div class="text-justify">{!! str_replace("\n", "</p>\n<p>", '<p>'.nl2br($project->description).'</p>') !!}</div>
            <p><span class="h3">Oportunidad de inversión</span></p>
            <div class="text-justify">{!! str_replace("\n", "</p>\n<p>", '<p>'.nl2br($project->opportunity).'</p>') !!}</div>
            <p><span class="h3">Modelo de negocio</span></p>
            <div class="text-justify">{!! str_replace("\n", "</p>\n<p>", '<p>'.nl2br($project->business_model).'</p>') !!}</div>
            <p><span class="h3">Competencia</span></p>
            <div class="text-justify">{!! str_replace("\n", "</p>\n<p>", '<p>'.nl2br($project->competition).'</p>') !!}</div>
            <p><span class="h3">Equipo</span></p>
            <div class="team-member bg-light">
              <img class="team-img" src="img/placeholdergrey.png">
              <p><strong>Lorem Ipsum</strong></p>
              <p>Puesto</p>
            </div> <!-- / .team-member-->
            <div class="team-member bg-light">
              <img class="team-img" src="img/placeholdergrey.png">
              <p><strong>Lorem Ipsum</strong></p>
              <p>Puesto</p>
            </div> <!-- / .team-member-->
            <div class="team-member bg-light">
              <img class="team-img" src="img/placeholdergrey.png">
              <p><strong>Lorem Ipsum</strong></p>
              <p>Puesto</p>
            </div> <!-- / .team-member-->
          </div> <!-- / .col-lg-8 -->

          <div class="col-12 col-md-6 col-lg-4 order-md-1">
            <p><span class="h3" id="ubicacion">Ubicación</span>
            <p><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30332.22485154439!2d-96.81867992425157!3d18.13957035843407!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85c43cdd1161f62d%3A0x4bd35257856751e!2sSan+Andr%C3%A9s+Hidalgo%2C+Oax.!5e0!3m2!1ses!2smx!4v1510251206930" width="300" height="200" frameborder="0" style="border:0" allowfullscreen></iframe></p>
            <p><span class="h3">Etapa de desarrollo del capital</span></p>
            <p>Crecimiento</p>
            <p><span class="h3">KPIs</span></p>
            <p>
              <table>
                <tr>
                  <td class="text-muted kpi-name">Dos semanas</td>
                  <td class="kpi-line"><div class="bullet"></div></td>
                  <td class="kpi-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In quis faucibus nibh. Fusce faucibus lacus id orci suscipit suscipit.</td>
                </tr>
                <tr>
                  <td class="text-muted kpi-name">Dos semanas</td>
                  <td class="kpi-line"><div class="bullet"></div></td>
                  <td class="kpi-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In quis faucibus nibh. Fusce faucibus lacus id orci suscipit suscipit.</td>
                </tr>
                <tr>
                  <td class="text-muted kpi-name">Dos semanas</td>
                  <td class="kpi-line"><div class="bullet"></div></td>
                  <td class="kpi-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In quis faucibus nibh. Fusce faucibus lacus id orci suscipit suscipit.</td>
                </tr>
                <tr>
                  <td class="text-muted kpi-name">Dos semanas</td>
                  <td class="kpi-line"><div class="bullet"></div></td>
                  <td class="kpi-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In quis faucibus nibh. Fusce faucibus lacus id orci suscipit suscipit.</td>
                </tr>
              </table>
            </p>
          </div> <!-- / .col-lg-4 -->

        </div> <!-- / .row -->
      </div> <!-- / .content -->
    </div> <!-- / .container -->

    <div class="container-fluid bg-light">
      <div class="container">

        <div class="content">
          <p class="text-center"><span class="h3">Fotos y video</span></p>

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
    </div> <!-- / .container-fluid -->

    <div class="jumbotron-fluid">
      <div class="content">
        <div class="container">
          <p><span class="h3">Data Room</span></p>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc rutrum, nisi eu hendrerit auctor, nisi nulla hendrerit nibh, ac laoreet sapien ex ut odio.</p>
        </div> <!-- / .container -->
        <div class="documents">
          <div class="container">
            <ul class="list-group">
              <li class="list-group-item">Cras justo odio</li>
              <li class="list-group-item">Dapibus ac facilisis in</li>
              <li class="list-group-item">Morbi leo risus</li>
              <li class="list-group-item">Porta ac consectetur ac</li>
              <li class="list-group-item">Vestibulum at eros</li>
            </ul> <!-- / .list-group -->
          </div> <!-- / .container -->
          <div class="no-access">
            <span class="h3">El acceso es sólo para inversionistas</span>
          </div> <!-- / .no-access -->
        </div> <!-- / .documents -->
      </div> <!-- / .content -->
    </div> <!-- / .jumbotron-fluid -->
@endsection