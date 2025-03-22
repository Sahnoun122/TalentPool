<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Annonce extends Model
{
    protected $fillable = [
        'titre', 'description', 'localisation', 'salaire', 'recruteur_id'
    ];

    public function recruteur()
    {
        return $this->belongsTo(User::class);
    }

    public function candidatures()
    {
        return $this->hasMany(User::class);
    }
}