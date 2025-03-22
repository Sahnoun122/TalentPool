<?php
namespace App\Repositories;

use App\Models\Candidatures;
use App\Repositories\CandidatureRepositoryInterface;

class CandidatureRepository implements CandidatureRepositoryInterface
{
    public function trouverParId( $id)
    {
        return Candidatures::findOrFail($id);
    }

    public function trouverParAnnonceId( $annonceId)
    {
        return Candidatures::where('annonce_id', $annonceId)->get();
    }

    public function AjouterCandidature( $donnees)
    {
        return Candidatures::create($donnees);
    }

    public function supprimerCandidature($id)
    {
        $candidature = Candidatures::findOrFail($id);
        $candidature->delete();
    }

    public function compterRecruteur( $recruteurId)
    {
        return Candidatures::whereHas('annonce', function ($query) use ($recruteurId) {
            $query->where('recruteur_id', $recruteurId);
        })->count();
    }

    public function repartirStatut( $recruteurId)
    {
        return Candidatures::whereHas('annonce', function ($query) use ($recruteurId) {
            $query->where('recruteur_id', $recruteurId);
        })
        ->select('statut')
        ->selectRaw('count(*) as total')
        ->groupBy('statut')
        ->get();
    }
}
