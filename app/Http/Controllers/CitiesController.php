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

            return redirect("/weather/$city");

        } else {

            $url = "http://api.openweathermap.org/data/2.5/weather?q=$city&APPID=50d091f2d9177ef28cf6718a31a8fb3f";
            $array = file_get_contents($url);
            $decoded = json_decode($array);
            $temp = $decoded->main->temp - 273.15;
            $weather = new City();
            $weather->city = $city;
            $weather->temp = $temp;
            $weather->windSpeed = $decoded->wind->speed;
            $weather->windDir = $decoded->wind->deg;
            $weather->save();

            return redirect("/weather/$city");
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
        $cityParam = City::where('city', $city)->first();

        return view('currentWeather', compact('cityParam'));
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

    public function update()
    {
        $cities = City::get();
        foreach ($cities as $city) {
          if ($city->windSpeed < 10) {
            $url = "http://api.openweathermap.org/data/2.5/weather?q=$city->city&APPID=50d091f2d9177ef28cf6718a31a8fb3f";
            $array = file_get_contents($url);
            $decoded = json_decode($array);
            $temp = $decoded->main->temp - 273.15;
            $city->temp = $temp;
            $city->windSpeed = $decoded->wind->speed;
            $city->windDir = $decoded->wind->deg;
            $city->save();
            if ($city->windSpeed >= 10) {
              // event
            };
          } else {
            $url = "http://api.openweathermap.org/data/2.5/weather?q=$city->city&APPID=50d091f2d9177ef28cf6718a31a8fb3f";
            $array = file_get_contents($url);
            $decoded = json_decode($array);
            $temp = $decoded->main->temp - 273.15;
            $city->temp = $temp;
            $city->windSpeed = $decoded->wind->speed;
            $city->windDir = $decoded->wind->deg;
            $city->save();
            if ($city->windSpeed < 10) {
              // event
            };
          };
        }
        return redirect('/home');
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
