<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categorie;
use App\Models\Client;


class categorie_client extends Model
{
    use HasFactory;

    protected $fillable = [
        'categorie_id',
        'client_id',
    ];

    protected $table = "categorie_clients";

    public function categorie () {
        return $this->belongsTo(Categorie::class,'categorie_id');
    }

    public function client () {
        return $this->belongsTo(Client::class,'client_id');
    }
}
