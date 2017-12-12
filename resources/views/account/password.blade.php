@extends('layouts.site', [
  'title' => 'Actualizar mi contraseña'
])
@section('header')
<div class="container">
  <div class="row my-3 justify-content-center">

    <div class="col-lg-6">
      <p><a href="{{route('account.index')}}"><i class="icon-arrow-left2"></i> Regresar</a></p>
      <b-card title="Actualizar contraseña">
        <password-form :window-redirect="true"></password-form>
      </b-card>
    </div><!-- /.col-lg-5 -->
  </div><!-- /.row -->
</div><!-- /.container -->
@endsection