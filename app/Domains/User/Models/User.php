<?php // app/Domains/User/Models/User.php

namespace App\Domains\User\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Domains\Url\Models\Url;

/**
 * Class User
 * @todo MustVerifyEmail is declared but there is no mail configuration, no verification routes beyond
 *     Auth::routes(['verify' => true]), and no queue worker to send emails.
 *     This will silently block all API access for unverified users.
 * Проблема остаётся частично. Для полноценной верификации нужно настроить Mail/Queue. Пока оставим интерфейс,
 *     но важно настроить очередь и отправку писем в прод-е.
 *
 * @package App\Domains\User\Models
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function urls(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Url::class);
    }
}