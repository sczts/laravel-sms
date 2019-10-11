<?php

namespace Sczts\Sms\Providers;

use Sczts\Sms\SmsService;
use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $path = realpath(__DIR__.'/../../config/config.php');

        $this->publishes([$path => config_path('sms.php')]);
    }

    public function register()
    {
        $this->app->alias('sczts.sms', SmsService::class);
    }
}