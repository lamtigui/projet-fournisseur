<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Categorie;
use App\Models\SousCategorieUser;
use App\Models\User;

class SousCategorie extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_produit',
        'texte',
        'categorie_id'
    ];

    public function categorie(){
        return $this->belongsTo(Categorie::class,'categorie_id');
    }



   
}
