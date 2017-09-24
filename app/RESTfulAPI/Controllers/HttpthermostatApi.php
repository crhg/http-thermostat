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


namespace App\RESTfulAPI\Controllers;

use App\RESTfulAPI\Codegen\Controllers\HttpthermostatApiBase;
use Illuminate\Http\Request;
use Response;

class HttpthermostatApi extends HttpthermostatApiBase
{
    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Operation status
     *
     * Get any thermostat info.
     *
     *
     * @return \Illuminate\Http\Response
     */
    protected function status(Request $request)
    {
        $result = [
            'targetHeatingCoolingState' => 1,
            'targetTemperature' => 25.0,
            'targetRelativeHumidity' => 0.5,
            'currentHeatingCoolingState' => 1,
            'currentTemperature' => 25.0,
            'currentRelativeHumidity' => 0.5,
        ];

        return Response::json($result);
    }

    /**
     * Operation targetHeatingCoolingState
     *
     * Set heating/cooling state.
     *
     * @param float $state  (required)
     *
     * @return \Illuminate\Http\Response
     */
    protected function targetHeatingCoolingState(Request $request, $state)
    {
        \Log::debug('targetHeatingCoolingState', ['state' => $state]);
        return response('Ok')->setStatusCode(200);
    }

    /**
     * Operation targetRelativeHumidity
     *
     * Set target relative humidity.
     *
     * @param float $humidity  (required)
     *
     * @return \Illuminate\Http\Response
     */
    protected function targetRelativeHumidity(Request $request, $humidity)
    {
        \Log::debug('targetRelativeHumidity', ['humidity' => $humidity]);
        return response('Ok')->setStatusCode(200);
    }

    /**
     * Operation targetTemperature
     *
     * Set target temperature.
     *
     * @param float $temp  (required)
     *
     * @return \Illuminate\Http\Response
     */
    protected function targetTemperature(Request $request, $temp)
    {
        \Log::debug('targetTemperature', ['temp' => $temp]);
        return response('Ok')->setStatusCode(200);
    }
}
