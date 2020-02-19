<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCity extends Model
{
  public $fillable = [
    'userId', 'cityId'
  ];
}
