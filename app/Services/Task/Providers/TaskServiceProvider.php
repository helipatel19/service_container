<?php

namespace App\Providers;

use App\Task;
use App\Services\Task\TaskService;
use App\Repositories\Task\TaskInterface;
use Illuminate\Support\ServiceProvider;

class TaskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
       $this->app->bind(TaskService::class, function ($app) {
            return new TaskService($app[ TaskInterface::class ]);
       });
    }

    /**
      * Get the services provided by the provider.
      *
      * @return array
    */
    public function provides()
    {
           return [TaskService::class];
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
