<?php

namespace App\Repositories;

interface AnnonceRepositoryInterface
{
    public function trouverParId( $id);
    public function trouverToutes();
    public function ajouterAnnonce( $donnees);
    public function modifierAnnonce( $id, $donnees);
    public function supprimerAnnonce($id);
}