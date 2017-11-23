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
    <form>








      <div class="container-fluid bg-light">
        <div class="container">
          <div class="content">
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <fieldset>
                  <p><legend><span class="h2 text-primary">5.</span> <span class="h3">Presentación y videos adicionales de la empresa</span></legend></p>
                  <div class="form-group file-upload">
                    <label><span class="btn btn-secondary file-button">Subir presentación</span></label>
                    <input type="file" class="file-trigger">
                  </div> <!-- / .form-group -->
                  <span class="btn btn-secondary add-url-button">Agregar video</span>
                </fieldset>
              </div> <!-- / .col-lg-8 -->
            </div> <!-- / .row -->
          </div> <!-- / .content -->
        </div> <!-- / .container -->
      </div> <!-- / .container-fluid -->

      <div class="container">
        <div class="content">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <fieldset>
              <p><legend><span class="h2 text-primary">6.</span> <span class="h3">Página y redes de la empresa</span></legend></p>
                <div class="form-group">
                  <label>Tu página oficial, página de facebook, twitter, etc.</label>
                  <input type="url" class="form-control" value="http://">
                </div> <!-- / .form-group -->
                <p><span class="btn btn-secondary add-url-button">Agregar link</span></p>
              </fieldset>
            </div> <!-- / .col-lg-8 -->
          </div> <!-- / .row -->
        </div> <!-- / .content -->
      </div> <!-- / .container -->

      <div class="container-fluid bg-light">
        <div class="container">
          <div class="content">
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <fieldset>
                  <p><legend><span class="h2 text-primary">7.</span> <span class="h3">Sectores a lo que pertenece la innovación</span></legend></p>
                  <div class="form-row">
                    <div class="col">
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox">
                          Biocombustibles
                        </label>
                      </div> <!-- / .form-check -->
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox">
                          Drones
                        </label>
                      </div> <!-- / .form-check -->
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox">
                          Maquinaria
                        </label>
                      </div> <!-- / .form-check -->
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox">
                          Tecnología Agrícola
                        </label>
                      </div> <!-- / .form-check -->
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox">
                          Biotecnología
                        </label>
                      </div> <!-- / .form-check -->
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox">
                          Hidroponia
                        </label>
                      </div> <!-- / .form-check -->
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox">
                          Irrigación
                        </label>
                      </div> <!-- / .form-check -->
                    </div> <!-- / .col -->
                    <div class="col">
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox">
                          Big Data
                        </label>
                      </div> <!-- / .form-check -->
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox">
                          Comida
                        </label>
                      </div> <!-- / .form-check -->
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox">
                          Logística
                        </label>
                      </div> <!-- / .form-check -->
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox">
                          Producción
                        </label>
                      </div> <!-- / .form-check -->
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox">
                          Almacenamiento
                        </label>
                      </div> <!-- / .form-check -->
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox">
                          Robótica
                        </label>
                      </div> <!-- / .form-check -->
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox">
                          Otro
                        </label>
                      </div> <!-- / .form-check -->
                    </div> <!-- / .col -->
                  </div> <!-- / .form-row -->
                </fieldset>
              </div> <!-- / .col-lg-8 -->
            </div> <!-- / .row -->
          </div> <!-- / .content -->
        </div> <!-- / .container -->
      </div> <!-- / .container-fluid -->

      <div class="container">
        <div class="content">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <fieldset>
                <p><legend><span class="h2 text-primary">8.</span> <span class="h3">Etapa de desarrollo de capital</span></legend></p>
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="form-check-input" type="checkbox">
                    Inicial (Menos de un año trabajando y requieres máximo $100,000 en capital)
                  </label>
                </div> <!-- / .form-check -->
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="form-check-input" type="checkbox">
                    Validación (Menos de dos años, algunas ventas y buscas menos de $200,000 en capital)
                  </label>
                </div> <!-- / .form-check -->
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="form-check-input" type="checkbox">
                    Crecimiento (Más de dos años, ventas recurrentes y buscas más de $200,000 en capital)
                  </label>
                </div> <!-- / .form-check -->
              </fieldset>
            </div> <!-- / .col-lg-8 -->
          </div> <!-- / .row -->
        </div> <!-- / .content -->
      </div> <!-- / .container -->

      <div class="container-fluid bg-light">
        <div class="container">
          <div class="content">
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <fieldset>
                  <p><legend><span class="h2 text-primary">9.</span> <span class="h3">Modelo de negocio</span></legend></p>
                  <div class="form-group">
                    <label>¿Cómo generas dinero? ¿Qué tipo de producto o servicio vendes y quién te lo compra? ¿A través de qué medios lo comercializas o cómo cierras tus ventas?</label>
                    <textarea class="form-control" rows="3"></textarea>
                  </div> <!-- / .form-group -->
                </fieldset>
              </div> <!-- / .col-lg-8 -->
            </div> <!-- / .row -->
          </div> <!-- / .content -->
        </div> <!-- / .container -->
      </div> <!-- / .container-fluid -->

      <div class="container">
        <div class="content">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <fieldset>
                <p><legend><span class="h2 text-primary">10.</span> <span class="h3">Datos de inversión</span></legend></p>
                <div class="form-group">
                  <label>Capital previamente obtenido (si aplica)</label>
                  <input type="number" class="form-control">
                </div> <!-- / .form-group -->
                <div class="form-group">
                  <label>Ventas totales al día de hoy (si aplica)</label>
                  <input type="number" class="form-control">
                </div> <!-- / .form-group -->
                <div class="form-group">
                  <label>Tamaño de la ronda (¿Cuánto necesitas?)</label>
                  <input type="number" class="form-control">
                </div> <!-- / .form-group -->
                <div class="form-group">
                  <label>¿Cuánto es lo mínimo que te serviría para levantar capital?</label>
                  <input type="number" class="form-control">
                </div> <!-- / .form-group -->
              </fieldset>
              <fieldset>
                <div class="form-row">
                  <legend class="col-form-legend">¿Tienes algún inversionista interesado?</legend>
                  <div class="col">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="inversionista-interesado">
                        Sí
                      </label>
                    </div> <!-- / .form-check -->
                  </div> <!-- / .col -->
                  <div class="col">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input"  type="radio" name="inversionista-interesado">
                        No
                      </label>
                    </div> <!-- / .form-check -->
                  </div> <!-- / .col -->
                </div> <!-- / .form-row -->
              </fieldset>
              <fieldset>
                <legend class="col-form-legend">Ventas esperadas en los próximos tres años</legend>
                <div class="form-group">
                  <div class="form-row">
                    <div class="col-2">
                      <label class="col-form-label">Año 1:</label>
                    </div> <!-- / .col-2 -->
                    <div class="col-4">
                      <input type="number" class="form-control">
                    </div> <!-- / .col-4 -->
                  </div> <!-- / .form-row -->
                </div> <!-- / .form-group -->
                <div class="form-group">
                  <div class="form-row">
                    <div class="col-2">
                      <label class="col-form-label">Año 2:</label>
                    </div> <!-- / .col-2 -->
                    <div class="col-4">
                      <input type="number" class="form-control">
                    </div> <!-- / .col-4 -->
                  </div> <!-- / .form-row -->
                </div> <!-- / .form-group -->
                <div class="form-group">
                  <div class="form-row">
                    <div class="col-2">
                      <label class="col-form-label">Año 3:</label>
                    </div> <!-- / .col-2 -->
                    <div class="col-4">
                      <input type="number" class="form-control">
                    </div> <!-- / .col-4 -->
                  </div> <!-- / .form-row -->
                </div> <!-- / .form-group -->
              </fieldset>
              <fieldset>
                <legend class="col-form-legend">¿Qué das a cambio de la inversión?</legend>
                <div class="form-row">
                  <div class="col">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox">
                        Deuda simple
                      </label>
                    </div> <!-- / .form-check -->
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox">
                        Deuda convertible
                      </label>
                    </div> <!-- / .form-check -->
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox">
                        Participación
                      </label>
                    </div> <!-- / .form-check -->
                  </div> <!-- / .col -->
                  <div class="col">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox">
                        Revenue share
                      </label>
                    </div> <!-- / .form-check -->
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox">
                        Mixto
                      </label>
                    </div> <!-- / .form-check -->
                  </div> <!-- / .col -->
                </div> <!-- / .form-row -->
              </fieldset>
            </div> <!-- / .col-lg-8 -->
          </div> <!-- / .row -->
        </div> <!-- / .content -->
      </div> <!-- / .container -->

      <div class="container-fluid bg-light">
        <div class="container">
          <div class="content">
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <fieldset>
                  <p><legend><span class="h2 text-primary">11.</span> <span class="h3">Documentos  Clave</span></legend></p>
                  <div class="form-group file-upload">
                    <label>Resumen Ejecutivo, Modelo Financiero, Plan de Negocios, Acta Constitutiva (si aplica), Estados o Proyecciones Financieras, Registro Federal de Contribuyentes (si aplica) e Identificación oficial del titular de proyecto.</label>
                    <p><span class="btn btn-secondary file-button">Subir archivo</span></p>
                    <input type="file" class="file-trigger">
                  </div> <!-- / .file-upload -->
                </fieldset>
              </div> <!-- / .col-lg-8 -->
            </div> <!-- / .row -->
          </div> <!-- / .content -->
        </div> <!-- / .container -->
      </div> <!-- / .container-fluid -->

      <div class="container">
        <div class="content">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <fieldset>
                <p><legend><span class="h2 text-primary">12.</span> <span class="h3">Material extra</span></legend></p>
                <div class="form-group file-upload">
                  <label>Sube archivos que sean importantes para comprobar o ampliar los datos previamente expuestos.</label>
                  <p><span class="btn btn-secondary file-button">Subir archivo</span></p>
                  <input type="file" class="file-trigger">
                </div> <!-- / .file-upload -->
              </fieldset>
            </div> <!-- / .col-lg-8 -->
          </div> <!-- / .row -->
        </div> <!-- / .content -->
      </div> <!-- / .container -->

      <div class="container-fluid bg-light">
        <div class="container">
          <div class="content">
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <p class="text-center"><button class="btn btn-primary" type="submit">Enviar solicitud</button></p>
              </div> <!-- / .col-lg-8 -->
            </div> <!-- / .row -->
          </div> <!-- / .content -->
        </div> <!-- / .container -->
      </div> <!-- / .container-fluid -->

    </form>

@endsection