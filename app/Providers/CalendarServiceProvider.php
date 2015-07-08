<?php

namespace App\Providers;

use App\Model\Date;
use App\Service\Calendar;
use Illuminate\Support\ServiceProvider;

/**
 * Class CalendarServiceProvider
 *
 * @package App\Providers
 */
class CalendarServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Service\Calendar',
            function($app)
            {
                return new Calendar(Date::all());
            }
        );

    }

}