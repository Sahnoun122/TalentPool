<?php
namespace App\Events;

use App\Models\Candidatures;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CandidatureStatutModifie
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $candidature;

    public function __construct(Candidatures $candidature)
    {
        $this->candidature = $candidature;
    }
}