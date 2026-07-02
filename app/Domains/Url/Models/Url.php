<?php

namespace App\Domains\Url\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Url extends Model
{
    protected $fillable = [
        'user_id', 'original_url', 'short_code', 'custom_alias', 'expires_at'
    ];
    protected $hidden = ['user_id'];
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function visits(): HasMany { return $this->hasMany(UrlVisit::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }

    // Вспомогательный метод для проверки истечения
    public function isExpired(): bool
    {
        return $this->expires_at && now()->gte($this->expires_at);
    }
}