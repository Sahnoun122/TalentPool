<?php

namespace App\Repositories;

use App\Models\Annonce;
use App\Repositories\AnnonceRepositoryInterface;

class AnnonceRepository implements AnnonceRepositoryInterface
{
    public function trouverParId($id)
    {
        return Annonce::findOrFail($id);
    }

    public function trouverToutes()
    {
        return Annonce::all();
    }

    public function ajouterAnnonce( $donnees)
    {
        return Annonce::create($donnees);
    }

    public function modifierAnnonce( $id,$donnees)
    {
        $annonce = Annonce::findOrFail($id);
        $annonce->update($donnees);
        return $annonce;
    }

     public function supprimerAnnonce($id)
    {
        $annonce = Annonce::findOrFail($id);
        $annonce->delete();
    }

    public function compterRecruteur(int $recruteurId)
    {
        return Annonce::where('recruteur_id', $recruteurId)->count();
    }

    public function compterToute()
    {
        return Annonce::count();
    }
}
