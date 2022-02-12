<?php

namespace Lbmadesia\ApiGenerator\Provider;

use Illuminate\Support\ServiceProvider;

class ApiCrudGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'generator');
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'generator');
        $this->mergeConfigFrom(__DIR__ . '/../config/generator.php', 'generator');

        $this->publishes([
            __DIR__ . '/../config/apiGenerator.php' => config_path('apiGenerator.php'),
        ], 'generator');
        $this->publishes([
            __DIR__.'/../views' => base_path('resources/views/vendor/api-generator'),
        ]);


    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/../routes.php';
        require_once(__DIR__.'/../helpers.php');
        $this->app->make('Lbmadesia\ApiGenerator\Api');
        $this->app->make('Lbmadesia\ApiGenerator\Controllers\ApiGenerator');
        $this->app->make('Lbmadesia\ApiGenerator\Controllers\ApiController');
        $this->app->make('Lbmadesia\ApiGenerator\Repositories\ApiRepository');
        $this->app->make('Lbmadesia\ApiGenerator\Controllers\ApiTableController');
    }
}
