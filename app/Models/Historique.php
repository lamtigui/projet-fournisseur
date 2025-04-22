<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Historique extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'login_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Empêcher les doublons avant l'insertion
    public static function boot()
    {
        parent::boot();

        static::creating(function ($historique) {
            $lastLogin = self::where('user_id', $historique->user_id)
                ->orderBy('login_at', 'desc')
                ->first();
        
            if ($lastLogin) {
                $timeDifference = $historique->login_at->diffInSeconds($lastLogin->login_at);
        
                if ($timeDifference < 2) {
                    return false; // Prevent creation if the difference is less than 2 seconds
                }
            }
        });
        
    }
}
