<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\UserCity;

class UsersCitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store($cityId)
    {
        $cityParam = City::findOrFail($cityId);
        $cityLine = UserCity::where('userId', auth()->user()->id)
                            ->where('cityId', $cityParam->id)
                            ->first();
        if ($cityLine) {
          $this->destroy($cityLine->id);
        } else {
          $userCity = new UserCity();
          $userCity->userId = auth()->user()->id;
          $userCity->cityId = $cityId;
          $userCity->save();

        }
        return redirect()->action('CitiesController@show', ['city' => $cityParam->city]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userCity = UserCity::findOrFail($id);
        $userCity->delete();
        return;
    }
}
