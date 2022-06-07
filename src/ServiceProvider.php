<?php

namespace Actengage\Capture;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/capture.php', 'capture'
        );

        $this->app->bind(ScreenshotFactory::class, function($app) {
            return new ScreenshotFactory();
        });
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/capture.php' => config_path('capture.php')
        ], 'capture-config');
    }
}