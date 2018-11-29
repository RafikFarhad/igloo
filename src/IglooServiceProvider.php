<?php

namespace InfancyIt\Igloo;

use InfancyIt\Igloo\Commands\ControllerCommand;
use InfancyIt\Igloo\Commands\CreateRequestCommand;
use InfancyIt\Igloo\Commands\RouteCommand;
use InfancyIt\Igloo\Commands\TransformerCommand;
use InfancyIt\Igloo\Commands\UpdateRequestCommand;
use Illuminate\Support\ServiceProvider;
use InfancyIt\Igloo\Commands\IglooCommand;
use InfancyIt\Igloo\Commands\ModelCommand;
use InfancyIt\Igloo\Commands\RepositoryCommand;
use InfancyIt\Igloo\Commands\ServiceCommand;

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
            __DIR__ . '/../publish/Repositories/' => app_path('Repositories'),
            __DIR__ . '/../publish/Services/' => app_path('Services'),
            __DIR__ . '/../publish/BaseSettings/' => app_path('BaseSettings'),
            __DIR__ . '/../publish/Responses/' => app_path('Responses'),
            __DIR__ . '/../publish/Transformers/' => app_path('Transformers'),
            __DIR__ . '/../publish/Requests/' => app_path('Http/Requests'),
            __DIR__ . '/../publish/config/' => config_path(),
            __DIR__ . '/resources/assets' => public_path('vendor/igloo'),
        ], 'Igloo');

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'igloo');
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
        $this->createRequestCommandCreator();
        $this->updateRequestCommandCreator();
        $this->routeCommandCreator();
        $this->controllerCommandCreator();
        $this->app->make('InfancyIt\Igloo\Controllers\AutomateController');
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

    public function createRequestCommandCreator()
    {
        $this->app->singleton('make.request', function ($app) {
            return new CreateRequestCommand($app['files']);
        });
        $this->commands('make.request');
    }

    public function updateRequestCommandCreator()
    {
        $this->app->singleton('make.request.update', function ($app) {
            return new UpdateRequestCommand($app['files']);
        });
        $this->commands('make.request.update');
    }


    public function routeCommandCreator()
    {
        $this->app->singleton('make.route', function ($app) {
            return new RouteCommand();
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

}
