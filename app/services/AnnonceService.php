<?php

namespace App\Services;

use App\Repositories\AnnonceRepositoryInterface;

class AnnonceService
{
    protected $annonceRepository;

    public function __construct(AnnonceRepositoryInterface $annonceRepository)
    {
        $this->annonceRepository = $annonceRepository;
    }

    public function creerAnnonce(array $donnees)
    {
        return $this->annonceRepository->ajouterAnnonce($donnees);
    }

    public function recupererAnnonces()
    {
        return $this->annonceRepository->trouverToutes();
    }

    public function mettreAJourAnnonce(int $id, array $donnees)
    {
        return $this->annonceRepository->modifierAnnonce($id, $donnees);
    }

    public function supprimerAnnonce(int $id)
    {
        return $this->annonceRepository->supprimerAnnonce($id);
    }

    public function NombreAnnonces(int $recruteurId)
    {
        return $this->annonceRepository->compterRecruteur($recruteurId);
    }

}

