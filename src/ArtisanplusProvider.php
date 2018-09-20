<?php

namespace Grahh\Artisanplus;

use Illuminate\Support\ServiceProvider;

class ArtisanplusProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/artisanplus.php' => config_path('artisanplus.php'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/artisanplus.php', 'artisanplus'
        );

        $this->commands(config('artisanplus.commands'));
    }
}
