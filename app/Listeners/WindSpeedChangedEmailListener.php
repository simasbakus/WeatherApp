<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\User;
use App\UserCity;
use Illuminate\Support\Facades\Mail;
use App\Mail\WindRoseMail;
use App\Mail\WindDropedMail;

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
      $data = $event->city;
      foreach ($userCities as $userCity) {
          $user = User::findOrFail($userCity->userId);
          if ($event->city->windSpeed < 10) {
            // Mail::to("$user->email")->send(new WindDropedMail($data));
            // for dev is disabled
          } else {
            // Mail::to("$user->email")->send(new WindRoseMail($data));
            // for dev is disabled
          };

      };
    }
}
