<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\categorie_client;
use App\Models\categorie_clientFournisseur;
use App\Models\categorie_fournisseur;
use App\Models\categorie_prospects;
use App\Models\Prospect;
use App\Models\Fournisseur;
use App\Models\SousCategorie;
use App\Models\Client;
use App\Models\FournisseurClient;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nom_categorie',

    ];



    public function sousCategories(){
        return $this->hasMany(SousCategorie::class);
    }

    public function fournisseurs(){
        return $this->belongsToMany(
            Fournisseur::class,
            'categorie_fournisseurs',
            'categorie_id','fournisseur_id'
    );
    }

    public function categorieFournisseur () {
        return $this->hasMany(categorie_fournisseur::class, 'categorie_id');
    }

    public function prospects () {
        return $this->belongsToMany(Prospect::class,
        'categorie_prospects',
        'categorie_id',
        'prospect_id');
    }

    public function categorieProspects () {
        return $this->hasMany(categorie_prospects::class,
        'categorie_id');
    }

    public function clients () {
        return $this->belongsToMany(Client::class,
        'categorie_clients',
        'categorie_id',
        'client_id');
    }

    public function categorieClients () {
        return $this->hasMany(categorie_client::class,
        'categorie_id'
    );
    }

    public function clientFournisseurs () {
        return $this->belongsToMany(FournisseurClient::class,
        'categorie_client_fournisseurs',
        'categorie_id',
        'clientFournisseur_id');
    }

    public function categorieClientFournisseurs () {
        return $this->hasMany(categorie_clientFournisseur::class,
        'categorie_id');
    }




}
