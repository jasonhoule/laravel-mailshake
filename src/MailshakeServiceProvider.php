<?php

namespace Jhoule\Mailshake;

use Illuminate\Support\ServiceProvider;

class MailshakeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/mailshake.php' => config_path('mailshake.php'),
        ], 'mailshake');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/mailshake.php', 'mailshake');
        $this->mergeConfigFrom(__DIR__.'/../config/endpoints.php', 'mailshake.endpoints');
    }
}
