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

      public function compterRecruteur( )
      {
          return Candidatures::whereHas('annonce', function ($query){
              $query->where('recruteur_id');
          })->count();
      }
  
      public function repartirStatut()
      {
          return Candidatures::whereHas('annonce', function ($query) {
              $query->where('recruteur_id');
          })
          ->select('statut')
          ->selectRaw('count(*) as total')
          ->groupBy('statut')
          ->get();
      }
  

}
