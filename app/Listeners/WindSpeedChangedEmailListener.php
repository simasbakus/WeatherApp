<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\User;
use App\UserCity;

class WindSpeedChangedEmailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
      $userCities = UserCity::where('cityId', $event->city->id)->get();
      foreach ($userCities as $userCity) {
          $user = User::findOrFail($userCity->userId);
          if ($event->city->windSpeed < 10) {
            // email user wind droped
          } else {
            // email user wind rised
          };

      };
    }
}
