<?php

namespace Meesudzu\Translation;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LangmanServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/translation-gui.php' => config_path('translation-gui.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/translation'),
        ], 'assets');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'translation');

        $this->registerRoutes();
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/translation-gui.php', 'translation-gui');

        $this->app->singleton(Manager::class, function () {
            return new Manager(
                new Filesystem,
                $this->app['path.lang'],
                [$this->app['path.resources'], $this->app['path']]
            );
        });
    }

    /**
     * Register the Langman routes.
     */
    protected function registerRoutes()
    {
        Route::group(array_merge(config('translation-gui.route_group_config'), ['prefix' => 'admin']), function () {
            Route::get('/translation', 'LangmanController@index')->name('translation');
            Route::post('/translation/save', 'LangmanController@save')->name('translation-save');
            Route::post('/translation/add-language', 'LangmanController@add')->name('translation-add');
        });
    }
}
