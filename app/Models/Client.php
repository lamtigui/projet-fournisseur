<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categorie;
use App\Models\User;
use App\Models\categorie_client;


class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nom_client',
        'email_client',
        'tele_client',
        'ville_client',
        'nomSociete_client',
        'GSM1_client',
        'GSM2_client',
        'lien_client',
        'user_id',
        'remark'
    ];


    public function categories () {
        return $this->belongsToMany(Categorie::class,
        'categorie_clients',
        'client_id',
        'categorie_id');
    }

    public function categorieClients () {
        return $this->hasMany(categorie_client::class,
        'client_id');
    }

    public function allCategories()
    {
        return Categorie::whereHas('clients', function ($query) {
            $query->where('clients.id', $this->id);
            })->get();
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
