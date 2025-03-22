<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Annonce;
use App\Models\User;

class Candidatures extends Model
{
    protected $fillable = [
        'annonce_id', 'candidat_id', 'cv_path', 'lettre_motivation', 'statut'
    ];

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }

    public function candidat()
    {
        return $this->belongsTo(User::class);
    }
}