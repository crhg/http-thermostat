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
use App\RESTfulAPI\Middleware\CheckThermostatName;
use App\Thermostat;
use Crhg\LaravelIRKit\Facades\IRKit;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Response;

class HttpthermostatApi extends HttpthermostatApiBase
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware(CheckThermostatName::class);
    }

    /**
     * Operation status
     *
     * Get any thermostat info.
     *
     * @param Request $request
     * @param string $name thermostat name
     *
     * @return \Illuminate\Http\Response
     */
    protected function status(Request $request, $name)
    {
        \Log::debug('status', ['accessory' => $name]);
        /** @var Thermostat $thermostat */
        $thermostat = Thermostat::get($name);

        $result = [
            'targetHeatingCoolingState'  => $thermostat->targetHeatingCoolingState(),
            'targetTemperature'          => 0.0 + $thermostat->target_temperature,
            'targetRelativeHumidity'     => 0.0 + $thermostat->target_humidity,
            'currentHeatingCoolingState' => 0 + $thermostat->targetHeatingCoolingState(),
            'currentTemperature'         => 0.0 + $thermostat->target_temperature,
            'currentRelativeHumidity'    => 0.0 + $thermostat->target_humidity,
        ];

        return Response::json($result);
    }

    /**
     * Operation targetHeatingCoolingState
     *
     * Set heating/cooling state.
     *
     * @param Request $request
     * @param string $name
     * @param float $state (required)
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    protected function targetHeatingCoolingState(Request $request, $name, $state)
    {
        \Log::debug('targetHeatingCoolingState', ['accessory' => $name, 'state' => $state]);

        $thermostat = Thermostat::get($name);

        switch ($state) {
        case 0:
            $thermostat->on_off = Thermostat::OFF;
            break;
        case 1:
            $thermostat->on_off = Thermostat::ON;
            $thermostat->heating_cooling = Thermostat::HEATING;
            break;
        case 2:
            $thermostat->on_off = Thermostat::ON;
            $thermostat->heating_cooling = Thermostat::COOLING;
            break;
        case 3:
            $thermostat->on_off = Thermostat::ON;
            break;
        default:
            throw new \Exception("invalid state: $state");
        }

        $this->send($thermostat);

        $thermostat->save();

        return response('Ok')->setStatusCode(200);
    }


    protected function off(Request $request, $name)
    {
        \Log::debug('off', ['name' => $name]);
        $thermostat = Thermostat::get($name);
        $thermostat->on_off = Thermostat::OFF;
        $this->send($thermostat);
        $thermostat->save();

        return response('Ok')->setStatusCode(200);
    }

    protected function comfort(Request $request, $name)
    {
        \Log::debug('comfort', ['name' => $name]);
        $thermostat = Thermostat::get($name);
        $thermostat->on_off = Thermostat::ON;
        $thermostat->heating_cooling = Thermostat::HEATING;
        $this->send($thermostat);
        $thermostat->save();

        return response('Ok')->setStatusCode(200);
    }

    protected function noFrost(Request $request, $name)
    {
        \Log::debug('noFrost', ['name' => $name]);
        $thermostat = Thermostat::get($name);
        $thermostat->on_off = Thermostat::ON;
        $thermostat->heating_cooling = Thermostat::COOLING;
        $this->send($thermostat);
        $thermostat->save();

        return response('Ok')->setStatusCode(200);
    }


    protected function auto(Request $request, $name)
    {
        \Log::debug('auto', ['name' => $name]);
        $thermostat = Thermostat::get($name);
        $thermostat->on_off = Thermostat::ON;
        $this->send($thermostat);
        $thermostat->save();

        return response('Ok')->setStatusCode(200);
    }

    /**
     * Operation targetRelativeHumidity
     *
     * Set target relative humidity.
     *
     * @param Request $request
     * @param string $name
     * @param float $humidity (required)
     *
     * @return \Illuminate\Http\Response
     */
    protected function targetRelativeHumidity(Request $request, $name, $humidity)
    {
        \Log::debug('targetRelativeHumidity', ['accessory' => $name, 'humidity' => $humidity]);

        $thermostat = Thermostat::get($name);
        $thermostat->target_humidity = $humidity;
        $thermostat->save();

        return response('Ok')->setStatusCode(200);
    }

    /**
     * Operation targetTemperature
     *
     * Set target temperature.
     *
     * @param Request $request
     * @param string $name
     * @param float $temp (required)
     *
     * @return \Illuminate\Http\Response
     */
    protected function targetTemperature(Request $request, $name, $temp)
    {
        \Log::debug('targetTemperature', ['accessory' => $name, 'temp' => $temp]);

        $thermostat = Thermostat::get($name);
        $thermostat->target_temperature = $temp;
        $thermostat->save();

        $this->send($thermostat);

        return response('Ok')->setStatusCode(200);
    }

    protected function send(Thermostat $thermostat)
    {
        $accessory = config('thermostat.'.$thermostat->name.'.accessory');
        $command = $this->selectCommand($thermostat);
        \Log::debug('send', ['accessory' => $accessory, 'command' => $command]);
        IRkit::send($accessory, $command);
    }

    protected function selectCommand(Thermostat $thermostat)
    {
        if ($thermostat->on_off == Thermostat::OFF) {
            return config('thermostat.'.$thermostat->name.'.command.off');
        } else {
            $heating_or_cooling = $thermostat->heating_cooling == Thermostat::HEATING? 'heating': 'cooling';
            $target_temperature = $thermostat->target_temperature;
            $e = collect(config('thermostat.thermostat1.command.'.$heating_or_cooling))
                ->reduce(
                    function ($current, $e) use ($target_temperature) {
                        if (is_null($current)) {
                            return $e;
                        }

                        $distance_e = abs($e['temperature'] - $target_temperature);
                        $distance_current = abs($current['temperature'] - $target_temperature);

                        if ($distance_e < $distance_current) {
                            return $e;
                        }

                        if ($distance_e == $distance_current && $e['temperature'] > $current['temperature']) {
                            return $e;
                        }

                        return $current;
                    }
                );
            return $e['command'];
        }
    }
}
