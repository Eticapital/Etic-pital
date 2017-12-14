@extends('layouts.site', [
  'title' => $project->name . ': Promesas de inversión'
])
@section('header')
<div class="container">
  <p><a href="{{ route('account.projects') }}"><i class="icon-arrow-left2"></i> Regresar</a></p>
  <h2 class="text-primary">
    <a class="small" href="{{ route('account.projects') }}">Proyectos</a> /
    {{ $project->name }}: Promesas de inversión
  </h2>
  @if($investments->count())
    <table class="table">
      <thead>
        <tr>
          <th>Monto</th>
          <th>Nombre</th>
          <th>Email</th>
          <th>Teléfono</th>
          <th>Residencia</th>
          <th>Organización</th>
          <th>Estatus</th>
        </tr>
      </thead>
      <tbody>
        @foreach($investments as $investment)
        <tr>
          <td>{{ money($investment->amount) }}</td>
          <td>{{ $investment->name }}</td>
          <td>{{ $investment->email }}</td>
          <td>{{ $investment->phone }}</td>
          <td>{{ $investment->residenceor or '-'  }}</td>
          <td>{{ $investment->organization or '-' }}</td>
          <td>
            <investments-status-btn :investment="{{ $investment->append(['can_accept', 'can_reject']) }}">
          </td>
        </tr>
        @endforeach
      </tbody>
    </table><!-- /.table -->
    @if($investments->hasMorePages())
    <nav class="mt-3 d-flex justify-content-center">
      {!! $investments->links() !!}
    </nav>
    @endif
  @else
    <p class="my-3"><i>No has recibido ninguna promesa de inversión aún. ¡Comparte tu proyecto!</p>
  @endif
</div><!-- /.container -->
@endsection