<?php

namespace App\Providers;

use App\Repository\CookieQueue;
use App\Repository\DatabaseQueue;
use App\Repository\QueueRepository;
use App\Repository\SessionQueue;
use Illuminate\Support\ServiceProvider;

class QueueProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(QueueRepository::class,function($app){
            return new DatabaseQueue();
        });
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
