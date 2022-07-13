<?php

namespace App\Models;

use App\Notifications\SendEmailVerificationNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
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

    public function orders(): Relation
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new SendEmailVerificationNotification());
    }

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }
}
