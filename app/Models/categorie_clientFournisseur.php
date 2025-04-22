<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categorie;
use App\Models\FournisseurClient;


class categorie_clientFournisseur extends Model
{
    use HasFactory;
    protected $fillable = [
        'categorie_id',
        'clientFournisseur_id',
    ];

    protected $table = "categorie_client_fournisseurs";

    public function categorie () {
        return $this->belongsTo(Categorie::class,'categorie_id');
    }

    public function clientFournisseur () {
        return $this->belongsTo(FournisseurClient::class,'clientFournisseur_id');
    }
}
