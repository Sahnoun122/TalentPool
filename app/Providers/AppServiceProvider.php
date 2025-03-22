<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
 


    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\UserRepositoryInterface::class,
            \App\Repositories\UserRepository::class
        );
    
        $this->app->bind(
            \App\Repositories\AnnonceRepositoryInterface::class,
            \App\Repositories\AnnonceRepository::class
        );

        
        $this->app->bind(
            \App\Repositories\CandidatureRepositoryInterface::class,
            \App\Repositories\CandidatureRepository::class
        );
    }
    

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
