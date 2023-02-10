<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'lname',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function getName(int $id): string
    {
        return User::where('id', $id)->first()->name;
    }

    public static function getLastName(int $id): string
    {
        return User::where('id', $id)->first()->lname;
    }

    public function bankAccounts(): HasMany
    {
        return $this->hasMany(BankAccount::class, 'owner_id');
    }
}
