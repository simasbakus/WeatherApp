@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form class="" action="/weather" method="post">
              <label for="city">Find Your City</label>
              <input type="text" name="city" value="">
              <button type="submit" name="searchBtn" class="btn btn-primary">Search</button>
              @csrf
            </form>
            <h3>{{ $city->city }}</h3>
        </div>
    </div>
</div>
@endsection
