<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Annonce;
use App\Policies\AnnoncePolicy;

class AppServiceProvider extends ServiceProvider
{
 
    protected $policies = [
        Annonce::class => AnnoncePolicy::class,
    ];

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

    Gate::define('recruteur', function ($user) {
        return $user->role === 'recruteur';
    });
    Gate::define('admin', function ($user) {
        return $user->role === 'admin';
    });
}
}
