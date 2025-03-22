<?php
namespace App\Repositories;

use App\Models\Candidature;
use App\Repositories\CandidatureRepositoryInterface;

class CandidatureRepository implements CandidatureRepositoryInterface
{
    public function trouverParId(int $id)
    {
        return Candidature::findOrFail($id);
    }

    public function trouverParAnnonceId(int $annonceId)
    {
        return Candidature::where('annonce_id', $annonceId)->get();
    }

    public function AjouterCandidature(array $donnees)
    {
        return Candidature::create($donnees);
    }

    public function supprimerCandidature(int $id)
    {
        $candidature = Candidature::findOrFail($id);
        $candidature->delete();
    }
}
