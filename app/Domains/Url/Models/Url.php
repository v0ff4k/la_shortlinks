<?php

declare(strict_types=1);

namespace App\Domains\Url\Models;

use App\Domains\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Url extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'original_url', 'short_code', 'custom_alias', 'expires_at'];

    protected $hidden = ['user_id'];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function visits(): HasMany
    {
        return $this->hasMany(UrlVisit::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at && now()->gte($this->expires_at);
    }
}
