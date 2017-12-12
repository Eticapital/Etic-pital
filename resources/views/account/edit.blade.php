@extends('layouts.site', [
  'title' => 'Actualizar datos de mi cuenta'
])
@section('header')
<div class="container">
  <div class="row my-3 justify-content-center">
    <div class="col-lg-6">
      <p><a href="{{route('account.index')}}"><i class="icon-arrow-left2"></i> Regresar</a></p>
      <b-card title="Actualizar datos de mi cuenta">
        <account-form :window-redirect="true" :user="{{ $user }}"></account-form>
      </b-card>
    </div><!-- /.col-lg-5 -->
  </div><!-- /.row -->
</div><!-- /.container -->
@endsection