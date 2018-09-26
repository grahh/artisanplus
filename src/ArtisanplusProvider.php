<?php

namespace Grahh\Artisanplus;

use Grahh\Artisanplus\Contracts\IFormBuilder;
use Grahh\Artisanplus\FormBuilder\BootstrapBuilder;
use Illuminate\Support\Arr;
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

        $this->mergeConfigFrom(
            __DIR__.'/config/artisanplus.php', 'artisanplus'
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(config('artisanplus.commands'));
    }

    /**
     * Merges the configs together and takes multi-dimensional arrays into account.
     *
     * @param  array  $original
     * @param  array  $merging
     * @return array
     */
    protected function mergeConfig(array $original, array $merging)
    {
        $array = array_merge($original, $merging);
        foreach ($original as $key => $value) {
            if (! is_array($value)) {
                continue;
            }
            if (! Arr::exists($merging, $key)) {
                continue;
            }
            if (is_numeric($key)) {
                continue;
            }
            $array[$key] = $this->mergeConfig($value, $merging[$key]);
        }
        return $array;
    }
}
