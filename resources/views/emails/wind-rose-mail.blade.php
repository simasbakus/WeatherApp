@component('mail::message')
  @component('mail::message')
  #Update!!!
  <h1>Wind Speed In <strong>{{ $data->city }}</strong> Rose Above 10 m/s</h1>
  <h2>Current Wind Speed <strong>{{ $data->windSpeed }} m/s</strong></h2>
  @endcomponent
@endcomponent
