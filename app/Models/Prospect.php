<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\categorie_prospects;
use App\Models\Categorie;
use App\Models\User;

class Prospect extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'nom_prospect',
        'email_prospect',
        'tele_prospect',
        'ville_prospect',
        'nomSociete_prospect',
        'GSM1_prospect',
        'GSM2_prospect',
        'lien_prospect',
        'user_id',
        'remark'
    ];

    public function categories()
    {
        return $this->belongsToMany(
            Categorie::class,
            'categorie_prospects',
            'prospect_id',
            'categorie_id'
        );
    }

    public function categorieProspects()
    {
        return $this->hasMany(
            categorie_prospects::class,
            'prospect_id'
        );
    }


    public function allCategories()
    {
        return Categorie::whereHas('prospects', function ($query) {
            $query->where('prospects.id', $this->id);
        })->get();
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
