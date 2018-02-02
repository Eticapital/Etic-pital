<footer id="footer" class="footer">
  <div class="footer-social">
    <div class="container d-flex justify-content-center">
        <a class="footer-icon footer-icon-fb" target="_blank" href="https://www.facebook.com/">Facebook</a>
        <a class="footer-icon footer-icon-tw" target="_blank" href="https://www.twitter.com/">Twitter</a>
        <a class="footer-icon footer-icon-in" target="_blank" href="https://www.instagram.com/">Instagram</a>
        <a class="footer-icon footer-icon-li" target="_blank" href="https://www.linkedin.com/">LinkedIn</a>
        <a class="footer-icon footer-icon-yt" target="_blank" href="https://www.youtube.com/">Youtube</a>
    </div><!-- /.container -->
  </div>
  <div class="container footer-menu">
    <div class="row d-flex align-items-end">
      <div class="col-sm-6 text-center text-sm-left">
        <p><img src="{{ asset('img/logo-footer.png') }}" alt="Eticapital" /></p>
        <h4>¡Queremos conocerte!</h4>
        <p>
          +52 (722) 474 5926<br />
          +52 (722) 304 7852
        </p>
        <h4><a class="text-primary" href="mailto: informes@eticapital.mx">informes@eticapital.mx</a></h4>
      </div>
      <div class="col-sm-6">
        <div class="row">
          <div class="col-sm-6">
            <ul class="menu-footer list-unstyled">
              <li><a href="{{ route('como-funciona') }}">¿Cómo funciona?</a></li>
              <li><a href="/index.html#que_hacemos">Propósito</a></li>
              <li><a href="/index.html#opcion">¿Cómo elegir?</a></li>
              <li><a href="/index.html#contacto">Crezcamos juntos</a></li>
            </ul>
          </div><!-- /.col-sm-6 -->
          <div class="col-sm-6">
            <ul class="menu-footer list-unstyled">
              <li class="menu-footer-crowfunding"><a href="{{ route('home') }}">Crowfunding</a></li>
              <li><a href="{{ route('invertir') }}">Invertir</a></li>
              <li><a href="{{ route('fondear-mi-proyecto') }}">Fondear mi proyecto</a></li>
              <li><a href="{{ route('login') }}">Ingresar</a></li>
            </ul>
          </div><!-- /.col-sm-6 -->
        </div><!-- /.row -->
        {{-- <div class="row mb-3">
          <div class="col-12 col-lg-6">
            <a href="{{ route('terminos-y-condiciones') }}">Términos y condiciones</a>
            <br><a href="{{ route('aviso-de-privacidad') }}">Aviso de privacidad</a>
            <br><a href="/corporativo">Etic@pital Corporativo</a>
          </div>
          <div class="col-12 col-lg-6">
            <strong>Contáctanos:</strong>
            <br>informes@eticapital.mx
          </div>
        </div> --}}
      </div> <!-- / .col -->
    </div> <!-- / .row -->
  </div> <!-- / .container -->
  <div class="footer-legals">
    <div class="container">
      <div class="row align-items-center py-4">
        <div class="col-sm-6  text-center text-sm-left">
          <a href="">Derechos reservados</a>
        </div>
        <div class="col-sm-6 d-flex justify-content-sm-end flex-sm-row flex-column text-center text-sm-left">
          <a href="">Conoce nuestro aviso de privacidad</a>
          <a class="pl-sm-4" href="">Términos y condiciones</a>
        </div>
      </div><!-- /.row -->
    </div>
  </div>
</footer>