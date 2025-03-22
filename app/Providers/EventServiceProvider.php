<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\CandidatureStatutModifie;
use App\Listeners\EnvoyerNotificationStatut;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Les écouteurs d'événements.
     *
     * @var array
     */
    protected $listen = [
        CandidatureStatutModifie::class => [
            EnvoyerNotificationStatut::class,
        ],
    ];

    /**
     * Enregistrer les événements et les écouteurs.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
