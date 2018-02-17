<?php

namespace InfancyIT\Igloo;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use InfancyIT\Igloo\Commands\IglooCommand;
use InfancyIT\Igloo\Commands\ModelCommand;
use InfancyIT\Igloo\Commands\RepositoryCommand;
use InfancyIT\Igloo\Commands\ServiceCommand;

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
//            __DIR__ . '/../publish/BaseSettings/' => app_path('BaseSettings'),
//            __DIR__ . '/../publish/Responses/' => app_path('Responses'),
//            __DIR__ . '/../publish/Transformers/' => app_path('Transformers'),
        ], 'InfancyIT-Igloo');
        include __DIR__.'/routes/web.php';
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
        $this->iglooCommandCreator();
        $this->app->make('InfancyIT\Igloo\Controllers\AutomateController');
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
