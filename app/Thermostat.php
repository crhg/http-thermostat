<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thermostat extends Model
{
    const OFF = 0;
    const ON = 1;

    const HEATING = 1;
    const COOLING = 2;

    protected $guarded = ['id', 'name'];
    protected $fillable = ['name', 'on_off', 'heating_cooling', 'target_temperature', 'target_humidity'];

    public static function get($name)
    {
        return Thermostat::firstOrCreate(
            [   'name' => $name
            ],
            [
                'on_off' => self::OFF,
                'heating_cooling' => self::COOLING,
                'target_temperature' => 25.0,
                'target_humidity' => 0.5,
            ]
        );
    }

    public function targetHeatingCoolingState()
    {
        if ($this->on_off == self::OFF) {
            return 0;
        } else {
            if ($this->heating_cooling == self::HEATING) {
                return 1;
            } else {
                return 2;
            }
        }
    }
}
