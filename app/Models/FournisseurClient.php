<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categorie;
use App\Models\User;
use App\Models\categorie_clientFournisseur;


class FournisseurClient extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nom_clientFournisseur',
        'email_clientFournisseur',
        'tele_clientFournisseur',
        'ville_clientFournisseur',
        'nomSociete_clientFournisseur',
        'GSM1_clientFournisseur',
        'GSM2_clientFournisseur',
        'lien_clientFournisseur',
        'user_id',
        'remark'
    ];

    public function categories () {
        return $this->belongsToMany(Categorie::class,
        'categorie_client_fournisseurs',
        'clientFournisseur_id',
        'categorie_id');
    }

    public function categorieClientFournisseurs () {
        return $this->hasMany(categorie_clientFournisseur::class,
        'clientFournisseur_id');
    }

    public function allCategories()
    {
        return Categorie::whereHas('clientFournisseurs', function ($query) {
            $query->where('fournisseur_clients.id', $this->id);
            })->get();
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
