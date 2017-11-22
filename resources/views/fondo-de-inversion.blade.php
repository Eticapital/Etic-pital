@extends('layouts.site')

@section('content')
<div class="container">
      <div class="content">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-justify">
            <p class="text-center"><span class="h2 text-primary">Aplica para nuestro fondo de inversión</span></p>
            <p>Invierte a través de nuestro fondo de inversión para proyectos agrícolas. Si necesitas más de $300,000, esta puede ser tu solución.</p>
            <p>¿Quieres saber más antes de aplicar? <a href="comofunciona.html#invertir">Consulta aquí cómo funciona</a>.</p>
          </div> <!-- / .col-lg-8 -->
        </div> <!-- / .row -->
      </div> <!-- / .content -->
    </div> <!-- / .container -->

    <form>
      <div class="container-fluid bg-light">
        <div class="container">
          <div class="content">
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <fieldset>
                <p><legend><span class="h2 text-primary">1.</span> <span class="h3">Tus datos</span></legend></p>
                  <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control">
                  </div> <!-- / .form-group -->
                  <div class="form-group">
                    <label>Correo de contacto</label>
                    <input type="email" class="form-control">
                  </div> <!-- / .form-group -->
                  <div class="form-group">
                    <label>Teléfono de contacto</label>
                    <input type="tel" class="form-control">
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
              <p><span class="h2 text-primary">2.</span> <span class="h3">¿Qué tipo de inversionista eres?</span></legend></p>
                <fieldset>
                  <div class="form-row">
                    <legend class="col-form-legend">¿Eres un inversionista acreditado o institucional?</legend>
                    <div class="col">
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="radio" type="checkbox" name="inversionista-interesado">
                          Sí
                        </label>
                      </div> <!-- / .form-check -->
                    </div> <!-- / .col -->
                    <div class="col">
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input"  type="radio" type="checkbox" name="inversionista-interesado">
                          No
                        </label>
                      </div> <!-- / .form-check -->
                    </div> <!-- / .col -->
                  </div> <!-- / .form-row -->
                </fieldset> <!-- / .form-group -->
                <fieldset>
                  <div class="form-row">
                    <legend class="col-form-legend">¿Manejas un portafolio superior a los $100,000 pesos?</legend>
                    <div class="col">
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="radio" type="checkbox" name="inversionista-interesado">
                          Sí
                        </label>
                      </div> <!-- / .form-check -->
                    </div> <!-- / .col -->
                    <div class="col">
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input"  type="radio" type="checkbox" name="inversionista-interesado">
                          No
                        </label>
                      </div> <!-- / .form-check -->
                    </div> <!-- / .col -->
                  </div> <!-- / .form-row -->
                </fieldset> <!-- / .form-group -->
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
                <p><legend><span class="h2 text-primary">3.</span> <span class="h3">Acerca de tu inversión</span></legend></p>
                  <div class="form-group">
                    <label>¿Cuánto deseas invertir?</label>
                    <input type="number" class="form-control">
                  </div> <!-- / .form-group -->
                  <div class="form-group">
                    <p>Elige las categorías de proyecto que más te interesan para invertir:</p>
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

                  <fieldset>
                      <legend class="col-form-legend">¿Cuál es tu nivel de interés para invertir?</legend>
                      <div class="form-rating">
                        <div class="rating-option">
                            <input type="radio" id="rating-option-1" name="inversionista-interesado" checked>
                            <label for="rating-option-1">1</label>
                        </div>
                        <div class="rating-option">
                            <input type="radio" id="rating-option-2" name="inversionista-interesado">
                            <label for="rating-option-2">2</label>
                        </div> <!-- / .form-rating -->
                        <div class="rating-option">
                            <input type="radio" id="rating-option-3" name="inversionista-interesado">
                            <label for="rating-option-3">3</label>
                        </div> <!-- / .form-rating -->
                        <div class="rating-option">
                            <input type="radio" id="rating-option-4" name="inversionista-interesado">
                            <label for="rating-option-4">4</label>
                        </div> <!-- / .form-rating -->
                        <div class="rating-option">
                            <input type="radio" id="rating-option-5" name="inversionista-interesado">
                            <label for="rating-option-5">5</label>
                        </div> <!-- / .form-rating -->
                      </div>
                      <div class="d-flex justify-content-between">
                        <small class="text-primary">Sólo tengo curiosidad</small>
                        <small class="text-primary">Estoy listo para invertir</small>
                      </div>

                    </div> <!-- / .form-row -->
                  </fieldset> <!-- / .form-group -->

                  <div class="form-group">
                    <label>¿Tienes algún comentario extra?</label>
                    <textarea class="form-control" rows="3"></textarea>
                  </div> <!-- / .form-group -->
                </fieldset>
              </div> <!-- / .col-lg-8 -->
            </div> <!-- / .row -->
          </div> <!-- / .content -->
        </div> <!-- / .container -->
      </div> <!-- / .container-fluid -->


      <div class="container-fluid">
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