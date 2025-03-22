<?php 

namespace App\Repositories;

interface CandidatureRepositoryInterface
{
    public function trouverParId(int $id);
    public function trouverParAnnonceId(int $annonceId);
    public function AjouterCandidature(array $donnees);
    public function supprimerCandidature(int $id);
}