<?php

namespace App\Policies;

use App\Models\Annonce;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AnnoncePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Annonce $annonce): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user)
    {
        return $user->role === 'recruteur';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Annonce $annonce)
    {
        return $user->id === $annonce->recruteur_id; 
    }

    /**
     * Determine whether the user can delete the model.
     */

     public function delete($user, Annonce $annonce)
     {
         return $user->id === $annonce->recruteur_id;
     }
    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Annonce $annonce): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Annonce $annonce): bool
    {
        return false;
    }
}
