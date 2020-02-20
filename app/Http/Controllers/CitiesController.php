<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\UserCity;
use App\Events\WindSpeedChangedEvent;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
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
        $city = $this->validateRequest()['city'];
        $doesExist = City::where('city', $city)->first();
        if ($doesExist) {

            return redirect("/weather/$city");

        } else {

            $url = "http://api.openweathermap.org/data/2.5/weather?q=$city&APPID=50d091f2d9177ef28cf6718a31a8fb3f";
            $array = file_get_contents($url);
            $decoded = json_decode($array);
            $temp = $decoded->main->temp - 273.15;
            $weather = new City($this->validateRequest());
            $weather->city = $city;
            $weather->temp = $temp;
            $weather->windSpeed = $decoded->wind->speed;
            $weather->windDir = $this->determineWindDirection($decoded->wind->deg);;
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
        if (auth()->user() == true) {
          $userCity = UserCity::where('userId', auth()->user()->id)
          ->where('cityId', $cityParam->id)
          ->first();
        } else {
          $userCity = null;
        };
        return view('currentWeather', compact('cityParam', 'userCity'));
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
            $city->windDir = $this->determineWindDirection($decoded->wind->deg);
            $city->save();
            if ($city->windSpeed >= 10) {
              event(new WindSpeedChangedEvent($city));
            };
          } else {
            $url = "http://api.openweathermap.org/data/2.5/weather?q=$city->city&APPID=50d091f2d9177ef28cf6718a31a8fb3f";
            $array = file_get_contents($url);
            $decoded = json_decode($array);
            $temp = $decoded->main->temp - 273.15;
            $city->temp = $temp;
            $city->windSpeed = $decoded->wind->speed;
            $city->windDir = $this->determineWindDirection($decoded->wind->deg);
            $city->save();
            if ($city->windSpeed < 10) {
              event(new WindSpeedChangedEvent($city));
            };
          };
        }
        return;
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

    public function determineWindDirection($degrees)
    {
      if ($degrees > 22.5 && $degrees <= 67.5) {
        $direction = "North-East";
      } elseif ($degrees > 67.5 && $degrees <= 112.5) {
        $direction = "East";
      } elseif ($degrees > 112.5 && $degrees <= 157.5) {
        $direction = "South-East";
      } elseif ($degrees > 157.5 && $degrees <= 202.5) {
        $direction = "South";
      } elseif ($degrees > 202.5 && $degrees <= 247.5) {
        $direction = "South-West";
      } elseif ($degrees > 247.5 && $degrees <= 292.5) {
        $direction = "West";
      } elseif ($degrees > 292.5 && $degrees <= 337.5) {
        $direction = "North-West";
      } elseif ($degrees > 337.5 || $degrees <= 22.5) {
        $direction = "North";
      };
      return $direction;
    }

    private function validateRequest()
    {
        return request()->validate([
          'city' => 'required|max:255'
        ]);
    }
}
