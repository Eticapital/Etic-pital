@extends('layouts.site')

@section('content')
<div class="jumbotron-fluid">
      <div class="container-fluid">
        <div class="row no-gutters text-center text-md-left">
          <div class="col-12 col-md-6">
            <div class="project-img"></div>
          </div> <!-- / .col-md-6 -->
          <div class="col-12 col-md-6">
            <div class="container">
                <div class="row pt-3">
                  <div class="col">
                    <p class="text-muted">Ubicación</p>
                  </div> <!-- / .col -->
                  <div class="col">
                    <p class="text-muted">Industria</p>
                  </div> <!-- / .col -->
                </div> <!-- / .row -->
              <p><span class="h2 text-primary">Nombre del proyecto</span></p>
              <div class="row py-3">
                <div class="col">
                  <p>Fondos recaudados
                  <br><span class="h3">$00,000</span></p>
                </div> <!-- / .col -->
                <div class="col">
                  <p>Tamaño de la ronda
                  <br>$00,000</p>
                </div> <!-- / .col -->
              </div> <!-- / .row -->
              <p class="py-3"><button class="btn btn-primary">Invertir</button></p>
            </div> <!-- / .container -->
            <div class="container-fluid bg-light d-inline-flex align-items-center">
                <img class="user-img rounded-circle m-3" src="img/placeholdergrey.png">
                <p class="pl-4 mb-0"><span class="h3">Lorem Ipsum</span>
                <br>Director general
                <br>Redes sociales</p>
            </div> <!-- / .container-fluid -->
          </div> <!-- / .col-md-6 -->
        </div> <!-- / .row -->
      </div> <!-- / .container-fluid -->
    </div> <!-- / .team-member-->

    <div class="container">
      <div class="content">
        <div class="row">

          <div class="col-12 col-md-6 col-lg-8 order-md-12">
            <p><span class="h3">Oportunidad de inversión</span></p>
            <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In quis faucibus nibh. Fusce faucibus lacus id orci suscipit suscipit. Aliquam congue, diam a volutpat tempor, velit tortor blandit nisl, finibus placerat justo nulla vitae est. Nullam sollicitudin vitae nulla id ultrices. Aliquam tempus arcu eu mollis accumsan. Sed ornare placerat tincidunt. Donec magna velit, rutrum id pharetra non, rutrum sit amet elit. Proin sapien libero, elementum vitae dolor in, vehicula maximus velit. </p>
            <p><span class="h3">Modelo de negocio</span></p>
            <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In quis faucibus nibh. Fusce faucibus lacus id orci suscipit suscipit. Aliquam congue, diam a volutpat tempor, velit tortor blandit nisl, finibus placerat justo nulla vitae est. Nullam sollicitudin vitae nulla id ultrices. Aliquam tempus arcu eu mollis accumsan. Sed ornare placerat tincidunt. Donec magna velit, rutrum id pharetra non, rutrum sit amet elit. Proin sapien libero, elementum vitae dolor in, vehicula maximus velit. </p>
            <p><span class="h3">Competencia</span></p>
            <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In quis faucibus nibh. Fusce faucibus lacus id orci suscipit suscipit. Aliquam congue, diam a volutpat tempor, velit tortor blandit nisl, finibus placerat justo nulla vitae est. Nullam sollicitudin vitae nulla id ultrices. Aliquam tempus arcu eu mollis accumsan. Sed ornare placerat tincidunt. Donec magna velit, rutrum id pharetra non, rutrum sit amet elit. Proin sapien libero, elementum vitae dolor in, vehicula maximus velit. </p>
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
            <p><span class="h3">Etapa de desarrollo del capital</span></p>
            <p>Lorem ipsum</p>
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
@endsection