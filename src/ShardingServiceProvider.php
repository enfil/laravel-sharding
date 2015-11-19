<?php

namespace Enfil\Sharding;

use Illuminate\Support\ServiceProvider;
use Enfil\Sharding\ShardManager;
use Enfil\Sharding\MapManager;

class ShardingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'sharding');
        $this->publishes([
            __DIR__.'/config/config.php' => config_path('sharding.php')
        ], 'config');
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConnectionManager();
        $this->app->bind('enfil.shardmanager', function () {
            return new ShardManager(
                $this->app['enfil.map_manager']
            );
        });

    }
    /**
     * Register the bindings for the ConnectionManager
     */
    protected function registerConnectionManager()
    {
        $this->app->bind('enfil.map_manager', function ($app) {
            $map = config('sharding.map');
            return new MapManager($map);
        });
    }
}
