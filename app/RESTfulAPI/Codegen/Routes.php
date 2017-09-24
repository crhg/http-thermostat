<?php
/**
 * HTTP Thermostat
 * HTTP Thermostat API
 *
 * OpenAPI spec version: 1.0.0
 * 
 *
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen.git
 * Do not edit the class manually.
 */


namespace App\RESTfulAPI\Codegen;

class Routes
{
    public static function addWebRoutes()
    {
        // web routes are not supported yet.
    }

    public static function addApiRoutes()
    {
        // HTTP Thermostat (1.0.0)
        \Route::GET('/api/status', '\App\RESTfulAPI\Controllers\HttpthermostatApi@statusWithValidate');
        \Route::GET('/api/targetHeatingCoolingState/{state}', '\App\RESTfulAPI\Controllers\HttpthermostatApi@targetHeatingCoolingStateWithValidate');
        \Route::GET('/api/targetRelativeHumidity/{humidity}', '\App\RESTfulAPI\Controllers\HttpthermostatApi@targetRelativeHumidityWithValidate');
        \Route::GET('/api/targetTemperature/{temp}', '\App\RESTfulAPI\Controllers\HttpthermostatApi@targetTemperatureWithValidate');
    }
}