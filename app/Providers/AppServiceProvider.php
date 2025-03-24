<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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


public function boot()
{
    $this->register();

    Gate::define('est-recruteur', function ($user) {
        return $user->role === 'recruteur';
    });
    Gate::define('est-admin', function ($user) {
        return $user->role === 'admin';
    });
}
}
