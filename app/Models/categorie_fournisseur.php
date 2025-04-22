<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categorie;
use App\Models\Fournisseur;

class categorie_fournisseur extends Model
{
    use HasFactory;

    protected $fillable = [
        'categorie_id',
        'fournisseur_id',
    ];
    protected $table = "categorie_fournisseurs";

    public function categorie()
    {
        return $this->belongsTo(Categorie::class,'categorie_id');
    }

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class,'fournisseur_id');
    }
}
