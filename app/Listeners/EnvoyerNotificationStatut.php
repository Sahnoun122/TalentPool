<?php
namespace App\Listeners;

use App\Events\CandidatureStatutModifie;
use App\Notifications\StatutCandidatureModifie;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
class EnvoyerNotificationStatut
{
    public function handle(CandidatureStatutModifie $event)
    {
        $candidature = $event->candidature;
        $candidature->candidat->notify(new StatutCandidatureModifie($candidature));
    }
}
