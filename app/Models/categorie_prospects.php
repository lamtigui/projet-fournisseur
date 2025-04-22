<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categorie;
use App\Models\Prospect;

class categorie_prospects extends Model
{
    use HasFactory;

    protected $fillable = [
        'categorie_id',
        'prospect_id',
    ];

    protected $table = "categorie_prospects";

    public function categorie () {
        return $this->belongsTo(Categorie::class,'categorie_id');
    }

    public function prospect () {
        return $this->belongsTo(Prospect::class,'prospect_id');
    }
}
