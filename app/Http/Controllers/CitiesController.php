<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $city = request()->city;
        $doesExist = City::where('city', $city)->first();
        if ($doesExist) {
            return redirect("/weather/$doesExist->id");
        } else {
            $url = "http://api.openweathermap.org/data/2.5/weather?q=$city&APPID=50d091f2d9177ef28cf6718a31a8fb3f";
            $array = file_get_contents($url);
            $decoded = json_decode($array);
            $temp = $decoded->main->temp - 273.15;
            $realFeel = $decoded->main->feels_like - 273.15;
            $weather = new City();
            $weather->city = $decoded->name;
            $weather->description = $decoded->weather[0]->description;
            $weather->temp = $temp;
            $weather->tempFeels = $realFeel;
            $weather->windSpeed = $decoded->wind->speed;
            $weather->save();

            return redirect("/weather/$weather->id");
        };
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($city)
    {
        $city = City::findOrFail($city);
        return view('currentWeather', compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $cities = City::get();
        foreach ($cities as $city) {
          $url = "http://api.openweathermap.org/data/2.5/weather?q=$city->city&APPID=50d091f2d9177ef28cf6718a31a8fb3f";
          $array = file_get_contents($url);
          $decoded = json_decode($array);
          $temp = $decoded->main->temp - 273.15;
          $realFeel = $decoded->main->feels_like - 273.15;

          $city->description = $decoded->weather[0]->description;
          $city->temp = $temp;
          $city->tempFeels = $realFeel;
          $city->windSpeed = $decoded->wind->speed;
          $city->save();
        };
        return redirect("/weather/$id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
