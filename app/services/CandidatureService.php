<?php 

namespace App\Services;

use App\Repositories\CandidatureRepository;
use App\Events\CandidatureStatutModifie;

class CandidatureService
{
    protected $candidatureRepository;

    public function __construct(CandidatureRepository $candidatureRepository)
    {
        $this->candidatureRepository = $candidatureRepository;
    }

    public function postuler(array $donnees)
    {
        return $this->candidatureRepository->AjouterCandidature($donnees);
    }

    public function retirerCandidature(int $id)
    {
        return $this->candidatureRepository->supprimerCandidature($id);
    }

    public function filtrerCandidatures(int $annonceId)
    {
        return $this->candidatureRepository->trouverParAnnonceId($annonceId);
    }

    public function mettreStatut(int $id, string $statut)
    {
        $candidature = $this->candidatureRepository->trouverParId($id);
        $candidature->statut = $statut;
        $candidature->save();

        event(new CandidatureStatutModifie($candidature));

        return $candidature;
    }

  public function NombreCandidatures()
  {
      return $this->candidatureRepository->compterRecruteur();
  }

  public function CandidaturesStatut()
  {
      return $this->candidatureRepository->repartirStatut();
  }

}

