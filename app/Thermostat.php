<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thermostat extends Model
{

    public function get()
    {
        return Thermostat::whereId(1)->firstOrCreate([]);
    }
}
