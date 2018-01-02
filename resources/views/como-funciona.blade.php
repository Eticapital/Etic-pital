@extends('layouts.site')

@section('content')
      <div class="container">
        <div class="content">
          <div class="row justify-content-center">
            <div class="col-lg-8 text-justify">
              <p class="text-center"><span class="h2 text-primary">¿Cómo funciona?</span></p>
              <p>En Etic@pital buscamos reunir los proyectos agrícolas más innovadores del país, lo que nos permite abrir dichos proyectos a un mayor grupo de inversionistas que al diversificar su ahorro podrán compartir del beneficio económico y social al ayudar a crear fuentes de empleo.</p>

              <p>Privilegiamos iniciativas agroalimentarias innovadoras constituidas en una empresa de al menos un año de operación y que a través de estados financieros nos puedan demostrar capacidad de crecimiento potencial que les permita recibir diferentes tipos de inversión.</p>

              <p>Sin embargo, estamos abiertos a cualquier iniciativa innovadora que represente un potencial de negocio económico y social.</p>
            </div> <!-- / .col-lg-8 -->
          </div> <!-- / .row -->
        </div> <!-- / .content -->
      </div> <!-- / .container -->

      <div class="container-fluid content-img-bg py-5" id="invertir">
        <div class="content">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-md-10">
                <p class="text-center h2 mb-5">¿Buscas invertir?</p>

                <p class="text-justify">Nuestro equipo de evaluación se encarga de ofrecer las mejores alternativas de Inversión en empresas legalmente constituidas que tienen gran potencial de crecimiento económico con responsabilidad social, reduciendo el riesgo. Representando así, un adecuado equilibrio en la rentabilidad esperada de tus inversiones. En Eticapital existen dos formas de invertir recursos:</p>
                <p class="text-center h3 my-5">En Eticapital existen dos formas de invertir recursos:</p>
              </div><!-- /.col-md-8 -->
            </div><!-- /.row -->
            <div class="row text-justify">
              <div class="col-md-6">
                <p class="text-center mb-4"><img src="{{ asset('img/comofunciona_icon1.png') }}" alt="" /></p>
                <p>La primera es que tú como inversionista decidas a qué proyecto, de entre el selecto grupo de iniciativas que hemos considerado para abrirlas a la inversión.  Las inversiones institucionales también caben en este apartado. </p>
                <p class="text-center mt-5"><a href="{{ route('invertir') }}" class="btn btn-secondary btn-wide">Crowdfunding</a></p>
              </div><!-- /.col-md-6 -->
              <div class="col-md-6">
                <p class="text-center mb-4"><img src="{{ asset('img/comofunciona_icon2.png') }}" alt="" /></p>
                <p>La segunda es a través de un portafolio diversificado que se aplica por medio del fondo de inversión Eticapital donde los rendimientos tienden a ser ligeramente más bajos pero pones tu dinero en manos de expertos para que nosotros diversifiquemos el riesgo.</p>
                <p class="text-center mt-5"><a href="{{ route('fondo-de-inversion') }}" class="btn btn-secondary btn-wide">Fondos de capital</a></p>
              </div><!-- /.col-md-6 -->
            </div> <!-- / .row -->
          </div> <!-- / .container -->
        </div> <!-- / .content -->
      </div> <!-- / .container-fluid -->

      <div class="container-fluid bg-light">
        <div class="content">
          <div class="container">
            <div class="row">
              <div class="col-12 col-lg-4 d-flex align-items-center justify-content-center">
                <img src="{{asset('img/comofunciona_icon3.png')}}" class="icon">
              </div> <!-- / .col-lg-4 -->
              <div class="col-12 col-lg-8 text-justify">
                <p><span class="h3">Para invertir</span></p>
                  <ol>
                    <li>Selecciona la forma de invertir (Crowdfunding o a través del Fondo)</li>
                    <li>Elige tu proyecto y proporciona algunos datos</li>
                    <li>Haz una promesa de inversión</li>
                    <li>Espera a que el dueño de la compañía la apruebe</li>
                    <li>Espera una invitación para formalizar la inversión persona a persona en las oficinas de Eticapital. NO REALIZAMOS TRANSACCIONES EN LÍNEA. </li>
                  </ol>
              </div> <!-- / .col-lg-8 -->
            </div> <!-- / .row -->
          </div> <!-- / .container -->
        </div> <!-- / .content -->
      </div> <!-- / .container-fluid -->

      <div class="container-fluid py-5 content-img-bg" id="levantar-fondos">
        <div class="content">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-8 text-justify">
                <p class="text-center"><span class="h2">¿Buscas levantar fondos?</span></p>
                <p>Si tienes una excelente iniciativa agrícola innovadora y ya tienes más de un año de constitución entonces no dudes en aplicar, para que te ayudemos a conseguir fondos de personas que además de confiar en tu modelo de negocios confían en ti. </p>
                <p>O, si tienes una iniciativa innovadora de negocio que, aunque no sea agrícola pueda representar un negocio potencial económico y social, no dudes en subir tu proyecto. </p>
                <p>Luego de un proceso de análisis de tu proyecto de negocio, en conjunto buscamos que tu empresa sea la mejor alternativa para levantar capital.  <a href="{{ route('fondear-mi-proyecto') }}">Puedes llenar tu formulario aquí.</a></p>
              </div> <!-- / .col-lg-8 -->
            </div> <!-- / .row -->
          </div> <!-- / .container -->
        </div> <!-- / .content -->
      </div> <!-- / .container-fluid -->

      <div class="container-fluid bg-light">
        <div class="content">
          <div class="container">
            <div class="row">
              <div class="col-12 col-lg-4 d-flex align-items-center justify-content-center">
                <img src="{{ asset('img/comofunciona_icon4.png') }}" class="icon">
              </div> <!-- / .col-lg-4 -->
              <div class="col-12 col-lg-8">
                <p><span class="h3">Los principales puntos a evaluar de una compañía, entre otros, son:</span></p>
                <ul>
                  <li>Los principales puntos a evaluar de una compañía, entre otros, son:</li>
                  <li>La experiencia que tiene realizando su actividad</li>
                  <li>En nivel de desarrollo tecnológico</li>
                  <li>Su impacto social o ambiental</li>
                  <li>Indicadores financieros de liquidez y de generación de valor</li>
                  <li>El nivel de tracción de la iniciativa </li>
                  <li>Activos como patentes y Capex</li>
                  <li>Oportunidad de mercado</li>
                  <li>Mecanismos de distribución</li>
                  <li>Capital de trabajo & Burning rate</li>
                </ul>
                <p><a href="{{ route('fondear-mi-proyecto') }}" class="btn btn-wide btn-secondary">Aplicar ahora</a></p>
              </div> <!-- / .col-lg-8 -->
            </div> <!-- / .row -->
          </div> <!-- / .container -->
        </div> <!-- / .content -->
      </div> <!-- / .container-fluid -->
@endsection