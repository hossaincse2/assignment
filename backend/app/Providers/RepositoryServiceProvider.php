<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register Interface and Repository in here

        $this->app->bind(
            'App\Interfaces\UserInterface',
            'App\Repositories\UserRepository'
        );

        $this->app->bind(
            'App\Interfaces\ProductInterface',
            'App\Repositories\ProductRepository'
        );

        $this->app->bind(
            'App\Interfaces\OrderInterface',
            'App\Repositories\OrderRepository'
        );
        $this->app->bind(
            'App\Interfaces\NotificationInterface',
            'App\Repositories\NotificationRepository'
        );
    }
}
