<?php

namespace App\Domains\Analytics\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\Url\Models\Url;

class UrlVisit extends Model
{
    protected $fillable = ['url_id', 'ip_address', 'visited_at'];
    protected $casts = ['visited_at' => 'datetime'];

    public function url(): BelongsTo
    {
        return $this->belongsTo(Url::class);
    }
}
