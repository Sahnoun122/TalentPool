<?php
use App\Events\CandidatureStatutModifie;
use App\Listeners\EnvoyerNotificationStatut;

protected $listen = [
    CandidatureStatutModifie::class => [
        EnvoyerNotificationStatut::class,
    ],
];