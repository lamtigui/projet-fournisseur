<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categorie;
use App\Models\categorie_fournisseur;


class Fournisseur extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'nom_fournisseur',
        'email_fournisseur',
        'tele_fournisseur',
        'ville_fournisseur',
        'nomSociete_fournisseur',
        'GSM1_fournisseur',
        'GSM2_fournisseur',
        'lien_fournisseur',
        'user_id',
        'remark'
    ];


    public function categories(){
        return $this->belongsToMany(Categorie::class,'categorie_fournisseurs','fournisseur_id','categorie_id');
    }

    public function categorieFournisseur () {
        return $this->hasMany(categorie_fournisseur::class, 'fournisseur_id');
    }

    public function allCategories()
    {
        return Categorie::whereHas('fournisseurs', function ($query) {
            $query->where('fournisseurs.id', $this->id);
            })->get();
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class,'user_id');
    }







}
