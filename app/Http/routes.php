<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$app->get('/', function() use ($app) {
    return $app->welcome();
});

$app->group(
    [
        'prefix'    => '/api_v1',
        'as'        => 'api_v1',
    ],
    function(\Laravel\Lumen\Application $app)
    {
        $app->get(
            'is_working/{date}',
            [
                'as'        => 'isWorking',
                'uses'      => 'App\Http\Controllers\Api\Calendar\Controller@isWorkingDay',
            ]
        );

        $app->get(
            'add_working/{days}/to/{date}',
            [
                'as'        => 'addWorking',
                'uses'      => 'App\Http\Controllers\Api\Calendar\Controller@addWorkingDays',
            ]
        );

        $app->get(
            'add/{days}/to/{date}',
            [
                'as'        => 'addRegular',
                'uses'      => 'App\Http\Controllers\Api\Calendar\Controller@addDays',
            ]
        );

        $app->get(
            'sub_working/{days}/from/{date}',
            [
                'as'        => 'subWorking',
                'uses'      => 'App\Http\Controllers\Api\Calendar\Controller@subWorkingDays',
            ]
        );

        $app->get(
            'sub/{days}/from/{date}',
            [
                'as'        => 'subRegular',
                'uses'      => 'App\Http\Controllers\Api\Calendar\Controller@subDays',
            ]
        );

        $app->get(
            'count_working/from/{dateFrom}/to/{dateTo}',
            [
                'as'        => 'countWorking',
                'uses'      => 'App\Http\Controllers\Api\Calendar\Controller@countWorkingDays',
            ]
        );

        $app->get(
            'count/from/{dateFrom}/to/{dateTo}',
            [
                'as'        => 'countRegular',
                'uses'      => 'App\Http\Controllers\Api\Calendar\Controller@countDays',
            ]
        );
    }
);
