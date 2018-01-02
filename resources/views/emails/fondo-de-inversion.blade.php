@component('mail::message')
# Formulario para aplicar a fondo de inversión

## Datos

<strong>Nombre: </strong> {{ $name }}

<strong>Correo electrónico: </strong> {{ $email }}

<strong>Teléfono: </strong> {{ $phone }}


## Tipo de inversionista
<strong>Inversionista acreditado o institucional: </strong> {{ $acreditado ? 'Si' : 'No' }}

<strong>Maneja un portafolio superior a los $100,000 pesos: </strong> {{ $portafolio ? 'Si' : 'No' }}

## Acerca de la inversión
<strong>Desea invertir </strong> ${{ number_format($investment, 0) }}

<strong>Categorías que más te interesan para invertir:</strong>
@foreach($sectors as $sector)
* {{ $sector }}
@endforeach

<strong>Nivel de interés para invertir del 1 al 5 <small>(1 solo tiene curiosidad y 5 está listo para invertir</small>): </strong> {{ $level }}

<strong>Comentario(s) extra</strong>

{!! nl2br($comments) !!}
@endcomponent
