<?php
/**
 * Created by PhpStorm.
 * User: matsui
 * Date: 2017/09/26
 * Time: 23:30
 */
namespace App\RESTfulAPI\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckThermostatName
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $name = $request->route()->parameter('name');
        $config = config('thermostat.'.$name);
        if (is_null($config)) {
            throw new NotFoundHttpException("thermostat not exists: $name");
        }

        return $next($request);
    }
}