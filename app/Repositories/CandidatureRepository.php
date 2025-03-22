<?php
namespace App\Repositories;

use App\Models\Candidatures;
use App\Repositories\CandidatureRepositoryInterface;

class CandidatureRepository implements CandidatureRepositoryInterface
{
    public function trouverParId(int $id)
    {
        return Candidatures::findOrFail($id);
    }

    public function trouverParAnnonceId(int $annonceId)
    {
        return Candidatures::where('annonce_id', $annonceId)->get();
    }

    public function AjouterCandidature(array $donnees)
    {
        return Candidatures::create($donnees);
    }

    public function supprimerCandidature(int $id)
    {
        $candidature = Candidatures::findOrFail($id);
        $candidature->delete();
    }
}
