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
              <h1 class="col-6">{{ $city->city }}</h1>
              <h1 class="col">{{ $city->temp }}C</h1>
            </div>
            <div class="row mt-4 mx-2 d-flex justify-content-end">
              <label for="feelsLike" class="col-6">Feels Like</label>
            </div>
            <div class="row mx-2 d-flex justify-content-center">
              <h3 class="col-6">{{ $city->description }}</h3>
              <h3 class="col feelsLike">{{ $city->tempFeels }}C</h3>
            </div>
        </div>
    </div>
</div>
@endsection
