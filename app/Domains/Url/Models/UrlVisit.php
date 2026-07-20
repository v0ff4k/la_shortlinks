<?php

declare(strict_types=1);

namespace App\Domains\Url\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $url_id
 * @property string $ip_address
 * @property \Carbon\Carbon $visited_at
 * @property-read Url $url
 */
class UrlVisit extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'url_id',
        'ip_address',
        'visited_at',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
    ];

    /** @return BelongsTo<Url, $this> */
    public function url(): BelongsTo
    {
        return $this->belongsTo(Url::class);
    }
}
