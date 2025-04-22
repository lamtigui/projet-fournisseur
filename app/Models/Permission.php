<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'user_id', 'can_see_prospects', 'can_see_clients', 'can_see_fournisseurs', 'can_see_fournisseurs_clients'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

