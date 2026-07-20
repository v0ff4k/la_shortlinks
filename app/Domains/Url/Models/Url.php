<?php

declare(strict_types=1);

namespace App\Domains\Url\Models;

use App\Domains\Url\Scopes\UserUrlScope;
use App\Domains\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string $original_url
 * @property string $short_code
 * @property string|null $custom_alias
 * @property \Carbon\Carbon|null $expires_at
 * @property int $visits_count
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, UrlVisit> $visits
 */
class Url extends Model
{
    /** @use HasFactory<\Database\Factories\UrlFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'original_url',
        'short_code',
        'custom_alias',
        'expires_at',
        'visits_count',
    ];

    protected $hidden = ['user_id'];

    protected $casts = [
        'expires_at'   => 'datetime',
        'visits_count' => 'integer',
    ];

    /** @return HasMany<UrlVisit, $this> */
    public function visits(): HasMany
    {
        return $this->hasMany(UrlVisit::class);
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && now()->gte($this->expires_at);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new UserUrlScope());
    }
}
