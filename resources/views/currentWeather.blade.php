@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <label for="city" class="row d-flex justify-content-center">Find Your City</label>
            <form class="row d-flex justify-content-center" action="/weather" method="post">
              <input type="text" name="city" value="" class="col-4">
              <button type="submit" name="searchBtn" class="btn btn-primary col-2">Search</button>
              @csrf
            </form>
            <div class="row mt-4 mx-2 d-flex justify-content-center">
              <h1 class="col-6">{{ $cityParam->city }}</h1>
              <h1 class="col">{{ $cityParam->temp }} C</h1>
            </div>
            <div class="row mx-2 d-flex justify-content-center">
              <h3 class="col-6">{{ $cityParam->windSpeed }} m/s</h3>
              <h3 class="col feelsLike">{{ $cityParam->windDir }} degrees</h3>
            </div>
            <form class="" action="/update" method="post">
              @method('PATCH')
              @csrf
              <button type="submit" name="button">update</button>
            </form>
        </div>
    </div>
</div>
@endsection
