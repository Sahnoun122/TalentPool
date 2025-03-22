<?php 

namespace App\Services;

use App\Repositories\CandidatureRepositoryInterface;

class CandidatureService
{
    protected $candidatureRepository;

    public function __construct(CandidatureRepositoryInterface $candidatureRepository)
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
}

