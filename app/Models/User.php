<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Fournisseur;
use App\Models\Prospect;
use App\Models\Client;
use App\Models\Historique;
use App\Models\FournisseurClient;
use App\Models\SousCategorieUser;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'contact',
        'adresse',
        'role',
        'email',
        'password',
        'email_verified_at',
        'remember_token',
    ];    

    public function fournisseurs()
    {
        return $this->hasMany(Fournisseur::class);
    }

    public function prospects()
    {
        return $this->hasMany(Prospect::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function fournisseurClients()
    {
        return $this->hasMany(FournisseurClient::class);
    }

    public function historiques()
    {
        return $this->hasMany(Historique::class);
    }
    public function permission()
{
    return $this->hasOne(Permission::class);
}

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
