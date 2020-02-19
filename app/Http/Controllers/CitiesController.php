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

            $weather = new City();
            $weather->city = $city;
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
        // $city = City::findOrFail($city);
        $url = "http://api.openweathermap.org/data/2.5/weather?q=$city&APPID=50d091f2d9177ef28cf6718a31a8fb3f";
        $array = file_get_contents($url);
        $decoded = json_decode($array);

        return view('currentWeather', compact('decoded'));
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
<<<<<<< HEAD
    public function checkWind()
    {
        $cities = City::get();
        foreach ($cities as $city) {
          $url = "http://api.openweathermap.org/data/2.5/weather?q=$city->city&APPID=50d091f2d9177ef28cf6718a31a8fb3f";
          $array = file_get_contents($url);
          $decoded = json_decode($array);

          if ($decoded->wind->speed < 10) {
            // dd("vejas mazesnis");
            //testavimui


          }
        };
=======
    public function update(Request $request, $id)
    {
        //
>>>>>>> parent of 7f2d33d... able to refresh all data in database
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
