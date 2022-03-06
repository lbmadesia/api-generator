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
        $this->loadViewsFrom(__DIR__.'/../views', 'api-generator');
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'api-generator');
        $this->mergeConfigFrom(__DIR__ . '/../config/apiGenerator.php', 'api-generator');

        $this->publishes([
            __DIR__ . '/../config/apiGenerator.php' => config_path('apiGenerator.php'),
        ], 'api-generator');

        $this->publishes([
            __DIR__ . '/../Api' => base_path('routes/Api'),
        ], 'api-generator');

        $this->publishes([
            __DIR__ . '/../APIController.php' => base_path('app/Http/Controllers/APIController.php'),
        ], 'api-generator');

        $this->publishes([
            __DIR__ . '/../migrations/2022_01_02_060149_create_apis_table.php' => database_path('migrations/2022_01_02_060149_create_apis_table.php'),
        ], 'api-generator');


        $this->publishes([
            __DIR__.'/../views' => base_path('resources/views/vendor/api-generator'),
        ],'api-generator');

               // Load the Breadcrumbs for the package
        if (class_exists('Breadcrumbs')) {
            require __DIR__ . '/../breadcrumbs.php';
        }

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
