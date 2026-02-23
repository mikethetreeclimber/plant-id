<?php

namespace ArbmanX\PlantId;

use Illuminate\Support\ServiceProvider;

class PlantIdServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/plant-id.php', 'plantId');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'plant-id');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/plant-id.php' => config_path('plantId.php'),
            ], 'plant-id-config');

            $this->publishes([
                __DIR__ . '/resources/views' => resource_path('views/vendor/plant-id'),
            ], 'plant-id-views');
        }
    }
}
