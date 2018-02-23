<?php

namespace Farhad\Igloo;

use Farhad\Igloo\Commands\ControllerCommand;
use Farhad\Igloo\Commands\RequestCommand;
use Farhad\Igloo\Commands\RouteCommand;
use Farhad\Igloo\Commands\TransformerCommand;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Farhad\Igloo\Commands\IglooCommand;
use Farhad\Igloo\Commands\ModelCommand;
use Farhad\Igloo\Commands\RepositoryCommand;
use Farhad\Igloo\Commands\ServiceCommand;

class IglooServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../publish/Rep/' => app_path('Repositories'),
            __DIR__ . '/../publish/Ser/' => app_path('Services'),
            __DIR__ . '/../publish/BS/' => app_path('BaseSettings'),
            __DIR__ . '/../publish/Res/' => app_path('Responses'),
            __DIR__ . '/../publish/Tran/' => app_path('Transformers'),
            __DIR__ . '/../publish/Req/' => app_path('Http/Requests'),
        ], 'Farhad-Igloo');
//        include __DIR__.'/routes/web.php';
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->modelCommandCreator();
        $this->repositoryCommandCreator();
        $this->serviceCommandCreator();
        $this->transformerCommandCreator();
        $this->iglooCommandCreator();
        $this->requestCommandCreator();
        $this->routeCommandCreator();
        $this->controllerCommandCreator();
        $this->app->make('Farhad\Igloo\Controllers\AutomateController');
    }


    public function modelCommandCreator()
    {
        $this->app->singleton('make.model', function ($app) {
            return new ModelCommand($app['files']);
        });
        $this->commands('make.model');
    }

    public function repositoryCommandCreator()
    {
        $this->app->singleton('make.repo', function ($app) {
            return new RepositoryCommand($app['files']);
        });
        $this->commands('make.repo');
    }


    public function serviceCommandCreator()
    {
        $this->app->singleton('make.service', function ($app) {
            return new ServiceCommand($app['files']);
        });
        $this->commands('make.service');
    }

    public function transformerCommandCreator()
    {
        $this->app->singleton('make.transformer', function ($app) {
            return new TransformerCommand($app['files']);
        });
        $this->commands('make.transformer');
    }

    public function requestCommandCreator()
    {
        $this->app->singleton('make.request', function ($app) {
            return new RequestCommand($app['files']);
        });
        $this->commands('make.request');
    }

    public function routeCommandCreator()
    {
        $this->app->singleton('make.route', function ($app) {
            return new RouteCommand($app['files']);
        });
        $this->commands('make.route');
    }

    public function controllerCommandCreator()
    {
        $this->app->singleton('make.controller', function ($app) {
            return new ControllerCommand($app['files']);
        });
        $this->commands('make.controller');
    }

    public function iglooCommandCreator()
    {
        $this->app->singleton('igloo', function ($app) {
            return new IglooCommand();
        });
        $this->commands('igloo');
    }






//    /**
//     * Get the services provided by the provider.
//     *
//     * @return array
//     */
//    public function provides()
//    {
//        return [
//            'name.farhad',
//        ];
//    }
}
