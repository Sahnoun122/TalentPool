<?php 

namespace App\Repositories;

interface CandidatureRepositoryInterface
{
    public function trouverParId( $id);
    public function trouverParAnnonceId( $annonceId);
    public function AjouterCandidature( $donnees);
    public function supprimerCandidature( $id);
}